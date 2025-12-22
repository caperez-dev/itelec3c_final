<?php
namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\VoteCount;
use App\Models\Voter;
use App\Models\Position;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class VoteController extends Controller
{
    /**
     * Show the candidates page (read-only view)
     */
    public function showCandidatesPage()
    {
        // Check if voter is logged in via session
        if (!Session::has('voter_id')) {
            return redirect()->route('voter.login')->with('error', 'Please login first');
        }

        // Get all active positions with their candidates
        $positions = Position::whereNull('deleted_at')
            ->with(['candidates' => function($query) {
                $query->whereRaw('LOWER(status) = ?', ['active'])->whereNull('deleted_at');
            }])
            ->get();

        return view('voter-candidates', compact('positions'));
    }

    /**
     * Show the voting page with candidates
     */
    public function showVotingPage()
    {
        // Check if voter is logged in via session
        if (!Session::has('voter_id')) {
            return redirect()->route('voter.login')->with('error', 'Please login first');
        }

        // Get all active positions with their candidates
        $positions = Position::whereNull('deleted_at')
            ->with(['candidates' => function($query) {
                $query->whereRaw('LOWER(status) = ?', ['active'])->whereNull('deleted_at');
            }])
            ->get();

        return view('voter-voting', compact('positions'));
    }

    /**
     * Submit voter's votes
     */
    public function submitVote(Request $request)
    {
        // Check if voter is logged in
        if (!Session::has('voter_id')) {
            return redirect()->route('voter.login')->with('error', 'Please login first');
        }

        $voterId = Session::get('voter_id');

        // Get all positions to validate votes
        $positions = Position::whereNull('deleted_at')->get();

        // Get votes array from request
        $votes = $request->input('votes', []);

        // Validate that at least one vote was made (not abstain and not empty)
        $hasVote = false;
        foreach ($votes as $positionId => $candidateId) {
            if (!empty($candidateId) && $candidateId !== 'abstain') {
                $hasVote = true;
                break;
            }
        }

        if (!$hasVote) {
            return back()->withErrors(['vote' => 'You must select at least one candidate to vote for.']);
        }

        // Check if voter has already voted
        $voter = Voter::find($voterId);
        if ($voter->has_voted) {
            Session::flush();
            return redirect()->route('voter.login')->with('error', 'You have already voted.');
        }

        // Process votes
        foreach ($votes as $positionId => $candidateId) {
            // Skip empty votes or abstain selections
            if (empty($candidateId) || $candidateId === 'abstain') {
                continue;
            }

            // Validate position exists
            $position = Position::find($positionId);
            if (!$position || $position->deleted_at != null) {
                return back()->withErrors(['vote' => 'Invalid position selected.']);
            }

            // Validate candidate exists and belongs to this position
            $candidate = Candidate::find($candidateId);
            if (!$candidate || $candidate->position_id != $positionId || $candidate->status != 'Active') {
                return back()->withErrors(['vote' => 'Invalid candidate selection.']);
            }

            // Create vote record
            Vote::create([
                'voter_id' => $voterId,
                'candidate_id' => $candidateId,
            ]);

            // Update or create vote count
            $voteCount = VoteCount::where('candidate_id', $candidateId)->first();
            if ($voteCount) {
                $voteCount->increment('vote_count');
            } else {
                VoteCount::create([
                    'candidate_id' => $candidateId,
                    'vote_count' => 1,
                ]);
            }
        }

        // Mark voter as voted
        $voter->update(['has_voted' => true]);

        // Redirect to results page with success message
        return redirect()->route('voter.results')->with('success', 'Your vote has been submitted successfully!');
    }

    /**
     * Show results page
     */
    public function showResults()
    {
        // Get all positions with their candidates and each candidate's vote count
        $positions = Position::whereNull('deleted_at')
            ->with(['candidates' => function($query) {
                $query->where('status', 'Active')
                      ->whereNull('deleted_at')
                      ->with('voteCount'); // Load vote count for each candidate
            }])
            ->get();

        // Calculate statistics
        $totalVoters = Voter::whereNull('deleted_at')->count();
        $votedCount = Voter::where('has_voted', true)->whereNull('deleted_at')->count();
        $totalVotes = Vote::count(); // Total number of votes cast
        $turnoutPercentage = $totalVoters > 0 ? round(($votedCount / $totalVoters) * 100, 1) : 0;

        // Get voter's votes if logged in
        $myVotes = collect();
        if (Session::has('voter_id')) {
            $myVotes = Vote::where('voter_id', Session::get('voter_id'))
                ->with(['candidate.position'])
                ->get();
        }

        // Clear voter session after showing results
        // Note: Session will persist until they navigate away or click logout

        return view('voter-results', compact('positions', 'totalVoters', 'votedCount', 'totalVotes', 'turnoutPercentage', 'myVotes'));
    }

    // Votes Table
    public function DisplayVotes(Request $request)
    {
        $search = $request->input('search');
        $applied_from = $request->input('applied_from');
        $applied_to = $request->input('applied_to');

        // Base query joining voters and candidates
        $query = Vote::join('voters', 'votes.voter_id', '=', 'voters.voter_id')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.candidate_id')
            ->select('votes.*', 'voters.first_name', 'voters.last_name', 'candidates.candidate_name');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('voters.last_name', 'like', "%$search%")
                  ->orWhere('voters.first_name', 'like', "%$search%")
                  ->orWhere('votes.vote_id', 'like', "%$search%");
            });
        }

        if ($applied_from && $applied_to) {
            $from = $applied_from . ' 00:00:00';
            $to = $applied_to . ' 23:59:59';
            $query->whereBetween('votes.created_at', [$from, $to]);
        } else if ($applied_from) {
            $query->where('votes.created_at', '>=', $applied_from . ' 00:00:00');
        } else if ($applied_to) {
            $query->where('votes.created_at', '<=', $applied_to . ' 23:59:59');
        }

        // Sorting
        $sort_by = $request->input('sort_by');
        $sort_dir = strtolower($request->input('sort_dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        $allowed = ['vote_id', 'last_name', 'first_name', 'candidate_name', 'created_at'];
        if (!in_array($sort_by, $allowed)) {
            $sort_by = null;
        }

        if ($sort_by) {
            switch ($sort_by) {
                case 'last_name':
                    $query->orderBy('voters.last_name', $sort_dir)->orderBy('voters.first_name', $sort_dir);
                    break;
                case 'first_name':
                    $query->orderBy('voters.first_name', $sort_dir)->orderBy('voters.last_name', $sort_dir);
                    break;
                case 'candidate_name':
                    $query->orderBy('candidates.candidate_name', $sort_dir);
                    break;
                case 'created_at':
                    $query->orderBy('votes.created_at', $sort_dir);
                    break;
                default:
                    $query->orderBy('votes.vote_id', $sort_dir);
                    break;
            }
        }

        $votes = $query->paginate(10)
            ->appends($request->only(['search','applied_from','applied_to','sort_by','sort_dir']));

        return view('VotesDisplay', compact('votes', 'sort_by', 'sort_dir'));
    }
    
    // Vote Counts Table
    public function VoteCountsDisplay(Request $request)
    {
        $search = $request->input('search');

        // Get active positions (ordered by position_id as requested)
        $positions = Position::whereNull('deleted_at')
            ->orderBy('position_id')
            ->get();

        // For each position, collect its candidates and their vote counts (0 if none), ordered by vote_count desc
        foreach ($positions as $pos) {
            $candidates = DB::table('candidates')
                ->leftJoin('vote_counts', 'candidates.candidate_id', '=', 'vote_counts.candidate_id')
                ->where('candidates.position_id', $pos->position_id)
                ->whereNull('candidates.deleted_at')
                ->select('candidates.candidate_id', 'candidates.candidate_name', DB::raw('COALESCE(vote_counts.vote_count, 0) as vote_count'))
                ->orderByDesc('vote_count')
                ->get();

            // If search provided, filter candidates by name
            if ($search) {
                $candidates = $candidates->filter(function($c) use ($search) {
                    return stripos($c->candidate_name, $search) !== false || stripos($c->candidate_id, $search) !== false;
                })->values();
            }

            $pos->rankedCandidates = $candidates;
        }

        return view('VoteCountsDisplay', compact('positions'));
    }

    /**
     * Export votes to PDF with filters and sorting
     */
    public function exportPDF(Request $request)
    {
        $search = $request->input('search');
        $applied_from = $request->input('applied_from');
        $applied_to = $request->input('applied_to');
        
        // Base query joining voters and candidates
        $query = Vote::join('voters', 'votes.voter_id', '=', 'voters.voter_id')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.candidate_id')
            ->select('votes.*', 'voters.first_name', 'voters.last_name', 'candidates.candidate_name');
        
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('voters.last_name', 'like', "%$search%")
                ->orWhere('voters.first_name', 'like', "%$search%")
                ->orWhere('votes.vote_id', 'like', "%$search%");
            });
        }
        
        // Apply date range filters
        if ($applied_from && $applied_to) {
            $from = $applied_from . ' 00:00:00';
            $to = $applied_to . ' 23:59:59';
            $query->whereBetween('votes.created_at', [$from, $to]);
        } else if ($applied_from) {
            $query->where('votes.created_at', '>=', $applied_from . ' 00:00:00');
        } else if ($applied_to) {
            $query->where('votes.created_at', '<=', $applied_to . ' 23:59:59');
        }
        
        // Apply sorting
        $sort_by = $request->input('sort_by');
        $sort_dir = strtolower($request->input('sort_dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $allowed = ['vote_id', 'last_name', 'first_name', 'candidate_name', 'created_at'];
        
        if (!in_array($sort_by, $allowed)) {
            $sort_by = null;
        }
        
        if ($sort_by) {
            switch ($sort_by) {
                case 'last_name':
                    $query->orderBy('voters.last_name', $sort_dir)->orderBy('voters.first_name', $sort_dir);
                    break;
                case 'first_name':
                    $query->orderBy('voters.first_name', $sort_dir)->orderBy('voters.last_name', $sort_dir);
                    break;
                case 'candidate_name':
                    $query->orderBy('candidates.candidate_name', $sort_dir);
                    break;
                case 'created_at':
                    $query->orderBy('votes.created_at', $sort_dir);
                    break;
                default:
                    $query->orderBy('votes.vote_id', $sort_dir);
                    break;
            }
        }
        
        // Get all votes (no pagination for PDF)
        $votes = $query->get();
        
        // Prepare filter information for display
        $filters = [
            'search' => $search,
            'applied_from' => $applied_from,
            'applied_to' => $applied_to,
            'sort_by' => $sort_by,
            'sort_dir' => $sort_dir
        ];
        
        // Generate PDF
        $pdf = Pdf::loadView('votes-pdf', compact('votes', 'filters'));
        
        // Set paper size and orientation
        $pdf->setPaper('a4', 'landscape');
        
        // Generate filename with timestamp
        $filename = 'votes_list_' . date('Y-m-d_His') . '.pdf';
        
        // Download PDF
        return $pdf->download($filename);
    }

    /**
     * Export vote counts to PDF with filters
     */
    public function exportVoteCountsPDF(Request $request)
    {
        $search = $request->input('search');
        
        // Get active positions (ordered by position_id)
        $positions = Position::whereNull('deleted_at')
            ->orderBy('position_id')
            ->get();
        
        // For each position, collect its candidates and their vote counts, ordered by vote_count desc
        foreach ($positions as $pos) {
            $candidates = DB::table('candidates')
                ->leftJoin('vote_counts', 'candidates.candidate_id', '=', 'vote_counts.candidate_id')
                ->where('candidates.position_id', $pos->position_id)
                ->whereNull('candidates.deleted_at')
                ->select('candidates.candidate_id', 'candidates.candidate_name', DB::raw('COALESCE(vote_counts.vote_count, 0) as vote_count'))
                ->orderByDesc('vote_count')
                ->get();
            
            // If search provided, filter candidates by name
            if ($search) {
                $candidates = $candidates->filter(function($c) use ($search) {
                    return stripos($c->candidate_name, $search) !== false || stripos($c->candidate_id, $search) !== false;
                })->values();
            }
            
            $pos->rankedCandidates = $candidates;
        }
        
        // Prepare filter information for display
        $filters = [
            'search' => $search
        ];
        
        // Generate PDF
        $pdf = Pdf::loadView('vote-counts-pdf', compact('positions', 'filters'));
        
        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');
        
        // Generate filename with timestamp
        $filename = 'vote_counts_report_' . date('Y-m-d_His') . '.pdf';
        
        // Download PDF
        return $pdf->download($filename);
    }
}
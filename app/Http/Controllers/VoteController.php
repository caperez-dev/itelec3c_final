<?php
namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\VoteCount;
use App\Models\Voter;
use App\Models\Position;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

        // Clear voter session after showing results
        // Note: Session will persist until they navigate away or click logout

        return view('voter-results', compact('positions', 'totalVoters', 'votedCount', 'totalVotes', 'turnoutPercentage'));
    }

    // Votes Table
    public function DisplayVotes(Request $request)
    {
        $search = $request->input('search');
        
        if ($search) {
            $votes = Vote::join('voters', 'votes.voter_id', '=', 'voters.voter_id')
                ->join('candidates', 'votes.candidate_id', '=', 'candidates.candidate_id')
                ->where(function($query) use ($search) {
                    $query->where('voters.last_name', 'like', "%$search%")
                        ->orWhere('voters.first_name', 'like', "%$search%")
                        ->orWhere('votes.vote_id', 'like', "%$search%");
                })
                ->select('votes.*', 'voters.first_name', 'voters.last_name', 'candidates.candidate_name')
                ->paginate(10)
                ->appends(['search' => $search]);
        } else {
            $votes = Vote::join('voters', 'votes.voter_id', '=', 'voters.voter_id')
                ->join('candidates', 'votes.candidate_id', '=', 'candidates.candidate_id')
                ->select('votes.*', 'voters.first_name', 'voters.last_name', 'candidates.candidate_name')
                ->paginate(10);
        }
        
        return view('VotesDisplay', compact('votes'));
    }
    
    // Vote Counts Table
    public function VoteCountsDisplay(Request $request)
    {
        $search = $request->input('search');
        
        if ($search) {
            $votecounts = VoteCount::join('candidates', 'vote_counts.candidate_id', '=', 'candidates.candidate_id')
                ->where('vote_count_id', 'LIKE', "%$search%")
                ->orWhere('candidates.candidate_name', 'LIKE', "%$search%")
                ->orWhere('vote_count', 'LIKE', "%$search%")
                ->select('vote_counts.*', 'candidates.candidate_name')
                ->get();
        } else {
            $votecounts = VoteCount::join('candidates', 'vote_counts.candidate_id', '=', 'candidates.candidate_id')
                ->select('vote_counts.*', 'candidates.candidate_name')
                ->get();
        }
        
        return view('VoteCountsDisplay', compact('votecounts'));
    }
}
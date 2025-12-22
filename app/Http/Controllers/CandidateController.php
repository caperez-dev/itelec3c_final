<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Position;
use App\Models\VoteCount;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CandidateController extends Controller
{
    /**
     * Display a listing of candidates with optional search and pagination
     */
    public function index(Request $request)
    {
        // Get current election status
        $election = Election::find(1);
        $electionStatus = $election ? $election->status : 'pending';
        // Load filter inputs
        $search = $request->input('search');
        $status = $request->input('status');
        $position_id = $request->input('position_id');
        $party_affiliation = $request->input('party_affiliation');
        $applied_from = $request->input('applied_from');
        $applied_to = $request->input('applied_to');

        // Base query joining positions so we can show position_name
        $query = Candidate::join('positions', 'candidates.position_id', '=', 'positions.position_id')
            ->select('candidates.*', 'positions.position_name');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('candidates.candidate_id', 'LIKE', "%$search%")
                  ->orWhere('candidates.candidate_name', 'LIKE', "%$search%")
                  ->orWhere('candidates.party_affiliation', 'LIKE', "%$search%")
                  ->orWhere('positions.position_name', 'LIKE', "%$search%");
            });
        }

        if ($status) {
            $query->where('candidates.status', $status);
        }

        if ($position_id) {
            $query->where('candidates.position_id', $position_id);
        }

        if ($party_affiliation) {
            $query->where('candidates.party_affiliation', 'LIKE', "%$party_affiliation%");
        }

        if ($applied_from && $applied_to) {
            $from = $applied_from . ' 00:00:00';
            $to = $applied_to . ' 23:59:59';
            $query->whereBetween('candidates.created_at', [$from, $to]);
        } else if ($applied_from) {
            $query->where('candidates.created_at', '>=', $applied_from . ' 00:00:00');
        } else if ($applied_to) {
            $query->where('candidates.created_at', '<=', $applied_to . ' 23:59:59');
        }

        // Sorting
        $sort_by = $request->input('sort_by');
        $sort_dir = strtolower($request->input('sort_dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        $allowedSorts = ['candidate_id', 'candidate_name', 'party_affiliation', 'position_name', 'status', 'created_at'];
        if (!in_array($sort_by, $allowedSorts)) {
            $sort_by = null; // leave null to use default DB ordering
        }

        if ($sort_by) {
            if ($sort_by === 'position_name') {
                $query->orderBy('positions.position_name', $sort_dir);
            } else {
                $query->orderBy('candidates.' . $sort_by, $sort_dir);
            }
        }

        $candidates = $query->paginate(10)
            ->appends($request->only(['search','status','position_id','party_affiliation','applied_from','applied_to','sort_by','sort_dir']));

        // Provide positions list for the filter select
        $positions = \App\Models\Position::whereNull('deleted_at')->orderBy('position_name')->get();

        // Provide distinct party affiliations for the filter dropdown
        $partyAffiliations = Candidate::whereNull('deleted_at')
            ->whereNotNull('party_affiliation')
            ->where('party_affiliation', '<>', '')
            ->select('party_affiliation')
            ->distinct()
            ->orderBy('party_affiliation')
            ->pluck('party_affiliation');

        return view('CandidatesDisplay', compact('candidates', 'electionStatus', 'positions', 'partyAffiliations', 'sort_by', 'sort_dir'));
    }

    /**
     * Show the form for creating a new candidate
     */
    public function create()
    {
        // Check election status before allowing create
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.candidates')
                ->with('error', 'Cannot add candidates. Election is not in Pending status.');
        }
        
        $positions = Position::whereNull('deleted_at')
            ->orderBy('position_name')
            ->get();
        
        return view('create-candidate', compact('positions'));
    }

    /**
     * Store a newly created candidate in the database
     */
    public function store(Request $request)
    {
        // Check election status before allowing store
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.candidates')
                ->with('error', 'Cannot add candidates. Election is not in Pending status.');
        }

        $request->merge([
            'candidate_name' => trim($request->candidate_name),
            'party_affiliation' => trim($request->party_affiliation),
        ]);
        
        $validated = $request->validate([
            'candidate_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s\.\-]+$/', // Only letters, spaces, dots, hyphens
                Rule::unique('candidates')->where(function ($query) use ($request) {
                    return $query->where('position_id', $request->position_id);
                }),
            ],
            'party_affiliation' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\&]+$/', // Alphanumeric with spaces, hyphens, ampersand
            ],
            'position_id' => [
                'required',
                'exists:positions,position_id',
                function ($attribute, $value, $fail) {
                    // Check if position exists and is not deleted
                    $position = Position::where('position_id', $value)
                        ->whereNull('deleted_at')
                        ->first();
                    
                    if (!$position) {
                        $fail('The selected position is invalid.');
                    }
                }
            ],
            'imagepath' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000', // Optional size limits
            ]
        ], [
            'candidate_name.regex' => 'Candidate name may only contain letters, spaces, dots, and hyphens.',
            'candidate_name.unique' => 'A candidate with this name already exists for this position.',
            'party_affiliation.regex' => 'Party affiliation may only contain letters, numbers, spaces, hyphens, and ampersand.',
            'imagepath.dimensions' => 'Image must be between 100x100 and 2000x2000 pixels.',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('imagepath')) {
            $imagePath = $request->file('imagepath')->store('candidates', 'public');
        }

        // Create candidate
        $candidate = Candidate::create([
            'candidate_name' => $validated['candidate_name'],
            'party_affiliation' => $validated['party_affiliation'],
            'imagepath' => $imagePath,
            'position_id' => $validated['position_id'],
            'status' => 'Active'
        ]);

        // Initialize vote count for this candidate
        VoteCount::create([
            'candidate_id' => $candidate->candidate_id,
            'vote_count' => 0,
        ]);

        return redirect()->route('register.candidate')
            ->with('success', 'Candidate registered successfully!');
    }

    /**
     * Show the form for editing the specified candidate
     */
    public function edit($id)
    {
        // Check election status before allowing edit
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.candidates')
                ->with('error', 'Cannot edit candidates. Election is not in Pending status.');
        }
        
        $candidate = Candidate::findOrFail($id);
        $positions = Position::whereNull('deleted_at')
            ->orderBy('position_name')
            ->get();
        
        return view('edit-candidate', compact('candidate', 'positions'));
    }

    /**
     * Update the specified candidate in the database
     */
    public function update(Request $request, $id)
    {
        // Check election status before allowing update
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.candidates')
                ->with('error', 'Cannot update candidates. Election is not in Pending status.');
        }
        
        $candidate = Candidate::findOrFail($id);
        
        $validated = $request->validate([
            'candidate_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s\.\-]+$/',
                Rule::unique('candidates')->where(function ($query) use ($request) {
                    return $query->where('position_id', $request->position_id);
                })->ignore($candidate->candidate_id, 'candidate_id'),
            ],
            'party_affiliation' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\&]+$/',
            ],
            'position_id' => [
                'required',
                'exists:positions,position_id',
                function ($attribute, $value, $fail) {
                    $position = Position::where('position_id', $value)
                        ->whereNull('deleted_at')
                        ->first();
                    
                    if (!$position) {
                        $fail('The selected position is invalid.');
                    }
                }
            ], [
                'candidate_name.regex' => 'Candidate name may only contain letters, spaces, dots, and hyphens.',
                'candidate_name.unique' => 'A candidate with this name already exists for this position.',
                'party_affiliation.regex' => 'Party affiliation may only contain letters, numbers, spaces, hyphens, and ampersand.',
            ],
        ]);

        $candidate->update([
            'candidate_name' => $validated['candidate_name'],
            'party_affiliation' => $validated['party_affiliation'],
            'position_id' => $validated['position_id']
        ]);

        return redirect()->route('display.candidates')
            ->with('success', 'Candidate updated successfully!');
    }

    /**
     * Soft delete the specified candidate
     */
    public function destroy($id)
    {
        // Check election status before allowing delete
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.candidates')
                ->with('error', 'Cannot delete candidates. Election is not in Pending status.');
        }
        
        $candidate = Candidate::findOrFail($id);
        $candidate->delete(); // Soft delete
        
        return redirect()->route('display.candidates')
            ->with('success', 'Candidate deleted successfully!');
    }

    /**
     * Display archived (soft deleted) candidates
     */
    public function ArchivedCandidatesDisplay(Request $request)
    {
        // Get current election status
        $election = Election::find(1);
        $electionStatus = $election ? $election->status : 'pending';
        
        $search = $request->input('search');
        
        if ($search) {
            $candidates = Candidate::onlyTrashed()
                ->join('positions', 'candidates.position_id', '=', 'positions.position_id')
                ->where('candidate_id', 'LIKE', "%$search%")
                ->orWhere('candidate_name', 'LIKE', "%$search%")
                ->orWhere('party_affiliation', 'LIKE', "%$search%")
                ->orWhere('positions.position_name', 'LIKE', "%$search%")
                ->select('candidates.*', 'positions.position_name')
                ->get();
        } else {
            $candidates = Candidate::onlyTrashed()
                ->join('positions', 'candidates.position_id', '=', 'positions.position_id')
                ->select('candidates.*', 'positions.position_name')
                ->get();
        }
        
        return view('ArchivedCandidatesDisplay', compact('candidates', 'electionStatus'));
    }

    /**
     * Restore a soft deleted candidate
     */
    public function restore($id)
    {
        // Check election status before allowing restore
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.archived.candidates')
                ->with('error', 'Cannot restore candidates. Election is not in Pending status.');
        }
        
        $candidate = Candidate::onlyTrashed()->findOrFail($id);
        $candidate->restore();
        
        return redirect()->route('display.archived.candidates')
            ->with('success', 'Candidate restored successfully!');
    }

    /**
     * Permanently delete the specified candidate from the database
     */
    public function forceDelete($id)
    {
        // Check election status before allowing force delete
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.archived.candidates')
                ->with('error', 'Cannot permanently delete candidates. Election is not in Pending status.');
        }
        
        $candidate = Candidate::onlyTrashed()->findOrFail($id);
        $candidate->forceDelete(); // Permanent delete
        
        return redirect()->route('display.archived.candidates')
            ->with('success', 'Candidate permanently deleted!');
    }

    /**
     * Disable the specified candidate
     */
    public function disable($id)
    {
        // Check election status before allowing disable
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.candidates')
                ->with('error', 'Cannot disable candidates. Election is not in Pending status.');
        }
        
        $candidate = Candidate::findOrFail($id);
        $candidate->update(['status' => 'Disabled']);
        
        return redirect()->route('display.candidates')
            ->with('success', 'Candidate disabled successfully!');
    }

    /**
     * Enable the specified candidate
     */
    public function enable($id)
    {
        // Check election status before allowing enable
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.candidates')
                ->with('error', 'Cannot enable candidates. Election is not in Pending status.');
        }
        
        $candidate = Candidate::findOrFail($id);
        $candidate->update(['status' => 'Active']);
        
        return redirect()->route('display.candidates')
            ->with('success', 'Candidate enabled successfully!');
    }
}
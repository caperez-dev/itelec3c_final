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
        
        $search = $request->input('search');
        
        if ($search) {
            $candidates = Candidate::join('positions', 'candidates.position_id', '=', 'positions.position_id')
                ->where(function($query) use ($search) {
                    $query->where('candidates.candidate_id', 'LIKE', "%$search%")
                        ->orWhere('candidates.candidate_name', 'LIKE', "%$search%")
                        ->orWhere('candidates.party_affiliation', 'LIKE', "%$search%")
                        ->orWhere('positions.position_name', 'LIKE', "%$search%");
                })
                ->select('candidates.*', 'positions.position_name')
                ->paginate(10)
                ->appends(['search' => $search]);
        } else {
            $candidates = Candidate::join('positions', 'candidates.position_id', '=', 'positions.position_id')
                ->select('candidates.*', 'positions.position_name')
                ->paginate(10);
        }
        
        return view('CandidatesDisplay', compact('candidates', 'electionStatus'));
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
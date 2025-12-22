<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VoterController extends Controller
{
    public function index(Request $request)
    {
        // Get current election status
        $election = Election::find(1);
        $electionStatus = $election ? $election->status : 'pending';
        // Filters
        $search = $request->input('search');
        $status = $request->input('status');
        $gender = $request->input('gender');
        $registeredFrom = $request->input('registered_from');
        $registeredTo = $request->input('registered_to');

        $query = Voter::whereNull('deleted_at');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%$search%")
                  ->orWhere('last_name', 'LIKE', "%$search%")
                  ->orWhere('gender', 'LIKE', "%$search%")
                  ->orWhere('contact_information', 'LIKE', "%$search%");
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($gender && $gender !== 'all') {
            $query->where('gender', $gender);
        }

        if ($registeredFrom) {
            $query->whereDate('created_at', '>=', $registeredFrom);
        }

        if ($registeredTo) {
            $query->whereDate('created_at', '<=', $registeredTo);
        }

        // Sorting
        $allowedSorts = ['voter_id','first_name','last_name','gender','contact_information','status','created_at'];
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = strtolower($request->input('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'last_name') {
                // sort full name by last_name then first_name
                $query->orderBy('last_name', $sortDir)->orderBy('first_name', $sortDir);
            } else {
                $query->orderBy($sortBy, $sortDir);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $voters = $query->paginate(10)
                        ->appends($request->only(['search','status','gender','registered_from','registered_to','sort_by','sort_dir']));
        
        return view('voters-list', compact('voters', 'electionStatus'));
    }

    /**
     * Show the form for creating a new voter
     */
    public function create()
    {
        // Check election status before allowing create
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot register voters. Election is not in Pending status.');
        }
        
        return view('create-voter');
    }

    /**
     * Generate unique voter key
     */
    private function generateVoterKey()
    {
        do {
            // Get current date in format MMDDYY (e.g., 121625 for Dec 16, 2025)
            $date = date('mdy');
            
            // Generate random 9 digits
            $randomDigits = str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);
            
            // Combine to create voter key: elecvotph + date + - + random digits
            $voterKey = 'elecvotph' . $date . '-' . $randomDigits;
            
            // Check if this key already exists
            $exists = Voter::where('voter_key', $voterKey)->exists();
            
        } while ($exists);
        
        return $voterKey;
    }

    /**
     * Store a newly created voter in database
     */
    public function store(Request $request)
    {
        // Check election status before allowing store
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot register voters. Election is not in Pending status.');
        }
        
        // Validations
        $request->validate([
            'fName' => 'required|string|max:255',
            'lName' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'contact' => 'required|string|max:11',
            'absimagepath' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Generate unique voter key
        $voterKey = $this->generateVoterKey();

        // Insert record to database
        $voter = Voter::create([
            'voter_key' => $voterKey,
            'first_name' => $request->input('fName'),
            'last_name' => $request->input('lName'),
            'birthdate' => $request->input('birthdate'),
            'gender' => $request->input('gender'),
            'contact_information' => $request->input('contact'),
            'imagepath' => $request->file('absimagepath')->store('voter_images', 'public'),
            'status' => 'Active'
        ]);

        // Redirect to success page with voter information
        return redirect()->route('voter.registered.success', ['id' => $voter->voter_id]);
    }

    /**
     * Display voter registration success page
     */
    public function registrationSuccess($id)
    {
        $voter = Voter::findOrFail($id);
        return view('voter-registered-success', compact('voter'));
    }

    /**
     * Show the form for editing a voter
     */
    public function edit($id)
    {
        // Check election status before allowing edit
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot edit voters. Election is not in Pending status.');
        }
        
        $voter = Voter::findOrFail($id);
        return view('edit-voter', compact('voter'));
    }

    /**
     * Update the specified voter in database
     */
    public function update(Request $request, $id)
    {
        // Check election status before allowing update
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot update voters. Election is not in Pending status.');
        }
        
        $voter = Voter::findOrFail($id);
        
        // Validations
        $request->validate([
            'fName' => 'required|string|max:255',
            'lName' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'contact' => 'required|string|max:11',
            'absimagepath' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update voter data
        $voter->first_name = $request->input('fName');
        $voter->last_name = $request->input('lName');
        $voter->birthdate = $request->input('birthdate');
        $voter->gender = $request->input('gender');
        $voter->contact_information = $request->input('contact');

        // Update image if new one is uploaded
        if ($request->hasFile('absimagepath')) {
            // Delete old image
            if ($voter->imagepath) {
                Storage::disk('public')->delete($voter->imagepath);
            }
            $voter->imagepath = $request->file('absimagepath')->store('voter_images', 'public');
        }

        $voter->save();

        return redirect()->route('voters.list')
            ->with('success', 'Voter updated successfully!');
    }

    /**
     * Soft delete the specified voter
     */
    public function destroy($id)
    {
        // Check election status before allowing delete
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot delete voters. Election is not in Pending status.');
        }
        
        $voter = Voter::findOrFail($id);
        $voter->deleted_at = now();
        $voter->save();

        return redirect()->route('voters.list')
            ->with('success', 'Voter deleted successfully!');
    }

    /**
     * Disable the specified voter
     */
    public function disable($id)
    {
        // Check election status before allowing disable
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot disable voters. Election is not in Pending status.');
        }
        
        $voter = Voter::findOrFail($id);
        $voter->status = 'Disabled';
        $voter->save();

        return redirect()->route('voters.list')
            ->with('success', 'Voter disabled successfully!');
    }

    public function enable($id)
    {
        // Check election status before allowing enable
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot enable voters. Election is not in Pending status.');
        }
        
        $voter = Voter::findOrFail($id);
        $voter->status = 'Active';
        $voter->save();
        
        return redirect()->route('voters.list')
            ->with('success', 'Voter enabled successfully!');
    }

    public function ArchivedVotersDisplay(Request $request)
    {
        // Get current election status
        $election = Election::find(1);
        $electionStatus = $election ? $election->status : 'pending';
        
        $search = $request->input('search');
        
        if ($search) {
            $voters = Voter::onlyTrashed()
                ->where(function($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%$search%")
                        ->orWhere('last_name', 'LIKE', "%$search%")
                        ->orWhere('voter_key', 'LIKE', "%$search%")
                        ->orWhere('gender', 'LIKE', "%$search%")
                        ->orWhere('contact_information', 'LIKE', "%$search%");
                })
                ->orderBy('deleted_at', 'desc')
                ->get();
        } else {
            $voters = Voter::onlyTrashed()
                ->orderBy('deleted_at', 'desc')
                ->get();
        }
        
        return view('ArchivedVotersDisplay', compact('voters', 'electionStatus'));
    }

    public function restore($id)
    {
        // Check election status before allowing restore
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.archived.voters')
                ->with('error', 'Cannot restore voters. Election is not in Pending status.');
        }
        
        $voter = Voter::onlyTrashed()->findOrFail($id);
        $voter->restore();
        
        return redirect()->route('display.archived.voters')
            ->with('success', 'Voter restored successfully!');
    }

    public function forceDelete($id)
    {
        // Check election status before allowing force delete
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.archived.voters')
                ->with('error', 'Cannot permanently delete voters. Election is not in Pending status.');
        }
        
        $voter = Voter::onlyTrashed()->findOrFail($id);
        
        // Delete image if exists
        if ($voter->imagepath) {
            Storage::disk('public')->delete($voter->imagepath);
        }
        
        $voter->forceDelete();
        
        return redirect()->route('display.archived.voters')
            ->with('success', 'Voter permanently deleted!');
    }
}
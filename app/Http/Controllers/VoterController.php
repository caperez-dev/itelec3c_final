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
        
        $search = $request->input('search');
        
        if ($search) {
            $voters = Voter::whereNull('deleted_at')
                ->where(function($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%$search%")
                        ->orWhere('last_name', 'LIKE', "%$search%")
                        ->orWhere('gender', 'LIKE', "%$search%")
                        ->orWhere('contact_information', 'LIKE', "%$search%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->appends(['search' => $search]);
        } else {
            $voters = Voter::whereNull('deleted_at')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        
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
        
        // Trim inputs before validation
        $request->merge([
            'fName' => trim($request->fName),
            'lName' => trim($request->lName),
            'contact' => trim($request->contact),
        ]);
        
        // Validations - FIXED REGEX PATTERNS
        $request->validate([
            'fName' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-Z\s\.\-\']+$/u', // Fixed: apostrophe escaped
            ],
            'lName' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-Z\s\.\-\']+$/u', // Fixed: apostrophe escaped
            ],
            'birthdate' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'), // Must be at least 18
                'after_or_equal:' . now()->subYears(120)->format('Y-m-d'), // Maximum 120 years
            ],
            'gender' => [
                'required',
                'string',
                'in:Male,Female,Other', // Specific allowed values
            ],
            'contact' => [
                'required',
                'string',
                'regex:/^(09|\\+639)\d{9}$/', // FIXED: double backslash for +639
                'size:11', // Exactly 11 characters for 09 format
                'unique:voters,contact_information', // Use correct column name
            ],
            'absimagepath' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
            ]
        ], [
            'fName.regex' => 'First name may only contain letters, spaces, dots, hyphens, and apostrophes.',
            'lName.regex' => 'Last name may only contain letters, spaces, dots, hyphens, and apostrophes.',
            'birthdate.before_or_equal' => 'You must be at least 18 years old.',
            'birthdate.after_or_equal' => 'Please enter a valid birthdate.',
            'gender.in' => 'Please select a valid gender (Male, Female, or Other).',
            'contact.regex' => 'Contact number must be a valid Philippine mobile number (09XXXXXXXXX or +639XXXXXXXXX).',
            'contact.size' => 'Contact number must be exactly 11 digits.',
            'contact.unique' => 'This contact number is already registered.',
            'absimagepath.required' => 'Photo is required for registration.',
            'absimagepath.dimensions' => 'Photo must be between 100x100 and 5000x5000 pixels.',
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
            'fName' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Z\s\.\-]+$/',
            ],
            'lName' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Z\s\.\-]+$/',
            ],
            'birthdate' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'), // Must be at least 18 years old
                'after_or_equal:' . now()->subYears(100)->format('Y-m-d'), // Reasonable age limit
            ],
            'gender' => [
                'required',
                'string',
                'in:Male,Female,Other', // Restrict to specific values
            ],
            'contact' => [
                'required',
                'string',
                'regex:/^09\d{9}$/', // Philippine mobile format: 09XXXXXXXXX
                'min:11',
                'max:11',
                'unique:voters,contact', // Assuming contact should be unique in voters table
            ],
            'absimagepath' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                'dimensions:max_width=2000,max_height=2000', // Optional size limits
            ]
        ], [
            'fName.regex' => 'First name may only contain letters, spaces, dots, and hyphens.',
            'lName.regex' => 'Last name may only contain letters, spaces, dots, and hyphens.',
            'birthdate.before_or_equal' => 'You must be at least 18 years old to register.',
            'birthdate.after_or_equal' => 'Please enter a valid birthdate.',
            'contact.regex' => 'Contact number must be a valid Philippine mobile number (09XXXXXXXXX).',
            'contact.unique' => 'This contact number is already registered.',
            'absimagepath.dimensions' => 'Image dimensions should not exceed 2000x2000 pixels.',
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
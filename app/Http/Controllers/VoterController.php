<?php
namespace App\Http\Controllers;
use App\Models\Voter;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF; // Add this import

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
     * Export voters to PDF
     */
    public function exportPDF(Request $request)
    {
        // Get the same filters and sorting as the index
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
        
        // Apply same sorting
        $allowedSorts = ['voter_id','first_name','last_name','gender','contact_information','status','created_at'];
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = strtolower($request->input('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'last_name') {
                $query->orderBy('last_name', $sortDir)->orderBy('first_name', $sortDir);
            } else {
                $query->orderBy($sortBy, $sortDir);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        // Get all voters (no pagination for PDF)
        $voters = $query->get();
        
        // Generate PDF
        $pdf = PDF::loadView('voters-pdf', compact('voters'));
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');
        
        // Generate filename with timestamp
        $filename = 'voters_list_' . date('Y-m-d_His') . '.pdf';
        
        // Download PDF
        return $pdf->download($filename);
    }

    // ... (rest of the existing methods remain the same)
    
    public function create()
    {
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot register voters. Election is not in Pending status.');
        }
        
        return view('create-voter');
    }

    private function generateVoterKey()
    {
        do {
            $date = date('mdy');
            $randomDigits = str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);
            $voterKey = 'elecvotph' . $date . '-' . $randomDigits;
            $exists = Voter::where('voter_key', $voterKey)->exists();
        } while ($exists);
        
        return $voterKey;
    }

    public function store(Request $request)
    {
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot register voters. Election is not in Pending status.');
        }
        
        $request->validate([
            'fName' => 'required|string|max:255',
            'lName' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'contact' => 'required|string|max:11',
            'absimagepath' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $voterKey = $this->generateVoterKey();

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

        return redirect()->route('voter.registered.success', ['id' => $voter->voter_id]);
    }

    public function registrationSuccess($id)
    {
        $voter = Voter::findOrFail($id);
        return view('voter-registered-success', compact('voter'));
    }

    public function edit($id)
    {
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot edit voters. Election is not in Pending status.');
        }
        
        $voter = Voter::findOrFail($id);
        return view('edit-voter', compact('voter'));
    }

    public function update(Request $request, $id)
    {
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('voters.list')
                ->with('error', 'Cannot update voters. Election is not in Pending status.');
        }
        
        $voter = Voter::findOrFail($id);
        
        $request->validate([
            'fName' => 'required|string|max:255',
            'lName' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'contact' => 'required|string|max:11',
            'absimagepath' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $voter->first_name = $request->input('fName');
        $voter->last_name = $request->input('lName');
        $voter->birthdate = $request->input('birthdate');
        $voter->gender = $request->input('gender');
        $voter->contact_information = $request->input('contact');

        if ($request->hasFile('absimagepath')) {
            if ($voter->imagepath) {
                Storage::disk('public')->delete($voter->imagepath);
            }
            $voter->imagepath = $request->file('absimagepath')->store('voter_images', 'public');
        }

        $voter->save();

        return redirect()->route('voters.list')
            ->with('success', 'Voter updated successfully!');
    }

    public function destroy($id)
    {
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

    public function disable($id)
    {
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
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.archived.voters')
                ->with('error', 'Cannot permanently delete voters. Election is not in Pending status.');
        }
        
        $voter = Voter::onlyTrashed()->findOrFail($id);
        
        if ($voter->imagepath) {
            Storage::disk('public')->delete($voter->imagepath);
        }
        
        $voter->forceDelete();
        
        return redirect()->route('display.archived.voters')
            ->with('success', 'Voter permanently deleted!');
    }
}
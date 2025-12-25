<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Election;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PositionController extends Controller
{   
    // Create Position form
    public function create()
    {
        // Check election status before allowing create
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.positions')
                ->with('error', 'Cannot add positions. Election is not in Pending status.');
        }
        
        return view('create-position');
    }
    
    // Store new position
    public function store(Request $request)
    {
        // Check election status before allowing store
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.positions')
                ->with('error', 'Cannot add positions. Election is not in Pending status.');
        }
        
        $validated = $request->validate([
            'position_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s\-\&\,\.\(\)\']+$/',
                Rule::unique('positions')->ignore($position->id ?? null),
            ],
            'description' => 'nullable|string|max:500',
        ]);

        $validated['position_name'] = trim($validated['position_name']);
        if (isset($validated['description'])) {
            $validated['description'] = trim($validated['description']);
        }

        $position = Position::create($validated);
        
        // Log the activity
        Log::create([
            'activity' => 'Created a New Position (ID: ' . $position->position_id . ')',
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return redirect()->route('display.positions')
            ->with('success', 'Position created successfully!');
    }
    
    // Positions Table
    public function PositionsDisplay(Request $request)
    {
        // Get current election status
        $election = Election::find(1);
        $electionStatus = $election ? $election->status : 'pending';
        
        $search = $request->input('search');
        $sort_by = $request->input('sort_by');
        $sort_dir = strtolower($request->input('sort_dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        
        // Build query
        $query = Position::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('position_name', 'LIKE', "%$search%")
                  ->orWhere('position_id', 'LIKE', "%$search%")
                  ->orWhere('description', 'LIKE', "%$search%");
            });
        }

        // Sorting
        $allowed = ['position_id', 'position_name', 'description', 'created_at'];
        if (!in_array($sort_by, $allowed)) {
            $sort_by = null;
        }

        if ($sort_by) {
            if ($sort_by === 'position_id') {
                $query->orderBy('position_id', $sort_dir);
            } else {
                $query->orderBy($sort_by, $sort_dir);
            }
        }

        $positions = $query->paginate(10)
            ->appends($request->only(['search','sort_by','sort_dir']));
        
        return view('PositionsDisplay', compact('positions', 'electionStatus', 'sort_by', 'sort_dir'));
    }
    
    public function ArchivedPositionsDisplay(Request $request)
    {
        // Get current election status
        $election = Election::find(1);
        $electionStatus = $election ? $election->status : 'pending';
        
        $search = $request->input('search');
        
        if ($search) {
            $positions = Position::onlyTrashed()
                ->where('position_name', 'LIKE', "%$search%")
                ->orWhere('position_id', 'LIKE', "%$search%")
                ->orWhere('description', 'LIKE', "%$search%")
                ->get();
        } else {
            $positions = Position::onlyTrashed()->get();
        }
        
        return view('ArchivedPositionsDisplay', compact('positions', 'electionStatus'));
    }
    
    // Soft Delete Position
    public function delete($id)
    {
        // Check election status before allowing delete
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.positions')
                ->with('error', 'Cannot delete positions. Election is not in Pending status.');
        }
        
        $position = Position::findOrFail($id);
        
        // Check if there are any active candidates for this position
        $candidatesCount = \App\Models\Candidate::where('position_id', $id)
            ->whereNull('deleted_at')
            ->count();
        
        if ($candidatesCount > 0) {
            return redirect()->route('display.positions')
                ->with('error', 'Cannot delete this position. There are candidates associated with it.');
        }
        
        $position->delete();
        
        // Log the activity
        Log::create([
            'activity' => 'Archived a Position (ID: ' . $position->position_id . ')',
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return redirect()->route('display.positions')
            ->with('success', 'Position archived successfully!');
    }
    
    // Restore Position
    public function restore($id)
    {
        // Check election status before allowing restore
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.archived.positions')
                ->with('error', 'Cannot restore positions. Election is not in Pending status.');
        }
        
        $position = Position::onlyTrashed()->findOrFail($id);
        $position->restore();
        
        // Log the activity
        Log::create([
            'activity' => 'Restored a Position (ID: ' . $position->position_id . ')',
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return redirect()->route('display.archived.positions')
            ->with('success', 'Position restored successfully!');
    }

    // Force Delete Position (Permanent)
    public function forceDelete($id)
    {
        // Check election status before allowing force delete
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.archived.positions')
                ->with('error', 'Cannot permanently delete positions. Election is not in Pending status.');
        }
        
        $position = Position::onlyTrashed()->findOrFail($id);
        
        // Log the activity before deleting
        Log::create([
            'activity' => 'Permanently Deleted a Position (ID: ' . $position->position_id . ')',
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $position->forceDelete();
        
        return redirect()->route('display.archived.positions')
            ->with('success', 'Position permanently deleted successfully!');
    }

    // Edit Position form
    public function edit($id)
    {
        // Check election status before allowing edit
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.positions')
                ->with('error', 'Cannot edit positions. Election is not in Pending status.');
        }
        
        $position = Position::findOrFail($id);
        return view('edit-position', compact('position'));
    }

    // Update Position
    public function update(Request $request, $id)
    {
        // Check election status before allowing update
        $election = Election::find(1);
        if ($election && strtolower($election->status) !== 'pending') {
            return redirect()->route('display.positions')
                ->with('error', 'Cannot update positions. Election is not in Pending status.');
        }
        
        $position = Position::findOrFail($id);
        
        $validated = $request->validate([
            'position_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s\-\&\,\.\(\)\']+$/',
                Rule::unique('positions')->ignore($position->id ?? null),
            ],
            'description' => 'nullable|string|max:500',
        ]);
        
        $validated['position_name'] = trim($validated['position_name']);
        if (isset($validated['description'])) {
            $validated['description'] = trim($validated['description']);
        }

        $position->update($validated);
        
        // Log the activity
        Log::create([
            'activity' => 'Edited a Position (ID: ' . $position->position_id . ')',
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return redirect()->route('display.positions')
            ->with('success', 'Position updated successfully!');
    }
}
<?php
namespace App\Http\Controllers;
use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    /**
     * Display settings page
     */
    public function settings()
    {
        // Get current election status
        $election = Election::find(1);
        $electionStatus = $election ? $election->status : 'Pending'; // Changed to 'Pending' with capital P
        
        return view('Settings', compact('electionStatus'));
    }
    
    /**
     * Start the election (set status to 'ongoing')
     */
    public function start()
    {
        $election = Election::find(1);
        
        if ($election) {
            $election->status = 'ongoing';
            $election->save();
            
            return redirect()->route('dashboard')->with('success', 'Election has been started successfully!');
        }
        
        return redirect()->route('dashboard')->with('error', 'Election not found.');
    }
    
    /**
     * Pause the election (set status to 'on hold')
     */
    public function pause()
    {
        $election = Election::find(1);
        
        if ($election) {
            $election->status = 'on hold';
            $election->save();
            
            return redirect()->route('dashboard')->with('success', 'Election has been paused.');
        }
        
        return redirect()->route('dashboard')->with('error', 'Election not found.');
    }
    
    /**
     * Resume the election (set status to 'ongoing')
     */
    public function resume()
    {
        $election = Election::find(1);
        
        if ($election) {
            $election->status = 'ongoing';
            $election->save();
            
            return redirect()->route('dashboard')->with('success', 'Election has been resumed.');
        }
        
        return redirect()->route('dashboard')->with('error', 'Election not found.');
    }
    
    /**
     * End the election (set status to 'ended')
     */
    public function end()
    {
        $election = Election::find(1);
        
        if ($election) {
            $election->status = 'ended';
            $election->save();
            
            return redirect()->route('dashboard')->with('success', 'Election has been ended.');
        }
        
        return redirect()->route('dashboard')->with('error', 'Election not found.');
    }
    
    /**
     * Hard reset the entire election system
     * WARNING: This permanently deletes all election data
     */
    public function hardReset()
    {
        // Check election status before allowing hard reset (allow when Pending or Ended)
        $election = Election::find(1);
        if ($election && !in_array(strtolower($election->status), ['pending', 'ended'])) {
            return redirect()->route('settings')
                ->with('error', 'Cannot perform hard reset. Election must be in Pending or Ended status.');
        }
        
        try {
            // Delete all records from candidates table
            \DB::table('candidates')->delete();
            
            // Delete all records from vote_counts table
            \DB::table('vote_counts')->delete();
            
            // Delete all records from votes table
            \DB::table('votes')->delete();
            
            // Reset election status to "Pending" (ID = 1)
            \DB::table('elections')
                ->where('id', 1)
                ->update(['status' => 'Pending']);
            
            // Reset has_voted to 0 for all voters
            \DB::table('voters')
                ->update(['has_voted' => 0]);
            
            return redirect()->route('settings')->with('success', 'Election system has been hard reset successfully! All data has been cleared.');
            
        } catch (\Exception $e) {
            return redirect()->route('settings')->with('error', 'Error resetting election system: ' . $e->getMessage());
        }
    }
}
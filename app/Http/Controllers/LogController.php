<?php
namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::with('user');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('activity', 'like', "%{$search}%")
                  ->orWhere('user_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Activity filter
        if ($request->filled('activity_type') && $request->activity_type != 'all') {
            $query->where('activity', 'like', "%{$request->activity_type}%");
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        
        $query->orderBy($sortBy, $sortDir);

        // Paginate results
        $logs = $query->paginate(15)->withQueryString();

        return view('LogsDisplay', compact('logs'));
    }

    public function exportPDF(Request $request)
    {
        // Log the export activity
        Log::create([
            'activity' => 'Exported Logs in PDF',
            'user_id' => auth()->id(),
        ]);

        $query = Log::with('user');

        // Apply the same filters as the index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('activity', 'like', "%{$search}%")
                  ->orWhere('user_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('activity_type') && $request->activity_type != 'all') {
            $query->where('activity', 'like', "%{$request->activity_type}%");
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Get all logs (no pagination for PDF)
        $logs = $query->get();

        // Prepare filter information for PDF
        $filters = [
            'search' => $request->get('search'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
            'sort_by' => $request->get('sort_by'),
            'sort_dir' => $request->get('sort_dir', 'desc'),
        ];

        // Generate PDF
        $pdf = PDF::loadView('logs-pdf', compact('logs', 'filters'));
        
        // Download PDF with timestamp
        $filename = 'activity-logs-' . date('Y-m-d-His') . '.pdf';
        return $pdf->download($filename);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    /**
     * Display the activity log page
     */
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        // Filter by date range
        $period = $request->get('period', 'this_month');
        switch ($period) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'last_month':
                $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
                break;
            case 'this_year':
                $query->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
                break;
        }

        // Filter by user type
        if ($request->has('user_type') && $request->user_type !== 'all') {
            $query->byUserType($request->user_type);
        }

        // Filter by action
        if ($request->has('action') && $request->action !== 'all') {
            $query->byAction($request->action);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('user_name', 'like', "%{$searchTerm}%")
                  ->orWhere('action', 'like', "%{$searchTerm}%")
                  ->orWhere('details', 'like', "%{$searchTerm}%");
            });
        }

        $activityLogs = $query->orderBy('created_at', 'desc')->paginate(50);

        // Get filter options
        $userTypes = ActivityLog::select('user_type')->distinct()->pluck('user_type');
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        return view('admin.activity-log', compact('activityLogs', 'userTypes', 'actions', 'period'));
    }

    /**
     * Get activity statistics
     */
    public function getStatistics()
    {
        $stats = [
            'total_activities' => ActivityLog::count(),
            'today_activities' => ActivityLog::whereDate('created_at', today())->count(),
            'this_week_activities' => ActivityLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month_activities' => ActivityLog::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'admin_activities' => ActivityLog::byUserType('admin')->count(),
            'customer_activities' => ActivityLog::byUserType('customer')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get recent activities for dashboard
     */
    public function getRecentActivities($limit = 10)
    {
        $activities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json($activities);
    }

    /**
     * Export activity log
     */
    public function export(Request $request)
    {
        $query = ActivityLog::query();

        // Apply same filters as index method
        $period = $request->get('period', 'this_month');
        switch ($period) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'last_month':
                $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
                break;
            case 'this_year':
                $query->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
                break;
        }

        if ($request->has('user_type') && $request->user_type !== 'all') {
            $query->byUserType($request->user_type);
        }

        if ($request->has('action') && $request->action !== 'all') {
            $query->byAction($request->action);
        }

        $activities = $query->orderBy('created_at', 'desc')->get();

        $filename = 'activity_log_' . $period . '_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($activities) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, ['Timestamp', 'User', 'Role', 'Action', 'Details', 'IP Address']);
            
            // CSV data
            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->created_at->format('Y-m-d H:i:s'),
                    $activity->user_name,
                    $activity->user_role,
                    $activity->action,
                    $activity->details,
                    $activity->ip_address,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

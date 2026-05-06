<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard
     */
    public function index()
    {
        $analytics = $this->getAnalyticsData();
        
        return view('admin.reports', compact('analytics'));
    }

    /**
     * Get comprehensive analytics data
     */
    public function getAnalyticsData($period = 'month')
    {
        $dateRange = $this->getDateRange($period);
        
        return [
            'kpis' => $this->getKPIs($dateRange),
            'monthly_revenue' => $this->getMonthlyRevenue(),
            'service_performance' => $this->getServicePerformance($dateRange),
            'service_locations' => $this->getServiceLocations($dateRange),
            'top_customers' => $this->getTopCustomers($dateRange),
            'revenue_trend' => $this->getRevenueTrend($dateRange),
            'appointment_trend' => $this->getAppointmentTrend($dateRange),
            'customer_trend' => $this->getCustomerTrend($dateRange),
        ];
    }

    /**
     * Get Key Performance Indicators
     */
    private function getKPIs($dateRange)
    {
        $currentPeriod = $this->getCurrentPeriodData($dateRange);
        $previousPeriod = $this->getPreviousPeriodData($dateRange);

        return [
            'total_revenue' => [
                'current' => $currentPeriod['revenue'],
                'previous' => $previousPeriod['revenue'],
                'change' => $this->calculatePercentageChange($currentPeriod['revenue'], $previousPeriod['revenue']),
                'formatted' => '₱' . number_format($currentPeriod['revenue'], 0),
            ],
            'appointments' => [
                'current' => $currentPeriod['appointments'],
                'previous' => $previousPeriod['appointments'],
                'change' => $this->calculatePercentageChange($currentPeriod['appointments'], $previousPeriod['appointments']),
                'formatted' => number_format($currentPeriod['appointments']),
            ],
            'new_customers' => [
                'current' => $currentPeriod['customers'],
                'previous' => $previousPeriod['customers'],
                'change' => $this->calculatePercentageChange($currentPeriod['customers'], $previousPeriod['customers']),
                'formatted' => number_format($currentPeriod['customers']),
            ],
            'avg_spend' => [
                'current' => $currentPeriod['avg_spend'],
                'previous' => $previousPeriod['avg_spend'],
                'change' => $this->calculatePercentageChange($currentPeriod['avg_spend'], $previousPeriod['avg_spend']),
                'formatted' => '₱' . number_format($currentPeriod['avg_spend'], 0),
            ],
        ];
    }

    /**
     * Get current period data
     */
    private function getCurrentPeriodData($dateRange)
    {
        $revenue = Appointment::whereBetween('created_at', $dateRange)
            ->where('status', 'completed')
            ->sum('amount');

        $appointments = Appointment::whereBetween('created_at', $dateRange)
            ->where('status', 'completed')
            ->count();

        $customers = User::whereBetween('created_at', $dateRange)
            ->where('role', 'customer')
            ->count();

        $avgSpend = $appointments > 0 ? $revenue / $appointments : 0;

        return [
            'revenue' => $revenue,
            'appointments' => $appointments,
            'customers' => $customers,
            'avg_spend' => $avgSpend,
        ];
    }

    /**
     * Get previous period data for comparison
     */
    private function getPreviousPeriodData($dateRange)
    {
        $periodLength = $dateRange['end']->diffInDays($dateRange['start']);
        $previousStart = $dateRange['start']->copy()->subDays($periodLength);
        $previousEnd = $dateRange['start']->copy()->subDay();

        $revenue = Appointment::whereBetween('created_at', [$previousStart, $previousEnd])
            ->where('status', 'completed')
            ->sum('amount');

        $appointments = Appointment::whereBetween('created_at', [$previousStart, $previousEnd])
            ->where('status', 'completed')
            ->count();

        $customers = User::whereBetween('created_at', [$previousStart, $previousEnd])
            ->where('role', 'customer')
            ->count();

        $avgSpend = $appointments > 0 ? $revenue / $appointments : 0;

        return [
            'revenue' => $revenue,
            'appointments' => $appointments,
            'customers' => $customers,
            'avg_spend' => $avgSpend,
        ];
    }

    /**
     * Get monthly revenue data for the last 6 months
     */
    private function getMonthlyRevenue()
    {
        $months = [];
        $revenues = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();

            $revenue = Appointment::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('status', 'completed')
                ->sum('amount');

            $months[] = $month->format('M');
            $revenues[] = $revenue;
        }

        return [
            'months' => $months,
            'revenues' => $revenues,
        ];
    }

    /**
     * Get service performance data
     */
    private function getServicePerformance($dateRange)
    {
        $services = Service::withCount(['appointments' => function ($query) use ($dateRange) {
            $query->whereBetween('created_at', $dateRange)
                  ->where('status', 'completed');
        }])
        ->withSum(['appointments' => function ($query) use ($dateRange) {
            $query->whereBetween('created_at', $dateRange)
                  ->where('status', 'completed');
        }], 'amount')
        ->get();

        return $services->map(function ($service) {
            return [
                'name' => $service->name,
                'revenue' => $service->appointments_sum_amount ?? 0,
                'appointments' => $service->appointments_count,
            ];
        })->sortByDesc('revenue')->values();
    }

    /**
     * Get service locations data
     */
    private function getServiceLocations($dateRange)
    {
        $locations = Appointment::whereBetween('created_at', $dateRange)
            ->where('status', 'completed')
            ->select('location_type', DB::raw('count(*) as count'))
            ->groupBy('location_type')
            ->get();

        $total = $locations->sum('count');

        return $locations->map(function ($location) use ($total) {
            return [
                'name' => ucfirst(str_replace('_', ' ', $location->location_type)),
                'count' => $location->count,
                'percentage' => $total > 0 ? round(($location->count / $total) * 100, 1) : 0,
            ];
        });
    }

    /**
     * Get top customers data
     */
    private function getTopCustomers($dateRange)
    {
        return User::where('role', 'customer')
            ->withCount(['appointments' => function ($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange)
                      ->where('status', 'completed');
            }])
            ->withSum(['appointments' => function ($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange)
                      ->where('status', 'completed');
            }], 'amount')
            ->with(['appointments' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->having('appointments_count', '>', 0)
            ->orderBy('appointments_sum_amount', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'appointments' => $customer->appointments_count,
                    'total_spend' => $customer->appointments_sum_amount ?? 0,
                    'last_visit' => $customer->appointments->first()?->created_at?->format('M j, Y') ?? 'N/A',
                    'loyalty' => $this->calculateLoyaltyScore($customer->appointments_count, $customer->appointments_sum_amount ?? 0),
                ];
            });
    }

    /**
     * Get revenue trend data
     */
    private function getRevenueTrend($dateRange)
    {
        $days = [];
        $revenues = [];

        $start = $dateRange['start']->copy();
        $end = $dateRange['end']->copy();

        while ($start->lte($end)) {
            $dayRevenue = Appointment::whereDate('created_at', $start)
                ->where('status', 'completed')
                ->sum('amount');

            $days[] = $start->format('M j');
            $revenues[] = $dayRevenue;

            $start->addDay();
        }

        return [
            'days' => $days,
            'revenues' => $revenues,
        ];
    }

    /**
     * Get appointment trend data
     */
    private function getAppointmentTrend($dateRange)
    {
        $days = [];
        $appointments = [];

        $start = $dateRange['start']->copy();
        $end = $dateRange['end']->copy();

        while ($start->lte($end)) {
            $dayAppointments = Appointment::whereDate('created_at', $start)
                ->where('status', 'completed')
                ->count();

            $days[] = $start->format('M j');
            $appointments[] = $dayAppointments;

            $start->addDay();
        }

        return [
            'days' => $days,
            'appointments' => $appointments,
        ];
    }

    /**
     * Get customer trend data
     */
    private function getCustomerTrend($dateRange)
    {
        $days = [];
        $customers = [];

        $start = $dateRange['start']->copy();
        $end = $dateRange['end']->copy();

        while ($start->lte($end)) {
            $dayCustomers = User::whereDate('created_at', $start)
                ->where('role', 'customer')
                ->count();

            $days[] = $start->format('M j');
            $customers[] = $dayCustomers;

            $start->addDay();
        }

        return [
            'days' => $days,
            'customers' => $customers,
        ];
    }

    /**
     * Calculate percentage change
     */
    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * Calculate loyalty score
     */
    private function calculateLoyaltyScore($appointments, $totalSpend)
    {
        $score = ($appointments * 10) + ($totalSpend / 100);
        
        if ($score >= 100) return 'Gold';
        if ($score >= 50) return 'Silver';
        if ($score >= 20) return 'Bronze';
        return 'New';
    }

    /**
     * Get date range based on period
     */
    private function getDateRange($period)
    {
        switch ($period) {
            case 'week':
                return [
                    'start' => Carbon::now()->startOfWeek(),
                    'end' => Carbon::now()->endOfWeek(),
                ];
            case 'month':
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth(),
                ];
            case 'year':
                return [
                    'start' => Carbon::now()->startOfYear(),
                    'end' => Carbon::now()->endOfYear(),
                ];
            default:
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth(),
                ];
        }
    }

    /**
     * Get analytics data as JSON (for API)
     */
    public function getAnalyticsJson(Request $request)
    {
        $period = $request->get('period', 'month');
        $analytics = $this->getAnalyticsData($period);
        
        return response()->json($analytics);
    }
}

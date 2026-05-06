<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        // Check if user exists and is an admin
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user || $user->role !== 'admin') {
            return back()->withErrors([
                'email' => 'These credentials do not match our records or you do not have admin access.',
            ])->withInput($request->only('email'));
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function dashboard()
    {
        \Log::info('Dashboard method called at: ' . now()->format('Y-m-d H:i:s'));
        
        $user = Auth::user();
        
        if ($user->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
        }

        $today = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        $weekStart = now()->startOfWeek();
        $monthStart = now()->startOfMonth();

        // Today's Statistics
        $todayAppointments = Appointment::whereDate('appointment_date', $today)->count();
        $todayRevenue = Appointment::whereDate('appointment_date', $today)
            ->where('payment_status', 'paid')
            ->sum('amount');
        $todayCompleted = Appointment::whereDate('appointment_date', $today)
            ->where('status', 'completed')
            ->count();
        
        // Debug logging
        \Log::info('Dashboard Debug - Today: ' . $today->format('Y-m-d'));
        \Log::info('Today Appointments: ' . $todayAppointments);
        \Log::info('Today Revenue: ' . $todayRevenue);
        
        
        // This Week's New Customers
        $newCustomersWeek = User::where('role', 'customer')
            ->where('created_at', '>=', $weekStart)
            ->count();
        
        // This Month's Pending Appointments
        $pendingAppointments = Appointment::where('status', 'pending')
            ->whereMonth('appointment_date', now()->month)
            ->count();

        // Overall Statistics
        $totalUsers = User::where('role', 'customer')->count();
        $totalAppointments = Appointment::count();
        $totalServices = Service::where('status', 'active')->count();
        $totalRevenue = Appointment::where('payment_status', 'paid')->sum('amount');
        
        // Status breakdown
        $appointmentsByStatus = [
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        // Today's appointments with details
        $todayAppointmentsList = Appointment::with(['user', 'service'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Upcoming appointments (next 7 days)
        $upcomingAppointments = Appointment::with(['user', 'service'])
            ->where('appointment_date', '>', now())
            ->where('appointment_date', '<=', now()->addDays(7))
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date', 'asc')
            ->take(5)
            ->get();
        
        // Recent appointments
        $recentAppointments = Appointment::with(['user', 'service'])
            ->latest('created_at')
            ->take(5)
            ->get();
        

        // Top services by bookings
        $topServices = Service::withCount(['appointments' => function($query) use ($monthStart) {
                $query->where('created_at', '>=', $monthStart);
            }])
            ->orderBy('appointments_count', 'desc')
            ->take(5)
            ->get();

        // Revenue by location type
        $revenueByLocation = Appointment::where('payment_status', 'paid')
            ->where('created_at', '>=', $monthStart)
            ->selectRaw('location_type, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('location_type')
            ->get();

        // Monthly revenue for chart (last 6 months)
        $monthlyRevenue = [];
        $monthlyLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M');
            
            $revenue = Appointment::whereYear('appointment_date', $date->year)
                ->whereMonth('appointment_date', $date->month)
                ->where('status', 'completed')
                ->sum('amount');
            
            $monthlyRevenue[] = $revenue;
        }

        // Weekly appointments for chart
        $weeklyAppointments = [];
        $weeklyLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $weeklyLabels[] = $date->format('D');
            
            $count = Appointment::whereDate('appointment_date', $date)
                ->count();
            
            $weeklyAppointments[] = $count;
        }

        // Test variable
        $testVariable = 'Dashboard loaded at: ' . now()->format('Y-m-d H:i:s');
        
        return view('admin.dashboard', compact(
            'todayAppointments',
            'todayRevenue',
            'todayCompleted',
            'newCustomersWeek',
            'pendingAppointments',
            'totalUsers', 
            'totalAppointments', 
            'totalServices',
            'totalRevenue',
            'appointmentsByStatus',
            'todayAppointmentsList',
            'upcomingAppointments',
            'recentAppointments', 
            'topServices',
            'revenueByLocation',
            'monthlyRevenue',
            'monthlyLabels',
            'weeklyAppointments',
            'weeklyLabels',
            'testVariable'
        ));
    }
    
    /**
     * Get dashboard statistics as JSON for AJAX requests
     */
    public function getDashboardStats()
    {
        $user = Auth::user();
        
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $today = now()->startOfDay();
        $weekStart = now()->startOfWeek();
        $monthStart = now()->startOfMonth();

        // Today's Statistics
        $todayAppointments = Appointment::whereDate('appointment_date', $today)->count();
        $todayRevenue = Appointment::whereDate('appointment_date', $today)
            ->where('payment_status', 'paid')
            ->sum('amount');
        
        // This Week's New Customers
        $newCustomersWeek = User::where('role', 'customer')
            ->where('created_at', '>=', $weekStart)
            ->count();
        
        // This Month's Pending Appointments
        $pendingAppointments = Appointment::where('status', 'pending')
            ->whereMonth('appointment_date', now()->month)
            ->count();

        return response()->json([
            'todayAppointments' => $todayAppointments,
            'todayRevenue' => $todayRevenue,
            'newCustomersWeek' => $newCustomersWeek,
            'pendingAppointments' => $pendingAppointments,
            'totalAppointments' => Appointment::count(),
            'totalUsers' => User::where('role', 'customer')->count(),
        ]);
    }

    public function customers()
    {
        $user = Auth::user();
        
        if ($user->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
        }

        // Get all customers (both registered and admin-created)
        $allCustomers = User::where('role', 'customer')
            ->withCount('appointments')
            ->withSum('appointments', 'amount')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users', compact('allCustomers'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')->with('success', 'You have been successfully logged out.');
    }

    public function showPasswordResetForm()
    {
        return view('auth.admin-password-reset');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if ($user->role !== 'admin') {
            return back()->withErrors([
                'email' => 'This email is not associated with an admin account.',
            ]);
        }

        // Here you would typically send a password reset email
        // For now, we'll just show a success message
        return back()->with('success', 'Password reset link has been sent to your email address.');
    }
}

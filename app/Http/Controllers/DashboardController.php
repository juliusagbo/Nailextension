<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get upcoming appointments (pending status and future dates)
        $upcomingAppointments = Appointment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('appointment_date', '>', Carbon::now())
            ->count();
        
        // Get total appointments
        $totalAppointments = Appointment::where('user_id', $user->id)->count();
        
        // Get completed appointments
        $completedAppointments = Appointment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        
        // Get favorite designs count from the favorites table
        $favoriteDesigns = \App\Models\Favorite::where('user_id', $user->id)->count();
        
        // Get upcoming appointments for the table
        $upcomingAppointmentsList = Appointment::with(['service'])
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('appointment_date', '>', Carbon::now())
            ->orderBy('appointment_date', 'asc')
            ->limit(5)
            ->get();
        
        // Get recent appointments (last 5)
        $recentAppointments = Appointment::with(['service'])
            ->where('user_id', $user->id)
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();
        
        // Get all services for the booking form
        $services = Service::all();
        
        return view('dashboard', compact(
            'upcomingAppointments',
            'totalAppointments', 
            'completedAppointments',
            'favoriteDesigns',
            'upcomingAppointmentsList',
            'recentAppointments',
            'services'
        ));
    }
}

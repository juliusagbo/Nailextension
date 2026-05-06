<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function index()
    {
        $services = Service::active()->get();
        
        // Get business information and hours from settings
        $businessInfo = \App\Models\Settings::getBusinessInfo();
        $businessHours = \App\Models\Settings::getBusinessHours();
        
        return view('welcome', compact('services', 'businessInfo', 'businessHours'));
    }

    public function bookAppointment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
            'location_type' => 'required|in:home-service,walk-in',
            'customer_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Get the service to calculate amount
        $service = Service::findOrFail($validated['service_id']);
        
        // Create appointment
        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'service_id' => $validated['service_id'],
            'appointment_date' => $validated['appointment_date'],
            'location_type' => $validated['location_type'],
            'customer_address' => $validated['customer_address'],
            'amount' => $service->price,
            'status' => 'pending',
            'payment_status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        return response()->json([
            'message' => 'Appointment booked successfully!',
            'appointment' => $appointment->load('service')
        ], 201);
    }

    public function getAvailableSlots(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => 'required|date|after:today',
            'service_id' => 'required|exists:services,id',
        ]);

        $date = $validated['date'];
        $service = Service::findOrFail($validated['service_id']);
        
        // Define business hours (9 AM to 6 PM)
        $businessHours = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
            '15:00', '15:30', '16:00', '16:30', '17:00', '17:30'
        ];

        // Get booked slots for this date and service
        $bookedSlots = Appointment::whereDate('appointment_date', $date)
            ->where('service_id', $validated['service_id'])
            ->pluck('appointment_date')
            ->map(function($datetime) {
                return date('H:i', strtotime($datetime));
            })
            ->toArray();

        // Filter out booked slots and slots that would overlap
        $availableSlots = [];
        foreach ($businessHours as $slot) {
            $slotDateTime = $date . ' ' . $slot;
            $endTime = date('H:i', strtotime($slotDateTime . ' +' . $service->duration_minutes . ' minutes'));
            
            // Check if this slot conflicts with any existing appointments
            $conflicts = Appointment::whereDate('appointment_date', $date)
                ->where(function($query) use ($slotDateTime, $endTime) {
                    $query->where(function($q) use ($slotDateTime, $endTime) {
                        $q->where('appointment_date', '<=', $slotDateTime)
                          ->whereRaw('DATE_ADD(appointment_date, INTERVAL ? MINUTE)', [$service->duration_minutes])
                          ->where('appointment_date', '>', $slotDateTime);
                    });
                })
                ->exists();

            if (!in_array($slot, $bookedSlots) && !$conflicts) {
                $availableSlots[] = $slot;
            }
        }

        return response()->json([
            'available_slots' => $availableSlots,
            'service_duration' => $service->duration_minutes
        ]);
    }

    public function cancelAppointment(Appointment $appointment): JsonResponse
    {
        if ($appointment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($appointment->status === 'completed') {
            return response()->json(['message' => 'Cannot cancel completed appointment'], 400);
        }

        $appointment->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Appointment cancelled successfully'
        ]);
    }

    public function rescheduleAppointment(Request $request, Appointment $appointment): JsonResponse
    {
        if ($appointment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'appointment_date' => 'required|date|after:now',
        ]);

        $appointment->update(['appointment_date' => $validated['appointment_date']]);

        return response()->json([
            'message' => 'Appointment rescheduled successfully',
            'appointment' => $appointment->load('service')
        ]);
    }
}

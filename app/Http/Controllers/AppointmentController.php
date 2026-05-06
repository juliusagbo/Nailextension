<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $appointments = Appointment::with(['user', 'service'])
            ->where('user_id', $user->id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('appointments', compact('appointments'));
    }

    public function store(Request $request)
    {
        try {
            // Log the request data for debugging
            \Log::info('Appointment booking request:', $request->all());
            
            // Validate request - support both single service_id and multiple service_ids
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'service_id' => 'nullable|exists:services,id', // For backward compatibility
                'service_ids' => 'nullable|array|max:5',
                'service_ids.*' => 'required|exists:services,id',
                'appointment_date' => 'required|date',
                'appointment_time' => 'required',
                'location_type' => 'required|in:home-service,walk-in',
                'customer_address' => 'nullable|string',
                'amount' => 'nullable|numeric|min:0',
                'status' => 'sometimes|in:pending,confirmed,completed,cancelled',
                'payment_status' => 'sometimes|in:pending,partial,paid',
                'notes' => 'nullable|string',
            ]);
            
            // Get service IDs - support both old (service_id) and new (service_ids[]) format
            $serviceIds = [];
            if ($request->has('service_ids') && is_array($request->service_ids)) {
                $serviceIds = array_filter($request->service_ids); // Remove empty values
            } elseif ($request->has('service_id')) {
                $serviceIds = [$request->service_id];
            }
            
            if (empty($serviceIds)) {
                return redirect()->back()->withErrors(['error' => 'Please select at least one service.'])->withInput();
            }
            
            if (count($serviceIds) > 5) {
                return redirect()->back()->withErrors(['error' => 'Maximum 5 services allowed per appointment.'])->withInput();
            }
            
            // Combine date and time into appointment_date
            $combinedDateTime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];
            
            // Validate that the combined date and time is in the future
            if (strtotime($combinedDateTime) <= time()) {
                throw new \Illuminate\Validation\ValidationException(
                    validator([], []), 
                    'The appointment date and time must be in the future.'
                );
            }
            
            // Set default status if not provided
            $status = $validated['status'] ?? 'pending';
            $paymentStatus = $validated['payment_status'] ?? 'pending';
            
            // Create appointments for each service
            $createdAppointments = [];
            $totalAmount = 0;
            
            foreach ($serviceIds as $serviceId) {
                $service = Service::findOrFail($serviceId);
                $serviceAmount = $service->price;
                $totalAmount += $serviceAmount;
                
                $appointment = Appointment::create([
                    'user_id' => $validated['user_id'],
                    'service_id' => $serviceId,
                    'appointment_date' => $combinedDateTime,
                    'location_type' => $validated['location_type'],
                    'customer_address' => $validated['customer_address'] ?? null,
                    'amount' => $serviceAmount,
                    'status' => $status,
                    'payment_status' => $paymentStatus,
                    'notes' => $validated['notes'] ?? null,
                ]);
                
                $createdAppointments[] = $appointment;
            }
            
            $serviceCount = count($createdAppointments);
            $successMessage = $serviceCount > 1 
                ? "Successfully booked {$serviceCount} appointments!" 
                : 'Appointment booked successfully! You can book unlimited appointments.';

            return redirect()->route('dashboard')->with('success', $successMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Appointment booking error: ' . $e->getMessage());
            \Log::error('Error details: ' . $e->getTraceAsString());
            
            return redirect()->back()->withErrors(['error' => 'Failed to book appointment. Please try again.'])->withInput();
        }
    }

    public function show(Appointment $appointment): JsonResponse
    {
        // Ensure user can only view their own appointments
        if ($appointment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        return response()->json($appointment->load(['user', 'service']));
    }

    public function update(Request $request, Appointment $appointment): JsonResponse
    {
        // Ensure user can only update their own appointments
        if ($appointment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'appointment_date' => 'sometimes|date|after:now',
            'location_type' => 'sometimes|in:home-service,walk-in',
            'customer_address' => 'nullable|string',
            'amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'sometimes|in:pending,partial,paid',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return response()->json([
            'message' => 'Appointment updated successfully',
            'appointment' => $appointment->load(['user', 'service'])
        ]);
    }

    public function destroy(Appointment $appointment): JsonResponse
    {
        // Ensure user can only delete their own appointments
        if ($appointment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $appointment->delete();

        return response()->json([
            'message' => 'Appointment deleted successfully'
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment): JsonResponse
    {
        // Ensure user can only update their own appointments
        if ($appointment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $appointment->update($validated);

        return response()->json([
            'message' => 'Appointment status updated successfully',
            'appointment' => $appointment->load(['user', 'service'])
        ]);
    }

    public function updatePaymentStatus(Request $request, Appointment $appointment): JsonResponse
    {
        // Ensure user can only update their own appointments
        if ($appointment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,partial,paid',
        ]);

        $appointment->update($validated);

        return response()->json([
            'message' => 'Payment status updated successfully',
            'appointment' => $appointment->load(['user', 'service'])
        ]);
    }

    public function getByStatus($status): JsonResponse
    {
        $user = Auth::user();
        $appointments = Appointment::with(['user', 'service'])
            ->where('user_id', $user->id)
            ->byStatus($status)
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json($appointments);
    }

    public function getByDateRange(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $user = Auth::user();
        $appointments = Appointment::with(['user', 'service'])
            ->where('user_id', $user->id)
            ->byDateRange($validated['start_date'], $validated['end_date'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json($appointments);
    }

    public function getUserAppointments(): JsonResponse
    {
        $user = Auth::user();
        $appointments = $user->appointments()
            ->with('service')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json($appointments);
    }

    public function reschedule(Request $request)
    {
        try {
            // Log the incoming request for debugging
            \Log::info('Reschedule request data:', $request->all());
            \Log::info('Request method: ' . $request->method());
            \Log::info('CSRF token: ' . $request->header('X-CSRF-TOKEN'));
            \Log::info('Session ID: ' . session()->getId());
            
            $validated = $request->validate([
                'appointment_id' => 'required|exists:appointments,id',
                'user_id' => 'required|exists:users,id',
                'new_appointment_date' => 'required|date',
                'new_appointment_time' => 'required',
                'reschedule_reason' => 'required|string|min:10',
            ]);

            // Ensure user can only reschedule their own appointments
            if ($validated['user_id'] != Auth::id()) {
                \Log::warning('Unauthorized reschedule attempt by user: ' . Auth::id());
                return redirect()->back()->withErrors(['error' => 'Unauthorized to reschedule this appointment.']);
            }

            $appointment = Appointment::findOrFail($validated['appointment_id']);
            
            // Double-check that the appointment belongs to the authenticated user
            if ($appointment->user_id != Auth::id()) {
                \Log::warning('User ' . Auth::id() . ' tried to reschedule appointment ' . $validated['appointment_id'] . ' which belongs to user ' . $appointment->user_id);
                return redirect()->back()->withErrors(['error' => 'Unauthorized to reschedule this appointment.']);
            }

            // Combine date and time into appointment_date
            $combinedDateTime = $validated['new_appointment_date'] . ' ' . $validated['new_appointment_time'];
            
            // Validate that the combined date and time is in the future
            $newDateTime = strtotime($combinedDateTime);
            $currentTime = time();
            
            if ($newDateTime <= $currentTime) {
                return redirect()->back()->withErrors(['error' => 'The new appointment date and time must be in the future.'])->withInput();
            }

            // Update the appointment with the new date and time
            \Log::info('Attempting to update appointment with data:', [
                'appointment_id' => $appointment->id,
                'new_appointment_date' => $combinedDateTime,
                'old_appointment_date' => $appointment->appointment_date
            ]);
            
            $updateResult = $appointment->update([
                'appointment_date' => $combinedDateTime,
                'notes' => ($appointment->notes ? $appointment->notes . "\n\n" : "") . "Reschedule Reason: " . $validated['reschedule_reason'] . " (Rescheduled on " . now()->format('Y-m-d H:i:s') . ")",
            ]);
            
            \Log::info('Update result: ' . ($updateResult ? 'success' : 'failed'));

            \Log::info('Appointment rescheduled successfully', [
                'appointment_id' => $appointment->id,
                'user_id' => $appointment->user_id,
                'old_date' => $appointment->getOriginal('appointment_date'),
                'new_date' => $combinedDateTime
            ]);

            return redirect()->route('dashboard')->with('success', 'Appointment rescheduled successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in reschedule: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Appointment reschedule error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->withErrors(['error' => 'Failed to reschedule appointment. Please try again.'])->withInput();
        }
    }

    public function markCompleted(Appointment $appointment)
    {
        try {
            // Ensure user can only update their own appointments
            if ($appointment->user_id !== Auth::id()) {
                return redirect()->back()->withErrors(['error' => 'Unauthorized to update this appointment.']);
            }

            $appointment->update(['status' => 'completed']);

            return redirect()->back()->with('success', 'Appointment marked as completed!');
        } catch (\Exception $e) {
            \Log::error('Mark completed error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update appointment status.']);
        }
    }

    public function markCancelled(Appointment $appointment)
    {
        try {
            // Ensure user can only update their own appointments
            if ($appointment->user_id !== Auth::id()) {
                return redirect()->back()->withErrors(['error' => 'Unauthorized to update this appointment.']);
            }

            $appointment->update(['status' => 'cancelled']);

            return redirect()->back()->with('success', 'Appointment cancelled successfully!');
        } catch (\Exception $e) {
            \Log::error('Mark cancelled error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to cancel appointment.']);
        }
    }

    public function submitReview(Request $request)
    {
        try {
            // Log the incoming request for debugging
            \Log::info('Review submission request data:', $request->all());
            
            $validated = $request->validate([
                'appointment_id' => 'required|exists:appointments,id',
                'user_id' => 'required|exists:users,id',
                'rating' => 'required|integer|between:1,5',
                'review_title' => 'required|string|max:100',
                'review_comment' => 'required|string|min:20|max:500',
                'recommend_service' => 'required|in:yes,maybe,no',
            ]);

            // Ensure user can only review their own appointments
            if ($validated['user_id'] != Auth::id()) {
                \Log::warning('Unauthorized review attempt by user: ' . Auth::id());
                return redirect()->back()->withErrors(['error' => 'Unauthorized to review this appointment.']);
            }

            $appointment = Appointment::findOrFail($validated['appointment_id']);
            
            // Double-check that the appointment belongs to the authenticated user
            if ($appointment->user_id != Auth::id()) {
                \Log::warning('User ' . Auth::id() . ' tried to review appointment ' . $validated['appointment_id'] . ' which belongs to user ' . $appointment->user_id);
                return redirect()->back()->withErrors(['error' => 'Unauthorized to review this appointment.']);
            }

            // Check if appointment is completed
            if ($appointment->status !== 'completed') {
                return redirect()->back()->withErrors(['error' => 'You can only review completed appointments.']);
            }

            // For now, we'll store the review in the appointment notes
            // In a real application, you'd want a separate reviews table
            $reviewText = "REVIEW:\n";
            $reviewText .= "Rating: " . str_repeat('★', $validated['rating']) . " (" . $validated['rating'] . "/5)\n";
            $reviewText .= "Title: " . $validated['review_title'] . "\n";
            $reviewText .= "Comment: " . $validated['review_comment'] . "\n";
            $reviewText .= "Recommend: " . ucfirst($validated['recommend_service']) . "\n";
            $reviewText .= "Reviewed on: " . now()->format('Y-m-d H:i:s') . "\n\n";

            $appointment->update([
                'notes' => ($appointment->notes ? $appointment->notes . "\n\n" : "") . $reviewText,
            ]);

            \Log::info('Review submitted successfully', [
                'appointment_id' => $appointment->id,
                'user_id' => $appointment->user_id,
                'rating' => $validated['rating'],
                'review_title' => $validated['review_title']
            ]);

            return redirect()->route('dashboard')->with('success', 'Thank you for your review! Your feedback helps us improve our services.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in review submission: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Review submission error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->withErrors(['error' => 'Failed to submit review. Please try again.'])->withInput();
        }
    }

    public function getAvailableTimeSlots(Request $request): JsonResponse
    {
        try {
            // Validate and sanitize date input
            $dateInput = $request->input('date');
            
            // Check if date is in valid format (YYYY-MM-DD)
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateInput)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid date format. Expected YYYY-MM-DD.',
                    'error' => 'Invalid date format: ' . $dateInput
                ], 400);
            }
            
            $validated = $request->validate([
                'date' => 'required|date|after_or_equal:today',
                'service_id' => 'nullable|exists:services,id',
            ]);

            $date = $validated['date'];
            $serviceId = $validated['service_id'] ?? null;
            
            // Additional validation: ensure date is a valid date
            try {
                $dateObj = Carbon::parse($date);
                if ($dateObj->year < 2000 || $dateObj->year > 2100) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid date. Please select a valid date.',
                        'error' => 'Date out of valid range: ' . $date
                    ], 400);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid date format.',
                    'error' => 'Date parsing error: ' . $e->getMessage()
                ], 400);
            }
            
            // Get service duration if service_id is provided
            $serviceDuration = 60; // Default 60 minutes
            if ($serviceId) {
                $service = Service::find($serviceId);
                if ($service && $service->duration_minutes) {
                    $serviceDuration = $service->duration_minutes;
                }
            }

            // Define business hours (9 AM to 6 PM) - 30 minute intervals
            $businessHours = [];
            for ($hour = 9; $hour < 18; $hour++) {
                $businessHours[] = sprintf('%02d:00', $hour);
                $businessHours[] = sprintf('%02d:30', $hour);
            }

            // Get all appointments for this date (excluding cancelled)
            $appointments = Appointment::whereDate('appointment_date', $date)
                ->where('status', '!=', 'cancelled')
                ->with('service')
                ->get();

            // Build list of booked time ranges
            $bookedRanges = [];
            foreach ($appointments as $appointment) {
                $startTime = Carbon::parse($appointment->appointment_date);
                $duration = $appointment->service->duration_minutes ?? 60;
                $endTime = $startTime->copy()->addMinutes($duration);
                
                $bookedRanges[] = [
                    'start' => $startTime->format('H:i'),
                    'end' => $endTime->format('H:i'),
                ];
            }

            // Filter available slots
            $availableSlots = [];
            foreach ($businessHours as $slot) {
                $slotTime = Carbon::parse($date . ' ' . $slot);
                $slotEndTime = $slotTime->copy()->addMinutes($serviceDuration);
                
                // Check if this slot conflicts with any booked appointment
                $isAvailable = true;
                foreach ($bookedRanges as $booked) {
                    $bookedStart = Carbon::parse($date . ' ' . $booked['start']);
                    $bookedEnd = Carbon::parse($date . ' ' . $booked['end']);
                    
                    // Check for overlap
                    if ($slotTime->lt($bookedEnd) && $slotEndTime->gt($bookedStart)) {
                        $isAvailable = false;
                        break;
                    }
                }
                
                // Also check if slot is in the past (for today)
                if ($slotTime->isPast() && $slotTime->isToday()) {
                    $isAvailable = false;
                }
                
                if ($isAvailable) {
                    $availableSlots[] = $slot;
                }
            }

            return response()->json([
                'success' => true,
                'available_slots' => $availableSlots,
                'date' => $date,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting available time slots: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get available time slots.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAppointmentController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all methods in this controller
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display all appointments for admin
     */
    public function index()
    {
        $appointments = Appointment::with(['user', 'service'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        $services = Service::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.appointments', compact('appointments', 'services'));
    }

    /**
     * Get all appointments as JSON for AJAX requests
     */
    public function getAllAppointments(): JsonResponse
    {
        $appointments = Appointment::with(['user', 'service'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json($appointments);
    }

    /**
     * Get appointments filtered by status
     */
    public function getByStatus($status): JsonResponse
    {
        $query = Appointment::with(['user', 'service']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $appointments = $query->orderBy('appointment_date', 'desc')->get();
        
        return response()->json($appointments);
    }

    /**
     * Get appointments filtered by date range
     */
    public function getByDateRange(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $appointments = Appointment::with(['user', 'service'])
            ->whereBetween('appointment_date', [$validated['start_date'], $validated['end_date']])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json($appointments);
    }

    /**
     * Search appointments
     */
    public function search(Request $request): JsonResponse
    {
        $searchTerm = $request->get('search');
        
        $appointments = Appointment::with(['user', 'service'])
            ->where(function($query) use ($searchTerm) {
                $query->whereHas('user', function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%");
                })
                ->orWhereHas('service', function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%");
                })
                ->orWhere('id', 'like', "%{$searchTerm}%");
            })
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json($appointments);
    }

    /**
     * Create new appointment from admin panel
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'customerName' => 'required|string|max:255',
                'customerPhone' => 'required|string|max:20',
                'serviceType' => 'required|exists:services,id',
                'appointmentDate' => 'required|date',
                'appointmentTime' => 'required',
                'serviceLocation' => 'required|in:home-service,walk-in',
                'customerAddress' => 'nullable|string',
                'servicePrice' => 'required|numeric|min:0',
                'paymentStatus' => 'sometimes|in:pending,partial,paid',
                'notes' => 'nullable|string',
            ]);

            // Find or create user based on phone number
            $user = User::firstOrCreate(
                ['phone' => $validated['customerPhone']],
                [
                    'name' => $validated['customerName'],
                    'email' => 'customer_' . time() . '@nailedbyvia.com', // Generate temporary email
                    'password' => bcrypt('password123'), // Temporary password
                    'role' => 'customer',
                ]
            );

            // Find service by ID
            $service = Service::findOrFail($validated['serviceType']);

            // Combine date and time
            $appointmentDateTime = $validated['appointmentDate'] . ' ' . $validated['appointmentTime'];

            $appointment = Appointment::create([
                'user_id' => $user->id,
                'service_id' => $service->id,
                'appointment_date' => $appointmentDateTime,
                'location_type' => $validated['serviceLocation'],
                'customer_address' => $validated['customerAddress'],
                'amount' => $validated['servicePrice'],
                'status' => 'pending',
                'payment_status' => $validated['paymentStatus'] ?? 'pending',
                'notes' => $validated['notes'],
            ]);

            Log::info('Admin created new appointment', [
                'admin_id' => Auth::id(),
                'appointment_id' => $appointment->id,
                'customer_name' => $validated['customerName'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment created successfully!',
                'appointment' => $appointment->load(['user', 'service'])
            ]);

        } catch (\Exception $e) {
            Log::error('Admin appointment creation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create appointment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update appointment
     */
    public function update(Request $request, Appointment $appointment): JsonResponse
    {
        try {
            // Check if only status fields are being updated
            $onlyStatusUpdate = $request->has('appointmentStatus') || $request->has('paymentStatus');
            $hasOtherFields = $request->has('customerName') || $request->has('serviceType') || $request->has('appointmentDate');
            
            if ($onlyStatusUpdate && !$hasOtherFields) {
                // Only updating status fields
                $validated = $request->validate([
                    'paymentStatus' => 'sometimes|in:pending,partial,paid',
                    'appointmentStatus' => 'sometimes|in:pending,confirmed,completed,cancelled',
                ]);

                $updateData = [];
                if (isset($validated['appointmentStatus'])) {
                    $updateData['status'] = $validated['appointmentStatus'];
                }
                if (isset($validated['paymentStatus'])) {
                    $updateData['payment_status'] = $validated['paymentStatus'];
                }

                $appointment->update($updateData);

                Log::info('Admin updated appointment status', [
                    'admin_id' => Auth::id(),
                    'appointment_id' => $appointment->id,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Appointment status updated successfully!',
                    'appointment' => $appointment->load(['user', 'service'])
                ]);
            }

            // Full update with all fields
            $validated = $request->validate([
                'customerName' => 'required|string|max:255',
                'customerPhone' => 'required|string|max:20',
                'serviceType' => 'required|exists:services,id',
                'appointmentDate' => 'required|date',
                'appointmentTime' => 'required',
                'serviceLocation' => 'required|in:home-service,walk-in',
                'customerAddress' => 'nullable|string',
                'servicePrice' => 'required|numeric|min:0',
                'paymentStatus' => 'sometimes|in:pending,partial,paid',
                'appointmentStatus' => 'sometimes|in:pending,confirmed,completed,cancelled',
                'notes' => 'nullable|string',
            ]);

            // Update user information
            $user = $appointment->user;
            if ($user) {
                $user->update([
                    'name' => $validated['customerName'],
                    'phone' => $validated['customerPhone'],
                ]);
            }

            // Find service by ID
            $service = Service::findOrFail($validated['serviceType']);

            // Combine date and time
            $appointmentDateTime = $validated['appointmentDate'] . ' ' . $validated['appointmentTime'];

            // Update appointment
            $appointment->update([
                'service_id' => $service->id,
                'appointment_date' => $appointmentDateTime,
                'location_type' => $validated['serviceLocation'],
                'customer_address' => $validated['customerAddress'],
                'amount' => $validated['servicePrice'],
                'status' => $validated['appointmentStatus'] ?? $appointment->status,
                'payment_status' => $validated['paymentStatus'] ?? $appointment->payment_status,
                'notes' => $validated['notes'],
            ]);

            Log::info('Admin updated appointment', [
                'admin_id' => Auth::id(),
                'appointment_id' => $appointment->id,
                'customer_name' => $validated['customerName'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment updated successfully!',
                'appointment' => $appointment->load(['user', 'service'])
            ]);

        } catch (\Exception $e) {
            Log::error('Admin appointment update error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update appointment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update appointment status
     */
    public function updateStatus(Request $request, Appointment $appointment): JsonResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,completed,cancelled',
            ]);

            $oldStatus = $appointment->status;
            $appointment->update(['status' => $validated['status']]);

            Log::info('Admin updated appointment status', [
                'admin_id' => Auth::id(),
                'appointment_id' => $appointment->id,
                'old_status' => $oldStatus,
                'new_status' => $validated['status'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment status updated successfully!',
                'appointment' => $appointment->load(['user', 'service'])
            ]);

        } catch (\Exception $e) {
            Log::error('Admin status update error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update appointment status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, Appointment $appointment): JsonResponse
    {
        try {
            $validated = $request->validate([
                'payment_status' => 'required|in:pending,partial,paid',
            ]);

            $oldPaymentStatus = $appointment->payment_status;
            $appointment->update(['payment_status' => $validated['payment_status']]);

            Log::info('Admin updated payment status', [
                'admin_id' => Auth::id(),
                'appointment_id' => $appointment->id,
                'old_payment_status' => $oldPaymentStatus,
                'new_payment_status' => $validated['payment_status'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully!',
                'appointment' => $appointment->load(['user', 'service'])
            ]);

        } catch (\Exception $e) {
            Log::error('Admin payment status update error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment status: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Delete appointment
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        try {
            $appointmentId = $appointment->id;
            $appointment->delete();

            Log::info('Admin deleted appointment', [
                'admin_id' => Auth::id(),
                'appointment_id' => $appointmentId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Admin appointment deletion error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete appointment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get appointment statistics for dashboard
     */
    public function getStatistics(): JsonResponse
    {
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'total_revenue' => Appointment::where('payment_status', 'paid')->sum('amount'),
            'pending_payments' => Appointment::where('payment_status', 'pending')->count(),
        ];

        return response()->json($stats);
    }
}

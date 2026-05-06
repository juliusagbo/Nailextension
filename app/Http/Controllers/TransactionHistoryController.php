<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get all appointments for the user
        $query = Appointment::where('user_id', $user->id)
            ->with('service')
            ->orderBy('appointment_date', 'desc');
        
        // Note: Status filtering will be applied after mapping appointment status to transaction status
        
        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('service', function($serviceQuery) use ($searchTerm) {
                    $serviceQuery->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhere('location_type', 'like', '%' . $searchTerm . '%')
                ->orWhere('customer_address', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Apply date filter if provided
        if ($request->has('date') && !empty($request->date)) {
            $date = $request->date;
            $query->whereDate('appointment_date', $date);
        }
        
        $appointments = $query->get();
        
        // Transform appointments to transaction format
        $transactions = $appointments->map(function($appointment) {
            return [
                'id' => $appointment->id,
                'transaction_id' => '#NVIA-' . date('Y', strtotime($appointment->appointment_date)) . '-' . str_pad($appointment->id, 4, '0', STR_PAD_LEFT),
                'date' => $appointment->appointment_date,
                'service' => $appointment->service->name ?? 'Service',
                'location' => $this->formatLocation($appointment),
                'amount' => $this->formatAmount($appointment),
                'payment_method' => 'GCash', // Default payment method
                'status' => $this->mapStatus($appointment->status),
                'original_status' => $appointment->status,
                'appointment' => $appointment
            ];
        });
        
        // Apply status filter after mapping (filter by transaction status, not appointment status)
        if ($request->has('status') && $request->status !== 'all') {
            $transactions = $transactions->filter(function($transaction) use ($request) {
                return $transaction['status'] === $request->status;
            });
        }
        
        return view('transaction-history', compact('transactions'));
    }
    
    private function formatLocation($appointment)
    {
        if ($appointment->location_type === 'home-service') {
            return 'Home Service' . ($appointment->customer_address ? ' (' . $appointment->customer_address . ')' : '');
        }
        return 'Walk In';
    }
    
    private function formatAmount($appointment)
    {
        $baseAmount = $appointment->amount ?? 0;
        $transportationFee = 0;
        
        // Add transportation fee for home service
        if ($appointment->location_type === 'home-service' && $appointment->customer_address) {
            if (strpos(strtolower($appointment->customer_address), 'cordova') !== false) {
                $transportationFee = 150;
            } elseif (strpos(strtolower($appointment->customer_address), 'lapu-lapu') !== false) {
                $transportationFee = 250;
            }
        }
        
        if ($transportationFee > 0) {
            return '₱' . number_format($baseAmount) . ' + ₱' . $transportationFee;
        }
        
        return '₱' . number_format($baseAmount);
    }
    
    private function mapStatus($appointmentStatus)
    {
        switch ($appointmentStatus) {
            case 'completed':
                return 'completed';
            case 'cancelled':
                return 'failed';
            case 'pending':
                return 'pending';
            default:
                return 'pending';
        }
    }
}

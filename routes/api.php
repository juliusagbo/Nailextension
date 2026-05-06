<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the 'api' middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/category/{category}', [ServiceController::class, 'getByCategory']);
Route::get('/services/location/{locationType}', [ServiceController::class, 'getByLocation']);

// Protected routes (require authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    // User routes
    Route::get('/user/appointments', [AppointmentController::class, 'getUserAppointments']);
    
    // Admin routes
    Route::middleware(['admin'])->group(function () {
        // Services management
        Route::apiResource('services', ServiceController::class);
        
        // Appointments management
        Route::apiResource('appointments', AppointmentController::class);
        Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus']);
        Route::patch('/appointments/{appointment}/payment-status', [AppointmentController::class, 'updatePaymentStatus']);
        Route::get('/appointments/status/{status}', [AppointmentController::class, 'getByStatus']);
        Route::post('/appointments/date-range', [AppointmentController::class, 'getByDateRange']);
        
        // Users management
        Route::apiResource('users', UserController::class);
        Route::patch('/users/{user}/status', [UserController::class, 'updateStatus']);
        Route::get('/users/customers', [UserController::class, 'getCustomers']);
        Route::get('/users/admins', [UserController::class, 'getAdmins']);
        Route::get('/users/active', [UserController::class, 'getActiveUsers']);
    });
});

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('home');

// Customer appointment routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/book-appointment', [App\Http\Controllers\CustomerController::class, 'bookAppointment'])->name('book.appointment');
    Route::get('/available-slots', [App\Http\Controllers\CustomerController::class, 'getAvailableSlots'])->name('available.slots');
    Route::patch('/appointments/{appointment}/cancel', [App\Http\Controllers\CustomerController::class, 'cancelAppointment'])->name('appointments.cancel.customer');
    Route::patch('/appointments/{appointment}/reschedule', [App\Http\Controllers\CustomerController::class, 'rescheduleAppointment'])->name('appointments.reschedule.customer');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/appointments', [AppointmentController::class, 'index'])->middleware(['auth', 'verified'])->name('appointments');
Route::post('/appointments', [AppointmentController::class, 'store'])->middleware(['auth', 'verified'])->name('appointments.store');
Route::get('/appointments/available-slots', [AppointmentController::class, 'getAvailableTimeSlots'])->middleware(['auth', 'verified'])->name('appointments.available-slots');
Route::put('/appointments/reschedule', [AppointmentController::class, 'reschedule'])->middleware(['auth', 'verified'])->name('appointments.reschedule');
Route::post('/appointments/review', [AppointmentController::class, 'submitReview'])->middleware(['auth', 'verified'])->name('appointments.review');
Route::patch('/appointments/{appointment}/complete', [AppointmentController::class, 'markCompleted'])->middleware(['auth', 'verified'])->name('appointments.complete');
Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'markCancelled'])->middleware(['auth', 'verified'])->name('appointments.cancel');

Route::get('/services', [App\Http\Controllers\ServicesController::class, 'index'])->middleware(['auth', 'verified'])->name('services');

// Public pages (no auth required)
Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/category/{category}', [App\Http\Controllers\GalleryController::class, 'getByCategory'])->name('gallery.category');
Route::get('/gallery/featured', [App\Http\Controllers\GalleryController::class, 'getFeatured'])->name('gallery.featured');
Route::get('/gallery/search', [App\Http\Controllers\GalleryController::class, 'search'])->name('gallery.search');
Route::get('/gallery/categories', [App\Http\Controllers\GalleryController::class, 'getCategories'])->name('gallery.categories');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/favorites', [App\Http\Controllers\FavoritesController::class, 'index'])->middleware(['auth', 'verified'])->name('favorites');
Route::post('/favorites/toggle', [App\Http\Controllers\FavoritesController::class, 'toggle'])->middleware(['auth', 'verified'])->name('favorites.toggle');
Route::delete('/favorites/remove', [App\Http\Controllers\FavoritesController::class, 'remove'])->middleware(['auth', 'verified'])->name('favorites.remove');
Route::get('/favorites/count', [App\Http\Controllers\FavoritesController::class, 'count'])->middleware(['auth', 'verified'])->name('favorites.count');

Route::get('/transaction-history', [App\Http\Controllers\TransactionHistoryController::class, 'index'])->middleware(['auth', 'verified'])->name('transaction-history');

Route::get('/profile-settings', function () {
    return view('profile-settings');
})->middleware(['auth', 'verified'])->name('profile-settings');

Route::get('/faqs', function () {
    return view('faqs');
})->middleware(['auth', 'verified'])->name('faqs');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update.picture');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [App\Http\Controllers\AdminController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\AdminController::class, 'login'])->name('login');
    Route::post('logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('logout');
    
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('dashboard/stats', [App\Http\Controllers\AdminController::class, 'getDashboardStats'])->name('dashboard.stats');
        Route::get('users', [App\Http\Controllers\AdminController::class, 'customers'])->name('users');
        Route::get('appointments', [App\Http\Controllers\AdminAppointmentController::class, 'index'])->name('appointments');
                    Route::get('services', [App\Http\Controllers\AdminServiceController::class, 'index'])->name('services');
        Route::get('settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
        Route::post('settings/update-all', [App\Http\Controllers\SettingsController::class, 'updateAllSettings'])->name('settings.update-all');
        Route::post('settings/business-info', [App\Http\Controllers\SettingsController::class, 'updateBusinessInfo'])->name('settings.business-info');
        Route::post('settings/business-hours', [App\Http\Controllers\SettingsController::class, 'updateBusinessHours'])->name('settings.business-hours');
        Route::post('settings/security', [App\Http\Controllers\SettingsController::class, 'updateSecuritySettings'])->name('settings.security');
        Route::get('settings/api', [App\Http\Controllers\SettingsController::class, 'getSettings'])->name('settings.api');
        Route::post('settings/reset', [App\Http\Controllers\SettingsController::class, 'resetToDefault'])->name('settings.reset');
        Route::get('reports', [App\Http\Controllers\AnalyticsController::class, 'index'])->name('reports');
        Route::get('reports/api', [App\Http\Controllers\AnalyticsController::class, 'getAnalyticsJson'])->name('reports.api');
        Route::get('activity-log', [App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-log');
        Route::get('activity-log/statistics', [App\Http\Controllers\ActivityLogController::class, 'getStatistics'])->name('activity-log.statistics');
        Route::get('activity-log/recent', [App\Http\Controllers\ActivityLogController::class, 'getRecentActivities'])->name('activity-log.recent');
        Route::get('activity-log/export', [App\Http\Controllers\ActivityLogController::class, 'export'])->name('activity-log.export');
        
        // Admin service management routes
        Route::prefix('services')->name('services.')->group(function () {
            Route::post('store', [App\Http\Controllers\AdminServiceController::class, 'store'])->name('store');
            Route::put('{service}', [App\Http\Controllers\AdminServiceController::class, 'update'])->name('update');
            Route::delete('{service}', [App\Http\Controllers\AdminServiceController::class, 'destroy'])->name('destroy');
            Route::get('statistics', [App\Http\Controllers\AdminServiceController::class, 'getStatistics'])->name('statistics');
        });
        
        // Admin appointment management routes
        Route::prefix('appointments')->name('appointments.')->group(function () {
            Route::get('all', [App\Http\Controllers\AdminAppointmentController::class, 'getAllAppointments'])->name('all');
            Route::get('status/{status}', [App\Http\Controllers\AdminAppointmentController::class, 'getByStatus'])->name('by-status');
            Route::post('date-range', [App\Http\Controllers\AdminAppointmentController::class, 'getByDateRange'])->name('by-date-range');
            Route::post('search', [App\Http\Controllers\AdminAppointmentController::class, 'search'])->name('search');
            Route::post('store', [App\Http\Controllers\AdminAppointmentController::class, 'store'])->name('store');
            Route::patch('{appointment}/status', [App\Http\Controllers\AdminAppointmentController::class, 'updateStatus'])->name('update-status');
            Route::patch('{appointment}/payment-status', [App\Http\Controllers\AdminAppointmentController::class, 'updatePaymentStatus'])->name('update-payment-status');
            Route::put('{appointment}', [App\Http\Controllers\AdminAppointmentController::class, 'update'])->name('update');
            Route::delete('{appointment}', [App\Http\Controllers\AdminAppointmentController::class, 'destroy'])->name('destroy');
            Route::get('statistics', [App\Http\Controllers\AdminAppointmentController::class, 'getStatistics'])->name('statistics');
        });
        
        // Admin customer management routes
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('all', [App\Http\Controllers\UserController::class, 'getCustomers'])->name('all');
            Route::post('store', [App\Http\Controllers\UserController::class, 'store'])->name('store');
            Route::put('{user}', [App\Http\Controllers\UserController::class, 'update'])->name('update');
            Route::delete('{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
            Route::patch('{user}/status', [App\Http\Controllers\UserController::class, 'updateStatus'])->name('update-status');
        });
        
        // Admin gallery management routes
        Route::prefix('gallery')->name('gallery.')->group(function () {
            Route::get('/', [App\Http\Controllers\AdminGalleryController::class, 'index'])->name('index');
            Route::get('create', [App\Http\Controllers\AdminGalleryController::class, 'create'])->name('create');
            Route::post('store', [App\Http\Controllers\AdminGalleryController::class, 'store'])->name('store');
            Route::get('{gallery}/edit', [App\Http\Controllers\AdminGalleryController::class, 'edit'])->name('edit');
            Route::put('{gallery}', [App\Http\Controllers\AdminGalleryController::class, 'update'])->name('update');
            Route::delete('{gallery}', [App\Http\Controllers\AdminGalleryController::class, 'destroy'])->name('destroy');
            Route::patch('{gallery}/toggle-status', [App\Http\Controllers\AdminGalleryController::class, 'toggleStatus'])->name('toggle-status');
            Route::patch('{gallery}/toggle-featured', [App\Http\Controllers\AdminGalleryController::class, 'toggleFeatured'])->name('toggle-featured');
        });
    });
    
    Route::get('forgot-password', [App\Http\Controllers\AdminController::class, 'showPasswordResetForm'])->name('password.request');
    Route::post('forgot-password', [App\Http\Controllers\AdminController::class, 'sendPasswordResetLink'])->name('password.email');
});

require __DIR__.'/auth.php';

@extends('layouts.app')

@section('content')
<style>
    body, .dashboard-bg { background: #f7f7f7 !important; }
    .sidebar {
        width: 240px;
        background: #fff;
        min-height: 100vh;
        box-shadow: 1px 0 8px #eee;
        padding: 32px 0 0 0;
        position: fixed;
        left: 0; top: 0; bottom: 0;
        z-index: 10;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .sidebar .profile-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
    }
    .sidebar .profile-name {
        font-weight: 700;
        color: #b48b8b;
        font-size: 18px;
        margin-bottom: 2px;
    }
    .sidebar .profile-email {
        font-size: 13px;
        color: #b48b8b;
        margin-bottom: 24px;
    }
    .sidebar-nav {
        width: 100%;
        margin-bottom: auto;
    }
    .sidebar-nav a {
        display: flex;
        align-items: center;
        padding: 12px 32px;
        color: #b48b8b;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.2s;
    }
    .sidebar-nav a.active, .sidebar-nav a:hover {
        background: #f7eaea;
        color: #a07a7a;
        border-right: 4px solid #b48b8b;
    }
    .sidebar .logout {
        color: #b48b8b;
        font-weight: 600;
        margin: 32px 0 0 0;
        padding: 12px 32px;
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    .dashboard-content {
        margin-left: 240px;
        padding: 32px 48px;
        min-height: 100vh;
        background: #f7f7f7;
    }
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .dashboard-header .search-bar {
        background: #fff;
        border-radius: 20px;
        padding: 6px 16px;
        border: 1px solid #e5cfd1;
        display: flex;
        align-items: center;
        width: 260px;
    }
    .dashboard-header input {
        border: none;
        outline: none;
        background: transparent;
        width: 100%;
        color: #b48b8b;
    }
    .tabs-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px #eee;
        margin-bottom: 24px;
        padding: 16px;
    }
    .appointment-tabs {
        display: flex;
        gap: 8px;
        border-bottom: 1px solid #f0e0e0;
        margin-bottom: 24px;
    }
    .appointment-tabs a {
        padding: 8px 16px;
        color: #b48b8b;
        text-decoration: none;
        border-radius: 20px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .appointment-tabs a.active {
        background: #b48b8b;
        color: #fff;
    }
    .appointment-tabs a:hover:not(.active) {
        background: #f7eaea;
    }
    .appointments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
    }
    .appointment-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px #eee;
        padding: 20px;
        color: #b48b8b;
    }
    .appointment-card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .appointment-card .date-time {
        font-size: 14px;
        color: #a07a7a;
    }
    .status-badge {
        border-radius: 12px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-upcoming {
        background: #e3f2fd;
        color: #2196f3;
    }
    .status-completed {
        background: #e0f7e9;
        color: #43a047;
    }
    .status-cancelled {
        background: #ffebee;
        color: #f44336;
    }
    .appointment-card .service-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .appointment-card .details {
        font-size: 14px;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
    }
    .appointment-card .details i {
        margin-right: 8px;
        font-size: 16px;
    }
    .appointment-card .actions {
        margin-top: 16px;
        display: flex;
        gap: 8px;
    }
    .action-btn {
        border: none;
        border-radius: 12px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .action-reschedule { background: #b48b8b; color: #fff; }
    .action-cancel { background: #fff; color: #b48b8b; border: 1px solid #b48b8b; }
    .action-details { background: #fff; color: #b48b8b; border: 1px solid #b48b8b; }
    .action-rate { background: #fff; color: #b48b8b; border: 1px solid #b48b8b; }
    .action-rebook { background: #b48b8b; color: #fff; }
    
    /* Additional Modal Styles */
    .appointment-details {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #495057;
        min-width: 120px;
    }
    
    .detail-value {
        color: #6c757d;
        text-align: right;
        flex: 1;
        margin-left: 16px;
    }
    
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        gap: 4px;
    }
    
    .rating-stars input[type="radio"] {
        display: none;
    }
    
    .rating-stars .star {
        font-size: 32px;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s ease;
    }
    
    .rating-stars .star:hover,
    .rating-stars .star:hover ~ .star,
    .rating-stars input[type="radio"]:checked ~ .star {
        color: #ffd700;
    }
    
    .char-count {
        text-align: right;
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
    }
    
    .radio-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .radio-option {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    
    .radio-option input[type="radio"] {
        margin: 0;
    }
    
    .radio-option span {
        color: #495057;
    }
    
    /* Mobile Menu Button */
    .mobile-menu-btn {
        display: none;
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1002;
        background: #b48b8b;
        border: none;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .mobile-menu-btn:hover {
        background: #a07a7a;
    }
    
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
    }
    
    .sidebar-overlay.active {
        display: block;
    }
    
    /* Tablet Styles */
    @media (max-width: 1024px) {
        .sidebar {
            width: 220px;
        }
        .dashboard-content {
            margin-left: 220px;
            padding: 24px 32px;
        }
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        .dashboard-header > div:last-child {
            width: 100%;
            justify-content: space-between;
        }
        .dashboard-header .search-bar {
            flex: 1;
            max-width: 400px;
        }
        .appointments-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }
    
    /* Mobile Styles */
    @media (max-width: 768px) {
        .mobile-menu-btn {
            display: block;
        }
        
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        
        .sidebar.mobile-open {
            transform: translateX(0);
        }
        
        .dashboard-content {
            margin-left: 0;
            padding: 70px 16px 16px;
        }
        
        .dashboard-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        
        .dashboard-header > div:first-child {
            font-size: 16px !important;
        }
        
        .dashboard-header .search-bar {
            width: 100%;
            max-width: 100%;
        }
        
        .tabs-container {
            padding: 12px;
            margin-bottom: 20px;
        }
        
        .appointment-tabs {
            overflow-x: auto;
            padding-bottom: 8px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #b48b8b #f0f0f0;
        }
        
        .appointment-tabs::-webkit-scrollbar {
            height: 4px;
        }
        
        .appointment-tabs::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 4px;
        }
        
        .appointment-tabs::-webkit-scrollbar-thumb {
            background: #b48b8b;
            border-radius: 4px;
        }
        
        .appointment-tabs a {
            white-space: nowrap;
            flex-shrink: 0;
            font-size: 13px;
            padding: 7px 14px;
        }
        
        .appointments-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .appointment-card {
            padding: 16px;
        }
        
        .appointment-card .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 10px;
        }
        
        .appointment-card .date-time {
            font-size: 13px;
        }
        
        .appointment-card .service-name {
            font-size: 15px;
        }
        
        .appointment-card .details {
            font-size: 13px;
        }
        
        .appointment-card .actions {
            flex-wrap: wrap;
            margin-top: 12px;
        }
        
        .action-btn {
            font-size: 11px;
            padding: 5px 10px;
        }
    }
    
    @media (max-width: 480px) {
        .dashboard-content {
            padding: 60px 12px 12px;
        }
        
        .dashboard-header > div:first-child {
            font-size: 15px !important;
        }
        
        .tabs-container {
            padding: 10px;
        }
        
        .appointment-tabs a {
            font-size: 12px;
            padding: 6px 12px;
        }
        
        .appointment-card {
            padding: 14px;
        }
        
        .appointment-card .service-name {
            font-size: 14px;
        }
        
        .appointment-card .details {
            font-size: 12px;
        }
        
        .action-btn {
            font-size: 11px;
            padding: 4px 8px;
        }
    }
</style>
<div class="dashboard-bg">
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <span class="material-icons" style="font-size: 20px;">menu</span>
    </button>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="sidebar" id="sidebar">
        @php $profilePic = Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/noprofile.png'); @endphp
        <img src="{{ $profilePic }}" class="profile-img" alt="Profile">
        <div class="profile-name">{{ Auth::user()->name }}</div>
        <div class="profile-email">{{ Auth::user()->email }}</div>
        <nav class="sidebar-nav">
            <a href="{{ url('/dashboard') }}">Home</a>
            <a href="{{ url('/appointments') }}" class="active">Appointments</a>
            <a href="{{ url('/services') }}">Services</a>
            <a href="{{ url('/favorites') }}">Favorites</a>
            <a href="{{ url('/transaction-history') }}">Transaction History</a>
            <a href="{{ url('/profile-settings') }}" >Profile Settings</a>
            <a href="{{ url('/faqs') }}">FAQs</a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" style="width:100%;">
            @csrf
            <button type="submit" class="logout" style="width:100%;text-align:left;background:none;border:none;padding:12px 32px;cursor:pointer;">Logout</button>
        </form>
    </div>
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div style="font-weight:600; color:#b48b8b; font-size:18px;">My Appointments</div>
            <div style="display:flex; align-items:center;">
                <div class="search-bar">
                    <input type="text" placeholder="Search appointments...">
                    <span class="material-icons" style="font-size:18px;">search</span>
                </div>
            </div>
        </div>
        
        <div class="tabs-container">
            @php
                $status = request('status', 'All');
                $filtered = $status === 'All' ? $appointments : $appointments->where('status', strtolower($status));
            @endphp
            <div class="appointment-tabs">
                <a href="?status=All" class="{{ $status === 'All' ? 'active' : '' }}">All Appointments</a>
                <a href="?status=Pending" class="{{ $status === 'Pending' ? 'active' : '' }}">Upcoming</a>
                <a href="?status=Completed" class="{{ $status === 'Completed' ? 'active' : '' }}">Completed</a>
                <a href="?status=Cancelled" class="{{ $status === 'Cancelled' ? 'active' : '' }}">Cancelled</a>
            </div>
            
            <div class="appointments-grid">
                @forelse($filtered as $appointment)
                <div class="appointment-card">
                    <div class="card-header">
                        <div class="date-time">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y \a\t h:i A') }}</div>
                        <span class="status-badge 
                            @if($appointment->status == 'pending') status-upcoming
                            @elseif($appointment->status == 'completed') status-completed
                            @elseif($appointment->status == 'cancelled') status-cancelled
                                    @endif
                                ">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                    <div class="service-name">{{ $appointment->service->name ?? 'Service' }}</div>
                    <div class="details">
                        <span class="material-icons">location_on</span>
                        {{ $appointment->location_type }}
                        @if($appointment->customer_address)
                            ({{ $appointment->customer_address }})
                        @endif
                    </div>
                    <div class="details">
                        <span class="material-icons">payment</span>
                        ₱{{ $appointment->amount }}
                    </div>
                    @if($appointment->notes)
                    <div class="details">
                        <span class="material-icons">note</span>
                        {{ $appointment->notes }}
                    </div>
                    @endif
                    <div class="actions">
                                @if($appointment->status == 'pending')
                            <button type="button" class="action-btn action-reschedule" data-appointment-id="{{ $appointment->id }}" data-service-name="{{ $appointment->service->name ?? 'Service' }}" data-appointment-date="{{ $appointment->appointment_date }}" data-appointment-time="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') }}" data-location-type="{{ $appointment->location_type }}" data-customer-address="{{ $appointment->customer_address ?? '' }}" data-notes="{{ $appointment->notes ?? '' }}">Reschedule</button>
                            <form method="POST" action="{{ route('appointments.complete', $appointment) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn action-details">Mark as Completed</button>
                            </form>
                            <form method="POST" action="{{ route('appointments.cancel', $appointment) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn action-cancel">Cancel</button>
                            </form>
                                @elseif($appointment->status == 'completed')
                            <button type="button" class="action-btn action-details" data-appointment-id="{{ $appointment->id }}" data-service-name="{{ $appointment->service->name ?? 'Service' }}" data-appointment-date="{{ $appointment->appointment_date }}" data-location-type="{{ $appointment->location_type }}" data-customer-address="{{ $appointment->customer_address ?? '' }}" data-notes="{{ $appointment->notes ?? '' }}" data-amount="{{ $appointment->amount ?? 0 }}">Details</button>
                            <button type="button" class="action-btn action-rate" data-appointment-id="{{ $appointment->id }}" data-service-name="{{ $appointment->service->name ?? 'Service' }}" data-appointment-date="{{ $appointment->appointment_date }}" data-location-type="{{ $appointment->location_type }}" data-customer-address="{{ $appointment->customer_address ?? '' }}" data-notes="{{ $appointment->notes ?? '' }}" data-amount="{{ $appointment->amount ?? 0 }}">Rate</button>
                                @elseif($appointment->status == 'cancelled')
                            <button type="button" class="action-btn action-rebook" data-appointment-id="{{ $appointment->id }}" data-service-name="{{ $appointment->service->name ?? 'Service' }}" data-appointment-date="{{ $appointment->appointment_date }}" data-location-type="{{ $appointment->location_type }}" data-customer-address="{{ $appointment->customer_address ?? '' }}" data-notes="{{ $appointment->notes ?? '' }}" data-amount="{{ $appointment->amount ?? 0 }}" data-service-id="{{ $appointment->service_id ?? 1 }}">Rebook</button>
                                @endif
                    </div>
                </div>
                @empty
                <div style="color:#b48b8b;font-size:16px;text-align:center;width:100%;padding:32px;">No appointments found.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Reschedule Modal -->
<div class="modal-overlay" id="rescheduleModal">
    <div class="booking-modal">
        <div class="modal-header">
            <div class="modal-title">
                <span class="material-icons">schedule</span>
                Reschedule Appointment
            </div>
            <button class="close-btn" onclick="closeRescheduleModal()">
                <span class="material-icons">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('appointments.reschedule') }}" id="rescheduleForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="appointment_id" id="reschedule_appointment_id">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

            <div class="form-section">
                <h3>Current Appointment Details</h3>
                <div class="current-appointment-details">
                    <div class="detail-item">
                        <span class="detail-label">Service:</span>
                        <span class="detail-value" id="currentService">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Current Date & Time:</span>
                        <span class="detail-value" id="currentDateTime">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Location:</span>
                        <span class="detail-value" id="currentLocation">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Notes:</span>
                        <span class="detail-value" id="currentNotes">-</span>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>New Appointment Details</h3>
                <div class="form-group">
                    <label for="new_appointment_date">New Date</label>
                    <div class="input-with-icon">
                        <input type="date" id="new_appointment_date" name="new_appointment_date" required>
                        <span class="material-icons">calendar_today</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="new_appointment_time">New Time</label>
                    <div class="input-with-icon">
                        <input type="time" id="new_appointment_time" name="new_appointment_time" required>
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="reschedule_reason">Reason for Rescheduling</label>
                    <textarea id="reschedule_reason" name="reschedule_reason" placeholder="Please provide a reason for rescheduling..." required></textarea>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closeRescheduleModal()">Cancel</button>
                <button type="submit" class="confirm-btn">Confirm Reschedule</button>
            </div>
        </form>
    </div>
</div>

<!-- Details Modal -->
<div class="modal-overlay" id="detailsModal">
    <div class="booking-modal">
        <div class="modal-header">
            <div class="modal-title">
                <span class="material-icons">info</span>
                Appointment Details
            </div>
            <button class="close-btn" onclick="closeDetailsModal()">
                <span class="material-icons">close</span>
            </button>
        </div>
        
        <div class="form-section">
            <h3>Appointment Information</h3>
            <div class="appointment-details">
                <div class="detail-item">
                    <span class="detail-label">Service:</span>
                    <span class="detail-value" id="detailService">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Date & Time:</span>
                    <span class="detail-value" id="detailDateTime">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Location:</span>
                    <span class="detail-value" id="detailLocation">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Amount Paid:</span>
                    <span class="detail-value" id="detailAmount">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" id="detailStatus">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Notes:</span>
                    <span class="detail-value" id="detailNotes">-</span>
                </div>
            </div>
        </div>
        
        <div class="modal-actions">
            <button type="button" class="cancel-btn" onclick="closeDetailsModal()">Close</button>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div class="modal-overlay" id="reviewModal">
    <div class="booking-modal">
        <div class="modal-header">
            <div class="modal-title">
                <span class="material-icons">rate_review</span>
                Rate Your Appointment
            </div>
            <button class="close-btn" onclick="closeReviewModal()">
                <span class="material-icons">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('appointments.review') }}" id="reviewForm">
            @csrf
            <input type="hidden" name="appointment_id" id="review_appointment_id">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

            <div class="form-section">
                <h3>Appointment Details</h3>
                <div class="appointment-details">
                    <div class="detail-item">
                        <span class="detail-label">Service:</span>
                        <span class="detail-value" id="reviewService">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date & Time:</span>
                        <span class="detail-value" id="reviewDateTime">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Location:</span>
                        <span class="detail-value" id="reviewLocation">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Amount Paid:</span>
                        <span class="detail-value" id="reviewAmount">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Notes:</span>
                        <span class="detail-value" id="reviewNotes">-</span>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Your Rating</h3>
                <div class="form-group">
                    <label for="rating">Overall Rating *</label>
                    <div class="rating-stars">
                        <input type="radio" id="star5" name="rating" value="5" required>
                        <label for="star5" class="star">★</label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4" class="star">★</label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3" class="star">★</label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2" class="star">★</label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1" class="star">★</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="review_title">Review Title *</label>
                    <input type="text" id="review_title" name="review_title" placeholder="Brief summary of your experience..." required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label for="review_comment">Detailed Review *</label>
                    <textarea id="review_comment" name="review_comment" placeholder="Share your experience, what you liked, and any suggestions for improvement..." required minlength="20" maxlength="500" rows="4"></textarea>
                    <div class="char-count">
                        <span id="charCount">0</span>/500 characters
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="recommend_service">Would you recommend this service?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="recommend_service" value="yes" checked>
                            <span>Yes, definitely!</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="recommend_service" value="maybe">
                            <span>Maybe, with some improvements</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="recommend_service" value="no">
                            <span>No, not really</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closeReviewModal()">Cancel</button>
                <button type="submit" class="confirm-btn">Submit Review</button>
            </div>
        </form>
    </div>
</div>

<!-- Rebook Modal -->
<div class="modal-overlay" id="rebookModal">
    <div class="booking-modal">
        <div class="modal-header">
            <div class="modal-title">
                <span class="material-icons">event</span>
                Rebook Appointment
            </div>
            <button class="close-btn" onclick="closeRebookModal()">
                <span class="material-icons">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('appointments.store') }}" id="rebookForm">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <input type="hidden" name="service_id" id="rebook_service_id">
            <input type="hidden" name="amount" id="rebook_amount">

            <div class="form-section">
                <h3>Previous Appointment Details</h3>
                <div class="appointment-details">
                    <div class="detail-item">
                        <span class="detail-label">Service:</span>
                        <span class="detail-value" id="rebookService">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Previous Date:</span>
                        <span class="detail-value" id="rebookPreviousDate">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Amount:</span>
                        <span class="detail-value" id="rebookAmount">-</span>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>New Appointment Details</h3>
                <div class="form-group">
                    <label for="rebook_appointment_date">Preferred Date *</label>
                    <div class="input-with-icon">
                        <input type="date" id="rebook_appointment_date" name="appointment_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        <span class="material-icons">calendar_today</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="rebook_appointment_time">Preferred Time *</label>
                    <div class="input-with-icon">
                        <input type="time" id="rebook_appointment_time" name="appointment_time" required>
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="rebook_location_type">Location Type *</label>
                    <div class="input-with-icon">
                        <select id="rebook_location_type" name="location_type" required>
                            <option value="walk-in">Walk In</option>
                            <option value="home-service">Home Service</option>
                        </select>
                        <span class="material-icons">location_on</span>
                    </div>
                </div>
                
                <div class="form-group" id="rebookAddressGroup" style="display: none;">
                    <label for="rebook_customer_address">Home Address</label>
                    <textarea id="rebook_customer_address" name="customer_address" placeholder="Enter your home address for home service..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="rebook_notes">Additional Notes</label>
                    <textarea id="rebook_notes" name="notes" placeholder="Any special requests or notes..."></textarea>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closeRebookModal()">Cancel</button>
                <button type="submit" class="confirm-btn">Book Appointment</button>
            </div>
        </form>
    </div>
</div>

<!-- Google Material Icons CDN for icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
/* Modal Styles for Appointments Page */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.booking-modal {
    background: #fff;
    border-radius: 12px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 24px 0 24px;
    border-bottom: 1px solid #e5cfd1;
    margin-bottom: 24px;
}

.modal-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
    color: #b48b8b;
    font-size: 18px;
}

.close-btn {
    background: none;
    border: none;
    color: #b48b8b;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: background 0.2s;
}

.close-btn:hover {
    background: #f7eaea;
}

.form-section {
    margin-bottom: 24px;
    padding: 0 24px;
}

.form-section h3 {
    color: #a07a7a;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 16px;
}

.form-group {
    margin-bottom: 16px;
}

.form-group label {
    display: block;
    color: #b48b8b;
    font-weight: 500;
    margin-bottom: 6px;
    font-size: 14px;
}

.input-with-icon {
    position: relative;
    display: flex;
    align-items: center;
}

.input-with-icon input,
.input-with-icon select {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e5cfd1;
    border-radius: 8px;
    font-size: 14px;
    color: #b48b8b;
    background: #fff;
    outline: none;
    transition: border-color 0.2s;
}

.input-with-icon input:focus,
.input-with-icon select:focus {
    border-color: #b48b8b;
}

.input-with-icon .material-icons {
    position: absolute;
    right: 12px;
    color: #b48b8b;
    font-size: 18px;
    pointer-events: none;
}

textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e5cfd1;
    border-radius: 8px;
    font-size: 14px;
    color: #b48b8b;
    background: #fff;
    outline: none;
    resize: vertical;
    min-height: 80px;
    font-family: inherit;
    transition: border-color 0.2s;
}

textarea:focus {
    border-color: #b48b8b;
}

.current-appointment-details {
    background: #f9f9f9;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    font-size: 14px;
    color: #a07a7a;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.detail-item .detail-label {
    font-weight: 500;
    color: #b48b8b;
}

.detail-item .detail-value {
    text-align: right;
    color: #a07a7a;
}

.modal-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding: 0 24px 24px 24px;
}

.cancel-btn {
    background: transparent;
    border: 1px solid #b48b8b;
    color: #b48b8b;
    border-radius: 20px;
    padding: 12px 24px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
}

.confirm-btn {
    background: #b48b8b;
    color: #fff;
    border: none;
    border-radius: 20px;
    padding: 12px 24px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
}

/* Modal Responsive Styles */
@media (max-width: 768px) {
    .booking-modal {
        width: 95%;
        max-height: 85vh;
    }
    
    .modal-header {
        padding: 20px 16px 0 16px;
        margin-bottom: 20px;
    }
    
    .modal-title {
        font-size: 16px;
    }
    
    .form-section {
        padding: 0 16px;
        margin-bottom: 20px;
    }
    
    .form-section h3 {
        font-size: 15px;
    }
    
    .form-group label {
        font-size: 13px;
    }
    
    .input-with-icon input,
    .input-with-icon select,
    textarea {
        font-size: 13px;
        padding: 10px 12px;
    }
    
    .current-appointment-details,
    .appointment-details {
        padding: 12px;
    }
    
    .detail-item {
        font-size: 13px;
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    .detail-value {
        text-align: left;
        margin-left: 0;
    }
    
    .modal-actions {
        padding: 0 16px 20px 16px;
        flex-direction: column-reverse;
        gap: 10px;
    }
    
    .cancel-btn,
    .confirm-btn {
        width: 100%;
        justify-content: center;
        padding: 10px 20px;
        font-size: 13px;
    }
    
    .rating-stars {
        justify-content: center;
    }
    
    .rating-stars .star {
        font-size: 28px;
    }
}

@media (max-width: 480px) {
    .booking-modal {
        width: 100%;
        max-width: 100%;
        border-radius: 0;
        max-height: 100vh;
    }
    
    .modal-title {
        font-size: 15px;
    }
    
    .form-group label {
        font-size: 12px;
    }
    
    .input-with-icon input,
    .input-with-icon select,
    textarea {
        font-size: 12px;
    }
    
    .detail-item {
        font-size: 12px;
    }
    
    .rating-stars .star {
        font-size: 24px;
    }
}
</style>

<script>
// Mobile menu functionality
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');

function toggleSidebar() {
    sidebar.classList.toggle('mobile-open');
    sidebarOverlay.classList.toggle('active');
    document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
}

if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', toggleSidebar);
}

if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', toggleSidebar);
}

// Close sidebar when clicking on a link (for mobile)
if (window.innerWidth <= 768) {
    document.querySelectorAll('.sidebar-nav a').forEach(link => {
        link.addEventListener('click', () => {
            if (sidebar.classList.contains('mobile-open')) {
                toggleSidebar();
            }
        });
    });
}

// Reschedule Modal Functions
function openRescheduleModal(appointmentId, serviceName, appointmentDate, appointmentTime, locationType, customerAddress, notes) {
    // Set the appointment ID in the hidden field
    document.getElementById('reschedule_appointment_id').value = appointmentId;
    
    // Populate current appointment details
    document.getElementById('currentService').textContent = serviceName;
    document.getElementById('currentDateTime').textContent = formatDateTime(appointmentDate, appointmentTime);
    document.getElementById('currentLocation').textContent = formatLocation(locationType, customerAddress);
    document.getElementById('currentNotes').textContent = notes || 'None';
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('new_appointment_date').min = today;
    
    // Show the modal
    document.getElementById('rescheduleModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeRescheduleModal() {
    document.getElementById('rescheduleModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Reset the form
    document.getElementById('rescheduleForm').reset();
}

// Close reschedule modal when clicking outside
document.getElementById('rescheduleModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRescheduleModal();
    }
});

function formatDateTime(date, time) {
    const dateObj = new Date(date + 'T' + time);
    return dateObj.toLocaleDateString('en-US', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    }) + ' at ' + dateObj.toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
}

function formatLocation(locationType, address) {
    if (locationType === 'home-service') {
        return 'Home Service' + (address ? ` (${address})` : '');
    } else {
        return 'Walk In';
    }
}

// Add form submission handler for reschedule form
document.addEventListener('DOMContentLoaded', function() {
    const rescheduleForm = document.getElementById('rescheduleForm');
    if (rescheduleForm) {
        rescheduleForm.addEventListener('submit', function(e) {
            const newDate = document.getElementById('new_appointment_date').value;
            const newTime = document.getElementById('new_appointment_time').value;
            const reason = document.getElementById('reschedule_reason').value;
            
            // Clear previous error messages
            clearValidationErrors();
            
            let hasErrors = false;
            
            // Validate required fields
            if (!newDate) {
                showFieldError('new_appointment_date', 'Please select a new date.');
                hasErrors = true;
            }
            
            if (!newTime) {
                showFieldError('new_appointment_time', 'Please select a new time.');
                hasErrors = true;
            }
            
            if (!reason.trim()) {
                showFieldError('reschedule_reason', 'Please provide a reason for rescheduling.');
                hasErrors = true;
            } else if (reason.trim().length < 10) {
                showFieldError('reschedule_reason', 'Reason must be at least 10 characters long.');
                hasErrors = true;
            }
            
            if (hasErrors) {
                e.preventDefault();
                return false;
            }
            
            // Check if the new date and time is in the future
            const selectedDateTime = new Date(newDate + 'T' + newTime);
            const now = new Date();
            
            if (selectedDateTime <= now) {
                e.preventDefault();
                alert('Please select a future date and time for your appointment.');
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
            
            // Re-enable button after 5 seconds in case of error
            setTimeout(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });
    }
});

function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (field) {
        field.style.borderColor = '#f44336';
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#f44336';
        errorDiv.style.fontSize = '12px';
        errorDiv.style.marginTop = '4px';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    }
}

function clearValidationErrors() {
    // Clear all field errors
    document.querySelectorAll('.field-error').forEach(error => error.remove());
    document.querySelectorAll('.input-with-icon input, .input-with-icon select, textarea').forEach(field => {
        field.style.borderColor = '#e5cfd1';
    });
}

// Details Modal Functions
function openDetailsModal(appointmentId, serviceName, appointmentDate, locationType, customerAddress, notes, amount) {
    console.log('openDetailsModal called with:', { appointmentId, serviceName, appointmentDate, locationType, customerAddress, notes, amount });
    
    try {
        // Populate appointment details
        const serviceField = document.getElementById('detailService');
        const dateTimeField = document.getElementById('detailDateTime');
        const locationField = document.getElementById('detailLocation');
        const amountField = document.getElementById('detailAmount');
        const statusField = document.getElementById('detailStatus');
        const notesField = document.getElementById('detailNotes');
        
        if (serviceField) serviceField.textContent = serviceName || 'Service';
        if (dateTimeField) dateTimeField.textContent = formatDetailsDateTime(appointmentDate);
        if (locationField) locationField.textContent = formatLocation(locationType, customerAddress);
        if (amountField) amountField.textContent = '₱' + (parseFloat(amount || 0)).toFixed(2);
        if (statusField) statusField.textContent = 'Completed';
        if (notesField) notesField.textContent = notes || 'None';
        
        // Show the modal
        const modal = document.getElementById('detailsModal');
        if (modal) {
            console.log('Found details modal, showing it...');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            console.error('Details modal not found!');
            alert('Details modal not found!');
        }
    } catch (error) {
        console.error('Error in openDetailsModal:', error);
        alert('Error opening details modal: ' + error.message);
    }
}

function closeDetailsModal() {
    document.getElementById('detailsModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Review Modal Functions
function openReviewModal(appointmentId, serviceName, appointmentDate, locationType, customerAddress, notes, amount) {
    console.log('openReviewModal called with:', { appointmentId, serviceName, appointmentDate, locationType, customerAddress, notes, amount });
    
    try {
        // Set the appointment ID in the hidden field
        const appointmentIdField = document.getElementById('review_appointment_id');
        if (appointmentIdField) {
            appointmentIdField.value = appointmentId;
        } else {
            console.error('review_appointment_id field not found');
        }
        
        // Populate appointment details
        const serviceField = document.getElementById('reviewService');
        const dateTimeField = document.getElementById('reviewDateTime');
        const locationField = document.getElementById('reviewLocation');
        const amountField = document.getElementById('reviewAmount');
        const notesField = document.getElementById('reviewNotes');
        
        if (serviceField) serviceField.textContent = serviceName || 'Service';
        if (dateTimeField) dateTimeField.textContent = formatDetailsDateTime(appointmentDate);
        if (locationField) locationField.textContent = formatLocation(locationType, customerAddress);
        if (amountField) amountField.textContent = '₱' + (parseFloat(amount || 0)).toFixed(2);
        if (notesField) notesField.textContent = notes || 'None';
        
        // Show the modal
        const modal = document.getElementById('reviewModal');
        if (modal) {
            console.log('Found review modal, showing it...');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            console.error('Review modal not found!');
            alert('Review modal not found!');
        }
    } catch (error) {
        console.error('Error in openReviewModal:', error);
        alert('Error opening review modal: ' + error.message);
    }
}

function closeReviewModal() {
    document.getElementById('reviewModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Reset the form
    document.getElementById('reviewForm').reset();
    // Reset character count
    document.getElementById('charCount').textContent = '0';
}

// Rebook Modal Functions
function openRebookModal(appointmentId, serviceName, appointmentDate, locationType, customerAddress, notes, amount, serviceId) {
    console.log('openRebookModal called with:', { appointmentId, serviceName, appointmentDate, locationType, customerAddress, notes, amount, serviceId });
    
    try {
        // Set the service ID and amount from the previous appointment
        const serviceIdField = document.getElementById('rebook_service_id');
        const amountField = document.getElementById('rebook_amount');
        
        if (serviceIdField) serviceIdField.value = serviceId || 1;
        if (amountField) amountField.value = amount || 0;
        
        // Populate previous appointment details
        const serviceField = document.getElementById('rebookService');
        const dateField = document.getElementById('rebookPreviousDate');
        const amountDisplayField = document.getElementById('rebookAmount');
        
        if (serviceField) serviceField.textContent = serviceName || 'Service';
        if (dateField) dateField.textContent = formatDetailsDateTime(appointmentDate);
        if (amountDisplayField) amountDisplayField.textContent = '₱' + (parseFloat(amount || 0)).toFixed(2);
        
        // Show the modal
        const modal = document.getElementById('rebookModal');
        if (modal) {
            console.log('Found rebook modal, showing it...');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            console.error('Rebook modal not found!');
            alert('Rebook modal not found!');
        }
    } catch (error) {
        console.error('Error in openRebookModal:', error);
        alert('Error opening rebook modal: ' + error.message);
    }
}

function closeRebookModal() {
    document.getElementById('rebookModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Reset the form
    document.getElementById('rebookForm').reset();
}

// Helper function for formatting date and time in details
function formatDetailsDateTime(appointmentDate) {
    const dateObj = new Date(appointmentDate);
    return dateObj.toLocaleDateString('en-US', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    }) + ' at ' + dateObj.toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
}

// Add event listeners for all action buttons
document.addEventListener('DOMContentLoaded', function() {
    // Reschedule buttons
    document.querySelectorAll('.action-reschedule').forEach(button => {
        button.addEventListener('click', function() {
            const appointmentId = this.getAttribute('data-appointment-id');
            const serviceName = this.getAttribute('data-service-name');
            const appointmentDate = this.getAttribute('data-appointment-date');
            const appointmentTime = this.getAttribute('data-appointment-time');
            const locationType = this.getAttribute('data-location-type');
            const customerAddress = this.getAttribute('data-customer-address');
            const notes = this.getAttribute('data-notes');
            
            openRescheduleModal(appointmentId, serviceName, appointmentDate, appointmentTime, locationType, customerAddress, notes);
        });
    });
    
    // Details buttons
    document.querySelectorAll('.action-details').forEach(button => {
        button.addEventListener('click', function() {
            const appointmentId = this.getAttribute('data-appointment-id');
            const serviceName = this.getAttribute('data-service-name');
            const appointmentDate = this.getAttribute('data-appointment-date');
            const locationType = this.getAttribute('data-location-type');
            const customerAddress = this.getAttribute('data-customer-address');
            const notes = this.getAttribute('data-notes');
            const amount = this.getAttribute('data-amount');
            
            openDetailsModal(appointmentId, serviceName, appointmentDate, locationType, customerAddress, notes, amount);
        });
    });
    
    // Rate buttons
    document.querySelectorAll('.action-rate').forEach(button => {
        button.addEventListener('click', function() {
            const appointmentId = this.getAttribute('data-appointment-id');
            const serviceName = this.getAttribute('data-service-name');
            const appointmentDate = this.getAttribute('data-appointment-date');
            const locationType = this.getAttribute('data-location-type');
            const customerAddress = this.getAttribute('data-customer-address');
            const notes = this.getAttribute('data-notes');
            const amount = this.getAttribute('data-amount');
            
            openReviewModal(appointmentId, serviceName, appointmentDate, locationType, customerAddress, notes, amount);
        });
    });
    
    // Rebook buttons
    document.querySelectorAll('.action-rebook').forEach(button => {
        button.addEventListener('click', function() {
            const appointmentId = this.getAttribute('data-appointment-id');
            const serviceName = this.getAttribute('data-service-name');
            const appointmentDate = this.getAttribute('data-appointment-date');
            const locationType = this.getAttribute('data-location-type');
            const customerAddress = this.getAttribute('data-customer-address');
            const notes = this.getAttribute('data-notes');
            const amount = this.getAttribute('data-amount');
            const serviceId = this.getAttribute('data-service-id');
            
            openRebookModal(appointmentId, serviceName, appointmentDate, locationType, customerAddress, notes, amount, serviceId);
        });
    });
    
    // Close modals when clicking outside
    // Details modal
    const detailsModal = document.getElementById('detailsModal');
    if (detailsModal) {
        detailsModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailsModal();
            }
        });
    }
    
    // Review modal
    const reviewModal = document.getElementById('reviewModal');
    if (reviewModal) {
        reviewModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewModal();
            }
        });
    }
    
    // Rebook modal
    const rebookModal = document.getElementById('rebookModal');
    if (rebookModal) {
        rebookModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRebookModal();
            }
        });
    }
    
    // Add character counter for review comment
    const reviewComment = document.getElementById('review_comment');
    if (reviewComment) {
        reviewComment.addEventListener('input', function() {
            const charCount = this.value.length;
            document.getElementById('charCount').textContent = charCount;
            
            // Change color based on character count
            if (charCount < 20) {
                this.style.borderColor = '#f44336';
            } else if (charCount > 450) {
                this.style.borderColor = '#ff9800';
            } else {
                this.style.borderColor = '#4caf50';
            }
        });
    }
    
    // Add form submission handler for review form
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            const rating = document.querySelector('input[name="rating"]:checked');
            const title = document.getElementById('review_title').value.trim();
            const comment = document.getElementById('review_comment').value.trim();
            
            // Clear previous error messages
            clearValidationErrors();
            
            let hasErrors = false;
            
            // Validate required fields
            if (!rating) {
                showFieldError('rating', 'Please select a rating.');
                hasErrors = true;
            }
            
            if (!title) {
                showFieldError('review_title', 'Please provide a review title.');
                hasErrors = true;
            }
            
            if (!comment) {
                showFieldError('review_comment', 'Please provide a detailed review.');
                hasErrors = true;
            } else if (comment.length < 20) {
                showFieldError('review_comment', 'Review must be at least 20 characters long.');
                hasErrors = true;
            }
            
            if (hasErrors) {
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;
            
            // Re-enable button after 5 seconds in case of error
            setTimeout(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });
    }
    
    // Handle location type change for rebook form
    const rebookLocationType = document.getElementById('rebook_location_type');
    if (rebookLocationType) {
        rebookLocationType.addEventListener('change', function() {
            const addressGroup = document.getElementById('rebookAddressGroup');
            if (this.value === 'home-service') {
                addressGroup.style.display = 'block';
            } else {
                addressGroup.style.display = 'none';
            }
        });
    }
});
</script>

@endsection
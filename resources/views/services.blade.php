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
    .page-title {
        font-weight: 700;
        color: #b48b8b;
        font-size: 24px;
        margin-bottom: 24px;
    }
    .service-filters {
        display: flex;
        gap: 12px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }
    .filter-btn {
        padding: 8px 16px;
        border: 1px solid #b48b8b;
        background: #fff;
        color: #b48b8b;
        border-radius: 20px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .filter-btn.active {
        background: #b48b8b;
        color: #fff;
    }
    .filter-btn:hover:not(.active) {
        background: #f7eaea;
    }
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 24px;
    }
    .service-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px #eee;
        overflow: hidden;
        color: #b48b8b;
        transition: transform 0.2s;
    }
    .service-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px #ddd;
    }
    .service-card .service-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        background-color: #f5f5f5;
        border-radius: 8px 8px 0 0;
    }
    
    .service-card .service-image[src*="noprofile.png"] {
        background-color: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 14px;
        text-align: center;
        padding: 20px;
    }
    .service-card .service-content {
        padding: 20px;
    }
    .service-card .service-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #a07a7a;
    }
    .service-card .service-price {
        font-size: 16px;
        font-weight: 600;
        color: #b48b8b;
        margin-bottom: 12px;
    }
    .service-card .service-description {
        font-size: 14px;
        line-height: 1.5;
        color: #a07a7a;
        margin-bottom: 16px;
    }
    .service-card .service-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .book-btn {
        background: #b48b8b;
        color: #fff;
        border: none;
        border-radius: 20px;
        padding: 8px 16px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        font-size: 14px;
    }
    .favorite-btn {
        background: transparent;
        border: 1px solid #b48b8b;
        color: #b48b8b;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .favorite-btn:hover {
        background: #f7eaea;
    }
    .favorite-btn.active {
        background: #b48b8b;
        color: #fff;
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
        .services-grid {
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
        
        .page-title {
            font-size: 20px;
        }
        
        .dashboard-header .search-bar {
            width: 100%;
            max-width: 100%;
        }
        
        .service-filters {
            overflow-x: auto;
            padding-bottom: 8px;
            justify-content: flex-start;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #b48b8b #f7f7f7;
        }
        
        .service-filters::-webkit-scrollbar {
            height: 4px;
        }
        
        .service-filters::-webkit-scrollbar-track {
            background: #f7f7f7;
            border-radius: 4px;
        }
        
        .service-filters::-webkit-scrollbar-thumb {
            background: #b48b8b;
            border-radius: 4px;
        }
        
        .filter-btn {
            white-space: nowrap;
            flex-shrink: 0;
        }
        
        .services-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .service-card .service-image {
            height: 220px;
        }
        
        .service-card .service-content {
            padding: 16px;
        }
        
        .service-card .service-title {
            font-size: 16px;
        }
        
        .service-card .service-actions {
            flex-direction: column;
            gap: 12px;
        }
        
        .book-btn {
            width: 100%;
            justify-content: center;
        }
        
        .favorite-btn {
            align-self: flex-end;
        }
    }
    
    @media (max-width: 480px) {
        .dashboard-content {
            padding: 60px 12px 12px;
        }
        
        .page-title {
            font-size: 18px;
            margin-bottom: 16px;
        }
        
        .filter-btn {
            font-size: 13px;
            padding: 6px 12px;
        }
        
        .service-card .service-image {
            height: 200px;
        }
        
        .service-card .service-title {
            font-size: 15px;
        }
        
        .service-card .service-price {
            font-size: 15px;
        }
        
        .service-card .service-description {
            font-size: 13px;
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
            <a href="{{ url('/appointments') }}">Appointments</a>
            <a href="{{ url('/services') }}" class="active">Services</a>
            <a href="{{ url('/favorites') }}">Favorites</a>
            <a href="{{ url('/transaction-history') }}">Transaction History</a>
            <a href="{{ url('/profile-settings') }}">Profile Settings</a>
            <a href="{{ url('/faqs') }}">FAQs</a>
        </nav>
        <a href="#" class="logout">Logout</a>
    </div>
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div class="page-title">Our Services</div>
            <div style="display:flex; align-items:center;">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search services..." onkeyup="searchServices()">
                    <span class="material-icons" style="font-size:18px;">search</span>
                </div>
            </div>
        </div>
        
        <div class="service-filters">
            <a href="#" class="filter-btn active" data-filter="all">All Services</a>
            <a href="#" class="filter-btn" data-filter="soft-gel">Soft Gel Extension</a>
            <a href="#" class="filter-btn" data-filter="gel-polish">Gel Polish</a>
            <a href="#" class="filter-btn" data-filter="toe">Toe Extension</a>
        </div>
        
        <div class="services-grid">
            @foreach($services as $service)
            @php
                $serviceNameLower = strtolower($service->name);
                $filterClass = '';
                
                // Determine filter class based on service name
                if (strpos($serviceNameLower, 'soft gel') !== false) {
                    $filterClass = 'soft-gel';
                } elseif (strpos($serviceNameLower, 'gel polish') !== false && strpos($serviceNameLower, 'toe') === false) {
                    $filterClass = 'gel-polish';
                } elseif (strpos($serviceNameLower, 'toe') !== false) {
                    $filterClass = 'toe';
                } else {
                    $filterClass = 'other';
                }
            @endphp
            <div class="service-card" data-category="{{ $filterClass }}">
                @php
                    $imageName = '';
                    $serviceNameLower = strtolower($service->name);
                    
                    // Use uploaded image if available and exists, otherwise fallback to default images
                    if ($service->image_url && file_exists(public_path($service->image_url))) {
                        $imageName = $service->image_url;
                    } else {
                        // Map service names to default image files
                        if (strpos($serviceNameLower, 'soft gel') !== false) {
                            $imageName = 'images/services/softgelminimalist.png';
                        } elseif (strpos($serviceNameLower, 'gel polish') !== false && strpos($serviceNameLower, 'toe') === false) {
                            $imageName = 'images/services/gelpolish.png';
                        } elseif (strpos($serviceNameLower, 'toe') !== false) {
                            $imageName = 'images/services/toegelpolish.png';
                        } elseif (strpos($serviceNameLower, 'nail art') !== false) {
                            $imageName = 'images/services/nailart.png';
                        } elseif (strpos($serviceNameLower, 'manicure') !== false) {
                            $imageName = 'images/services/manicureclassic.png';
                        } else {
                            // Default fallback
                            $imageName = 'images/noprofile.png';
                        }
                    }
                @endphp
                
                <img src="{{ asset($imageName) }}" 
                     alt="{{ $service->name }}" 
                     class="service-image" 
                     onerror="console.log('Customer image failed:', '{{ asset($imageName) }}'); this.src='{{ asset('images/noprofile.png') }}'"
                     onload="console.log('Customer image loaded:', '{{ asset($imageName) }}');"
                     style="width: 100%; height: 200px; object-fit: cover;"
                     title="Image: {{ $imageName }} | DB: {{ $service->image_url }} | Service: {{ $service->name }}">
                <div class="service-content">
                    <div class="service-title">{{ $service->name }}</div>
                    <div class="service-price">₱{{ number_format($service->price) }}</div>
                    <div class="service-description">
                        {{ $service->description ?? 'Professional nail service with premium quality materials and expert craftsmanship.' }}
                    </div>
                    <div class="service-actions">
                        <button class="book-btn" onclick="openBookingModal({{ $service->id }}, '{{ $service->name }}', {{ $service->price }})">
                            <span class="material-icons" style="font-size:16px;">event</span>
                            Book Now
                        </button>
                        <button class="favorite-btn {{ in_array($service->id, $userFavorites) ? 'active' : '' }}" 
                                onclick="toggleFavorite({{ $service->id }}, this)">
                            <span class="material-icons" style="font-size:18px;">
                                {{ in_array($service->id, $userFavorites) ? 'favorite' : 'favorite_border' }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal-overlay" id="bookingModal">
    <div class="booking-modal">
        <div class="modal-header">
            <div class="modal-title">
                <span class="material-icons">event</span>
                Book New Appointment
            </div>
            <button class="close-btn" onclick="closeBookingModal()">
                <span class="material-icons">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('appointments.store') }}" id="bookingForm">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

            <div class="form-section" id="transportationSection" style="display: none;">
                <h3>Transportation</h3>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="transportation" value="Cordova" checked>
                        <span>Cordova (+₱150)</span>
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="transportation" value="Lapu-Lapu">
                        <span>Lapu-Lapu (+₱250)</span>
                    </label>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Service Details</h3>
                <div class="form-group">
                    <label for="service_id">Select a Service</label>
                    <div class="input-with-icon">
                        <select id="service_id" name="service_id" onchange="updateCharges()" required>
                            <option value="">Choose a service...</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-name="{{ $service->name }}">{{ $service->name }} - ₱{{ $service->price }}</option>
                            @endforeach
                        </select>
                        <span class="material-icons">expand_more</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="appointment_date">Date</label>
                    <div class="input-with-icon">
                        <input type="date" id="appointment_date" name="appointment_date" required>
                        <span class="material-icons">calendar_today</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="appointment_time">Time</label>
                    <div class="input-with-icon">
                        <input type="time" id="appointment_time" name="appointment_time" required>
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="location_type">Location Type</label>
                    <div class="input-with-icon">
                        <select id="location_type" name="location_type" required>
                            <option value="walk-in">Walk In</option>
                            <option value="home-service">Home Service</option>
                        </select>
                        <span class="material-icons">location_on</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="customer_address">Address (for Home Service)</label>
                    <textarea id="customer_address" name="customer_address" placeholder="Enter your address for home service..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="notes">Special Requests</label>
                    <textarea id="notes" name="notes" placeholder="Any specific design or notes..."></textarea>
                </div>
                <input type="hidden" id="amount" name="amount" value="">
            </div>
            
            <div class="charges-summary">
                <div class="charge-item">
                    <span>Service: <span id="serviceName">-</span></span>
                    <span id="servicePrice">₱0</span>
                </div>
                <div class="charge-item" id="transportationItem" style="display: none;">
                    <span>Transportation: <span id="transportationName">-</span></span>
                    <span id="transportationPrice">₱0</span>
                </div>
                <div class="charge-item">
                    <span>Total Amount:</span>
                    <span id="totalAmount">₱0</span>
                </div>
                <div class="charge-item">
                    <span>- ₱100 Downpayment</span>
                    <span></span>
                </div>
                <div class="charge-item">
                    <span>To be paid after service:</span>
                    <span id="finalAmount">₱0</span>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closeBookingModal()">Cancel</button>
                <button type="submit" class="confirm-btn">Confirm Booking (₱100 Deposit)</button>
            </div>
        </form>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal-overlay" id="confirmationModal">
    <div class="confirmation-modal">
        <div class="confirmation-header">
            <div class="success-icon">
                <span class="material-icons">check</span>
            </div>
            <div class="confirmation-title">Booking Confirmed!</div>
        </div>
        
        <div class="booking-details">
            <div class="detail-row">
                <span class="detail-label">Service:</span>
                <span class="detail-value" id="confirmService">₱1,500 Soft Gel - Full Set</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date:</span>
                <span class="detail-value" id="confirmDate">Tuesday, May 13, 2025 at 2:00 PM</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Location:</span>
                <span class="detail-value" id="confirmLocation">Home Service</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Special Request:</span>
                <span class="detail-value" id="confirmRequest">Lorem Ipsum</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Transportation:</span>
                <span class="detail-value" id="confirmTransportation">₱150 (Cordova)</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total:</span>
                <span class="detail-value" id="confirmTotal">₱1,650</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Down Payment:</span>
                <span class="detail-value">₱100</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">To be paid after service:</span>
                <span class="detail-value" id="confirmFinal">₱1,550</span>
            </div>
        </div>
        
        <div class="confirmation-message">
            A confirmation has been sent to your email.
        </div>
        
        <div class="confirmation-actions">
            <button class="view-appointments-btn" onclick="viewAppointments()">
                <span class="material-icons">event</span>
                View Appointments
            </button>
            <button class="print-receipt-btn" onclick="printReceipt()">
                <span class="material-icons">print</span>
                Print Receipt
            </button>
        </div>
    </div>
</div>

<!-- Google Material Icons CDN for icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
/* Modal Styles */
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
    padding: 8px 12px;
    border-radius: 8px;
    transition: background 0.2s;
}

.radio-option:hover {
    background: #f7eaea;
}

.radio-option input[type="radio"] {
    margin: 0;
}

.radio-option span {
    color: #b48b8b;
    font-weight: 500;
}

.charges-summary {
    background: #f7f7f7;
    border-radius: 8px;
    padding: 16px;
    margin: 0 24px 24px 24px;
}

.charge-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    font-size: 14px;
    color: #b48b8b;
}

.charge-item:last-child {
    margin-bottom: 0;
    font-weight: 600;
    color: #a07a7a;
    border-top: 1px solid #e5cfd1;
    padding-top: 8px;
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

.confirmation-modal {
    background: #fff;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    padding: 32px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.confirmation-header {
    margin-bottom: 24px;
}

.success-icon {
    width: 60px;
    height: 60px;
    background: #d4edda;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}

.success-icon .material-icons {
    color: #155724;
    font-size: 30px;
}

.confirmation-title {
    font-size: 20px;
    font-weight: 700;
    color: #b48b8b;
}

.booking-details {
    background: #f7f7f7;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 24px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    font-size: 14px;
    color: #a07a7a;
}

.detail-row:last-child {
    margin-bottom: 0;
    font-weight: 600;
    color: #b48b8b;
    border-top: 1px solid #e5cfd1;
    padding-top: 8px;
}

.detail-label {
    font-weight: 500;
}

.detail-value {
    text-align: right;
}

.confirmation-message {
    color: #a07a7a;
    font-size: 14px;
    margin-bottom: 24px;
}

.confirmation-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
}

.view-appointments-btn {
    background: transparent;
    border: 1px solid #b48b8b;
    color: #b48b8b;
    border-radius: 20px;
    padding: 12px 24px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.print-receipt-btn {
    background: #b48b8b;
    color: #fff;
    border: none;
    border-radius: 20px;
    padding: 12px 24px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
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
    
    .charges-summary {
        margin: 0 16px 20px 16px;
        padding: 12px;
    }
    
    .charge-item {
        font-size: 13px;
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
    
    .confirmation-modal {
        width: 95%;
        padding: 24px 16px;
    }
    
    .confirmation-title {
        font-size: 18px;
    }
    
    .booking-details {
        padding: 12px;
    }
    
    .detail-row {
        font-size: 13px;
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    .detail-value {
        text-align: left;
    }
    
    .confirmation-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .view-appointments-btn,
    .print-receipt-btn {
        width: 100%;
        justify-content: center;
        font-size: 13px;
        padding: 10px 20px;
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
    
    .charge-item {
        font-size: 12px;
    }
    
    .confirmation-modal {
        width: 100%;
        max-width: 100%;
        border-radius: 0;
        padding: 20px 12px;
    }
    
    .success-icon {
        width: 50px;
        height: 50px;
    }
    
    .success-icon .material-icons {
        font-size: 24px;
    }
    
    .confirmation-title {
        font-size: 16px;
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

function openBookingModal(serviceId = null, serviceName = null, servicePrice = null) {
    document.getElementById('bookingModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // If service is pre-selected from the services page
    if (serviceId && serviceName && servicePrice) {
        const serviceSelect = document.getElementById('service_id');
        serviceSelect.value = serviceId;
        updateCharges();
    }
}

function closeBookingModal() {
    document.getElementById('bookingModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Reset the form
    document.querySelector('#bookingModal form').reset();
    // Reset the charges display
    updateCharges();
}

// Close modal when clicking outside
document.getElementById('bookingModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeBookingModal();
    }
});

// Add event listener for location type changes
document.addEventListener('DOMContentLoaded', function() {
    const locationTypeSelect = document.getElementById('location_type');
    if (locationTypeSelect) {
        locationTypeSelect.addEventListener('change', updateCharges);
    }
    
    // Add event listener for transportation changes
    document.querySelectorAll('input[name="transportation"]').forEach(radio => {
        radio.addEventListener('change', updateCharges);
    });
    
    // Add form submission handler
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            // Log form data for debugging
            console.log('Form submitting...');
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            
            // Check if required fields are filled
            const serviceId = formData.get('service_id');
            const appointmentDate = formData.get('appointment_date');
            const appointmentTime = formData.get('appointment_time');
            const amount = formData.get('amount');
            
            if (!serviceId || !appointmentDate || !appointmentTime || !amount) {
                e.preventDefault();
                alert('Please fill in all required fields and select a service.');
                return false;
            }
        });
    }
});

function updateCharges() {
    const serviceSelect = document.getElementById('service_id');
    const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
    const serviceName = selectedOption.dataset.name || selectedOption.text;
    const servicePrice = selectedOption.dataset.price || 0;
    
    console.log('Service selected:', serviceName);
    console.log('Service price:', servicePrice);
    
    document.getElementById('amount').value = servicePrice;
    
    const location = document.getElementById('location_type').value;
    const transportation = document.querySelector('input[name="transportation"]:checked');
    
    let transportationPrice = 0;
    let transportationName = '';
    
    if (location === 'home-service' && transportation) {
        if (transportation.value === 'Cordova') {
            transportationPrice = 150;
            transportationName = 'Cordova';
        } else if (transportation.value === 'Lapu-Lapu') {
            transportationPrice = 250;
            transportationName = 'Lapu-Lapu';
        }
    }
    
    const total = parseInt(servicePrice) + transportationPrice;
    const final = total - 100;
    
    document.getElementById('serviceName').textContent = serviceName || '-';
    document.getElementById('servicePrice').textContent = `₱${servicePrice}`;
    document.getElementById('transportationName').textContent = transportationName;
    document.getElementById('transportationPrice').textContent = `₱${transportationPrice}`;
    document.getElementById('totalAmount').textContent = `₱${total}`;
    document.getElementById('finalAmount').textContent = `₱${final}`;
    
    // Show/hide transportation section based on location
    const transportationSection = document.getElementById('transportationSection');
    const transportationItem = document.getElementById('transportationItem');
    
    if (location === 'home-service') {
        transportationSection.style.display = 'block';
        transportationItem.style.display = 'flex';
    } else {
        transportationSection.style.display = 'none';
        transportationItem.style.display = 'none';
    }
}

function confirmBooking() {
    // Get form data
    const serviceSelect = document.getElementById('service_id');
    const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
    const serviceName = selectedOption.dataset.name || selectedOption.text;
    const servicePrice = selectedOption.dataset.price || 0;
    
    const location = document.getElementById('location_type').value;
    const transportation = document.querySelector('input[name="transportation"]:checked');
    const appointmentDate = document.getElementById('appointment_date').value;
    const notes = document.getElementById('notes').value;
    
    let transportationPrice = 0;
    let transportationName = '';
    let locationName = 'Walk In';
    
    if (location === 'home-service' && transportation) {
        if (transportation.value === 'Cordova') {
            transportationPrice = 150;
            transportationName = 'Cordova';
        } else if (transportation.value === 'Lapu-Lapu') {
            transportationPrice = 250;
            transportationName = 'Lapu-Lapu';
        }
        locationName = 'Home Service';
    }
    
    const total = parseInt(servicePrice) + transportationPrice;
    const final = total - 100;
    
    // Update confirmation modal with booking details
    document.getElementById('confirmService').textContent = `₱${servicePrice} ${serviceName}`;
    document.getElementById('confirmDate').textContent = appointmentDate;
    document.getElementById('confirmLocation').textContent = locationName;
    document.getElementById('confirmRequest').textContent = notes || 'None';
    document.getElementById('confirmTransportation').textContent = location === 'home-service' ? `₱${transportationPrice} (${transportationName})` : 'N/A';
    document.getElementById('confirmTotal').textContent = `₱${total}`;
    document.getElementById('confirmFinal').textContent = `₱${final}`;
    
    // Close booking modal and open confirmation modal
    closeBookingModal();
    openConfirmationModal();
}

function openConfirmationModal() {
    document.getElementById('confirmationModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeConfirmationModal() {
    document.getElementById('confirmationModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close confirmation modal when clicking outside
document.getElementById('confirmationModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeConfirmationModal();
    }
});

function viewAppointments() {
    closeConfirmationModal();
    window.location.href = '/appointments';
}

function printReceipt() {
    // Create a printable version of the receipt
    const printWindow = window.open('', '_blank');
    const receiptContent = `
        <html>
        <head>
            <title>Booking Receipt</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                .header { text-align: center; margin-bottom: 30px; }
                .receipt { border: 1px solid #ccc; padding: 20px; }
                .detail-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
                .total { border-top: 2px solid #000; padding-top: 10px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Nailed by Via</h1>
                <h2>Booking Confirmation</h2>
            </div>
            <div class="receipt">
                <div class="detail-row">
                    <span>Service:</span>
                    <span>${document.getElementById('confirmService').textContent}</span>
                </div>
                <div class="detail-row">
                    <span>Date:</span>
                    <span>${document.getElementById('confirmDate').textContent}</span>
                </div>
                <div class="detail-row">
                    <span>Location:</span>
                    <span>${document.getElementById('confirmLocation').textContent}</span>
                </div>
                <div class="detail-row">
                    <span>Transportation:</span>
                    <span>${document.getElementById('confirmTransportation').textContent}</span>
                </div>
                <div class="detail-row total">
                    <span>Total Amount:</span>
                    <span>${document.getElementById('confirmTotal').textContent}</span>
                </div>
                <div class="detail-row">
                    <span>Down Payment:</span>
                    <span>₱100</span>
                </div>
                <div class="detail-row total">
                    <span>To be paid after service:</span>
                    <span>${document.getElementById('confirmFinal').textContent}</span>
                </div>
            </div>
        </body>
        </html>
    `;
    printWindow.document.write(receiptContent);
    printWindow.document.close();
    printWindow.print();
}

function toggleFavorite(serviceId, button) {
    fetch('/favorites/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            service_id: serviceId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'added') {
            button.classList.add('active');
            button.querySelector('.material-icons').textContent = 'favorite';
            showNotification('Service added to favorites!', 'success');
            
            // Dispatch custom event to update dashboard favorites count
            document.dispatchEvent(new CustomEvent('favoritesUpdated'));
        } else {
            button.classList.remove('active');
            button.querySelector('.material-icons').textContent = 'favorite_border';
            showNotification('Service removed from favorites!', 'info');
            
            // Dispatch custom event to update dashboard favorites count
            document.dispatchEvent(new CustomEvent('favoritesUpdated'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating favorites!', 'error');
    });
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: slideIn 0.3s ease-out;
    `;
    
    // Set background color based on type
    switch(type) {
        case 'success':
            notification.style.backgroundColor = '#4caf50';
            break;
        case 'error':
            notification.style.backgroundColor = '#f44336';
            break;
        case 'info':
        default:
            notification.style.backgroundColor = '#2196f3';
            break;
    }
    
    // Add to page
    notification.style.display = 'block';
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Add CSS animations for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Service filtering functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const serviceCards = document.querySelectorAll('.service-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get the filter value
            const filterValue = this.getAttribute('data-filter');
            
            // Filter service cards
            serviceCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                
                if (filterValue === 'all' || cardCategory === filterValue) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.3s ease-in';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show notification
            const filterName = this.textContent;
            showNotification(`Showing ${filterName}`, 'info');
        });
    });
});

// Add fade-in animation for filtered cards
const filterStyle = document.createElement('style');
filterStyle.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(filterStyle);

// Search functionality
function searchServices() {
    const searchInput = document.getElementById('searchInput');
    const searchTerm = searchInput.value.toLowerCase();
    const serviceCards = document.querySelectorAll('.service-card');
    
    serviceCards.forEach(card => {
        const serviceTitle = card.querySelector('.service-title').textContent.toLowerCase();
        const serviceDescription = card.querySelector('.service-description').textContent.toLowerCase();
        
        if (serviceTitle.includes(searchTerm) || serviceDescription.includes(searchTerm)) {
            card.style.display = 'block';
            card.style.animation = 'fadeIn 0.3s ease-in';
        } else {
            card.style.display = 'none';
        }
    });
    
    // If search is cleared, show all services
    if (searchTerm === '') {
        serviceCards.forEach(card => {
            card.style.display = 'block';
        });
    }
}
</script>

@endsection 
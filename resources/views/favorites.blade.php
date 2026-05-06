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
        margin-bottom: 8px;
    }
    .page-subtitle {
        color: #a07a7a;
        font-size: 14px;
        margin-bottom: 24px;
    }
    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 24px;
    }
    .favorite-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px #eee;
        overflow: hidden;
        color: #b48b8b;
        transition: transform 0.2s;
        position: relative;
    }
    .favorite-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px #ddd;
    }
    .favorite-card .favorite-icon {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #b48b8b;
        color: #fff;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }
    .favorite-card .service-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .favorite-card .service-content {
        padding: 20px;
    }
    .favorite-card .service-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #a07a7a;
    }
    .favorite-card .service-description {
        font-size: 14px;
        line-height: 1.5;
        color: #a07a7a;
        margin-bottom: 16px;
    }
    .favorite-card .service-actions {
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
    .remove-btn {
        background: transparent;
        border: 1px solid #f44336;
        color: #f44336;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .remove-btn:hover {
        background: #f44336;
        color: #fff;
    }
    .empty-favorites {
        text-align: center;
        padding: 60px 20px;
        color: #b48b8b;
    }
    
    .empty-icon {
        margin-bottom: 24px;
    }
    
    .empty-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #a07a7a;
    }
    
    .empty-subtitle {
        font-size: 16px;
        margin-bottom: 32px;
        color: #b48b8b;
    }
    
    .browse-services-btn {
        background: #b48b8b;
        color: #fff;
        text-decoration: none;
        padding: 12px 24px;
        border-radius: 20px;
        font-weight: 600;
        transition: background 0.2s;
    }
    
    .browse-services-btn:hover {
        background: #a07a7a;
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
        .favorites-grid {
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
        
        .page-subtitle {
            font-size: 13px;
            margin-bottom: 20px;
        }
        
        .dashboard-header .search-bar {
            width: 100%;
            max-width: 100%;
        }
        
        .favorites-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .favorite-card .service-image {
            height: 220px;
        }
        
        .favorite-card .service-content {
            padding: 16px;
        }
        
        .favorite-card .service-title {
            font-size: 16px;
        }
        
        .favorite-card .service-description {
            font-size: 13px;
            margin-bottom: 14px;
        }
        
        .favorite-card .service-actions {
            flex-direction: column;
            gap: 12px;
        }
        
        .book-btn {
            width: 100%;
            justify-content: center;
        }
        
        .remove-btn {
            align-self: flex-end;
        }
        
        .empty-favorites {
            padding: 40px 20px;
        }
        
        .empty-icon .material-icons {
            font-size: 48px !important;
        }
        
        .empty-title {
            font-size: 20px;
        }
        
        .empty-subtitle {
            font-size: 14px;
            margin-bottom: 24px;
        }
    }
    
    @media (max-width: 480px) {
        .dashboard-content {
            padding: 60px 12px 12px;
        }
        
        .page-title {
            font-size: 18px;
            margin-bottom: 6px;
        }
        
        .page-subtitle {
            font-size: 12px;
            margin-bottom: 16px;
        }
        
        .favorite-card .service-image {
            height: 200px;
        }
        
        .favorite-card .service-title {
            font-size: 15px;
        }
        
        .favorite-card .service-description {
            font-size: 12px;
        }
        
        .empty-icon .material-icons {
            font-size: 40px !important;
        }
        
        .empty-title {
            font-size: 18px;
        }
        
        .empty-subtitle {
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
            <a href="{{ url('/services') }}">Services</a>
            <a href="{{ url('/favorites') }}" class="active">Favorites</a>
            <a href="{{ url('/transaction-history') }}">Transaction History</a>
            <a href="{{ url('/profile-settings') }}">Profile Settings</a>
            <a href="{{ url('/faqs') }}">FAQs</a>
        </nav>
        <a href="#" class="logout">Logout</a>
    </div>
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div>
                <div class="page-title">My Favorites</div>
                <div class="page-subtitle">Your saved favorite services and designs. Click 'Book Now' to schedule or remove items you no longer want.</div>
            </div>
            <div style="display:flex; align-items:center;">
                <div class="search-bar">
                    <input type="text" placeholder="Search favorites...">
                    <span class="material-icons" style="font-size:18px;">search</span>
                </div>
            </div>
        </div>
        
        <div class="favorites-grid">
            @if($favorites->count() > 0)
                @foreach($favorites as $favorite)
                <div class="favorite-card" id="favorite-{{ $favorite->id }}">
                <div class="favorite-icon">
                    <span class="material-icons" style="font-size:18px;">favorite</span>
                </div>
                    @php
                        $imageName = '';
                        $serviceNameLower = strtolower($favorite->service->name);
                        
                        // Use uploaded image if available and exists, otherwise fallback to default images
                        if ($favorite->service->image_url && file_exists(public_path($favorite->service->image_url))) {
                            $imageName = $favorite->service->image_url;
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
                         alt="{{ $favorite->service->name }}" 
                         class="service-image" 
                         onerror="this.src='{{ asset('images/noprofile.png') }}'">
                <div class="service-content">
                        <div class="service-title">{{ $favorite->service->name }}</div>
                    <div class="service-description">
                            {{ $favorite->service->description ?? 'Professional nail service with premium quality materials and expert craftsmanship.' }}
                    </div>
                    <div class="service-actions">
                            <button class="book-btn" onclick="openBookingModal({{ $favorite->service->id }}, '{{ $favorite->service->name }}', {{ $favorite->service->price }})">
                            <span class="material-icons" style="font-size:16px;">event</span>
                            Book Now
                            </button>
                            <button class="remove-btn" onclick="removeFavorite({{ $favorite->id }})">
                            <span class="material-icons" style="font-size:18px;">delete</span>
                        </button>
                    </div>
                </div>
            </div>
                @endforeach
            @else
                <div class="empty-favorites">
                    <div class="empty-icon">
                        <span class="material-icons" style="font-size:64px; color: #b48b8b;">favorite_border</span>
                </div>
                    <div class="empty-title">No favorites yet</div>
                    <div class="empty-subtitle">Start adding services to your favorites to see them here!</div>
                    <a href="{{ url('/services') }}" class="browse-services-btn">Browse Services</a>
                    </div>
            @endif
                    </div>
                </div>
            </div>
<!-- Google Material Icons CDN for icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
                            @foreach($favorites as $favorite)
                                <option value="{{ $favorite->service->id }}" data-price="{{ $favorite->service->price }}" data-name="{{ $favorite->service->name }}">{{ $favorite->service->name }} - ₱{{ $favorite->service->price }}</option>
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
    
    // If service is pre-selected from the favorites page
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

function removeFavorite(favoriteId) {
    if (confirm('Are you sure you want to remove this service from your favorites?')) {
        fetch('/favorites/remove', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                favorite_id: favoriteId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Remove the favorite card from the DOM
                const favoriteCard = document.getElementById(`favorite-${favoriteId}`);
                if (favoriteCard) {
                    favoriteCard.remove();
                    
                    // Check if there are no more favorites
                    const remainingFavorites = document.querySelectorAll('.favorite-card');
                    if (remainingFavorites.length === 0) {
                        // Show empty state
                        const favoritesGrid = document.querySelector('.favorites-grid');
                        favoritesGrid.innerHTML = `
                            <div class="empty-favorites">
                                <div class="empty-icon">
                                    <span class="material-icons" style="font-size:64px; color: #b48b8b;">favorite_border</span>
                                </div>
                                <div class="empty-title">No favorites yet</div>
                                <div class="empty-subtitle">Start adding services to your favorites to see them here!</div>
                                <a href="/services" class="browse-services-btn">Browse Services</a>
</div>
                        `;
                    }
                }
                showNotification('Service removed from favorites!', 'success');
                
                // Dispatch custom event to update dashboard favorites count
                document.dispatchEvent(new CustomEvent('favoritesUpdated'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error removing favorite!', 'error');
        });
    }
}

function updateCharges() {
    const serviceSelect = document.getElementById('service_id');
    const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
    const serviceName = selectedOption.dataset.name || selectedOption.text;
    const servicePrice = selectedOption.dataset.price || 0;
    
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

// Add event listeners
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
            const formData = new FormData(this);
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
    
    // Close modal when clicking outside
    document.getElementById('bookingModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeBookingModal();
        }
    });
});

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
        color: #b48b8b;
        background: #fff;
        outline: none;
        resize: vertical;
        min-height: 80px;
        font-family: inherit;
        transition: border-color 0.2s;
        border-radius: 8px;
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
    }
`;
document.head.appendChild(style);
</script>

@endsection 
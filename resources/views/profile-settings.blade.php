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
    .page-title {
        font-weight: 700;
        color: #b48b8b;
        font-size: 24px;
        margin-bottom: 24px;
    }
    .profile-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px #eee;
        padding: 32px;
        max-width: 800px;
    }
    .section-header {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        color: #b48b8b;
        font-size: 18px;
        margin-bottom: 24px;
    }
    .profile-picture-section {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 32px;
    }
    .profile-picture {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
    }
    .picture-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .picture-info .size-text {
        color: #a07a7a;
        font-size: 14px;
    }
    .upload-btn {
        background: transparent;
        border: 1px solid #b48b8b;
        color: #b48b8b;
        border-radius: 20px;
        padding: 8px 16px;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }
    .upload-btn:hover {
        background: #b48b8b;
        color: #fff;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .form-group label {
        font-weight: 600;
        color: #b48b8b;
        font-size: 14px;
    }
    .form-group input {
        padding: 12px 16px;
        border: 1px solid #e5cfd1;
        border-radius: 8px;
        font-size: 14px;
        color: #a07a7a;
        background: #fff;
        transition: border-color 0.2s;
    }
    .form-group input:focus {
        outline: none;
        border-color: #b48b8b;
    }
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    .save-btn {
        background: #b48b8b;
        color: #fff;
        border: none;
        border-radius: 20px;
        padding: 12px 24px;
        font-weight: 600;
        cursor: pointer;
        font-size: 16px;
        margin-top: 24px;
        transition: background 0.2s;
    }
    .save-btn:hover {
        background: #a07a7a;
    }
    .btn-container {
        display: flex;
        justify-content: flex-end;
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
        .profile-card {
            padding: 24px;
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
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 20px;
        }
        
        .profile-card {
            padding: 20px;
        }
        
        .section-header {
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        .profile-picture-section {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 16px;
        }
        
        .profile-picture {
            width: 80px;
            height: 80px;
        }
        
        .picture-info {
            width: 100%;
            align-items: center;
        }
        
        .picture-info input[type="file"] {
            width: 100%;
            font-size: 13px;
            padding: 8px;
            border: 1px solid #e5cfd1;
            border-radius: 8px;
            background: #fff;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .form-group label {
            font-size: 13px;
        }
        
        .form-group input {
            font-size: 13px;
            padding: 10px 12px;
        }
        
        .btn-container {
            justify-content: stretch;
        }
        
        .save-btn {
            width: 100%;
            font-size: 15px;
            padding: 12px 20px;
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
        
        .profile-card {
            padding: 16px;
            border-radius: 8px;
        }
        
        .section-header {
            font-size: 15px;
        }
        
        .profile-picture {
            width: 70px;
            height: 70px;
        }
        
        .picture-info .size-text {
            font-size: 12px;
        }
        
        .picture-info input[type="file"] {
            padding: 6px;
            font-size: 12px;
        }
        
        .form-grid {
            gap: 16px;
        }
        
        .form-group label {
            font-size: 12px;
        }
        
        .form-group input {
            font-size: 12px;
            padding: 10px;
        }
        
        .save-btn {
            font-size: 14px;
            padding: 10px 16px;
            margin-top: 20px;
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
            <a href="{{ url('/favorites') }}">Favorites</a>
            <a href="{{ url('/transaction-history') }}">Transaction History</a>
            <a href="{{ url('/profile-settings') }}" class="active">Profile Settings</a>
            <a href="{{ url('/faqs') }}">FAQs</a>
        </nav>
        <a href="#" class="logout">Logout</a>
    </div>
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div class="page-title">Profile Settings</div>
        </div>
        
        <div class="profile-card">
            <div class="section-header">
                <span class="material-icons" style="font-size:20px;">person</span>
                Profile Information
            </div>
            
            @php
                $user = Auth::user();
                $profilePic = $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/noprofile.png');
            @endphp
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="profile-picture-section">
                    <img src="{{ $profilePic }}" alt="Profile Picture" class="profile-picture">
                    <div class="picture-info">
                        <div class="size-text">Recommended size: 200x200 pixels</div>
                        <input type="file" name="profile_picture" accept="image/*" style="margin-bottom:8px;">
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ explode(' ', $user->name)[0] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ explode(' ', $user->name, 2)[1] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ $user->phone }}">
                    </div>
                    <div class="form-group full-width">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" placeholder="Enter current password">
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                    </div>
                </div>
                <div class="btn-container">
                    <button type="submit" class="save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Google Material Icons CDN for icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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

// File input styling for mobile
const fileInput = document.querySelector('input[type="file"]');
if (fileInput && window.innerWidth <= 768) {
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const fileName = this.files[0].name;
            console.log('Selected file:', fileName);
        }
    });
}
</script>

@endsection 
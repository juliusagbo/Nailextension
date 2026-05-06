<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Nailed by Via</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333;
            display: flex;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: #fff;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
        }
        
        .brand {
            padding: 30px 25px 20px;
            border-bottom: 1px solid #eee;
        }
        
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }
        
        .logo-letters {
            width: 40px;
            height: 40px;
            background: #b48b8b;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }
        
        .brand-name {
            color: #b48b8b;
            font-size: 20px;
            font-weight: 600;
        }
        
        .nav-section {
            padding: 20px 0;
        }
        
        .nav-title {
            color: #666;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 25px 10px;
            margin-bottom: 10px;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 25px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .nav-item:hover {
            background: #f8f9fa;
            color: #b48b8b;
        }
        
        .nav-item.active {
            background: #f0f0f0;
            color: #b48b8b;
            border-left-color: #b48b8b;
        }
        
        .nav-item i {
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            min-height: 100vh;
        }
        
        /* Header */
        .header {
            background: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .search-bar {
            position: relative;
            width: 400px;
        }
        
        .search-bar input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 14px;
            background: #f8f9fa;
        }
        
        .search-bar i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .profile-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #b48b8b;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .profile-details h4 {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        
        .profile-details p {
            font-size: 12px;
            color: #666;
        }
        
        /* Settings Content */
        .settings-content {
            padding: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #b48b8b;
            margin-bottom: 30px;
        }
        
        /* Settings Grid */
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
        }
        
        .settings-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
        }
        
        .card-icon {
            width: 40px;
            height: 40px;
            background: #b48b8b;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            background: #f8f9fa;
            transition: border-color 0.3s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #b48b8b;
            background: white;
        }
        
        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            background: #f8f9fa;
            resize: vertical;
            min-height: 80px;
            transition: border-color 0.3s;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #b48b8b;
            background: white;
        }
        
        /* Business Hours */
        .hours-grid {
            display: grid;
            gap: 15px;
        }
        
        .hours-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .hours-row:last-child {
            border-bottom: none;
        }
        
        .day-label {
            font-weight: 500;
            color: #333;
        }
        
        .hours-display {
            color: #666;
            font-size: 14px;
        }
        
        /* Security Settings */
        .security-section {
            margin-bottom: 25px;
        }
        
        .security-section:last-child {
            margin-bottom: 0;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #b48b8b;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
        
        .toggle-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .toggle-text {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }
        
        /* Buttons */
        .btn {
            background: #b48b8b;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }
        
        .btn:hover {
            background: #a07a7a;
        }
        
        .btn:active {
            transform: translateY(1px);
        }
        
        /* Success Message */
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            display: none;
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: #b48b8b;
            border: none;
            color: white;
            font-size: 20px;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .mobile-menu-btn:hover {
            background: #a17a7a;
        }
        
        .sidebar.mobile-open {
            transform: translateX(0) !important;
        }
        
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        .overlay.show {
            display: block;
        }
        
        /* Tablet Styles */
        @media (max-width: 1200px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .search-bar {
                width: 100%;
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
            
            .main-content {
                margin-left: 0;
            }
            
            .header {
                padding: 15px;
                flex-direction: column;
                gap: 12px;
            }
            
            .search-bar {
                width: 100%;
            }
            
            .profile-details {
                display: none;
            }
            
            .settings-content {
                padding: 15px;
            }
            
            .page-title {
                font-size: 22px;
                margin-bottom: 20px;
            }
            
            .settings-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .settings-card {
                padding: 20px;
            }
            
            .card-header {
                margin-bottom: 20px;
            }
            
            .card-icon {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }
            
            .card-title {
                font-size: 16px;
            }
            
            .form-label {
                font-size: 13px;
            }
            
            .form-input,
            .form-textarea {
                font-size: 16px; /* Prevents iOS zoom */
                padding: 11px 13px;
            }
            
            .form-group {
                margin-bottom: 16px;
            }
            
            .hours-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 15px 0;
            }
            
            .hours-row > div:last-child {
                width: 100%;
            }
            
            .hours-row input[type="time"] {
                width: calc(50% - 25px) !important;
                flex: 1;
            }
            
            .hours-row > div:last-child {
                display: flex;
                gap: 10px;
                align-items: center;
                width: 100%;
            }
            
            .hours-row > div:last-child span {
                flex-shrink: 0;
            }
            
            .section-title {
                font-size: 15px;
            }
            
            .toggle-text {
                font-size: 13px;
            }
            
            .btn {
                padding: 11px 20px;
                font-size: 13px;
            }
            
            .success-message {
                font-size: 13px;
                padding: 10px 12px;
            }
        }
        
        @media (max-width: 480px) {
            .header {
                padding: 12px;
            }
            
            .settings-content {
                padding: 12px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .settings-card {
                padding: 16px;
                border-radius: 10px;
            }
            
            .card-icon {
                width: 32px;
                height: 32px;
                font-size: 15px;
            }
            
            .card-title {
                font-size: 15px;
            }
            
            .form-label {
                font-size: 12px;
                margin-bottom: 6px;
            }
            
            .form-input,
            .form-textarea {
                font-size: 16px;
                padding: 10px 12px;
            }
            
            .form-textarea {
                min-height: 70px;
            }
            
            .day-label {
                font-size: 13px;
            }
            
            .hours-row label {
                font-size: 11px !important;
            }
            
            .hours-row input[type="time"] {
                font-size: 14px;
                padding: 8px 10px !important;
                width: auto !important;
                flex: 1;
            }
            
            .section-title {
                font-size: 14px;
            }
            
            .toggle-text {
                font-size: 12px;
            }
            
            .toggle-switch {
                width: 45px;
                height: 22px;
            }
            
            .toggle-slider:before {
                height: 16px;
                width: 16px;
            }
            
            input:checked + .toggle-slider:before {
                transform: translateX(23px);
            }
            
            .btn {
                font-size: 13px;
                padding: 10px 18px;
            }
            
            .success-message {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Overlay for mobile sidebar -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-logo">
                <div class="logo-letters">NV</div>
                <div class="brand-name">Nailed by Via</div>
            </div>
        </div>
        
        <div class="nav-section">
            <div class="nav-title">Management</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.appointments') }}" class="nav-item">
                <i class="fas fa-calendar-alt"></i>
                Appointments
            </a>
            <a href="{{ route('admin.services') }}" class="nav-item">
                <i class="fas fa-spa"></i>
                Services
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item">
                <i class="fas fa-users"></i>
                Customers
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-title">Business</div>
            <a href="{{ route('admin.reports') }}" class="nav-item">
                <i class="fas fa-chart-bar"></i>
                Analytics
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-title">System</div>
            <a href="{{ route('admin.settings') }}" class="nav-item active">
                <i class="fas fa-cog"></i>
                Settings
            </a>
            <a href="{{ route('admin.activity-log') }}" class="nav-item">
                <i class="fas fa-file-alt"></i>
                Activity Log
            </a>
        </div>
        
        <div class="nav-section">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="width: 100%; border: none; background: none; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="search-bar">
                <input type="text" placeholder="Search customers...">
                <i class="fas fa-search"></i>
            </div>
            
            <div class="user-profile">
                <div class="profile-info">
                    <div class="profile-pic">
                        <img src="{{ asset('images/viaflor.png') }}" alt="ViaFlor" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    </div>
                    <div class="profile-details">
                        <h4>ViaFlor P. Sabior</h4>
                        <p>Owner</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="settings-content">
            <h1 class="page-title">Settings</h1>
            
            @if(session('success'))
                <div class="success-message" style="display: block; margin-bottom: 25px;">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="success-message" style="display: block; margin-bottom: 25px; background: #f8d7da; color: #721c24;">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="success-message" style="display: block; margin-bottom: 25px; background: #f8d7da; color: #721c24;">
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin: 10px 0 0 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('admin.settings.update-all') }}">
                @csrf
                <div class="settings-grid">
                    <!-- Business Information Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="fas fa-folder"></i>
                            </div>
                            <h3 class="card-title">Business Information</h3>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Business Name</label>
                            <input type="text" class="form-input" name="business_name" value="{{ $businessInfo['business_name'] }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Contact Email</label>
                            <input type="email" class="form-input" name="contact_email" value="{{ $businessInfo['contact_email'] }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-input" name="phone_number" value="{{ $businessInfo['phone_number'] }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Business Address</label>
                            <textarea class="form-textarea" name="business_address" required>{{ $businessInfo['business_address'] }}</textarea>
                        </div>
                    </div>

                    <!-- Business Hours Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3 class="card-title">Business Hours</h3>
                        </div>
                        
                        <div class="hours-grid">
                            @foreach(['monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday'] as $day => $dayName)
                                <div class="hours-row">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span class="day-label">{{ $dayName }}</span>
                                        <label style="display: flex; align-items: center; gap: 5px; font-size: 12px;">
                                            <input type="checkbox" name="{{ $day }}_closed" {{ $businessHours[$day]['closed'] ? 'checked' : '' }}>
                                            Closed
                                        </label>
                                    </div>
                                    <div style="display: flex; gap: 10px; align-items: center;">
                                        <input type="time" class="form-input" name="{{ $day }}_open" value="{{ $businessHours[$day]['open'] }}" style="width: 120px;" {{ $businessHours[$day]['closed'] ? 'disabled' : '' }}>
                                        <span>-</span>
                                        <input type="time" class="form-input" name="{{ $day }}_close" value="{{ $businessHours[$day]['close'] }}" style="width: 120px;" {{ $businessHours[$day]['closed'] ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Security Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h3 class="card-title">Security</h3>
                        </div>
                        
                        <div class="security-section">
                            <h4 class="section-title">Change Password</h4>
                            <div class="form-group">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-input" name="current_password">
                            </div>
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-input" name="new_password">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-input" name="new_password_confirmation">
                            </div>
                        </div>
                        
                        <div class="security-section">
                            <h4 class="section-title">Security Settings</h4>
                            <div class="form-group">
                                <label class="form-label">Password Minimum Length</label>
                                <input type="number" class="form-input" name="password_min_length" value="{{ $securitySettings['password_min_length'] }}" min="6" max="20">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Session Timeout (minutes)</label>
                                <input type="number" class="form-input" name="session_timeout" value="{{ $securitySettings['session_timeout'] }}" min="30" max="480">
                            </div>
                            <div class="toggle-label">
                                <span class="toggle-text">Two-Factor Authentication</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="two_factor_enabled" {{ $securitySettings['two_factor_enabled'] ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Single Save Button -->
                <div style="margin-top: 30px; text-align: center;">
                    <button type="submit" class="btn" style="max-width: 400px; font-size: 16px; padding: 15px 40px;">
                        <i class="fas fa-save" style="margin-right: 8px;"></i>
                        Save All Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('show');
        }
        
        // Handle business hours checkboxes
        document.querySelectorAll('input[type="checkbox"][name$="_closed"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const day = this.name.replace('_closed', '');
                const openInput = document.querySelector(`input[name="${day}_open"]`);
                const closeInput = document.querySelector(`input[name="${day}_close"]`);
                
                if (this.checked) {
                    openInput.disabled = true;
                    closeInput.disabled = true;
                    openInput.value = '00:00';
                    closeInput.value = '00:00';
                } else {
                    openInput.disabled = false;
                    closeInput.disabled = false;
                    // Set default hours if they were closed
                    if (openInput.value === '00:00' && closeInput.value === '00:00') {
                        if (day === 'saturday') {
                            openInput.value = '10:00';
                            closeInput.value = '20:00';
                        } else if (day === 'sunday') {
                            // Keep Sunday closed by default
                            this.checked = true;
                            openInput.disabled = true;
                            closeInput.disabled = true;
                        } else {
                            openInput.value = '09:00';
                            closeInput.value = '19:00';
                        }
                    }
                }
            });
        });

        // Search functionality
        document.querySelector('.search-bar input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            // Add search functionality here if needed
        });

        // Auto-hide success messages
        setTimeout(() => {
            const successMessages = document.querySelectorAll('.success-message');
            successMessages.forEach(msg => {
                if (msg.style.display === 'block') {
                    msg.style.display = 'none';
                }
            });
        }, 5000);
    </script>
</body>
</html>

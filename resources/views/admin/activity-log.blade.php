<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log - Nailed by Via</title>
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
        
        /* Activity Log Content */
        .activity-content {
            padding: 30px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }
        
        .time-filter {
            position: relative;
            display: inline-block;
        }
        
        .filter-dropdown {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: white;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 150px;
        }
        
        .filter-dropdown:hover {
            border-color: #b48b8b;
        }
        
        .filter-options {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
        }
        
        .filter-options.show {
            display: block;
        }
        
        .filter-option {
            padding: 10px 15px;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .filter-option:hover {
            background: #f8f9fa;
        }
        
        .filter-option.active {
            background: #b48b8b;
            color: white;
        }
        
        /* Activity Table */
        .activity-table {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th {
            background: #b48b8b;
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }
        
        .table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            vertical-align: middle;
        }
        
        .table tr:hover {
            background: #f8f9fa;
        }
        
        .table tr:last-child td {
            border-bottom: none;
        }
        
        .timestamp {
            color: #666;
            font-size: 13px;
            font-weight: 500;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #b48b8b;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }
        
        .user-details h4 {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }
        
        .user-role {
            font-size: 12px;
            color: #666;
        }
        
        .action-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .action-updated {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .action-booking {
            background: #d4edda;
            color: #155724;
        }
        
        .action-payment {
            background: #fff3cd;
            color: #856404;
        }
        
        .action-added {
            background: #f8d7da;
            color: #721c24;
        }
        
        .details {
            color: #333;
            font-size: 14px;
        }
        
        .ip-address {
            color: #666;
            font-size: 13px;
            font-family: 'Courier New', monospace;
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
            .page-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .search-bar {
                width: 100%;
                max-width: 400px;
            }
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 260px;
            }
            
            .main-content {
                margin-left: 260px;
            }
            
            .header {
                padding: 15px 20px;
            }
            
            .activity-content {
                padding: 20px;
            }
            
            .profile-details {
                display: none;
            }
            
            /* Make table scrollable on tablet */
            .activity-table {
                overflow-x: auto;
            }
            
            .table {
                min-width: 800px;
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
                padding: 15px 15px 15px 60px;
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .search-bar {
                width: 100%;
                max-width: 100%;
            }
            
            .user-profile {
                justify-content: space-between;
            }
            
            .profile-details {
                display: none;
            }
            
            .activity-content {
                padding: 15px;
            }
            
            .page-title {
                font-size: 22px;
            }
            
            .page-header {
                gap: 15px;
            }
            
            /* Convert table to card layout on mobile */
            .activity-table {
                background: transparent;
                box-shadow: none;
            }
            
            .table thead {
                display: none;
            }
            
            .table tbody {
                display: block;
            }
            
            .table tr {
                display: block;
                background: white;
                margin-bottom: 15px;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                padding: 15px;
            }
            
            .table td {
                display: block;
                border: none;
                padding: 8px 0;
                text-align: left;
            }
            
            .table td:before {
                content: attr(data-label);
                font-weight: 600;
                color: #666;
                display: block;
                margin-bottom: 5px;
                font-size: 12px;
                text-transform: uppercase;
            }
            
            .table tr:hover {
                background: white;
            }
            
            .timestamp {
                font-size: 12px;
            }
            
            .user-info {
                gap: 8px;
            }
            
            .user-avatar {
                width: 36px;
                height: 36px;
            }
            
            .filter-dropdown {
                font-size: 13px;
                padding: 8px 12px;
                min-width: 120px;
            }
        }
        
        @media (max-width: 480px) {
            .page-title {
                font-size: 20px;
            }
            
            .header {
                padding: 12px 12px 12px 55px;
            }
            
            .activity-content {
                padding: 12px;
            }
            
            .search-bar input {
                padding: 10px 40px 10px 12px;
                font-size: 13px;
            }
            
            .filter-dropdown {
                font-size: 12px;
                padding: 7px 10px;
                min-width: 110px;
            }
            
            .user-details h4 {
                font-size: 13px;
            }
            
            .action-badge {
                font-size: 10px;
                padding: 3px 6px;
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
            <a href="{{ route('admin.settings') }}" class="nav-item">
                <i class="fas fa-cog"></i>
                Settings
            </a>
            <a href="{{ route('admin.activity-log') }}" class="nav-item active">
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
                <input type="text" placeholder="Search activity..." value="{{ request('search', '') }}">
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

        <!-- Activity Log Content -->
        <div class="activity-content">
            <div class="page-header">
                <h1 class="page-title">Activity Log</h1>
                
                <div class="time-filter">
                    <div class="filter-dropdown" onclick="toggleFilter()">
                        <span id="selected-filter">
                            @switch($period)
                                @case('today') Today @break
                                @case('this_week') This Week @break
                                @case('this_month') This Month @break
                                @case('last_month') Last Month @break
                                @case('this_year') This Year @break
                                @default This Month
                            @endswitch
                        </span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="filter-options" id="filter-options">
                        <div class="filter-option {{ $period === 'today' ? 'active' : '' }}" data-value="today">Today</div>
                        <div class="filter-option {{ $period === 'this_week' ? 'active' : '' }}" data-value="this_week">This Week</div>
                        <div class="filter-option {{ $period === 'this_month' ? 'active' : '' }}" data-value="this_month">This Month</div>
                        <div class="filter-option {{ $period === 'last_month' ? 'active' : '' }}" data-value="last_month">Last Month</div>
                        <div class="filter-option {{ $period === 'this_year' ? 'active' : '' }}" data-value="this_year">This Year</div>
                    </div>
                </div>
            </div>
            
            <!-- Activity Table -->
            <div class="activity-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Details</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activityLogs as $log)
                            <tr>
                                <td class="timestamp" data-label="Timestamp">{{ $log->formatted_timestamp }}</td>
                                <td data-label="User">
                                    <div class="user-info">
                                        <div class="user-avatar">{{ substr($log->user_name, 0, 2) }}</div>
                                        <div class="user-details">
                                            <h4>{{ $log->user_name }}</h4>
                                            <span class="user-role">{{ $log->user_role }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Action">
                                    <span class="action-badge {{ $log->action_badge_color }}">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="details" data-label="Details">{{ $log->details }}</td>
                                <td class="ip-address" data-label="IP Address">{{ $log->ip_address }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #666;">
                                    No activity logs found for the selected period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($activityLogs->hasPages())
                <div class="pagination-container" style="margin-top: 20px; display: flex; justify-content: center;">
                    {{ $activityLogs->appends(request()->query())->links() }}
                </div>
            @endif
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
        
        // Filter dropdown functionality
        function toggleFilter() {
            const options = document.getElementById('filter-options');
            options.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const filter = document.querySelector('.time-filter');
            const options = document.getElementById('filter-options');
            
            if (!filter.contains(event.target)) {
                options.classList.remove('show');
            }
        });

        // Filter option selection
        document.querySelectorAll('.filter-option').forEach(option => {
            option.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                const text = this.textContent;
                
                // Update selected filter text
                document.getElementById('selected-filter').textContent = text;
                
                // Update active state
                document.querySelectorAll('.filter-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                // Close dropdown
                document.getElementById('filter-options').classList.remove('show');
                
                // Filter activities based on selection
                filterActivities(value);
            });
        });

        // Filter activities function
        function filterActivities(timeframe) {
            // Reload page with new filter parameter
            const url = new URL(window.location);
            url.searchParams.set('period', timeframe);
            window.location.href = url.toString();
        }

        // Search functionality
        let searchTimeout;
        document.querySelector('.search-bar input').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value;
            
            searchTimeout = setTimeout(() => {
                if (searchTerm.length >= 2 || searchTerm.length === 0) {
                    const url = new URL(window.location);
                    if (searchTerm) {
                        url.searchParams.set('search', searchTerm);
                    } else {
                        url.searchParams.delete('search');
                    }
                    window.location.href = url.toString();
                }
            }, 500);
        });
    </script>
</body>
</html>

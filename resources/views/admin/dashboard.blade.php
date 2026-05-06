    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dashboard - Nailed by Via</title>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            
            .header-actions {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            .refresh-btn {
                background: #b48b8b;
                border: none;
                color: white;
                padding: 10px 12px;
                border-radius: 8px;
                cursor: pointer;
                font-size: 14px;
                transition: background 0.3s;
            }
            
            .refresh-btn:hover {
                background: #a17a7a;
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
            
            /* Dashboard Content */
            .dashboard-content {
                padding: 30px;
            }
            
            /* KPI Cards */
            .kpi-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                margin-bottom: 30px;
            }
            
            .kpi-card {
                background: #fff;
                padding: 25px;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                display: flex;
                align-items: center;
                gap: 15px;
            }
            
            .kpi-icon {
                width: 50px;
                height: 50px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                color: white;
            }
            
            .kpi-icon.blue { background: #4e73df; }
            .kpi-icon.green { background: #1cc88a; }
            .kpi-icon.orange { background: #f6c23e; }
            .kpi-icon.purple { background: #e83e8c; }
            
            .kpi-info h3 {
                font-size: 28px;
                font-weight: 700;
                color: #333;
                margin-bottom: 5px;
            }
            
            .kpi-info p {
                color: #666;
                font-size: 14px;
            }
            
            /* Charts Section */
            .charts-section {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 20px;
                margin-bottom: 30px;
            }
            
            .chart-card {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                padding: 25px;
            }
            
            .chart-title {
                font-size: 18px;
                font-weight: 600;
                color: #333;
                margin-bottom: 20px;
            }
            
            .chart-container {
                position: relative;
                height: 300px;
            }
            
            /* Data Tables */
            .tables-section {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 20px;
            }
            
            .table-card {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                padding: 25px;
            }
            
            .table-title {
                font-size: 18px;
                font-weight: 600;
                color: #333;
                margin-bottom: 20px;
            }
            
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            
            .table th {
                text-align: left;
                padding: 12px 0;
                border-bottom: 1px solid #eee;
                color: #666;
                font-weight: 600;
                font-size: 14px;
            }
            
            .table td {
                padding: 12px 0;
                border-bottom: 1px solid #f8f9fa;
                font-size: 14px;
            }
            
            .status-badge {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
            }
            
            .status-completed {
                background: #d4edda;
                color: #155724;
            }
            
            .status-confirmed {
                background: #cce5ff;
                color: #004085;
            }
            
            .status-pending {
                background: #fff3cd;
                color: #856404;
            }
            
            .status-upcoming {
                background: #fff3cd;
                color: #856404;
            }
            
            .status-cancelled {
                background: #f8d7da;
                color: #721c24;
            }
            
            .service-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 0;
                border-bottom: 1px solid #f8f9fa;
            }
            
            .service-item:last-child {
                border-bottom: none;
            }
            
            .service-info h4 {
                font-size: 14px;
                font-weight: 600;
                color: #333;
                margin-bottom: 4px;
            }
            
            .service-info p {
                font-size: 12px;
                color: #666;
            }
            
            .service-price {
                font-weight: 600;
                color: #b48b8b;
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
                .kpi-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
                
                .charts-section,
                .tables-section {
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
                
                .dashboard-content {
                    padding: 15px;
                }
                
                .kpi-grid {
                    grid-template-columns: 1fr;
                    gap: 15px;
                }
                
                .kpi-card {
                    padding: 20px;
                    border-radius: 10px;
                    gap: 12px;
                }
                
                .kpi-icon {
                    width: 45px;
                    height: 45px;
                    font-size: 18px;
                }
                
                .kpi-info h3 {
                    font-size: 24px;
                }
                
                .kpi-info p {
                    font-size: 13px;
                }
                
                .charts-section {
                    gap: 15px;
                }
                
                .chart-card {
                    padding: 20px;
                    border-radius: 10px;
                }
                
                .chart-title {
                    font-size: 16px;
                    margin-bottom: 15px;
                }
                
                .chart-container {
                    height: 250px;
                }
                
                .tables-section {
                    gap: 15px;
                }
                
                .table-card {
                    padding: 20px;
                    border-radius: 10px;
                }
                
                .table-title {
                    font-size: 16px;
                    margin-bottom: 15px;
                }
                
                /* Mobile table - Card layout */
                .table {
                    display: block;
                }
                
                .table thead {
                    display: none;
                }
                
                .table tbody {
                    display: block;
                }
                
                .table tr {
                    display: block;
                    margin-bottom: 15px;
                    background: #f8f9fa;
                    border-radius: 8px;
                    padding: 15px;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                }
                
                .table td {
                    display: block;
                    padding: 8px 0;
                    border: none;
                    text-align: left !important;
                }
                
                .table td::before {
                    content: attr(data-label);
                    font-weight: 600;
                    color: #666;
                    display: block;
                    font-size: 12px;
                    margin-bottom: 4px;
                }
                
                .status-badge {
                    display: inline-block;
                    margin-top: 4px;
                }
                
                .service-item {
                    padding: 12px 0;
                }
                
                .service-info h4 {
                    font-size: 13px;
                }
                
                .service-info p {
                    font-size: 11px;
                }
                
                .service-price {
                    font-size: 15px;
                }
            }
            
            @media (max-width: 480px) {
                .dashboard-content {
                    padding: 12px;
                }
                
                .kpi-card {
                    padding: 16px;
                    gap: 10px;
                }
                
                .kpi-icon {
                    width: 40px;
                    height: 40px;
                    font-size: 16px;
                }
                
                .kpi-info h3 {
                    font-size: 22px;
                }
                
                .kpi-info p {
                    font-size: 12px;
                }
                
                .chart-card {
                    padding: 16px;
                }
                
                .chart-title {
                    font-size: 15px;
                }
                
                .chart-container {
                    height: 220px;
                }
                
                .table-card {
                    padding: 16px;
                }
                
                .table-title {
                    font-size: 15px;
                }
                
                .table tr {
                    padding: 12px;
                }
                
                .table td {
                    font-size: 13px;
                }
                
                .status-badge {
                    font-size: 11px;
                    padding: 3px 10px;
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
                <div class="nav-title">Main</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-title">Management</div>
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
                    <input type="text" placeholder="Search appointments, customers...">
                    <i class="fas fa-search"></i>
                </div>
                
                <div class="header-actions">
                    <button onclick="location.reload()" class="refresh-btn" title="Refresh Dashboard">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                
                <div class="user-profile">
                    <div class="profile-info">
                        <div class="profile-pic">
                            <img src="{{ asset('images/viaflor.png') }}" alt="ViaFlor" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                        </div>
                        <div class="profile-details">
                            <h4>ViaFlor P. Sabior</h4>
                            <p>Owner</p>
                            <small style="color: #999; font-size: 10px;">Last updated: {{ now()->format('M j, g:i A') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- KPI Cards -->
                <div class="kpi-grid">
                    <div class="kpi-card">
                        <div class="kpi-icon blue">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="kpi-info">
                            <h3 id="todayAppointments">0</h3>
                            <p>Today's Appointments</p>
                            <small style="color: #999; font-size: 10px;">Loading...</small>
                        </div>
                    </div>
                    
                    <div class="kpi-card">
                        <div class="kpi-icon green">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="kpi-info">
                            <h3 id="todayRevenue">₱0</h3>
                            <p>Today's Revenue</p>
                        </div>
                    </div>
                    
                    <div class="kpi-card">
                        <div class="kpi-icon orange">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="kpi-info">
                            <h3 id="newCustomersWeek">0</h3>
                            <p>New This Week</p>
                        </div>
                    </div>
                    
                    <div class="kpi-card">
                        <div class="kpi-icon purple">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="kpi-info">
                            <h3 id="pendingAppointments">0</h3>
                            <p>Pending</p>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="charts-section">
                    <div class="chart-card">
                        <h3 class="chart-title">Revenue Last 6 Months</h3>
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="chart-card">
                        <h3 class="chart-title">Appointments This Week</h3>
                        <div class="chart-container">
                            <canvas id="customerChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Data Tables -->
                <div class="tables-section">
                    <div class="table-card">
                        <h3 class="table-title">Recent Appointments</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAppointments as $appointment)
                                    <tr>
                                        <td data-label="Customer">{{ $appointment->user->name }}</td>
                                        <td data-label="Service">{{ $appointment->service->name }}</td>
                                        <td data-label="Date">{{ $appointment->appointment_date->format('M j, g:i A') }}</td>
                                        <td data-label="Amount">₱{{ number_format($appointment->amount, 0) }}</td>
                                        <td data-label="Status">
                                            @php
                                                $statusClass = match($appointment->status) {
                                                    'completed' => 'status-completed',
                                                    'confirmed' => 'status-confirmed',
                                                    'pending' => 'status-upcoming',
                                                    'cancelled' => 'status-cancelled',
                                                    default => 'status-upcoming'
                                                };
                                            @endphp
                                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($appointment->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 30px; color: #666;">
                                            No appointments found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="table-card">
                        <h3 class="table-title">Top Services (This Month)</h3>
                        @forelse($topServices as $service)
                            <div class="service-item">
                                <div class="service-info">
                                    <h4>{{ $service->name }}</h4>
                                    <p>{{ $service->appointments_count }} {{ $service->appointments_count == 1 ? 'booking' : 'bookings' }}</p>
                                </div>
                                <div class="service-price">₱{{ number_format($service->price, 0) }}</div>
                            </div>
                        @empty
                            <div class="service-item" style="justify-content: center;">
                                <div class="service-info" style="text-align: center; color: #666;">
                                    <p>No bookings this month</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Global variables
            let currentAppointments = [];
            let dashboardData = {};
            
            // Mobile sidebar toggle
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('overlay');
                sidebar.classList.toggle('mobile-open');
                overlay.classList.toggle('show');
            }
            
        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Load data immediately
            loadDashboardData();
            
            // Auto-refresh dashboard every 30 seconds
            setInterval(loadDashboardData, 30000);
        });
            
            // Load all dashboard data dynamically
            function loadDashboardData() {
                loadAppointments();
                loadDashboardStats();
            }
            
            // Load appointments from backend
            function loadAppointments() {
                fetch('/admin/appointments/all', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(appointments => {
                    if (Array.isArray(appointments)) {
                        currentAppointments = appointments;
                        updateDashboardWithAppointments(appointments);
                    } else {
                        console.error('Invalid appointments data received:', appointments);
                    }
                })
                .catch(error => {
                    console.error('Error loading appointments:', error);
                });
            }
            
            // Load dashboard statistics
            function loadDashboardStats() {
                fetch('/admin/dashboard/stats', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(stats => {
                    if (stats && typeof stats === 'object') {
                        dashboardData = stats;
                        updateDashboardStats(stats);
                    } else {
                        console.error('Invalid dashboard stats received:', stats);
                    }
                })
                .catch(error => {
                    console.error('Error loading dashboard stats:', error);
                });
            }
            
            // Update dashboard with appointments data
            function updateDashboardWithAppointments(appointments) {
                // Get today's date in YYYY-MM-DD format for comparison
                const today = new Date();
                const todayString = today.getFullYear() + '-' + 
                    String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                    String(today.getDate()).padStart(2, '0');
                
                // Calculate today's appointments by comparing date strings
                const todayAppointments = appointments.filter(apt => {
                    const aptDate = new Date(apt.appointment_date);
                    const aptDateString = aptDate.getFullYear() + '-' + 
                        String(aptDate.getMonth() + 1).padStart(2, '0') + '-' + 
                        String(aptDate.getDate()).padStart(2, '0');
                    return aptDateString === todayString;
                });
                
                // Calculate today's revenue
                const todayRevenue = todayAppointments
                    .filter(apt => apt.payment_status === 'paid')
                    .reduce((sum, apt) => sum + parseFloat(apt.amount || 0), 0);
                
                // Get recent appointments (last 5)
                const recentAppointments = appointments
                    .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                    .slice(0, 5);
                
                // Update the dashboard display
                updateKPI('todayAppointments', todayAppointments.length);
                updateKPI('todayRevenue', todayRevenue);
                updateRecentAppointments(recentAppointments);
                
                // Debug logging
                console.log('Today string:', todayString);
                console.log('Today appointments found:', todayAppointments.length);
                console.log('All appointments:', appointments.length);
                console.log('Today appointments details:', todayAppointments.map(apt => ({
                    id: apt.id,
                    date: apt.appointment_date,
                    customer: apt.user?.name
                })));
            }
            
        // Update KPI cards
        function updateKPI(type, value) {
            const elements = {
                'todayAppointments': document.getElementById('todayAppointments'),
                'todayRevenue': document.getElementById('todayRevenue'),
                'newCustomersWeek': document.getElementById('newCustomersWeek'),
                'pendingAppointments': document.getElementById('pendingAppointments')
            };
            
            if (elements[type]) {
                if (type === 'todayRevenue') {
                    elements[type].textContent = '₱' + Math.round(value).toLocaleString();
                } else {
                    elements[type].textContent = value;
                }
            }
        }
            
            // Update recent appointments table
            function updateRecentAppointments(appointments) {
                const tbody = document.querySelector('.table tbody');
                
                if (appointments.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: #666;">
                                No appointments found
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                tbody.innerHTML = appointments.map(appointment => `
                    <tr>
                        <td data-label="Customer">${appointment.user ? appointment.user.name : 'N/A'}</td>
                        <td data-label="Service">${appointment.service ? appointment.service.name : 'N/A'}</td>
                        <td data-label="Date">${formatDateTime(appointment.appointment_date)}</td>
                        <td data-label="Amount">₱${parseFloat(appointment.amount || 0).toFixed(0)}</td>
                        <td data-label="Status">
                            <span class="status-badge status-${appointment.status.toLowerCase()}">${appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1)}</span>
                        </td>
                    </tr>
                `).join('');
            }
            
        // Update dashboard statistics
        function updateDashboardStats(stats) {
            // Update other KPI cards if needed
            if (stats.newCustomersWeek !== undefined) {
                updateKPI('newCustomersWeek', stats.newCustomersWeek);
            }
            
            if (stats.pendingAppointments !== undefined) {
                updateKPI('pendingAppointments', stats.pendingAppointments);
            }
        }
            
            // Utility function to format date/time
            function formatDateTime(dateTimeString) {
                if (!dateTimeString) return 'N/A';
                
                const date = new Date(dateTimeString);
                if (isNaN(date.getTime())) return 'N/A';
                
                return date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
            }
            
            // Revenue Chart - Last 6 Months
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const monthlyRevenueData = @json($monthlyRevenue);
            const monthlyLabels = @json($monthlyLabels);
            
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Revenue',
                        data: monthlyRevenueData,
                        borderColor: '#b48b8b',
                        backgroundColor: 'rgba(180, 139, 139, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + (value / 1000) + 'k';
                                }
                            }
                        }
                    }
                }
            });

            // Weekly Appointments Chart
            const customerCtx = document.getElementById('customerChart').getContext('2d');
            const weeklyAppointmentsData = @json($weeklyAppointments);
            const weeklyLabels = @json($weeklyLabels);
            
            new Chart(customerCtx, {
                type: 'bar',
                data: {
                    labels: weeklyLabels,
                    datasets: [{
                        label: 'Appointments',
                        data: weeklyAppointmentsData,
                        backgroundColor: '#b48b8b',
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        </script>
    </body>
    </html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Nailed by Via</title>
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
        
        /* Analytics Content */
        .analytics-content {
            padding: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }
        
        /* KPI Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .kpi-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .kpi-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        
        .kpi-icon.revenue {
            background: linear-gradient(135deg, #28a745, #20c997);
        }
        
        .kpi-icon.appointments {
            background: linear-gradient(135deg, #007bff, #6610f2);
        }
        
        .kpi-icon.customers {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }
        
        .kpi-icon.spend {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
        }
        
        .kpi-info h3 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .kpi-info p {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .kpi-trend {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .trend-up {
            color: #28a745;
        }
        
        .trend-down {
            color: #dc3545;
        }
        
        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .chart-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
        
        /* Top Customers Table */
        .top-customers-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .table-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .table-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        
        .table-header i {
            color: #b48b8b;
        }
        
        .customers-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .customers-table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }
        
        .customers-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f8f9fa;
            font-size: 14px;
            vertical-align: middle;
        }
        
        .customers-table tr:hover {
            background: #f8f9fa;
        }
        
        .customer-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #b48b8b;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }
        
        .customer-details h4 {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        
        .appointments-count {
            font-weight: 600;
            color: #333;
            text-align: center;
        }
        
        .total-spend {
            font-weight: 600;
            color: #b48b8b;
        }
        
        .last-visit {
            color: #666;
            font-size: 13px;
        }
        
        .loyalty-bar {
            width: 100px;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .loyalty-fill {
            height: 100%;
            background: linear-gradient(90deg, #b48b8b, #a07a7a);
            border-radius: 4px;
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
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .kpi-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
            
            .analytics-content {
                padding: 15px;
            }
            
            .page-title {
                font-size: 22px;
                margin-bottom: 20px;
            }
            
            .kpi-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .kpi-card {
                padding: 20px;
                border-radius: 10px;
            }
            
            .kpi-icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
            
            .kpi-info h3 {
                font-size: 24px;
            }
            
            .kpi-info p {
                font-size: 13px;
            }
            
            .kpi-trend {
                font-size: 11px;
            }
            
            .charts-grid {
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
            
            .top-customers-card {
                padding: 20px;
                border-radius: 10px;
            }
            
            .table-header h3 {
                font-size: 16px;
            }
            
            /* Mobile table - Card layout */
            .customers-table {
                display: block;
            }
            
            .customers-table thead {
                display: none;
            }
            
            .customers-table tbody {
                display: block;
            }
            
            .customers-table tr {
                display: block;
                margin-bottom: 15px;
                background: #f8f9fa;
                border-radius: 8px;
                padding: 15px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            
            .customers-table tr:hover {
                background: #f0f0f0;
            }
            
            .customers-table td {
                display: block;
                padding: 8px 0;
                border: none;
                text-align: left !important;
            }
            
            .customers-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #666;
                display: block;
                font-size: 12px;
                margin-bottom: 4px;
            }
            
            .customers-table td:first-child::before {
                display: none;
            }
            
            .customer-info {
                margin-bottom: 10px;
            }
            
            .customer-avatar {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }
            
            .customer-details h4 {
                font-size: 13px;
            }
            
            .appointments-count,
            .total-spend,
            .last-visit {
                font-size: 13px;
            }
            
            .loyalty-bar {
                width: 100%;
                max-width: 200px;
            }
        }
        
        @media (max-width: 480px) {
            .analytics-content {
                padding: 12px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .kpi-card {
                padding: 16px;
                gap: 15px;
            }
            
            .kpi-icon {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
            
            .kpi-info h3 {
                font-size: 22px;
            }
            
            .kpi-info p {
                font-size: 12px;
            }
            
            .kpi-trend {
                font-size: 10px;
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
            
            .top-customers-card {
                padding: 16px;
            }
            
            .table-header h3 {
                font-size: 15px;
            }
            
            .customers-table tr {
                padding: 12px;
            }
            
            .customer-avatar {
                width: 32px;
                height: 32px;
                font-size: 13px;
            }
            
            .customer-details h4 {
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
            <a href="{{ route('admin.reports') }}" class="nav-item active">
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
                <input type="text" placeholder="Search analytics...">
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

        <!-- Analytics Content -->
        <div class="analytics-content">
            <h1 class="page-title">Business Analytics</h1>
            
            <!-- KPI Cards -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-icon revenue">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="kpi-info">
                        <h3>{{ $analytics['kpis']['total_revenue']['formatted'] }}</h3>
                        <p>Total Revenue</p>
                        <div class="kpi-trend {{ $analytics['kpis']['total_revenue']['change'] >= 0 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas fa-arrow-{{ $analytics['kpis']['total_revenue']['change'] >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ abs($analytics['kpis']['total_revenue']['change']) }}% from last month</span>
                        </div>
                    </div>
                </div>
                
                <div class="kpi-card">
                    <div class="kpi-icon appointments">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="kpi-info">
                        <h3>{{ $analytics['kpis']['appointments']['formatted'] }}</h3>
                        <p>Appointments</p>
                        <div class="kpi-trend {{ $analytics['kpis']['appointments']['change'] >= 0 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas fa-arrow-{{ $analytics['kpis']['appointments']['change'] >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ abs($analytics['kpis']['appointments']['change']) }}% from last month</span>
                        </div>
                    </div>
                </div>
                
                <div class="kpi-card">
                    <div class="kpi-icon customers">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="kpi-info">
                        <h3>{{ $analytics['kpis']['new_customers']['formatted'] }}</h3>
                        <p>New Customers</p>
                        <div class="kpi-trend {{ $analytics['kpis']['new_customers']['change'] >= 0 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas fa-arrow-{{ $analytics['kpis']['new_customers']['change'] >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ abs($analytics['kpis']['new_customers']['change']) }}% from last month</span>
                        </div>
                    </div>
                </div>
                
                <div class="kpi-card">
                    <div class="kpi-icon spend">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="kpi-info">
                        <h3>{{ $analytics['kpis']['avg_spend']['formatted'] }}</h3>
                        <p>Avg. Spend</p>
                        <div class="kpi-trend {{ $analytics['kpis']['avg_spend']['change'] >= 0 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas fa-arrow-{{ $analytics['kpis']['avg_spend']['change'] >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ abs($analytics['kpis']['avg_spend']['change']) }}% from last month</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-grid">
                <!-- Monthly Revenue Chart -->
                <div class="chart-card">
                    <h3 class="chart-title">Monthly Revenue</h3>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
                
                <!-- Service Locations Chart -->
                <div class="chart-card">
                    <h3 class="chart-title">Service Locations</h3>
                    <div class="chart-container">
                        <canvas id="locationsChart"></canvas>
                    </div>
                </div>
                
                <!-- Service Performance Chart -->
                <div class="chart-card">
                    <h3 class="chart-title">Service Performance</h3>
                    <div class="chart-container">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Customers Table -->
            <div class="top-customers-card">
                <div class="table-header">
                    <i class="fas fa-star"></i>
                    <h3>Top Customers</h3>
                </div>
                
                <table class="customers-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Appointments</th>
                            <th>Total Spend</th>
                            <th>Last Visit</th>
                            <th>Loyalty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($analytics['top_customers'] as $customer)
                            <tr>
                                <td data-label="Customer">
                                    <div class="customer-info">
                                        <div class="customer-avatar">{{ substr($customer['name'], 0, 2) }}</div>
                                        <div class="customer-details">
                                            <h4>{{ $customer['name'] }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td class="appointments-count" data-label="Appointments">{{ $customer['appointments'] }}</td>
                                <td class="total-spend" data-label="Total Spend">₱{{ number_format($customer['total_spend'], 0) }}</td>
                                <td class="last-visit" data-label="Last Visit">{{ $customer['last_visit'] }}</td>
                                <td data-label="Loyalty">
                                    <div class="loyalty-bar">
                                        @php
                                            $loyaltyWidth = 0;
                                            switch($customer['loyalty']) {
                                                case 'Gold': $loyaltyWidth = 100; break;
                                                case 'Silver': $loyaltyWidth = 75; break;
                                                case 'Bronze': $loyaltyWidth = 50; break;
                                                default: $loyaltyWidth = 25; break;
                                            }
                                        @endphp
                                        <div class="loyalty-fill" style="width: {{ $loyaltyWidth }}%;"></div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #666;">
                                    No customer data available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
        
        // Monthly Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($analytics['monthly_revenue']['months']),
                datasets: [{
                    label: 'Monthly Revenue',
                    data: @json($analytics['monthly_revenue']['revenues']),
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

        // Service Locations Chart
        const locationsCtx = document.getElementById('locationsChart').getContext('2d');
        const locationData = @json($analytics['service_locations']);
        
        new Chart(locationsCtx, {
            type: 'doughnut',
            data: {
                labels: locationData.length > 0 ? locationData.map(item => item.name) : ['No Data'],
                datasets: [{
                    data: locationData.length > 0 ? locationData.map(item => item.count) : [1],
                    backgroundColor: ['#b48b8b', '#a07a7a', '#8b6b6b', '#6b4b4b', '#4b2b2b'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Service Performance Chart
        const performanceCtx = document.getElementById('performanceChart').getContext('2d');
        const performanceData = @json($analytics['service_performance']);
        
        new Chart(performanceCtx, {
            type: 'bar',
            data: {
                labels: performanceData.length > 0 ? performanceData.map(item => item.name) : ['No Data'],
                datasets: [{
                    label: 'Revenue',
                    data: performanceData.length > 0 ? performanceData.map(item => item.revenue) : [0],
                    backgroundColor: '#b48b8b',
                    borderRadius: 6
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

        // Search functionality
        document.querySelector('.search-bar input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.customers-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

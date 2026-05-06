<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Appointments Management - Nailed by Via</title>
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
        
        /* Appointments Content */
        .appointments-content {
            padding: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }
        
        /* Filters Section */
        .filters-section {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .filters-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #b48b8b;
            border-radius: 20px;
            background: transparent;
            color: #b48b8b;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .filter-btn.active {
            background: #b48b8b;
            color: white;
        }
        
        .filter-btn:hover {
            background: #b48b8b;
            color: white;
        }
        
        .date-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .date-range label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }
        
        .date-input {
            position: relative;
        }
        
        .date-input input {
            padding: 8px 35px 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            width: 120px;
        }
        
        .date-input i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 12px;
        }
        
        .new-appointment-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }
        
        .new-appointment-btn:hover {
            background: #c82333;
        }
        
        /* Appointments Table */
        .appointments-table {
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
            background: #f8f9fa;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }
        
        .table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f8f9fa;
            font-size: 14px;
        }
        
        .table tr:hover {
            background: #f8f9fa;
        }
        
        .appointment-id {
            font-weight: 600;
            color: #b48b8b;
        }
        
        .customer-name {
            font-weight: 500;
            color: #333;
        }
        
        .service-name {
            color: #666;
        }
        
        .datetime {
            color: #333;
            font-weight: 500;
        }
        
        .location {
            color: #666;
            font-size: 13px;
        }
        
        .amount {
            font-weight: 600;
            color: #b48b8b;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-completed {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .edit-btn {
            background: #f8f9fa;
            color: #666;
        }
        
        .edit-btn:hover {
            background: #e9ecef;
            color: #333;
        }
        
        .delete-btn {
            background: #f8d7da;
            color: #721c24;
        }
        
        .delete-btn:hover {
            background: #f5c6cb;
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
            .filters-row {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filter-buttons {
                order: 1;
                width: 100%;
            }
            
            .date-range {
                order: 2;
                width: 100%;
                flex-wrap: wrap;
            }
            
            .new-appointment-btn {
                order: 3;
                align-self: flex-end;
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
            
            .appointments-content {
                padding: 15px;
            }
            
            .page-title {
                font-size: 22px;
                margin-bottom: 20px;
            }
            
            .filters-section {
                padding: 15px;
            }
            
            .filters-row {
                gap: 15px;
            }
            
            .filter-buttons {
                display: flex;
                overflow-x: auto;
                white-space: nowrap;
                gap: 8px;
                padding-bottom: 5px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
                scrollbar-color: #b48b8b #f0f0f0;
            }
            
            .filter-buttons::-webkit-scrollbar {
                height: 6px;
            }
            
            .filter-buttons::-webkit-scrollbar-track {
                background: #f0f0f0;
                border-radius: 10px;
            }
            
            .filter-buttons::-webkit-scrollbar-thumb {
                background: #b48b8b;
                border-radius: 10px;
            }
            
            .filter-btn {
                flex-shrink: 0;
                font-size: 13px;
                padding: 7px 14px;
            }
            
            .date-range {
                flex-direction: column;
                width: 100%;
                gap: 8px;
            }
            
            .date-range label {
                font-size: 13px;
            }
            
            .date-input {
                width: 100%;
            }
            
            .date-input input {
                width: 100%;
                font-size: 14px;
            }
            
            .new-appointment-btn {
                width: 100%;
                justify-content: center;
                padding: 11px 18px;
                font-size: 13px;
            }
            
            /* Mobile table - Card layout */
            .appointments-table {
                border-radius: 0;
            }
            
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
                background: #fff;
                border-radius: 8px;
                padding: 15px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                border-bottom: none;
            }
            
            .table tr:hover {
                background: #f8f9fa;
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
            
            .table td:first-child::before {
                display: none;
            }
            
            .appointment-id {
                font-size: 16px;
                margin-bottom: 10px;
                display: block;
            }
            
            .customer-name,
            .service-name,
            .datetime,
            .location,
            .amount {
                font-size: 13px;
            }
            
            .status-badge {
                display: inline-block;
                margin-top: 4px;
            }
            
            .actions {
                margin-top: 10px;
                justify-content: flex-start;
            }
            
            .action-btn {
                width: 36px;
                height: 36px;
            }
        }
        
        @media (max-width: 480px) {
            .appointments-content {
                padding: 12px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .filters-section {
                padding: 12px;
            }
            
            .filter-btn {
                font-size: 12px;
                padding: 6px 12px;
            }
            
            .table tr {
                padding: 12px;
            }
            
            .appointment-id {
                font-size: 15px;
            }
            
            .table td {
                font-size: 12px;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fff;
            margin: 20px;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
            border-radius: 12px 12px 0 0;
        }

        .modal-header h2 {
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 28px;
            color: #666;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .close-modal:hover {
            background: #f0f0f0;
            color: #333;
        }

        .appointment-form {
            padding: 30px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            background: #fff;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #b48b8b;
            box-shadow: 0 0 0 3px rgba(180, 139, 139, 0.1);
        }

        .form-group input:disabled,
        .form-group select:disabled,
        .form-group textarea:disabled {
            background: #f5f5f5;
            color: #666;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .form-group input:disabled:focus,
        .form-group select:disabled:focus,
        .form-group textarea:disabled:focus {
            border-color: #e9ecef;
            box-shadow: none;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn-cancel,
        .btn-submit {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel {
            background: #f8f9fa;
            color: #666;
            border: 2px solid #e9ecef;
        }

        .btn-cancel:hover {
            background: #e9ecef;
            color: #333;
        }

        .btn-submit {
            background: #b48b8b;
            color: white;
        }

        .btn-submit:hover {
            background: #a07a7a;
            transform: translateY(-1px);
        }

        /* Notification animations */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive adjustments for modal */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                margin: 10px;
                max-height: 85vh;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .modal-header {
                padding: 20px 16px;
            }
            
            .modal-header h2 {
                font-size: 20px;
            }
            
            .appointment-form {
                padding: 20px 16px;
            }
            
            .form-group label {
                font-size: 13px;
            }
            
            .form-group input,
            .form-group select,
            .form-group textarea {
                font-size: 16px; /* Prevents iOS zoom */
                padding: 11px 14px;
            }

            .form-actions {
                flex-direction: column-reverse;
                gap: 10px;
            }

            .btn-cancel,
            .btn-submit {
                width: 100%;
                padding: 11px 20px;
            }
        }
        
        @media (max-width: 480px) {
            .modal-content {
                width: 100%;
                max-width: 100%;
                border-radius: 0;
                margin: 0;
            }
            
            .modal-header h2 {
                font-size: 18px;
            }
            
            .form-group label {
                font-size: 12px;
            }
            
            .form-group input,
            .form-group select,
            .form-group textarea {
                font-size: 16px;
                padding: 10px 12px;
            }
            
            .btn-cancel,
            .btn-submit {
                font-size: 13px;
                padding: 10px 18px;
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
            <a href="{{ route('admin.appointments') }}" class="nav-item active">
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
                <input type="text" placeholder="Search appointments...">
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

        <!-- Appointments Content -->
        <div class="appointments-content">
            <h1 class="page-title">Appointments Management</h1>
            
            <!-- Filters Section -->
            <div class="filters-section">
                <div class="filters-row">
                    <div class="filter-buttons">
                        <button class="filter-btn active" data-filter="all">All</button>
                        <button class="filter-btn" data-filter="pending">Pending</button>
                        <button class="filter-btn" data-filter="completed">Completed</button>
                        <button class="filter-btn" data-filter="cancelled">Cancelled</button>
                    </div>
                    
                    <div class="date-range">
                        <label>Date Range:</label>
                        <div class="date-input">
                            <input type="date" id="start-date">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <span>to</span>
                        <div class="date-input">
                            <input type="date" id="end-date">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                    
                    <button class="new-appointment-btn">
                        <i class="fas fa-plus"></i>
                        New Appointment
                    </button>
                </div>
            </div>

            <!-- Appointments Table -->
            <div class="appointments-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Date/Time</th>
                            <th>Location</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentsTableBody">
                        @if($appointments->count() > 0)
                            @foreach($appointments as $appointment)
                                <tr data-appointment-id="{{ $appointment->id }}">
                                    <td class="appointment-id">#AP-{{ str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="customer-name" data-label="Customer">{{ $appointment->user->name ?? 'N/A' }}</td>
                                    <td class="service-name" data-label="Service">{{ $appointment->service->name ?? 'N/A' }}</td>
                                    <td class="datetime" data-label="Date/Time">{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y, g:i A') : 'N/A' }}</td>
                                    <td class="location" data-label="Location">
                                        @if($appointment->location_type === 'home-service')
                                            Home Service ({{ $appointment->customer_address ?? 'N/A' }})
                                        @else
                                            Walk In
                                        @endif
                            </td>
                                    <td class="amount" data-label="Amount">₱{{ number_format($appointment->amount, 2) }}</td>
                                    <td data-label="Status">
                                        <span class="status-badge status-{{ strtolower($appointment->status) }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                            </td>
                            <td class="actions" data-label="Actions">
                                        <button class="action-btn edit-btn" title="Edit" onclick="editAppointment({{ $appointment->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px; color: #666;">
                                    <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 20px; display: block; color: #ddd;"></i>
                                    <p>No appointments found</p>
                                    <p style="font-size: 14px; margin-top: 10px;">Appointments will appear here when customers book them</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- New Appointment Modal -->
    <div id="newAppointmentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New Appointment</h2>
                <button class="close-modal">&times;</button>
            </div>
            
            <form id="newAppointmentForm" class="appointment-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="customerName">Customer Name *</label>
                        <input type="text" id="customerName" name="customerName" required>
                    </div>
                    <div class="form-group">
                        <label for="customerPhone">Phone Number *</label>
                        <input type="tel" id="customerPhone" name="customerPhone" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="serviceType">Service Type *</label>
                        <select id="serviceType" name="serviceType" required>
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-name="{{ $service->name }}">
                                    {{ $service->name }} - ₱{{ number_format($service->price, 0) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="appointmentDate">Appointment Date *</label>
                        <input type="date" id="appointmentDate" name="appointmentDate" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="appointmentTime">Appointment Time *</label>
                        <input type="time" id="appointmentTime" name="appointmentTime" required>
                    </div>
                    <div class="form-group">
                        <label for="serviceLocation">Service Location *</label>
                        <select id="serviceLocation" name="serviceLocation" required>
                            <option value="">Select Location</option>
                            <option value="home-service">Home Service</option>
                            <option value="walk-in">Walk In</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="customerAddress">Customer Address</label>
                        <textarea id="customerAddress" name="customerAddress" rows="3" placeholder="Enter address for home service"></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="servicePrice">Service Price (₱) *</label>
                        <input type="number" id="servicePrice" name="servicePrice" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="paymentStatus">Payment Status</label>
                        <select id="paymentStatus" name="paymentStatus">
                            <option value="pending">Pending</option>
                            <option value="partial">Partial Payment</option>
                            <option value="paid">Fully Paid</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="notes">Additional Notes</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Any special requests or notes"></textarea>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('newAppointmentModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn-submit">Create Appointment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Appointment Modal -->
    <div id="editAppointmentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Appointment</h2>
                <button class="close-modal" onclick="closeEditModal()">&times;</button>
            </div>
            
            <form id="editAppointmentForm" class="appointment-form">
                <input type="hidden" id="editAppointmentId" name="appointmentId">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editCustomerName">Customer Name *</label>
                        <input type="text" id="editCustomerName" name="customerName" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="editCustomerPhone">Phone Number *</label>
                        <input type="tel" id="editCustomerPhone" name="customerPhone" required disabled>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editServiceType">Service Type *</label>
                        <select id="editServiceType" name="serviceType" required disabled>
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-name="{{ $service->name }}">
                                    {{ $service->name }} - ₱{{ number_format($service->price, 0) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editAppointmentDate">Appointment Date *</label>
                        <input type="date" id="editAppointmentDate" name="appointmentDate" required disabled>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editAppointmentTime">Appointment Time *</label>
                        <input type="time" id="editAppointmentTime" name="appointmentTime" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="editServiceLocation">Service Location *</label>
                        <select id="editServiceLocation" name="serviceLocation" required disabled>
                            <option value="">Select Location</option>
                            <option value="home-service">Home Service</option>
                            <option value="walk-in">Walk In</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editCustomerAddress">Customer Address</label>
                        <textarea id="editCustomerAddress" name="customerAddress" rows="3" placeholder="Enter address for home service" disabled></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editServicePrice">Service Price (₱) *</label>
                        <input type="number" id="editServicePrice" name="servicePrice" min="0" step="0.01" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="editPaymentStatus">Payment Status</label>
                        <select id="editPaymentStatus" name="paymentStatus">
                            <option value="pending">Pending</option>
                            <option value="partial">Partial Payment</option>
                            <option value="paid">Fully Paid</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editAppointmentStatus">Appointment Status</label>
                        <select id="editAppointmentStatus" name="appointmentStatus">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editNotes">Additional Notes</label>
                        <textarea id="editNotes" name="notes" rows="3" placeholder="Any special requests or notes" disabled></textarea>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Global variables
        let currentAppointments = [];
        let currentFilter = 'all';
        
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('show');
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            loadAppointments();
            setupEventListeners();
        });

        // Setup all event listeners
        function setupEventListeners() {
            // Edit form submission
            document.getElementById('editAppointmentForm').addEventListener('submit', handleEditAppointment);
            
            // Close edit modal when clicking outside
            document.getElementById('editAppointmentModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEditModal();
                }
            });
        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                    currentFilter = filter;
                filterAppointments(filter);
            });
        });

        // Search functionality
        document.querySelector('.search-bar input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
                searchAppointments(searchTerm);
            });

            // Date range filtering
            document.getElementById('start-date').addEventListener('change', applyDateRangeFilter);
            document.getElementById('end-date').addEventListener('change', applyDateRangeFilter);

        // New appointment button
        document.querySelector('.new-appointment-btn').addEventListener('click', function() {
            document.getElementById('newAppointmentModal').style.display = 'flex';
        });

            // Modal event listeners
        document.getElementById('newAppointmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });

        document.querySelector('.close-modal').addEventListener('click', function() {
            document.getElementById('newAppointmentModal').style.display = 'none';
        });

        // Form submission
            document.getElementById('newAppointmentForm').addEventListener('submit', handleNewAppointment);
            
            // Service selection handler for new appointment
            document.getElementById('serviceType').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price');
                if (price) {
                    document.getElementById('servicePrice').value = price;
                }
            });
            
            // Service selection handler for edit appointment
            document.getElementById('editServiceType').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price');
                if (price) {
                    document.getElementById('editServicePrice').value = price;
                }
            });
        }

        // Load appointments from backend
        function loadAppointments() {
            fetch('/admin/appointments/all', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(appointments => {
                currentAppointments = appointments;
                renderAppointments(appointments);
            })
            .catch(error => {
                console.error('Error loading appointments:', error);
                showNotification('Error loading appointments', 'error');
            });
        }

        // Render appointments in the table
        function renderAppointments(appointments) {
            const tbody = document.getElementById('appointmentsTableBody');
            
            if (appointments.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #666;">
                            <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 20px; display: block; color: #ddd;"></i>
                            <p>No appointments found</p>
                            <p style="font-size: 14px; margin-top: 10px;">Appointments will appear here when customers book them</p>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = appointments.map(appointment => `
                <tr data-appointment-id="${appointment.id}">
                    <td class="appointment-id">#AP-${String(appointment.id).padStart(4, '0')}</td>
                    <td class="customer-name">${appointment.user ? appointment.user.name : 'N/A'}</td>
                    <td class="service-name">${appointment.service ? appointment.service.name : 'N/A'}</td>
                    <td class="datetime">${formatDateTime(appointment.appointment_date)}</td>
                    <td class="location">
                        ${appointment.location_type === 'home-service' 
                            ? `Home Service (${appointment.customer_address || 'N/A'})` 
                            : 'Walk In'}
                    </td>
                    <td class="amount">₱${parseFloat(appointment.amount).toFixed(2)}</td>
                    <td>
                        <span class="status-badge status-${appointment.status.toLowerCase()}">
                            ${appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1)}
                        </span>
                    </td>
                    <td class="actions">
                        <button class="action-btn edit-btn" title="Edit" onclick="editAppointment(${appointment.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Filter appointments by status
        function filterAppointments(status) {
            if (status === 'all') {
                renderAppointments(currentAppointments);
            } else {
                const filtered = currentAppointments.filter(appointment => 
                    appointment.status.toLowerCase() === status.toLowerCase()
                );
                renderAppointments(filtered);
            }
        }

        // Search appointments
        function searchAppointments(searchTerm) {
            if (!searchTerm) {
                filterAppointments(currentFilter);
                return;
            }

            const filtered = currentAppointments.filter(appointment => {
                const searchText = `
                    ${appointment.user ? appointment.user.name : ''} 
                    ${appointment.service ? appointment.service.name : ''} 
                    ${appointment.id} 
                    ${appointment.user ? appointment.user.email : ''}
                `.toLowerCase();
                
                return searchText.includes(searchTerm.toLowerCase());
            });

            renderAppointments(filtered);
        }

        // Apply date range filter
        function applyDateRangeFilter() {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;

            if (!startDate || !endDate) return;

            fetch('/admin/appointments/date-range', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ start_date: startDate, end_date: endDate })
            })
            .then(response => response.json())
            .then(appointments => {
                currentAppointments = appointments;
                renderAppointments(appointments);
            })
            .catch(error => {
                console.error('Error filtering by date range:', error);
                showNotification('Error filtering appointments', 'error');
            });
        }

        // Handle new appointment creation
        function handleNewAppointment(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            fetch('/admin/appointments/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showNotification(result.message, 'success');
                    document.getElementById('newAppointmentModal').style.display = 'none';
                    this.reset();
                    loadAppointments(); // Reload appointments
                } else {
                    showNotification(result.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error creating appointment. Please try again.', 'error');
            });
        }

        // Edit appointment
        function editAppointment(appointmentId) {
            // Find the appointment in current appointments
            const appointment = currentAppointments.find(apt => apt.id == appointmentId);
            
            if (!appointment) {
                showNotification('Appointment not found!', 'error');
                return;
            }
            
            // Populate the edit form with appointment data
            document.getElementById('editAppointmentId').value = appointment.id;
            document.getElementById('editCustomerName').value = appointment.user ? appointment.user.name : '';
            document.getElementById('editCustomerPhone').value = appointment.user ? appointment.user.phone : '';
            document.getElementById('editServiceType').value = appointment.service ? appointment.service.name : '';
            document.getElementById('editServicePrice').value = appointment.amount || '';
            document.getElementById('editPaymentStatus').value = appointment.payment_status || 'pending';
            document.getElementById('editAppointmentStatus').value = appointment.status || 'pending';
            document.getElementById('editCustomerAddress').value = appointment.customer_address || '';
            document.getElementById('editNotes').value = appointment.notes || '';
            
            // Parse appointment date and time
            if (appointment.appointment_date) {
                const appointmentDate = new Date(appointment.appointment_date);
                const dateStr = appointmentDate.toISOString().split('T')[0];
                const timeStr = appointmentDate.toTimeString().slice(0, 5);
                
                document.getElementById('editAppointmentDate').value = dateStr;
                document.getElementById('editAppointmentTime').value = timeStr;
            }
            
            // Set service location
            document.getElementById('editServiceLocation').value = appointment.location_type || '';
            
            // Show the edit modal
            document.getElementById('editAppointmentModal').style.display = 'flex';
        }
        
        // Close edit modal
        function closeEditModal() {
            document.getElementById('editAppointmentModal').style.display = 'none';
        }
        
        // Handle edit appointment form submission
        function handleEditAppointment(e) {
            e.preventDefault();
            
            const appointmentId = document.getElementById('editAppointmentId').value;
            const appointmentStatus = document.getElementById('editAppointmentStatus').value;
            const paymentStatus = document.getElementById('editPaymentStatus').value;
            
            // Only send appointment status and payment status
            const data = {
                appointmentStatus: appointmentStatus,
                paymentStatus: paymentStatus
            };
            
            fetch(`/admin/appointments/${appointmentId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showNotification(result.message, 'success');
                    closeEditModal();
                    loadAppointments(); // Reload appointments
                } else {
                    showNotification(result.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating appointment. Please try again.', 'error');
            });
        }

        // Utility functions
        function formatDateTime(dateTimeString) {
            if (!dateTimeString) return 'N/A';
            
            const date = new Date(dateTimeString);
            if (isNaN(date.getTime())) return 'N/A';
            
            return date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
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
                padding: 15px 20px;
                border-radius: 5px;
                color: white;
                font-weight: 500;
                z-index: 10000;
                animation: slideIn 0.3s ease-out;
            `;
            
            // Set background color based on type
            switch(type) {
                case 'success':
                    notification.style.backgroundColor = '#28a745';
                    break;
                case 'error':
                    notification.style.backgroundColor = '#dc3545';
                    break;
                default:
                    notification.style.backgroundColor = '#17a2b8';
            }
            
            // Add to page
            document.body.appendChild(notification);
            
            // Remove after 5 seconds
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Auto-refresh appointments every 30 seconds to show new customer bookings
        setInterval(() => {
            loadAppointments();
        }, 30000);
    </script>
</body>
</html>

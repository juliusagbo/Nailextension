<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customers - Nailed by Via</title>
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
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
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
        
        .add-customer-btn {
            background: #b48b8b;
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
        
        .add-customer-btn:hover {
            background: #a07a7a;
        }
        
        /* Customers Content */
        .customers-content {
            padding: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #b48b8b;
            margin-bottom: 30px;
        }
        
        /* Customers Table */
        .customers-table {
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
            color: #b48b8b;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }
        
        .table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f8f9fa;
            font-size: 14px;
            vertical-align: middle;
        }
        
        .table tr:hover {
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
            margin-bottom: 2px;
        }
        
        .customer-details p {
            font-size: 12px;
            color: #666;
        }
        
        .contact-info {
            color: #333;
            font-weight: 500;
        }
        
        .appointments-count {
            font-weight: 600;
            color: #333;
            text-align: center;
        }
        
        .total-spent {
            font-weight: 600;
            color: #b48b8b;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            text-align: center;
            display: inline-block;
            min-width: 80px;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-inactive {
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
            background: #b48b8b;
            color: white;
        }
        
        .edit-btn:hover {
            background: #a07a7a;
        }
        
        .delete-btn {
            background: #dc3545;
            color: white;
        }
        
        .delete-btn:hover {
            background: #c82333;
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
            .header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .header-right {
                justify-content: space-between;
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
            }
            
            .profile-details {
                display: none;
            }
            
            .customers-content {
                padding: 15px;
            }
            
            .page-title {
                font-size: 22px;
                margin-bottom: 20px;
            }
            
            .add-customer-btn {
                font-size: 13px;
                padding: 8px 16px;
            }
            
            /* Convert table to cards on mobile */
            .customers-table {
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
                font-weight: 700;
                color: #b48b8b;
                display: block;
                margin-bottom: 5px;
                font-size: 12px;
                text-transform: uppercase;
            }
            
            .table tr:hover {
                background: white;
            }
            
            .customer-info {
                gap: 8px;
            }
            
            .customer-avatar {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }
            
            .actions {
                justify-content: flex-start;
                margin-top: 8px;
            }
        }
        
        @media (max-width: 480px) {
            .header {
                padding: 12px;
            }
            
            .customers-content {
                padding: 12px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .customer-details h4 {
                font-size: 13px;
            }
            
            .customer-details p {
                font-size: 11px;
            }
            
            .status-badge {
                font-size: 11px;
                padding: 3px 10px;
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
            max-width: 700px;
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

        .modal-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-title i {
            color: #b48b8b;
            font-size: 20px;
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

        .customer-form {
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

        .form-group.full-width {
            grid-column: 1 / -1;
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
            min-height: 100px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-weight: 500;
            color: #333;
        }

        .radio-label input[type="radio"] {
            display: none;
        }

        .radio-custom {
            width: 18px;
            height: 18px;
            border: 2px solid #e9ecef;
            border-radius: 50%;
            position: relative;
            transition: all 0.3s;
        }

        .radio-label input[type="radio"]:checked + .radio-custom {
            border-color: #b48b8b;
            background: #b48b8b;
        }

        .radio-label input[type="radio"]:checked + .radio-custom::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
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
            
            .customer-form {
                padding: 20px 16px;
            }
            
            .form-group label {
                font-size: 13px;
            }
            
            .form-group input,
            .form-group textarea,
            .form-group select {
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

            .radio-group {
                flex-direction: column;
                gap: 12px;
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
            .form-group textarea,
            .form-group select {
                font-size: 16px;
                padding: 10px 12px;
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
            <a href="{{ route('admin.users') }}" class="nav-item active">
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
                <input type="text" placeholder="Search customers...">
                <i class="fas fa-search"></i>
            </div>
            
            <div class="header-right">
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
        </div>

        <!-- Customers Content -->
        <div class="customers-content">
            <h1 class="page-title">Customers</h1>
            
            <!-- Customers Table -->
            <div class="customers-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Appointments</th>
                            <th>Total Spent</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($allCustomers) && $allCustomers->count() > 0)
                            @foreach($allCustomers as $customer)
                                @php
                                    // Generate initials for avatar
                                    $nameParts = explode(' ', $customer->name);
                                    $initials = '';
                                    foreach($nameParts as $part) {
                                        $initials .= strtoupper(substr($part, 0, 1));
                                    }
                                    $initials = substr($initials, 0, 2); // Limit to 2 characters
                                    
                                    // Check if this is an admin-created customer (non-registered)
                                    $isAdminCreated = strpos($customer->email, 'customer_') === 0 && strpos($customer->email, '@nailedbyvia.com') !== false;
                                @endphp
                                <tr data-customer-id="{{ $customer->id }}">
                            <td data-label="Customer">
                                <div class="customer-info">
                                            <div class="customer-avatar">{{ $initials }}</div>
                                    <div class="customer-details">
                                                <h4>{{ $customer->name }}</h4>
                                                <p>{{ $customer->email }}</p>
                                                @if($isAdminCreated)
                                                    <small style="color: #666; font-size: 11px;">Admin-created customer</small>
                                                @endif
                                    </div>
                                </div>
                            </td>
                                    <td class="contact-info" data-label="Contact">{{ $customer->phone ?? 'N/A' }}</td>
                                    <td class="appointments-count" data-label="Appointments">{{ $customer->appointments_count ?? 0 }}</td>
                                    <td class="total-spent" data-label="Total Spent">₱{{ number_format($customer->appointments_sum_amount ?? 0) }}</td>
                                    <td data-label="Status">
                                        <span class="status-badge status-{{ $customer->status ?? 'active' }}">
                                            {{ ucfirst($customer->status ?? 'active') }}
                                        </span>
                            </td>
                            <td class="actions" data-label="Actions">
                                <button class="action-btn edit-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                                    <i class="fas fa-users" style="font-size: 48px; margin-bottom: 20px; color: #ddd;"></i>
                                    <p>No customers found</p>
                                    <p style="font-size: 14px; color: #999;">Customers will appear here when appointments are created</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Edit Customer Modal -->
    <div id="editCustomerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Customer</h2>
                <button class="close-modal" onclick="closeEditCustomerModal()">&times;</button>
            </div>
            
            <form id="editCustomerForm" class="customer-form">
                <input type="hidden" id="editCustomerId" name="customerId">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editCustomerName">Customer Name *</label>
                        <input type="text" id="editCustomerName" name="customerName" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="editCustomerEmail">Email Address *</label>
                        <input type="email" id="editCustomerEmail" name="customerEmail" required disabled>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editCustomerPhone">Phone Number *</label>
                        <input type="tel" id="editCustomerPhone" name="customerPhone" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="editCustomerStatus">Status</label>
                        <select id="editCustomerStatus" name="customerStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeEditCustomerModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Update Customer</button>
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
        
        // Search functionality
        document.querySelector('.search-bar input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Edit buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                editCustomer(row);
            });
        });

        // Edit customer function
        function editCustomer(row) {
            const customerName = row.querySelector('.customer-details h4').textContent;
            const customerEmail = row.querySelector('.customer-details p').textContent;
            const customerPhone = row.querySelector('.contact-info').textContent;
            const statusBadge = row.querySelector('.status-badge');
            const customerStatus = statusBadge.classList.contains('status-active') ? 'active' : 'inactive';
            
            // Get customer ID from data attribute
            const customerId = row.getAttribute('data-customer-id');
            
            if (!customerId) {
                showNotification('Customer ID not found. Please refresh the page and try again.', 'error');
                return;
            }
            
            // Populate the edit form
            document.getElementById('editCustomerId').value = customerId;
            document.getElementById('editCustomerName').value = customerName;
            document.getElementById('editCustomerEmail').value = customerEmail;
            document.getElementById('editCustomerPhone').value = customerPhone === 'N/A' ? '' : customerPhone;
            document.getElementById('editCustomerStatus').value = customerStatus;
            
            // Show the edit modal
            document.getElementById('editCustomerModal').style.display = 'flex';
        }

        // Close edit customer modal
        function closeEditCustomerModal() {
            document.getElementById('editCustomerModal').style.display = 'none';
        }

        // Handle edit customer form submission
        document.getElementById('editCustomerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            const customerId = data.customerId;
            
            // Make API call to update customer
            fetch(`/admin/customers/${customerId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: data.customerName,
                    email: data.customerEmail,
                    phone: data.customerPhone,
                    status: data.customerStatus
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.message) {
                    showNotification('Customer "' + data.customerName + '" has been updated successfully.', 'success');
                    closeEditCustomerModal();
                    // In a real app, you would refresh the table or update the specific row
                    // For now, we'll just close the modal
                } else {
                    showNotification('Error updating customer. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating customer. Please try again.', 'error');
            });
        });

        // Close edit modal when clicking outside
        document.getElementById('editCustomerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditCustomerModal();
            }
        });

        // Show notification function
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.textContent = message;
            
            // Style the notification
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 5px;
                color: white;
                font-weight: 500;
                z-index: 10000;
                max-width: 300px;
                word-wrap: break-word;
            `;
            
            // Set background color based on type
            switch(type) {
                case 'success':
                    notification.style.backgroundColor = '#28a745';
                    break;
                case 'error':
                    notification.style.backgroundColor = '#dc3545';
                    break;
                case 'warning':
                    notification.style.backgroundColor = '#ffc107';
                    notification.style.color = '#000';
                    break;
                default:
                    notification.style.backgroundColor = '#17a2b8';
            }
            
            // Add to page
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 3000);
        }




        // Status badge click to toggle
        document.querySelectorAll('.status-badge').forEach(badge => {
            badge.addEventListener('click', function() {
                const currentStatus = this.textContent.toLowerCase();
                const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
                
                this.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                this.className = `status-badge status-${newStatus}`;
            });
        });
    </script>
</body>
</html>

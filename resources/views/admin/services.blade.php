<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Services - Nailed by Via</title>
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
        
        /* Services Content */
        .services-content {
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
        
        .filter-dropdowns {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .dropdown-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .dropdown-group label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }
        
        .dropdown-select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            color: #333;
        }
        
        .add-service-btn {
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
        
        .add-service-btn:hover {
            background: #a07a7a;
        }
        
        /* Services Grid */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        
        .service-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .service-image {
            position: relative;
            height: 200px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }
        
        .service-tags {
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            display: flex;
            justify-content: space-between;
        }
        
        .service-tag {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .tag-home-service {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .tag-walk-in {
            background: #d4edda;
            color: #155724;
        }
        
        .tag-active {
            background: #d4edda;
            color: #155724;
        }
        
        .tag-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        
        .service-content {
            padding: 20px;
        }
        
        .service-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .service-price {
            font-size: 20px;
            font-weight: 700;
            color: #b48b8b;
            margin-bottom: 12px;
        }
        
        .service-description {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        
        .service-duration {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .service-duration i {
            color: #b48b8b;
        }
        
        .service-actions {
            display: flex;
            gap: 10px;
        }
        
        .edit-btn {
            flex: 1;
            background: #b48b8b;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background 0.3s;
        }
        
        .edit-btn:hover {
            background: #a07a7a;
        }
        
        .delete-btn {
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            color: #666;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .delete-btn:hover {
            background: #f8d7da;
            color: #721c24;
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
            
            .filter-dropdowns {
                order: 2;
                width: 100%;
                flex-wrap: wrap;
            }
            
            .add-service-btn {
                order: 3;
                align-self: flex-end;
            }
            
            .services-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
            
            .services-content {
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
            
            .filter-dropdowns {
                flex-direction: column;
                width: 100%;
                gap: 10px;
            }
            
            .dropdown-group {
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
            
            .dropdown-group label {
                font-size: 13px;
            }
            
            .dropdown-select {
                width: 100%;
                font-size: 14px;
            }
            
            .add-service-btn {
                width: 100%;
                justify-content: center;
                padding: 11px 18px;
                font-size: 13px;
            }
            
            .services-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .service-card {
                border-radius: 10px;
            }
            
            .service-image {
                height: 180px;
            }
            
            .service-content {
                padding: 16px;
            }
            
            .service-title {
                font-size: 16px;
            }
            
            .service-price {
                font-size: 18px;
            }
            
            .service-description {
                font-size: 13px;
            }
            
            .service-duration {
                font-size: 13px;
            }
            
            .service-actions {
                flex-direction: row;
                gap: 8px;
            }
            
            .edit-btn {
                font-size: 13px;
                padding: 9px;
            }
            
            .delete-btn {
                width: 38px;
                height: 38px;
                flex-shrink: 0;
            }
        }
        
        @media (max-width: 480px) {
            .services-content {
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
            
            .dropdown-group label {
                font-size: 12px;
            }
            
            .dropdown-select {
                font-size: 13px;
                padding: 7px 10px;
            }
            
            .service-image {
                height: 160px;
            }
            
            .service-content {
                padding: 14px;
            }
            
            .service-title {
                font-size: 15px;
            }
            
            .service-price {
                font-size: 17px;
            }
            
            .service-description {
                font-size: 12px;
                margin-bottom: 12px;
            }
            
            .service-duration {
                font-size: 12px;
                margin-bottom: 15px;
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

        .service-form {
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

        .form-group input[type="file"] {
            padding: 8px 12px;
            border: 2px dashed #b48b8b;
            background: #f8f9fa;
            cursor: pointer;
        }

        .form-group input[type="file"]:hover {
            border-color: #a07a7a;
            background: #f0f0f0;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #b48b8b;
            box-shadow: 0 0 0 3px rgba(180, 139, 139, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-help {
            color: #666;
            font-size: 12px;
            margin-top: 4px;
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

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 8px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-weight: 500;
            color: #333;
        }

        .checkbox-label input[type="checkbox"] {
            display: none;
        }

        .checkbox-custom {
            width: 18px;
            height: 18px;
            border: 2px solid #e9ecef;
            border-radius: 4px;
            position: relative;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .checkbox-label input[type="checkbox"]:checked + .checkbox-custom {
            border-color: #b48b8b;
            background: #b48b8b;
        }

        .checkbox-label input[type="checkbox"]:checked + .checkbox-custom::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
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
            background: #fff;
            color: #b48b8b;
            border: 2px solid #b48b8b;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
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
            
            .service-form {
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
            
            .form-group input[type="file"] {
                font-size: 14px;
                padding: 9px 12px;
            }
            
            .form-help {
                font-size: 11px;
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
            
            .radio-label {
                font-size: 14px;
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
            
            .form-group input[type="file"] {
                font-size: 13px;
                padding: 8px 10px;
            }
            
            .form-help {
                font-size: 10px;
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
            <a href="{{ route('admin.appointments') }}" class="nav-item">
                <i class="fas fa-calendar-alt"></i>
                Appointments
            </a>
            <a href="{{ route('admin.services') }}" class="nav-item active">
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
                <input type="text" placeholder="Search services...">
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

        <!-- Services Content -->
        <div class="services-content">
            <h1 class="page-title">Services</h1>
            
            <!-- Filters Section -->
            <div class="filters-section">
                <div class="filters-row">
                    <div class="filter-buttons">
                        <button class="filter-btn active" data-filter="all">All Services</button>
                        <button class="filter-btn" data-filter="soft-gel">Soft Gel Extension</button>
                        <button class="filter-btn" data-filter="gel-polish">Gel Polish</button>
                        <button class="filter-btn" data-filter="toe-extension">Toe Extension</button>
                    </div>
                    
                    <div class="filter-dropdowns">
                        <div class="dropdown-group">
                            <label>Status:</label>
                            <select class="dropdown-select" id="status-filter">
                                <option value="all">Active / Inactive</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <div class="dropdown-group">
                            <label>Location type:</label>
                            <select class="dropdown-select" id="location-filter">
                                <option value="all">Home Service / Walk In</option>
                                <option value="home-service">Home Service</option>
                                <option value="walk-in">Walk In</option>
                            </select>
                        </div>
                    </div>
                    
                    <button class="add-service-btn">
                        <i class="fas fa-plus"></i>
                        Service
                    </button>
                </div>
            </div>

            <!-- Services Grid -->
            <div class="services-grid" id="servicesGrid">
                @if(isset($services) && $services->count() > 0)
                    @foreach($services as $service)
                        @php
                            $imageName = '';
                            $serviceNameLower = strtolower($service->name);
                            $filterCategory = 'other';
                            
                            // Determine filter category based on service name
                            if (strpos($serviceNameLower, 'soft gel') !== false) {
                                $filterCategory = 'soft-gel';
                            } elseif (strpos($serviceNameLower, 'gel polish') !== false && strpos($serviceNameLower, 'toe') === false) {
                                $filterCategory = 'gel-polish';
                            } elseif (strpos($serviceNameLower, 'toe') !== false) {
                                $filterCategory = 'toe-extension';
                            } elseif (strpos($serviceNameLower, 'nail art') !== false) {
                                $filterCategory = 'other';
                            } elseif (strpos($serviceNameLower, 'manicure') !== false) {
                                $filterCategory = 'other';
                            }
                            
                            // Use uploaded image if available and exists, otherwise fallback to default images
                            if ($service->image_url && file_exists(public_path($service->image_url))) {
                                $imageName = $service->image_url;
                            } else {
                                // Map service names to default image files
                                if (strpos($serviceNameLower, 'soft gel') !== false) {
                                    $imageName = 'images/admin/services/softgelminimalist.png';
                                } elseif (strpos($serviceNameLower, 'gel polish') !== false && strpos($serviceNameLower, 'toe') === false) {
                                    $imageName = 'images/admin/services/gelpolish.png';
                                } elseif (strpos($serviceNameLower, 'toe') !== false) {
                                    $imageName = 'images/admin/services/toegelpolish.png';
                                } elseif (strpos($serviceNameLower, 'nail art') !== false) {
                                    $imageName = 'images/admin/services/nailart.png';
                                } elseif (strpos($serviceNameLower, 'manicure') !== false) {
                                    $imageName = 'images/admin/services/manicureclassic.png';
                                } else {
                                    $imageName = 'images/admin/services/gelpolish.png'; // Default fallback
                                }
                            }
                        @endphp
                        
                        <div class="service-card" data-category="{{ $filterCategory }}" data-status="{{ $service->status ?? 'active' }}" data-location="{{ $service->location_type ?? 'home-service' }}" data-service-id="{{ $service->id }}">
                            <div class="service-image">
                                <img src="{{ asset($imageName) }}" alt="{{ $service->name }}" class="service-image" 
                                     onerror="console.log('Image failed to load:', '{{ asset($imageName) }}'); this.style.display='none';"
                                     onload="console.log('Image loaded successfully:', '{{ asset($imageName) }}');"
                                     title="Image URL: {{ asset($imageName) }} | DB URL: {{ $service->image_url }}">
                                <div class="service-tags">
                                    <span class="service-tag tag-{{ $service->location_type ?? 'home-service' }}">
                                        {{ ucfirst(str_replace('-', ' ', $service->location_type ?? 'home-service')) }}
                                    </span>
                                    <span class="service-tag tag-{{ $service->status ?? 'active' }}">
                                        {{ ucfirst($service->status ?? 'active') }}
                                    </span>
                                </div>
                            </div>
                            <div class="service-content">
                                <h3 class="service-title">{{ $service->name }}</h3>
                                <div class="service-price">₱{{ number_format($service->price) }}</div>
                                <p class="service-description">{{ $service->description ?? 'Professional nail service with premium quality materials.' }}</p>
                                <div class="service-duration">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $service->duration ?? '1 hour' }}</span>
                                </div>
                                <div class="service-actions">
                                    <button class="edit-btn" onclick="editService({{ $service->id }})">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button class="delete-btn" onclick="deleteService({{ $service->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-services">
                        <i class="fas fa-spa" style="font-size: 48px; color: #ddd; margin-bottom: 20px;"></i>
                        <p>No services found</p>
                        <p style="font-size: 14px; color: #999;">Add your first service to get started</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add New Service Modal -->
    <div id="addServiceModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Service</h2>
                <button class="close-modal">&times;</button>
            </div>
            
            <form id="addServiceForm" class="service-form" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="serviceName">Service Name *</label>
                        <input type="text" id="serviceName" name="name" placeholder="Enter service name" required>
                    </div>
                    <div class="form-group">
                        <label for="serviceCategory">Category *</label>
                        <select id="serviceCategory" name="category" required>
                            <option value="">Select Category</option>
                            <option value="soft-gel-extension">Soft Gel Extension</option>
                            <option value="gel-polish">Gel Polish</option>
                            <option value="toe-extension">Toe Extension</option>
                            <option value="nail-art">Nail Art</option>
                            <option value="manicure">Manicure</option>
                            <option value="pedicure">Pedicure</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="servicePrice">Price (₱) *</label>
                        <input type="text" id="servicePrice" name="servicePrice" placeholder="Enter price" required>
                    </div>
                    <div class="form-group">
                        <label for="serviceStatus">Status</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="status" value="active" checked>
                                <span class="radio-custom"></span>
                                Active
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="status" value="inactive">
                                <span class="radio-custom"></span>
                                Inactive
                            </label>
                        </div>
                    </div>
                </div>
                
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="serviceDescription">Description *</label>
                        <textarea id="serviceDescription" name="description" rows="4" placeholder="Enter service description" required></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="serviceImage">Service Image</label>
                        <input type="file" id="serviceImage" name="image" accept="image/*">
                        <small class="form-help">Upload an image file (JPEG, PNG, JPG, GIF) - Max 2MB</small>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('addServiceModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn-submit">Save Service</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div id="editServiceModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Service</h2>
                <button class="close-modal" onclick="closeEditModal()">&times;</button>
            </div>
            
            <form id="editServiceForm" class="service-form" enctype="multipart/form-data">
                <input type="hidden" id="editServiceId" name="serviceId">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editServiceName">Service Name *</label>
                        <input type="text" id="editServiceName" name="name" placeholder="Enter service name" required>
                    </div>
                    <div class="form-group">
                        <label for="editServiceCategory">Category *</label>
                        <select id="editServiceCategory" name="category" required>
                            <option value="">Select Category</option>
                            <option value="soft-gel-extension">Soft Gel Extension</option>
                            <option value="gel-polish">Gel Polish</option>
                            <option value="toe-extension">Toe Extension</option>
                            <option value="nail-art">Nail Art</option>
                            <option value="manicure">Manicure</option>
                            <option value="pedicure">Pedicure</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editServicePrice">Price (₱) *</label>
                        <input type="text" id="editServicePrice" name="servicePrice" placeholder="Enter price" required>
                    </div>
                    <div class="form-group">
                        <label for="editServiceStatus">Status</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="status" value="active" id="editStatusActive">
                                <span class="radio-custom"></span>
                                Active
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="status" value="inactive" id="editStatusInactive">
                                <span class="radio-custom"></span>
                                Inactive
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="editServiceDescription">Description *</label>
                        <textarea id="editServiceDescription" name="description" rows="4" placeholder="Enter service description" required></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Available Schedule Days</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableDays[]" value="monday" id="editDayMonday">
                                <span class="checkbox-custom"></span>
                                Monday
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableDays[]" value="tuesday" id="editDayTuesday">
                                <span class="checkbox-custom"></span>
                                Tuesday
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableDays[]" value="wednesday" id="editDayWednesday">
                                <span class="checkbox-custom"></span>
                                Wednesday
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableDays[]" value="thursday" id="editDayThursday">
                                <span class="checkbox-custom"></span>
                                Thursday
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableDays[]" value="friday" id="editDayFriday">
                                <span class="checkbox-custom"></span>
                                Friday
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableDays[]" value="saturday" id="editDaySaturday">
                                <span class="checkbox-custom"></span>
                                Saturday
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableDays[]" value="sunday" id="editDaySunday">
                                <span class="checkbox-custom"></span>
                                Sunday
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Available Time Slots</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableTimes[]" value="08:00" id="editTime0800">
                                <span class="checkbox-custom"></span>
                                8:00 AM
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableTimes[]" value="09:00" id="editTime0900">
                                <span class="checkbox-custom"></span>
                                9:00 AM
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableTimes[]" value="10:00" id="editTime1000">
                                <span class="checkbox-custom"></span>
                                10:00 AM
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableTimes[]" value="11:00" id="editTime1100">
                                <span class="checkbox-custom"></span>
                                11:00 AM
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableTimes[]" value="13:00" id="editTime1300">
                                <span class="checkbox-custom"></span>
                                1:00 PM
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableTimes[]" value="14:00" id="editTime1400">
                                <span class="checkbox-custom"></span>
                                2:00 PM
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableTimes[]" value="15:00" id="editTime1500">
                                <span class="checkbox-custom"></span>
                                3:00 PM
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableTimes[]" value="16:00" id="editTime1600">
                                <span class="checkbox-custom"></span>
                                4:00 PM
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="availableTimes[]" value="17:00" id="editTime1700">
                                <span class="checkbox-custom"></span>
                                5:00 PM
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="editServiceImage">Service Image</label>
                        <input type="file" id="editServiceImage" name="image" accept="image/*">
                        <small class="form-help">Upload a new image file (JPEG, PNG, JPG, GIF) - Max 2MB. Leave blank to keep current image.</small>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Update Service</button>
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
        
        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                applyFilters();
            });
        });

        // Dropdown filters
        document.getElementById('status-filter').addEventListener('change', applyFilters);
        document.getElementById('location-filter').addEventListener('change', applyFilters);

        function applyFilters() {
            const categoryFilter = document.querySelector('.filter-btn.active').getAttribute('data-filter');
            const statusFilter = document.getElementById('status-filter').value;
            const locationFilter = document.getElementById('location-filter').value;
            
            const cards = document.querySelectorAll('.service-card');
            
            cards.forEach(card => {
                const category = card.getAttribute('data-category');
                const status = card.getAttribute('data-status');
                const location = card.getAttribute('data-location');
                
                const categoryMatch = categoryFilter === 'all' || category === categoryFilter;
                const statusMatch = statusFilter === 'all' || status === statusFilter;
                const locationMatch = locationFilter === 'all' || location === locationFilter;
                
                if (categoryMatch && statusMatch && locationMatch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Search functionality
        document.querySelector('.search-bar input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.service-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Edit buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.service-card');
                openEditModal(card);
            });
        });

        // Function to edit service
        function editService(serviceId) {
            // Find the service card by ID
            const card = document.querySelector(`[data-service-id="${serviceId}"]`);
            if (card) {
                openEditModal(card);
            }
        }

        // Function to delete service
        function deleteService(serviceId) {
            if (confirm('Are you sure you want to delete this service? This action cannot be undone.')) {
                fetch(`/admin/services/${serviceId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        // Remove the service card from the DOM
                        const card = document.querySelector(`[data-service-id="${serviceId}"]`);
                        if (card) {
                            card.remove();
                        }
                        alert(result.message);
                    } else {
                        alert('Error: ' + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting service. Please try again.');
                });
            }
        }

        // Function to open edit modal with service data
        function openEditModal(card) {
            // Extract data from the service card
            const title = card.querySelector('.service-title').textContent;
            const price = card.querySelector('.service-price').textContent.replace('₱', '').replace(',', '');
            const description = card.querySelector('.service-description').textContent;
            const category = card.getAttribute('data-category');
            const status = card.getAttribute('data-status');
            
            // Populate the edit form
            document.getElementById('editServiceName').value = title;
            document.getElementById('editServicePrice').value = price;
            document.getElementById('editServiceDescription').value = description;
            document.getElementById('editServiceCategory').value = category;
            
            // Set status radio button
            if (status === 'active') {
                document.getElementById('editStatusActive').checked = true;
            } else {
                document.getElementById('editStatusInactive').checked = true;
            }
            
            // Get the service ID from the data attribute
            const serviceId = card.getAttribute('data-service-id');
            document.getElementById('editServiceId').value = serviceId;
            
            // Clear all checkboxes first
            document.querySelectorAll('input[name="availableDays[]"]').forEach(cb => cb.checked = false);
            document.querySelectorAll('input[name="availableTimes[]"]').forEach(cb => cb.checked = false);
            
            // Get available days and times from data attributes if available
            const availableDays = card.getAttribute('data-available-days');
            const availableTimes = card.getAttribute('data-available-times');
            
            if (availableDays) {
                const days = availableDays.split(',');
                days.forEach(day => {
                    const checkbox = document.getElementById('editDay' + day.charAt(0).toUpperCase() + day.slice(1));
                    if (checkbox) checkbox.checked = true;
                });
            }
            
            if (availableTimes) {
                const times = availableTimes.split(',');
                times.forEach(time => {
                    const timeId = 'editTime' + time.replace(':', '');
                    const checkbox = document.getElementById(timeId);
                    if (checkbox) checkbox.checked = true;
                });
            }
            
            // Show the modal
            document.getElementById('editServiceModal').style.display = 'flex';
        }

        // Function to close edit modal
        function closeEditModal() {
            document.getElementById('editServiceModal').style.display = 'none';
        }

        // Delete buttons
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.service-card');
                const title = card.querySelector('.service-title').textContent;
                if (confirm('Are you sure you want to delete service "' + title + '"?')) {
                    card.remove();
                }
            });
        });

        // Add service button
        document.querySelector('.add-service-btn').addEventListener('click', function() {
            document.getElementById('addServiceModal').style.display = 'flex';
        });

        // Close modal when clicking outside
        document.getElementById('addServiceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });

        // Close modal when clicking close button
        document.querySelector('.close-modal').addEventListener('click', function() {
            document.getElementById('addServiceModal').style.display = 'none';
        });

        // Close edit modal when clicking outside
        document.getElementById('editServiceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Price input formatting
        document.getElementById('servicePrice').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9.]/g, '');
            e.target.value = value;
        });

        document.getElementById('editServicePrice').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9.]/g, '');
            e.target.value = value;
        });

        // Form submission
        document.getElementById('addServiceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Add CSRF token to form data
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            // Send to backend
            fetch('/admin/services/store', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert(result.message);
                    document.getElementById('addServiceModal').style.display = 'none';
                    this.reset();
                    // Reload the page to show new service
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating service. Please try again.');
            });
        });

        // Edit form submission
        document.getElementById('editServiceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const serviceId = document.getElementById('editServiceId').value;
            
            // Add CSRF token
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'PUT');
            
            console.log('Updating service ID:', serviceId);
            console.log('Form data:', Object.fromEntries(formData.entries()));
            
            // Send to backend
            fetch('/admin/services/' + serviceId, {
                method: 'POST', // Use POST with _method=PUT for Laravel
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(result => {
                console.log('Update result:', result);
                if (result.success) {
                    alert('Service updated successfully!');
                    closeEditModal();
                    location.reload();
                } else {
                    alert('Error: ' + (result.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Update error:', error);
                alert('Error updating service: ' + error.message);
            });
        });
    </script>
</body>
</html>

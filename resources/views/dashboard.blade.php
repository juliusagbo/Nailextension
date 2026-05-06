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
    .welcome-card {
        background: #b48b8b;
        color: #fff;
        border-radius: 8px;
        padding: 24px 32px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }
    .welcome-card .welcome-btn {
        background: #fff;
        color: #b48b8b;
        border: none;
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 600;
        margin-top: 12px;
        cursor: pointer;
    }
    .summary-cards {
        display: flex;
        gap: 24px;
        margin-bottom: 24px;
    }
    .summary-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px #eee;
        flex: 1;
        padding: 24px;
        color: #b48b8b;
        min-width: 180px;
    }
    .summary-card .summary-title {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .summary-card .summary-value {
        font-size: 32px;
        font-weight: 700;
        color: #b48b8b;
        margin-bottom: 4px;
    }
    .appointments-section {
        margin-top: 24px;
    }
    .appointments-table {
        width: 100%;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px #eee;
        margin-top: 12px;
        overflow: hidden;
    }
    .appointments-table th, .appointments-table td {
        padding: 12px 16px;
        color: #b48b8b;
        font-size: 15px;
        text-align: left;
    }
    .appointments-table th {
        background: #f7eaea;
        font-weight: 700;
    }
    .appointments-table tr:not(:last-child) {
        border-bottom: 1px solid #f0e0e0;
    }
    .status-upcoming {
        background: #e3f2fd;
        color: #2196f3;
        border-radius: 12px;
        padding: 2px 12px;
        font-size: 13px;
        font-weight: 600;
    }
    .status-completed {
        background: #e0f7e9;
        color: #43a047;
        border-radius: 12px;
        padding: 2px 12px;
        font-size: 13px;
        font-weight: 600;
    }
    .action-btn {
        border: none;
        border-radius: 12px;
        padding: 4px 12px;
        font-size: 13px;
        font-weight: 600;
        margin-right: 6px;
        cursor: pointer;
    }
    .action-reschedule { background: #b48b8b; color: #fff; }
    .action-cancel { background: #fff; color: #b48b8b; border: 1px solid #b48b8b; }
    .action-review { background: #fff; color: #b48b8b; border: 1px solid #b48b8b; }
    .action-book { background: #b48b8b; color: #fff; }
    
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
        .summary-cards {
            gap: 16px;
        }
        .summary-card {
            min-width: 150px;
        }
        .welcome-card {
            flex-direction: column;
            text-align: center;
            gap: 16px;
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
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        
        .dashboard-header > div:first-child {
            font-size: 16px !important;
        }
        
        .dashboard-header .search-bar {
            width: 100%;
            max-width: 100%;
        }
        
        .welcome-card {
            padding: 20px;
            flex-direction: column;
            text-align: center;
            gap: 12px;
        }
        
        .welcome-card > div:first-child > div:first-child {
            font-size: 16px !important;
        }
        
        .welcome-card > div:first-child > div:nth-child(2) {
            font-size: 13px !important;
        }
        
        .welcome-card .welcome-btn {
            width: 100%;
            padding: 10px 20px;
        }
        
        .summary-cards {
            flex-direction: column;
            gap: 12px;
        }
        
        .summary-card {
            min-width: auto;
            padding: 20px;
        }
        
        .summary-card .summary-title {
            font-size: 14px;
        }
        
        .summary-card .summary-value {
            font-size: 28px;
        }
        
        .summary-card > div:last-child {
            font-size: 12px !important;
        }
        
        .appointments-section {
            margin-top: 20px;
        }
        
        .appointments-section > div:first-child {
            font-size: 15px !important;
            flex-wrap: wrap;
        }
        
        /* Convert table to cards on mobile */
        .appointments-table {
            background: transparent;
            box-shadow: none;
        }
        
        .appointments-table table {
            display: block;
        }
        
        .appointments-table thead {
            display: none;
        }
        
        .appointments-table tbody {
            display: block;
        }
        
        .appointments-table tr {
            display: block;
            background: white;
            margin-bottom: 16px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #eee;
            padding: 16px;
        }
        
        .appointments-table td {
            display: block;
            padding: 8px 0;
            border: none;
            text-align: left;
        }
        
        .appointments-table td:before {
            content: attr(data-label);
            font-weight: 700;
            color: #b48b8b;
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
        }
        
        .appointments-table tr:not(:last-child) {
            border-bottom: none;
        }
        
        .appointments-table td:last-child {
            margin-top: 8px;
        }
        
        .action-btn {
            margin-bottom: 8px;
            display: inline-block;
        }
        
        /* Empty state responsive */
        .appointments-table tbody tr td[colspan] {
            display: table-cell !important;
            text-align: center;
            padding: 30px 16px !important;
        }
        
        .appointments-table tbody tr td[colspan]:before {
            display: none !important;
        }
    }
    
    @media (max-width: 480px) {
        .dashboard-content {
            padding: 60px 12px 12px;
        }
        
        .dashboard-header > div:first-child {
            font-size: 15px !important;
        }
        
        .welcome-card {
            padding: 16px;
        }
        
        .welcome-card > div:first-child > div:first-child {
            font-size: 15px !important;
        }
        
        .welcome-card > div:first-child > div:nth-child(2) {
            font-size: 12px !important;
        }
        
        .summary-card {
            padding: 16px;
        }
        
        .summary-card .summary-title {
            font-size: 13px;
        }
        
        .summary-card .summary-value {
            font-size: 24px;
        }
        
        .action-btn {
            font-size: 12px;
            padding: 4px 10px;
        }
    }

    
    /* Booking Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .booking-modal {
        background: #fff;
        border-radius: 16px;
        padding: 32px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f0e0e0;
    }
    .modal-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        color: #b48b8b;
        font-size: 20px;
    }
    .close-btn {
        background: none;
        border: none;
        color: #b48b8b;
        font-size: 24px;
        cursor: pointer;
        padding: 4px;
    }
    .form-section {
        margin-bottom: 24px;
    }
    .form-section h3 {
        font-weight: 600;
        color: #b48b8b;
        font-size: 16px;
        margin-bottom: 12px;
    }
    .radio-group {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }
    .radio-option {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    .radio-option input[type="radio"] {
        accent-color: #b48b8b;
    }
    .form-group {
        margin-bottom: 16px;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        color: #b48b8b;
        font-size: 14px;
        margin-bottom: 6px;
    }
    .form-group input, .form-group select, .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5cfd1;
        border-radius: 8px;
        font-size: 14px;
        color: #a07a7a;
        background: #fff;
        transition: border-color 0.2s;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
        outline: none;
        border-color: #b48b8b;
    }
    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }
    .input-with-icon {
        position: relative;
    }
    .input-with-icon .material-icons {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #b48b8b;
        font-size: 18px;
    }
    .service-row {
        margin-bottom: 16px;
    }
    .service-number {
        color: #b48b8b;
        font-weight: 600;
        font-size: 12px;
    }
    .remove-service-btn {
        transition: background 0.2s;
    }
    .remove-service-btn:hover {
        background: #c82333 !important;
    }
    #addServiceBtn:hover {
        background: #a07a7a !important;
    }
    .charges-summary {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
    }
    .charge-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .charge-item:last-child {
        margin-bottom: 0;
        font-weight: 600;
        color: #b48b8b;
        border-top: 1px solid #e5cfd1;
        padding-top: 8px;
    }
    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    .cancel-btn {
        background: #f5f5f5;
        color: #666;
        border: none;
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
    
    /* Confirmation Modal Styles */
    .confirmation-modal {
        background: #fff;
        border-radius: 16px;
        padding: 32px;
        width: 90%;
        max-width: 500px;
        text-align: center;
        position: relative;
    }
    .confirmation-header {
        margin-bottom: 24px;
    }
    .success-icon {
        width: 60px;
        height: 60px;
        background: #b48b8b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .success-icon .material-icons {
        color: #fff;
        font-size: 32px;
    }
    .confirmation-title {
        font-weight: 700;
        color: #b48b8b;
        font-size: 24px;
        margin-bottom: 8px;
    }
    .booking-details {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 24px;
        text-align: left;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
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
    
    /* Reschedule Modal Styles */
    .current-appointment-details {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 16px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        font-size: 14px;
        color: #a07a7a;
    }
    
    .detail-item:last-child {
        margin-bottom: 0;
    }
    
    .detail-item .detail-label {
        font-weight: 500;
        color: #b48b8b;
    }
    
    .detail-item .detail-value {
        text-align: right;
        color: #a07a7a;
    }
    
    /* Review Modal Styles */
    .appointment-details {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #495057;
        min-width: 120px;
    }
    
    .detail-value {
        color: #6c757d;
        text-align: right;
        flex: 1;
        margin-left: 16px;
    }
    
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        gap: 4px;
    }
    
    .rating-stars input[type="radio"] {
        display: none;
    }
    
    .rating-stars .star {
        font-size: 32px;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s ease;
    }
    
    .rating-stars .star:hover,
    .rating-stars .star:hover ~ .star,
    .rating-stars input[type="radio"]:checked ~ .star {
        color: #ffd700;
    }
    
    .char-count {
        text-align: right;
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
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
    }
    
    .radio-option input[type="radio"] {
        margin: 0;
    }
    
    .radio-option span {
        color: #495057;
    }
    
    /* Additional Modal Styles */
    .appointment-details {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #495057;
        min-width: 120px;
    }
    
    .detail-value {
        color: #6c757d;
        text-align: right;
        flex: 1;
        margin-left: 16px;
    }
    
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        gap: 4px;
    }
    
    .rating-stars input[type="radio"] {
        display: none;
    }
    
    .rating-stars .star {
        font-size: 32px;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s ease;
    }
    
    .rating-stars .star:hover,
    .rating-stars .star:hover ~ .star,
    .rating-stars input[type="radio"]:checked ~ .star {
        color: #ffd700;
    }
    
    .char-count {
        text-align: right;
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
    }
    
    /* Modal Responsive Styles */
    @media (max-width: 768px) {
        .booking-modal,
        .confirmation-modal {
            width: 95%;
            max-height: 85vh;
            padding: 24px 16px;
        }
        
        .modal-header {
            padding: 0 0 16px 0;
            margin-bottom: 20px;
        }
        
        .modal-title {
            font-size: 16px;
        }
        
        .close-btn {
            font-size: 20px;
        }
        
        .form-section {
            margin-bottom: 20px;
        }
        
        .form-section h3 {
            font-size: 15px;
        }
        
        .form-group label {
            font-size: 13px;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            font-size: 13px;
            padding: 10px 12px;
        }
        
        .charges-summary {
            padding: 12px;
            margin-bottom: 20px;
        }
        
        .charge-item {
            font-size: 13px;
        }
        
        .modal-actions {
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
        
        .confirmation-title {
            font-size: 20px;
        }
        
        .success-icon {
            width: 50px;
            height: 50px;
        }
        
        .success-icon .material-icons {
            font-size: 28px;
        }
        
        .booking-details,
        .appointment-details,
        .current-appointment-details {
            padding: 12px;
        }
        
        .detail-row,
        .detail-item {
            font-size: 13px;
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }
        
        .detail-value {
            text-align: left;
            margin-left: 0;
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
        
        .rating-stars {
            justify-content: center;
        }
        
        .rating-stars .star {
            font-size: 28px;
        }
        
        .radio-group {
            gap: 10px;
        }
        
        /* Alert messages responsive */
        .dashboard-content > div[style*="background: #d4edda"],
        .dashboard-content > div[style*="background: #f8d7da"] {
            font-size: 13px !important;
            padding: 10px !important;
        }
    }

    @media (max-width: 480px) {
        .booking-modal,
        .confirmation-modal {
            width: 100%;
            max-width: 100%;
            border-radius: 0;
            max-height: 100vh;
            padding: 20px 12px;
        }
        
        .modal-title {
            font-size: 15px;
        }
        
        .form-group label {
            font-size: 12px;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            font-size: 12px;
        }
        
        .charge-item,
        .detail-row,
        .detail-item {
            font-size: 12px;
        }
        
        .confirmation-title {
            font-size: 18px;
        }
        
        .rating-stars .star {
            font-size: 24px;
        }
        
        /* Alert messages responsive */
        .dashboard-content > div[style*="background: #d4edda"],
        .dashboard-content > div[style*="background: #f8d7da"] {
            font-size: 12px !important;
            padding: 10px !important;
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
            <a href="#" class="active">Home</a>
            <a href="{{ url('/appointments') }}">Appointments</a>
            <a href="{{ url('/services') }}">Services</a>
            <a href="{{ url('/favorites') }}">Favorites</a>
            <a href="{{ url('/transaction-history') }}">Transaction History</a>
            <a href="{{ url('/profile-settings') }}">Profile Settings</a>
            <a href="{{ url('/faqs') }}">FAQs</a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" style="width:100%;">
            @csrf
            <button type="submit" class="logout" style="width:100%;text-align:left;background:none;border:none;padding:12px 32px;cursor:pointer;">Logout</button>
        </form>
    </div>
    <div class="dashboard-content">
        @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
        @endif
        
        @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="dashboard-header">
            <div style="font-weight:600; color:#b48b8b; font-size:18px;">Home Dashboard - {{ Auth::user()->name }}</div>
            <div style="display:flex; align-items:center;">
                <div class="search-bar">
                    <input type="text" placeholder="Search here...">
                    <span class="material-icons" style="font-size:18px;">search</span>
                </div>
            </div>
        </div>
        <div class="welcome-card">
            <div>
                <div style="font-size:18px; font-weight:700;">Good Day, {{ Auth::user()->name }}!</div>
                <div style="margin:8px 0 0 0;">Ready for your next nail transformation? You have <b>{{ $upcomingAppointments }} upcoming appointments</b> this month.</div>
                <button class="welcome-btn" onclick="openBookingModal()">Book New Appointment</button>
            </div>
            <div>
                <span class="material-icons" style="font-size:60px; opacity:0.2;">filter_vintage</span>
            </div>
        </div>
        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-title">Upcoming Appointments</div>
                <div class="summary-value">{{ $upcomingAppointments }}</div>
                <div style="font-size:13px;">You have {{ $upcomingAppointments }} upcoming appointments</div>
            </div>
            <div class="summary-card">
                <div class="summary-title">Total Appointments</div>
                <div class="summary-value">{{ $totalAppointments }}</div>
                <div style="font-size:13px;">This is your total appointments</div>
            </div>
            <div class="summary-card">
                <div class="summary-title">Favorite Designs</div>
                <div class="summary-value">{{ $favoriteDesigns }}</div>
                <div style="font-size:13px;">Saved for your next appointment</div>
            </div>
        </div>
        <div class="appointments-section">
            <div style="font-weight:600; color:#b48b8b; margin-bottom:8px; display:flex; align-items:center;">
                <span class="material-icons" style="font-size:20px; margin-right:6px;">event</span>
                Upcoming Appointments
                <a href="{{ route('appointments') }}" style="margin-left:auto; font-size:13px; color:#b48b8b;">View All</a>
            </div>
            <div class="appointments-table">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Service</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAppointments as $appointment)
                        <tr>
                            <td data-label="Date & Time">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y - h:i A') }}</td>
                            <td data-label="Service">{{ $appointment->service->name ?? 'Service' }}</td>
                            <td data-label="Location">{{ $appointment->location_type }}@if($appointment->customer_address) ({{ $appointment->customer_address }})@endif</td>
                            <td data-label="Status">
                                <span class="status-{{ $appointment->status == 'pending' ? 'upcoming' : ($appointment->status == 'completed' ? 'completed' : 'cancelled') }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td data-label="Actions">
                                @if($appointment->status == 'pending')
                                    <button class="action-btn action-reschedule" onclick="openRescheduleModal({{ $appointment->id }}, '{{ addslashes($appointment->service->name ?? 'Service') }}', '{{ $appointment->appointment_date }}', '{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') }}', '{{ $appointment->location_type }}', '{{ addslashes($appointment->customer_address ?? '') }}', '{{ addslashes($appointment->notes ?? '') }}')">Reschedule</button>
                                    <button class="action-btn action-cancel" onclick="openCancelModal({{ $appointment->id }}, '{{ addslashes($appointment->service->name ?? 'Service') }}', '{{ $appointment->appointment_date }}')">Cancel</button>
                                @elseif($appointment->status == 'completed')
                                    <button class="action-btn action-book" onclick="openBookAgainModal({{ $appointment->id }}, '{{ addslashes($appointment->service->name ?? 'Service') }}', {{ $appointment->service_id ?? 1 }}, {{ $appointment->amount ?? 0 }})">Book Again</button>
                                    <button class="action-btn action-review" onclick="openReviewModal({{ $appointment->id }}, '{{ addslashes($appointment->service->name ?? 'Service') }}', '{{ $appointment->appointment_date }}', '{{ $appointment->location_type }}', '{{ addslashes($appointment->customer_address ?? '') }}', '{{ addslashes($appointment->notes ?? '') }}', {{ $appointment->amount ?? 0 }})">Review</button>
                                @else
                                    <button class="action-btn action-book" onclick="openBookAgainModal({{ $appointment->id }}, '{{ addslashes($appointment->service->name ?? 'Service') }}', {{ $appointment->service_id ?? 1 }}, {{ $appointment->amount ?? 0 }})">Book Again</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #b48b8b; padding: 20px;">No appointments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
                <div id="servicesContainer">
                    <div class="service-row" data-service-index="0">
                        <div class="form-group">
                            <label>Select a Service <span class="service-number">1</span></label>
                            <div class="input-with-icon" style="display: flex; gap: 8px; position: relative;">
                                <select class="service-select" name="service_ids[]" data-index="0" onchange="updateCharges()" required style="flex: 1; padding-right: 40px;">
                                    <option value="">Choose a service...</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-name="{{ $service->name }}">{{ $service->name }} - ₱{{ $service->price }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="remove-service-btn" onclick="removeServiceRow(0)" style="display: none; background: #dc3545; color: white; border: none; border-radius: 8px; padding: 12px 16px; cursor: pointer; font-size: 14px; min-width: 50px;">
                                    <span class="material-icons" style="font-size: 18px;">delete</span>
                                </button>
                                <span class="material-icons" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #b48b8b; font-size: 18px; pointer-events: none;">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 12px;">
                    <button type="button" id="addServiceBtn" onclick="addServiceRow()" style="background: #b48b8b; color: white; border: none; border-radius: 8px; padding: 10px 20px; cursor: pointer; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                        <span class="material-icons" style="font-size: 18px;">add</span>
                        Add Another Service
                    </button>
                    <div id="maxServicesMessage" style="display: none; color: #dc3545; font-size: 12px; margin-top: 8px;">
                        Maximum 5 services allowed per appointment
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
                    <label for="appointment_time">Available Time</label>
                    <div class="input-with-icon">
                        <select id="appointment_time" name="appointment_time" required>
                            <option value="">Select a date first...</option>
                        </select>
                        <span class="material-icons">schedule</span>
                    </div>
                    <div id="timeSlotLoading" style="display: none; font-size: 12px; color: #b48b8b; margin-top: 4px;">
                        Loading available times...
                    </div>
                    <div id="timeSlotError" style="display: none; font-size: 12px; color: #dc3545; margin-top: 4px;"></div>
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
                <div id="servicesList">
                    <div class="charge-item">
                        <span>Services:</span>
                        <span id="servicesTotal">₱0</span>
                    </div>
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

<!-- Reschedule Modal -->
<div class="modal-overlay" id="rescheduleModal">
    <div class="booking-modal">
        <div class="modal-header">
            <div class="modal-title">
                <span class="material-icons">schedule</span>
                Reschedule Appointment
            </div>
            <button class="close-btn" onclick="closeRescheduleModal()">
                <span class="material-icons">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('appointments.reschedule') }}" id="rescheduleForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="appointment_id" id="reschedule_appointment_id">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

            <div class="form-section">
                <h3>Current Appointment Details</h3>
                <div class="current-appointment-details">
                    <div class="detail-item">
                        <span class="detail-label">Service:</span>
                        <span class="detail-value" id="currentService">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Current Date & Time:</span>
                        <span class="detail-value" id="currentDateTime">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Location:</span>
                        <span class="detail-value" id="currentLocation">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Notes:</span>
                        <span class="detail-value" id="currentNotes">-</span>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>New Appointment Details</h3>
                <div class="form-group">
                    <label for="new_appointment_date">New Date</label>
                    <div class="input-with-icon">
                        <input type="date" id="new_appointment_date" name="new_appointment_date" required>
                        <span class="material-icons">calendar_today</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="new_appointment_time">New Time</label>
                    <div class="input-with-icon">
                        <select id="new_appointment_time" name="new_appointment_time" required>
                            <option value="">Select a date first...</option>
                        </select>
                        <span class="material-icons">schedule</span>
                    </div>
                    <div id="rescheduleTimeSlotLoading" style="display: none; font-size: 12px; color: #b48b8b; margin-top: 4px;">
                        Loading available times...
                    </div>
                    <div id="rescheduleTimeSlotError" style="display: none; font-size: 12px; color: #dc3545; margin-top: 4px;"></div>
                </div>
                
                <div class="form-group">
                    <label for="reschedule_reason">Reason for Rescheduling</label>
                    <textarea id="reschedule_reason" name="reschedule_reason" placeholder="Please provide a reason for rescheduling..." required></textarea>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closeRescheduleModal()">Cancel</button>
                <button type="submit" class="confirm-btn">Confirm Reschedule</button>
            </div>
        </form>
    </div>
</div>

<!-- Review Modal -->
<div class="modal-overlay" id="reviewModal">
    <div class="booking-modal">
        <div class="modal-header">
            <div class="modal-title">
                <span class="material-icons">rate_review</span>
                Review Your Appointment
            </div>
            <button class="close-btn" onclick="closeReviewModal()">
                <span class="material-icons">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('appointments.review') }}" id="reviewForm">
            @csrf
            <input type="hidden" name="appointment_id" id="review_appointment_id">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

            <div class="form-section">
                <h3>Appointment Details</h3>
                <div class="appointment-details">
                    <div class="detail-item">
                        <span class="detail-label">Service:</span>
                        <span class="detail-value" id="reviewService">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date & Time:</span>
                        <span class="detail-value" id="reviewDateTime">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Location:</span>
                        <span class="detail-value" id="reviewLocation">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Amount Paid:</span>
                        <span class="detail-value" id="reviewAmount">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Notes:</span>
                        <span class="detail-value" id="reviewNotes">-</span>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Your Review</h3>
                <div class="form-group">
                    <label for="rating">Overall Rating *</label>
                    <div class="rating-stars">
                        <input type="radio" id="star5" name="rating" value="5" required>
                        <label for="star5" class="star">★</label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4" class="star">★</label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3" class="star">★</label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2" class="star">★</label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1" class="star">★</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="review_title">Review Title *</label>
                    <input type="text" id="review_title" name="review_title" placeholder="Brief summary of your experience..." required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label for="review_comment">Detailed Review *</label>
                    <textarea id="review_comment" name="review_comment" placeholder="Share your experience, what you liked, and any suggestions for improvement..." required minlength="20" maxlength="500" rows="4"></textarea>
                    <div class="char-count">
                        <span id="charCount">0</span>/500 characters
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="recommend_service">Would you recommend this service?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="recommend_service" value="yes" checked>
                            <span>Yes, definitely!</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="recommend_service" value="maybe">
                            <span>Maybe, with some improvements</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="recommend_service" value="no">
                            <span>No, not really</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closeReviewModal()">Cancel</button>
                <button type="submit" class="confirm-btn">Submit Review</button>
            </div>
        </form>
    </div>
</div>

<!-- Cancel Confirmation Modal -->
<div class="modal-overlay" id="cancelModal">
    <div class="booking-modal">
        <div class="modal-header">
            <div class="modal-title">
                <span class="material-icons">cancel</span>
                Cancel Appointment
            </div>
            <button class="close-btn" onclick="closeCancelModal()">
                <span class="material-icons">close</span>
            </button>
        </div>
        
        <div class="form-section">
            <h3>Confirm Cancellation</h3>
            <div class="appointment-details">
                <div class="detail-item">
                    <span class="detail-label">Service:</span>
                    <span class="detail-value" id="cancelService">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Date & Time:</span>
                    <span class="detail-value" id="cancelDateTime">-</span>
                </div>
            </div>
            <p style="color: #721c24; margin: 16px 0;">Are you sure you want to cancel this appointment? This action cannot be undone.</p>
        </div>
        
        <div class="modal-actions">
            <button type="button" class="cancel-btn" onclick="closeCancelModal()">No, Keep Appointment</button>
            <form method="POST" id="cancelForm" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="confirm-btn" style="background: #dc3545;">Yes, Cancel Appointment</button>
            </form>
        </div>
    </div>
</div>

<!-- Book Again Modal -->
<div class="modal-overlay" id="bookAgainModal">
    <div class="booking-modal">
        <div class="modal-header">
            <div class="modal-title">
                <span class="material-icons">event</span>
                Book Same Service Again
            </div>
            <button class="close-btn" onclick="closeBookAgainModal()">
                <span class="material-icons">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('appointments.store') }}" id="bookAgainForm">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <input type="hidden" name="service_id" id="bookAgain_service_id">
            <input type="hidden" name="amount" id="bookAgain_amount">

            <div class="form-section">
                <h3>Previous Service Details</h3>
                <div class="appointment-details">
                    <div class="detail-item">
                        <span class="detail-label">Service:</span>
                        <span class="detail-value" id="bookAgainService">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Amount:</span>
                        <span class="detail-value" id="bookAgainAmount">-</span>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>New Appointment Details</h3>
                <div class="form-group">
                    <label for="bookAgain_appointment_date">Preferred Date *</label>
                    <div class="input-with-icon">
                        <input type="date" id="bookAgain_appointment_date" name="appointment_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        <span class="material-icons">calendar_today</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="bookAgain_appointment_time">Preferred Time *</label>
                    <div class="input-with-icon">
                        <select id="bookAgain_appointment_time" name="appointment_time" required>
                            <option value="">Select a date first...</option>
                        </select>
                        <span class="material-icons">schedule</span>
                    </div>
                    <div id="bookAgainTimeSlotLoading" style="display: none; font-size: 12px; color: #b48b8b; margin-top: 4px;">
                        Loading available times...
                    </div>
                    <div id="bookAgainTimeSlotError" style="display: none; font-size: 12px; color: #dc3545; margin-top: 4px;"></div>
                </div>
                
                <div class="form-group">
                    <label for="bookAgain_location_type">Location Type *</label>
                    <div class="input-with-icon">
                        <select id="bookAgain_location_type" name="location_type" required>
                            <option value="walk-in">Walk In</option>
                            <option value="home-service">Home Service</option>
                        </select>
                        <span class="material-icons">location_on</span>
                    </div>
                </div>
                
                <div class="form-group" id="bookAgainAddressGroup" style="display: none;">
                    <label for="bookAgain_customer_address">Home Address</label>
                    <textarea id="bookAgain_customer_address" name="customer_address" placeholder="Enter your home address for home service..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="bookAgain_notes">Additional Notes</label>
                    <textarea id="bookAgain_notes" name="notes" placeholder="Any special requests or notes..."></textarea>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closeBookAgainModal()">Cancel</button>
                <button type="submit" class="confirm-btn">Book Appointment</button>
            </div>
        </form>
    </div>
</div>

<!-- Review Modal -->
<div class="modal-overlay" id="reviewModal">
    <div class="booking-modal">
        <div class="modal-header">
            <div class="modal-title">
                <span class="material-icons">rate_review</span>
                Review Your Appointment
            </div>
            <button class="close-btn" onclick="closeReviewModal()">
                <span class="material-icons">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('appointments.review') }}" id="reviewForm">
            @csrf
            <input type="hidden" name="appointment_id" id="review_appointment_id">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

            <div class="form-section">
                <h3>Appointment Details</h3>
                <div class="appointment-details">
                    <div class="detail-item">
                        <span class="detail-label">Service:</span>
                        <span class="detail-value" id="reviewService">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date & Time:</span>
                        <span class="detail-value" id="reviewDateTime">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Location:</span>
                        <span class="detail-value" id="reviewLocation">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Amount Paid:</span>
                        <span class="detail-value" id="reviewAmount">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Notes:</span>
                        <span class="detail-value" id="reviewNotes">-</span>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Your Review</h3>
                <div class="form-group">
                    <label for="rating">Overall Rating *</label>
                    <div class="rating-stars">
                        <input type="radio" id="star5" name="rating" value="5" required>
                        <label for="star5" class="star">★</label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4" class="star">★</label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3" class="star">★</label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2" class="star">★</label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1" class="star">★</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="review_title">Review Title *</label>
                    <input type="text" id="review_title" name="review_title" placeholder="Brief summary of your experience..." required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label for="review_comment">Detailed Review *</label>
                    <textarea id="review_comment" name="review_comment" placeholder="Share your experience, what you liked, and any suggestions for improvement..." required minlength="20" maxlength="500" rows="4"></textarea>
                    <div class="char-count">
                        <span id="charCount">0</span>/500 characters
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="recommend_service">Would you recommend this service?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="recommend_service" value="yes" checked>
                            <span>Yes, definitely!</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="recommend_service" value="maybe">
                            <span>Maybe, with some improvements</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="recommend_service" value="no">
                            <span>No, not really</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closeReviewModal()">Cancel</button>
                <button type="submit" class="confirm-btn">Submit Review</button>
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

function openBookingModal() {
    document.getElementById('bookingModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    // Initialize service row count
    serviceRowCount = 1;
    // Ensure first service row remove button is hidden
    updateRemoveButtons();
}

function closeBookingModal() {
    document.getElementById('bookingModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Reset the form
    document.querySelector('#bookingModal form').reset();
    // Reset services container to single service
    const container = document.getElementById('servicesContainer');
    const rows = container.querySelectorAll('.service-row');
    rows.forEach((row, index) => {
        if (index > 0) {
            row.remove();
        }
    });
    serviceRowCount = 1;
    updateServiceNumbers();
    updateRemoveButtons();
    // Reset the charges display
    updateCharges();
    // Reset time slot dropdown
    const timeSelect = document.getElementById('appointment_time');
    if (timeSelect) {
        timeSelect.innerHTML = '<option value="">Select a date first...</option>';
    }
    // Hide loading/error messages
    const loadingDiv = document.getElementById('timeSlotLoading');
    const errorDiv = document.getElementById('timeSlotError');
    if (loadingDiv) loadingDiv.style.display = 'none';
    if (errorDiv) errorDiv.style.display = 'none';
    // Reset add service button
    document.getElementById('maxServicesMessage').style.display = 'none';
    document.getElementById('addServiceBtn').disabled = false;
}

// Close modal when clicking outside
document.getElementById('bookingModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeBookingModal();
    }
});

// Function to fetch available time slots
async function fetchAvailableTimeSlots(date, serviceId, timeSelectId, loadingId, errorId) {
    if (!date) {
        const timeSelect = document.getElementById(timeSelectId);
        if (timeSelect) {
            timeSelect.innerHTML = '<option value="">Select a date first...</option>';
        }
        return;
    }

    // Validate and normalize date format (YYYY-MM-DD)
    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
    if (!dateRegex.test(date)) {
        console.error('Invalid date format:', date);
        const timeSelect = document.getElementById(timeSelectId);
        if (timeSelect) {
            timeSelect.innerHTML = '<option value="">Invalid date format</option>';
        }
        return;
    }

    const timeSelect = document.getElementById(timeSelectId);
    const loadingDiv = document.getElementById(loadingId);
    const errorDiv = document.getElementById(errorId);

    if (!timeSelect) return;

    // Show loading state
    timeSelect.innerHTML = '<option value="">Loading...</option>';
    timeSelect.disabled = true;
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (errorDiv) errorDiv.style.display = 'none';

    try {
        const url = new URL('/appointments/available-slots', window.location.origin);
        url.searchParams.append('date', date);
        if (serviceId) {
            url.searchParams.append('service_id', serviceId);
        }

        const response = await fetch(url.toString(), {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success && data.available_slots && data.available_slots.length > 0) {
            // Populate time slots
            timeSelect.innerHTML = '<option value="">Choose a time...</option>';
            data.available_slots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot;
                option.textContent = formatTimeSlot(slot);
                timeSelect.appendChild(option);
            });
            timeSelect.disabled = false;
            if (errorDiv) errorDiv.style.display = 'none';
        } else {
            timeSelect.innerHTML = '<option value="">No available times</option>';
            timeSelect.disabled = true;
            if (errorDiv) {
                errorDiv.textContent = 'No available time slots for this date. Please select another date.';
                errorDiv.style.display = 'block';
            }
        }
    } catch (error) {
        console.error('Error fetching available time slots:', error);
        timeSelect.innerHTML = '<option value="">Error loading times</option>';
        timeSelect.disabled = true;
        if (errorDiv) {
            errorDiv.textContent = 'Failed to load available times. Please try again.';
            errorDiv.style.display = 'block';
        }
    } finally {
        if (loadingDiv) loadingDiv.style.display = 'none';
    }
}

// Function to format time slot for display
function formatTimeSlot(time) {
    const [hours, minutes] = time.split(':');
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour % 12 || 12;
    return `${displayHour}:${minutes} ${ampm}`;
}

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
    
    // Add event listener for date change in booking modal with debouncing
    let dateChangeTimeout;
    const appointmentDateInput = document.getElementById('appointment_date');
    if (appointmentDateInput) {
        appointmentDateInput.addEventListener('change', function() {
            // Clear any pending timeout
            if (dateChangeTimeout) {
                clearTimeout(dateChangeTimeout);
            }
            
            // Debounce the date change to prevent multiple rapid requests
            dateChangeTimeout = setTimeout(() => {
                const selectedDate = this.value;
                
                // Validate date format (YYYY-MM-DD) and ensure it's a complete date
                if (!selectedDate || !/^\d{4}-\d{2}-\d{2}$/.test(selectedDate)) {
                    console.error('Invalid date format:', selectedDate);
                    const timeSelect = document.getElementById('appointment_time');
                    if (timeSelect) {
                        timeSelect.innerHTML = '<option value="">Please select a valid date</option>';
                    }
                    return;
                }
                
                // Additional validation: check if date is reasonable (between 2000 and 2100)
                const year = parseInt(selectedDate.split('-')[0]);
                if (year < 2000 || year > 2100) {
                    console.error('Date out of valid range:', selectedDate);
                    const timeSelect = document.getElementById('appointment_time');
                    if (timeSelect) {
                        timeSelect.innerHTML = '<option value="">Please select a valid date</option>';
                    }
                    return;
                }
                
                // Use the first selected service for time slot checking (or null if none selected)
                const firstSelectedService = Array.from(document.querySelectorAll('.service-select')).find(select => select.value !== '');
                const serviceId = firstSelectedService ? firstSelectedService.value : null;
                fetchAvailableTimeSlots(selectedDate, serviceId, 'appointment_time', 'timeSlotLoading', 'timeSlotError');
            }, 300); // 300ms debounce
        });
    }

    // Add event listener for service changes (to update time slots if date is already selected)
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('service-select')) {
            const selectedDate = document.getElementById('appointment_date')?.value;
            const serviceId = e.target.value;
            if (selectedDate) {
                // Use the first selected service for time slot checking
                const firstSelectedService = Array.from(document.querySelectorAll('.service-select')).find(select => select.value !== '');
                if (firstSelectedService) {
                    fetchAvailableTimeSlots(selectedDate, firstSelectedService.value, 'appointment_time', 'timeSlotLoading', 'timeSlotError');
                }
            }
            updateCharges();
        }
    });
    
    // Add event listener for date change in reschedule modal
    const newAppointmentDateInput = document.getElementById('new_appointment_date');
    if (newAppointmentDateInput) {
        newAppointmentDateInput.addEventListener('change', function() {
            const selectedDate = this.value;
            fetchAvailableTimeSlots(selectedDate, null, 'new_appointment_time', 'rescheduleTimeSlotLoading', 'rescheduleTimeSlotError');
        });
    }

    // Add event listener for date change in book again modal
    const bookAgainDateInput = document.getElementById('bookAgain_appointment_date');
    if (bookAgainDateInput) {
        bookAgainDateInput.addEventListener('change', function() {
            const selectedDate = this.value;
            const serviceId = document.getElementById('bookAgain_service_id')?.value;
            fetchAvailableTimeSlots(selectedDate, serviceId, 'bookAgain_appointment_time', 'bookAgainTimeSlotLoading', 'bookAgainTimeSlotError');
        });
    }
    
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
            const serviceIds = formData.getAll('service_ids[]').filter(id => id !== '');
            const appointmentDate = formData.get('appointment_date');
            const appointmentTime = formData.get('appointment_time');
            
            if (serviceIds.length === 0) {
                e.preventDefault();
                alert('Please select at least one service.');
                return false;
            }
            
            if (!appointmentDate || !appointmentTime) {
                e.preventDefault();
                alert('Please select a date and time.');
                return false;
            }
            
            if (serviceIds.length > 5) {
                e.preventDefault();
                alert('Maximum 5 services allowed per appointment.');
                return false;
            }
        });
    }
});



// Service management functions
let serviceRowCount = 1;

function addServiceRow() {
    const container = document.getElementById('servicesContainer');
    const serviceRows = container.querySelectorAll('.service-row');
    
    if (serviceRows.length >= 5) {
        document.getElementById('maxServicesMessage').style.display = 'block';
        document.getElementById('addServiceBtn').disabled = true;
        return;
    }
    
    const newRow = document.createElement('div');
    newRow.className = 'service-row';
    newRow.setAttribute('data-service-index', serviceRowCount);
    
    const serviceNumber = serviceRowCount + 1;
    // Get services from the first select to clone options
    const firstSelect = document.querySelector('.service-select');
    const serviceOptions = Array.from(firstSelect.options).map(opt => {
        if (opt.value) {
            return `<option value="${opt.value}" data-price="${opt.dataset.price}" data-name="${opt.dataset.name}">${opt.text}</option>`;
        }
        return `<option value="">Choose a service...</option>`;
    }).join('');
    
    newRow.innerHTML = `
        <div class="form-group">
            <label>Select a Service <span class="service-number">${serviceNumber}</span></label>
            <div class="input-with-icon" style="display: flex; gap: 8px; position: relative;">
                <select class="service-select" name="service_ids[]" data-index="${serviceRowCount}" onchange="updateCharges()" required style="flex: 1; padding-right: 40px;">
                    ${serviceOptions}
                </select>
                <button type="button" class="remove-service-btn" onclick="removeServiceRow(${serviceRowCount})" style="background: #dc3545; color: white; border: none; border-radius: 8px; padding: 12px 16px; cursor: pointer; font-size: 14px; min-width: 50px;">
                    <span class="material-icons" style="font-size: 18px;">delete</span>
                </button>
                <span class="material-icons" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #b48b8b; font-size: 18px; pointer-events: none;">expand_more</span>
            </div>
        </div>
    `;
    
    container.appendChild(newRow);
    serviceRowCount++;
    
    // Show remove buttons on all rows except the first
    updateRemoveButtons();
    updateCharges();
}

function removeServiceRow(index) {
    const container = document.getElementById('servicesContainer');
    const row = container.querySelector(`[data-service-index="${index}"]`);
    if (row) {
        row.remove();
        updateServiceNumbers();
        updateRemoveButtons();
        updateCharges();
        
        // Re-enable add button if under limit
        const serviceRows = container.querySelectorAll('.service-row');
        if (serviceRows.length < 5) {
            document.getElementById('maxServicesMessage').style.display = 'none';
            document.getElementById('addServiceBtn').disabled = false;
        }
    }
}

function updateServiceNumbers() {
    const container = document.getElementById('servicesContainer');
    const rows = container.querySelectorAll('.service-row');
    rows.forEach((row, index) => {
        const label = row.querySelector('label');
        const serviceNumber = label.querySelector('.service-number');
        if (serviceNumber) {
            serviceNumber.textContent = index + 1;
        }
    });
}

function updateRemoveButtons() {
    const container = document.getElementById('servicesContainer');
    const rows = container.querySelectorAll('.service-row');
    rows.forEach((row, index) => {
        const removeBtn = row.querySelector('.remove-service-btn');
        if (removeBtn) {
            // Show remove button if more than one service row
            removeBtn.style.display = rows.length > 1 ? 'block' : 'none';
        }
    });
}

function updateCharges() {
    // Get all selected services
    const serviceSelects = document.querySelectorAll('.service-select');
    let totalServicePrice = 0;
    const selectedServices = [];
    
    serviceSelects.forEach((select, index) => {
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const servicePrice = parseFloat(selectedOption.dataset.price || 0);
            const serviceName = selectedOption.dataset.name || selectedOption.text;
            totalServicePrice += servicePrice;
            selectedServices.push({
                name: serviceName,
                price: servicePrice
            });
        }
    });
    
    // Update services list display
    const servicesList = document.getElementById('servicesList');
    if (selectedServices.length > 0) {
        // Remove old service items (keep the main "Services:" row)
        const oldItems = servicesList.querySelectorAll('.service-item');
        oldItems.forEach(item => item.remove());
        
        // Add individual service items
        selectedServices.forEach((service, index) => {
            const item = document.createElement('div');
            item.className = 'charge-item service-item';
            item.innerHTML = `
                <span>${index + 1}. ${service.name}:</span>
                <span>₱${service.price}</span>
            `;
            servicesList.insertBefore(item, servicesList.firstChild);
        });
        
        document.getElementById('servicesTotal').textContent = `₱${totalServicePrice}`;
    } else {
        document.getElementById('servicesTotal').textContent = '₱0';
        const oldItems = servicesList.querySelectorAll('.service-item');
        oldItems.forEach(item => item.remove());
    }
    
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
    
    const total = totalServicePrice + transportationPrice;
    const final = total - 100;
    
    // Store total amount in hidden field (will be used for each appointment)
    document.getElementById('amount').value = totalServicePrice;
    
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

// Reschedule Modal Functions
function openRescheduleModal(appointmentId, serviceName, appointmentDate, appointmentTime, locationType, customerAddress, notes) {
    // Set the appointment ID in the hidden field
    document.getElementById('reschedule_appointment_id').value = appointmentId;
    
    // Populate current appointment details
    document.getElementById('currentService').textContent = serviceName;
    document.getElementById('currentDateTime').textContent = formatDateTime(appointmentDate, appointmentTime);
    document.getElementById('currentLocation').textContent = formatLocation(locationType, customerAddress);
    document.getElementById('currentNotes').textContent = notes || 'None';
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('new_appointment_date').min = today;
    
    // Show the modal
    document.getElementById('rescheduleModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeRescheduleModal() {
    document.getElementById('rescheduleModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Reset the form
    document.getElementById('rescheduleForm').reset();
    // Reset time slot dropdown
    const timeSelect = document.getElementById('new_appointment_time');
    if (timeSelect) {
        timeSelect.innerHTML = '<option value="">Select a date first...</option>';
    }
    // Hide loading/error messages
    const loadingDiv = document.getElementById('rescheduleTimeSlotLoading');
    const errorDiv = document.getElementById('rescheduleTimeSlotError');
    if (loadingDiv) loadingDiv.style.display = 'none';
    if (errorDiv) errorDiv.style.display = 'none';
}

// Close reschedule modal when clicking outside
document.getElementById('rescheduleModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRescheduleModal();
    }
});

// Close review modal when clicking outside
document.getElementById('reviewModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});

function formatDateTime(date, time) {
    const dateObj = new Date(date + 'T' + time);
    return dateObj.toLocaleDateString('en-US', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    }) + ' at ' + dateObj.toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
}

function formatLocation(locationType, address) {
    if (locationType === 'home-service') {
        return 'Home Service' + (address ? ` (${address})` : '');
    } else {
        return 'Walk In';
    }
}

// Add form submission handler for reschedule form
document.addEventListener('DOMContentLoaded', function() {
    const rescheduleForm = document.getElementById('rescheduleForm');
    if (rescheduleForm) {
        rescheduleForm.addEventListener('submit', function(e) {
            const newDate = document.getElementById('new_appointment_date').value;
            const newTime = document.getElementById('new_appointment_time').value;
            const reason = document.getElementById('reschedule_reason').value;
            
            // Clear previous error messages
            clearValidationErrors();
            
            let hasErrors = false;
            
            // Validate required fields
            if (!newDate) {
                showFieldError('new_appointment_date', 'Please select a new date.');
                hasErrors = true;
            }
            
            if (!newTime) {
                showFieldError('new_appointment_time', 'Please select a new time.');
                hasErrors = true;
            }
            
            if (!reason.trim()) {
                showFieldError('reschedule_reason', 'Please provide a reason for rescheduling.');
                hasErrors = true;
            } else if (reason.trim().length < 10) {
                showFieldError('reschedule_reason', 'Reason must be at least 10 characters long.');
                hasErrors = true;
            }
            
            if (hasErrors) {
                e.preventDefault();
                return false;
            }
            
            // Check if the new date and time is in the future
            const selectedDateTime = new Date(newDate + 'T' + newTime);
            const now = new Date();
            
            if (selectedDateTime <= now) {
                e.preventDefault();
                alert('Please select a future date and time for your appointment.');
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
            
            // Re-enable button after 5 seconds in case of error
            setTimeout(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });
    }
    
    // Add character counter for review comment
    const reviewComment = document.getElementById('review_comment');
    if (reviewComment) {
        reviewComment.addEventListener('input', function() {
            const charCount = this.value.length;
            document.getElementById('charCount').textContent = charCount;
            
            // Change color based on character count
            if (charCount < 20) {
                this.style.borderColor = '#f44336';
            } else if (charCount > 450) {
                this.style.borderColor = '#ff9800';
            } else {
                this.style.borderColor = '#4caf50';
            }
        });
    }
    
    // Add form submission handler for review form
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            const rating = document.querySelector('input[name="rating"]:checked');
            const title = document.getElementById('review_title').value.trim();
            const comment = document.getElementById('review_comment').value.trim();
            
            // Clear previous error messages
            clearValidationErrors();
            
            let hasErrors = false;
            
            // Validate required fields
            if (!rating) {
                showFieldError('rating', 'Please select a rating.');
                hasErrors = true;
            }
            
            if (!title) {
                showFieldError('review_title', 'Please provide a review title.');
                hasErrors = true;
            }
            
            if (!comment) {
                showFieldError('review_comment', 'Please provide a detailed review.');
                hasErrors = true;
            } else if (comment.length < 20) {
                showFieldError('review_comment', 'Review must be at least 20 characters long.');
                hasErrors = true;
            }
            
            if (hasErrors) {
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;
            
            // Re-enable button after 5 seconds in case of error
            setTimeout(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });
    }
});

function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (field) {
        field.style.borderColor = '#f44336';
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#f44336';
        errorDiv.style.fontSize = '12px';
        errorDiv.style.marginTop = '4px';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    }
}

function clearValidationErrors() {
    // Clear all field errors
    document.querySelectorAll('.field-error').forEach(error => error.remove());
    document.querySelectorAll('.input-with-icon input, .input-with-icon select, textarea').forEach(field => {
        field.style.borderColor = '#e5cfd1';
    });
}

// Cancel Modal Functions
function openCancelModal(appointmentId, serviceName, appointmentDate) {
    // Store appointment ID for form submission
    window.currentCancelAppointmentId = appointmentId;
    
    // Populate appointment details
    document.getElementById('cancelService').textContent = serviceName || 'Service';
    document.getElementById('cancelDateTime').textContent = formatDateTime(appointmentDate);
    
    // Show the modal
    document.getElementById('cancelModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeCancelModal() {
    document.getElementById('cancelModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Book Again Modal Functions
function openBookAgainModal(appointmentId, serviceName, serviceId, amount) {
    // Set the service ID and amount in the hidden fields
    document.getElementById('bookAgain_service_id').value = serviceId || 1;
    document.getElementById('bookAgain_amount').value = amount || 0;
    
    // Populate previous service details
    document.getElementById('bookAgainService').textContent = serviceName || 'Service';
    document.getElementById('bookAgainAmount').textContent = '₱' + (parseFloat(amount || 0)).toFixed(2);
    
    // Show the modal
    document.getElementById('bookAgainModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeBookAgainModal() {
    document.getElementById('bookAgainModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Reset the form
    document.getElementById('bookAgainForm').reset();
    // Reset time slot dropdown
    const timeSelect = document.getElementById('bookAgain_appointment_time');
    if (timeSelect) {
        timeSelect.innerHTML = '<option value="">Select a date first...</option>';
    }
    // Hide loading/error messages
    const loadingDiv = document.getElementById('bookAgainTimeSlotLoading');
    const errorDiv = document.getElementById('bookAgainTimeSlotError');
    if (loadingDiv) loadingDiv.style.display = 'none';
    if (errorDiv) errorDiv.style.display = 'none';
}

// Review Modal Functions
function openReviewModal(appointmentId, serviceName, appointmentDate, locationType, customerAddress, notes, amount) {
    // Set the appointment ID in the hidden field
    document.getElementById('review_appointment_id').value = appointmentId;
    
    // Populate appointment details
    document.getElementById('reviewService').textContent = serviceName || 'Service';
    document.getElementById('reviewDateTime').textContent = formatDateTime(appointmentDate);
    document.getElementById('reviewLocation').textContent = (locationType === 'home-service' ? 'Home Service' : 'Walk In') + (customerAddress ? ` (${customerAddress})` : '');
    document.getElementById('reviewAmount').textContent = '₱' + (parseFloat(amount || 0)).toFixed(2);
    document.getElementById('reviewNotes').textContent = notes || 'None';
    
    // Show the modal
    document.getElementById('reviewModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeReviewModal() {
    document.getElementById('reviewModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Reset the form
    document.getElementById('reviewForm').reset();
    // Reset character count
    document.getElementById('charCount').textContent = '0';
}

// Helper function for formatting date and time
function formatDateTime(appointmentDate) {
    const dateObj = new Date(appointmentDate);
    return dateObj.toLocaleDateString('en-US', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    }) + ' at ' + dateObj.toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
}

// Close modals when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    // Cancel modal
    const cancelModal = document.getElementById('cancelModal');
    if (cancelModal) {
        cancelModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });
    }
    
    // Book Again modal
    const bookAgainModal = document.getElementById('bookAgainModal');
    if (bookAgainModal) {
        bookAgainModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookAgainModal();
            }
        });
    }
    
    // Review modal
    const reviewModal = document.getElementById('reviewModal');
    if (reviewModal) {
        reviewModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewModal();
            }
        });
    }
    
    // Handle location type change for book again form
    const bookAgainLocationType = document.getElementById('bookAgain_location_type');
    if (bookAgainLocationType) {
        bookAgainLocationType.addEventListener('change', function() {
            const addressGroup = document.getElementById('bookAgainAddressGroup');
            if (this.value === 'home-service') {
                addressGroup.style.display = 'block';
            } else {
                addressGroup.style.display = 'none';
            }
        });
    }
    
    // Add character counter for review comment
    const reviewComment = document.getElementById('review_comment');
    if (reviewComment) {
        reviewComment.addEventListener('input', function() {
            const charCount = this.value.length;
            document.getElementById('charCount').textContent = charCount;
            
            // Change color based on character count
            if (charCount < 20) {
                this.style.borderColor = '#f44336';
            } else if (charCount > 450) {
                this.style.borderColor = '#ff9800';
            } else {
                this.style.borderColor = '#4caf50';
            }
        });
    }
    
    // Add form submission handler for cancel form
    const cancelForm = document.getElementById('cancelForm');
    if (cancelForm) {
        cancelForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!window.currentCancelAppointmentId) {
                alert('Error: Appointment ID not found. Please try again.');
                return false;
            }
            
            // Set the form action with the correct appointment ID
            this.action = `/appointments/${window.currentCancelAppointmentId}/cancel`;
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Cancelling...';
            submitBtn.disabled = true;
            
            // Submit the form
            this.submit();
        });
    }
    
    // Add form submission handler for review form
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            const rating = document.querySelector('input[name="rating"]:checked');
            const title = document.getElementById('review_title').value.trim();
            const comment = document.getElementById('review_comment').value.trim();
            
            let hasErrors = false;
            
            // Validate required fields
            if (!rating) {
                alert('Please select a rating.');
                hasErrors = true;
            }
            
            if (!title) {
                alert('Please provide a review title.');
                hasErrors = true;
            }
            
            if (!comment) {
                alert('Please provide a detailed review.');
                hasErrors = true;
            } else if (comment.length < 20) {
                alert('Review must be at least 20 characters long.');
                hasErrors = true;
            }
            
            if (hasErrors) {
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;
            
            // Re-enable button after 5 seconds in case of error
            setTimeout(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });
    }
    
    // Function to update favorites count on the dashboard
    function updateFavoritesCount() {
        fetch('/favorites/count', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.count !== undefined) {
                // Update the favorites count display
                const favoritesValueElement = document.querySelector('.summary-card:nth-child(3) .summary-value');
                if (favoritesValueElement) {
                    favoritesValueElement.textContent = data.count;
                }
                
                // Update the description text
                const favoritesDescElement = document.querySelector('.summary-card:nth-child(3) div[style*="font-size:13px"]');
                if (favoritesDescElement) {
                    favoritesDescElement.textContent = `Saved for your next appointment`;
                }
            }
        })
        .catch(error => {
            console.error('Error updating favorites count:', error);
        });
    }
    
    // Listen for custom events from other pages when favorites change
    document.addEventListener('favoritesUpdated', function() {
        updateFavoritesCount();
    });
    
    // Update favorites count when page loads
    updateFavoritesCount();
});
</script>

<!-- Google Material Icons CDN for icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection

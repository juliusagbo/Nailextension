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
        margin-bottom: 24px;
    }
    .filters-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .filter-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .filter-btn {
        padding: 8px 16px;
        border: 1px solid #b48b8b;
        background: #fff;
        color: #b48b8b;
        border-radius: 20px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
    }
    .filter-btn.active {
        background: #b48b8b;
        color: #fff;
    }
    .filter-btn:hover:not(.active) {
        background: #f7eaea;
    }
    .date-range {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid #e5cfd1;
        border-radius: 20px;
        padding: 6px 12px;
    }
    .date-range input {
        border: none;
        outline: none;
        background: transparent;
        color: #b48b8b;
        font-size: 14px;
        width: 80px;
    }
    .date-range .material-icons {
        color: #b48b8b;
        font-size: 16px;
    }
    .transaction-table {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px #eee;
        overflow: hidden;
        margin-top: 24px;
    }
    .transaction-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .transaction-table th {
        background: #f7eaea;
        color: #b48b8b;
        font-weight: 700;
        padding: 16px;
        text-align: left;
        font-size: 14px;
    }
    .transaction-table td {
        padding: 16px;
        color: #a07a7a;
        font-size: 14px;
        border-bottom: 1px solid #f0e0e0;
    }
    .transaction-table tr:last-child td {
        border-bottom: none;
    }
    .transaction-table tr:hover {
        background: #f9f9f9;
    }
    .status-badge {
        border-radius: 12px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
    }
    .status-completed {
        background: #43a047;
    }

    .status-pending {
        background: #ff9800;
    }
    .status-failed {
        background: #f44336;
    }
    .view-btn {
        background: #6c757d;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }
    .view-btn:hover {
        background: #5a6268;
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
        
        .filters-section {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        
        .filter-buttons {
            justify-content: flex-start;
            overflow-x: auto;
            padding-bottom: 4px;
        }
        
        .filter-btn {
            white-space: nowrap;
        }
        
        .date-range {
            justify-content: space-between;
        }
        
        .date-range input {
            width: auto;
            flex: 1;
        }
        
        /* Convert table to cards on mobile */
        .transaction-table {
            background: transparent;
            box-shadow: none;
        }
        
        .transaction-table table {
            display: block;
        }
        
        .transaction-table thead {
            display: none;
        }
        
        .transaction-table tbody {
            display: block;
        }
        
        .transaction-table tr {
            display: block;
            background: white;
            margin-bottom: 16px;
            border-radius: 12px;
            box-shadow: 0 2px 8px #eee;
            padding: 16px;
        }
        
        .transaction-table td {
            display: block;
            padding: 8px 0;
            border: none;
            text-align: left;
        }
        
        .transaction-table td:before {
            content: attr(data-label);
            font-weight: 700;
            color: #b48b8b;
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
        }
        
        .transaction-table tr:hover {
            background: white;
        }
        
        .status-badge {
            display: inline-block;
        }
        
        .view-btn {
            margin-top: 8px;
            width: 100%;
            justify-content: center;
        }
        
        /* Modal responsive */
        .transaction-modal {
            max-width: 95% !important;
            padding: 24px 20px !important;
            margin: 20px auto !important;
        }
        
        .modal-overlay {
            padding: 20px;
        }
        
        /* Empty state responsive */
        .transaction-table tbody tr td[colspan] > div {
            padding: 20px !important;
        }
        
        .transaction-table tbody tr td[colspan] .material-icons {
            font-size: 36px !important;
        }
        
        .transaction-table tbody tr td[colspan] > div > div:last-child > div:first-child {
            font-size: 16px !important;
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
        
        .dashboard-header .search-bar {
            width: 100%;
            max-width: 100%;
        }
        
        .filter-btn {
            font-size: 13px;
            padding: 6px 12px;
        }
        
        .date-range {
            padding: 8px 12px;
        }
        
        .date-range input {
            font-size: 13px;
        }
        
        .transaction-table td {
            font-size: 13px;
        }
        
        .transaction-modal {
            font-size: 14px;
        }
        
        .transaction-modal > div:first-child button {
            padding: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
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
            <a href="{{ url('/transaction-history') }}" class="active">Transaction History</a>
            <a href="{{ url('/profile-settings') }}">Profile Settings</a>
            <a href="{{ url('/faqs') }}">FAQs</a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" style="width:100%;">
            @csrf
            <button type="submit" class="logout" style="width:100%;text-align:left;background:none;border:none;padding:12px 32px;cursor:pointer;">Logout</button>
        </form>
    </div>
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div class="page-title">Transaction History</div>
            <div style="display:flex; align-items:center;">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search transactions..." onkeyup="searchTransactions()">
                    <span class="material-icons" style="font-size:18px;">search</span>
                </div>
            </div>
        </div>
        
        <div class="filters-section">
            <div class="filter-buttons">
                <a href="{{ url('/transaction-history') }}" class="filter-btn {{ !request('status') || request('status') == 'all' ? 'active' : '' }}">All</a>
                <a href="{{ url('/transaction-history?status=completed') }}" class="filter-btn {{ request('status') == 'completed' ? 'active' : '' }}">Completed</a>
                <a href="{{ url('/transaction-history?status=failed') }}" class="filter-btn {{ request('status') == 'failed' ? 'active' : '' }}">Failed</a>
                <a href="{{ url('/transaction-history?status=pending') }}" class="filter-btn {{ request('status') == 'pending' ? 'active' : '' }}">Pending</a>
            </div>
            <div class="date-range">
                <input type="date" id="dateFilter" onchange="filterByDate()">
                <span class="material-icons">calendar_today</span>
            </div>
        </div>
        
        <div class="transaction-table">
            <table>
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Service</th>
                        <th>Location</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td data-label="Transaction ID">{{ $transaction['transaction_id'] }}</td>
                        <td data-label="Date">{{ \Carbon\Carbon::parse($transaction['date'])->format('M d, Y') }}</td>
                        <td data-label="Service">{{ $transaction['service'] }}</td>
                        <td data-label="Location">{{ $transaction['location'] }}</td>
                        <td data-label="Amount">{{ $transaction['amount'] }}</td>
                        <td data-label="Payment Method">{{ $transaction['payment_method'] }}</td>
                        <td data-label="Status">
                            <span class="status-badge status-{{ $transaction['status'] }}">
                                {{ ucfirst($transaction['status']) }}
                            </span>
                        </td>
                        <td data-label="Actions">
                            <a href="#" class="view-btn" onclick="openTransactionModal({{ json_encode($transaction) }})">
                                <span class="material-icons" style="font-size:14px;">visibility</span>
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #b48b8b; padding: 40px;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 16px;">
                                <span class="material-icons" style="font-size: 48px; color: #e0e0e0;">receipt_long</span>
                                <div>
                                    <div style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No transactions found</div>
                                    <div style="font-size: 14px; color: #a07a7a;">You haven't made any appointments yet.</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Transaction Details Modal -->
<div class="modal-overlay" id="transactionModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.18);z-index:2000;align-items:center;justify-content:center;">
    <div class="transaction-modal" style="background:#fff;border-radius:18px;max-width:520px;width:95%;margin:auto;padding:32px 32px 24px 32px;box-shadow:0 4px 32px #0001;position:relative;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
            <div style="display:flex;align-items:center;gap:8px;font-weight:600;color:#b48b8b;font-size:18px;">
                <span class="material-icons" style="font-size:22px;">receipt_long</span>
                Transaction Details
            </div>
            <button onclick="closeTransactionModal()" style="background:none;border:none;font-size:22px;color:#b48b8b;cursor:pointer;">&times;</button>
        </div>
        <div id="modalDetails">
            <!-- Populated by JS -->
        </div>
        <div style="margin-top:18px;text-align:right;">
            <button onclick="printTransactionReceipt()" style="background:#b48b8b;color:#fff;font-weight:600;border:none;border-radius:6px;padding:10px 32px;font-size:15px;display:inline-flex;align-items:center;gap:8px;cursor:pointer;">
                <span class="material-icons" style="font-size:18px;">print</span> Print Receipt
            </button>
        </div>
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

function openTransactionModal(transaction) {
    // Get status color
    let statusColor = '#43a047';
    if(transaction.status === 'completed') statusColor = '#43a047';
    else if(transaction.status === 'pending') statusColor = '#ff9800';
    else if(transaction.status === 'failed') statusColor = '#f44336';
    
    // Extract base amount from the formatted amount string
    const amountText = transaction.amount.replace(/[^\d]/g, '');
    const baseAmount = parseInt(amountText) || 0;
    
    // Populate modal with transaction data
    document.getElementById('modalDetails').innerHTML = `
        <div style="margin-bottom:10px;"><b>Transaction ID:</b> <span style='color:#b48b8b;'>${transaction.transaction_id}</span></div>
        <div style="margin-bottom:10px;"><b>Date & Time:</b> <span style='color:#b48b8b;'>${new Date(transaction.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span></div>
        <div style="margin-bottom:10px;"><b>Status:</b> <span style='background:${statusColor};color:#fff;padding:2px 10px;border-radius:8px;font-size:13px;'>${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}</span></div>
        <div style="margin-bottom:10px;"><b>Payment Method:</b> <span style='color:#b48b8b;'>${transaction.payment_method}</span></div>
        <div style="margin-bottom:10px;"><b>Service:</b> <span style='color:#b48b8b;'>${transaction.service}</span></div>
        <div style="margin-bottom:10px;"><b>Location:</b> <span style='color:#b48b8b;'>${transaction.location}</span></div>
        <div style="margin-bottom:10px;"><b>Qty:</b> 1</div>
        <div style="margin-bottom:10px;"><b>Amount:</b> ${transaction.amount}</div>
        <hr style='margin:18px 0;'>
        <div style="display:flex;justify-content:space-between;margin-bottom:6px;"><span>Down Payment:</span><span style='color:#b48b8b;'>₱100</span></div>
        <div style="display:flex;justify-content:space-between;margin-bottom:6px;"><span>Paid after service:</span><span style='color:#b48b8b;'>₱${baseAmount - 100}</span></div>
        <div style="display:flex;justify-content:space-between;font-weight:600;margin-top:10px;"><span>Total Amount:</span><span style='color:#b48b8b;'>₱${baseAmount}</span></div>
    `;
    document.getElementById('transactionModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeTransactionModal() {
    document.getElementById('transactionModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('transactionModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeTransactionModal();
    }
});

function printTransactionReceipt() {
    window.print();
}

function searchTransactions() {
    const searchInput = document.getElementById('searchInput');
    const searchTerm = searchInput.value.toLowerCase();
    const tableRows = document.querySelectorAll('.transaction-table tbody tr');
    
    tableRows.forEach(row => {
        const transactionId = row.children[0].textContent.toLowerCase();
        const service = row.children[2].textContent.toLowerCase();
        const location = row.children[3].textContent.toLowerCase();
        
        if (transactionId.includes(searchTerm) || service.includes(searchTerm) || location.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function filterByDate() {
    const dateInput = document.getElementById('dateFilter');
    const selectedDate = dateInput.value;
    
    if (selectedDate) {
        window.location.href = `{{ url('/transaction-history') }}?date=${selectedDate}`;
    } else {
        window.location.href = `{{ url('/transaction-history') }}`;
    }
}
</script>
<!-- Google Material Icons CDN for icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection 
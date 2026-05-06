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
    .faq-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 32px;
    }
    .faq-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px #eee;
        overflow: hidden;
        color: #b48b8b;
        transition: all 0.2s;
    }
    .faq-card:hover {
        box-shadow: 0 4px 16px #ddd;
    }
    .faq-question {
        padding: 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        font-size: 16px;
        color: #a07a7a;
        border-bottom: 1px solid #f0e0e0;
        gap: 16px;
    }
    .faq-question:hover {
        background: #f9f9f9;
    }
    .faq-answer {
        padding: 20px;
        color: #a07a7a;
        font-size: 14px;
        line-height: 1.6;
        background: #fafafa;
    }
    .faq-arrow {
        color: #b48b8b;
        font-size: 18px;
        transition: transform 0.2s;
    }
    .faq-card.expanded .faq-arrow {
        transform: rotate(180deg);
    }
    .contact-section {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px #eee;
        padding: 24px;
        text-align: center;
        color: #b48b8b;
    }
    .contact-section h3 {
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 16px;
        color: #a07a7a;
    }
    .contact-info {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 24px;
        margin-top: 16px;
        flex-wrap: wrap;
    }
    .contact-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #b48b8b;
        font-size: 14px;
    }
    .contact-item .material-icons {
        font-size: 18px;
    }
    .social-links {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-top: 16px;
    }
    .social-link {
        color: #b48b8b;
        font-size: 20px;
        text-decoration: none;
        transition: color 0.2s;
    }
    .social-link:hover {
        color: #a07a7a;
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
            margin-bottom: 20px;
        }
        
        .dashboard-header .search-bar {
            width: 100%;
            max-width: 100%;
        }
        
        .faq-container {
            gap: 12px;
            margin-bottom: 24px;
        }
        
        .faq-card {
            border-radius: 10px;
        }
        
        .faq-question {
            padding: 16px;
            font-size: 15px;
            gap: 10px;
        }
        
        .faq-answer {
            padding: 16px;
            font-size: 13px;
        }
        
        .faq-arrow {
            font-size: 20px;
            flex-shrink: 0;
        }
        
        .contact-section {
            padding: 20px;
        }
        
        .contact-section h3 {
            font-size: 16px;
            margin-bottom: 14px;
        }
        
        .contact-info {
            flex-direction: column;
            gap: 12px;
            align-items: center;
        }
        
        .contact-item {
            font-size: 13px;
        }
        
        .social-links {
            margin-top: 14px;
        }
        
        .social-link {
            font-size: 24px;
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
        
        .faq-container {
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .faq-question {
            padding: 14px;
            font-size: 14px;
        }
        
        .faq-answer {
            padding: 14px;
            font-size: 12px;
            line-height: 1.5;
        }
        
        .faq-arrow {
            font-size: 18px;
        }
        
        .contact-section {
            padding: 16px;
            border-radius: 10px;
        }
        
        .contact-section h3 {
            font-size: 15px;
        }
        
        .contact-item {
            font-size: 12px;
            width: 100%;
        }
        
        .contact-item .material-icons {
            font-size: 16px;
        }
        
        .social-links {
            gap: 12px;
        }
        
        .social-link {
            font-size: 22px;
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
            <a href="{{ url('/profile-settings') }}">Profile Settings</a>
            <a href="{{ url('/faqs') }}" class="active">FAQs</a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" style="width:100%;">
            @csrf
            <button type="submit" class="logout" style="width:100%;text-align:left;background:none;border:none;padding:12px 32px;cursor:pointer;">Logout</button>
        </form>
    </div>
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div class="page-title">Frequently Asked Questions</div>
            <div style="display:flex; align-items:center;">
                <div class="search-bar">
                    <input type="text" placeholder="Search FAQs...">
                    <span class="material-icons" style="font-size:18px;">search</span>
                </div>
            </div>
        </div>
        
        <div class="faq-container">
            <div class="faq-card">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    What are nail extensions?
                    <span class="faq-arrow material-icons">expand_more</span>
                </div>
                <div class="faq-answer">
                    Nail extensions are artificial enhancements that add length and improve the appearance of your natural nails. They are typically made from materials like acrylic, gel, or soft gel and are applied over your natural nails to create longer, more durable nails.
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    Are nail extensions safe?
                    <span class="faq-arrow material-icons">expand_more</span>
                </div>
                <div class="faq-answer">
                    Yes, nail extensions are safe when applied and removed by a professional nail technician. The main cause of damage to natural nails comes from improper removal techniques, not the extensions themselves.
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    How long do nail extensions last?
                    <span class="faq-arrow material-icons">expand_more</span>
                </div>
                <div class="faq-answer">
                    Nail extensions typically last 2 to 3 weeks before you'll need a fill or removal. The exact duration depends on how fast your natural nails grow and how well you take care of them.
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    Can I still do daily activities with extensions?
                    <span class="faq-arrow material-icons">expand_more</span>
                </div>
                <div class="faq-answer">
                    Yes, you can perform most daily activities with nail extensions. However, it's important to avoid using your nails as tools to prevent lifting or breakage. Be gentle when opening cans, typing, or doing other activities.
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    How do I maintain my nail extensions?
                    <span class="faq-arrow material-icons">expand_more</span>
                </div>
                <div class="faq-answer">
                    To maintain your nail extensions, use cuticle oil daily, wear gloves when cleaning or doing dishes, avoid biting or picking at your nails, and schedule regular fill-ins every 2-3 weeks to keep them looking fresh.
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    Will my natural nails be damaged?
                    <span class="faq-arrow material-icons">expand_more</span>
                </div>
                <div class="faq-answer">
                    No, your natural nails should not be damaged if the extensions are applied and removed correctly by a professional. Damage typically occurs from improper removal techniques or infrequent maintenance.
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    Can I remove extensions at home?
                    <span class="faq-arrow material-icons">expand_more</span>
                </div>
                <div class="faq-answer">
                    It's not recommended to remove nail extensions at home. Professional removal ensures your natural nails are not harmed. Picking or prying at extensions can lead to thinning or peeling of your natural nails.
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    Are there any risks of infection?
                    <span class="faq-arrow material-icons">expand_more</span>
                </div>
                <div class="faq-answer">
                    Infections are rare if the salon follows proper hygiene protocols. However, if you experience any pain, redness, or swelling around your nails, inform your technician immediately.
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    What is your cancellation policy?
                    <span class="faq-arrow material-icons">expand_more</span>
                </div>
                <div class="faq-answer">
                    You can reschedule your appointment 2-3 days before your scheduled time. Downpayment is non-refundable if cancelled. Your booking will be cancelled if you are 30 minutes late without prior notice.
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    How much do nail extensions cost?
                    <span class="faq-arrow material-icons">expand_more</span>
                </div>
                <div class="faq-answer">
                    Prices vary depending on the style and salon. At Nailed by Via, base extensions start at ₱1,200. Add-ons like nail art or French tips cost extra. Contact us for specific pricing based on your desired style.
                </div>
            </div>
        </div>
        
        <div class="contact-section">
            <h3>You have questions? You can call us!</h3>
            <div class="contact-info">
                <div class="contact-item">
                    <span class="material-icons">phone</span>
                    Contact Nailed by Via at 0912-345-6789
                </div>
                <div class="contact-item">
                    <span class="material-icons">chat</span>
                    Or message us on Facebook / Instagram
                </div>
            </div>
            <div class="social-links">
                <a href="#" class="social-link material-icons">facebook</a>
                <a href="#" class="social-link material-icons">camera_alt</a>
            </div>
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

// FAQ toggle functionality
function toggleFAQ(element) {
    const card = element.parentElement;
    const answer = card.querySelector('.faq-answer');
    const arrow = element.querySelector('.faq-arrow');
    
    if (card.classList.contains('expanded')) {
        card.classList.remove('expanded');
        answer.style.display = 'none';
    } else {
        card.classList.add('expanded');
        answer.style.display = 'block';
    }
}

// Initialize all FAQ answers as hidden
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.faq-answer').forEach(answer => {
        answer.style.display = 'none';
    });
});
</script>

<!-- Google Material Icons CDN for icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection 
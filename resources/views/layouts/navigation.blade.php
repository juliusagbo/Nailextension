<style>
    .mobile-nav-menu {
        display: none;
        position: fixed;
        top: 0;
        right: -100%;
        width: 280px;
        height: 100vh;
        background: white;
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        z-index: 1001;
        transition: right 0.3s ease;
        padding: 80px 0 20px;
        overflow-y: auto;
    }
    
    .mobile-nav-menu.active {
        right: 0;
    }
    
    .mobile-nav-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
    }
    
    .mobile-nav-overlay.active {
        display: block;
    }
    
    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        color: #b48b8b;
        font-size: 24px;
        cursor: pointer;
        padding: 8px;
    }
    
    .mobile-close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        color: #b48b8b;
        font-size: 28px;
        cursor: pointer;
    }
    
    .mobile-nav-links {
        display: flex;
        flex-direction: column;
        padding: 20px;
        gap: 10px;
    }
    
    .mobile-nav-links a {
        display: block;
        padding: 12px 20px;
        text-align: center;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    @media (max-width: 768px) {
        .mobile-menu-btn,
        .mobile-nav-menu {
            display: block;
        }
        
        .desktop-auth-buttons {
            display: none;
        }
    }
    
    @media (max-width: 480px) {
        .mobile-nav-menu {
            width: 100%;
        }
    }
</style>

<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 36px;" class="h-9 sm:h-9">
                    </a>
                </div>
            </div>
            
            <!-- Desktop Auth Buttons -->
            <div class="desktop-auth-buttons flex items-center gap-2">
                <a href="{{ route('login') }}" class="rounded-full px-4 py-1.5 sm:px-5 sm:py-2 border border-[#b48b8b] text-[#b48b8b] font-semibold bg-white hover:bg-[#b48b8b] hover:text-white transition text-sm sm:text-base">Log In</a>
                <a href="{{ route('register') }}" class="rounded-full px-4 py-1.5 sm:px-5 sm:py-2 border border-[#b48b8b] text-white font-semibold bg-[#b48b8b] hover:bg-[#a07a7a] transition text-sm sm:text-base">Sign Up</a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" onclick="toggleMobileNav()">
                ☰
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Navigation Overlay -->
<div class="mobile-nav-overlay" id="mobileNavOverlay" onclick="toggleMobileNav()"></div>

<!-- Mobile Navigation Menu -->
<div class="mobile-nav-menu" id="mobileNavMenu">
    <button class="mobile-close-btn" onclick="toggleMobileNav()">×</button>
    <div class="mobile-nav-links">
        <a href="{{ route('login') }}" class="border border-[#b48b8b] text-[#b48b8b] bg-white hover:bg-[#b48b8b] hover:text-white">Log In</a>
        <a href="{{ route('register') }}" class="border border-[#b48b8b] text-white bg-[#b48b8b] hover:bg-[#a07a7a]">Sign Up</a>
    </div>
</div>

<script>
function toggleMobileNav() {
    const menu = document.getElementById('mobileNavMenu');
    const overlay = document.getElementById('mobileNavOverlay');
    menu.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
}
</script> 

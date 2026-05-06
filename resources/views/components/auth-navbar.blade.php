<style>
    .auth-navbar {
        width: 100%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 48px;
        height: 64px;
        border-bottom: 2px solid #eee;
        position: relative;
        z-index: 100;
    }
    .auth-navbar-logo {
        height: 40px;
        display: flex;
        align-items: center;
    }
    .auth-navbar-links {
        display: flex;
        gap: 36px;
        align-items: center;
        flex: 1;
        justify-content: center;
    }
    .auth-navbar-link {
        color: #b48b8b;
        font-weight: 500;
        font-size: 18px;
        text-decoration: none;
        padding-bottom: 2px;
        border-bottom: 2px solid transparent;
        transition: border-color 0.2s, color 0.2s;
    }
    .auth-navbar-link.active, .auth-navbar-link:hover, .auth-navbar-link.clicked {
        color: #b48b8b;
        border-bottom: 2px solid #b48b8b;
        animation: underlineSlide 0.3s ease-out;
    }
    
    @keyframes underlineSlide {
        0% {
            border-bottom-width: 0;
        }
        100% {
            border-bottom-width: 2px;
        }
    }
    .auth-navbar-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .auth-navbar-btn {
        font-weight: 600;
        font-size: 16px;
        border-radius: 24px;
        padding: 8px 28px;
        border: 2px solid #b48b8b;
        background: #fff;
        color: #b48b8b;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
        text-decoration: none;
        outline: none;
    }
    .auth-navbar-btn.filled {
        background: #b48b8b;
        color: #fff;
        border: 2px solid #b48b8b;
    }
    .auth-navbar-btn.filled:hover {
        background: #a07a7a;
        border-color: #a07a7a;
    }
    .auth-navbar-btn:not(.filled):hover {
        background: #f7eaea;
    }
    @media (max-width: 900px) {
        .auth-navbar {
            flex-direction: column;
            height: auto;
            padding: 12px 8px;
        }
        .auth-navbar-links {
            gap: 18px;
            font-size: 16px;
        }
        .auth-navbar-actions {
            gap: 6px;
        }
        .auth-navbar-btn {
            padding: 8px 16px;
            font-size: 15px;
        }
    }
</style>
<nav class="auth-navbar">
    <div class="auth-navbar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
    </div>
    <div class="auth-navbar-links">
        <a href="{{ url('/') }}" class="auth-navbar-link{{ Request::is('/') ? ' active' : '' }}">Home</a>
        <a href="{{ url('/services') }}" class="auth-navbar-link{{ Request::is('services') ? ' active' : '' }}">Services</a>
        <a href="{{ url('/pricing') }}" class="auth-navbar-link{{ Request::is('pricing') ? ' active' : '' }}">Pricing</a>
        <a href="{{ url('/gallery') }}" class="auth-navbar-link{{ Request::is('gallery') ? ' active' : '' }}">Gallery</a>
        <a href="{{ url('/about') }}" class="auth-navbar-link{{ Request::is('about') ? ' active' : '' }}">About</a>
        <a href="{{ url('/contact') }}" class="auth-navbar-link{{ Request::is('contact') ? ' active' : '' }}">Contact</a>
    </div>
    <div class="auth-navbar-actions">
        <a href="{{ route('login') }}" class="auth-navbar-btn{{ Request::is('login') ? ' filled' : '' }}">Log In</a>
        <a href="{{ route('register') }}" class="auth-navbar-btn filled{{ Request::is('register') ? ' filled' : '' }}">Sign Up</a>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navigation link click animations
    document.querySelectorAll('.auth-navbar-link').forEach(link => {
        link.addEventListener('click', function(e) {
            // Add clicked class to the clicked link for animation
            this.classList.add('clicked');
            
            // Remove clicked class after animation completes
            setTimeout(() => {
                this.classList.remove('clicked');
            }, 300);
            
            // Allow normal navigation to proceed
            // No preventDefault() - let the link navigate normally
        });
    });
});
</script>
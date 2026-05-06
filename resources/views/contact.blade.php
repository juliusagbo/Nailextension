@include('components.auth-navbar')

@extends('layouts.app')

@section('content')
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { 
        background: #fff;
        scroll-behavior: smooth;
    }
    .contact-main {
        padding: 80px 0;
        background: #fff;
    }
    .contact-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .contact-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: #b48b8b;
        margin-bottom: 1rem;
    }
    .contact-subtitle {
        text-align: center;
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    .contact-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        margin-top: 3rem;
    }
    .contact-info {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 15px;
    }
    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    
    .contact-item:last-child {
        margin-bottom: 0;
    }
    .contact-icon {
        width: 50px;
        height: 50px;
        background: #b48b8b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .contact-details h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.3rem;
    }
    .contact-details p {
        color: #666;
        margin: 0;
    }
    .contact-form {
        background: #fff;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 15px;
        transition: border-color 0.3s;
        background: #fff;
        font-family: inherit;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #b48b8b;
        box-shadow: 0 0 0 3px rgba(180, 139, 139, 0.1);
    }
    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }
    .btn-submit {
        background: #b48b8b;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
        width: 100%;
    }
    .btn-submit:hover {
        background: #a07a7a;
    }
    .hours-section {
        margin-top: 3rem;
        text-align: center;
    }
    .hours-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #b48b8b;
        margin-bottom: 1rem;
    }
    .hours-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        max-width: 600px;
        margin: 0 auto;
    }
    .hours-item {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
    }
    .hours-item .day {
        font-weight: 600;
        color: #333;
    }
    .hours-item .time {
        color: #666;
        font-size: 0.9rem;
    }
    
    /* Tablet Styles */
    @media (max-width: 1024px) {
        .contact-main {
            padding: 60px 0;
        }
        
        .contact-container {
            padding: 0 30px;
        }
        
        .contact-title {
            font-size: 2.2rem;
        }
        
        .contact-subtitle {
            font-size: 1rem;
            margin-bottom: 2.5rem;
        }
        
        .contact-content {
            gap: 3rem;
            margin-top: 2.5rem;
        }
        
        .hours-section {
            margin-top: 2.5rem;
        }
    }
    
    /* Mobile Styles */
    @media (max-width: 768px) {
        .contact-main {
            padding: 40px 0;
        }
        
        .contact-container {
            padding: 0 20px;
        }
        
        .contact-title {
            font-size: 1.8rem;
            margin-bottom: 0.8rem;
        }
        
        .contact-subtitle {
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }
        
        .contact-content {
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .contact-info {
            padding: 1.5rem;
            border-radius: 12px;
        }
        
        .contact-item {
            margin-bottom: 1.2rem;
        }
        
        .contact-item:last-child {
            margin-bottom: 0;
        }
        
        .contact-icon {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
            margin-right: 0.9rem;
        }
        
        .contact-details h3 {
            font-size: 1rem;
        }
        
        .contact-details p {
            font-size: 0.9rem;
        }
        
        .contact-form {
            padding: 1.5rem;
            border-radius: 12px;
        }
        
        .form-group {
            margin-bottom: 1.2rem;
        }
        
        .form-group label {
            font-size: 14px;
            margin-bottom: 0.4rem;
        }
        
        .form-group input,
        .form-group textarea {
            padding: 11px 14px;
            font-size: 14px;
            -webkit-appearance: none;
            appearance: none;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            box-shadow: 0 0 0 3px rgba(180, 139, 139, 0.15);
        }
        
        .form-group textarea {
            min-height: 100px;
        }
        
        .btn-submit {
            padding: 12px 24px;
            font-size: 15px;
        }
        
        .hours-section {
            margin-top: 2rem;
        }
        
        .hours-title {
            font-size: 1.3rem;
        }
        
        .hours-grid {
            grid-template-columns: 1fr;
            gap: 0.8rem;
        }
        
        .hours-item {
            padding: 0.9rem;
        }
    }
    
    /* Extra Small Mobile */
    @media (max-width: 480px) {
        .contact-main {
            padding: 30px 0;
        }
        
        .contact-container {
            padding: 0 15px;
        }
        
        .contact-title {
            font-size: 1.6rem;
        }
        
        .contact-subtitle {
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .contact-content {
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .contact-info {
            padding: 1.2rem;
            border-radius: 10px;
        }
        
        .contact-item {
            margin-bottom: 1rem;
        }
        
        .contact-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
            margin-right: 0.8rem;
        }
        
        .contact-details h3 {
            font-size: 0.95rem;
        }
        
        .contact-details p {
            font-size: 0.85rem;
        }
        
        .contact-form {
            padding: 1.2rem;
            border-radius: 10px;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            font-size: 13px;
        }
        
        .form-group input,
        .form-group textarea {
            padding: 10px 12px;
            font-size: 13px;
        }
        
        .form-group textarea {
            min-height: 90px;
        }
        
        .btn-submit {
            padding: 11px 20px;
            font-size: 14px;
        }
        
        .hours-section {
            margin-top: 1.5rem;
        }
        
        .hours-title {
            font-size: 1.2rem;
        }
        
        .hours-item {
            padding: 0.8rem;
        }
        
        .hours-item .day {
            font-size: 0.9rem;
        }
        
        .hours-item .time {
            font-size: 0.8rem;
        }
    }
</style>

<div class="contact-main">
    <div class="contact-container">
        <h1 class="contact-title">Contact Us</h1>
        <p class="contact-subtitle">Get in touch with us for appointments, inquiries, or any questions</p>
        
        <div class="contact-content">
            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Address</h3>
                        <p>123 Beauty Street, City<br>Philippines</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Phone</h3>
                        <p>(555) 123-4567</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Email</h3>
                        <p>info@nailedbyvia.com</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Business Hours</h3>
                        <p>Monday - Sunday: 9AM - 8PM</p>
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <form>
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn-submit">Send Message</button>
                </form>
            </div>
        </div>
        
        <div class="hours-section">
            <h2 class="hours-title">Our Hours</h2>
            <div class="hours-grid">
                <div class="hours-item">
                    <div class="day">Monday - Friday</div>
                    <div class="time">9:00 AM - 8:00 PM</div>
                </div>
                <div class="hours-item">
                    <div class="day">Saturday</div>
                    <div class="time">9:00 AM - 6:00 PM</div>
                </div>
                <div class="hours-item">
                    <div class="day">Sunday</div>
                    <div class="time">10:00 AM - 5:00 PM</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation and submission
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-form form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();
            
            // Simple validation
            if (!name || !email || !subject || !message) {
                alert('Please fill in all required fields.');
                return false;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('.btn-submit');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Sending...';
            submitBtn.disabled = true;
            
            // Simulate form submission (replace with actual submission)
            setTimeout(() => {
                alert('Thank you for contacting us! We will get back to you soon.');
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 1000);
        });
    }
});
</script>

@endsection

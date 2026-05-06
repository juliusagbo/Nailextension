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
    .about-main {
        padding: 80px 0;
        background: #fff;
    }
    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .about-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: #b48b8b;
        margin-bottom: 1rem;
    }
    .about-subtitle {
        text-align: center;
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    .about-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        margin-top: 3rem;
    }
    .about-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }
    .about-text p {
        margin-bottom: 1.5rem;
    }
    .about-image {
        text-align: center;
    }
    .about-image img {
        max-width: 100%;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 4rem;
    }
    .feature-item {
        text-align: center;
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 15px;
        transition: transform 0.3s ease;
    }
    .feature-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
    
    @media (hover: hover) {
        .feature-item:hover {
            transform: translateY(-5px);
        }
    }
    .feature-icon {
        font-size: 3rem;
        color: #b48b8b;
        margin-bottom: 1rem;
    }
    .feature-item h3 {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }
    .feature-item p {
        color: #666;
        line-height: 1.6;
    }
    
    /* Tablet Styles */
    @media (max-width: 1024px) {
        .about-main {
            padding: 60px 0;
        }
        
        .about-container {
            padding: 0 30px;
        }
        
        .about-title {
            font-size: 2.2rem;
        }
        
        .about-subtitle {
            font-size: 1rem;
            margin-bottom: 2.5rem;
        }
        
        .about-content {
            gap: 3rem;
            margin-top: 2.5rem;
        }
        
        .about-text {
            font-size: 1rem;
        }
        
        .features-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }
        
        .feature-item {
            padding: 1.5rem;
        }
    }
    
    /* Mobile Styles */
    @media (max-width: 768px) {
        .about-main {
            padding: 40px 0;
        }
        
        .about-container {
            padding: 0 20px;
        }
        
        .about-title {
            font-size: 1.8rem;
            margin-bottom: 0.8rem;
        }
        
        .about-subtitle {
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }
        
        .about-content {
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .about-text {
            order: 2;
            font-size: 0.95rem;
            line-height: 1.7;
        }
        
        .about-image {
            order: 1;
        }
        
        .about-text p {
            margin-bottom: 1.2rem;
        }
        
        .about-image img {
            border-radius: 12px;
        }
        
        .features-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-top: 2.5rem;
        }
        
        .feature-item {
            padding: 1.5rem;
            border-radius: 12px;
        }
        
        .feature-item:hover {
            transform: none;
        }
        
        .feature-icon {
            font-size: 2.5rem;
        }
        
        .feature-item h3 {
            font-size: 1.2rem;
        }
        
        .feature-item p {
            font-size: 0.9rem;
        }
    }
    
    /* Extra Small Mobile */
    @media (max-width: 480px) {
        .about-main {
            padding: 30px 0;
        }
        
        .about-container {
            padding: 0 15px;
        }
        
        .about-title {
            font-size: 1.6rem;
        }
        
        .about-subtitle {
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .about-content {
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .about-text {
            font-size: 0.9rem;
        }
        
        .about-text p {
            margin-bottom: 1rem;
        }
        
        .about-image img {
            border-radius: 10px;
        }
        
        .features-grid {
            gap: 1.2rem;
            margin-top: 2rem;
        }
        
        .feature-item {
            padding: 1.2rem;
            border-radius: 10px;
        }
        
        .feature-icon {
            font-size: 2.2rem;
        }
        
        .feature-item h3 {
            font-size: 1.1rem;
        }
        
        .feature-item p {
            font-size: 0.85rem;
        }
    }
    
    /* Touch device optimization */
    @media (hover: none) {
        .feature-item:hover {
            transform: none;
        }
    }
</style>

<div class="about-main">
    <div class="about-container">
        <h1 class="about-title">About NAILED.BYVIA</h1>
        <p class="about-subtitle">Your premier destination for professional nail care and stunning nail art</p>
        
        <div class="about-content">
            <div class="about-text">
                <p>Welcome to NAILED.BYVIA, where we transform your nails into works of art. Our passion for nail care and dedication to excellence has made us a trusted name in the beauty industry.</p>
                
                <p>With years of experience and a commitment to using only the highest quality products, we provide a wide range of nail services including soft gel extensions, gel polish, toe extensions, and custom nail art designs.</p>
                
                <p>Our skilled technicians are trained in the latest techniques and trends, ensuring that every client leaves our salon feeling beautiful and confident. We believe that well-manicured nails are not just a luxury, but an essential part of personal grooming and self-expression.</p>
            </div>
            <div class="about-image">
                <img src="{{ asset('images/nailedbyvia.png') }}" alt="NAILED.BYVIA Salon">
            </div>
        </div>
        
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Hygiene First</h3>
                <p>All tools are sterilized and we follow strict hygiene protocols for your safety and peace of mind.</p>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3>Expert Technicians</h3>
                <p>Our certified nail technicians have years of experience and ongoing training in the latest techniques.</p>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Premium Products</h3>
                <p>We use only high-quality, non-toxic products for the best results and your nail health.</p>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Flexible Hours</h3>
                <p>Open 7 days a week with extended hours to fit your busy schedule and lifestyle.</p>
            </div>
        </div>
    </div>
</div>
@endsection

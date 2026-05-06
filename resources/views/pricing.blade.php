@include('components.auth-navbar')

@extends('layouts.app')

@section('content')
<style>
    body { 
        background: #fff;
        scroll-behavior: smooth;
    }
    .pricing-main {
        padding: 80px 0;
        background: #fff;
    }
    .pricing-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .pricing-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: #b48b8b;
        margin-bottom: 1rem;
    }
    .pricing-subtitle {
        text-align: center;
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    .pricing-card {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .pricing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    
    @media (hover: none) {
        .pricing-card:hover {
            transform: none;
        }
    }
    .pricing-header {
        background: #b48b8b;
        color: white;
        padding: 1.5rem;
        text-align: center;
    }
    .pricing-header h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }
    .pricing-body {
        padding: 1.5rem;
    }
    .pricing-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.8rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .pricing-item:last-child {
        border-bottom: none;
    }
    .service-name {
        color: #333;
        font-weight: 500;
        font-size: 0.95rem;
    }
    .service-price {
        color: #b48b8b;
        font-weight: 600;
        font-size: 1rem;
    }
    
    /* Tablet Styles */
    @media (max-width: 1024px) {
        .pricing-main {
            padding: 60px 0;
        }
        
        .pricing-container {
            padding: 0 30px;
        }
        
        .pricing-title {
            font-size: 2.2rem;
        }
        
        .pricing-subtitle {
            font-size: 1rem;
            margin-bottom: 2.5rem;
        }
        
        .pricing-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 2.5rem;
        }
        
        .pricing-card {
            max-width: 450px;
            margin: 0 auto;
            width: 100%;
        }
    }
    
    @media (max-width: 900px) {
        .pricing-grid {
            grid-template-columns: 1fr;
        }
    }
    
    /* Mobile Styles */
    @media (max-width: 768px) {
        .pricing-main {
            padding: 40px 0;
        }
        
        .pricing-container {
            padding: 0 20px;
        }
        
        .pricing-title {
            font-size: 1.8rem;
            margin-bottom: 0.8rem;
        }
        
        .pricing-subtitle {
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }
        
        .pricing-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .pricing-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            max-width: 500px;
            margin: 0 auto;
            width: 100%;
        }
        
        .pricing-header {
            padding: 1.2rem;
        }
        
        .pricing-header h3 {
            font-size: 1.1rem;
        }
        
        .pricing-body {
            padding: 1.2rem;
        }
        
        .pricing-item {
            padding: 0.7rem 0;
            flex-wrap: wrap;
        }
        
        .service-name {
            font-size: 0.9rem;
        }
        
        .service-price {
            font-size: 0.95rem;
        }
    }
    
    /* Extra Small Mobile */
    @media (max-width: 480px) {
        .pricing-main {
            padding: 30px 0;
        }
        
        .pricing-container {
            padding: 0 15px;
        }
        
        .pricing-title {
            font-size: 1.6rem;
        }
        
        .pricing-subtitle {
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .pricing-grid {
            gap: 1.2rem;
            margin-top: 1.5rem;
        }
        
        .pricing-card {
            border-radius: 12px;
        }
        
        .pricing-header {
            padding: 1rem;
        }
        
        .pricing-header h3 {
            font-size: 1rem;
        }
        
        .pricing-body {
            padding: 1rem;
        }
        
        .pricing-item {
            padding: 0.6rem 0;
        }
        
        .service-name {
            font-size: 0.85rem;
            flex: 1;
        }
        
        .service-price {
            font-size: 0.9rem;
            white-space: nowrap;
            margin-left: 10px;
        }
    }
</style>

<div class="pricing-main">
    <div class="pricing-container">
        <h1 class="pricing-title">Our Pricing</h1>
        <p class="pricing-subtitle">Transparent pricing for all our premium nail services</p>
        
        <div class="pricing-grid">
            <div class="pricing-card">
                <div class="pricing-header">
                    <h3>SOFTGEL EXTENSION</h3>
                </div>
                <div class="pricing-body">
                    <div class="pricing-item">
                        <span class="service-name">Plain (1-2 colors)</span>
                        <span class="service-price">₱700.00</span>
                    </div>
                    <div class="pricing-item">
                        <span class="service-name">Minimalist</span>
                        <span class="service-price">₱900.00</span>
                    </div>
                    <div class="pricing-item">
                        <span class="service-name">Full Set</span>
                        <span class="service-price">₱1,500.00</span>
                    </div>
                </div>
            </div>
            
            <div class="pricing-card">
                <div class="pricing-header">
                    <h3>GEL POLISH</h3>
                </div>
                <div class="pricing-body">
                    <div class="pricing-item">
                        <span class="service-name">Plain</span>
                        <span class="service-price">₱499.00</span>
                    </div>
                    <div class="pricing-item">
                        <span class="service-name">With Design</span>
                        <span class="service-price">₱699.00</span>
                    </div>
                </div>
            </div>
            
            <div class="pricing-card">
                <div class="pricing-header">
                    <h3>TOE EXTENSION</h3>
                </div>
                <div class="pricing-body">
                    <div class="pricing-item">
                        <span class="service-name">Plain</span>
                        <span class="service-price">₱800.00</span>
                    </div>
                    <div class="pricing-item">
                        <span class="service-name">With Design</span>
                        <span class="service-price">₱1,200.00</span>
                    </div>
                </div>
            </div>
            
            <div class="pricing-card">
                <div class="pricing-header">
                    <h3>REMOVAL FEE</h3>
                </div>
                <div class="pricing-body">
                    <div class="pricing-item">
                        <span class="service-name">My Work / New Set</span>
                        <span class="service-price">₱100.00</span>
                    </div>
                    <div class="pricing-item">
                        <span class="service-name">Not My Work</span>
                        <span class="service-price">₱199.00</span>
                    </div>
                </div>
            </div>
            
            <div class="pricing-card">
                <div class="pricing-header">
                    <h3>TRANSPORTATION</h3>
                </div>
                <div class="pricing-body">
                    <div class="pricing-item">
                        <span class="service-name">Cordova</span>
                        <span class="service-price">₱150.00</span>
                    </div>
                    <div class="pricing-item">
                        <span class="service-name">Lapu-Lapu</span>
                        <span class="service-price">₱250.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

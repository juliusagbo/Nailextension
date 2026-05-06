<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>NAILED.BYVIA - Premium Nail Salon</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
            <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        .header {
            background: white;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            position: relative;
        }
        
        .logo-text {
            font-size: 2.2rem;
            font-weight: 700;
            color: #D4A5A5;
            font-family: 'Georgia', serif;
            position: relative;
        }
        
        .logo-text:first-child {
            margin-right: -0.3rem;
            transform: translateY(-0.1rem);
        }
        
        .logo-text:last-child {
            transform: translateY(0.1rem);
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            gap: 2.5rem;
            margin: 0 auto;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #D4A5A5;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            padding-bottom: 0.3rem;
        }
        
        .nav-links a:hover {
            color: #B88686;
        }
        
        .nav-links a.active {
            color: #B88686;
        }
        
        .nav-links a.active::after,
        .nav-links a.clicked::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: #D4A5A5;
            border-radius: 1px;
            animation: underlineSlide 0.3s ease-out;
        }
        
        @keyframes underlineSlide {
            0% {
                width: 0;
                left: 50%;
            }
            100% {
                width: 100%;
                left: 0;
            }
        }
        
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }
        
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        
        .btn-login {
            border: 1px solid #B88686;
            color: white;
            background: #B88686;
            border-radius: 20px;
        }
        
        .btn-login:hover {
            background: #A67575;
            border-color: #A67575;
        }
        
        .btn-signup {
            background: #D4A5A5;
            color: white;
            border: 1px solid #D4A5A5;
            border-radius: 20px;
        }
        
        .btn-signup:hover {
            background: #C49595;
            border-color: #C49595;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #FF6B9D, #FF8E53);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 157, 0.3);
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid #D4A5A5;
            color: #D4A5A5;
        }
        
        .btn-outline:hover {
            background: #D4A5A5;
            color: white;
        }
        
        /* Hero Section */
        .hero {
            background: #FDF2F8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23FF6B9D" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23FF8E53" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23FF6B9D" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero-text h1 span {
            background: linear-gradient(135deg, #FF6B9D, #FF8E53);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-text p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .hero-image {
            position: relative;
        }
        
        .hero-image img {
            width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .floating-card {
            position: absolute;
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: float 3s ease-in-out infinite;
        }
        
        .floating-card.top {
            top: -20px;
            right: -20px;
            animation-delay: 0s;
        }
        
        .floating-card.bottom {
            bottom: -20px;
            left: -20px;
            animation-delay: 1.5s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        /* Services Section */
        .services {
            padding: 5rem 0;
            background: white;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #B88686;
        }
        
        .section-subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 4rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;
            max-width: 900px;
            margin: 0 auto;
        }
        
        .service-card {
            background: #FDF2F8;
            border-radius: 15px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid #FCE7F3;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(184, 134, 134, 0.15);
        }
        
        .service-icon {
            width: 70px;
            height: 70px;
            background: #B88686;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
            color: white;
        }
        
        .service-card h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .service-card p {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
        }
        
        /* Pricing Section */
        .pricing {
            padding: 5rem 0;
            background: #FDF2F8;
        }
        
        .pricing-tabs {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
        }
        
        .tab-btn {
            padding: 0.8rem 2rem;
            border-radius: 25px;
            border: 2px solid #B88686;
            background: transparent;
            color: #B88686;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .tab-btn.active {
            background: #B88686;
            color: white;
        }
        
        .tab-btn:hover {
            background: #B88686;
            color: white;
        }
        
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .pricing-card:nth-child(4),
        .pricing-card:nth-child(5) {
            grid-column: span 1.5;
        }
        
        .pricing-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .pricing-header {
            background: #B88686;
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .pricing-header h3 {
            font-size: 1.1rem;
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
            color: #B88686;
            font-weight: 600;
            font-size: 1rem;
        }
        
        /* Gallery Section */
        .gallery {
            padding: 5rem 0;
            background: white;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .gallery-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(184, 134, 134, 0.2);
        }
        
        .gallery-image {
            width: 100%;
            height: 250px;
            overflow: hidden;
        }
        
        .gallery-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover .gallery-image img {
            transform: scale(1.05);
        }
        
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
            padding: 1.5rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }
        
        .gallery-overlay h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .gallery-overlay p {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.4;
        }
        
        /* Features Section */
        .features {
            padding: 5rem 0;
            background: linear-gradient(135deg, #F8F9FA 0%, #E9ECEF 100%);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .feature-item {
            text-align: center;
            padding: 2rem;
        }
        
        .feature-icon {
            font-size: 3rem;
            color: #FF6B9D;
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
        
        /* CTA Section */
        .cta {
            padding: 5rem 0;
            background: linear-gradient(135deg, #FF6B9D, #FF8E53);
            color: white;
            text-align: center;
        }
        
        .cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .cta p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .btn-white {
            background: white;
            color: #FF6B9D;
            font-size: 1.1rem;
            padding: 1rem 2rem;
        }
        
        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }
        
        /* Footer */
        .footer {
            background: #333;
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #FF6B9D;
        }
        
        .footer-section p,
        .footer-section a {
            color: #ccc;
            text-decoration: none;
            line-height: 1.6;
        }
        
        .footer-section a:hover {
            color: #FF6B9D;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #555;
            color: #ccc;
        }
        
        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #D4A5A5;
            cursor: pointer;
            z-index: 1002;
            position: relative;
        }
        
        .mobile-nav {
            position: fixed;
            top: 0;
            left: -100%;
            width: 280px;
            height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1001;
            transition: left 0.3s ease;
            overflow-y: auto;
            padding: 80px 0 20px;
        }
        
        .mobile-nav.active {
            left: 0;
        }
        
        .mobile-nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .mobile-nav-links li {
            border-bottom: 1px solid #f0f0f0;
        }
        
        .mobile-nav-links a {
            display: block;
            padding: 15px 25px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .mobile-nav-links a:hover,
        .mobile-nav-links a.active {
            background: #FDF2F8;
            color: #D4A5A5;
        }
        
        .mobile-auth {
            padding: 20px 25px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .mobile-auth .btn {
            text-align: center;
            width: 100%;
        }
        
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        
        .mobile-overlay.active {
            display: block;
        }
        
        .mobile-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #D4A5A5;
            cursor: pointer;
        }
        
        /* Tablet Styles */
        @media (max-width: 1024px) {
            .container {
                padding: 0 30px;
            }
            
            .hero-text h1 {
                font-size: 3rem;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
            
            .pricing-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        /* Mobile Styles */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .auth-buttons {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .container {
                padding: 0 20px;
            }
            
            .header {
                padding: 0.8rem 0;
            }
            
            .logo-text {
                font-size: 1.8rem;
            }
            
            .hero {
                padding-top: 80px;
                min-height: auto;
            }
            
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 2rem;
                padding: 2rem 0;
            }
            
            .hero-text h1 {
                font-size: 2.2rem;
                line-height: 1.3;
            }
            
            .hero-text p {
                font-size: 1rem;
            }
            
            .hero-buttons {
                justify-content: center;
                gap: 0.8rem;
            }
            
            .hero-buttons .btn {
                padding: 0.7rem 1.5rem;
                font-size: 0.9rem;
            }
            
            .hero-image {
                max-width: 400px;
                margin: 0 auto;
            }
            
            .floating-card {
                padding: 1rem;
            }
            
            .floating-card.top {
                top: -10px;
                right: -10px;
            }
            
            .floating-card.bottom {
                bottom: -10px;
                left: -10px;
            }
            
            .services {
                padding: 3rem 0;
            }
            
            .services-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .service-card {
                padding: 2rem 1.5rem;
            }
            
            .section-title {
                font-size: 1.8rem;
                margin-bottom: 0.8rem;
            }
            
            .section-subtitle {
                font-size: 1rem;
                margin-bottom: 2rem;
            }
            
            .pricing {
                padding: 3rem 0;
            }
            
            .pricing-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .pricing-card:nth-child(4),
            .pricing-card:nth-child(5) {
                grid-column: span 1;
            }
            
            .pricing-tabs {
                flex-wrap: wrap;
                gap: 0.8rem;
                padding: 0 20px;
            }
            
            .tab-btn {
                padding: 0.7rem 1.5rem;
                font-size: 0.9rem;
            }
            
            .gallery {
                padding: 3rem 0;
            }
            
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            
            .gallery-image {
                height: 180px;
            }
            
            .gallery-overlay {
                transform: translateY(0);
                background: linear-gradient(transparent, rgba(0, 0, 0, 0.85));
                padding: 1rem;
            }
            
            .gallery-overlay h3 {
                font-size: 0.95rem;
            }
            
            .gallery-overlay p {
                font-size: 0.8rem;
            }
            
            .features {
                padding: 3rem 0;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .feature-item {
                padding: 1.5rem;
            }
            
            .feature-icon {
                font-size: 2.5rem;
            }
            
            .cta {
                padding: 3rem 0;
            }
            
            .cta h2 {
                font-size: 1.8rem;
            }
            
            .cta p {
                font-size: 1rem;
            }
            
            .booking {
                padding: 3rem 0;
            }
            
            .booking-form-container {
                padding: 25px;
                margin: 0 20px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .footer {
                padding: 2rem 0 1rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 0 15px;
            }
            
            .logo-text {
                font-size: 1.5rem;
            }
            
            .hero-text h1 {
                font-size: 1.8rem;
            }
            
            .section-title {
                font-size: 1.6rem;
            }
            
            .gallery-grid {
                grid-template-columns: 1fr;
            }
            
            .gallery-image {
                height: 250px;
            }
            
            .btn-book {
                padding: 12px 30px;
                font-size: 14px;
            }
        }
        
        /* Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Booking Section */
        .booking {
            padding: 80px 0;
            background: linear-gradient(135deg, #FFE5F1 0%, #FFF0F5 100%);
        }

        .booking-form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
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
            border-color: #FF6B9D;
            box-shadow: 0 0 0 3px rgba(255, 107, 157, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-actions {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btn-book {
            background: linear-gradient(135deg, #FF6B9D 0%, #FF8EAB 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
        }

        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 157, 0.4);
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .booking-form-container {
                padding: 20px;
                margin: 0 20px;
            }
        }
            </style>
    </head>
<body>
    <!-- Mobile Navigation Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>
    
    <!-- Mobile Navigation Menu -->
    <div class="mobile-nav" id="mobileNav">
        <button class="mobile-close" id="mobileClose">
            <i class="fas fa-times"></i>
        </button>
        <ul class="mobile-nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#pricing">Pricing</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="mobile-auth">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-login">Log In</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-signup">Sign Up</a>
                @endif
            @endauth
        </div>
    </div>
    
    <!-- Header -->
    <header class="header" id="header">
        <div class="container">
            <nav class="nav">
                <a href="#" class="logo">
                    <span class="logo-text">N</span>
                    <span class="logo-text">V</span>
                </a>
                
                <ul class="nav-links">
                    <li><a href="#home" class="active">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#gallery">Gallery</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                
                <div class="auth-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login">Log In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-signup">Sign Up</a>
                        @endif
                    @endauth
                </div>
                
                <button class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
                </nav>
        </div>
        </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text fade-in">
                    <h1>Transform Your <span>Nails</span> Into Art</h1>
                    <p>Experience the ultimate nail care with our premium services. From classic manicures to stunning nail art, we bring your vision to life with precision and style.</p>
                    <div class="hero-buttons">
                        <a href="#services" class="btn btn-primary">Book Now</a>
                        <a href="#services" class="btn btn-outline">View Services</a>
                    </div>
                </div>
                
                <div class="hero-image fade-in">
                    <img src="{{ asset('images/nailedbyvia.png') }}" alt="NAILED.BYVIA Nail Art">
                    
                    <div class="floating-card top">
                        <i class="fas fa-star" style="color: #FFD700; font-size: 1.5rem;"></i>
                        <p style="margin: 0.5rem 0 0 0; font-weight: 600;">5.0 Rating</p>
                        <p style="margin: 0; font-size: 0.9rem; color: #666;">500+ Reviews</p>
                    </div>
                    
                    <div class="floating-card bottom">
                        <i class="fas fa-clock" style="color: #FF6B9D; font-size: 1.2rem;"></i>
                        <p style="margin: 0.5rem 0 0 0; font-weight: 600;">Quick Service</p>
                        <p style="margin: 0; font-size: 0.9rem; color: #666;">30-60 min</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <h2 class="section-title fade-in">Our Services</h2>
            <p class="section-subtitle fade-in">We specialize in these premium nail services to enhance your beauty.</p>
            
            <div class="services-grid">
                <div class="service-card fade-in">
                    <div class="service-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3>Soft Gel Extensions</h3>
                    <p>Flexible and natural-looking gel extensions that provide strength and durability.</p>
                </div>
                
                <div class="service-card fade-in">
                    <div class="service-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3>Gel Polish</h3>
                    <p>Long-lasting gel polish with high-shine finish that won't chip for weeks.</p>
                </div>
                
                <div class="service-card fade-in">
                    <div class="service-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3>Toe Extensions</h3>
                    <p>Beautiful toe nail extensions to complete your perfect pedicure look.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing" id="pricing">
        <div class="container">
            <h2 class="section-title fade-in">Price List</h2>
            
            <div class="pricing-tabs fade-in">
                <button class="tab-btn active" data-tab="home">Home Service</button>
                <button class="tab-btn" data-tab="walkin">Walk In</button>
            </div>
            
            <div class="pricing-grid fade-in">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>SOFTGEL EXTENSION</h3>
                    </div>
                    <div class="pricing-body">
                        <div class="pricing-item">
                            <span class="service-name">Plain (1-2 colors)</span>
                            <span class="service-price">P700.00</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Minimalist</span>
                            <span class="service-price">P900.00</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Full Set</span>
                            <span class="service-price">P1500.00</span>
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
                            <span class="service-price">P499.00</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">With Design</span>
                            <span class="service-price">P699.00</span>
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
                            <span class="service-price">P800.00</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">With Design</span>
                            <span class="service-price">P1200.00</span>
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
                            <span class="service-price">P100.00</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Not My Work</span>
                            <span class="service-price">P199.00</span>
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
                            <span class="service-price">P150.00</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Lapu-Lapu</span>
                            <span class="service-price">P250.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery" id="gallery">
        <div class="container">
            <h2 class="section-title fade-in">Our Work</h2>
            <p class="section-subtitle fade-in">Browse through our gallery of stunning nail extension transformations.</p>
            
            <div class="gallery-grid fade-in">
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/ourworks/1.png') }}" alt="Gold Cat Eye Nails">
                    </div>
                    <div class="gallery-overlay">
                        <h3>Gold Cat Eye Nails</h3>
                        <p>Striking metallic gold with dark outline</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/ourworks/2.png') }}" alt="Burgundy & Nude Design Nails">
                    </div>
                    <div class="gallery-overlay">
                        <h3>Burgundy & Nude Design</h3>
                        <p>Deep burgundy with intricate white patterns</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/ourworks/3.png') }}" alt="Gold Glitter French Tip Nails">
                    </div>
                    <div class="gallery-overlay">
                        <h3>Gold Glitter French Tip</h3>
                        <p>Modern French tip with shimmering gold</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/ourworks/4.png') }}" alt="3D Floral Nails">
                    </div>
                    <div class="gallery-overlay">
                        <h3>3D Floral Design</h3>
                        <p>Vibrant 3D floral in orange and yellow</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/ourworks/5.png') }}" alt="Grey Pedicure">
                    </div>
                    <div class="gallery-overlay">
                        <h3>Grey Pedicure</h3>
                        <p>Muted light grey with clean finish</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/ourworks/6.png') }}" alt="Light Blue Pedicure">
                    </div>
                    <div class="gallery-overlay">
                        <h3>Light Blue Pedicure</h3>
                        <p>Pastel light blue or periwinkle</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/ourworks/7.png') }}" alt="French Pedicure with Rhinestones">
                    </div>
                    <div class="gallery-overlay">
                        <h3>French with Rhinestones</h3>
                        <p>Classic French with delicate rhinestones</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ asset('images/ourworks/8.png') }}" alt="White Pedicure">
                    </div>
                    <div class="gallery-overlay">
                        <h3>White Pedicure</h3>
                        <p>Clean white with well-moisturized finish</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="about">
        <div class="container">
            <h2 class="section-title fade-in">Why Choose NAILED.BYVIA?</h2>
            <p class="section-subtitle fade-in">We're committed to providing the best nail care experience</p>
            
            <div class="features-grid">
                <div class="feature-item fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Hygiene First</h3>
                    <p>All tools are sterilized and we follow strict hygiene protocols for your safety.</p>
                </div>
                
                <div class="feature-item fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Expert Technicians</h3>
                    <p>Our certified nail technicians have years of experience and ongoing training.</p>
                </div>
                
                <div class="feature-item fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Premium Products</h3>
                    <p>We use only high-quality, non-toxic products for the best results.</p>
                </div>
                
                <div class="feature-item fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Flexible Hours</h3>
                    <p>Open 7 days a week with extended hours to fit your busy schedule.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2 class="fade-in">Ready to Transform Your Nails?</h2>
            <p class="fade-in">Book your appointment today and experience the difference!</p>
            <a href="{{ route('login') }}" class="btn btn-white fade-in">Get Started Now</a>
        </div>
    </section>

    <!-- Booking Section -->
    <section class="booking" id="booking">
        <div class="container">
            <h2 class="section-title fade-in">Book Your Appointment</h2>
            <p class="section-subtitle fade-in">Ready to get beautiful nails? Book your appointment today!</p>
            
            <div class="booking-form-container fade-in">
                <form id="bookingForm" class="booking-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="service">Select Service *</label>
                            <select id="service" name="service_id" required>
                                <option value="">Choose a service</option>
                                @if(isset($services))
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-duration="{{ $service->duration_minutes }}">
                                            {{ $service->name }} - ₱{{ number_format($service->price, 2) }}
                                        </option>
                                    @endforeach
        @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="location">Service Location *</label>
                            <select id="location" name="location_type" required>
                                <option value="">Select location</option>
                                <option value="home-service">Home Service</option>
                                <option value="walk-in">Walk In</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="appointment_date">Preferred Date *</label>
                            <input type="date" id="appointment_date" name="appointment_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>
                        <div class="form-group">
                            <label for="appointment_time">Preferred Time *</label>
                            <select id="appointment_time" name="appointment_time" required>
                                <option value="">Select time</option>
                                <option value="09:00">9:00 AM</option>
                                <option value="09:30">9:30 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="10:30">10:30 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="11:30">11:30 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="12:30">12:30 PM</option>
                                <option value="13:00">1:00 PM</option>
                                <option value="13:30">1:30 PM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="14:30">2:30 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="15:30">3:30 PM</option>
                                <option value="16:00">4:00 PM</option>
                                <option value="16:30">4:30 PM</option>
                                <option value="17:00">5:00 PM</option>
                                <option value="17:30">5:30 PM</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="customer_address">Address (for home service)</label>
                            <textarea id="customer_address" name="customer_address" rows="3" placeholder="Enter your address if you selected home service"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="notes">Special Requests or Notes</label>
                            <textarea id="notes" name="notes" rows="3" placeholder="Any special requests or additional notes..."></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-book">Book Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>NAILED.BYVIA</h3>
                    <p>Your premier destination for professional nail care and stunning nail art. We're dedicated to making you feel beautiful and confident.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <p><a href="#home">Home</a></p>
                    <p><a href="#services">Services</a></p>
                    <p><a href="#pricing">Pricing</a></p>
                    <p><a href="#gallery">Gallery</a></p>
                    <p><a href="#booking">Book Now</a></p>
                    <p><a href="#about">About</a></p>
                    <p><a href="#contact">Contact</a></p>
                </div>
                
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $businessInfo['business_address'] }}</p>
                    <p><i class="fas fa-phone"></i> {{ $businessInfo['phone_number'] }}</p>
                    <p><i class="fas fa-envelope"></i> {{ $businessInfo['contact_email'] }}</p>
                </div>
                
                <div class="footer-section">
                    <h3>Hours</h3>
                    @foreach(['monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday'] as $day => $dayName)
                        @if($businessHours[$day]['closed'] == true || $businessHours[$day]['closed'] == 1 || $businessHours[$day]['closed'] === '1')
                            <p>{{ $dayName }}: Closed</p>
                        @else
                            @php
                                $openTime = date('g:i A', strtotime($businessHours[$day]['open']));
                                $closeTime = date('g:i A', strtotime($businessHours[$day]['close']));
                            @endphp
                            <p>{{ $dayName }}: {{ $openTime }} - {{ $closeTime }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 NAILED.BYVIA. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mobileNav = document.getElementById('mobileNav');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const mobileClose = document.getElementById('mobileClose');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-links a');
        
        function openMobileMenu() {
            mobileNav.classList.add('active');
            mobileOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMobileMenu() {
            mobileNav.classList.remove('active');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        mobileMenuBtn.addEventListener('click', openMobileMenu);
        mobileClose.addEventListener('click', closeMobileMenu);
        mobileOverlay.addEventListener('click', closeMobileMenu);
        
        // Close mobile menu when a link is clicked
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                closeMobileMenu();
                
                // Remove active class from all links
                mobileNavLinks.forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');
            });
        });
        
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Fade in animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Navigation link click animations
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active and clicked classes from all nav links
                document.querySelectorAll('.nav-links a').forEach(l => {
                    l.classList.remove('active', 'clicked');
                });
                
                // Add clicked class to the clicked link
                this.classList.add('clicked');
                
                // Prevent default behavior for smooth scrolling
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
                
                // Remove clicked class after animation completes
                setTimeout(() => {
                    this.classList.remove('clicked');
                    this.classList.add('active');
                }, 300);
            });
        });

        // Pricing tabs functionality
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Here you can add logic to show different pricing for different tabs
                const tabType = this.getAttribute('data-tab');
                console.log('Selected tab:', tabType);
            });
        });

        // Booking form functionality
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            // Convert date and time to datetime
            const appointmentDate = data.appointment_date + ' ' + data.appointment_time;
            data.appointment_date = appointmentDate;
            
            // Remove the separate time field
            delete data.appointment_time;
            
            // Check if user is authenticated
            @auth
                // Send to backend
                fetch('/book-appointment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.message) {
                        alert(result.message);
                        this.reset();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error booking appointment. Please try again.');
                });
            @else
                // Redirect to login if not authenticated
                alert('Please log in to book an appointment.');
                window.location.href = '{{ route("login") }}';
            @endauth
        });
    </script>
    </body>
</html>

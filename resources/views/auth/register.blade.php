@include('components.auth-navbar')

@extends('layouts.app')

@section('content')
<style>
    body { 
        background: #fff;
        scroll-behavior: smooth;
    }
    .register-main {
        display: flex;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        background: #fff;
    }
    .register-card {
        width: 100%;
        max-width: 400px;
        background: #fff;
        border-radius: 12px;
        box-shadow: none;
        border: none;
        margin: 40px 0;
        padding: 32px 24px 24px 24px;
    }
    .register-title {
        color: #b48b8b;
        font-weight: 700;
        text-align: center;
        margin-bottom: 24px;
        letter-spacing: 1px;
        font-size: 24px;
    }
    .form-label {
        color: #b48b8b;
        font-weight: 400;
        font-size: 15px;
        margin-bottom: 6px;
        display: block;
    }
    .form-control {
        border: 1.5px solid #b48b8b;
        border-radius: 8px;
        margin-bottom: 22px;
        font-size: 15px;
        padding: 10px 14px;
        background: #fff;
        color: #a07a7a;
        box-shadow: none;
        outline: none;
        transition: border-color 0.2s;
        width: 100%;
        display: block;
    }
    .form-control:focus {
        border-color: #b48b8b;
        box-shadow: none;
    }
    .btn-register {
        background: #b48b8b;
        color: #fff;
        font-weight: 700;
        letter-spacing: 1px;
        border-radius: 8px;
        width: 100%;
        font-size: 18px;
        padding: 14px 0;
        border: none;
        margin-top: 8px;
        margin-bottom: 0;
        text-transform: uppercase;
        transition: background 0.2s;
    }
    .btn-register:hover {
        background: #a07a7a;
    }
    .register-footer {
        text-align: center;
        margin-top: 18px;
        color: #b48b8b;
        font-size: 15px;
    }
    .register-footer a {
        color: #b48b8b;
        font-weight: 600;
        text-decoration: none;
    }
    .register-footer a:hover {
        text-decoration: underline;
    }
    
    /* Tablet Styles */
    @media (max-width: 1024px) {
        .register-main {
            padding: 0 30px;
        }
        
        .register-card {
            max-width: 450px;
        }
    }
    
    /* Mobile Styles */
    @media (max-width: 768px) {
        .register-main {
            padding: 0 20px;
            min-height: calc(100vh - 64px);
        }
        
        .register-card {
            max-width: 100%;
            margin: 30px 0;
            padding: 28px 20px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .register-title {
            font-size: 22px;
            margin-bottom: 20px;
        }
        
        .form-label {
            font-size: 14px;
        }
        
        .form-control {
            font-size: 16px; /* Prevents iOS zoom */
            padding: 11px 12px;
            margin-bottom: 18px;
        }
        
        .btn-register {
            font-size: 16px;
            padding: 12px 0;
        }
        
        .register-footer {
            font-size: 14px;
            margin-top: 16px;
        }
    }
    
    /* Extra Small Mobile */
    @media (max-width: 480px) {
        .register-main {
            padding: 0 15px;
        }
        
        .register-card {
            margin: 20px 0;
            padding: 24px 16px 16px;
            border-radius: 10px;
        }
        
        .register-title {
            font-size: 20px;
            margin-bottom: 18px;
        }
        
        .form-label {
            font-size: 13px;
            margin-bottom: 5px;
        }
        
        .form-control {
            font-size: 16px;
            padding: 10px 12px;
            margin-bottom: 16px;
        }
        
        .btn-register {
            font-size: 15px;
            padding: 11px 0;
        }
        
        .register-footer {
            font-size: 13px;
            margin-top: 14px;
        }
    }
</style>
<div class="register-main">
    <div class="register-card">
        <h2 class="register-title">SIGN UP</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-register">SUBMIT</button>
        </form>
        <div class="register-footer">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</div>
@endsection

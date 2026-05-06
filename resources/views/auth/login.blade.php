@include('components.auth-navbar')

@extends('layouts.app')

@section('content')
<style>
    body { 
        background: #fff;
        scroll-behavior: smooth;
    }
    .login-main {
        display: flex;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        background: #fff;
    }
    .login-card {
        width: 100%;
        max-width: 400px;
        background: #fff;
        border-radius: 12px;
        box-shadow: none;
        border: none;
        margin: 40px 0;
        padding: 32px 24px 24px 24px;
    }
    .login-title {
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
    .btn-login {
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
    .btn-login:hover {
        background: #a07a7a;
    }
    .login-footer {
        text-align: center;
        margin-top: 18px;
        color: #b48b8b;
        font-size: 15px;
    }
    .login-footer a {
        color: #b48b8b;
        font-weight: 600;
        text-decoration: none;
    }
    .login-footer a:hover {
        text-decoration: underline;
    }
    .forgot-link {
        float: right;
        font-size: 13px;
        color: #b48b8b;
        text-decoration: none;
        margin-bottom: 10px;
    }
    .forgot-link:hover {
        text-decoration: underline;
    }
    
    .error-message {
        background: #ffebee;
        color: #c62828;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
        border: 1px solid #ffcdd2;
    }
    
    .success-message {
        background: #e8f5e8;
        color: #2e7d32;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
        border: 1px solid #c8e6c9;
    }
    
    /* Tablet Styles */
    @media (max-width: 1024px) {
        .login-main {
            padding: 0 30px;
        }
        
        .login-card {
            max-width: 450px;
        }
    }
    
    /* Mobile Styles */
    @media (max-width: 768px) {
        .login-main {
            padding: 0 20px;
            min-height: calc(100vh - 64px);
        }
        
        .login-card {
            max-width: 100%;
            margin: 30px 0;
            padding: 28px 20px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .login-title {
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
        
        .forgot-link {
            font-size: 12px;
        }
        
        .btn-login {
            font-size: 16px;
            padding: 12px 0;
        }
        
        .login-footer {
            font-size: 14px;
            margin-top: 16px;
        }
        
        .error-message,
        .success-message {
            font-size: 13px;
            padding: 10px;
        }
    }
    
    /* Extra Small Mobile */
    @media (max-width: 480px) {
        .login-main {
            padding: 0 15px;
        }
        
        .login-card {
            margin: 20px 0;
            padding: 24px 16px 16px;
            border-radius: 10px;
        }
        
        .login-title {
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
        
        .forgot-link {
            font-size: 11px;
            margin-bottom: 8px;
        }
        
        .btn-login {
            font-size: 15px;
            padding: 11px 0;
        }
        
        .login-footer {
            font-size: 13px;
            margin-top: 14px;
        }
        
        .error-message,
        .success-message {
            font-size: 12px;
            padding: 10px;
        }
    }
</style>
<div class="login-main">
    <div class="login-card">
        <h2 class="login-title">LOG IN</h2>
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="error-message">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password ?</a>
            </div>
            <button type="submit" class="btn btn-login">LOG IN</button>
        </form>
        <div class="login-footer">
            Don't have an account? <a href="{{ route('register') }}"><b>Sign up</b></a>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Password Reset - NAILED.BYVIA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fefefe;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .reset-container {
            display: flex;
            width: 100%;
            max-width: 900px;
            height: 600px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .logo-section {
            flex: 1;
            background: #fefefe;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .logo-section::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 80%;
            background: #e0e0e0;
        }
        
        .logo-container {
            text-align: center;
        }
        
        .logo-letters {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
        }
        
        .letter-n {
            position: absolute;
            font-size: 80px;
            font-weight: bold;
            color: #b48b8b;
            top: 0;
            left: 0;
            z-index: 2;
        }
        
        .letter-v {
            position: absolute;
            font-size: 80px;
            font-weight: bold;
            color: #b48b8b;
            top: 10px;
            left: 15px;
            z-index: 1;
            opacity: 0.7;
        }
        
        .logo-text {
            font-size: 18px;
            font-weight: 600;
            color: #b48b8b;
            letter-spacing: 1px;
        }
        
        .reset-section {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .reset-title {
            font-size: 24px;
            font-weight: 700;
            color: #b48b8b;
            margin-bottom: 20px;
            text-align: center;
            letter-spacing: 1px;
        }
        
        .reset-subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 40px;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            color: #b48b8b;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #b48b8b;
            border-radius: 6px;
            font-size: 14px;
            color: #333;
            background: #fff;
            transition: border-color 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #a07a7a;
        }
        
        .reset-btn {
            width: 100%;
            padding: 14px;
            background: #b48b8b;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.2s;
            margin-bottom: 20px;
        }
        
        .reset-btn:hover {
            background: #a07a7a;
        }
        
        .back-to-login {
            text-align: center;
        }
        
        .back-to-login a {
            color: #b48b8b;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }
        
        .back-to-login a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .success-message {
            background: #e8f5e8;
            color: #2e7d32;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        /* Tablet Styles */
        @media (max-width: 1024px) {
            .reset-container {
                max-width: 750px;
                margin: 20px;
            }
        }
        
        /* Mobile Styles */
        @media (max-width: 768px) {
            .reset-container {
                flex-direction: column;
                height: auto;
                margin: 20px;
                max-width: 100%;
            }
            
            .logo-section {
                padding: 40px 20px;
            }
            
            .logo-section::after {
                display: none;
            }
            
            .logo-letters {
                width: 100px;
                height: 100px;
            }
            
            .letter-n,
            .letter-v {
                font-size: 70px;
            }
            
            .letter-v {
                top: 8px;
                left: 12px;
            }
            
            .logo-text {
                font-size: 16px;
            }
            
            .reset-section {
                padding: 40px 30px;
            }
            
            .reset-title {
                font-size: 22px;
                margin-bottom: 18px;
            }
            
            .reset-subtitle {
                font-size: 13px;
                margin-bottom: 30px;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-label {
                font-size: 13px;
            }
            
            .form-input {
                font-size: 16px; /* Prevents iOS zoom */
                padding: 11px 14px;
            }
            
            .reset-btn {
                padding: 12px;
                font-size: 15px;
                margin-bottom: 18px;
            }
            
            .back-to-login a {
                font-size: 13px;
            }
            
            .error-message,
            .success-message {
                font-size: 13px;
                padding: 10px;
            }
        }
        
        /* Extra Small Mobile */
        @media (max-width: 480px) {
            .reset-container {
                margin: 15px;
                border-radius: 10px;
            }
            
            .logo-section {
                padding: 30px 15px;
            }
            
            .logo-letters {
                width: 90px;
                height: 90px;
            }
            
            .letter-n,
            .letter-v {
                font-size: 60px;
            }
            
            .letter-v {
                top: 7px;
                left: 10px;
            }
            
            .logo-text {
                font-size: 15px;
            }
            
            .reset-section {
                padding: 30px 20px;
            }
            
            .reset-title {
                font-size: 20px;
                margin-bottom: 16px;
            }
            
            .reset-subtitle {
                font-size: 12px;
                margin-bottom: 25px;
            }
            
            .form-group {
                margin-bottom: 18px;
            }
            
            .form-label {
                font-size: 12px;
                margin-bottom: 6px;
            }
            
            .form-input {
                font-size: 16px;
                padding: 10px 12px;
            }
            
            .reset-btn {
                padding: 11px;
                font-size: 14px;
                margin-bottom: 16px;
            }
            
            .back-to-login a {
                font-size: 12px;
            }
            
            .error-message,
            .success-message {
                font-size: 12px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="logo-section">
            <div class="logo-container">
                <div class="logo-letters">
                    <div class="letter-n">N</div>
                    <div class="letter-v">V</div>
                </div>
                <div class="logo-text">NAILED.BYVIA</div>
            </div>
        </div>
        
        <div class="reset-section">
            <h1 class="reset-title">RESET PASSWORD</h1>
            <p class="reset-subtitle">Enter your email address and we'll send you a link to reset your password.</p>
            
            @if(session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="error-message">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus>
                </div>
                
                <button type="submit" class="reset-btn">SEND RESET LINK</button>
            </form>
            
            <div class="back-to-login">
                <a href="{{ route('admin.login') }}">← Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>

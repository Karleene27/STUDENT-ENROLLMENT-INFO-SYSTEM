<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEIS - Login</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        
        .logo-icon i {
            font-size: 1.8rem;
            color: white;
        }
        
        .login-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 0.8rem;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.2rem;
        }
        
        .form-label {
            font-weight: 600;
            font-size: 0.75rem;
            margin-bottom: 0.4rem;
            color: #1e293b;
            display: block;
        }
        
        .input-group-custom {
            position: relative;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            z-index: 1;
        }
        
        .form-control-custom {
            width: 100%;
            padding: 0.7rem 0.8rem 0.7rem 2.2rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.85rem;
            transition: all 0.3s;
        }
        
        .form-control-custom:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.7rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.85rem;
            color: white;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 1rem 0;
            font-size: 0.75rem;
        }
        
        .checkbox-container label {
            margin-left: 0.4rem;
            color: #64748b;
        }
        
        .forgot-link {
            color: #667eea;
            text-decoration: none;
            font-size: 0.75rem;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 0.75rem;
            color: #64748b;
        }
        
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .demo-credentials {
            background: #f8fafc;
            border-radius: 12px;
            padding: 0.8rem;
            margin-top: 1.2rem;
            text-align: center;
            font-size: 0.7rem;
            color: #64748b;
        }
        
        .alert-custom {
            padding: 0.7rem;
            border-radius: 12px;
            font-size: 0.75rem;
            margin-bottom: 1rem;
        }
        
        hr {
            margin: 1rem 0;
            border-color: #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        
        <h2 class="login-title">Welcome Back</h2>
        <p class="login-subtitle">Sign in to your account</p>
        
        @if($errors->any())
            <div class="alert alert-danger alert-custom">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif
        
        @if(session('success'))
            <div class="alert alert-success alert-custom">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="input-group-custom">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control-custom" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-group-custom">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control-custom" placeholder="Enter your password" required>
                </div>
            </div>
            
            <div class="checkbox-container">
                <div>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Sign In
            </button>
        </form>
        
        <div class="register-link">
            Not yet enrolled? <a href="{{ route('register') }}">Enroll Now</a>
        </div>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
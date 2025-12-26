<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Election System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            border-top: 5px solid #1e40af;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1e40af, #3b82f6, #60a5fa);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e0e7ff 0%, #dbeafe 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 4px solid #f0f4f8;
        }

        .login-logo i {
            font-size: 36px;
            color: #1e40af;
        }

        .login-title {
            color: #1e40af;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #64748b;
            font-size: 16px;
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: #f8fafc;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 14px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid #cbd5e1;
            cursor: pointer;
        }

        .remember-me label {
            color: #64748b;
            font-size: 14px;
            cursor: pointer;
        }

        .forgot-password {
            color: #3b82f6;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .login-button:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 64, 175, 0.2);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .login-footer a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 16px;
            border-radius: 10px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-left: 4px solid #059669;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .alert i {
            font-size: 20px;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 24px;
                margin: 16px;
            }
            
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
        }
        .login-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            background: none;
            border: none;
            width: 100%;
            height: auto;
        }
        img {
            width: 375px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Login Header -->
        <div class="nav-brand">
            <div class="login-logo">
                <img src="{{ asset('Logowithtext.png') }}" alt="CICSelect">
            </div>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input 
                    id="email" 
                    class="form-input @error('email') error @enderror" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="email"
                    placeholder="Enter your email address"
                >
                @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    id="password" 
                    class="form-input @error('password') error @enderror"
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    placeholder="Enter your password"
                >
                @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="remember-forgot">
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>
                
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="login-button">
                <i class="fas fa-sign-in-alt"></i>
                Sign In to Dashboard
            </button>

            <!-- Optional: Registration Link -->
            <div class="login-footer">
                Don't have an account? 
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    <script>
        // Add animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.login-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);

            // Add focus effects
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        });
    </script>
</body>
</html>
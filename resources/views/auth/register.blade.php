<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Election System</title>
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

        .register-container {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            border-top: 5px solid #1e40af;
            position: relative;
            overflow: hidden;
        }

        .register-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1e40af, #3b82f6, #60a5fa);
        }

        .register-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            background: none;
            border: none;
            width: 100%;
            height: auto;
        }
        
        .register-logo img {
            width: 375px;
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
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
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

        .register-button {
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

        .register-button:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 64, 175, 0.2);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .register-footer {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .register-footer a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        .login-link {
            color: #3b82f6;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .login-link:hover {
            color: #1d4ed8;
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
            .register-container {
                padding: 30px 24px;
                margin: 16px;
            }
            
            .register-logo img {
                width: 280px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Register Header -->
        <div class="nav-brand">
            <div class="register-logo">
                <img src="{{ asset('Logowithtext.png') }}" alt="CICSelect">
            </div>
        </div>

        <!-- Register Form - Maintaining the original Blade structure -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input 
                    id="name" 
                    class="form-input @error('name') error @enderror" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus 
                    autocomplete="name"
                    placeholder="Enter your full name"
                />
                @error('name')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

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
                    autocomplete="email"
                    placeholder="Enter your email address"
                />
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
                    autocomplete="new-password"
                    placeholder="Create a secure password"
                />
                @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input 
                    id="password_confirmation" 
                    class="form-input"
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="Confirm your password"
                />
                @error('password_confirmation')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit" class="register-button">
                <i class="fas fa-user-plus"></i>
                Create Account
            </button>

            <!-- Login Link -->
            <div class="register-footer">
                Already have an account? 
                <a class="login-link" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <script>
        // Add animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.register-container');
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
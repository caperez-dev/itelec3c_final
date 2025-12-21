<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast Your Vote - Premium Election System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap');
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes glow-pulse {
            0%, 100% { box-shadow: 0 0 20px rgba(34, 211, 238, 0.5), inset 0 0 20px rgba(34, 211, 238, 0.1); }
            50% { box-shadow: 0 0 40px rgba(34, 211, 238, 0.8), inset 0 0 30px rgba(34, 211, 238, 0.2); }
        }
        
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(-45deg, #0f172a 0%, #1a0f2e 25%, #0d1f3c 50%, #1e1b4b 75%, #0f172a 100%);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(34, 211, 238, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        .login-wrapper {
            width: 100%;
            max-width: 32rem;
            position: relative;
            z-index: 10;
            animation: slide-up 0.8s ease-out;
        }

        .login-card {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.92) 0%, rgba(30, 58, 138, 0.92) 100%);
            border: 1.5px solid rgba(34, 211, 238, 0.4);
            border-radius: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6),
                        0 0 80px rgba(34, 211, 238, 0.15);
            padding: 3.5rem 2.5rem;
            backdrop-filter: blur(40px);
            position: relative;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.320, 1);
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(34, 211, 238, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        
        .login-card::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        
        .login-card:hover {
            border-color: rgba(34, 211, 238, 0.7);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6),
                        0 0 100px rgba(34, 211, 238, 0.25);
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            z-index: 10;
        }

        .logo-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 5rem;
            height: 5rem;
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 50%, #7c3aed 100%);
            border-radius: 1.75rem;
            box-shadow: 0 25px 50px -12px rgba(6, 182, 212, 0.6),
                        inset 0 0 30px rgba(255, 255, 255, 0.15);
            margin-bottom: 2rem;
            animation: float 3s ease-in-out infinite;
            position: relative;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo-circle:hover {
            animation: glow-pulse 2s ease-in-out infinite;
        }

        .logo-circle svg {
            width: 2.5rem;
            height: 2.5rem;
            color: #fff;
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.3));
        }

        .login-title {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(to right, #e0f2fe, #cffafe, #a5f3fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
            letter-spacing: -1px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .login-subtitle {
            color: rgba(165, 243, 252, 0.8);
            font-size: 0.95rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* Session Status */
        .session-status {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.2) 0%, rgba(16, 185, 129, 0.15) 100%);
            border: 1.5px solid rgba(16, 185, 129, 0.6);
            border-radius: 1.25rem;
            padding: 1.25rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            backdrop-filter: blur(20px);
            position: relative;
            z-index: 10;
            animation: slide-up 0.8s ease-out 0.2s both;
        }

        .session-status-icon {
            flex-shrink: 0;
            color: rgba(16, 185, 129, 0.8);
            margin-top: 0.125rem;
        }

        .session-status-icon svg {
            width: 1.5rem;
            height: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }

        .session-status-text {
            color: #a7f3d0;
            font-size: 0.9rem;
            font-weight: 500;
            line-height: 1.5;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.75rem;
            animation: slide-up 0.8s ease-out both;
            position: relative;
            z-index: 10;
        }
        
        .form-group:nth-child(2) { animation-delay: 0.1s; }
        .form-group:nth-child(3) { animation-delay: 0.2s; }
        .form-group:nth-child(4) { animation-delay: 0.3s; }

        .form-label {
            display: block;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: rgba(226, 232, 240, 0.95);
            font-size: 0.9rem;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 2px solid rgba(34, 211, 238, 0.3);
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            color: #e0f2fe;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.2),
                        0 4px 12px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(20px);
            font-weight: 500;
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(34, 211, 238, 0.8);
            background: rgba(15, 23, 42, 0.8);
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.2),
                        0 0 0 3px rgba(6, 182, 212, 0.2),
                        0 10px 30px rgba(6, 182, 212, 0.1);
            transform: translateY(-2px);
        }

        .form-input::placeholder {
            color: rgba(148, 163, 184, 0.5);
            font-weight: 400;
        }

        /* Form Errors */
        .form-error {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.2) 0%, rgba(239, 68, 68, 0.1) 100%);
            border: 1.5px solid rgba(220, 38, 38, 0.5);
            border-radius: 0.875rem;
            padding: 1rem;
            margin-top: 0.75rem;
            color: #fca5a5;
            font-size: 0.85rem;
            font-weight: 500;
            backdrop-filter: blur(20px);
            animation: slide-up 0.4s ease-out;
        }

        .form-error-list {
            list-style: none;
        }

        .form-error-list li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-error-list li:before {
            content: '●';
            color: #fca5a5;
            font-weight: 700;
            margin-right: 0.25rem;
        }

        /* Submit Button */
        .submit-button {
            width: 100%;
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 50%, #7c3aed 100%);
            color: #fff;
            border: none;
            padding: 1.1rem 1.5rem;
            border-radius: 1rem;
            font-weight: 800;
            font-size: 1.025rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            box-shadow: 0 15px 35px rgba(6, 182, 212, 0.3),
                        0 0 0 1px rgba(34, 211, 238, 0.2) inset;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            position: relative;
            z-index: 10;
            margin-top: 0.5rem;
            letter-spacing: 0.5px;
            animation: slide-up 0.8s ease-out 0.4s both;
            font-family: 'Space Grotesk', sans-serif;
        }
        
        .submit-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            border-radius: 1rem;
            opacity: 0;
            animation: shimmer 2s infinite;
        }

        .submit-button:hover:not(:disabled) {
            background: linear-gradient(135deg, #06a6d4 0%, #1d4ed8 50%, #6d28d9 100%);
            box-shadow: 0 20px 50px rgba(6, 182, 212, 0.5),
                        0 0 0 1px rgba(34, 211, 238, 0.3) inset;
            transform: translateY(-4px);
        }

        .submit-button:active:not(:disabled) {
            transform: translateY(-2px);
        }

        .submit-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .submit-button svg {
            width: 1.35rem;
            height: 1.35rem;
            filter: drop-shadow(0 0 4px rgba(255, 255, 255, 0.2));
        }

        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
            border-left: 4px solid rgba(34, 211, 238, 0.8);
            border-radius: 1.25rem;
            padding: 1.5rem;
            margin-top: 2.5rem;
            position: relative;
            z-index: 10;
            backdrop-filter: blur(20px);
            animation: slide-up 0.8s ease-out 0.5s both;
            border: 1.5px solid rgba(34, 211, 238, 0.3);
            border-left: 4px solid rgba(34, 211, 238, 0.8);
        }

        .info-box-title {
            font-weight: 800;
            color: rgba(165, 243, 252, 0.95);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .info-box-text {
            color: rgba(165, 243, 252, 0.7);
            font-size: 0.85rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .info-box-list {
            margin: 0;
            padding-left: 0;
            list-style: none;
        }

        .info-box-list li {
            color: rgba(165, 243, 252, 0.6);
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }
        
        .info-box-list li:before {
            content: '✓';
            color: rgba(16, 185, 129, 0.8);
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .login-card {
                padding: 2.5rem 1.75rem;
                border-radius: 2rem;
            }

            .login-title {
                font-size: 2rem;
            }
            
            .logo-circle {
                width: 4rem;
                height: 4rem;
            }
            
            .logo-circle svg {
                width: 2rem;
                height: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="logo-circle">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <h1 class="login-title">Cast Your Vote</h1>
                <p class="login-subtitle">Secure voter authentication</p>
            </div>

            <!-- Session Status -->
            @if(session('status'))
                <div class="session-status">
                    <div class="session-status-icon">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <p class="session-status-text">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('voter.authenticate') }}">
                @csrf

                <!-- Full Name Field -->
                <div class="form-group">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input 
                        id="fullname" 
                        type="text" 
                        name="fullname" 
                        class="form-input" 
                        value="{{ old('fullname') }}"
                        placeholder="Enter your full name"
                        required 
                        autofocus 
                        autocomplete="name"
                    />
                    @if($errors->has('fullname'))
                        <div class="form-error">
                            <ul class="form-error-list">
                                @foreach($errors->get('fullname') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Voter Key Field -->
                <div class="form-group">
                    <label for="voter_key" class="form-label">Voter Key</label>
                    <input 
                        id="voter_key" 
                        type="text" 
                        name="voter_key" 
                        class="form-input"
                        placeholder="Enter your voter key"
                        required 
                        autocomplete="off"
                    />
                    @if($errors->has('voter_key'))
                        <div class="form-error">
                            <ul class="form-error-list">
                                @foreach($errors->get('voter_key') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Login to Vote
                </button>
            </form>

            <!-- Info Box -->
            <div class="info-box">
                <p class="info-box-title">Need Help?</p>
                <p class="info-box-text">If you don't have your voter key or need assistance, please contact the election administrator.</p>
                <ul class="info-box-list">
                    <li>✓ Keep your voter key confidential</li>
                    <li>✓ Your vote is completely anonymous</li>
                    <li>✓ All data is securely encrypted</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>

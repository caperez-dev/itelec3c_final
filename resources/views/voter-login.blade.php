@php
use App\Models\Election;
$election = Election::find(1);
$status = $election ? strtolower($election->status) : 'pending';
// Redirect voters to welcome when election is not open for voting
if (in_array($status, ['pending', 'ended', 'on hold'])) {
    redirect()->route('welcome')->send();
    exit;
}
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Council Election - Voter Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Source+Sans+Pro:wght@400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            color: #334155;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: auto;
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

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            border-radius: 12px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .login-logo svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .login-title {
            font-size: 1.75rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
            font-weight: 700;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .login-subtitle {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* Session Status */
        .session-status {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .session-status-icon {
            flex-shrink: 0;
            color: #16a34a;
            margin-top: 0.125rem;
        }

        .session-status-icon svg {
            width: 18px;
            height: 18px;
        }

        .session-status-text {
            color: #166534;
            font-size: 0.9rem;
            font-weight: 500;
            line-height: 1.5;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #475569;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 0.875rem 1rem;
            color: #1e293b;
            font-size: 1rem;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        /* Form Errors */
        .form-error {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 0.75rem;
            margin-top: 0.5rem;
            color: #dc2626;
            font-size: 0.85rem;
        }

        .form-error-list {
            list-style: none;
        }

        .form-error-list li {
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-error-list li:before {
            content: '•';
            color: #dc2626;
            font-weight: 700;
        }

        /* Submit Button */
        .submit-button {
            width: 100%;
            background: #2563eb;
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            font-family: 'Inter', sans-serif;
        }

        .submit-button:hover:not(:disabled) {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .submit-button:active:not(:disabled) {
            transform: translateY(0);
        }

        .submit-button:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }

        .submit-button svg {
            width: 18px;
            height: 18px;
        }

        /* Help Section */
        .help-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .help-title {
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .help-text {
            color: #64748b;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .help-list {
            list-style: none;
        }

        .help-list li {
            color: #475569;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-weight: 500;
        }
        
        .help-list li:before {
            content: '✓';
            color: #2563eb;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        /* Footer Note */
        .footer-note {
            text-align: center;
            margin-top: 1.5rem;
            color: #94a3b8;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
                border-radius: 12px;
            }

            .login-title {
                font-size: 1.5rem;
            }
            
            .login-logo {
                width: 56px;
                height: 56px;
                margin-bottom: 1rem;
            }
            
            .login-logo svg {
                width: 28px;
                height: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-logo">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h1 class="login-title">Voter Login</h1>
                <p class="login-subtitle">Student Council Election System</p>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Login to Vote
                </button>
            </form>

            <!-- Help Section -->
            <div class="help-section">
                <p class="help-title">Need Help?</p>
                <p class="help-text">If you don't have your voter key or need assistance, please contact the student council election committee.</p>
                <ul class="help-list">
                    <li>Keep your voter key confidential</li>
                    <li>Your vote is completely anonymous</li>
                    <li>Voting is open during election hours only</li>
                </ul>
            </div>

            <!-- Footer Note -->
            <div class="footer-note">
                <p>By logging in, you agree to participate in the student council election process.</p>
            </div>
        </div>
    </div>
</body>
</html>
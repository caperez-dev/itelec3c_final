<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Council Election System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            color: #334155;
            line-height: 1.6;
        }

        /* Navigation */
        .election-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-logo {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-logo svg {
            width: 24px;
            height: 24px;
            color: #1e3a8a;
        }

        .nav-title h1 {
            font-size: 1.25rem;
            font-weight: 700;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .nav-title p {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .nav-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            background: rgba(255, 255, 255, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
        }

        /* Main Content */
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 3rem 1rem;
            margin-bottom: 3rem;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #eff6ff;
            color: #2563eb;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            border: 1px solid #dbeafe;
        }

        .hero-badge svg {
            width: 16px;
            height: 16px;
        }

        .hero-title {
            font-size: 2.5rem;
            color: #1e293b;
            margin-bottom: 1rem;
            font-weight: 700;
            font-family: 'Source Sans Pro', sans-serif;
            line-height: 1.2;
        }

        .hero-title span {
            color: #2563eb;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .hero-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: #2563eb;
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid #1d4ed8;
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
        }

        .hero-button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.3);
        }

        .hero-button svg {
            width: 20px;
            height: 20px;
        }

        /* Features Grid */
        .features-section {
            margin-bottom: 4rem;
        }

        .section-title {
            text-align: center;
            font-size: 1.75rem;
            color: #1e293b;
            margin-bottom: 2rem;
            font-weight: 700;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .features-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            text-align: center;
            transition: all 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-color: #cbd5e1;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .feature-icon.secure {
            background: #d1fae5;
            color: #059669;
        }

        .feature-icon.real-time {
            background: #dbeafe;
            color: #2563eb;
        }

        .feature-icon.access {
            background: #f3e8ff;
            color: #7c3aed;
        }

        .feature-icon svg {
            width: 28px;
            height: 28px;
        }

        .feature-title {
            font-size: 1.125rem;
            color: #1e293b;
            margin-bottom: 0.75rem;
            font-weight: 600;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .feature-description {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Election Info Card */
        .election-info {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            text-align: center;
            margin-bottom: 4rem;
        }

        .election-info-title {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 1rem;
            font-weight: 700;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .election-info-subtitle {
            color: #64748b;
            font-size: 1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            max-width: 400px;
            margin: 0 auto;
        }

        @media (min-width: 640px) {
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .info-box {
            background: #f8fafc;
            border-radius: 10px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .info-box:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .info-date {
            font-size: 1.5rem;
            color: #2563eb;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .info-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
        }

        /* How to Vote Section */
        .how-to-vote {
            background: #f1f5f9;
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 4rem;
            border: 1px solid #e2e8f0;
        }

        .how-to-vote .section-title {
            text-align: left;
            margin-bottom: 1.5rem;
        }

        .steps-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .step-number {
            background: #2563eb;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .step-content h4 {
            font-size: 1rem;
            color: #1e293b;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .step-content p {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Footer */
        footer {
            background: #1e293b;
            color: white;
            padding: 3rem 0;
            margin-top: 4rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            text-align: center;
        }

        .footer-logo {
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .footer-logo svg {
            width: 24px;
            height: 24px;
            color: #1e293b;
        }

        .footer-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .footer-subtitle {
            font-size: 0.875rem;
            opacity: 0.8;
            margin-bottom: 1.5rem;
        }

        .footer-text {
            color: #cbd5e1;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .footer-copyright {
            font-size: 0.875rem;
            color: #94a3b8;
            margin-top: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .nav-status {
                display: none;
            }

            .election-info, .how-to-vote {
                padding: 1.5rem;
            }

            .feature-card, .info-box, .step-item {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.75rem;
            }

            .hero-button {
                width: 100%;
                justify-content: center;
            }

            .nav-container {
                flex-direction: column;
                gap: 0.75rem;
                text-align: center;
            }

            .nav-title p {
                display: none;
            }
        }
    </style>
</head>
<body>
    @php
        // Load election status (id = 1)
        $election = \App\Models\Election::find(1);
        $electionStatus = $election ? $election->status : 'Pending';
        $status = strtolower(trim($electionStatus));
        $statusColor = $status === 'pending' ? '#f59e0b' : (($status === 'ongoing' || $status === 'active') ? '#10b981' : '#6b7280');
    @endphp
    <!-- Navigation -->
    <header class="election-header">
        <div class="nav-container">
            <div class="nav-brand">
                <div class="nav-logo">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div class="nav-title">
                    <h1>Election System</h1>
                    <p>Your Voice Matters</p>
                </div>
            </div>
            <div class="nav-status">
                <div class="status-dot" style="background: {{ $statusColor }};"></div>
                <span>Election Status: {{ ucfirst($electionStatus) }}</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-badge">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>Secure • Transparent • Fair</span>
            </div>
            
            <h1 class="hero-title">
                Shape <span>Your Future</span>
            </h1>
            
            <p class="hero-subtitle">
                Participate in the democratic process. Your vote is your voice in building a better student community
            </p>
            
            @if($status === 'pending')
                <div style="max-width:820px;margin:0.75rem auto 1rem;padding:0.75rem 1rem;border-radius:8px;background:#fffbeb;color:#92400e;border:1px solid #f59e0b;text-align:center;">
                    <strong>Notice:</strong> The election has not started yet — voting is not available until the election is active.
                </div>
            @elseif($status === 'on hold')
                <div style="max-width:820px;margin:0.75rem auto 1rem;padding:0.75rem 1rem;border-radius:8px;background:#fff7ed;color:#92400e;border:1px solid #f59e0b;text-align:center;">
                    <strong>Notice:</strong> The election is currently on hold — voting is temporarily disabled until the election is resumed.
                </div>
            @elseif($status === 'ended')
                <div style="max-width:820px;margin:0.75rem auto 1rem;padding:0.75rem 1rem;border-radius:8px;background:#fef2f2;color:#991b1b;border:1px solid #f87171;text-align:center;">
                    <strong>Notice:</strong> The election has ended — voting is no longer available.
                </div>
            @endif

            @if(in_array($status, ['ongoing', 'active']))
                <a href="{{ route('voter.login') }}" class="hero-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    Cast Your Vote
                </a>
            @endif
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <h2 class="section-title">Why Vote With Us</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon secure">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Secure Voting</h3>
                    <p class="feature-description">
                        Your vote is confidential and secure. We use encrypted systems to protect your privacy.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon real-time">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Transparent Process</h3>
                    <p class="feature-description">
                        Clear procedures and verifiable results ensure a fair election process for everyone.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon access">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Easy Access</h3>
                    <p class="feature-description">
                        Accessible platform that works on any device. Vote anytime during election hours.
                    </p>
                </div>
            </div>
        </section>

        <!-- Election Info -->
        <section class="election-info">
            <h2 class="election-info-title">Election Details</h2>
            <p class="election-info-subtitle">
                Make sure you're ready to participate. Check the dates and times for this year's student council election.
            </p>
            <div class="info-grid">
                <div class="info-box">
                    <div class="info-date">{{ now()->format('F j, Y') }}</div>
                    <div class="info-label">Election Day</div>
                </div>
                <div class="info-box">
                    <div class="info-date">8:00 AM - 5:00 PM</div>
                    <div class="info-label">Voting Hours</div>
                </div>
            </div>
        </section>

        <!-- How to Vote -->
        <section class="how-to-vote">
            <h2 class="section-title">How to Vote</h2>
            <div class="steps-list">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Login to Your Account</h4>
                        <p>Use your student credentials to access the voting platform.</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Review the Candidates</h4>
                        <p>Learn about each candidate's platform and qualifications.</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Cast Your Vote</h4>
                        <p>Select your preferred candidate for each position.</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h4>Submit & Confirm</h4>
                        <p>Review your selections and submit your vote. Remember, you cannot change your vote after submission.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-logo">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <h3 class="footer-title">Student Council Election</h3>
            <p class="footer-subtitle">Your Voice, Your Choice</p>
            <p class="footer-text">
                Empowering students through democratic participation in campus governance.
            </p>
            <p class="footer-copyright">
                © {{ date('Y') }} Student Council Election System. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
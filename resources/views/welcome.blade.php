<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CICSelect - Student Council Election</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            color: #1e293b;
            line-height: 1.7;
            overflow-x: hidden;
        }

        /* Navigation */
        .election-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            color: white;
            padding: 1.25rem 0;
            box-shadow: 0 4px 20px rgba(30, 64, 175, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover {
            transform: scale(1.05);
        }

        .nav-logo img {
            height: 90px;
            width: auto;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.1));
        }

        .nav-title h1 {
            font-size: 1.25rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.025em;
        }

        .nav-title p {
            font-size: 0.75rem;
            opacity: 0.95;
        }

        .nav-status {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            font-size: 0.875rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.625rem 1.25rem;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .nav-status:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        .status-dot {
            width: 10px;
            height: 10px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        /* Main Content */
        main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 2rem;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 2.5rem 1.5rem;
            margin-bottom: 3rem;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
            pointer-events: none;
            z-index: -1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #1e40af;
            padding: 0.625rem 1.5rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 2rem;
            border: 1px solid #bfdbfe;
            box-shadow: 0 2px 12px rgba(59, 130, 246, 0.15);
            animation: fadeInDown 0.6s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-badge svg {
            width: 16px;
            height: 16px;
        }

        .hero-title {
            font-size: 3.5rem;
            color: #0f172a;
            margin-bottom: 1.5rem;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
            line-height: 1.1;
            letter-spacing: -0.03em;
            animation: fadeInUp 0.8s ease-out;
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

        .hero-title span {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #475569;
            max-width: 650px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
            font-weight: 400;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .hero-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: white;
            padding: 1.125rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.0625rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
            position: relative;
            overflow: hidden;
        }

        .hero-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .hero-button:hover::before {
            left: 100%;
        }

        .hero-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.4);
        }

        .hero-button:active {
            transform: translateY(-1px);
        }

        .hero-button svg {
            width: 20px;
            height: 20px;
        }

        /* Features Grid */
        .features-section {
            margin-bottom: 3.5rem;
        }

        .section-title {
            text-align: center;
            font-size: 2.25rem;
            color: #0f172a;
            margin-bottom: 2.5rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.025em;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .features-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(226, 232, 240, 0.8);
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, currentColor, transparent);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(203, 213, 225, 0.8);
        }

        .feature-icon {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
            transition: transform 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-icon.secure {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #059669;
        }

        .feature-icon.real-time {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #2563eb;
        }

        .feature-icon.access {
            background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
            color: #7c3aed;
        }

        .feature-icon svg {
            width: 32px;
            height: 32px;
        }

        .feature-title {
            font-size: 1.25rem;
            color: #0f172a;
            margin-bottom: 1rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }

        .feature-description {
            color: #64748b;
            font-size: 0.9375rem;
            line-height: 1.65;
        }

        /* Election Info Card */
        .election-info {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            text-align: center;
            margin-bottom: 3.5rem;
            position: relative;
            overflow: hidden;
        }

        .election-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #3b82f6);
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .election-info-title {
            font-size: 2rem;
            color: #0f172a;
            margin-bottom: 1.25rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.025em;
        }

        .election-info-subtitle {
            color: #64748b;
            font-size: 1.0625rem;
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            max-width: 500px;
            margin: 0 auto;
        }

        @media (min-width: 640px) {
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
        }

        .info-box {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            padding: 2rem 1.5rem;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
        }

        .info-box::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            padding: 2px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .info-box:hover {
            transform: translateY(-4px);
            border-color: transparent;
        }

        .info-box:hover::after {
            opacity: 1;
        }

        .info-date {
            font-size: 1.75rem;
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            margin-bottom: 0.625rem;
            font-family: 'Poppins', sans-serif;
        }

        .info-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* How to Vote Section */
        .how-to-vote {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            margin-bottom: 3rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .how-to-vote .section-title {
            text-align: left;
            margin-bottom: 2rem;
        }

        .steps-list {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            padding: 1.5rem;
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .step-item:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .step-number {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: white;
            min-width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            font-family: 'Poppins', sans-serif;
        }

        .step-content h4 {
            font-size: 1.0625rem;
            color: #0f172a;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }

        .step-content p {
            color: #64748b;
            font-size: 0.9375rem;
            line-height: 1.65;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
            position: relative;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }

        .footer-text {
            color: #cbd5e1;
            font-size: 0.9375rem;
            margin: 0;
        }

        /* Notice Styles */
        .notice-box {
            max-width: 900px;
            margin: 1rem auto 1.5rem;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            text-align: center;
            font-size: 0.9375rem;
            line-height: 1.6;
            border: 1px solid;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notice-box.pending {
            background: #fffbeb;
            color: #92400e;
            border-color: #fbbf24;
        }

        .notice-box.on-hold {
            background: #fff7ed;
            color: #92400e;
            border-color: #fb923c;
        }

        .notice-box.ended {
            background: #fef2f2;
            color: #991b1b;
            border-color: #f87171;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 1.875rem;
            }

            .nav-status {
                display: none;
            }

            .election-info, .how-to-vote {
                padding: 2rem 1.5rem;
            }

            .feature-card, .info-box, .step-item {
                padding: 1.75rem 1.5rem;
            }

            main {
                padding: 2rem 1.5rem;
            }

            .hero-section {
                padding: 2rem 1rem;
                margin-bottom: 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .hero-button {
                width: 100%;
                justify-content: center;
                padding: 1rem 2rem;
            }

            .nav-container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .nav-logo img {
                height: 70px;
            }

            .nav-title p {
                display: none;
            }

            .how-to-vote .section-title {
                text-align: center;
            }

            .step-item {
                flex-direction: column;
                align-items: center;
                text-align: center;
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
                    <img src="{{ asset('Logowithtext.png') }}" alt="CICSelect">
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
                <div class="notice-box pending">
                    <strong>Notice:</strong> The election has not started yet — voting is not available until the election is active.
                </div>
            @elseif($status === 'on hold')
                <div class="notice-box on-hold">
                    <strong>Notice:</strong> The election is currently on hold — voting is temporarily disabled until the election is resumed.
                </div>
            @elseif($status === 'ended')
                <div class="notice-box ended">
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

            <div style="margin-top:16px;">
                <a href="{{ url('/login') }}" class="hero-button" style="background: linear-gradient(135deg, #374151 0%, #111827 100%);">
                    <i class="fa fa-user-shield" style="margin-right:8px; color: white;"></i>
                    Admin Login
                </a>
            </div>
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
            <p class="footer-text">
                © {{ date('Y') }} CICSelect. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
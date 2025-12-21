<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Election System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #0f0f23 50%, #1a1a3e 75%, #0f172a 100%);
            background-attachment: fixed;
            min-height: 100vh;
            color: #fff;
            position: relative;
            overflow-x: hidden;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        @keyframes glow-pulse {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(6, 182, 212, 0.3), 0 0 40px rgba(6, 182, 212, 0.15);
            }
            50% { 
                box-shadow: 0 0 30px rgba(6, 182, 212, 0.5), 0 0 60px rgba(6, 182, 212, 0.25);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes slide-up {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        @keyframes hover-lift {
            from { transform: translateY(0); }
            to { transform: translateY(-6px); }
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Navigation */
        nav {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(6, 182, 212, 0.1);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        .nav-container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 5rem;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-logo {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 100%);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.4), 0 8px 16px rgba(6, 182, 212, 0.2);
            position: relative;
            animation: glow-pulse 3s ease-in-out infinite;
        }

        .nav-logo svg {
            width: 1.75rem;
            height: 1.75rem;
            color: #fff;
        }

        .nav-pulse {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            width: 1rem;
            height: 1rem;
            background: #10b981;
            border-radius: 50%;
            border: 2px solid #fff;
            animation: pulse 2s infinite;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
        }

        .nav-title h1 {
            font-size: 1.375rem;
            font-weight: 800;
            background: linear-gradient(to right, #06b6d4, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-family: 'Space Grotesk', sans-serif;
        }

        .nav-title p {
            font-size: 0.75rem;
            color: #94a3b8;
            letter-spacing: 0.05em;
        }

        .nav-status {
            display: none;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #cbd5e1;
        }

        .nav-status-dot {
            width: 0.5rem;
            height: 0.5rem;
            background: #10b981;
            border-radius: 50%;
            animation: pulse 2s infinite;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
        }

        @media (min-width: 768px) {
            .nav-status {
                display: flex;
            }
        }

        /* Main Section */
        main {
            position: relative;
            overflow: hidden;
        }

        .bg-pattern {
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(6, 182, 212, 0.08), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(37, 99, 235, 0.08), transparent 50%);
            pointer-events: none;
        }

        .bg-blob-1 {
            position: absolute;
            top: 5rem;
            right: 5rem;
            width: 24rem;
            height: 24rem;
            background: rgba(6, 182, 212, 0.15);
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            animation: float 6s ease-in-out infinite;
        }

        .bg-blob-2 {
            position: absolute;
            bottom: 5rem;
            left: 5rem;
            width: 20rem;
            height: 20rem;
            background: rgba(168, 85, 247, 0.12);
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            animation: float 8s ease-in-out infinite reverse;
        }

        .main-wrapper {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 1rem;
            padding-top: 5rem;
            position: relative;
            z-index: 10;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            margin-bottom: 5rem;
            animation: slide-up 0.8s ease-out;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(6, 182, 212, 0.15);
            backdrop-filter: blur(8px);
            color: #06b6d4;
            padding: 0.625rem 1.25rem;
            border: 1px solid rgba(6, 182, 212, 0.3);
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            letter-spacing: 0.05em;
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.2);
            transition: all 0.3s ease;
        }

        .hero-badge:hover {
            background: rgba(6, 182, 212, 0.25);
            box-shadow: 0 0 30px rgba(6, 182, 212, 0.4);
        }

        .hero-badge svg {
            width: 1rem;
            height: 1rem;
        }

        .hero-title {
            font-size: 3.75rem;
            font-weight: 900;
            color: #f1f5f9;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            letter-spacing: -0.03em;
            font-family: 'Space Grotesk', sans-serif;
            animation: slide-up 0.8s ease-out 0.1s both;
        }

        .hero-title-highlight {
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 50%, #a855f7 100%);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease infinite;
        }

        .hero-subtitle {
            font-size: 1.375rem;
            color: #cbd5e1;
            max-width: 48rem;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
            animation: slide-up 0.8s ease-out 0.2s both;
        }

        .hero-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1.125rem 2.5rem;
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 50%, #a855f7 100%);
            background-size: 200% 200%;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 1.5rem;
            text-decoration: none;
            box-shadow: 0 0 30px rgba(6, 182, 212, 0.4), 0 15px 40px rgba(37, 99, 235, 0.3);
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            animation: slide-up 0.8s ease-out 0.3s both;
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
            box-shadow: 0 0 50px rgba(6, 182, 212, 0.6), 0 20px 60px rgba(37, 99, 235, 0.4);
            animation: hover-lift 0.3s ease forwards;
            background-position: 100% 100%;
            transform: translateY(-6px);
        }

        .hero-button svg {
            width: 1.25rem;
            height: 1.25rem;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .hero-button:hover svg:last-child {
            transform: translateX(4px);
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 5rem;
        }

        @media (min-width: 768px) {
            .features-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .feature-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(6, 182, 212, 0.2);
            border-radius: 1.5rem;
            padding: 2rem;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            position: relative;
            overflow: hidden;
            animation: slide-up 0.8s ease-out both;
        }

        .feature-card:nth-child(1) { animation-delay: 0.2s; }
        .feature-card:nth-child(2) { animation-delay: 0.3s; }
        .feature-card:nth-child(3) { animation-delay: 0.4s; }

        .feature-card::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(6, 182, 212, 0.5), transparent);
        }

        .feature-card:hover {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(6, 182, 212, 0.5);
            box-shadow: 0 0 30px rgba(6, 182, 212, 0.2), 0 20px 40px rgba(0, 0, 0, 0.3);
            transform: translateY(-4px);
        }

        .feature-icon {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
            position: relative;
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.3);
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.15) rotate(5deg);
        }

        .feature-icon-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
        }

        .feature-icon-blue {
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 100%);
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.4);
        }

        .feature-icon-purple {
            background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.4);
        }

        .feature-icon svg {
            width: 1.75rem;
            height: 1.75rem;
            color: #fff;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 0.75rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .feature-description {
            color: #cbd5e1;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Election Info Card */
        .election-card {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(37, 99, 235, 0.15) 50%, rgba(168, 85, 247, 0.15) 100%);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(6, 182, 212, 0.3);
            border-radius: 2rem;
            padding: 3rem 2rem;
            color: #f1f5f9;
            text-align: center;
            box-shadow: 0 0 40px rgba(6, 182, 212, 0.2), 0 20px 50px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            animation: slide-up 0.8s ease-out 0.5s both;
        }

        .election-card::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(6, 182, 212, 0.8), transparent);
        }

        .election-title {
            font-size: 2rem;
            font-weight: 900;
            margin-bottom: 1rem;
            font-family: 'Space Grotesk', sans-serif;
            background: linear-gradient(to right, #06b6d4, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .election-subtitle {
            color: #cbd5e1;
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .election-info-grid {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            justify-content: center;
        }

        @media (min-width: 640px) {
            .election-info-grid {
                flex-direction: row;
                gap: 2rem;
            }
        }

        .election-info-box {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(6, 182, 212, 0.2);
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            flex: 1;
        }

        .election-info-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(6, 182, 212, 0.5), transparent);
        }

        .election-info-box:hover {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(6, 182, 212, 0.5);
            transform: translateY(-4px);
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.2);
        }

        .election-info-date {
            font-size: 1.75rem;
            font-weight: 900;
            color: #06b6d4;
            font-family: 'Space Grotesk', sans-serif;
        }

        .election-info-label {
            font-size: 0.875rem;
            color: #94a3b8;
            margin-top: 0.5rem;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        /* Footer */
        footer {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(6, 182, 212, 0.1);
            box-shadow: 0 -10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        .footer-container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 2rem 1rem;
            text-align: center;
        }

        .footer-text {
            color: #cbd5e1;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .footer-subtext {
            font-size: 0.875rem;
            color: #64748b;
            letter-spacing: 0.05em;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .election-title {
                font-size: 1.5rem;
            }

            .bg-blob-1, .bg-blob-2 {
                width: 12rem;
                height: 12rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <div class="nav-brand">
                <div class="nav-logo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="nav-pulse"></div>
                </div>
                <div class="nav-title">
                    <h1>Student Election System</h1>
                    <p>Your Voice, Your Choice</p>
                </div>
            </div>
            <div class="nav-status">
                <div class="nav-status-dot"></div>
                <span>Election Status: Active</span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Background Elements -->
        <div class="bg-pattern"></div>
        <div class="bg-blob-1"></div>
        <div class="bg-blob-2"></div>

        <div class="main-wrapper">
            <!-- Hero Section -->
            <div class="hero-section">
                <div class="hero-badge">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Secure • Transparent • Fair</span>
                </div>

                <h1 class="hero-title">
                    Shape Your
                    <span class="hero-title-highlight">Future</span>
                </h1>

                <p class="hero-subtitle">
                    Participate in the democratic process. Your vote is your voice in building a better student community.
                </p>

                <a href="{{ route('voter.login') }}" class="hero-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    Cast Your Vote
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>

            <!-- Features Grid -->
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon feature-icon-green">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Secure Voting</h3>
                    <p class="feature-description">State-of-the-art encryption ensures your vote remains private and tamper-proof.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon feature-icon-blue">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Real-time Results</h3>
                    <p class="feature-description">Watch election results unfold in real-time with transparent vote counting.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon feature-icon-purple">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Easy Access</h3>
                    <p class="feature-description">Vote from anywhere, anytime with our user-friendly platform.</p>
                </div>
            </div>

            <!-- Election Info Card -->
            <div class="election-card">
                <h2 class="election-title">Ready to Vote?</h2>
                <p class="election-subtitle">Login with your credentials to access the voting platform and make your voice heard.</p>
                <div class="election-info-grid">
                    <div class="election-info-box">
                        <div class="election-info-date">{{ now()->format('M j, Y') }}</div>
                        <div class="election-info-label">Election Date</div>
                    </div>
                    <div class="election-info-box">
                        <div class="election-info-date">8:00 AM - 5:00 PM</div>
                        <div class="election-info-label">Voting Hours</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <p class="footer-text">© {{ date('Y') }} Student Election System. All rights reserved.</p>
            <p class="footer-subtext">Empowering student voices through democratic participation.</p>
        </div>
    </footer>
</body>
</html>

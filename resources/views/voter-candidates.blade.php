<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet the Candidates - Premium Election System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap');

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        @keyframes glow-pulse {
            0%, 100% { box-shadow: 0 0 20px rgba(34, 211, 238, 0.5), inset 0 0 20px rgba(34, 211, 238, 0.1); }
            50% { box-shadow: 0 0 40px rgba(34, 211, 238, 0.8), inset 0 0 30px rgba(34, 211, 238, 0.2); }
        }

        @keyframes slide-in {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes scale-in {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
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
            color: #fff;
            position: relative;
            overflow-x: hidden;
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
            background: radial-gradient(circle at 20% 50%, rgba(34, 211, 238, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        nav {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 58, 138, 0.95) 100%);
            backdrop-filter: blur(40px);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3),
                        0 0 50px rgba(34, 211, 238, 0.1);
            border-bottom: 1px solid rgba(34, 211, 238, 0.2);
        }

        .nav-container {
            max-width: 90rem;
            margin: 0 auto;
            padding: 0 2rem;
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
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 50%, #7c3aed 100%);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px rgba(6, 182, 212, 0.4),
                        inset 0 0 20px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            border: 1.5px solid rgba(255, 255, 255, 0.1);
        }

        .nav-logo:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 30px 60px rgba(6, 182, 212, 0.5),
                        inset 0 0 30px rgba(255, 255, 255, 0.2);
        }

        .nav-logo svg {
            width: 1.75rem;
            height: 1.75rem;
            color: #fff;
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.3));
        }

        .nav-title h1 {
            font-size: 1.35rem;
            font-weight: 900;
            background: linear-gradient(to right, #a5f3fc, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .nav-title p {
            font-size: 0.75rem;
            color: rgba(165, 243, 252, 0.6);
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-user {
            text-align: right;
            display: none;
        }

        .nav-user p:first-child {
            font-size: 0.95rem;
            font-weight: 700;
            color: #e0f2fe;
        }

        .nav-user p:last-child {
            font-size: 0.8rem;
            color: rgba(165, 243, 252, 0.6);
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            color: rgba(165, 243, 252, 0.8);
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.1), rgba(34, 211, 238, 0.05));
            border: 1.5px solid rgba(34, 211, 238, 0.3);
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.7rem 1.5rem;
            border-radius: 0.875rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            backdrop-filter: blur(20px);
        }

        .logout-btn:hover {
            color: #e0f2fe;
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.2), rgba(34, 211, 238, 0.1));
            border-color: rgba(34, 211, 238, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 211, 238, 0.2);
        }

        .logout-btn svg {
            width: 1.1rem;
            height: 1.1rem;
        }

        @media (min-width: 640px) {
            .nav-user {
                display: block;
            }
        }

        .main-container {
            max-width: 90rem;
            margin: 0 auto;
            padding: 2rem;
            padding-top: 5rem;
            padding-bottom: 6rem;
            position: relative;
            z-index: 10;
        }

        .hero-section {
            margin-bottom: 6rem;
            text-align: center;
            animation: slide-in 0.8s ease-out;
        }

        .hero-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 5.5rem;
            height: 5.5rem;
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 50%, #7c3aed 100%);
            border-radius: 1.5rem;
            box-shadow: 0 30px 60px rgba(6, 182, 212, 0.4),
                        inset 0 0 30px rgba(255, 255, 255, 0.15);
            margin-bottom: 2rem;
            transition: all 0.4s ease;
            border: 2px solid rgba(255, 255, 255, 0.1);
            animation: float 4s ease-in-out infinite;
        }

        .hero-icon:hover {
            transform: scale(1.15) rotate(-5deg);
            box-shadow: 0 40px 80px rgba(6, 182, 212, 0.5),
                        inset 0 0 40px rgba(255, 255, 255, 0.2);
        }

        .hero-icon svg {
            width: 2.75rem;
            height: 2.75rem;
            color: #fff;
            filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.4));
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(to right, #cffafe, #a5f3fc, #93c5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            letter-spacing: -1px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(165, 243, 252, 0.85);
            max-width: 42rem;
            margin: 0 auto;
            line-height: 1.8;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
        }

        .position-section {
            margin-bottom: 6rem;
            animation: slide-in 0.8s ease-out both;
        }

        .position-header {
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 40%, #4f46e5 100%);
            border-radius: 2rem;
            box-shadow: 0 30px 60px rgba(6, 182, 212, 0.3),
                        0 0 60px rgba(6, 182, 212, 0.15);
            padding: 3rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.320, 1);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
        }

        .position-header:hover {
            transform: translateY(-8px);
            box-shadow: 0 40px 80px rgba(6, 182, 212, 0.4),
                        0 0 80px rgba(6, 182, 212, 0.2);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .position-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .position-header-content {
            position: relative;
            z-index: 10;
        }

        .position-badges {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .position-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3.5rem;
            height: 3.5rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 0.75rem;
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            font-weight: 800;
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.5rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .position-label {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
            color: rgba(255, 255, 255, 0.95);
            font-size: 0.9rem;
            font-weight: 700;
            backdrop-filter: blur(20px);
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .position-title {
            font-size: 2.5rem;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 0.75rem;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            letter-spacing: -0.5px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .position-description {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            line-height: 1.7;
        }

        .candidates-wrapper {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.6) 0%, rgba(30, 58, 138, 0.4) 100%);
            border-radius: 2rem;
            padding: 3rem 2rem;
            backdrop-filter: blur(20px);
            border: 1.5px solid rgba(34, 211, 238, 0.3);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .candidates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2.5rem;
        }

        .candidate-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            border-radius: 1.75rem;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3),
                        0 0 20px rgba(34, 211, 238, 0.1);
            border: 2px solid rgba(34, 211, 238, 0.3);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            animation: scale-in 0.5s ease-out both;
            cursor: pointer;
            position: relative;
        }

        .candidate-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4),
                        0 0 40px rgba(34, 211, 238, 0.2);
            border-color: rgba(34, 211, 238, 0.7);
        }

        .candidate-photo-wrapper {
            position: relative;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(37, 99, 235, 0.1));
            border-bottom: 2px solid rgba(34, 211, 238, 0.3);
        }

        .candidate-photo {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(6, 182, 212, 0.3),
                        inset 0 0 20px rgba(255, 255, 255, 0.1);
            border: 3px solid rgba(34, 211, 238, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            position: relative;
            transition: all 0.4s ease;
        }

        .candidate-card:hover .candidate-photo {
            box-shadow: 0 20px 50px rgba(6, 182, 212, 0.4),
                        inset 0 0 30px rgba(255, 255, 255, 0.15);
            border-color: rgba(165, 243, 252, 0.8);
            transform: scale(1.08);
        }

        .candidate-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .candidate-photo svg {
            width: 60px;
            height: 60px;
            color: rgba(34, 211, 238, 0.6);
        }

        .candidate-info {
            padding: 1.75rem;
            text-align: center;
        }

        .candidate-name {
            font-size: 1.35rem;
            font-weight: 900;
            color: rgba(165, 243, 252, 0.95);
            margin-bottom: 0.5rem;
            letter-spacing: -0.3px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .candidate-position {
            color: rgba(34, 211, 238, 0.8);
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
            letter-spacing: 0.2px;
        }

        .candidate-party {
            color: rgba(148, 163, 184, 0.7);
            font-size: 0.85rem;
            font-style: italic;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(34, 211, 238, 0.2);
        }

        .empty-state {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.05), rgba(99, 102, 241, 0.05));
            border: 2px dashed rgba(34, 211, 238, 0.3);
            border-radius: 1.75rem;
            padding: 4rem 2rem;
            text-align: center;
            backdrop-filter: blur(20px);
        }

        .empty-state svg {
            width: 4rem;
            height: 4rem;
            color: rgba(34, 211, 238, 0.4);
            margin: 0 auto 1rem;
        }

        .empty-state-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: rgba(165, 243, 252, 0.8);
            margin-bottom: 0.5rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .empty-state-text {
            color: rgba(165, 243, 252, 0.6);
            font-size: 1rem;
        }

        .no-positions {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(139, 92, 246, 0.1));
            border: 2px solid rgba(99, 102, 241, 0.3);
            border-radius: 2rem;
            padding: 4rem;
            text-align: center;
            backdrop-filter: blur(20px);
            animation: scale-in 0.6s ease-out;
        }

        .no-positions-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 5rem;
            height: 5rem;
            background: rgba(99, 102, 241, 0.2);
            border-radius: 1.5rem;
            margin-bottom: 2rem;
            border: 2px solid rgba(99, 102, 241, 0.3);
        }

        .no-positions-icon svg {
            width: 2.5rem;
            height: 2.5rem;
            color: rgba(99, 102, 241, 0.7);
        }

        .no-positions-title {
            font-size: 2rem;
            font-weight: 900;
            color: rgba(165, 243, 252, 0.9);
            margin-bottom: 1rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .no-positions-text {
            color: rgba(165, 243, 252, 0.7);
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .vote-section {
            margin-top: 6rem;
            text-align: center;
            animation: slide-in 0.8s ease-out 0.3s both;
        }

        .vote-btn {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 50%, #7c3aed 100%);
            color: #fff;
            text-decoration: none;
            font-weight: 900;
            font-size: 1.25rem;
            padding: 1.35rem 3rem;
            border-radius: 1.25rem;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            box-shadow: 0 20px 50px rgba(6, 182, 212, 0.35),
                        0 0 0 1.5px rgba(34, 211, 238, 0.2) inset;
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: 0.5px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .vote-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .vote-btn:hover::before {
            left: 100%;
        }

        .vote-btn:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 70px rgba(6, 182, 212, 0.5),
                        0 0 0 2px rgba(34, 211, 238, 0.3) inset;
        }

        .vote-btn:active {
            transform: translateY(-2px);
        }

        .vote-btn svg {
            width: 1.5rem;
            height: 1.5rem;
            filter: drop-shadow(0 0 6px rgba(255, 255, 255, 0.3));
            transition: transform 0.3s ease;
        }

        .vote-btn:hover svg {
            transform: translateX(4px);
        }

        @media (max-width: 768px) {
            .nav-container {
                padding: 0 1.5rem;
            }

            .main-container {
                padding: 1.5rem;
                padding-top: 4rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .position-header {
                padding: 2rem 1.5rem;
            }

            .position-title {
                font-size: 1.75rem;
            }

            .candidates-grid {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                gap: 1.5rem;
            }

            .candidates-wrapper {
                padding: 1.75rem 1rem;
            }

            .vote-btn {
                font-size: 1rem;
                padding: 1rem 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="nav-container">
            <div class="nav-brand">
                <div class="nav-logo">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <div class="nav-title">
                    <h1>Election System</h1>
                    <p>Candidate Preview</p>
                </div>
            </div>
            <div class="nav-right">
                <div class="nav-user">
                    <p>{{ session('voter_firstname') }} {{ session('voter_lastname') }}</p>
                    <p>Registered Voter</p>
                </div>
                <form method="POST" action="{{ route('voter.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-icon">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                </svg>
            </div>
            <h1 class="hero-title">Meet the Candidates</h1>
            <p class="hero-subtitle">Review all candidates for each position. Get to know them before you cast your vote.</p>
        </div>

        <!-- Positions and Candidates -->
        @forelse($positions as $index => $position)
            <div class="position-section" style="animation-delay: {{ $index * 0.1 }}s;">
                <!-- Position Header -->
                <div class="position-header">
                    <div class="position-header-content">
                        <div class="position-badges">
                            <div class="position-number">{{ $index + 1 }}</div>
                            <span class="position-label">Position</span>
                        </div>
                        <h2 class="position-title">{{ $position->position_name }}</h2>
                        @if($position->description)
                            <p class="position-description">{{ $position->description }}</p>
                        @endif
                    </div>
                </div>

                <!-- Candidates -->
                <div class="candidates-wrapper">
                    @if($position->candidates->count() > 0)
                        <div class="candidates-grid">
                            @foreach($position->candidates as $candidateIndex => $candidate)
                                <div class="candidate-card" style="animation-delay: {{ $candidateIndex * 0.05 }}s;">
                                    <div class="candidate-photo-wrapper">
                                        <div class="candidate-photo">
                                            @if($candidate->imagepath)
                                                <img src="{{ asset('storage/' . $candidate->imagepath) }}" alt="{{ $candidate->candidate_name }}">
                                            @else
                                                <svg fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="candidate-info">
                                        <h3 class="candidate-name">{{ $candidate->candidate_name }}</h3>
                                        <p class="candidate-position">{{ $position->position_name }}</p>
                                        @if($candidate->party_affiliation)
                                            <p class="candidate-party">{{ $candidate->party_affiliation }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="empty-state-title">No candidates yet</p>
                            <p class="empty-state-text">Check back soon for updates</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="no-positions">
                <div class="no-positions-icon">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                </div>
                <h3 class="no-positions-title">No Positions Available</h3>
                <p class="no-positions-text">No positions or candidates available at this time. Please check back later.</p>
            </div>
        @endforelse

        <!-- Proceed to Voting -->
        @if($positions->count() > 0)
            <div class="vote-section">
                <a href="{{ route('voter.voting') }}" class="vote-btn">
                    <span>Ready to Vote</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</body>
</html>

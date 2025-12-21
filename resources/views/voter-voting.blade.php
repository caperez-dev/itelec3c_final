<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast Your Vote - Premium Election System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap');

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(34, 211, 238, 0.5); }
            50% { box-shadow: 0 0 40px rgba(34, 211, 238, 0.8); }
        }

        @keyframes checkmark {
            0% { transform: scale(0) rotate(-45deg); opacity: 0; }
            50% { transform: scale(1.2); }
            100% { transform: scale(1) rotate(0); opacity: 1; }
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
            animation: bgGradient 15s ease infinite;
            min-height: 100vh;
            color: #fff;
            position: relative;
        }

        @keyframes bgGradient {
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
            max-width: 56rem;
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
            width: 3.25rem;
            height: 3.25rem;
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 50%, #7c3aed 100%);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px rgba(6, 182, 212, 0.4),
                        inset 0 0 20px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .nav-logo:hover {
            transform: scale(1.1);
            box-shadow: 0 30px 60px rgba(6, 182, 212, 0.5);
        }

        .nav-logo svg {
            width: 1.75rem;
            height: 1.75rem;
            color: #fff;
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.3));
        }

        .nav-title h1 {
            font-size: 1.25rem;
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
        }

        .nav-user {
            display: none;
        }

        @media (min-width: 640px) {
            .nav-user {
                display: block;
                text-align: right;
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
        }

        .main-container {
            max-width: 56rem;
            margin: 0 auto;
            padding: 2rem;
            padding-top: 5rem;
            padding-bottom: 6rem;
            position: relative;
            z-index: 10;
        }

        .page-header {
            text-align: center;
            margin-bottom: 4rem;
            animation: slideUp 0.8s ease-out;
        }

        .header-icon {
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

        .header-icon:hover {
            transform: scale(1.15);
            box-shadow: 0 40px 80px rgba(6, 182, 212, 0.5);
        }

        .header-icon svg {
            width: 2.75rem;
            height: 2.75rem;
            color: #fff;
            filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.4));
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 900;
            background: linear-gradient(to right, #cffafe, #a5f3fc, #93c5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            letter-spacing: -1px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: rgba(165, 243, 252, 0.85);
            font-weight: 500;
        }

        .instructions-card {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(37, 99, 235, 0.1));
            border: 2px solid rgba(34, 211, 238, 0.5);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 3rem;
            backdrop-filter: blur(20px);
            display: flex;
            gap: 1.5rem;
            animation: slideUp 0.8s ease-out 0.1s both;
        }

        .instructions-icon {
            flex-shrink: 0;
            width: 2rem;
            height: 2rem;
            color: rgba(34, 211, 238, 0.8);
        }

        .instructions-content h3 {
            font-weight: 800;
            color: rgba(165, 243, 252, 0.95);
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .instructions-content p {
            color: #e0f2fe;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .voting-form {
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }

        .position-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            border-radius: 2rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3),
                        0 0 20px rgba(34, 211, 238, 0.1);
            overflow: hidden;
            border: 2px solid rgba(34, 211, 238, 0.3);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            animation: slideUp 0.8s ease-out both;
        }

        .position-card:hover {
            border-color: rgba(34, 211, 238, 0.7);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4),
                        0 0 40px rgba(34, 211, 238, 0.2);
            transform: translateY(-8px);
        }

        .position-header {
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 40%, #4f46e5 100%);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
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
        }

        .position-header-content {
            position: relative;
            z-index: 10;
        }

        .position-badges {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .position-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 0.75rem;
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            font-weight: 800;
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.35rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .position-label {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
            color: rgba(255, 255, 255, 0.95);
            font-size: 0.85rem;
            font-weight: 700;
            backdrop-filter: blur(20px);
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .position-title {
            font-size: 2rem;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            letter-spacing: -0.5px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .position-description {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .candidates-list {
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .candidate-option {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            border: 2px solid rgba(34, 211, 238, 0.3);
            border-radius: 1.25rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            background: rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .candidate-option::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(34, 211, 238, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .candidate-option:hover::before {
            transform: translateX(100%);
        }

        .candidate-option:hover {
            border-color: rgba(34, 211, 238, 0.7);
            background: rgba(34, 211, 238, 0.15);
            box-shadow: 0 15px 35px rgba(6, 182, 212, 0.2);
            transform: translateX(8px);
        }

        .candidate-option input[type="radio"]:checked + .candidate-content {
            color: #e0f2fe;
        }

        .candidate-radio {
            width: 1.75rem;
            height: 1.75rem;
            flex-shrink: 0;
            cursor: pointer;
            accent-color: rgba(6, 182, 212, 0.9);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .candidate-option:hover .candidate-radio {
            transform: scale(1.15);
        }

        .candidate-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex: 1;
            position: relative;
            z-index: 10;
        }

        .candidate-photo {
            width: 4.5rem;
            height: 4.5rem;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(6, 182, 212, 0.2);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(34, 211, 238, 0.4);
            transition: all 0.3s ease;
        }

        .candidate-option:hover .candidate-photo {
            box-shadow: 0 12px 30px rgba(6, 182, 212, 0.35);
            border-color: rgba(34, 211, 238, 0.7);
            transform: scale(1.08);
        }

        .candidate-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .candidate-photo svg {
            width: 2rem;
            height: 2rem;
            color: rgba(34, 211, 238, 0.6);
        }

        .candidate-info h4 {
            font-size: 1.15rem;
            font-weight: 800;
            color: rgba(165, 243, 252, 0.95);
            margin-bottom: 0.25rem;
            letter-spacing: -0.3px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .candidate-info p {
            color: rgba(148, 163, 184, 0.8);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .abstain-option {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.75rem;
            border: 2.5px dashed rgba(168, 85, 247, 0.4);
            border-radius: 1.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(139, 92, 246, 0.05);
            position: relative;
        }

        .abstain-option:hover {
            border-color: rgba(168, 85, 247, 0.7);
            background: rgba(139, 92, 246, 0.15);
            box-shadow: 0 12px 30px rgba(139, 92, 246, 0.2);
            transform: translateX(8px);
        }

        .abstain-text {
            font-size: 1rem;
            font-weight: 700;
            color: rgba(168, 85, 247, 0.9);
            flex: 1;
            font-family: 'Space Grotesk', sans-serif;
        }

        .confirmation-section {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(5, 150, 105, 0.08));
            border: 2px solid rgba(16, 185, 129, 0.3);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-top: 2rem;
            backdrop-filter: blur(20px);
            animation: slideUp 0.8s ease-out 0.3s both;
        }

        .confirmation-checkbox-label {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            cursor: pointer;
        }

        .confirmation-checkbox {
            width: 1.5rem;
            height: 1.5rem;
            min-width: 1.5rem;
            margin-top: 0.25rem;
            cursor: pointer;
            accent-color: rgba(16, 185, 129, 0.8);
        }

        .confirmation-content h3 {
            font-weight: 800;
            color: rgba(16, 185, 129, 0.95);
            margin-bottom: 1rem;
            font-size: 1.1rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .confirmation-items {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .confirmation-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            color: rgba(16, 185, 129, 0.8);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .confirmation-item svg {
            width: 1.25rem;
            height: 1.25rem;
            color: rgba(16, 185, 129, 0.8);
            flex-shrink: 0;
            margin-top: 0.15rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 3rem;
        }

        @media (min-width: 640px) {
            .action-buttons {
                gap: 1.5rem;
            }
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1.15rem 2rem;
            border: none;
            border-radius: 1rem;
            font-weight: 800;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            position: relative;
            overflow: hidden;
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: 0.3px;
            flex: 1;
        }

        .btn-secondary {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.2), rgba(34, 211, 238, 0.1));
            color: rgba(165, 243, 252, 0.95);
            border: 2px solid rgba(34, 211, 238, 0.4);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.3), rgba(34, 211, 238, 0.2));
            border-color: rgba(34, 211, 238, 0.7);
            box-shadow: 0 15px 35px rgba(34, 211, 238, 0.2);
            transform: translateY(-3px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 50%, #7c3aed 100%);
            color: #fff;
            border: none;
            box-shadow: 0 15px 35px rgba(6, 182, 212, 0.35),
                        0 0 0 1.5px rgba(34, 211, 238, 0.2) inset;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #06a6d4 0%, #1d4ed8 50%, #6d28d9 100%);
            box-shadow: 0 25px 50px rgba(6, 182, 212, 0.4),
                        0 0 0 2px rgba(34, 211, 238, 0.3) inset;
            transform: translateY(-4px);
        }

        .btn-primary:active {
            transform: translateY(-2px);
        }

        .btn svg {
            width: 1.35rem;
            height: 1.35rem;
            filter: drop-shadow(0 0 4px rgba(255, 255, 255, 0.2));
        }

        @media (max-width: 768px) {
            .nav-container {
                padding: 0 1.5rem;
            }

            .main-container {
                padding: 1.5rem;
                padding-top: 4rem;
            }

            .page-title {
                font-size: 2.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .position-card {
                margin-bottom: 1.5rem;
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
                    <h1>Cast Your Vote</h1>
                    <p>Secure & Transparent</p>
                </div>
            </div>
            <div class="nav-user">
                <p>{{ session('voter_firstname') }} {{ session('voter_lastname') }}</p>
                <p>Authenticated Voter</p>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-icon">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
            </div>
            <h1 class="page-title">Cast Your Vote</h1>
            <p class="page-subtitle">Select your candidates for each position</p>
        </div>

        <!-- Instructions Card -->
        <div class="instructions-card">
            <svg class="instructions-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="instructions-content">
                <h3>How to Vote</h3>
                <p>For each position, select one candidate or choose to abstain. Review all your selections carefully before submitting. Once submitted, your vote cannot be changed.</p>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div style="background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(239, 68, 68, 0.1)); border: 2px solid rgba(239, 68, 68, 0.5); border-radius: 1.5rem; padding: 2rem; margin-bottom: 3rem; backdrop-filter: blur(20px);">
                <h3 style="color: #fca5a5; font-weight: 800; margin-bottom: 1rem; font-family: 'Space Grotesk', sans-serif;">Please correct the following errors:</h3>
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li style="color: #fca5a5; margin-bottom: 0.5rem; display: flex; gap: 0.5rem;">
                            <span>•</span> {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Voting Form -->
        <form method="POST" action="{{ route('voter.submit-vote') }}" class="voting-form">
            @csrf

            @forelse($positions as $index => $position)
                <div class="position-card" style="animation-delay: {{ $index * 0.1 }}s;">
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

                    <div class="candidates-list">
                        @if($position->candidates->count() > 0)
                            @foreach($position->candidates as $candidate)
                                <label class="candidate-option">
                                    <input 
                                        type="radio" 
                                        name="votes[{{ $position->position_id }}]" 
                                        value="{{ $candidate->candidate_id }}"
                                        {{ old('votes.' . $position->position_id) == $candidate->candidate_id ? 'checked' : '' }}
                                        class="candidate-radio"
                                        data-position-id="{{ $position->position_id }}"
                                        data-candidate-id="{{ $candidate->candidate_id }}"
                                    />
                                    <div class="candidate-content">
                                        <div class="candidate-photo">
                                            @if($candidate->imagepath)
                                                <img src="{{ asset('storage/' . $candidate->imagepath) }}" alt="{{ $candidate->candidate_name }}">
                                            @else
                                                <svg fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="candidate-info">
                                            <h4>{{ $candidate->candidate_name }}</h4>
                                            <p>{{ $position->position_name }}</p>
                                            @if($candidate->party_affiliation)
                                                <p>{{ $candidate->party_affiliation }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        @endif

                        <!-- Abstain Option -->
                        <label class="abstain-option">
                            <input 
                                type="radio" 
                                name="votes[{{ $position->position_id }}]" 
                                value="abstain"
                                {{ old('votes.' . $position->position_id) == 'abstain' ? 'checked' : '' }}
                                class="candidate-radio"
                                data-position-id="{{ $position->position_id }}"
                                data-candidate-id="abstain"
                            />
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.75rem; height: 1.75rem; color: rgba(168, 85, 247, 0.6);">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span class="abstain-text">Abstain from this position</span>
                        </label>
                    </div>
                </div>
            @empty
                <div style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(139, 92, 246, 0.1)); border: 2px solid rgba(99, 102, 241, 0.3); border-radius: 2rem; padding: 3rem; text-align: center; backdrop-filter: blur(20px);">
                    <p style="font-size: 1.15rem; color: rgba(165, 243, 252, 0.8); font-weight: 600; font-family: 'Space Grotesk', sans-serif;">No positions available</p>
                </div>
            @endforelse

            <!-- Confirmation Section -->
            <div class="confirmation-section">
                <label class="confirmation-checkbox-label">
                    <input type="checkbox" name="confirmation" id="confirmation" class="confirmation-checkbox" required />
                    <div class="confirmation-content">
                        <h3>Confirm Your Vote</h3>
                        <div class="confirmation-items">
                            <div class="confirmation-item">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                <span>I have reviewed all my selections</span>
                            </div>
                            <div class="confirmation-item">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                <span>I understand my vote cannot be changed</span>
                            </div>
                            <div class="confirmation-item">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                <span>I am voting of my own free will</span>
                            </div>
                        </div>
                    </div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('voter.candidates') }}" class="btn btn-secondary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Review Candidates
                </a>
                <button 
                    type="submit"
                    onclick="return confirm('Are you sure? This action CANNOT be undone.');"
                    class="btn btn-primary"
                >
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    Submit My Vote
                </button>
            </div>
        </form>
    </div>

    <script>
        // Simple toggle behavior - click again to unselect
        document.addEventListener('DOMContentLoaded', function() {
            const votes = {};
            const lastSelected = {};
            
            // Restore from localStorage first
            document.querySelectorAll('input[type="radio"][name^="votes"]').forEach(radio => {
                const positionId = radio.getAttribute('data-position-id');
                const saved = localStorage.getItem('votes_backup_' + positionId);
                
                if (saved && radio.value === saved) {
                    radio.checked = true;
                    votes[positionId] = saved;
                    lastSelected[positionId] = radio;
                } else if (radio.checked) {
                    votes[positionId] = radio.value;
                    lastSelected[positionId] = radio;
                }
            });
            
            // Add click listener for toggle behavior
            document.querySelectorAll('input[type="radio"][name^="votes"]').forEach(radio => {
                radio.addEventListener('click', function() {
                    const positionId = this.getAttribute('data-position-id');
                    
                    // If clicking the already-selected radio, uncheck it
                    if (lastSelected[positionId] === this && this.checked) {
                        this.checked = false;
                        delete votes[positionId];
                        delete lastSelected[positionId];
                        localStorage.removeItem('votes_backup_' + positionId);
                        console.log('Unselected position', positionId);
                    } else {
                        // New selection
                        votes[positionId] = this.value;
                        lastSelected[positionId] = this;
                        localStorage.setItem('votes_backup_' + positionId, this.value);
                        console.log('Selected position', positionId, '=', this.value);
                    }
                });
            });
            
            // Clear localStorage on form submit
            document.querySelector('.voting-form').addEventListener('submit', function() {
                Object.keys(votes).forEach(positionId => {
                    localStorage.removeItem('votes_backup_' + positionId);
                });
            });
        });
    </script>
</body>
</html>


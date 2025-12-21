<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Results - Premium Election System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
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
            0%, 100% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.5); }
            50% { box-shadow: 0 0 40px rgba(16, 185, 129, 0.8); }
        }

        @keyframes countdown {
            0% { width: 0%; }
            100% { width: 100%; }
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
            max-width: 80rem;
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
            box-shadow: 0 20px 40px rgba(6, 182, 212, 0.4);
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .nav-logo:hover {
            transform: scale(1.1);
        }

        .nav-logo svg {
            width: 1.75rem;
            height: 1.75rem;
            color: #fff;
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

        @media (min-width: 640px) {
            .nav-user {
                display: block;
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
            transition: all 0.3s ease;
            backdrop-filter: blur(20px);
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.2), rgba(34, 211, 238, 0.1));
            border-color: rgba(34, 211, 238, 0.6);
            transform: translateY(-2px);
        }

        .main-container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 2rem;
            padding-top: 5rem;
            padding-bottom: 6rem;
            position: relative;
            z-index: 10;
        }

        .success-banner {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.2), rgba(16, 185, 129, 0.15));
            border: 2px solid rgba(16, 185, 129, 0.5);
            border-radius: 1.75rem;
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
            backdrop-filter: blur(20px);
            animation: slideUp 0.8s ease-out;
        }

        .success-icon {
            flex-shrink: 0;
            width: 3rem;
            height: 3rem;
            background: rgba(16, 185, 129, 0.3);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(16, 185, 129, 0.5);
        }

        .success-icon svg {
            width: 1.75rem;
            height: 1.75rem;
            color: rgba(16, 185, 129, 0.8);
            animation: float 3s ease-in-out infinite;
        }

        .success-content h3 {
            color: rgba(16, 185, 129, 0.95);
            font-weight: 800;
            margin-bottom: 0.35rem;
            font-size: 1.15rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .success-content p {
            color: #a7f3d0;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .page-header {
            text-align: center;
            margin-bottom: 4rem;
            animation: slideUp 0.8s ease-out 0.1s both;
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
        }

        .header-icon svg {
            width: 2.75rem;
            height: 2.75rem;
            color: #fff;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
            animation: slideUp 0.8s ease-out 0.2s both;
        }

        .stat-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            border-radius: 1.75rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3),
                        0 0 20px rgba(34, 211, 238, 0.1);
            padding: 2rem;
            border: 2px solid rgba(34, 211, 238, 0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            transition: all 0.4s ease;
        }

        .stat-card:hover {
            border-color: rgba(34, 211, 238, 0.7);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4),
                        0 0 40px rgba(34, 211, 238, 0.2);
            transform: translateY(-8px);
        }

        .stat-content p:first-child {
            font-size: 0.85rem;
            font-weight: 700;
            color: rgba(165, 243, 252, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 0.75rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .stat-number {
            font-size: 2.75rem;
            font-weight: 900;
            color: rgba(165, 243, 252, 0.95);
            margin-bottom: 0.35rem;
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: -1px;
        }

        .stat-description {
            font-size: 0.9rem;
            color: rgba(165, 243, 252, 0.6);
            font-weight: 500;
        }

        .stat-icon {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 2px solid;
            transition: all 0.3s ease;
        }

        .stat-icon svg {
            width: 2.25rem;
            height: 2.25rem;
        }

        .cyan-stat { 
            border-color: rgba(34, 211, 238, 0.5); 
            background: rgba(34, 211, 238, 0.15); 
        }
        .cyan-stat svg { color: rgba(34, 211, 238, 0.8); }

        .emerald-stat { 
            border-color: rgba(16, 185, 129, 0.5); 
            background: rgba(16, 185, 129, 0.15); 
        }
        .emerald-stat svg { color: rgba(16, 185, 129, 0.8); }

        .indigo-stat { 
            border-color: rgba(79, 70, 229, 0.5); 
            background: rgba(79, 70, 229, 0.15); 
        }
        .indigo-stat svg { color: rgba(79, 70, 229, 0.8); }

        .position-section {
            margin-bottom: 5rem;
            animation: slideUp 0.8s ease-out both;
        }

        .position-header {
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 40%, #4f46e5 100%);
            border-radius: 2rem;
            box-shadow: 0 30px 60px rgba(6, 182, 212, 0.3);
            padding: 3rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
            transition: all 0.5s ease;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
        }

        .position-header:hover {
            transform: translateY(-8px);
            box-shadow: 0 40px 80px rgba(6, 182, 212, 0.4);
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
        }

        .results-space {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.6), rgba(30, 58, 138, 0.4));
            border-radius: 1.75rem;
            padding: 2.5rem;
            backdrop-filter: blur(20px);
            border: 1.5px solid rgba(34, 211, 238, 0.3);
        }

        .candidate-result {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.1));
            border: 2px solid rgba(34, 211, 238, 0.3);
            border-radius: 1.25rem;
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .candidate-result:hover {
            border-color: rgba(34, 211, 238, 0.6);
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.1), rgba(34, 211, 238, 0.05));
            transform: translateX(8px);
        }

        .candidate-result.leading {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(5, 150, 105, 0.1));
            border-color: rgba(16, 185, 129, 0.6);
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.2);
        }

        .candidate-photo {
            width: 4rem;
            height: 4rem;
            border-radius: 0.875rem;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            border: 2px solid rgba(34, 211, 238, 0.4);
            transition: all 0.3s ease;
        }

        .candidate-result:hover .candidate-photo {
            transform: scale(1.08);
            border-color: rgba(34, 211, 238, 0.7);
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

        .candidate-info {
            flex: 1;
        }

        .candidate-info h3 {
            font-size: 1.2rem;
            font-weight: 900;
            color: rgba(165, 243, 252, 0.95);
            margin-bottom: 0.35rem;
            letter-spacing: -0.3px;
            font-family: 'Space Grotesk', sans-serif;
        }

        .candidate-info p {
            color: rgba(148, 163, 184, 0.8);
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .vote-stats {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .vote-count {
            text-align: center;
        }

        .vote-number {
            font-size: 1.75rem;
            font-weight: 900;
            color: rgba(165, 243, 252, 0.95);
            font-family: 'Space Grotesk', sans-serif;
        }

        .leading .vote-number {
            color: rgba(16, 185, 129, 0.95);
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .vote-label {
            font-size: 0.8rem;
            color: rgba(148, 163, 184, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            font-family: 'Space Grotesk', sans-serif;
        }

        .progress-bar-container {
            flex: 1;
            min-width: 150px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .progress-label span:first-child {
            color: rgba(165, 243, 252, 0.8);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .progress-percentage {
            color: rgba(148, 163, 184, 0.7);
            font-size: 0.85rem;
            font-weight: 700;
            font-family: 'Space Grotesk', sans-serif;
        }

        .leading .progress-percentage {
            color: rgba(16, 185, 129, 0.8);
        }

        .progress-bar {
            height: 0.75rem;
            background: rgba(34, 211, 238, 0.2);
            border-radius: 9999px;
            overflow: hidden;
            border: 1px solid rgba(34, 211, 238, 0.3);
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #06b6d4, #2563eb);
            border-radius: 9999px;
            transition: width 1s cubic-bezier(0.23, 1, 0.320, 1);
            animation: countdown 1s ease-out;
        }

        .leading .progress-fill {
            background: linear-gradient(90deg, #10b981, #059669);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
        }

        .no-results {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.05), rgba(99, 102, 241, 0.05));
            border: 2px dashed rgba(34, 211, 238, 0.3);
            border-radius: 1.75rem;
            padding: 3rem;
            text-align: center;
            backdrop-filter: blur(20px);
        }

        .no-results svg {
            width: 3.5rem;
            height: 3.5rem;
            color: rgba(34, 211, 238, 0.4);
            margin: 0 auto 1rem;
        }

        .no-results p:first-of-type {
            font-size: 1.35rem;
            font-weight: 800;
            color: rgba(165, 243, 252, 0.8);
            margin-bottom: 0.5rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .no-results p:last-of-type {
            color: rgba(165, 243, 252, 0.6);
            font-size: 1rem;
        }

        .home-button-container {
            text-align: center;
            margin-top: 5rem;
            animation: slideUp 0.8s ease-out 0.4s both;
        }

        .home-button {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 50%, #7c3aed 100%);
            color: #fff;
            text-decoration: none;
            font-weight: 900;
            font-size: 1.15rem;
            padding: 1.25rem 2.75rem;
            border-radius: 1.15rem;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            box-shadow: 0 20px 50px rgba(6, 182, 212, 0.35);
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .home-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .home-button:hover::before {
            left: 100%;
        }

        .home-button:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 70px rgba(6, 182, 212, 0.5);
        }

        .home-button:active {
            transform: translateY(-2px);
        }

        .home-button svg {
            width: 1.4rem;
            height: 1.4rem;
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

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
            }

            .vote-stats {
                flex-direction: column;
            }

            .position-header {
                padding: 2rem 1.5rem;
            }

            .position-title {
                font-size: 1.5rem;
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
                    <h1>Election Results</h1>
                    <p>Live Results</p>
                </div>
            </div>
            <div class="nav-right">
                <div class="nav-user">
                    <p>Results Dashboard</p>
                    <p>Real-time Updates</p>
                </div>
                <form method="POST" action="{{ route('voter.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.1rem; height: 1.1rem;">
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
        <!-- Success Message -->
        @if(session('success'))
            <div class="success-banner">
                <div class="success-icon">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                </div>
                <div class="success-content">
                    <h3>Vote Submitted Successfully</h3>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <div class="header-icon">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h1 class="page-title">Election Results</h1>
            <p class="page-subtitle">Real-time voting results and analytics</p>
        </div>

        <!-- Statistics Summary -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-content">
                    <p>Total Votes Cast</p>
                    <div class="stat-number">{{ $totalVotes }}</div>
                    <div class="stat-description">Registered voters participated</div>
                </div>
                <div class="stat-icon cyan-stat">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <p>Positions</p>
                    <div class="stat-number">{{ $positions->count() }}</div>
                    <div class="stat-description">Voting positions available</div>
                </div>
                <div class="stat-icon emerald-stat">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8c0 1.657-.895 3.09-2.223 3.859V17H8v-5.141C6.895 11.09 6 9.657 6 8a4 4 0 118 0zM8 17v2a1 1 0 001 1h6a1 1 0 001-1v-2"/>
                    </svg>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <p>Participation Rate</p>
                    <div class="stat-number">{{ round(($totalVotes / max($totalVoters, 1)) * 100) }}%</div>
                    <div class="stat-description">Of eligible voters</div>
                </div>
                <div class="stat-icon indigo-stat">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Results by Position -->
        @forelse($positions as $positionIndex => $position)
            <div class="position-section" style="animation-delay: {{ $positionIndex * 0.1 }}s;">
                <!-- Position Header -->
                <div class="position-header">
                    <div class="position-header-content">
                        <div class="position-badges">
                            <div class="position-number">{{ $positionIndex + 1 }}</div>
                            <span class="position-label">Position</span>
                        </div>
                        <h2 class="position-title">{{ $position->position_name }}</h2>
                        @if($position->description)
                            <p class="position-description">{{ $position->description }}</p>
                        @endif
                    </div>
                </div>

                <!-- Results -->
                @php
                    $voteData = $position->voteCount;
                    $maxVotes = $voteData->max('vote_count') ?? 0;
                    $leadingCandidate = $voteData->where('vote_count', $maxVotes)->first();
                @endphp

                <div class="results-space">
                    @if($voteData->count() > 0)
                        @foreach($voteData->sortByDesc('vote_count') as $voteCount)
                            @php
                                $percentage = $maxVotes > 0 ? ($voteCount->vote_count / $maxVotes) * 100 : 0;
                                $isLeading = $voteCount->id === $leadingCandidate?->id;
                            @endphp
                            <div class="candidate-result {{ $isLeading ? 'leading' : '' }}">
                                <div class="candidate-photo">
                                    @if($voteCount->candidate && $voteCount->candidate->imagepath)
                                        <img src="{{ asset('storage/' . $voteCount->candidate->imagepath) }}" alt="{{ $voteCount->candidate->candidate_name }}">
                                    @else
                                        <svg fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="candidate-info">
                                    <h3>{{ $voteCount->candidate->candidate_name ?? 'Abstain' }}</h3>
                                    @if($voteCount->candidate)
                                        <p>{{ $position->position_name }}</p>
                                    @endif
                                </div>
                                <div class="vote-stats">
                                    <div class="vote-count">
                                        <div class="vote-number">{{ $voteCount->vote_count }}</div>
                                        <div class="vote-label">Votes</div>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-label">
                                            <span>Vote Share</span>
                                            <span class="progress-percentage">{{ round($percentage) }}%</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-results">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p>No votes recorded</p>
                            <p>This position has not received any votes yet</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(139, 92, 246, 0.1)); border: 2px solid rgba(99, 102, 241, 0.3); border-radius: 2rem; padding: 4rem 2rem; text-align: center; backdrop-filter: blur(20px);">
                <svg fill="currentColor" viewBox="0 0 24 24" style="width: 4rem; height: 4rem; color: rgba(99, 102, 241, 0.6); margin: 0 auto 1.5rem;">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <h3 style="font-size: 1.5rem; font-weight: 900; color: rgba(165, 243, 252, 0.8); margin-bottom: 0.75rem; font-family: 'Space Grotesk', sans-serif;">No Results Available</h3>
                <p style="color: rgba(165, 243, 252, 0.6); font-size: 1rem;">Results will appear here as votes are submitted</p>
            </div>
        @endforelse

        <!-- Home Button -->
        <div class="home-button-container">
            <form method="POST" action="{{ route('voter.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="home-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Exit & Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>

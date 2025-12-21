<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet the Candidates</title>
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
            line-height: 1.6;
        }

        /* Header */
        .election-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-icon svg {
            width: 20px;
            height: 20px;
            color: #1e3a8a;
        }

        .header-title h1 {
            font-size: 1.25rem;
            font-weight: 700;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .header-title p {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .voter-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .voter-details {
            text-align: right;
        }

        .voter-details p:first-child {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .voter-details p:last-child {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .logout-btn svg {
            width: 16px;
            height: 16px;
        }

        /* Main Content */
        .main-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
        }

        .page-header h1 {
            font-size: 2rem;
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 0.75rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .page-header p {
            color: #64748b;
            font-size: 1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Position Cards */
        .position-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 2.5rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .position-header {
            background: #f1f5f9;
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .position-title-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .position-number {
            background: #2563eb;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .position-title {
            font-size: 1.25rem;
            color: #1e293b;
            font-weight: 600;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .position-description {
            color: #64748b;
            font-size: 0.9rem;
            margin-left: 3rem;
        }

        /* Candidates Grid */
        .candidates-container {
            padding: 1.5rem;
        }

        .candidates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1.5rem;
        }

        .candidate-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .candidate-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            border-color: #cbd5e1;
        }

        .candidate-photo-wrapper {
            height: 160px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .candidate-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #e2e8f0;
        }

        .candidate-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .candidate-photo svg {
            width: 48px;
            height: 48px;
            color: #94a3b8;
        }

        .candidate-info {
            padding: 1.25rem;
            text-align: center;
        }

        .candidate-name {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .candidate-position {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .candidate-party {
            font-size: 0.8rem;
            color: #475569;
            font-style: italic;
            padding-top: 0.5rem;
            border-top: 1px solid #f1f5f9;
        }

        /* Empty States */
        .empty-candidates {
            text-align: center;
            padding: 3rem 1rem;
            color: #64748b;
        }

        .empty-candidates svg {
            width: 48px;
            height: 48px;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .empty-candidates p {
            font-size: 0.95rem;
        }

        .no-positions {
            text-align: center;
            padding: 4rem 1rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .no-positions svg {
            width: 64px;
            height: 64px;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }

        .no-positions h3 {
            font-size: 1.25rem;
            color: #475569;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        /* Voting Button */
        .voting-section {
            text-align: center;
            margin-top: 4rem;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .voting-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 100%);
            color: white;
            text-decoration: none;
            padding: 0.875rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
        }

        .voting-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.3);
        }

        .voting-btn svg {
            width: 18px;
            height: 18px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .voter-info {
                width: 100%;
                justify-content: center;
            }

            .main-container {
                padding: 0 1rem;
            }

            .candidates-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1rem;
            }

            .position-title-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .position-description {
                margin-left: 0;
            }
        }

        @media (max-width: 480px) {
            .candidates-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .voter-info {
                flex-direction: column;
                gap: 1rem;
            }

            .voter-details {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="election-header">
        <div class="header-container">
            <div class="header-brand">
                <div class="header-icon">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div class="header-title">
                    <h1>Election System</h1>
                    <p>Candidate Preview</p>
                </div>
            </div>
            
            <div class="voter-info">
                <div class="voter-details">
                    <p>Hello, {{ session('voter_name') }}</p>
                    <p>Registered Student Voter</p>
                </div>
                <form method="POST" action="{{ route('voter.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Meet the Candidates</h1>
            <p>Review all candidates running for student council positions. Learn about each candidate before casting your vote.</p>
        </div>

        <!-- Positions and Candidates -->
        @forelse($positions as $index => $position)
            <div class="position-card">
                <!-- Position Header -->
                <div class="position-header">
                    <div class="position-title-container">
                        <div class="position-number">{{ $index + 1 }}</div>
                        <h2 class="position-title">{{ $position->position_name }}</h2>
                    </div>
                    @if($position->description)
                        <p class="position-description">{{ $position->description }}</p>
                    @endif
                </div>

                <!-- Candidates -->
                <div class="candidates-container">
                    @if($position->candidates->count() > 0)
                        <div class="candidates-grid">
                            @foreach($position->candidates as $candidate)
                                <div class="candidate-card">
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
                        <div class="empty-candidates">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p>No candidates have registered for this position yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="no-positions">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3>No Positions Available</h3>
                <p>Election positions will be announced soon. Please check back later.</p>
            </div>
        @endforelse

        <!-- Proceed to Voting -->
        @if($positions->count() > 0)
            <div class="voting-section">
                <a href="{{ route('voter.voting') }}" class="voting-btn">
                    <span>Proceed to Voting</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <p style="margin-top: 1rem; color: #64748b; font-size: 0.9rem;">
                    Review all candidates before proceeding to the voting ballot.
                </p>
            </div>
        @endif
    </div>
</body>
</html>
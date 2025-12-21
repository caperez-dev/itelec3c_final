<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Council Election Results</title>
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
            position: sticky;
            top: 0;
            z-index: 100;
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
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-icon svg {
            width: 24px;
            height: 24px;
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

        .voter-details {
            text-align: right;
            margin-right: 1rem;
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

        /* Success Message */
        .success-message {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .success-icon {
            flex-shrink: 0;
            color: #16a34a;
            margin-top: 0.125rem;
        }

        .success-icon svg {
            width: 24px;
            height: 24px;
        }

        .success-content h3 {
            color: #15803d;
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-size: 1rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .success-content p {
            color: #166534;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 1rem 0;
        }

        .page-title {
            font-size: 2rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
            font-weight: 700;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 1rem;
        }

        /* Statistics */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        @media (min-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            text-align: center;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            background: #f1f5f9;
            color: #2563eb;
        }

        .stat-icon svg {
            width: 24px;
            height: 24px;
        }

        .stat-number {
            font-size: 2rem;
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-description {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Position Results */
        .position-section {
            margin-bottom: 3rem;
        }

        .position-header {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
        }

        .position-header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .position-number {
            background: #2563eb;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .position-title {
            font-size: 1.25rem;
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .position-description {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Candidate Results */
        .results-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .candidate-result {
            background: white;
            border-radius: 10px;
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .candidate-result.leading {
            border-color: #2563eb;
            background: #eff6ff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
        }

        .candidate-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .candidate-photo {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
        }

        .candidate-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .candidate-photo svg {
            width: 32px;
            height: 32px;
            color: #94a3b8;
        }

        .candidate-info {
            flex: 1;
        }

        .candidate-info h3 {
            font-size: 1.125rem;
            color: #1e293b;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .candidate-info p {
            color: #64748b;
            font-size: 0.9rem;
        }

        .vote-stats {
            margin-top: 1rem;
        }

        .vote-count {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }

        .vote-number {
            font-size: 1.5rem;
            color: #2563eb;
            font-weight: 700;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .vote-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
        }

        .progress-bar-container {
            flex: 1;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .progress-label span:first-child {
            color: #475569;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .progress-percentage {
            color: #2563eb;
            font-size: 0.875rem;
            font-weight: 700;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .progress-bar {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #2563eb;
            border-radius: 4px;
            transition: width 0.8s ease;
        }

        .leading .progress-fill {
            background: #1d4ed8;
        }

        /* No Results */
        .no-results {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
        }

        .no-results svg {
            width: 48px;
            height: 48px;
            color: #cbd5e1;
            margin: 0 auto 1rem;
        }

        .no-results p:first-of-type {
            font-size: 1.125rem;
            color: #475569;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .no-results p:last-of-type {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            border-color: #94a3b8;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            border: 1px solid #1d4ed8;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1e40af;
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        /* No Positions */
        .no-positions {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        .no-positions svg {
            width: 64px;
            height: 64px;
            color: #cbd5e1;
            margin: 0 auto 1.5rem;
        }

        .no-positions h3 {
            font-size: 1.25rem;
            color: #475569;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .no-positions p {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* My Votes Section */
        .my-votes-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .my-votes-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .my-votes-header svg {
            width: 32px;
            height: 32px;
            color: #2563eb;
        }

        .my-votes-header h2 {
            font-size: 1.5rem;
            color: #1e293b;
            font-weight: 700;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .my-votes-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .my-vote-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .my-vote-photo {
            width: 56px;
            height: 56px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #cbd5e1;
        }

        .my-vote-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .my-vote-photo svg {
            width: 28px;
            height: 28px;
            color: #94a3b8;
        }

        .my-vote-info {
            flex: 1;
        }

        .my-vote-position {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .my-vote-candidate {
            font-size: 1.125rem;
            color: #1e293b;
            font-weight: 600;
        }

        .my-vote-badge {
            background: #2563eb;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .my-vote-badge svg {
            width: 14px;
            height: 14px;
        }

        .no-votes-message {
            text-align: center;
            padding: 2rem;
            color: #64748b;
        }

        .no-votes-message svg {
            width: 48px;
            height: 48px;
            color: #cbd5e1;
            margin: 0 auto 1rem;
        }

        .no-votes-message p {
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 0.75rem;
                text-align: center;
            }

            .main-container {
                padding: 0 1rem;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .position-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .candidate-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .vote-count {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .my-vote-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .my-vote-badge {
                align-self: flex-start;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .candidate-photo {
                width: 56px;
                height: 56px;
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
                    <h1>Election Results</h1>
                    <p>Student Council Election</p>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 1rem;">
                @if(session('voter_name'))
                    <div class="voter-details">
                        <p>Hello, {{ session('voter_name') }}</p>
                        <p>Registered Student Voter</p>
                    </div>
                @endif
                <form method="POST" action="{{ route('voter.logout') }}" style="display: inline;">
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
        <!-- Success Message -->
        @if(session('success'))
            <div class="success-message">
                <div class="success-icon">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                </div>
                <div class="success-content">
                    <h3>Thank You for Voting!</h3>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Election Results</h1>
            <p class="page-subtitle">Live results from the student council election</p>
        </div>

        <!-- Statistics Summary -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="stat-number">{{ $totalVotes }}</div>
                <div class="stat-label">Votes Cast</div>
                <div class="stat-description">Total ballots submitted</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="stat-number">{{ $positions->count() }}</div>
                <div class="stat-label">Positions</div>
                <div class="stat-description">Contested positions</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="stat-number">{{ round(($votedCount / max($totalVoters, 1)) * 100) }}%</div>
                <div class="stat-label">Participation</div>
                <div class="stat-description">Voter turnout rate</div>
            </div>
        </div>

        <!-- My Votes Section -->
        @if(session('voter_id'))
            <div class="my-votes-section">
                <div class="my-votes-header">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h2>My Votes</h2>
                </div>

                @if(isset($myVotes) && $myVotes->count() > 0)
                    <div class="my-votes-list">
                        @foreach($myVotes as $vote)
                            <div class="my-vote-item">
                                <div class="my-vote-photo">
                                    @if($vote->candidate->imagepath)
                                        <img src="{{ asset('storage/' . $vote->candidate->imagepath) }}" alt="{{ $vote->candidate->candidate_name }}">
                                    @else
                                        <svg fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="my-vote-info">
                                    <div class="my-vote-position">{{ $vote->candidate->position->position_name }}</div>
                                    <div class="my-vote-candidate">{{ $vote->candidate->candidate_name }}</div>
                                </div>
                                <div class="my-vote-badge">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    Voted
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-votes-message">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p>No voting record found. You may not have voted yet.</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Results by Position -->
        @forelse($positions as $positionIndex => $position)
            <div class="position-section">
                <!-- Position Header -->
                <div class="position-header">
                    <div class="position-header-content">
                        <div class="position-number">{{ $positionIndex + 1 }}</div>
                        <div>
                            <h2 class="position-title">{{ $position->position_name }}</h2>
                            @if($position->description)
                                <p class="position-description">{{ $position->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Results -->
                @php
                    $candidates = $position->candidates->sortByDesc(function($candidate) {
                        return $candidate->voteCount->vote_count ?? 0;
                    });
                    $maxVotes = $candidates->max(function($candidate) {
                        return $candidate->voteCount->vote_count ?? 0;
                    }) ?? 0;
                    $totalVotesForPosition = $candidates->sum(function($candidate) {
                        return $candidate->voteCount->vote_count ?? 0;
                    });
                @endphp

                <div class="results-container">
                    @if($candidates->count() > 0)
                        @foreach($candidates as $candidate)
                            @php
                                $voteCount = $candidate->voteCount->vote_count ?? 0;
                                $percentage = $totalVotesForPosition > 0 ? ($voteCount / $totalVotesForPosition) * 100 : 0;
                                $isLeading = $voteCount > 0 && $voteCount === $maxVotes;
                            @endphp
                            <div class="candidate-result {{ $isLeading ? 'leading' : '' }}">
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
                                        <h3>{{ $candidate->candidate_name }}</h3>
                                        <p>{{ $position->position_name }}</p>
                                    </div>
                                </div>
                                <div class="vote-stats">
                                    <div class="vote-count">
                                        <div class="vote-number">{{ $voteCount }}</div>
                                        <div class="vote-label">Votes</div>
                                        <div class="progress-percentage">{{ round($percentage) }}%</div>
                                    </div>
                                    <div class="progress-bar-container">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.801 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.801 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                            </svg>
                            <p>No votes recorded</p>
                            <p>This position has not received any votes yet</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="no-positions">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3>No Results Available</h3>
                <p>Election results will appear here once voting begins</p>
            </div>
        @endforelse

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="" class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Return to Dashboard
            </a>
            <form method="POST" action="{{ route('voter.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>
    </div>
</body>
</html>
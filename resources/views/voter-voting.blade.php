<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast Your Vote - Student Election</title>
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
            max-width: 900px;
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
            text-align: right;
        }

        .voter-info p:first-child {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .voter-info p:last-child {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        /* Main Content */
        .main-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1rem 0;
        }

        .page-header h1 {
            font-size: 1.75rem;
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .page-header p {
            color: #64748b;
            font-size: 1rem;
        }

        /* Instructions */
        .instructions-card {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
        }

        .instructions-icon {
            flex-shrink: 0;
            width: 24px;
            height: 24px;
            color: #2563eb;
        }

        .instructions-content h3 {
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .instructions-content p {
            color: #475569;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Error Messages */
        .error-messages {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .error-messages h3 {
            color: #dc2626;
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 1rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .error-messages ul {
            list-style: none;
        }

        .error-messages li {
            color: #dc2626;
            margin-bottom: 0.5rem;
            display: flex;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        /* Voting Form */
        .voting-form {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Position Card */
        .position-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .position-header {
            background: #f1f5f9;
            padding: 1.25rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .position-header-content {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .position-number {
            background: #2563eb;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .position-title-section {
            flex: 1;
        }

        .position-title {
            font-size: 1.15rem;
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .position-description {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Candidates List */
        .candidates-list {
            padding: 1.5rem;
        }

        .candidate-option {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 0.75rem;
            background: white;
        }

        .candidate-option:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .candidate-option.selected {
            border-color: #2563eb;
            background: rgba(37, 99, 235, 0.05);
        }

        .candidate-radio {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            cursor: pointer;
            accent-color: #2563eb;
        }

        .candidate-content {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }

        .candidate-photo {
            width: 56px;
            height: 56px;
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
            width: 28px;
            height: 28px;
            color: #94a3b8;
        }

        .candidate-info h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .candidate-info p {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }

        /* Abstain Option */
        .abstain-option {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border: 1px dashed #94a3b8;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #f8fafc;
        }

        .abstain-option:hover {
            border-color: #64748b;
            background: #f1f5f9;
        }

        .abstain-option.selected {
            border-color: #7c3aed;
            background: rgba(124, 58, 237, 0.05);
        }

        .abstain-option svg {
            width: 20px;
            height: 20px;
            color: #7c3aed;
            flex-shrink: 0;
        }

        .abstain-text {
            font-size: 0.95rem;
            color: #475569;
            flex: 1;
            font-weight: 500;
        }

        /* Confirmation Section */
        .confirmation-section {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .confirmation-checkbox-label {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            cursor: pointer;
        }

        .confirmation-checkbox {
            width: 20px;
            height: 20px;
            min-width: 20px;
            margin-top: 0.15rem;
            cursor: pointer;
            accent-color: #16a34a;
        }

        .confirmation-content h3 {
            font-weight: 600;
            color: #15803d;
            margin-bottom: 0.75rem;
            font-size: 1rem;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .confirmation-items {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .confirmation-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            color: #166534;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .confirmation-item svg {
            width: 16px;
            height: 16px;
            color: #16a34a;
            flex-shrink: 0;
            margin-top: 0.15rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
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
            flex: 1;
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

        .btn-primary:disabled {
            background: #94a3b8;
            border-color: #64748b;
            cursor: not-allowed;
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        /* No Positions */
        .no-positions {
            text-align: center;
            padding: 3rem 1rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        .no-positions p {
            font-size: 1rem;
            color: #475569;
            font-weight: 600;
            font-family: 'Source Sans Pro', sans-serif;
        }

        /* Progress Indicator */
        .progress-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .progress-number {
            background: #2563eb;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .progress-text {
            font-size: 0.9rem;
            color: #475569;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 0.75rem;
                text-align: center;
            }

            .voter-info {
                text-align: center;
            }

            .main-container {
                padding: 0 1rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .candidate-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .candidate-photo {
                width: 48px;
                height: 48px;
            }
        }

        @media (max-width: 480px) {
            .page-header h1 {
                font-size: 1.5rem;
            }

            .position-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .candidates-list {
                padding: 1rem;
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
                    <p>Cast your vote</p>
                </div>
            </div>
            <div class="voter-info">
                <p>{{ session('voter_firstname') }} {{ session('voter_lastname') }}</p>
                <p>Registered Voter</p>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Cast Your Vote</h1>
            <p>Select your preferred candidate for each position</p>
        </div>

        <!-- Progress Indicator -->
        <div class="progress-indicator">
            <div class="progress-number">{{ $positions->count() > 0 ? 1 : 0 }}</div>
            <div class="progress-text">Reviewing {{ $positions->count() }} position(s)</div>
        </div>

        <!-- Instructions -->
        <div class="instructions-card">
            <svg class="instructions-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="instructions-content">
                <h3>Voting Instructions</h3>
                <p>Select one candidate per position, or choose to abstain. You may review your selections before submitting. Once submitted, your vote is final and cannot be changed.</p>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="error-messages">
                <h3>Please correct the following errors:</h3>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Voting Form -->
        <form method="POST" action="{{ route('voter.submit-vote') }}" class="voting-form" id="votingForm">
            @csrf

            @forelse($positions as $index => $position)
                <div class="position-card">
                    <div class="position-header">
                        <div class="position-header-content">
                            <div class="position-number">{{ $index + 1 }}</div>
                            <div class="position-title-section">
                                <h2 class="position-title">{{ $position->position_name }}</h2>
                                @if($position->description)
                                    <p class="position-description">{{ $position->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="candidates-list">
                        @if($position->candidates->count() > 0)
                            @foreach($position->candidates as $candidate)
                                <label class="candidate-option" data-position="{{ $position->position_id }}">
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
                        <label class="abstain-option" data-position="{{ $position->position_id }}">
                            <input 
                                type="radio" 
                                name="votes[{{ $position->position_id }}]" 
                                value="abstain"
                                {{ old('votes.' . $position->position_id) == 'abstain' ? 'checked' : '' }}
                                class="candidate-radio"
                                data-position-id="{{ $position->position_id }}"
                                data-candidate-id="abstain"
                            />
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span class="abstain-text">Abstain from this position</span>
                        </label>
                    </div>
                </div>
            @empty
                <div class="no-positions">
                    <p>No positions available for voting at this time.</p>
                </div>
            @endforelse

            <!-- Confirmation Section -->
            @if($positions->count() > 0)
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
                                    <span>I understand my vote is final</span>
                                </div>
                                <div class="confirmation-item">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    <span>I am voting voluntarily</span>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('voter.candidates') }}" class="btn btn-secondary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Review Candidates
                    </a>
                    <button 
                        type="submit"
                        onclick="return confirmSubmission();"
                        class="btn btn-primary"
                        id="submitBtn"
                    >
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        Submit Vote
                    </button>
                </div>
            @endif
        </form>
    </div>

    <script>
        // Highlight selected options
        document.addEventListener('DOMContentLoaded', function() {
            // Update visual state when radio buttons change
            document.querySelectorAll('input[type="radio"][name^="votes"]').forEach(radio => {
                // Set initial state
                updateOptionState(radio);
                
                // Update on change
                radio.addEventListener('change', function() {
                    updateOptionState(this);
                });
            });
            
            function updateOptionState(radio) {
                const label = radio.closest('label');
                const positionId = radio.getAttribute('data-position-id');
                
                // Remove selected class from all options in this position
                document.querySelectorAll(`label[data-position="${positionId}"]`).forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add selected class to this option if checked
                if (radio.checked) {
                    label.classList.add('selected');
                }
            }
            
            // Enable/disable submit button based on confirmation checkbox
            const confirmationCheckbox = document.getElementById('confirmation');
            const submitBtn = document.getElementById('submitBtn');
            
            if (confirmationCheckbox && submitBtn) {
                confirmationCheckbox.addEventListener('change', function() {
                    // In a real implementation, you might want to check if all positions have votes
                    // For now, just enable/disable based on confirmation
                    submitBtn.disabled = !this.checked;
                });
                
                // Initial state
                submitBtn.disabled = !confirmationCheckbox.checked;
            }
        });
        
        function confirmSubmission() {
            // Check if confirmation is checked
            const confirmationCheckbox = document.getElementById('confirmation');
            if (!confirmationCheckbox || !confirmationCheckbox.checked) {
                alert('Please confirm your vote by checking the confirmation box.');
                return false;
            }
            
            // Count selected votes
            const selectedVotes = document.querySelectorAll('input[type="radio"][name^="votes"]:checked').length;
            const totalPositions = {{ $positions->count() }};
            
            if (selectedVotes !== totalPositions) {
                return confirm('You have not voted for all positions. Are you sure you want to submit? You can choose to abstain for specific positions.');
            }
            
            return confirm('Are you sure you want to submit your vote? This action cannot be undone.');
        }
        
        // Save progress in localStorage
        document.addEventListener('DOMContentLoaded', function() {
            // Restore saved selections
            document.querySelectorAll('input[type="radio"][name^="votes"]').forEach(radio => {
                const positionId = radio.getAttribute('data-position-id');
                const saved = localStorage.getItem(`vote_${positionId}`);
                
                if (saved && radio.value === saved) {
                    radio.checked = true;
                    updateOptionState(radio);
                }
            });
            
            // Save on change
            document.querySelectorAll('input[type="radio"][name^="votes"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const positionId = this.getAttribute('data-position-id');
                    if (this.checked) {
                        localStorage.setItem(`vote_${positionId}`, this.value);
                    }
                });
            });
            
            // Clear on form submit
            document.getElementById('votingForm').addEventListener('submit', function() {
                document.querySelectorAll('input[type="radio"][name^="votes"]').forEach(radio => {
                    const positionId = radio.getAttribute('data-position-id');
                    localStorage.removeItem(`vote_${positionId}`);
                });
            });
        });
        
        function updateOptionState(radio) {
            const label = radio.closest('label');
            const positionId = radio.getAttribute('data-position-id');
            
            // Remove selected class from all options in this position
            document.querySelectorAll(`label[data-position="${positionId}"]`).forEach(opt => {
                opt.classList.remove('selected');
            });
            
            // Add selected class to this option if checked
            if (radio.checked) {
                label.classList.add('selected');
            }
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="voting-system.css">
    <style>
        body {
            background-color: #f0f4f8;
        }

        .sidebar-color {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
        }
        
        .dashboard-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 40px;
            border-top: 5px solid #1e40af;
        }
        
        h1 {
            color: #1e40af;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
            border-left: 4px solid #1e40af;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .stat-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .stat-card-primary {
            border-left-color: #1e40af;
        }
        
        .stat-card-primary .stat-card-icon {
            background-color: #e0e7ff;
            color: #1e40af;
        }
        
        .stat-card-success {
            border-left-color: #059669;
        }
        
        .stat-card-success .stat-card-icon {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .stat-card-warning {
            border-left-color: #d97706;
        }
        
        .stat-card-warning .stat-card-icon {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .stat-card-info {
            border-left-color: #0891b2;
        }
        
        .stat-card-info .stat-card-icon {
            background-color: #cffafe;
            color: #0891b2;
        }
        
        .stat-card-title {
            font-size: 0.875rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }
        
        .stat-card-description {
            font-size: 0.875rem;
            color: #64748b;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .status-active, .status-ongoing {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-inactive, .status-ended {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-on-hold {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .election-status-card {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .election-status-card h3 {
            color: white;
            margin-bottom: 20px;
        }

        .election-controls {
            margin-top: 30px;
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .election-control-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            margin-right: 10px;
            margin-bottom: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-start {
            background-color: #059669;
            color: white;
        }

        .btn-start:hover {
            background-color: #047857;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(5, 150, 105, 0.3);
        }

        .btn-pause {
            background-color: #d97706;
            color: white;
        }

        .btn-pause:hover {
            background-color: #b45309;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(217, 119, 6, 0.3);
        }

        .btn-resume {
            background-color: #0891b2;
            color: white;
        }

        .btn-resume:hover {
            background-color: #0e7490;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(8, 145, 178, 0.3);
        }

        .btn-end {
            background-color: #dc2626;
            color: white;
        }

        .btn-end:hover {
            background-color: #b91c1c;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3);
        }
        
        .quick-actions {
            margin-top: 30px;
        }
        
        .quick-action-btn {
            background-color: #1e40af;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        
        .quick-action-btn:hover {
            background-color: #1e3a8a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .section-divider {
            margin: 40px 0;
            border-top: 2px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="d-flex">
    <div class="sidebar-color text-white p-3 p-md-4" style="width: 250px; height: auto; min-height: 100vh;">
        <div class="sticky-top pt-2">
            <div>
                <img src="{{ asset('Logowithtext.png') }}" alt="CICSelect" style="width: 200px; height: auto;">
            </div>
            <hr class="my-3">
            @if(Auth::check())
            <div class="mb-3 px-3">
                <div class="fw-bold">{{ Auth::user()->name }}</div>
                <div class="small text-white-50">Role: {{ Auth::user()->role }}</div>
            </div>
            @endif
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ url('/dashboard') }}" class="nav-link text-white active py-3 px-3 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF" class="me-2"><path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
                        <b>Dashboard</b>
                    </a>
                </li>
                @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="nav-item mb-2">
                    <a href="{{ url('/voters') }}" class="nav-link text-white py-3 px-3 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF" class="me-2"><path d="M40-160v-160q0-34 23.5-57t56.5-23h131q20 0 38 10t29 27q29 39 71.5 61t90.5 22q49 0 91.5-22t70.5-61q13-17 30.5-27t36.5-10h131q34 0 57 23t23 57v160H640v-91q-35 25-75.5 38T480-200q-43 0-84-13.5T320-252v92H40Zm440-160q-38 0-72-17.5T351-386q-17-25-42.5-39.5T253-440q22-37 93-58.5T480-520q63 0 134 21.5t93 58.5q-29 0-55 14.5T609-386q-22 32-56 49t-73 17ZM160-440q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T280-560q0 50-34.5 85T160-440Zm640 0q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T920-560q0 50-34.5 85T800-440ZM480-560q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-680q0 50-34.5 85T480-560Z"/></svg>
                        <b>Voters</b>
                    </a>
                </li>
                @endif
                <li class="nav-item mb-2">
                    <a href="{{ url('/display-candidates') }}" class="nav-link text-white py-3 px-3 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF" class="me-2"><path d="M480-440q-66 0-113-47t-47-113v-140q0-25 17.5-42.5T380-800q15 0 28.5 7t21.5 20q8-13 21.5-20t28.5-7q15 0 28.5 7t21.5 20q8-13 21.5-20t28.5-7q25 0 42.5 17.5T640-740v140q0 66-47 113t-113 47Zm0-80q33 0 56.5-23.5T560-600v-100H400v100q0 33 23.5 56.5T480-520ZM160-120v-112q0-34 17.5-62.5T224-338q62-31 126-46.5T480-400q66 0 130 15.5T736-338q29 15 46.5 43.5T800-232v112H160Zm80-80h480v-32q0-11-5.5-20T700-266q-54-27-109-40.5T480-320q-56 0-111 13.5T260-266q-9 5-14.5 14t-5.5 20v32Zm240 0Zm0-500Z"/></svg>    
                        <b>Candidates</b>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ url('/display-votes') }}" class="nav-link text-white py-3 px-3 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF" class="me-2"><path d="M200-80q-33 0-56.5-23.5T120-160v-182l110-125 57 57-80 90h546l-78-88 57-57 108 123v182q0 33-23.5 56.5T760-80H200Zm0-80h560v-80H200v80Zm225-225L284-526q-23-23-22.5-56.5T285-639l196-196q23-23 57-24t57 22l141 141q23 23 24 56t-22 56L538-384q-23 23-56.5 22.5T425-385Zm255-254L539-780 341-582l141 141 198-198ZM200-160v-80 80Z"/></svg>    
                        <b>Votes</b>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ url('display-positions') }}" class="nav-link text-white py-3 px-3 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF" class="me-2"><path d="M557-518 387-688l57-56 113 113 227-226 56 56-283 283ZM320-220l278 76 238-74q-5-9-14.5-15.5T800-240H598q-27 0-43-2t-33-8l-93-31 22-78 81 27q17 5 40 8t68 4q0-11-6.5-21T618-354l-234-86h-64v220ZM80-80v-440h304q7 0 14 1.5t13 3.5l235 87q33 12 53.5 42t20.5 66h80q50 0 85 33t35 87v40L600-60l-280-78v58H80Zm80-80h80v-280h-80v280Z"/></svg>
                        <b>Position</b>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ url('display-vote-counts') }}" class="nav-link text-white py-3 px-3 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF" class="me-2"><path d="M480-360h120q33 0 56.5-23.5T680-440v-240q0-33-23.5-56.5T600-760h-80q-33 0-56.5 23.5T440-680v80q0 33 23.5 56.5T520-520h80v80H480v80Zm120-240h-80v-80h80v80ZM320-240q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z"/></svg>    
                        <b>Vote Counts</b>
                    </a>
                </li>
                @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="nav-item mb-2">
                    <a href="{{ route('logs.display') }}" class="nav-link text-white py-3 px-3 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF" class="me-2"><path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
                        <b>Activity Logs</b>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ url('/settings') }}" class="nav-link text-white py-3 px-3 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF" class="me-2"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
                        <b>Settings</b>
                    </a>
                </li>
                @endif
            </ul>
            
            <div class="mt-5 pt-3 border-top">
                <form method="POST" action="{{ route('logout') }}" style="display: block;">
                    @csrf
                    <button type="submit" class="nav-link text-white py-3 px-3 rounded w-100 text-start" style="background: none; border: none; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF" class="me-2"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                        <b>Logout</b>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 40px;">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
                <div class="dashboard-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="mb-0"><i class="fas fa-chart-line me-2"></i>Dashboard</h1>
                    </div>
                    
                    <!-- Statistics Cards Row 1 -->
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="stat-card stat-card-primary">
                                <div class="stat-card-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-card-title">Registered Voters</div>
                                <div class="stat-card-value">{{ $registeredVoters ?? '0' }}</div>
                                <div class="stat-card-description">Total registered voters</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <div class="stat-card stat-card-success">
                                <div class="stat-card-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-card-title">Voted Users</div>
                                <div class="stat-card-value">{{ $votedUsers ?? '0' }}</div>
                                <div class="stat-card-description">Users who have voted</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <div class="stat-card stat-card-warning">
                                <div class="stat-card-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="stat-card-title">Total Candidates</div>
                                <div class="stat-card-value">{{ $totalCandidates ?? '0' }}</div>
                                <div class="stat-card-description">Running for positions</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <div class="stat-card stat-card-info">
                                <div class="stat-card-icon">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="stat-card-title">Total Positions</div>
                                <div class="stat-card-value">{{ $totalPositions ?? '0' }}</div>
                                <div class="stat-card-description">Available positions</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section-divider"></div>
                    
                    <!-- Election Status Card -->
                    <div class="row">
                        <div class="col-12">
                            <div class="election-status-card">
                                <h3><i class="fas fa-vote-yea me-2"></i>Election Status</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="mb-2">Current Status:</h4>
                                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $electionStatus ?? 'pending')) }}">
                                            {{ ucfirst($electionStatus ?? 'pending') }}
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <div class="mb-2">
                                            <small class="d-block opacity-75">Voter Turnout</small>
                                            <h3 class="mb-0">{{ $voterTurnout ?? '0' }}%</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Election Control Buttons -->
                    @unless(Auth::check() && Auth::user()->role === 'organizer')
                    <div class="election-controls">
                        <h3 class="mb-3" style="color: #1e40af;"><i class="fas fa-sliders-h me-2"></i>Election Controls</h3>
                        <div>
                            @if(strtolower($electionStatus ?? 'pending') === 'pending')
                                <!-- Show only Start Election button when status is Pending -->
                                <form action="{{ route('election.start') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="election-control-btn btn-start">
                                        <i class="fas fa-play"></i>
                                        Start Election
                                    </button>
                                </form>
                            @elseif(strtolower($electionStatus ?? 'pending') === 'ongoing')
                                <!-- Show Pause and End buttons when status is Ongoing -->
                                <form action="{{ route('election.pause') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="election-control-btn btn-pause">
                                        <i class="fas fa-pause"></i>
                                        Pause Election
                                    </button>
                                </form>

                                <form action="{{ route('election.end') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="election-control-btn btn-end" onclick="return confirm('Are you sure you want to end the election? This action cannot be undone.')">
                                        <i class="fas fa-stop"></i>
                                        End Election
                                    </button>
                                </form>
                            @elseif(strtolower($electionStatus ?? 'pending') === 'on hold')
                                <!-- Show Resume and End buttons when status is On Hold -->
                                <form action="{{ route('election.resume') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="election-control-btn btn-resume">
                                        <i class="fas fa-play-circle"></i>
                                        Resume Election
                                    </button>
                                </form>

                                <form action="{{ route('election.end') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="election-control-btn btn-end" onclick="return confirm('Are you sure you want to end the election? This action cannot be undone.')">
                                        <i class="fas fa-stop"></i>
                                        End Election
                                    </button>
                                </form>
                            @else
                                <!-- Election has ended or other status -->
                                <p class="text-muted mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Election has ended. No controls available.
                                </p>
                            @endif
                        </div>
                    </div>
                    @endunless
                    
                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <h3 class="mb-3" style="color: #1e40af;"><i class="fas fa-bolt me-2"></i>Quick Actions</h3>
                        <div>
                            <a href="{{ url('/voters') }}" class="quick-action-btn">
                                <i class="fas fa-users"></i>
                                View Voters
                            </a>
                            <a href="{{ route('register.voter') }}" class="quick-action-btn">
                                <i class="fas fa-user-plus"></i>
                                Register New Voter
                            </a>
                            <a href="{{ url('/display-candidates') }}" class="quick-action-btn">
                                <i class="fas fa-user-tie"></i>
                                Manage Candidates
                            </a>
                            <a href="{{ url('/display-votes') }}" class="quick-action-btn">
                                <i class="fas fa-vote-yea"></i>
                                View Votes
                            </a>
                            <a href="{{ url('display-vote-counts') }}" class="quick-action-btn">
                                <i class="fas fa-chart-bar"></i>
                                Vote Results
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
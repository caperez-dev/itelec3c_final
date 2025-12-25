<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f4f8;
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
        
        .danger-zone {
            background-color: #fee2e2;
            border-radius: 10px;
            padding: 30px;
            border-left: 4px solid #dc2626;
            margin-top: 30px;
        }
        
        .danger-zone h3 {
            color: #991b1b;
            margin-bottom: 20px;
        }
        
        .danger-zone p {
            color: #7f1d1d;
            margin-bottom: 20px;
        }
        
        .danger-zone ul {
            color: #7f1d1d;
            margin-bottom: 20px;
        }
        
        .danger-zone ul li {
            margin-bottom: 8px;
        }
        
        .btn-danger-custom {
            background-color: #dc2626;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-danger-custom:hover {
            background-color: #b91c1c;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3);
        }
        
        .btn-danger-custom:disabled {
            background-color: #94a3b8;
            color: white;
            cursor: not-allowed;
            opacity: 0.6;
            transform: none;
            box-shadow: none;
        }
        
        .warning-icon {
            font-size: 48px;
            color: #dc2626;
            margin-bottom: 15px;
        }
        
        .election-status-alert {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            color: #92400e;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .election-status-alert i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    @php
        // Ensure the view knows the current election status (id = 1)
        $election = \App\Models\Election::find(1);
        $electionStatus = $election ? $election->status : 'Pending';
    @endphp
    <!-- Sidebar -->
    <div class="d-flex">
    <div class="bg-dark text-white p-4" style="width: 250px; height: 100vh;">
        <h4 class="text-center">Election System</h4>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link text-white">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
                Dashboard</a></li>
            <li class="nav-item">
                <a href="{{ url('/voters') }}" class="nav-link text-white">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M40-160v-160q0-34 23.5-57t56.5-23h131q20 0 38 10t29 27q29 39 71.5 61t90.5 22q49 0 91.5-22t70.5-61q13-17 30.5-27t36.5-10h131q34 0 57 23t23 57v160H640v-91q-35 25-75.5 38T480-200q-43 0-84-13.5T320-252v92H40Zm440-160q-38 0-72-17.5T351-386q-17-25-42.5-39.5T253-440q22-37 93-58.5T480-520q63 0 134 21.5t93 58.5q-29 0-55 14.5T609-386q-22 32-56 49t-73 17ZM160-440q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T280-560q0 50-34.5 85T160-440Zm640 0q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T920-560q0 50-34.5 85T800-440ZM480-560q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-680q0 50-34.5 85T480-560Z"/></svg>
                Voters</a></li>
            <li class="nav-item">
                <a href="{{ url('/display-candidates') }}" class="nav-link text-white">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M480-440q-66 0-113-47t-47-113v-140q0-25 17.5-42.5T380-800q15 0 28.5 7t21.5 20q8-13 21.5-20t28.5-7q15 0 28.5 7t21.5 20q8-13 21.5-20t28.5-7q25 0 42.5 17.5T640-740v140q0 66-47 113t-113 47Zm0-80q33 0 56.5-23.5T560-600v-100H400v100q0 33 23.5 56.5T480-520ZM160-120v-112q0-34 17.5-62.5T224-338q62-31 126-46.5T480-400q66 0 130 15.5T736-338q29 15 46.5 43.5T800-232v112H160Zm80-80h480v-32q0-11-5.5-20T700-266q-54-27-109-40.5T480-320q-56 0-111 13.5T260-266q-9 5-14.5 14t-5.5 20v32Zm240 0Zm0-500Z"/></svg>    
                Candidates</a></li>
            <li class="nav-item">
                <a href="{{ url('/display-votes') }}" class="nav-link text-white">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M200-80q-33 0-56.5-23.5T120-160v-182l110-125 57 57-80 90h546l-78-88 57-57 108 123v182q0 33-23.5 56.5T760-80H200Zm0-80h560v-80H200v80Zm225-225L284-526q-23-23-22.5-56.5T285-639l196-196q23-23 57-24t57 22l141 141q23 23 24 56t-22 56L538-384q-23 23-56.5 22.5T425-385Zm255-254L539-780 341-582l141 141 198-198ZM200-160v-80 80Z"/></svg>    
                Votes</a></li>
            <li class="nav-item">
                <a href="{{ url('display-positions') }}" class="nav-link text-white">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M557-518 387-688l57-56 113 113 227-226 56 56-283 283ZM320-220l278 76 238-74q-5-9-14.5-15.5T800-240H598q-27 0-43-2t-33-8l-93-31 22-78 81 27q17 5 40 8t68 4q0-11-6.5-21T618-354l-234-86h-64v220ZM80-80v-440h304q7 0 14 1.5t13 3.5l235 87q33 12 53.5 42t20.5 66h80q50 0 85 33t35 87v40L600-60l-280-78v58H80Zm80-80h80v-280h-80v280Z"/></svg>
                Position</a></li>
            <li class="nav-item"><a href="{{ url('display-vote-counts') }}" class="nav-link text-white">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M480-360h120q33 0 56.5-23.5T680-440v-240q0-33-23.5-56.5T600-760h-80q-33 0-56.5 23.5T440-680v80q0 33 23.5 56.5T520-520h80v80H480v80Zm120-240h-80v-80h80v80ZM320-240q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z"/></svg>    
                Vote Counts</a></li>
            <li class="nav-item">
                <a href="{{ route('logs.display') }}" class="nav-link text-white active">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
                Activity Logs</a></li>
            <li class="nav-item">
                <a href="{{ url('/settings') }}" class="nav-link text-white active">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
                Settings</a></li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link text-white" style="background: none; border: none; padding: 0; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
    <div class="container" style="padding-top: 40px;">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
                <div class="dashboard-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="mb-0"><i class="fas fa-cog me-2"></i>Settings</h1>
                    </div>
                    
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <!-- Election Status Warning -->
                    @php $status = strtolower(trim($electionStatus ?? 'pending')); @endphp
                    @if(!in_array($status, ['pending', 'ended']))
                        <div class="election-status-alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Hard Reset Disabled:</strong> The hard reset function is locked because the election status is currently "<strong>{{ ucfirst($electionStatus) }}</strong>".
                            To perform a hard reset, the election must be in "Pending" or "Ended" status.
                        </div>
                    @endif
                    
                    <!-- Danger Zone - Hard Reset -->
                    <div class="danger-zone">
                        <div class="text-center">
                            <i class="fas fa-exclamation-triangle warning-icon"></i>
                        </div>
                        <h3><i class="fas fa-radiation me-2"></i>Danger Zone</h3>
                        <p><strong>Warning:</strong> This action is extremely destructive and cannot be undone!</p>
                        
                        <p>Hard resetting the election will permanently:</p>
                        <ul>
                            <li><strong>Delete all candidates</strong> from the database</li>
                            <li><strong>Delete all vote counts</strong> from the database</li>
                            <li><strong>Delete all votes</strong> from the database</li>
                            <li><strong>Reset election status</strong> to "Pending"</li>
                            <li><strong>Reset all voters' voting status</strong> (has_voted = 0)</li>
                        </ul>
                        
                        <p class="mb-3">
                            <strong>This will allow you to start a completely fresh election.</strong> 
                            All voting data will be lost permanently.
                        </p>
                                                
                        @if(in_array(strtolower(trim($electionStatus ?? 'pending')), ['pending', 'ended']))
                            <form action="{{ route('election.hard-reset') }}" method="POST" onsubmit="return confirm('⚠️ FINAL WARNING ⚠️\n\nAre you absolutely sure you want to HARD RESET the entire election system?\n\nThis will PERMANENTLY DELETE:\n- All Candidates\n- All Votes\n- All Vote Counts\n- Reset Election Status\n- Reset All Voter Status\n\nThis action CANNOT be undone!\n\nType YES in the prompt to confirm.');">
                                @csrf
                                <button type="submit" class="btn-danger-custom">
                                    <i class="fas fa-skull-crossbones"></i>
                                    Hard Reset Election System
                                </button>
                            </form>
                        @else
                            <button class="btn-danger-custom" disabled title="Election must be in Pending status to perform hard reset">
                                <i class="fas fa-skull-crossbones"></i>
                                Hard Reset Election System (Locked)
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
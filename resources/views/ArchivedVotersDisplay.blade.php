<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Voters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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

        .btn-action:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="d-flex">
    <div class="bg-dark text-white p-4" style="width: 250px; height: 100vh;">
        <h4 class="text-center">Election System</h4>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link text-white active">
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
                <a href="{{ url('/settings') }}" class="nav-link text-white active">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
                Settings</a></li>
        </ul>
    </div>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><i class="fas fa-archive me-2"></i>Archived Voters</h3>
        <a href="{{ url('/voters') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i>View Active Voters
        </a>
    </div>
    
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
    @if(strtolower($electionStatus ?? 'pending') !== 'pending')
        <div class="election-status-alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Actions Disabled:</strong> Voter restoration and permanent deletion are locked because the election status is currently "<strong>{{ ucfirst($electionStatus) }}</strong>". 
            Only viewing is available. To restore or permanently delete voters, the election must be in "Pending" status.
        </div>
    @endif
    
    <form action="{{ url('/display-archived-voters') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="Search archived voter..." value="{{ request('search') }}" autocomplete="off">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search me-1"></i>Search
            </button>
        </div>
    </form>
    
    @if($voters->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Voter Key</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Deleted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voters as $voter)
                    <tr>
                        <td>{{ $voter->voter_id }}</td>
                        <td><code>{{ $voter->voter_key }}</code></td>
                        <td>{{ $voter->first_name }}</td>
                        <td>{{ $voter->last_name }}</td>
                        <td>{{ $voter->gender }}</td>
                        <td>{{ $voter->contact_information }}</td>
                        <td>{{ $voter->deleted_at->format('M d, Y h:i A') }}</td>
                        <td>
                            @if(strtolower($electionStatus ?? 'pending') === 'pending')
                                <form action="{{ url('restore-voter/'.$voter->voter_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success mb-1" onclick="return confirm('Are you sure you want to restore this voter?')">
                                        <i class="fas fa-undo me-1"></i>Restore
                                    </button>
                                </form>
                                <form action="{{ url('force-delete-voter/'.$voter->voter_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure you want to PERMANENTLY delete this voter? This action cannot be undone!')">
                                        <i class="fas fa-trash-alt me-1"></i>Delete
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-success mb-1 btn-action" disabled title="Election must be in Pending status">
                                    <i class="fas fa-undo me-1"></i>Restore
                                </button>
                                <button class="btn btn-sm btn-danger mb-1 btn-action" disabled title="Election must be in Pending status">
                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i>No archived voters found.
        </div>
    @endif
</div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
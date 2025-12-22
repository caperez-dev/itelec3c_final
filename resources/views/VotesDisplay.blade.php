<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f4f8;
        }
        
        .voter-container {
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
        
        .table-header {
            background-color: #1e40af;
            color: black;
        }
        .table-header a {
            color: black !important;
            text-decoration: none;
        }
        .table-header a:hover {
            color: black !important;
            text-decoration: none;
        }
        
        .btn-register {
            background-color: #1e40af;
            color: white;
            padding: 10px 30px;
            border: none;
            text-decoration: none;
        }
        
        .btn-register:hover {
            background-color: #1e3a8a;
            color: white;
        }
        
        .voter-badge {
            background-color: #e0e7ff;
            color: #1e40af;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .alert {
            margin-bottom: 20px;
        }
        
        .btn-view {
            color: #1e40af;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0;
            font-size: 1.2rem;
        }
        
        .btn-view:hover {
            color: #1e3a8a;
        }
        
        .modal-header {
            background-color: #1e40af;
            color: white;
        }
        
        .info-label {
            font-weight: 600;
            color: #1e40af;
        }
        
        /* Pagination Styles */
        .pagination {
            margin-top: 20px;
            justify-content: center;
        }
        
        .pagination .page-link {
            color: #1e40af;
            border: 1px solid #1e40af;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #1e40af;
            border-color: #1e40af;
            color: white;
        }
        
        .pagination .page-link:hover {
            background-color: #e0e7ff;
            color: #1e40af;
        }
        
        .pagination-info {
            text-align: center;
            color: #64748b;
            margin-top: 10px;
            font-size: 0.9rem;
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
    <div class="container" style="padding-top: 40px;">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
                <div class="voter-container">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="mb-0">Votes List</h1>
                    </div>
                    <!-- Search bar + Filter + Export Button -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <form action="{{ url('/display-votes') }}" method="GET" class="flex-grow-1 me-3">
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="Search vote..." value="{{ request('search') }}" autocomplete="off">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button id="voteFilterBtn" type="button" class="btn btn-outline-secondary ms-2" data-bs-toggle="collapse" data-bs-target="#voteFilters" aria-expanded="false" aria-controls="voteFilters">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                            <div class="collapse mt-3 @if(request('applied_from') || request('applied_to')) show @endif" id="voteFilters">
                                <div class="card card-body p-3">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label small">Voted From</label>
                                            <input type="date" name="applied_from" class="form-control" value="{{ request('applied_from') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small">Voted To</label>
                                            <input type="date" name="applied_to" class="form-control" value="{{ request('applied_to') }}">
                                        </div>
                                    </div>
                                    <div class="mt-3 text-end">
                                        <a href="{{ url('/display-votes') }}" class="btn btn-secondary">Reset</a>
                                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Export PDF Button -->
                        <div class="d-flex flex-column align-items-end gap-2">
                            <a href="{{ route('votes.export.pdf', request()->all()) }}" class="btn btn-success" title="Export current view to PDF">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
                        </div>
                    </div>
                    @if($votes->total() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-header">
                                    <tr>
                                        <th scope="col">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'vote_id', 'sort_dir' => (request('sort_by') == 'vote_id' && request('sort_dir') == 'asc') ? 'desc' : 'asc']) }}" class="text-white text-decoration-none">
                                                Vote ID
                                                @if(request('sort_by') == 'vote_id')
                                                    <i class="fas fa-sort-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @else
                                                    <i class="fas fa-sort ms-1"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'last_name', 'sort_dir' => (request('sort_by') == 'last_name' && request('sort_dir') == 'asc') ? 'desc' : 'asc']) }}" class="text-white text-decoration-none">
                                                Voter Name
                                                @if(request('sort_by') == 'last_name')
                                                    <i class="fas fa-sort-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @else
                                                    <i class="fas fa-sort ms-1"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'candidate_name', 'sort_dir' => (request('sort_by') == 'candidate_name' && request('sort_dir') == 'asc') ? 'desc' : 'asc']) }}" class="text-white text-decoration-none">
                                                Candidate Voted
                                                @if(request('sort_by') == 'candidate_name')
                                                    <i class="fas fa-sort-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @else
                                                    <i class="fas fa-sort ms-1"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_dir' => (request('sort_by') == 'created_at' && request('sort_dir') == 'asc') ? 'desc' : 'asc']) }}" class="text-white text-decoration-none">
                                                Voted Date
                                                @if(request('sort_by') == 'created_at')
                                                    <i class="fas fa-sort-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @else
                                                    <i class="fas fa-sort ms-1"></i>
                                                @endif
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($votes as $vote)
                                    <tr>
                                        <th scope="row">{{ $vote->vote_id }}</th>
                                        <td class="fw-semibold">{{ $vote->first_name }} {{ $vote->last_name }}</td>
                                        <td>{{ $vote->candidate_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($vote->created_at)->format('M d, Y') }}</td>
                                    </tr>
                                    
                                    <!-- Modal for this vote -->
                                    <div class="modal fade" id="voteModal{{ $vote->vote_id }}" tabindex="-1" aria-labelledby="voteModalLabel{{ $vote->vote_id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="voteModalLabel{{ $vote->vote_id }}">
                                                        <i class="fas fa-vote-yea me-2"></i>Vote Details
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <p class="info-label mb-1">Vote ID:</p>
                                                            <p>{{ $vote->vote_id }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <p class="info-label mb-1">Voter Name:</p>
                                                            <p>{{ $vote->first_name }} {{ $vote->last_name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <p class="info-label mb-1">Candidate Voted:</p>
                                                            <p><span class="voter-badge">{{ $vote->candidate_name }}</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p class="info-label mb-1">Voted Date:</p>
                                                            <p>{{ \Carbon\Carbon::parse($vote->created_at)->format('F d, Y - h:i A') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <!-- Pagination Links -->
                            <div class="pagination-wrapper">
                                {{ $votes->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="mb-3">🗳️</div>
                            <h4>No Votes Recorded Yet</h4>
                            <p class="mb-4">Votes will appear here once voters start casting their ballots.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz4YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        // Fallback: toggle collapse class if Bootstrap data API isn't initialized or JS errors occur
        (function(){
            try{
                var btn = document.getElementById('voteFilterBtn');
                var panel = document.getElementById('voteFilters');
                if(btn && panel){
                    btn.addEventListener('click', function(e){
                        // if Bootstrap handled it, this will just toggle too; safe fallback
                        e.preventDefault();
                        panel.classList.toggle('show');
                    });
                }
            }catch(err){
                // silent
            }
        })();
    </script>
</body>
</html>
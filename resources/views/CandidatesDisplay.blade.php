<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f4f8;
        }
        
        .candidate-container {
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
            color: white;
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
        
        .candidate-badge {
            background-color: #e0e7ff;
            color: #1e40af;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        .party-badge {
            background-color: #fef3c7;
            color: #92400e;
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
        
        .btn-action {
            padding: 5px 10px;
            font-size: 0.875rem;
            margin: 0 2px;
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
        
        .candidate-image-modal {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 3px solid #1e40af;
        }
        
        .info-label {
            font-weight: 600;
            color: #1e40af;
        }
        
        .actions-column {
            transition: all 0.3s ease;
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
        </ul>
    </div>
    <div class="container" style="padding-top: 40px;">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
                <div class="candidate-container">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="mb-0">Candidates</h1>
                        <div class="d-flex gap-2">
                            <a href="{{ url('/display-archived-candidates') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-archive"></i> View Trashed Candidates
                            </a>
                            <a href="/register-candidate" class="btn btn-register">
                                + Add New Candidate
                            </a>
                        </div>
                    </div>
                    @if($candidates->count() > 0)
                        <div class="table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <form action="{{ url('/display-candidates') }}" method="GET" class="flex-grow-1 me-3">
                                    <div class="input-group">
                                        <input type="search" name="search" class="form-control" placeholder="Search candidate...">
                                        <input type="submit" value="Search" class="btn btn-primary">
                                    </div>
                                </form>
                                <button class="btn btn-outline-primary" id="toggleActions" onclick="toggleActionsColumn()">
                                    <i class="fas fa-cog"></i> Actions
                                </button>
                            </div>
                            <table class="table table-hover align-middle">
                                <thead class="table-header">
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Candidate Name</th>
                                        <th scope="col">Party Affiliation</th>
                                        <th scope="col">Position</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Applied Date</th>
                                        <th scope="col" class="actions-column" style="display: none;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidates as $candidate)
                                    <tr>
                                        <th>
                                            <button class="btn-view" data-bs-toggle="modal" data-bs-target="#candidateModal{{ $candidate->candidate_id }}" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </th>
                                        <td class="fw-semibold">{{ $candidate->candidate_name }}</td>
                                        <td>
                                            <span class="party-badge">
                                                {{ $candidate->party_affiliation }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="candidate-badge">
                                                {{ $candidate->position_name }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($candidate->status === 'Disabled')
                                                <span class="badge bg-secondary">Disabled</span>
                                            @else
                                                <span class="badge bg-success">Active</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($candidate->created_at)->format('M d, Y') }}</td>
                                        <td class="actions-column" style="display: none;">
                                            <a href="{{ route('candidates.edit', $candidate->candidate_id) }}" class="btn btn-sm btn-warning btn-action">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            
                                            @if($candidate->status !== 'Disabled')
                                                <form action="{{ route('candidates.disable', $candidate->candidate_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to disable this candidate?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-secondary btn-action">
                                                        <i class="fas fa-ban"></i> Disable
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('candidates.enable', $candidate->candidate_id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success btn-action">
                                                        <i class="fas fa-check-circle"></i> Enable
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('candidates.destroy', $candidate->candidate_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this candidate?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-action">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Modal for this candidate -->
                                    <div class="modal fade" id="candidateModal{{ $candidate->candidate_id }}" tabindex="-1" aria-labelledby="candidateModalLabel{{ $candidate->candidate_id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="candidateModalLabel{{ $candidate->candidate_id }}">
                                                        <i class="fas fa-user-tie me-2"></i>Candidate Details
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row mb-3">
                                                                <div class="col-6">
                                                                    <p class="info-label mb-1">Candidate ID:</p>
                                                                    <p>{{ $candidate->candidate_id }}</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="info-label mb-1">Position:</p>
                                                                    <p>
                                                                        <span class="candidate-badge">
                                                                            {{ $candidate->position_name }}
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <p class="info-label mb-1">Candidate Name:</p>
                                                                    <p>{{ $candidate->candidate_name }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <p class="info-label mb-1">Party Affiliation:</p>
                                                                    <p>
                                                                        <span class="party-badge">
                                                                            {{ $candidate->party_affiliation }}
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="info-label mb-1">Applied for Candidacy:</p>
                                                                    <p>{{ \Carbon\Carbon::parse($candidate->created_at)->format('F d, Y - h:i A') }}</p>
                                                                </div>
                                                            </div>
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
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="mb-3">🎯</div>
                            <h4>No Candidates Yet</h4>
                            <p class="mb-4">Start by adding your first candidate.</p>
                            <a href="/register-candidate" class="btn btn-register">
                                Add First Candidate
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        function toggleActionsColumn() {
            const actionColumns = document.querySelectorAll('.actions-column');
            const toggleBtn = document.getElementById('toggleActions');
            
            actionColumns.forEach(column => {
                if (column.style.display === 'none') {
                    column.style.display = 'table-cell';
                    toggleBtn.classList.remove('btn-outline-primary');
                    toggleBtn.classList.add('btn-primary');
                } else {
                    column.style.display = 'none';
                    toggleBtn.classList.remove('btn-primary');
                    toggleBtn.classList.add('btn-outline-primary');
                }
            });
        }
    </script>
</body>
</html>
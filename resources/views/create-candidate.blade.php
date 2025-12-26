<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        body {
            background-color: #f0f4f8;
            padding: 40px 0;
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
        .form-label {
            color: #1e3a8a;
            font-weight: 500;
        }
        .btn-vote {
            background-color: #1e40af;
            color: white;
            padding: 10px 30px;
            border: none;
        }
        .btn-vote:hover {
            background-color: #1e3a8a;
            color: white;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="voter-container">
                    <div class="mb-3">
                        <a href="{{ route('display.candidates') }}" class="text-decoration-none">
                            <small>← View All Candidates</small>
                        </a>
                    </div>
                    
                    <h1 class="text-center">Candidate Registration</h1>
                    <form action="{{ route('register.candidate.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Candidate Name -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="candidate_name" class="form-label">Candidate Name</label>
                                <input type="text" name="candidate_name" id="candidate_name" class="form-control" value="{{ old('candidate_name') }}" required>
                            </div>
                        </div>

                        <!-- Party Affiliation -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="party_affiliation" class="form-label">Party Affiliation</label>
                                <input type="text" name="party_affiliation" id="party_affiliation" class="form-control" value="{{ old('party_affiliation') }}" required>
                            </div>
                        </div>

                        <!-- Candidate Photo -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="imagepath" class="form-label">Candidate Photo (Optional)</label>
                                <input type="file" name="imagepath" id="imagepath" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewImage(event)">
                                <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                                <div id="imagePreview" class="mt-2" style="display: none;">
                                    <small class="text-muted">Preview:</small><br>
                                    <img id="previewImg" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; object-fit: cover; border: 2px solid #1e40af; border-radius: 8px;">
                                </div>
                            </div>
                        </div>

                        <!-- Position -->
                        <div class="row mb-4">
                            <div class="col">
                                <label for="position_id" class="form-label">Position</label>
                                <select name="position_id" id="position_id" class="form-select" required>
                                    <option value="">Select Position</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->position_id }}" {{ old('position_id') == $position->position_id ? 'selected' : '' }}>
                                            {{ $position->position_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-vote">Register Candidate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
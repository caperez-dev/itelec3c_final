<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Voter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        body {
            background-color: #f0f4f8;
        }
        
        .registration-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-top: 40px;
            border-top: 5px solid #1e40af;
        }
        
        h1 {
            color: #1e40af;
            margin-bottom: 30px;
        }
        
        .form-label {
            font-weight: 600;
            color: #334155;
        }
        
        .btn-submit {
            background-color: #1e40af;
            color: white;
            padding: 12px 40px;
            border: none;
            width: 100%;
        }
        
        .btn-submit:hover {
            background-color: #1e3a8a;
            color: white;
        }

        .btn-back {
            background-color: #6b7280;
            color: white;
            padding: 12px 40px;
            border: none;
            width: 100%;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #4b5563;
            color: white;
        }
        
        .required {
            color: #dc2626;
        }

        .current-image {
            max-width: 200px;
            margin-top: 10px;
            border-radius: 5px;
            border: 2px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="registration-container">
                    <h1 class="text-center">Edit Voter Information</h1>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('voters.update', $voter->voter_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fName" class="form-label">
                                    First Name <span class="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="fName" 
                                    name="fName" 
                                    value="{{ old('fName', $voter->first_name) }}"
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="lName" class="form-label">
                                    Last Name <span class="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="lName" 
                                    name="lName" 
                                    value="{{ old('lName', $voter->last_name) }}"
                                    required
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="birthdate" class="form-label">
                                Date of Birth <span class="required">*</span>
                            </label>
                            <input 
                                type="date" 
                                class="form-control" 
                                id="birthdate" 
                                name="birthdate" 
                                value="{{ old('birthdate', $voter->birthdate->format('Y-m-d')) }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">
                                Gender <span class="required">*</span>
                            </label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender', $voter->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $voter->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $voter->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="contact" class="form-label">
                                Contact Number <span class="required">*</span>
                            </label>
                            <input 
                                type="tel" 
                                class="form-control" 
                                id="contact" 
                                name="contact" 
                                value="{{ old('contact', $voter->contact_information) }}"
                                maxlength="11"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="absimagepath" class="form-label">
                                Voter Image <small class="text-muted">(Leave blank to keep current image)</small>
                            </label>
                            <input 
                                type="file" 
                                class="form-control" 
                                id="absimagepath" 
                                name="absimagepath"
                                accept="image/jpeg,image/png,image/jpg,image/gif"
                                onchange="previewImage(event)"
                            >
                            <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                            @if($voter->imagepath)
                                <div class="mt-2">
                                    <p class="mb-1"><strong>Current Image:</strong></p>
                                    <img src="{{ asset('storage/'.$voter->imagepath) }}" alt="Current voter image" class="current-image">
                                </div>
                            @endif
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <small class="text-muted">New image preview:</small><br>
                                <img id="previewImg" src="" alt="New Image Preview" style="max-width: 150px; max-height: 150px; object-fit: cover; border: 2px solid #1e40af; border-radius: 8px;">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('voters.list') }}" class="btn btn-back">
                                    Cancel
                                </a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <button type="submit" class="btn btn-submit">
                                    Update Voter
                                </button>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Registration</title>
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

                <div class="voter-container">
                    <div class="mb-3">
                        <a href="{{ route('voters.list') }}" class="text-decoration-none">
                            <small>← View All Registered Voters</small>
                        </a>
                    </div>
                    
                    <h1 class="text-center">Voter Registration</h1>

                    <form action="{{route('register.voter.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Voter Name -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="fName" class="form-label">First Name</label>
                                <input type="text" name="fName" id="fName" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="lName" class="form-label">Last Name</label>
                                <input type="text" name="lName" id="lName" class="form-control" required>
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="birthdate" class="form-label">Date of Birth</label>
                                <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Gender</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="gender" id="genderFemale" value="Female" class="form-check-input" required>
                                        <label class="form-check-label" for="genderFemale">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="gender" id="genderMale" value="Male" class="form-check-input">
                                        <label class="form-check-label" for="genderMale">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="gender" id="genderOthers" value="Others" class="form-check-input">
                                        <label class="form-check-label" for="genderOthers">Others</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="gender" id="genderPrefNot" value="PrefNot" class="form-check-input">
                                        <label class="form-check-label" for="genderPrefNot">Prefer not to say</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row mb-4">
                            <div class="col">
                                <label for="contact" class="form-label">Contact Number</label>
                                <input type="tel" name="contact" id="contact" class="form-control" required>
                            </div>
                        </div>

                        <!-- Voter Image -->
                        <div class="row mb-4">
                            <div class="col">
                                <label for="absimagepath">Voter Image</label>
                                <input type="file" name="absimagepath" id="absimagepath" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewImage(event)">
                                <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                                <div id="imagePreview" class="mt-2" style="display: none;">
                                    <small class="text-muted">Preview:</small><br>
                                    <img id="previewImg" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; object-fit: cover; border: 2px solid #1e40af; border-radius: 8px;">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-vote">Register to Vote</button>
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
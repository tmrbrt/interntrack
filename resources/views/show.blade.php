@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="d-flex align-items-start">
                            <!-- Profile Picture Preview (Upper Left) -->
                            <div class="me-3">
                                <img id="previewImage" 
                                     src="{{ $profile->profile_picture ? asset('storage/' . $profile->profile_picture) : asset('default-avatar.png') }}" 
                                     alt="Profile Picture" 
                                     class="rounded-circle border" width="120">
                            </div>

<!-- Profile Heading -->
<h2 class="mb-0">
    {{ auth()->user()->name }} - 
    @if(auth()->user()->role == 'student')
        Student Profile
    @elseif(auth()->user()->role == 'coordinator')
        Coordinator Profile
    @elseif(auth()->user()->role == 'supervisor')
        Supervisor Profile
    @endif
</h2>


                        </div>

                        <hr class="my-4">

                        @if(session('password_success'))
                            <div class="alert alert-success">
                                {{ session('password_success') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Profile Picture Upload -->
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Upload Profile Picture</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                            </div>

                            <!-- Common Fields for All Users -->
                            @if(auth()->user()->role == 'student')
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address', $profile->address ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="student_number" class="form-label">Student Number</label>
                                    <input type="text" class="form-control" id="student_number" name="student_number"
                                        value="{{ old('student_number', $profile->student_number ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="college" class="form-label">College</label>
                                    <input type="text" class="form-control" id="college" name="college"
                                        value="{{ old('college', $profile->college ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="department" name="department"
                                        value="{{ old('department', $profile->department ?? '') }}" required>
                                </div>
                            @elseif(auth()->user()->role == 'coordinator')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Coordinator Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $profile->name ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="department" name="department"
                                        value="{{ old('department', $profile->department ?? '') }}" required>
                                </div>
                            @elseif(auth()->user()->role == 'supervisor')
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        value="{{ old('company_name', $profile->company_name ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="company_address" class="form-label">Company Address</label>
                                    <input type="text" class="form-control" id="company_address" name="company_address"
                                        value="{{ old('company_address', $profile->company_address ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="department" class="form-label">Position</label>
                                    <input type="text" class="form-control" id="department" name="department"
                                        value="{{ old('department', $profile->department ?? '') }}" required>
                                </div>
                            @endif

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for Live Profile Picture Preview -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('profile_picture');
        const previewImage = document.getElementById('previewImage');

        fileInput.addEventListener('change', function(event) {
            if (event.target.files.length) {
                const reader = new FileReader();
                reader.onload = function() {
                    previewImage.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    });
</script>
@endsection

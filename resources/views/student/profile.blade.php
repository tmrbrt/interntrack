@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Welcome, {{ Auth::user()->name }}!</h2>
                        <p class="text-center">Please fill up your profile information.</p>

                        <form method="POST" action="{{ route('profile.student.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Name (Readonly) -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" readonly>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ $studentProfile->address }}" required>
                            </div>

                            <!-- Date of Birth -->
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $studentProfile->date_of_birth }}" required>
                            </div>

                            <!-- Student Number -->
                            <div class="mb-3">
                                <label for="student_number" class="form-label">Student Number</label>
                                <input type="text" class="form-control" id="student_number" name="student_number" value="{{ $studentProfile->student_number }}" required>
                            </div>

                            <!-- Department -->
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-control" id="department" name="department" required>
                                    <option value="CAS" {{ $studentProfile->department == 'CAS' ? 'selected' : '' }}>CAS</option>
                                    <option value="CBA" {{ $studentProfile->department == 'CBA' ? 'selected' : '' }}>CBA</option>
                                    <!-- Add other departments here -->
                                </select>
                            </div>

                            <!-- Profile Picture -->
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Upload Profile Picture</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Save Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

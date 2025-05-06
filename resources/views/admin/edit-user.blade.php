@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                <option value="supervisor" {{ $user->role === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="coordinator" {{ $user->role === 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <!-- Role-Specific Fields -->
        @if ($user->role === 'student' && $user->studentProfile)
            <div class="mb-3">
                <label for="student_number" class="form-label">Student Number</label>
                <input type="text" class="form-control" id="student_number" name="student_number" value="{{ $user->studentProfile->student_number }}" required>
            </div>
            <div class="mb-3">
                <label for="college" class="form-label">College</label>
                <input type="text" class="form-control" id="college" name="college" value="{{ $user->studentProfile->college }}" required>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department" value="{{ $user->studentProfile->department }}" required>
            </div>
        @elseif ($user->role === 'supervisor' && $user->supervisorProfile)
            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $user->supervisorProfile->company_name }}" required>
            </div>
            <div class="mb-3">
                <label for="company_address" class="form-label">Company Address</label>
                <input type="text" class="form-control" id="company_address" name="company_address" value="{{ $user->supervisorProfile->company_address }}" required>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department" value="{{ $user->supervisorProfile->department }}" required>
            </div>
        @elseif ($user->role === 'coordinator' && $user->coordinatorProfile)
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department" value="{{ $user->coordinatorProfile->department }}" required>
            </div>
        @endif

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Update User</button>
    </form>
</div>
@endsection

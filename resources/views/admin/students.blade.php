@extends('layouts.app')

@include('layouts.adminsidebar')

@section('content')
<div class="d-flex">
    <div class="container-fluid" style="margin-left: 260px;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-primary">Student Profiles</h2>
                        <p class="text-muted">View all registered students.</p>
                        
                        <table class="table table-striped table-bordered mt-3">
                        <thead class="table-dark">
    <tr>
        <th>User ID</th>
        <th>Student Name</th> <!-- Added column -->
        <th>Supervisor ID</th>
        <th>Address</th>
        <th>Date of Birth</th>
        <th>Student Number</th>
        <th>College</th>
        <th>Department</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    @foreach($students as $student)
        <tr>
            <td>{{ $student->user_id }}</td>
            <td>{{ $student->user->name ?? 'N/A' }}</td> <!-- Display Student Name -->
            <td>{{ $student->supervisor_id }}</td>
            <td>{{ $student->address }}</td>
            <td>{{ $student->date_of_birth }}</td>
            <td>{{ $student->student_number }}</td>
            <td>{{ $student->college }}</td>
            <td>{{ $student->department }}</td>
            <td>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $student->id }}">Edit</button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudentModal{{ $student->id }}">Delete</button>
            </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Student</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label class="form-label">Address</label>
                                                            <input type="text" class="form-control" name="address" value="{{ $student->address }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Date of Birth</label>
                                                            <input type="date" class="form-control" name="date_of_birth" value="{{ $student->date_of_birth }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Student Number</label>
                                                            <input type="text" class="form-control" name="student_number" value="{{ $student->student_number }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">College</label>
                                                            <input type="text" class="form-control" name="college" value="{{ $student->college }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Department</label>
                                                            <input type="text" class="form-control" name="department" value="{{ $student->department }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Student</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this student?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

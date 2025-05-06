@extends('layouts.app')

@include('layouts.adminsidebar')

@section('content')
<div class="d-flex">
    <div class="container-fluid" style="margin-left: 260px;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-primary">Coordinators List</h2>
                        <p class="text-muted">View all registered coordinators.</p>

                        <table class="table table-striped table-bordered mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
    @foreach($coordinators as $coordinator)
        <tr>
            <td>{{ $coordinator->user->id ?? 'N/A' }}</td>
            <td>{{ $coordinator->user->name ?? 'N/A' }}</td>
            <td>{{ $coordinator->department }}</td>
            <td>
                                            <!-- Edit Button -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCoordinatorModal{{ $coordinator->user_id }}">Edit</button>
                                            
                                            <!-- Delete Button -->
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCoordinatorModal{{ $coordinator->user_id }}">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- Edit Coordinator Modal -->
                                    <div class="modal fade" id="editCoordinatorModal{{ $coordinator->user_id }}" tabindex="-1" aria-labelledby="editCoordinatorModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Coordinator</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.coordinators.update', $coordinator->user_id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" class="form-control" name="name" value="{{ $coordinator->user->name ?? '' }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Department</label>
                                                            <input type="text" class="form-control" name="department" value="{{ $coordinator->department }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteCoordinatorModal{{ $coordinator->user_id }}" tabindex="-1" aria-labelledby="deleteCoordinatorModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Coordinator</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this coordinator?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.coordinators.destroy', $coordinator->user_id) }}" method="POST">
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
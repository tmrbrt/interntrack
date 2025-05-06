    @extends('layouts.app')

    @include('layouts.adminsidebar')

    @section('content')

    <style>
        html, body {
            height: 100%;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    .main-content {
        flex: 1;
        margin-left: 260px; /* Ensure sidebar spacing */
        padding: 15px;
        max-height: 65vh; /* Shorten the container */
        overflow-y: auto; /* Enable scrolling only if necessary */
        width: 90%; /* Reduce width to prevent horizontal scrolling */
    }

    .table {
        font-size: 14px; /* Reduce font size to make the table more compact */
        table-layout: fixed; /* Prevent table from stretching too wide */
        width: 100%;
    }

    th, td {
        white-space: nowrap; /* Prevent text from wrapping and making rows too tall */
        padding: 5px; /* Reduce padding for a more compact table */
    }

    </style>

    <div class="wrapper">
        <div class="main-content container-fluid py-4">
            <h1 class="mb-4">User Management</h1>

            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#userModal"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            data-email="{{ $user->email }}"
                            data-role="{{ ucfirst($user->role) }}"
                            data-created_at="{{ $user->created_at->format('Y-m-d H:i') }}"

                            @if ($user->role === 'student' && $user->studentProfile)
                                data-student_number="{{ $user->studentProfile->student_number }}"
                                data-college="{{ $user->studentProfile->college }}"
                                data-department="{{ $user->studentProfile->department }}"
                            @elseif ($user->role === 'coordinator' && $user->coordinatorProfile)
                                data-college="{{ $user->coordinatorProfile->college }}"
                                data-department="{{ $user->coordinatorProfile->department }}"
                            @elseif ($user->role === 'supervisor' && $user->supervisorProfile)
                                data-company_name="{{ $user->supervisorProfile->company_name }}"
                                data-company_address="{{ $user->supervisorProfile->company_address }}"
                                data-department="{{ $user->supervisorProfile->department }}"
                            @endif
                        >
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    <!-- User Info Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="userModalLabel">User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: black;">

                    <p><strong>ID:</strong> <span id="modal-user-id"></span></p>
                    <p><strong>Name:</strong> <span id="modal-user-name"></span></p>
                    <p><strong>Email:</strong> <span id="modal-user-email"></span></p>
                    <p><strong>Role:</strong> <span id="modal-user-role"></span></p>
                    <p><strong>Created At:</strong> <span id="modal-user-created_at"></span></p>

                    <!-- Conditional Information -->
                    <div id="student-info" style="display:none;">
                        <p><strong>Student Number:</strong> <span id="modal-student-number"></span></p>
                        <p><strong>College:</strong> <span id="modal-student-college"></span></p>
                        <p><strong>Department:</strong> <span id="modal-student-department"></span></p>
                    </div>

                    <div id="coordinator-info" style="display:none;">
                        <p><strong>Department:</strong> <span id="modal-coordinator-department"></span></p>
                    </div>

                    <div id="supervisor-info" style="display:none;">
                        <p><strong>Company Name:</strong> <span id="modal-supervisor-company_name"></span></p>
                        <p><strong>Company Address:</strong> <span id="modal-supervisor-company_address"></span></p>
                        <p><strong>Department:</strong> <span id="modal-supervisor-department"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to Handle Modal Data -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rows = document.querySelectorAll('.clickable-row');
            rows.forEach(row => {
                row.addEventListener('click', function () {
                    document.getElementById('modal-user-id').innerText = row.getAttribute('data-id');
                    document.getElementById('modal-user-name').innerText = row.getAttribute('data-name');
                    document.getElementById('modal-user-email').innerText = row.getAttribute('data-email');
                    document.getElementById('modal-user-role').innerText = row.getAttribute('data-role');
                    document.getElementById('modal-user-created_at').innerText = row.getAttribute('data-created_at');

                    // Hide all additional info initially
                    document.getElementById('student-info').style.display = 'none';
                    document.getElementById('coordinator-info').style.display = 'none';
                    document.getElementById('supervisor-info').style.display = 'none';

                    // Show relevant info based on role
                    const role = row.getAttribute('data-role').toLowerCase();
                    if (role === 'student') {
                        document.getElementById('modal-student-number').innerText = row.getAttribute('data-student_number');
                        document.getElementById('modal-student-college').innerText = row.getAttribute('data-college');
                        document.getElementById('modal-student-department').innerText = row.getAttribute('data-department');
                        document.getElementById('student-info').style.display = 'block';
                    } else if (role === 'coordinator') {
                        document.getElementById('modal-coordinator-department').innerText = row.getAttribute('data-department');
                        document.getElementById('coordinator-info').style.display = 'block';
                    } else if (role === 'supervisor') {
                        document.getElementById('modal-supervisor-company_name').innerText = row.getAttribute('data-company_name');
                        document.getElementById('modal-supervisor-company_address').innerText = row.getAttribute('data-company_address');
                        document.getElementById('modal-supervisor-department').innerText = row.getAttribute('data-department');
                        document.getElementById('supervisor-info').style.display = 'block';
                    }
                });
            });
        });
    </script>

    @endsection

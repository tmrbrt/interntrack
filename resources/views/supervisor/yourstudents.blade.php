@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->role === 'supervisor')
    @include('layouts.supsidebar')
@endif

<!-- Dark Container -->
<div class="container mt-4 bg-dark text-white p-4 rounded">
    <h2>Assign Yourself to Students</h2>

    <h4>Available Students</h4>
    <table class="table table-bordered mb-4 table-dark">
        <thead class="table-primary">
            <tr>
                <th>Name</th>
                <th>Student Number</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>College</th>
                <th>Department</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->user->name ?? 'N/A' }}</td>
                    <td>{{ $student->student_number }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('F d, Y') }}</td>
                    <td>{{ $student->college }}</td>
                    <td>{{ $student->department }}</td>
                    <td>
                        <form action="{{ route('supervisor.assignStudent') }}" method="POST">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Your Assigned Students</h4>
    <table class="table table-bordered table-dark">
        <thead class="table-success">
            <tr>
                <th>Name</th>
                <th>Student Number</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>College</th>
                <th>Department</th>
                <th>Action</th>
                <th>Chat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assignedStudents as $student)
                <tr>
                    <td>{{ $student->user->name ?? 'N/A' }}</td>
                    <td>{{ $student->student_number }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('F d, Y') }}</td>
                    <td>{{ $student->college }}</td>
                    <td>{{ $student->department }}</td>
                    <td>
                        <form action="{{ route('supervisor.unassignStudent') }}" method="POST">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this student?')">
                                Remove
                            </button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm open-chat"
                            data-student-id="{{ $student->user->id }}"
                            data-student-name="{{ $student->user->name }}"
                            data-bs-toggle="modal"
                            data-bs-target="#chatModal">
                            Chat
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

<!-- Load Pusher -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pusher-js/7.0.6/pusher.min.js"></script>

<!-- Load Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Chat Script -->
<script src="{{ asset('js/chat.js') }}"></script>

<style>
    /* Footer Stays at the Bottom */
    html, body {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .container {
        flex: 1;
    }

    footer {
        margin-top: auto;
    }
</style>

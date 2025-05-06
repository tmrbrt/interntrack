@extends('layouts.app')

@section('content')
<body class="bg-black text-light"> <!-- Dark background -->

@if(Auth::check() && Auth::user()->role === 'supervisor')
    @include('layouts.supsidebar')
@elseif(Auth::check() && Auth::user()->role === 'coordinator')
    @include('layouts.coordsidebar')
@endif

<div class="container mt-4 p-4 rounded" style="margin-left: 270px; max-width: 1200px; background-color: #1e1e1e;"> <!-- Slightly lighter dark -->
    <h2 class="text-white">Student Assignments</h2>

    <!-- Assignment List Section -->
    <div class="card" style="background-color: #242424; color: white; border: 1px solid #444;"> <!-- Darkened card -->
        <div class="card-header bg-secondary text-white">Assignments</div>
        <div class="card-body">
            <ul class="list-group">
                @foreach ($assignments as $assignment)
                    @if(auth()->user()->role === 'student' && $assignment->supervisor_id == auth()->id())
                        <li class="list-group-item" style="background-color: #2a2a2a; color: white; border: 1px solid #444;">
                            <strong>{{ $assignment->title }}</strong>
                            <p>{{ $assignment->description }}</p>
                            <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                @csrf
                                <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                                <input type="file" name="submission" class="form-control bg-dark text-light border-secondary mb-2" required>
                                <button type="submit" class="btn btn-primary">Upload Submission</button>
                            </form>
                        </li>
                    @elseif(auth()->user()->role !== 'student')
                        <li class="list-group-item" style="background-color: #2a2a2a; color: white; border: 1px solid #444;">
                            <strong>{{ $assignment->title }}</strong>
                            <p>{{ $assignment->description }}</p>
                            @if($assignment->file_path)
                                <p><strong>Attachment:</strong> 
                                    <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="text-warning">View File</a>
                                </p>
                            @endif
                            @if(auth()->user()->role === 'supervisor' && $assignment->supervisor_id == auth()->id())
                                <a href="{{ route('assignments.edit', $assignment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this assignment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Student Submissions Section -->
    @if(auth()->user()->role === 'supervisor' || auth()->user()->role === 'coordinator')
        <div class="card mt-5" style="background-color: #242424; color: white; border: 1px solid #444;"> <!-- Darkened section -->
            <div class="card-header bg-info text-white">Student Submissions</div>
            <div class="card-body">
                @foreach ($assignments as $assignment)
                    @if(auth()->user()->role === 'supervisor' && $assignment->supervisor_id != auth()->id())
                        @continue
                    @endif
                
                    <ul class="list-group">
                        @foreach ($assignment->submissions as $submission)
                            <li class="list-group-item" style="background-color: #2a2a2a; color: white; border: 1px solid #444;">
                                <h5>{{ $assignment->title }}</h5>
                                <p><strong>Student:</strong> {{ $submission->student->name }}</p>
                                <p><strong>Submitted File:</strong> 
                                    @if($submission->file_path)
                                        <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-warning">View File</a>
                                    @else
                                        <p>No file submitted.</p>
                                    @endif
                                </p>
                                <p><strong>Submitted on:</strong> {{ $submission->created_at->format('F d, Y h:i A') }}</p>

                                @if(auth()->user()->role === 'supervisor')
                                    <form action="{{ route('submissions.grade', $submission->id) }}" method="POST" class="mt-3">
                                        @csrf
                                        @method('PATCH')
                                        <label for="grade">Grade (1-100):</label>
                                        <input type="number" name="grade" class="form-control bg-dark text-light border-secondary mb-2" min="1" max="100" value="{{ $submission->grade ?? 50 }}">
                                        <textarea name="feedback" class="form-control bg-dark text-light border-secondary mb-2" placeholder="Provide feedback...">{{ $submission->feedback ?? '' }}</textarea>
                                        <button type="submit" class="btn btn-success">Submit Grade</button>
                                    </form>
                                @endif

                                @if($submission->feedback)
                                    <p class="mt-2"><strong>Feedback:</strong> {{ $submission->feedback }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const gradeRange = document.getElementById("gradeRange");
        const gradeInput = document.getElementById("gradeInput");

        gradeRange.addEventListener("input", function () {
            gradeInput.value = gradeRange.value;
        });

        gradeInput.addEventListener("input", function () {
            gradeRange.value = gradeInput.value;
        });
    });
</script>

</body>
@endsection

@extends('layouts.app')

@section('content')
<body class="bg-black text-light"> <!-- Darkest background -->
    @if(Auth::check() && Auth::user()->role === 'supervisor')
        @include('layouts.supsidebar')
    @elseif(Auth::check() && Auth::user()->role === 'coordinator')
        @include('layouts.coordsidebar')
    @endif

    <div class="container mt-4 p-4 rounded" style="margin-left: 270px; background-color: #222;"> <!-- Darker container -->
        <h2 class="text-white">Student Assignments</h2>
        
        <!-- Assignment Posting Section (For Supervisors Only) -->
        @if(auth()->user()->role === 'supervisor')
            <div class="card mb-4" style="background-color: #1a1a1a; color: white;"> <!-- Slightly darker card -->
                <div class="card-header bg-success text-white">Post New Assignment</div>
                <div class="card-body">
                    <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control bg-dark text-white" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control bg-dark text-white" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Attach File (Optional)</label>
                            <input type="file" name="file" class="form-control bg-dark text-white">
                        </div>
                        <button type="submit" class="btn btn-outline-light">Post Assignment</button>
                    </form>
                </div>
            </div>
        @endif
        
        <!-- Assignment List Section -->
        <div class="card" style="background-color: #1a1a1a; color: white;">
            <div class="card-header bg-secondary text-white">Assignments</div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($assignments as $assignment)
                        @if(auth()->user()->role === 'student' && $assignment->supervisor_id == auth()->id())
                            <li class="list-group-item" style="background-color: #222; color: white;">
                                <strong>{{ $assignment->title }}</strong>
                                <p>{{ $assignment->description }}</p>

                                {{-- Only students can submit assignments --}}
                                <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                                    <input type="file" name="submission" class="form-control bg-dark text-white mb-2" required>
                                    <button type="submit" class="btn btn-outline-light">Upload Submission</button>
                                </form>
                            </li>
                        @elseif(auth()->user()->role !== 'student')
                            <li class="list-group-item" style="background-color: #222; color: white;">
                                <strong>{{ $assignment->title }}</strong>
                                <p>{{ $assignment->description }}</p>
                                
                                @if($assignment->file_path)
                                    <p><strong>Attachment:</strong> 
                                        <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="text-info">View File</a>
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

        <!-- Supervisor View: Student Submissions -->
        @if(auth()->user()->role === 'supervisor' || auth()->user()->role === 'coordinator')
            <div class="card mt-4" style="background-color: #1a1a1a; color: white;">
                <div class="card-header bg-info text-white">Student Submissions</div>
                <div class="card-body">
                    @foreach ($assignments as $assignment)
                        @if(auth()->user()->role === 'supervisor' && $assignment->supervisor_id != auth()->id())
                            @continue
                        @endif
                        <div class="mb-3">
                    
                        </div>
                        <ul class="list-group">
                            @foreach ($assignment->submissions as $submission)
                                <li class="list-group-item" style="background-color: #222; color: white;">
                                            <h5 class="text-white fw-bold">{{ $assignment->title }}</h5>
                                            <p>Student: {{ $submission->student->name }}</p>
                                    <p>Submitted File:
                                        <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-info">View File</a>
                                    </p>
                                    <p>Submitted on: {{ $submission->created_at->format('F d, Y h:i A') }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</body>
@endsection

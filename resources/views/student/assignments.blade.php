@extends('layouts.app')

@section('content')

<div class="container mt-4 text-light" style="max-width: 1200px;">
    <h2 class="text-center mb-4">Student Assignments</h2>

    <div class="card bg-black text-white border-secondary">
        <div class="card-header bg-dark text-white border-secondary">
            <h4>Assignments</h4>
        </div>
        <div class="card-body">
            @if($assignments->isEmpty())
                <p class="text-muted">No assignments available.</p>
            @else
                <div class="accordion" id="assignmentAccordion">
                    @foreach ($assignments as $assignment)
                        @if(auth()->user()->role === 'student')
                            @php
                                $assignedSupervisorId = optional(auth()->user()->studentProfile)->supervisor_id;
                            @endphp
                            @if($assignment->supervisor_id !== $assignedSupervisorId)
                                @continue
                            @endif
                        @endif

                        <div class="accordion-item bg-dark border-secondary">
                            <h2 class="accordion-header" id="heading{{ $assignment->id }}">
                                <button class="accordion-button collapsed bg-dark text-white border-secondary" 
                                        type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#collapse{{ $assignment->id }}" 
                                        aria-expanded="false">
                                    {{ $assignment->title }}
                                </button>
                            </h2>
                            <div id="collapse{{ $assignment->id }}" class="accordion-collapse collapse" 
                                 aria-labelledby="heading{{ $assignment->id }}" 
                                 data-bs-parent="#assignmentAccordion">
                                <div class="accordion-body bg-black text-white border-secondary">
                                    <p>{{ $assignment->description }}</p>
                                    <p><strong>Posted by:</strong> {{ $assignment->supervisor->name }}</p>
                                    <p><strong>Posted:</strong> {{ $assignment->created_at->format('F d, Y') }}</p>

                                    {{-- Show Supervisor's Uploaded File --}}
                                    @if ($assignment->file_path)
                                        <p><strong>Assignment File:</strong> 
                                            <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="text-primary">Download</a>
                                        </p>
                                    @endif

                                    {{-- File Upload Form for Student Submissions --}}
                                    @if(auth()->user()->role === 'student')
                                        <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

                                            <div class="mb-3">
                                                <label class="form-label">Upload Your Submission:</label>
                                                <input type="file" name="submission" class="form-control bg-dark text-white border-secondary" required>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>

                                        {{-- Display Student's Submitted File --}}
                                        @php
                                            $submission = $assignment->submissions->where('student_id', auth()->id())->first();
                                        @endphp
                                        @if ($submission)
                                            <p class="mt-2"><strong>Your Submission:</strong> 
                                                <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-primary">View File</a>
                                            </p>

                                            {{-- Show Supervisor's Feedback if available --}}
                                            @if($submission->feedback)
                                                <div class="alert alert-info mt-2">
                                                    <strong>Supervisor's Feedback:</strong>
                                                    <p>{{ $submission->feedback }}</p>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
<style>
    /* Make accordion arrow white */
    .accordion-button::after {
        filter: invert(1); /* Inverts colors, making the arrow white */
    }

    /* Ensure button text remains white */
    .accordion-button {
        color: white !important;
    }

    /* Override the background color for the expanded button */
    .accordion-button:not(.collapsed) {
        background-color: #222 !important;
        color: white !important;
    }
</style>

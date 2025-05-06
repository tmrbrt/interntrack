@extends('layouts.app')
@section('content')
    @include('layouts.coordsidebar')

    <div class="container mt-4" style="margin-left: 270px; max-width: 1200px; background-color: #121212; color: #ffffff; padding: 20px; border-radius: 10px;">
        <h2 class="mb-4 text-white">Student Assignments</h2>

        <div class="card bg-dark text-light border-light shadow">
            <div class="card-header bg-primary text-white">
                Uploaded Assignments
            </div>
            <div class="card-body">
                @if($assignments->isEmpty())
                    <p class="text-muted">No assignments uploaded yet.</p>
                @else
                    <table class="table table-dark table-hover">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Progress</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $students = [];
                        @endphp

                        @foreach ($assignments as $assignment)
                            @foreach ($assignment->submissions as $submission)
                                @php
                                    $studentId = $submission->student_id;
                                    if (!isset($students[$studentId])) {
                                        $students[$studentId] = [
                                            'name' => optional($submission->student)->name ?? 'Unknown Student',
                                            'assigned_count' => 0,
                                            'submitted_count' => 0,
                                            'submissions' => [],
                                        ];
                                    }

                                    $students[$studentId]['assigned_count']++;
                                    if ($submission->file_path) {
                                        $students[$studentId]['submitted_count']++;
                                    }

                                    $students[$studentId]['submissions'][] = [
                                        'title' => $assignment->title,
                                        'uploaded_on' => $submission->created_at->format('F d, Y h:i A'),
                                        'grade' => $submission->grade ?? 'Not Graded',
                                        'feedback' => $submission->feedback ?? 'No Feedback',
                                        'file_url' => $submission->file_path ?? null,
                                    ];
                                @endphp
                            @endforeach
                        @endforeach

                        @foreach ($students as $student_id => $student)
                            <tr>
                                <td class="text-white">{{ $student_id }}</td>
                                <td class="text-white">{{ $student['name'] }}</td>
                                <td>
                                    <strong class="text-warning">{{ $student['submitted_count'] }} / {{ $student['assigned_count'] }}</strong> Assignments Submitted
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#studentModal{{ $student_id }}">
                                        View Assignments
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal for Student Assignments -->
                            <div class="modal fade" id="studentModal{{ $student_id }}" tabindex="-1" aria-labelledby="studentModalLabel{{ $student_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content bg-dark text-light border-light">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-white" id="studentModalLabel{{ $student_id }}">Assignments - {{ $student['name'] }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if(empty($student['submissions']))
                                                <p class="text-muted">No assignments uploaded.</p>
                                            @else
                                                <div class="accordion" id="assignmentAccordion{{ $student_id }}">
                                                    @foreach ($student['submissions'] as $index => $submission)
                                                        <div class="accordion-item bg-dark border-secondary">
                                                            <h2 class="accordion-header" id="heading{{ $student_id }}{{ $index }}">
                                                                <button class="accordion-button bg-secondary text-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $student_id }}{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $student_id }}{{ $index }}">
                                                                    {{ $submission['title'] }} (Uploaded: {{ $submission['uploaded_on'] }})
                                                                </button>
                                                            </h2>
                                                            <div id="collapse{{ $student_id }}{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $student_id }}{{ $index }}" data-bs-parent="#assignmentAccordion{{ $student_id }}">
                                                                <div class="accordion-body text-white">
                                                                    <p><strong>Grade:</strong> <span class="text-warning">{{ $submission['grade'] }}</span></p>
                                                                    <p><strong>Feedback:</strong> <span class="text-light">{{ $submission['feedback'] }}</span></p>
                                                                    @if ($submission['file_url'])
                                                                        <p><strong>File:</strong> 
                                                                            <a href="{{ asset('storage/' . $submission['file_url']) }}" 
                                                                               target="_blank" class="btn btn-sm btn-outline-light">
                                                                                View File
                                                                            </a>
                                                                        </p>
                                                                    @else
                                                                        <p class="text-danger">No File Uploaded</p>
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
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Ensure Bootstrap JS is Loaded -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .table th, .table td {
            color: #ffffff !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .modal-content {
            background-color: #1e1e1e !important;
            color: #ffffff !important;
        }

        .btn-close-white {
            filter: invert(1);
        }

        .accordion-button {
            color: #ffffff !important;
        }

        .accordion-button:not(.collapsed) {
            background-color: #343a40 !important;
            color: #ffffff !important;
        }

        .accordion-button:hover {
            background-color: #5a6268 !important;
        }

        .accordion-body {
            background-color: #222 !important;
            color: #ffffff !important;
        }

        .text-muted {
            color: #d3d3d3 !important;
        }

        .text-secondary {
            color: #b0b0b0 !important;
        }

        .card, .modal-content {
            background-color: #1e1e1e !important;
            color: #ffffff !important;
        }

        .btn-outline-light {
            border-color: #ffffff;
            color: #ffffff;
        }

        .btn-outline-light:hover {
            background-color: #ffffff;
            color: #000;
        }
    </style>
@endsection

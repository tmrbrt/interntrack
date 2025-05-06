@extends('layouts.app') 
@section('content')
    @include('layouts.coordsidebar')

    <div class="container mt-4" style="margin-left: 270px; max-width: 1200px;">
        <h2 class="mb-4">Student Progress</h2>

        <!-- Rendered Hours Section -->
        <div class="card">
            <div class="card-header bg-primary text-white">Attendance List</div>
            <div class="card-body">
                @isset($attendances)
                    @if($attendances->isEmpty())
                        <p class="text-muted">No attendance records available.</p>
                    @else
                        @foreach ($attendances as $studentId => $records)
                            @php 
                                $student = $records->first() ? $records->first()->student : null;
                            @endphp

                            <div class="mb-3">
                                <button class="btn btn-secondary w-100 text-left" type="button" data-bs-toggle="modal" data-bs-target="#modal-{{ $studentId }}">
                                    {{ $student ? $student->name : 'Unknown Student' }}
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modal-{{ $studentId }}" tabindex="-1" aria-labelledby="modalLabel-{{ $studentId }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel-{{ $studentId }}">
                                                    Attendance for {{ $student ? $student->name : 'Unknown Student' }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Time In</th>
                                                            <th>Time Out</th>
                                                            <th>Status</th>
                                                            <th>Hours Rendered</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($records as $attendance)
                                                            @php
                                                                $timeIn = $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in) : null;
                                                                $timeOut = $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out) : null;
                                                                $hoursRendered = ($timeIn && $timeOut) ? round($timeIn->diffInMinutes($timeOut) / 60, 2) : 0;

                                                                // Determine status based on work duration
                                                                $status = 'Absent';
                                                                if ($timeIn && $timeOut) {
                                                                    if ($hoursRendered >= 8) {
                                                                        $status = 'Present';
                                                                    } else {
                                                                        $status = 'Undertime';
                                                                    }
                                                                }
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $attendance->date }}</td>
                                                                <td>{{ $timeIn ? $timeIn->format('h:i A') : 'N/A' }}</td>
                                                                <td>{{ $timeOut ? $timeOut->format('h:i A') : 'N/A' }}</td>
                                                                <td>
                                                                    <span class="badge {{ $status == 'Present' ? 'bg-success' : ($status == 'Undertime' ? 'bg-warning' : 'bg-danger') }}">
                                                                        {{ $status }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $hoursRendered }} hrs</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @else
                    <p class="text-danger">Attendance data not available.</p>
                @endisset
            </div>
        </div>

        <!-- Assignment Section -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">Uploaded Assignments</div>
            <div class="card-body">
                @isset($assignments)
                    @if($assignments->isEmpty())
                        <p class="text-muted">No assignments uploaded yet.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Assignment Title</th>
                                    <th>Uploaded On</th>
                                    <th>Grade</th>
                                    <th>Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $assignment)
                                    @foreach ($assignment->submissions as $submission)
                                        <tr>
                                            <td>{{ $submission->student_id }}</td>
                                            <td>{{ optional($submission->student)->name ?? 'Unknown Student' }}</td>
                                            <td>{{ $assignment->title }}</td>
                                            <td>{{ $submission->created_at->format('F d, Y h:i A') }}</td>
                                            <td>{{ $submission->grade ?? 'Not Graded' }}</td>
                                            <td>{{ $submission->feedback ?? 'No Feedback' }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @else
                    <p class="text-danger">Assignment data not available.</p>
                @endisset
            </div>
        </div>
    </div>
@endsection

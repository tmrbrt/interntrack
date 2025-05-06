@extends('layouts.app')

@section('content')
@include('layouts.coordsidebar')

<div class="container mt-4 bg-dark text-light" style="margin-left: 270px; max-width: 1200px;">
    <h2 class="mb-4">Student Attendance Records</h2>

    <div class="card bg-dark text-white">
        <div class="card-header bg-primary text-white">Attendance List</div>
        <div class="card-body">
            @foreach ($attendances as $studentId => $records)
                @php 
                    $student = $records->first()->student;
                    $department = $student->department ?? null;
                    $college = $student->college ?? null;

                    // Generate the key for matching OJT configurations
                    $key = $department . '-' . $college;

                    // Log the key to check if it matches the OJT configurations
                    \Log::debug('Key for student:', ['student' => $student->name, 'key' => $key]);

                    // Calculate total hours for the student
                    $totalHours = 0;
                    foreach ($records as $attendance) {
                        $timeIn = $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in) : null;
                        $timeOut = $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out) : null;
                        $hoursRendered = ($timeIn && $timeOut) ? round($timeIn->diffInMinutes($timeOut) / 60, 2) : 0;
                        $totalHours += $hoursRendered; // Add to total
                    }
                @endphp

                <!-- Display student attendance details here -->
                <div class="mb-3">
                <button class="btn btn-outline-light w-100 text-left" type="button" data-bs-toggle="modal" data-bs-target="#modal-{{ $studentId }}">
                        {{ $student ? $student->name : 'Unknown Student' }}
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modal-{{ $studentId }}" tabindex="-1" aria-labelledby="modalLabel-{{ $studentId }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark text-light">
                                <div class="modal-header border-secondary">
                                    <h5 class="modal-title" id="modalLabel-{{ $studentId }}">
                                        Attendance for {{ $student ? $student->name : 'Unknown Student' }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Display Total Rendered Hours inside the modal -->
                                    <p><strong>Total Hours Worked:</strong> {{ $totalHours }} hrs</p>
                                    <table class="table table-dark table-bordered">
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
                                                    $badgeClass = 'bg-danger';
                                                    if ($timeIn && $timeOut) {
                                                        if ($hoursRendered >= 8) {
                                                            $status = 'Present';
                                                            $badgeClass = 'bg-success';
                                                        } else {
                                                            $status = 'Undertime';
                                                            $badgeClass = 'bg-warning text-dark';
                                                        }
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $attendance->date }}</td>
                                                    <td>{{ $timeIn ? $timeIn->format('h:i A') : 'N/A' }}</td>
                                                    <td>{{ $timeOut ? $timeOut->format('h:i A') : 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge {{ $badgeClass }}">
                                                            {{ $status }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $hoursRendered }} hrs</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer border-secondary">
                                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

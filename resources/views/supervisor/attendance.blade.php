@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->role === 'supervisor')
    @include('layouts.supsidebar')
@endif

<div class="container mt-4" style="margin-left: 270px; max-width: 1200px;">
    <h2 class="mb-4 text-light">Student Attendance Records</h2>

    <div class="card bg-dark text-white">
        <div class="card-header bg-secondary text-white">Attendance List</div>
        <div class="card-body">
            @if($groupedAttendances->isEmpty())
                <p class="text-muted">No attendance records available.</p>
            @else
                @foreach ($groupedAttendances as $studentId => $attendances)
                @php 
                    $student = $attendances->first() ? $attendances->first()->student : null;
                    $supervisorId = Auth::user()->id;
                    $isAssignedStudent = $student && $student->studentProfile->supervisor_id == $supervisorId;
                @endphp

                @if($isAssignedStudent)
                    <div class="mb-3">
                        <button class="btn btn-outline-light w-100 text-left" type="button" data-bs-toggle="modal" data-bs-target="#modal-{{ $studentId }}">
                            {{ $student ? $student->name : 'Unknown Student' }}
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modal-{{ $studentId }}" tabindex="-1" aria-labelledby="modalLabel-{{ $studentId }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-info" id="modalLabel-{{ $studentId }}">
                                            Attendance for {{ $student ? $student->name : 'Unknown Student' }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-dark table-bordered border-secondary">
                                            <thead class="bg-secondary text-white">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time In</th>
                                                    <th>Time Out</th>
                                                    <th>Status</th>
                                                    <th>Hours Rendered</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($attendances as $attendance)
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
                                                                $badgeClass = 'bg-warning';
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
                @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection

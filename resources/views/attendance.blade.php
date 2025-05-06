@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->role === 'student')
    @include('layouts.sidebar')
@endif

<div class="container mt-4" style="margin-left: 270px; max-width: 1200px;">
    <h2 class="mb-4 text-light">Student Attendance</h2>

    <div class="card bg-dark text-white">
        <div class="card-header bg-secondary text-white">Time In / Time Out</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" name="date" value="{{ now()->toDateString() }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="time_in" class="form-label">Time In</label>
                    <input type="time" class="form-control" name="time_in" required>
                </div>

                <div class="mb-3">
                    <label for="time_out" class="form-label">Time Out</label>
                    <input type="time" class="form-control" name="time_out">
                </div>

                <button type="submit" class="btn btn-primary">Submit Attendance</button>
            </form>
        </div>
    </div>

    <!-- Attendance History -->
    <div class="card bg-dark text-white mt-4">
        <div class="card-header bg-secondary text-white">Attendance History</div>
        <div class="card-body">
            @if($attendances->isEmpty())
                <p class="text-muted">No attendance records available.</p>
            @else
                <table class="table table-dark table-bordered border-secondary">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Hours Rendered</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            @php
                                $timeIn = $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in) : null;
                                $timeOut = $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out) : null;
                                $now = \Carbon\Carbon::now();

                                // Calculate total minutes logged
                                $totalMinutesLogged = ($timeIn && $timeOut) ? $timeIn->diffInMinutes($timeOut) : 0;
                                $hoursRendered = $totalMinutesLogged > 0 ? round($totalMinutesLogged / 60, 2) : 'N/A';

                                // Determine status based on work duration
                                $status = 'Absent';
                                $badgeClass = 'bg-danger';
                                if ($timeIn && $timeOut) {
                                    if ($totalMinutesLogged >= 480) { // 8 hours
                                        $status = 'Present';
                                        $badgeClass = 'bg-success';
                                    } else {
                                        $status = 'Undertime';
                                        $badgeClass = 'bg-warning';
                                    }
                                }

                                // Restrict timeout until 6 hours (360 minutes)
                                $canTimeOut = $timeIn && !$timeOut && $timeIn->diffInMinutes($now) >= 360;
                            @endphp
                            <tr>
                                <td>{{ $attendance->date }}</td>
                                <td>{{ $timeIn ? $timeIn->format('h:i A') : 'N/A' }}</td>
                                <td>{{ $timeOut ? $timeOut->format('h:i A') : 'N/A' }}</td>
                                <td>{{ $hoursRendered }} hrs</td>
                                <td>
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td>
                                    @if ($canTimeOut)
                                        <form action="{{ route('attendance.timeout') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirm Time Out?')">
                                                Time Out
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            @if(!$timeIn)
                                                No Time In
                                            @elseif($timeOut)
                                                Already Timed Out
                                            @else
                                                Time Out (Wait {{ round((360 - $timeIn->diffInMinutes($now)) / 60, 1) }} hrs)
                                            @endif
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

@endsection

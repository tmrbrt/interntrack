@extends('layouts.app') {{-- Extend your main layout --}}

@section('content')
<div class="container">
    <h2 class="mb-4">Daily Attendance</h2>

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
@endsection

@extends('layouts.app')

@section('content')
<section class="py-5 d-flex flex-column min-vh-100">
    <div class="container flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-md-8">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body p-5 text-center">
                        <h2>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h2>

                        <!-- Display attendance count -->
                        <div class="my-4">
                            <h4>Days Present This Month:</h4>
                            <h2 class="text-success">{{ $monthlyAttendanceCount }} / {{ $totalDaysInMonth }}</h2>
                        </div>

                        <!-- Display total hours rendered -->
                        <div class="my-4">
                            <h4>Total Hours Rendered This Month:</h4>
                            <h2 class="text-primary">{{ $totalHoursRendered }} hours</h2>
                        </div>

                        <!-- Display required hours if available -->
                        <div class="my-4">
                            <h4>Required OJT Hours:</h4>
                            @if(isset($requiredHours))
                                <h2 class="text-warning">{{ $requiredHours }} hours</h2>
                            @else
                                <h2 class="text-danger">Not Set</h2>
                            @endif
                        </div>

                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

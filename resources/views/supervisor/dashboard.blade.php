@extends('layouts.app')
@include('layouts.supsidebar')

@section('content')
<div class="d-flex flex-column min-vh-100"> <!-- Full height container -->
    <div class="d-flex flex-grow-1 align-items-center justify-content-center"> <!-- Centers content -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg border-0 bg-dark text-white"> <!-- Dark background -->
                        <div class="card-body text-center p-5">
                            <!-- Greeting Message -->
                            <h1 class="fw-bold text-warning">Welcome, {{ $supervisor->name }}!</h1>
                            <p class="text-light">You are logged in as a Supervisor.</p>

                            <!-- Dashboard Sections -->
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card bg-info text-white shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Students</h5>
                                            <p class="card-text">Assign your students.</p>
                                            <a href="{{ route('supervisor.yourstudents') }}" class="btn btn-light btn-sm">View</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card bg-success text-white shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Evaluations</h5>
                                            <p class="card-text">Assess student performance.</p>
                                            <a href="{{ route('evaluation') }}" class="btn btn-light btn-sm">Review</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card bg-warning text-white shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Chat</h5>
                                            <p class="card-text">Message your Students</p>
                                            <a href="{{ route('chat.index') }}" class="btn btn-light btn-sm">Check</a>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End row -->
                        </div>
                    </div> <!-- End card -->
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

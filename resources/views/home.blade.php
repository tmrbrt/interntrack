    @extends('layouts.app')
    @if(Auth::check() && Auth::user()->role === 'coordinator')
        @include('layouts.coordsidebar')
    @endif

    @section('content')

    <style>
        /* Black and Yellow Theme */
        .bg-custom-black { background-color: #000 !important; }
        .text-custom-yellow { color: #FFC107 !important; }
        .btn-custom-yellow { background-color: #FFC107 !important; color: #000 !important; border: none; }
        .btn-custom-yellow:hover { background-color: #e0a800 !important; }
        .border-custom-yellow { border-color: #FFC107 !important; }
    </style>

    <!-- Hero Section -->
    <section class="bg-custom-black text-custom-yellow text-center py-5">
        <div class="container">
            <h1 class="display-4">Welcome to InternTrack</h1>
            <p class="lead">Your one-stop solution for managing internships and tracking student progress.</p>
            <a href="/register" class="btn btn-custom-yellow btn-lg">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <h2 class="text-center text-custom-yellow mb-5">Why Choose InternTrack?</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <h3 class="text-custom-yellow">Easy to Use</h3>
                    <p>Our platform is designed to be intuitive and user-friendly.</p>
                </div>
                <div class="col-md-4 text-center">
                    <h3 class="text-custom-yellow">Track Progress</h3>
                    <p>Monitor student progress and generate reports effortlessly.</p>
                </div>
                <div class="col-md-4 text-center">
                    <h3 class="text-custom-yellow">Collaborate</h3>
                    <p>Connect students, supervisors, and coordinators in one place.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-custom-black text-center py-5">
        <div class="container">
            <h2 class="text-custom-yellow">Ready to Get Started?</h2>
            <p>Sign up now and take control of your internship management.</p>
            <a href="/register" class="btn btn-custom-yellow btn-lg">Sign Up</a>
        </div>
    </section>

    @endsection

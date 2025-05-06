@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white text-center py-5">
    <div class="container">
        <h1 class="display-4">Welcome to InternTrack</h1>
        <p class="lead">Your one-stop solution for managing internships and tracking student progress.</p>
        <a href="/register" class="btn btn-light btn-lg">Get Started</a>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose InternTrack?</h2>
        <div class="row">
            <div class="col-md-4 text-center">
                <h3>Easy to Use</h3>
                <p>Our platform is designed to be intuitive and user-friendly.</p>
            </div>
            <div class="col-md-4 text-center">
                <h3>Track Progress</h3>
                <p>Monitor student progress and generate reports effortlessly.</p>
            </div>
            <div class="col-md-4 text-center">
                <h3>Collaborate</h3>
                <p>Connect students, supervisors, and coordinators in one place.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-light py-5">
    <div class="container text-center">
        <h2>Ready to Get Started?</h2>
        <p>Sign up now and take control of your internship management.</p>
        <a href="/register" class="btn btn-primary btn-lg">Sign Up</a>
    </div>
</section>
@endsection
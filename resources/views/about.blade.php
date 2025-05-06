@extends('layouts.app')
@if(Auth::check() && Auth::user()->role === 'coordinator')
    @include('layouts.coordsidebar')
@endif
@section('content')

<section class="py-5" style="background-color: #000; color: #FFD700;">
    <div class="container">
        <h1 class="text-center fw-bold">About InternTrack</h1>
        <p class="lead text-center text-light">Empowering students, supervisors, and coordinators for a seamless internship experience.</p>

        <div class="row mt-4">
            <div class="col-md-6">
                <h2 class="fw-bold">Our Mission</h2>
                <p>To simplify internship management and enhance collaboration between students, supervisors, and coordinators, ensuring a smooth and efficient process for all.</p>
            </div>
            <div class="col-md-6">
                <h2 class="fw-bold">Our Vision</h2>
                <p>To become the leading platform for internship tracking and management worldwide, setting the standard for efficiency and ease of use.</p>
            </div>
        </div>

        <!-- How It Works Section -->
     
        <!-- User Testimonials -->
        <div class="mt-5">
            <h2 class="text-center fw-bold">What Our Users Say</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <p class="text-light">"InternTrack has made internship tracking a breeze! I no longer have to manually check student progress." <br><strong>- Supervisor</strong></p>
                </div>
                <div class="col-md-4 text-center">
                    <p class="text-light">"Managing internships has never been easier. I love the real-time updates!" <br><strong>- Coordinator</strong></p>
                </div>
                <div class="col-md-4 text-center">
                    <p class="text-light">"InternTrack keeps me organized, and submitting reports is so simple!" <br><strong>- Student</strong></p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-5">
            <h2 class="fw-bold">Join InternTrack Today</h2>
            <p class="text-light">Simplify your internship management with our powerful platform.</p>
            <a href="/register" class="btn btn-warning btn-lg fw-bold text-dark">Get Started Now</a>
        </div>
    </div>
</section>

<!-- Footer Section -->
<footer class="mt-auto py-4" style="background-color: #111; color: #FFD700;">
    <div class="container text-center">
        <div class="row">
            <!-- Footer Links -->
            <div class="col-md-4">
                <h5 class="fw-bold">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="text-warning">Home</a></li>
                    <li><a href="/about" class="text-warning">About Us</a></li>
                    <li><a href="/contact" class="text-warning">Contact</a></li>
                    <li><a href="/faq" class="text-warning">FAQ</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-4">
                <h5 class="fw-bold">Contact Us</h5>
                <p>Email: <a href="mailto:support@interntrack.com" class="text-warning">support@interntrack.com</a></p>
                <p>Phone: +123 456 7890</p>
                <p>Location: 123 Internship St, Muntinlupa</p>
            </div>

            <!-- Social Media -->
            <div class="col-md-4">
                <h5 class="fw-bold">Follow Us</h5>
                <a href="#" class="text-warning mx-2"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="text-warning mx-2"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-warning mx-2"><i class="fab fa-linkedin fa-lg"></i></a>
                <a href="#" class="text-warning mx-2"><i class="fab fa-instagram fa-lg"></i></a>
            </div>
        </div>

        <hr style="border-color: #FFD700;">
    </div>
</footer>

@endsection

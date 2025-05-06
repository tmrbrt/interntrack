@extends('layouts.app')

@section('content')
<div class="d-flex flex-column min-vh-100" style="background-color: #000;">
    <section class="flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); color: #fff; border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 class="text-center mb-3 fw-bold text-white">Welcome Back</h2>
                            <p class="text-center mb-4 text-white">Sign in to continue to InternTrack</p>

                            <!-- Display Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success text-white" style="background: rgba(255, 255, 255, 0.2); border: none;">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Display Validation Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger text-white" style="background: rgba(255, 0, 0, 0.2); border: none;">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label text-white">Email Address</label>
                                    <input type="email" class="form-control text-white" id="email" name="email" value="{{ old('email') }}" required autofocus 
                                        style="background-color: rgba(255, 255, 255, 0.1); border: none; padding: 12px; border-radius: 8px;">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label text-white">Password</label>
                                    <input type="password" class="form-control text-white" id="password" name="password" required 
                                        style="background-color: rgba(255, 255, 255, 0.1); border: none; padding: 12px; border-radius: 8px;">
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label text-white" for="remember">Remember Me</label>
                                    </div>
                                    <a href="#" class="text-white text-decoration-none">Forgot Password?</a>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-lg fw-bold" 
                                        style="background: #d4a517; color: #000; border-radius: 8px; padding: 12px;">Login</button>
                                </div>
                            </form>
                            <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.2);">
                            <p class="text-center text-white">Don't have an account? 
                                <a href="{{ route('register') }}" class="text-warning text-decoration-none fw-bold">Register here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('content')
<div class="d-flex flex-column min-vh-100" style="background-color: #000;">
    <section class="flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); color: #fff; border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 class="text-center mb-3 fw-bold text-white">Register for InternTrack</h2>
                            <p class="text-center mb-4 text-white">Create an account to get started</p>

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

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label text-white">Full Name</label>
                                    <input type="text" class="form-control text-white" id="name" name="name" value="{{ old('name') }}" required autofocus 
                                        style="background-color: rgba(255, 255, 255, 0.1); border: none; padding: 12px; border-radius: 8px;">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-white">Email Address</label>
                                    <input type="email" class="form-control text-white" id="email" name="email" value="{{ old('email') }}" required 
                                        style="background-color: rgba(255, 255, 255, 0.1); border: none; padding: 12px; border-radius: 8px;">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label text-white">Password</label>
                                    <input type="password" class="form-control text-white" id="password" name="password" required 
                                        style="background-color: rgba(255, 255, 255, 0.1); border: none; padding: 12px; border-radius: 8px;">
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label text-white">Confirm Password</label>
                                    <input type="password" class="form-control text-white" id="password_confirmation" name="password_confirmation" required 
                                        style="background-color: rgba(255, 255, 255, 0.1); border: none; padding: 12px; border-radius: 8px;">
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label text-white">Role</label>
                                    <select class="form-control text-white" id="role" name="role" required 
                                        style="background-color: rgba(255, 255, 255, 0.1); border: none; padding: 12px; border-radius: 8px;">
                                        <option value="student">Student</option>
                                        <option value="supervisor">Supervisor</option>
                                        <option value="coordinator">Coordinator</option>
                                    </select>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-lg fw-bold" 
                                        style="background: #d4a517; color: #000; border-radius: 8px; padding: 12px;">Register</button>
                                </div>
                            </form>
                            <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.2);">
                            <p class="text-center text-white">Already have an account? 
                                <a href="{{ route('login') }}" class="text-warning text-decoration-none fw-bold">Login here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

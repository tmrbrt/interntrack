@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Welcome, {{ Auth::user()->name }}!</h2>
                        <p class="text-center">Please update your profile information below.</p>

                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.supervisor.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Company Name Field -->
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $supervisorProfile->company_name }}" required>
                            </div>

                            <!-- Company Address Field -->
                            <div class="mb-3">
                                <label for="company_address" class="form-label">Company Address</label>
                                <input type="text" class="form-control" id="company_address" name="company_address" value="{{ $supervisorProfile->company_address }}" required>
                            </div>

                            <!-- Department Field -->
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="department" name="department" value="{{ $supervisorProfile->department }}" required>
                            </div>

                            <!-- Profile Picture Upload Field -->
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                                <!-- Display existing profile picture if available -->
                                @if ($supervisorProfile->profile_picture)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $supervisorProfile->profile_picture) }}" alt="Profile Picture" width="100">
                                    </div>
                                @endif
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Save Profile</button>
                            </div>

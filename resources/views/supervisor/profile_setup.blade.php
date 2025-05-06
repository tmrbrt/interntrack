@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Welcome, {{ Auth::user()->name }}!</h2>
                        <p class="text-center">Please fill up your profile information.</p>

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

                        <form method="POST" action="{{ route('supervisor.profile.setup') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" readonly>
                            </div>
                            <div class="mb-3">
    <label for="company_name" class="form-label">Company Name</label>
    <input type="text" class="form-control" id="company_name" name="company_name" required>
</div>

<div class="mb-3">
    <label for="company_address" class="form-label">Company Address</label>
    <input type="text" class="form-control" id="company_address" name="company_address" required>
</div>
                            
                            <div class="mb-3">
                                <label for="department" class="form-label">Position</label>
                                <input type="text" class="form-control" id="department" name="department" required>
                            </div>
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Upload Profile Picture</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Save Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

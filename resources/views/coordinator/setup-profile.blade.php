@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Coordinator Profile Setup</h2>

                        <form method="POST" action="{{ route('coordinator.profile.store') }}">
                            @csrf  <!-- CSRF Token for Security -->

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <!-- Department Dropdown -->
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-control" id="department" name="department" required>
                                    <option value="">Select Department</option>
                                    <option value="CAS">College of Arts And Science (CAS)</option>
                                    <option value="CBA">College of Business Administration (CBA)</option>
                                    <option value="Accountancy">College of Accountancy</option>
                                    <option value="CCJ">College of Criminal Justice (CCJ)</option>
                                    <option value="CITCS">College of Information, Technology and Computer Studies (CITCS)</option>
                                    <option value="COM">College of Medicine (COM)</option>
                                    <option value="Education">College of Teacher Education</option>
                                    <option value="PublicPolicy">Institute of Public Policy and Governance</option>
                                    <option value="SocialWork">Institute of Social Work</option>
                                </select>
                            </div>

                            <!-- Save Profile Button -->
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary">Save Profile</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

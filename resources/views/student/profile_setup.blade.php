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

                        <form method="POST" action="{{ route('student.profile.setup') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                            </div>
                            <div class="mb-3">
                                <label for="student_number" class="form-label">Student Number</label>
                                <input type="text" class="form-control" id="student_number" name="student_number" required>
                            </div>
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
                            <div class="mb-3">
                                <label for="college" class="form-label">Course</label>
                                <select class="form-control" id="college" name="college" required>
                                    <option value="">Select Course</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Upload Profile Picture</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture" required>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const courseDropdown = document.getElementById("college");
        const departmentDropdown = document.getElementById("department");

        const courses = {
            "CAS": ["Bachelor of Arts in Communication", "Bachelor of Science in Psychology"],
            "CBA": [
                "Bachelor of Science in Business Administration - Major in Human Resource Development Management",
                "Bachelor of Science in Business Administration - Major in Marketing Management",
                "Bachelor of Science in Business Administration - Major in Operations Management"
            ],
            "Accountancy": ["Bachelor of Science in Accountancy"],
            "CCJ": ["Bachelor of Science in Criminology"],
            "CITCS": [
                "Bachelor of Science in Computer Science",
                "Bachelor of Science in Information Technology",
                "Associate in Computer Technology"
            ],
            "COM": ["Doctor of Medicine"],
            "Education": [
                "Bachelor of Elementary Education (BEEd) - General Elementary Education",
                "Bachelor of Secondary Education (BSEd) - Major in Science",
                "Bachelor of Secondary Education (BSEd) - Major in English",
                "Bachelor of Secondary Education (BSEd) - Major in Social Science"
            ],
            "PublicPolicy": ["Bachelor of Public Administration", "Bachelor of Arts in Political Science"],
            "SocialWork": ["Bachelor of Science in Social Work"]
        };

        departmentDropdown.addEventListener("change", function() {
            const selectedDepartment = this.value;
            courseDropdown.innerHTML = "<option value=''>Select Course</option>";

            if (courses[selectedDepartment]) {
                courses[selectedDepartment].forEach(course => {
                    const option = document.createElement("option");
                    option.value = course;
                    option.textContent = course;
                    courseDropdown.appendChild(option);
                });
            }
        });
    });
</script>
@endsection

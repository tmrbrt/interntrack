@extends('layouts.app')

@include('layouts.coordsidebar')

@section('content')
<div class="d-flex">
    <div class="container-fluid" style="margin-left: 260px; background-color: #121212; color: #ffffff; min-height: 100vh;">
        <div class="row justify-content-center">
            <div class="col-md-8 m-5">
                <div class="card shadow-lg border-0 bg-dark text-light">
                    <div class="card-body text-center p-5">
                        <h1 class="fw-bold text-white">Welcome, {{ $coordinator->name }}!</h1>
                        <p class="text-secondary">You are logged in as a Coordinator.</p>

                        <!-- Row for Two Graphs -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5 class="text-white">Total Students</h5>
                                <canvas id="totalStudentsChart" style="max-height: 200px;"></canvas>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-white">Students per Department</h5>
                                <canvas id="departmentChart" style="max-height: 200px;"></canvas>
                            </div>
                        </div>

                        <!-- Dashboard Sections -->
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card text-white bg-secondary mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Students</h5>
                                        <p class="card-text">Manage student profiles and progress.</p>
                                        <a href="#" class="btn btn-dark btn-sm">View</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card text-white bg-dark mb-3 shadow-sm border-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Supervisors</h5>
                                        <p class="card-text">Oversee assigned supervisors.</p>
                                        <a href="#" class="btn btn-light btn-sm">Manage</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card text-white bg-secondary mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Messages</h5>
                                        <p class="card-text">Chat Supervisors and Students.</p>
                                        <a href="#" class="btn btn-dark btn-sm">Check</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Total Students Chart
        var totalStudentsCtx = document.getElementById('totalStudentsChart').getContext('2d');
        new Chart(totalStudentsCtx, {
            type: 'bar',
            data: {
                labels: ['Total Students'],
                datasets: [{
                    label: 'Number of Students',
                    data: [{{ $studentCount }}],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });

        // Department-wise Students Chart
        var departmentCtx = document.getElementById('departmentChart').getContext('2d');
        new Chart(departmentCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($studentCounts)) !!},
                datasets: [{
                    label: 'Students Per Department',
                    data: {!! json_encode(array_values($studentCounts)) !!},
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>

@endsection

<style>
    .nav-link {
        padding: 10px;
        transition: background 0.3s ease;
        color: white;
    }
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
    }
</style>

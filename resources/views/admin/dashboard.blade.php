@extends('layouts.app') 

@include('layouts.adminsidebar')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 bg-black text-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-dark text-light shadow-lg border-0">
                    <div class="card-body text-center p-5">
                        <h1 class="fw-bold text-warning">Welcome, {{ $admin->name }}!</h1>
                        <p class="text-muted">You are logged in as an Admin.</p>

                        <!-- Dashboard Sections -->
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card bg-secondary text-white mb-3 shadow-sm" style="height: 150px;">
                                    <div class="card-body">
                                        <h6 class="card-title">Students</h6>
                                        <p class="card-text">Manage student profiles and progress.</p>
                                        <a href="{{ route('admin.students.index') }}" class="btn btn-light btn-sm">View</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-success text-white mb-3 shadow-sm" style="height: 150px;">
                                    <div class="card-body">
                                        <h6 class="card-title">Supervisors</h6>
                                        <p class="card-text">Oversee assigned supervisors.</p>
                                        <a href="{{ route('admin.supervisors.index') }}" class="btn btn-light btn-sm">Manage</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-warning text-dark mb-3 shadow-sm" style="height: 150px;">
                                    <div class="card-body">
                                        <h6 class="card-title">Reports</h6>
                                        <p class="card-text">Access reports and evaluations.</p>
                                        <a href="#" class="btn btn-dark btn-sm">Check</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Analytics Section (Graph) -->
                        <div class="row mt-4 justify-content-center">
                            <div class="col-md-10">
                                <div class="card bg-dark text-light shadow-sm">
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-center text-warning">User Analytics</h6>
                                        <canvas id="userChart" style="max-height: 250px;"></canvas>
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
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var barCtx = document.getElementById('userChart').getContext('2d');
        var userChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Students', 'Supervisors', 'Coordinators'],
                datasets: [{
                    label: 'User Count',
                    data: [{{ $studentsCount }}, {{ $supervisorsCount }}, {{ $coordinatorsCount }}],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107'],
                    borderColor: ['#0056b3', '#1e7e34', '#d39e00'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: { color: "#ffffff" }, // White text for x-axis labels
                        grid: { color: "rgba(255, 255, 255, 0.2)" } // Light grid lines
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: "#ffffff" }, // White text for y-axis labels
                        grid: { color: "rgba(255, 255, 255, 0.2)" } // Light grid lines
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: "#ffffff" } // White legend text
                    }
                }
            }
        });
    });
</script>

@endsection

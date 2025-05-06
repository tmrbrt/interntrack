<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AttendanceController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

//student User
Route::get('/profile/setup', [StudentProfileController::class, 'showProfileSetupForm'])->name('student.profile.setup');


// Authentication Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/student/profile/setup', [ProfileController::class, 'show'])->name('student.profile.show');
    Route::post('/student/profile/setup', [ProfileController::class, 'setupProfile'])->name('student.profile.setup'); 


Route::post('/profile/setup', [ProfileController::class, 'setupProfile'])->name('student.profile.setup');
Route::get('/profile/setup', [StudentProfileController::class, 'showProfileSetupForm'])->name('student.profile.setup');


Route::get('/dashboard', function () {
        return view('dashboard'); // Make sure this view exists in resources/views/dashboard.blade.php
    })->name('dashboard')->middleware('auth');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:coordinator'])->group(function () {
    Route::get('/coordinator/dashboard', [CoordinatorController::class, 'index'])->name('coordinator.dashboard');
    });
    
Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    });
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});

    Route::get('/student/profile/setup', [StudentProfileController::class, 'setup'])->name('student.profile.setup');
    Route::get('/supervisor/dashboard', [SupervisorDashboardController::class, 'index'])->name('supervisor.dashboard');
    Route::get('/coordinator/dashboard', [CoordinatorDashboardController::class, 'index'])->name('coordinator.dashboard');
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');;

Route::middleware(['auth'])->group(function () {
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    });
});
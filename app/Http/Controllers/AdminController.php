<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\CoordinatorProfile;
use App\Models\SupervisorProfile;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $admin = Auth::user();
            return view('admin.dashboard', compact('admin'));
        }
        $students = StudentProfile::all();
        return view('admin.students.index', compact('students'));
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }

    public function userManagement()
{
    $users = User::with(['studentProfile', 'coordinatorProfile', 'supervisorProfile'])->get();
    return view('admin.user-management', compact('users'));
}


public function dashboard() {
    $admin = Auth::user();
    $studentsCount = User::where('role', 'student')->count();
    $coordinatorsCount = User::where('role', 'coordinator')->count();
    $supervisorsCount = User::where('role', 'supervisor')->count();

    return view('admin.dashboard', compact('admin', 'studentsCount', 'coordinatorsCount', 'supervisorsCount'));
}


}

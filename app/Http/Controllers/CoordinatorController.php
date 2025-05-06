<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\DB;

class CoordinatorController extends Controller
{
    public function index()
    {
        return view('coordinator.dashboard'); // Match your file path
    }

    public function studentProgress()
{
    $students = Student::with('attendances')->get();
    $assignments = Assignment::with('submissions.student')->get();

    return view('coordinator.student_progress', compact('students', 'assignments'));
}

public function dashboard()
{
    // Fetch student counts grouped by department
    $departmentCounts = StudentProfile::select('department', DB::raw('COUNT(*) as total'))
        ->groupBy('department')
        ->get();

    // Pass data to the view
    return view('coordinator.dashboard', compact('departmentCounts'));
}
}

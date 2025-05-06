<?php

namespace App\Http\Controllers;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoordinatorDashboardController extends Controller
{
    public function index()
{
    $coordinator = Auth::user(); // Get the logged-in coordinator
    $studentCount = StudentProfile::count(); // Get total number of students

    // Get student count grouped by department
    $studentCounts = StudentProfile::selectRaw('department, COUNT(*) as count')
        ->groupBy('department')
        ->pluck('count', 'department')
        ->toArray(); // Convert to array for JSON encoding

    return view('coordinator.dashboard', compact('coordinator', 'studentCount', 'studentCounts'));
}


    public function dashboard()
    {
        $coordinator = auth()->user(); // Retrieve the logged-in coordinator
        $studentCount = StudentProfile::count(); // Get total number of students
    
        // Get student count grouped by department
        $studentCounts = StudentProfile::selectRaw('department, COUNT(*) as count')
            ->groupBy('department')
            ->pluck('count', 'department')
            ->toArray(); // Convert to array for JSON encoding
    
        return view('coordinator.dashboard', compact('coordinator', 'studentCount', 'studentCounts'));
    }
    

}


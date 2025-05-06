<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\User;
use App\Models\OjtConfiguration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Auth;

class StudentProgressController extends Controller
{
    public function index()
    {
        // Fetch students with attendance records
        $students = User::whereHas('attendances')->with('attendances')->get();
        
        // Fetch all attendance records
        $attendances = Attendance::all(); // Make sure this is included
    
        // Fetch assignments
        $assignments = Assignment::with('submissions.student')->get();
    
        // Calculate total rendered hours for each student
        foreach ($students as $student) {
            $totalRenderedHours = $student->attendances->sum(function ($attendance) {
                if ($attendance->time_in && $attendance->time_out) {
                    return Carbon::parse($attendance->time_in)->diffInHours(Carbon::parse($attendance->time_out));
                }
                return 0;
            });
    
            $student->rendered_hours = round($totalRenderedHours, 2);
            $student->required_hours = 40; // Example required hours
        }
    
        // Ensure attendances is passed to the view
        return view('coordinator.student_progress', compact('students', 'assignments', 'attendances'));
    }
    
    
    public function getRenderedHours()
    {
        $attendances = Attendance::with('student')->get();
        
        foreach ($attendances as $attendance) {
            $totalRenderedHours = Attendance::where('student_id', $attendance->student_id)->get()->sum(function ($record) {
                if ($record->time_in && $record->time_out) {
                    return Carbon::parse($record->time_in)->diffInHours(Carbon::parse($record->time_out));
                }
                return 0;
            });

            $attendance->rendered_hours = $totalRenderedHours;
            $attendance->required_hours = 40; 
        }

        return view('coordinator.student_progress', compact('attendances'));
    }

    
public function studentProgress()
{
    // Fetch required hours from the ojt_configurations table
    $requiredHours = OjtConfiguration::value('required_hours');

    // Get unique student IDs from the attendances table
    $studentIds = Attendance::pluck('student_id')->unique();

    // Fetch students who have attendance records
    $students = Student::whereIn('id', $studentIds)
        ->select('id', 'name', 'rendered_hours')
        ->get()
        ->map(function ($student) use ($requiredHours) {
            $student->required_hours = $requiredHours; // Assign required hours to each student
            return $student;
        });

    // Fetch assignments with student submissions
    $assignments = Assignment::with('submissions.student')->get();

    return view('coordinator.student_progress', compact('students', 'assignments'));
}

public function showAttendance()
{
    // Retrieve attendance records with associated student data
    $attendances = Attendance::with('student')->get()->groupBy('student_id');

    // Retrieve assignments (if applicable)
    $assignments = Assignment::with('submissions.student')->get();

    return view('coordinator.student_progress', compact('attendances', 'assignments'));
}


}

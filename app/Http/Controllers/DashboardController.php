<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\OjtConfiguration;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Calculate the number of present days for the current month
    $monthlyAttendanceCount = Attendance::where('student_id', $user->id)
        ->whereMonth('date', now()->month)
        ->whereYear('date', now()->year)
        ->whereNotNull('time_in')
        ->count();

    // Total days in the current month
    $totalDaysInMonth = now()->daysInMonth;

    // Calculate total hours rendered in the month
    $totalHoursRendered = Attendance::where('student_id', $user->id)
        ->whereMonth('date', now()->month)
        ->whereYear('date', now()->year)
        ->whereNotNull('time_in')
        ->whereNotNull('time_out')
        ->get()
        ->sum(function ($attendance) {
            $timeIn = \Carbon\Carbon::parse($attendance->time_in);
            $timeOut = \Carbon\Carbon::parse($attendance->time_out);
            return $timeIn->diffInMinutes($timeOut) / 60; // Get decimal hours
        });

    // Limit to 2 decimal places
    $totalHoursRendered = round($totalHoursRendered, 2);

    // Fetch the required hours for the student's department from ojt_configurations
    $studentProfile = \App\Models\StudentProfile::where('user_id', $user->id)->first();
$requiredHours = OjtConfiguration::where('college', $studentProfile->college)
                                  ->where('department', $studentProfile->department)
                                  ->value('required_hours');

    return view('student.dashboard', compact('monthlyAttendanceCount', 'totalDaysInMonth', 'totalHoursRendered', 'requiredHours'));
}

    public function getMonthlyAttendanceCount()
{
    $user = Auth::user();

    $count = Attendance::where('user_id', $user->id) // Filter by user ID
        ->whereMonth('date', now()->month)
        ->whereYear('date', now()->year)
        ->whereNotNull('time_in')
        ->count();

    return $count;
}

public function redirectToDashboard()
{
    $user = Auth::user();

    if (!$user) {
        return redirect('/login');
    }

    switch ($user->role) {
        case 'student':
            return redirect()->route('student.dashboard');
        case 'supervisor':
            return redirect()->route('supervisor.dashboard');
        case 'coordinator':
            return redirect()->route('coordinator.dashboard');
        case 'admin':
            return redirect()->route('admin.dashboard');
        default:
            return redirect('/login')->with('error', 'Invalid role');
    }
}

}

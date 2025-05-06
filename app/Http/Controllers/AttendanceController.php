<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\OjtConfiguration;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    
    public function index() 
    {
        $supervisorId = auth()->id();
        $userId = auth()->id();
        $userRole = Auth::user()->role;
        $today = now()->toDateString();
        $currentTime = now()->toTimeString();
    
        // Remove attendance records for coordinators to prevent overlap
        Attendance::whereIn('student_id', function ($query) {
            $query->select('id')
                ->from('users')
                ->where('role', 'coordinator');
        })->delete();
    
        // Only students should have attendance records
        if ($userRole === 'student') {
            $attendance = Attendance::where('student_id', $userId)
                ->where('date', $today)
                ->first();
    
            if (!$attendance) {
                $attendance = Attendance::create([
                    'student_id' => $userId,
                    'date' => $today,
                    'time_in' => $currentTime,
                    'time_out' => null,
                ]);
            }
        }
    
        $recentAttendance = Attendance::where('student_id', $userId)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();
    
        $attendances = Attendance::where('student_id', $userId)
            ->orderBy('date', 'desc')
            ->get();
    
        $attendanceData = $attendances->map(function ($attendance) {
            return [
                'title' => 'Present',
                'start' => $attendance->date,
                'timestamp' => "Time In: {$attendance->time_in}<br>Time Out: {$attendance->time_out}",
                'color' => '#28a745',
            ];
        });
    
        $daysInMonth = now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = now()->startOfMonth()->addDays($i - 1)->toDateString();
            if (!$attendances->where('date', $date)->count()) {
                $attendanceData->push([
                    'title' => 'Absent',
                    'start' => $date,
                    'color' => '#dc3545',
                ]);
            }
        }
    
        // Fetch required hours from ojt_configurations
        $ojtConfigurations = OjtConfiguration::all()->mapWithKeys(function ($config) {
            return [$config->department_id . '-' . $config->college_id => $config->required_hours];
        });
    
        // Filter attendance for assigned students for supervisors
        if ($userRole === 'supervisor') {
            $assignedStudentIds = \DB::table('student_profiles')
                ->where('supervisor_id', $supervisorId)
                ->pluck('user_id');
    
            $groupedAttendances = Attendance::whereIn('student_id', $assignedStudentIds)
                ->with(['student.department', 'student.college'])
                ->get()
                ->groupBy('student_id');
    
            return view('supervisor.attendance', compact('groupedAttendances', 'ojtConfigurations'));
        }
    
        // Coordinators can view all attendance records
        if ($userRole === 'coordinator') {
            $groupedAttendances = Attendance::with(['student.department', 'student.college'])->get()->groupBy('student_id');
            return view('coordinator.attendance', compact('groupedAttendances', 'ojtConfigurations'));
        }
    
        // Students get their own attendance records
        return view('attendance', compact('recentAttendance', 'attendances', 'ojtConfigurations'));
    }
    
    


    public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'time_in' => 'required',
        'time_out' => 'nullable',
    ]);

    $attendance = Attendance::where('student_id', Auth::id())
        ->where('date', $request->date)
        ->first();

    if ($attendance) {
        // Update existing record
        $attendance->update([
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
        ]);
    } else {
        // Create a new record (should rarely happen now)
        Attendance::create([
            'student_id' => Auth::id(),
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
        ]);
    }

    return redirect()->route('student.dashboard')->with('success', 'Attendance recorded successfully!');
}


public function fetchAttendance(Request $request)
{
    $attendances = Attendance::where('student_id', Auth::id())->orderBy('date', 'desc')->get();
    
    if ($attendances->isEmpty()) {
        return response()->json([], 200);
    }

    $events = $attendances->map(function ($record) {
        return [
            'title' => $record->time_in ? 'Present' : 'Absent',
            'start' => $record->date,
            'color' => $record->time_in ? 'green' : 'red',
            'time_in' => $record->time_in,
            'time_out' => $record->time_out,
        ];
    });

    return response()->json($events);
}

    
public function getAttendanceData()
{
    $events = Attendance::all()->map(function ($attendance) {
        return [
            'title' => 'Present',
            'start' => $attendance->date,
            'extendedProps' => [
                'time_in' => $attendance->time_in,
                'time_out' => $attendance->time_out,
            ],
        ];
    });

    return response()->json($events);
}
public function supervisorView()
{
    $userId = auth()->id();

    // Get students assigned to the supervisor from student_profiles
    $studentIds = \App\Models\StudentProfile::where('supervisor_id', $userId)->pluck('user_id');

    $attendances = Attendance::with('student')
        ->whereIn('student_id', $studentIds)
        ->orderBy('date', 'desc')
        ->get()
        ->groupBy('student_id');

    return view('supervisor.attendance', compact('attendances'));
}



public function showAttendance()
{
    $userId = auth()->id(); // Get the logged-in user's ID

    $recentAttendance = Attendance::where('student_id', $userId)
        ->orderBy('date', 'desc')
        ->take(10)
        ->get(); // ✅ Ensure it's a collection


    return view('attendance', compact('recentAttendance'));
}

public function coordinatorView()
{
    $attendances = Attendance::with('student')->get()->groupBy('student_id');

    // Fetch OJT configurations and use 'college' and 'department' columns for key
    $ojtConfigurations = OjtConfiguration::all()->keyBy(function($item) {
        return $item->department . '-' . $item->college; // Adjusted to match your database columns
    });

    // Log OJT configurations to ensure they are correct
    \Log::debug('OJT Configurations:', $ojtConfigurations->toArray());

    // Pass the grouped attendances and OJT configurations to the view
    return view('coordinator.attendance', compact('attendances', 'ojtConfigurations'));
}


public function timeOut(Request $request)
{
    $attendance = Attendance::where('student_id', auth()->id())
        ->whereDate('date', Carbon::today())
        ->whereNotNull('time_in')
        ->whereNull('time_out')
        ->first();

    if (!$attendance) {
        return back()->with('error', 'No valid time-in record found.');
    }

    // Calculate the time difference
    $timeIn = Carbon::parse($attendance->time_in);
    $now = Carbon::now();
    $hoursLogged = $timeIn->diffInHours($now);

    if ($hoursLogged < 6) {
        return back()->with('error', 'You must be logged in for at least 6 hours before timing out.');
    }

    // Update time_out if the condition is met
    $attendance->update(['time_out' => $now]);

    return back()->with('success', 'Time out recorded successfully.');
}

public function attendanceRecords()
{
    $attendances = Attendance::with(['student.department', 'student.college'])->get()->groupBy('student_id');

    // Fetch all OJT configurations and create an associative array for lookup
    $requiredHours = OjtConfiguration::all()->pluck('required_hours', function ($item) {
        return $item->department_id . '-' . $item->college_id;
    });

    return view('attendance.index', compact('attendances', 'requiredHours'));
}
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupervisorProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\DB;


class SupervisorController extends Controller
{
    public function dashboard()
{
    return view('supervisor.dashboard'); // Ensure this view exists
}

    public function index()
    {
        return view('supervisor.dashboard'); // Ensure this view exists in resources/views/supervisor/
    }

    public function setupProfile()
    {
        return view('supervisor.profile_setup'); // Ensure this view exists
    }

    // Show profile setup page
    public function profileSetup()
    {
        return view('supervisor.profile_setup');
    }
    public function announcement()
{
    $announcements = Announcement::latest()->get();
    return view('supervisor.announcement', compact('announcements'));
}
public function showAttendance()
{
    $groupedAttendances = Attendance::with('student') // Load student relationship
    ->get()
    ->groupBy('student_id'); // Group by student_id

return view('supervisor.attendance', compact('groupedAttendances'));

}
    // Store supervisor profile data
    public function storeProfile(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        $profile = SupervisorProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'address' => $request->address,
                'is_completed' => true, // Mark as completed
            ]
        );

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profile->update(['profile_picture' => $path]);
        }

        return redirect()->route('supervisor.dashboard')->with('success', 'Profile updated successfully.');
    }

    public function yourStudents()
{
    $supervisorId = Auth::id(); // Get logged-in supervisor ID

    // Fetch students without a supervisor
    $students = StudentProfile::whereNull('supervisor_id')->get();

    // Fetch students assigned to this supervisor
    $assignedStudents = StudentProfile::where('supervisor_id', $supervisorId)->get();

    return view('supervisor.yourstudents', compact('students', 'assignedStudents'));
}

public function assignStudent(Request $request)
{
    $supervisorId = Auth::id();
    $student = StudentProfile::findOrFail($request->student_id);

    // Assign the student to the supervisor
    $student->supervisor_id = $supervisorId;
    $student->save();

    return redirect()->back()->with('success', 'Student assigned successfully.');
}

public function unassignStudent(Request $request)
{
    $supervisorId = Auth::id();
    $student = StudentProfile::where('id', $request->student_id)
        ->where('supervisor_id', $supervisorId) // Ensure only the assigned supervisor can unassign
        ->firstOrFail();

    // Remove the supervisor assignment
    $student->supervisor_id = null;
    $student->save();

    return redirect()->back()->with('success', 'Student unassigned successfully.');
}

    
}

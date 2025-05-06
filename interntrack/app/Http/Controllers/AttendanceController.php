<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('attendance');
    }

    public function store(Request $request)
    {
        $request->validate([
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
        ]);

        Attendance::create([
            'student_id' => Auth::id(),
            'date' => now()->toDateString(),
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance marked successfully.');
    }
}

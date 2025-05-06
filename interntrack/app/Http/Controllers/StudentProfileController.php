<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function show()
    {
        return view('profile_setup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'student_number' => 'required|string|max:50|unique:users,student_number,' . Auth::id(),
            'college' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user = Auth::user();

        // Handle Profile Picture Upload
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $profilePicturePath;
        }

        // Update user profile
        $user->address = $request->address;
        $user->date_of_birth = $request->date_of_birth;
        $user->student_number = $request->student_number;
        $user->college = $request->college;
        $user->department = $request->department;
        $user->profile_completed = true;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profile setup completed successfully!');
    }

    public function showProfileSetupForm()
{
    return view('student.profile_setup'); // Make sure the view file exists
}

}

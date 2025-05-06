<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentProfile;

class ProfileController extends Controller
{
    public function show()
    {
        return view('student.profile_setup');
    }

    public function setupProfile(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'date_of_birth' => 'required|date',
            'student_number' => 'required',
            'college' => 'required',
            'department' => 'required',
            'profile_picture' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        // Store profile picture
        $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');

        // Create or update student profile
        StudentProfile::updateOrCreate(
            ['user_id' => $user->id], // Check if a profile exists for the user
            [
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'student_number' => $request->student_number,
                'college' => $request->college,
                'department' => $request->department,
                'profile_picture' => $profilePicturePath,
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Profile setup completed!');
    }
}

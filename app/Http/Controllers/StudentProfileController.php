<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\StudentProfile;

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
            'student_number' => 'required|string|max:50|unique:student_profiles,student_number',
            'college' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);
    
        $user = Auth::user();
    
        // Handle Profile Picture Upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }
    
        // Store data in student_profiles table
        StudentProfile::updateOrCreate(
            ['user_id' => $user->id], // Ensure profile is linked to the user
            [
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'student_number' => $request->student_number,
                'college' => $request->college,
                'department' => $request->department,
                'profile_picture' => $profilePicturePath,
                'is_completed' => true,
            ]
        );
    
        return redirect()->route('dashboard')->with('success', 'Profile setup completed successfully!');
    }
    

    public function showProfileSetupForm()
{
    return view('student.profile_setup'); // Make sure the view file exists
}

public function edit()
{
    $studentProfile = auth()->user()->studentProfile;
    $profile = auth()->user()->studentProfile; // or wherever you store the user's profile data

    return view('student.profile', compact('profile')); // Correct view path here
}

public function update(Request $request)
{
    $request->validate([
        'address' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'student_number' => 'required|string|max:20',
        'department' => 'required|string|max:100',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $studentProfile = StudentProfile::where('user_id', Auth::id())->first();
    $studentProfile->address = $request->address;
    $studentProfile->date_of_birth = $request->date_of_birth;
    $studentProfile->student_number = $request->student_number;
    $studentProfile->department = $request->department;

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        $profilePicture = $request->file('profile_picture')->store('profile_pictures', 'public');
        $studentProfile->profile_picture = $profilePicture;
    }

    $studentProfile->save();

    return redirect()->route('student.profile.edit')->with('success', 'Profile updated successfully.');
}

public function setup()
{
    return view('student.profile_setup'); // Ensure this view file exists
}


}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\CoordinatorProfile;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    // Show profile based on user role
    public function show()
    {
        $user = Auth::user();
        $profile = null;

        if ($user->role == 'student') {
            $profile = StudentProfile::where('user_id', $user->id)->first();
        } elseif ($user->role == 'coordinator') {
            $profile = CoordinatorProfile::where('user_id', $user->id)->first();
        } elseif ($user->role == 'supervisor') {
            $profile = SupervisorProfile::where('user_id', $user->id)->first();
        }

        return view('show', compact('user', 'profile'));
    }

    // Update existing profile for all users
    public function update(Request $request)
{
    $user = Auth::user();

    // Validation rules
    $rules = [
        'profile_picture' => 'nullable|image|max:2048', // Profile picture is optional
    ];

    // Only require address and date_of_birth for students
    if ($user->role === 'student') {
        $rules['address'] = 'required|string|max:255';
        $rules['date_of_birth'] = 'required|date';
    } else {
        $rules['address'] = 'nullable|string|max:255'; // Optional for other roles
        $rules['date_of_birth'] = 'nullable|date'; // Optional for other roles
    }

    $validatedData = $request->validate($rules);

    // Find the correct profile based on user role
    if ($user->role == 'student') {
        $profile = StudentProfile::where('user_id', $user->id)->first();
    } elseif ($user->role == 'coordinator') {
        $profile = CoordinatorProfile::where('user_id', $user->id)->first();
    } elseif ($user->role == 'supervisor') {
        $profile = SupervisorProfile::where('user_id', $user->id)->first();
    }

    if (!$profile) {
        return back()->withErrors(['profile' => 'Profile not found.']);
    }

    // Update only the provided fields
    $profile->fill($validatedData);

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        if ($profile->profile_picture) {
            \Storage::delete('public/' . $profile->profile_picture);
        }
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $profile->profile_picture = $path;
    }

    $profile->save();

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Define validation rules
    $rules = [
        'student_number' => 'nullable|string|max:50',
        'college' => 'nullable|string|max:100',
        'department' => 'nullable|string|max:100',
        'company_name' => 'nullable|string|max:255',
        'company_address' => 'nullable|string|max:255',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];

    // Address and Date of Birth required only for students
    if ($user->role === 'student') {
        $rules['address'] = 'required|string|max:255';
        $rules['date_of_birth'] = 'required|date';
    } else {
        $rules['address'] = 'nullable|string|max:255';
        $rules['date_of_birth'] = 'nullable|date';
    }

    // Validate input
    $validatedData = $request->validate($rules);

    // Fetch the correct profile based on the user's role
    if ($user->role == 'student') {
        $profile = StudentProfile::where('user_id', $user->id)->first();
    } elseif ($user->role == 'coordinator') {
        $profile = CoordinatorProfile::where('user_id', $user->id)->first();
    } elseif ($user->role == 'supervisor') {
        $profile = SupervisorProfile::where('user_id', $user->id)->first();
    } else {
        return back()->withErrors(['profile' => 'Profile not found.']);
    }

    if (!$profile) {
        return back()->withErrors(['profile' => 'Profile not found.']);
    }

    // ✅ Update profile details
    $profile->update($validatedData);

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        if ($profile->profile_picture) {
            \Storage::delete('public/' . $profile->profile_picture);
        }
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $profile->update(['profile_picture' => $path]);
    }

    return back()->with('success', 'Profile updated successfully.');
}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupervisorProfile;
use Illuminate\Support\Facades\Auth;

class SupervisorProfileController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the supervisor already has a profile
        $supervisorProfile = SupervisorProfile::firstOrNew(['user_id' => Auth::id()]);

        // Save the data
        $supervisorProfile->company_name = $request->company_name;
        $supervisorProfile->company_address = $request->company_address;
        $supervisorProfile->department = $request->department;

        // Handle Profile Picture Upload
        if ($request->hasFile('profile_picture')) {
            $imageName = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile_pictures'), $imageName);
            $supervisorProfile->profile_picture = 'profile_pictures/' . $imageName;
        }

        $supervisorProfile->user_id = Auth::id();
        $supervisorProfile->save();

        return redirect()->route('supervisor.dashboard')->with('success', 'Profile setup completed!');
    }

    public function edit()
    {
        // Fetch the supervisor profile based on the authenticated user
        $supervisorProfile = SupervisorProfile::where('user_id', Auth::id())->first();
        
        return view('profile.supervisor', compact('supervisorProfile'));
    }

    public function update(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Find the supervisor profile by user_id and update the data
        $supervisorProfile = SupervisorProfile::where('user_id', Auth::id())->first();
        $supervisorProfile->company_name = $request->company_name;
        $supervisorProfile->company_address = $request->company_address;
        $supervisorProfile->department = $request->department;

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture')->store('profile_pictures', 'public');
            $supervisorProfile->profile_picture = $profilePicture;
        }

        // Save the updated data
        $supervisorProfile->save();

        // Redirect back with a success message
        return redirect()->route('profile.supervisor.edit')->with('success', 'Profile updated successfully.');
    }
}

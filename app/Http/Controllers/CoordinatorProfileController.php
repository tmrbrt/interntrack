<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CoordinatorProfile; // Make sure this line is here to import the model


class CoordinatorProfileController extends Controller
{
    public function setupProfile()
    {
        return view('coordinator.setup-profile');
    }

    public function storeProfile(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            
        ]);

        // Update or create the coordinator profile
        CoordinatorProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'name' => $request->name,
                'department' => $request->department,

                'is_completed' => true,
            ]
        );

        // Redirect to the coordinator's dashboard after successful profile creation
        return redirect()->route('coordinator.dashboard');
    }

    public function edit()
    {
        // Fetch the coordinator profile based on the authenticated user
        $coordinatorProfile = CoordinatorProfile::where('user_id', Auth::id())->first();
        
        return view('profile.coordinator', compact('coordinatorProfile'));
    }

    public function update(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
        ]);

        // Find the coordinator profile by user_id and update the data
        $coordinatorProfile = CoordinatorProfile::where('user_id', Auth::id())->first();
        $coordinatorProfile->name = $request->name;
        $coordinatorProfile->department = $request->department;

        // Save the updated data
        $coordinatorProfile->save();

        // Redirect back with a success message
        return redirect()->route('profile.coordinator.edit')->with('success', 'Profile updated successfully.');
    }
}

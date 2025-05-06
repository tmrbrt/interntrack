<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Ensure this is imported
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\CoordinatorProfile;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with(['studentProfile', 'supervisorProfile', 'coordinatorProfile'])->get();
        return view('admin.user-management', compact('users'));
    }

    public function edit($id)
    {
        $user = User::with(['studentProfile', 'supervisorProfile', 'coordinatorProfile'])->findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Update common fields
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Update role-specific data
        if ($user->role === 'student') {
            StudentProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'student_number' => $request->student_number,
                    'college' => $request->college,
                    'department' => $request->department,
                ]
            );
        } elseif ($user->role === 'supervisor') {
            SupervisorProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $request->company_name,
                    'company_address' => $request->company_address,
                    'department' => $request->department,
                ]
            );
        } elseif ($user->role === 'coordinator') {
            CoordinatorProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'department' => $request->department,
                ]
            );
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }
}

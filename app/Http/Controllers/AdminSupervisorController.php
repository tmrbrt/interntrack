<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supervisor;

class AdminSupervisorController extends Controller
{
    public function index()
    {
        // Fetch all supervisors with user details
        $supervisors = Supervisor::with('user')->get();

        return view('admin.supervisors', compact('supervisors'));
    }

    public function update(Request $request, $user_id)
{
    $supervisor = Supervisor::where('user_id', $user_id)->firstOrFail();

    // Update supervisor details
    $supervisor->update([
        'company_name' => $request->company_name,
        'company_address' => $request->company_address,
        'department' => $request->department,
    ]);

    // Update user name
    if ($supervisor->user) {
        $supervisor->user->update([
            'name' => $request->name,
        ]);
    }

    return redirect()->route('admin.supervisors.index')->with('success', 'Supervisor updated successfully.');
}

public function destroy($user_id)
{
    $supervisor = Supervisor::where('user_id', $user_id)->firstOrFail();
    $supervisor->delete();

    return redirect()->route('admin.supervisors.index')->with('success', 'Supervisor deleted successfully.');
}
}

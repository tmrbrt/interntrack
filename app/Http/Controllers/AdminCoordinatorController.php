<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coordinator;
use App\Models\User;

class AdminCoordinatorController extends Controller
{
    public function index()
    {
        // ✅ Fetch all coordinators with user details
        $coordinators = Coordinator::with('user')->get(); // ✅ Use the correct variable name
    
        return view('admin.coordinators', compact('coordinators')); // ✅ Matches variable name
    }
    public function update(Request $request, $user_id)
    {
        $coordinator = Coordinator::where('user_id', $user_id)->firstOrFail();

        // ✅ Update coordinator details
        $coordinator->update([
            'department' => $request->department,
        ]);

        // ✅ Update user name
        if ($coordinator->user) {
            $coordinator->user->update([
                'name' => $request->name,
            ]);
        }

        return redirect()->route('admin.coordinators.index')->with('success', 'Coordinator updated successfully.');
    }

    public function destroy($user_id)
    {
        $coordinator = Coordinator::where('user_id', $user_id)->firstOrFail();
        $coordinator->delete();

        return redirect()->route('admin.coordinators.index')->with('success', 'Coordinator deleted successfully.');
    }
}
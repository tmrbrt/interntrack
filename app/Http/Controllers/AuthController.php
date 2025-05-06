<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\CoordinatorProfile;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function authenticated(Request $request, $user)
    {
        return $this->redirectBasedOnRole($user);
    }

    private function redirectBasedOnRole($user)
{
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'student') {
        $profileCompleted = StudentProfile::where('user_id', $user->id)->exists();
        return redirect()->route($profileCompleted ? 'student.dashboard' : 'student.profile.setup');
    }

    if ($user->role === 'supervisor') {
        $profileCompleted = SupervisorProfile::where('user_id', $user->id)->exists();
        return redirect()->route($profileCompleted ? 'supervisor.dashboard' : 'supervisor.profile.setup');
    }

    if ($user->role === 'coordinator') {
        $profileCompleted = CoordinatorProfile::where('user_id', $user->id)->exists();
        return redirect()->route($profileCompleted ? 'coordinator.dashboard' : 'coordinator.profile.setup');
    }

    return redirect()->route('dashboard');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    
}


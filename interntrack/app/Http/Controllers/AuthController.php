<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentProfile;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            if ($user->role === 'student') {
                $profile = StudentProfile::where('user_id', $user->id)->first();

                if ($profile && $profile->is_completed) { // Assuming 'is_completed' is a field in 'student_profiles'
                    return redirect()->route('student.dashboard');
                } else {
                    return redirect()->route('student.profile.setup'); // Redirect to profile setup if incomplete
                }
            }

            // Redirect supervisors and coordinators accordingly
            if ($user->role === 'supervisor') {
                return redirect()->route('supervisor.dashboard');
            }

            if ($user->role === 'coordinator') {
                return redirect()->route('coordinator.dashboard');
            }

            return redirect()->intended('/home');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }
    public function authenticated(Request $request, $user)
{
    if ($user->role === 'student') {
        return redirect()->route('student.dashboard');
    }

    return redirect()->route('home');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

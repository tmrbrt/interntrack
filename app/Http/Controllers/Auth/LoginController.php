<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Redirect to the intended page or dashboard
            return $this->redirectTo();
        }

        // If login fails, redirect back with errors
        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    // Handle the logout request
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Custom redirect logic after login
    protected function redirectTo()
    {
        $user = Auth::user();
    
        // Check if the user is a student and has no profile
        if ($user->role === 'student' && !$user->studentProfile) {
            return route('student.profile.setup');
        }
    
        // Redirect to the dashboard for other cases
        return '/dashboard';
    }

    protected function authenticated(Request $request, $user)
{
    session()->flash('success', 'You have successfully logged in.');
    
    dd(session('success')); // Check if the session is set correctly
    
    return redirect('/student/dashboard');

}


}
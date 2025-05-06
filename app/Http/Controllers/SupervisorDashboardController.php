<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SupervisorDashboardController extends Controller
{
    public function index()
    {
        $supervisor = Auth::user(); // Assuming the user is a supervisor
        return view('supervisor.dashboard', compact('supervisor'));
    }
    
}

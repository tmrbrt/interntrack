<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentProfile;
use App\Models\OjtConfiguration;



class OjtConfigurationController extends Controller
{
    // Display OJT Configuration Page
    public function index()
    {
        // Get distinct colleges and departments from student_profiles
        $data = StudentProfile::select('college', 'department')
            ->distinct()
            ->orderBy('college')
            ->orderBy('department')
            ->get();
            

            return view('admin.ojt-configuration', compact('data'));
    }

    // Store the OJT Configuration
    public function store(Request $request)
    {
        $request->validate([
            'college' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'hours' => 'required|integer|min:1',
        ]);

        // Save to OJT Configuration table
        OjtConfiguration::updateOrCreate(
            [
                'college' => $request->college,
                'department' => $request->department,
            ],
            [
                'hours' => $request->hours,
            ]
        );

        return redirect()->route('admin.ojt-config')->with('success', 'OJT Configuration saved successfully!');
    }
    public function setHours(Request $request)
{
    $request->validate([
        'college' => 'required|string',
        'department' => 'required|string',
        'hours' => 'required|integer|min:1',
    ]);

    OjtConfiguration::updateOrCreate(
        [
            'college' => $request->college,
            'department' => $request->department,
        ],
        [
            'required_hours' => $request->hours,
        ]
    );

    return redirect()->back()->with('success', 'OJT hours set successfully.');
}



}


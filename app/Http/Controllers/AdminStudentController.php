<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentProfile;

class AdminStudentController extends Controller
{
    public function index()
    {
        $students = StudentProfile::all();
        $students = StudentProfile::with('user')->get();
        return view('admin.students', compact('students'));
    }
    public function update(Request $request, $id)
{
    $student = StudentProfile::findOrFail($id);
    $student->update($request->all());

    return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
}
}

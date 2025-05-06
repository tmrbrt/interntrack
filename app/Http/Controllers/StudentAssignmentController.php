<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Announcement;

class StudentAssignmentController extends Controller {
    public function index() {
        $assignments = Assignment::latest()->get();
        $announcements = Announcement::latest()->get();
        
        return view('student.assignments', compact('assignments', 'announcements'));
    }

}

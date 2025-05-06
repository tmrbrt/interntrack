<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role === 'student') {
            $studentProfile = StudentProfile::where('user_id', $user->id)->first();
            
            if (!$studentProfile) {
                $assignments = collect();
            } else {
                $assignments = Assignment::where('supervisor_id', $studentProfile->supervisor_id)
                    ->with('submissions.student')
                    ->get();
            }
    
            return view('student.assignments', compact('assignments'));
        } 
        elseif ($user->role === 'supervisor') {
            // Show only assignments belonging to this supervisor
            $assignments = Assignment::where('supervisor_id', $user->id)
                ->with('submissions.student')
                ->get();
    
            return view('supervisor.assignments', compact('assignments'));
        } 
        elseif (in_array($user->role, ['coordinator', 'admin'])) {
            $assignments = Assignment::with('submissions.student')->get();
            return view('admin.assignments', compact('assignments'));
        } 
        else {
            abort(403, 'Unauthorized');
        }
    }
    
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'supervisor_id' => auth()->id(),
        ]);

        return redirect()->route('supervisor.assignments')->with('success', 'Assignment posted successfully.');
    }

    public function viewSubmissions()
    {
        $assignments = Assignment::with(['submissions.student'])->get();
        return view('coordinator.assignments', compact('assignments'));
    }

    public function edit(Assignment $assignment)
    {
        if (auth()->user()->id !== $assignment->supervisor_id) {
            return redirect()->route('supervisor.assignments')->with('error', 'Unauthorized action.');
        }
        return view('supervisor.edit_assignment', compact('assignment'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        if ($request->hasFile('file')) {
            if ($assignment->file_path) {
                Storage::disk('public')->delete($assignment->file_path);
            }
            $assignment->file_path = $request->file('file')->store('assignments', 'public');
        }

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $assignment->file_path,
        ]);

        return redirect()->route('supervisor.assignments')->with('success', 'Assignment updated successfully.');
    }

    public function destroy(Assignment $assignment)
    {
        if (auth()->user()->id !== $assignment->supervisor_id) {
            return redirect()->route('supervisor.assignments')->with('error', 'Unauthorized action.');
        }

        $assignment->delete();
        return redirect()->route('supervisor.assignments')->with('success', 'Assignment deleted successfully.');
    }

    public function autosave(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->title = $request->title;
        $assignment->description = $request->description;
        $assignment->save();
        
        return response()->json(['message' => 'Draft saved']);
    }
}    

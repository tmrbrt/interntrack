<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupervisorProfile; // Make sure this model exists
use Illuminate\Support\Facades\Auth;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;
use App\Models\Assignment;

class SubmissionController extends Controller

{

    public function storeProfile(Request $request)
    {
        $request->validate([
            'company_address' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'department' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        // Store the profile information
        $profile = SupervisorProfile::updateOrCreate(
            ['user_id' => $user->id], // Find or create
            [
                'company_address' => $request->company_address,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'department' => $request->department,
            ]
        );

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $profilePath = $request->file('profile_picture')->store('profiles', 'public');
            $profile->profile_picture = $profilePath;
            $profile->save();
        }

        return redirect()->route('supervisor.dashboard')->with('success', 'Profile updated successfully!');
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'submission' => 'required|file',
        ]);

        $user = Auth::user();

        // Check if the student has already submitted for this assignment
        $existingSubmission = Submission::where('assignment_id', $request->assignment_id)
                                        ->where('student_id', $user->id)
                                        ->first();

        if ($request->hasFile('submission')) {
            // Store the file using the 'public' disk
            $filePath = $request->file('submission')->store('submissions', 'public');

            if (!$filePath) {
                return redirect()->back()->with('error', 'File upload failed.');
            }

            if ($existingSubmission) {
                // Delete the previous file
                Storage::disk('public')->delete($existingSubmission->file_path);
                
                // Update the existing submission
                $existingSubmission->update([ 'file_path' => $filePath ]);
                return redirect()->back()->with('success', 'Submission updated successfully!');
            } else {
                // Create a new submission
                Submission::create([
                    'assignment_id' => $request->assignment_id,
                    'student_id' => $user->id,
                    'file_path' => $filePath,
                ]);
                return redirect()->back()->with('success', 'Submission uploaded successfully!');
            }
        } else {
            return redirect()->back()->with('error', 'No file was uploaded.');
        }
    }
    

    public function storeFeedback(Request $request, Submission $submission)
{
    $request->validate([
        'feedback' => 'required|string|max:1000',
    ]);

    // Ensure only the supervisor can provide feedback
    if (auth()->user()->role !== 'supervisor') {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    $submission->update(['feedback' => $request->feedback]);

    return redirect()->back()->with('success', 'Feedback submitted successfully.');
}

public function evaluation()
    {
        $assignments = Assignment::with(['submissions.student'])
            ->where('supervisor_id', auth()->id()) 
            ->get();

        return view('supervisor.evaluation', compact('assignments'));
    }

    public function grade(Request $request, Submission $submission)
{


    $request->validate([
        'grade' => 'required|integer|min:1|max:100',
        'feedback' => 'nullable|string',
    ]);

    // Debug to check if submission is correctly fetched
    if (!$submission) {
        return back()->with('error', 'Submission not found!');
    }

    // Update the grade and feedback
    $submission->grade = $request->grade;
    $submission->feedback = $request->feedback;
    $submission->save();

    return back()->with('success', 'Grade submitted successfully!');
}

public function viewSubmission(Submission $submission)
{
    // Check if the authenticated user is a supervisor
    if (auth()->user()->role !== 'supervisor') {
        return back()->with('error', 'Unauthorized access.');
    }

    // Check if the supervisor is assigned to this student
    $assignment = Assignment::where('id', $submission->assignment_id)
        ->where('supervisor_id', auth()->id())
        ->first();

    if (!$assignment) {
        return back()->with('error', 'You are not authorized to view this submission.');
    }

    // Provide the path to download or view the file
    $filePath = storage_path('app/public/' . $submission->file_path);

    if (!file_exists($filePath)) {
        return back()->with('error', 'File not found.');
    }

    return response()->file($filePath);
}



}

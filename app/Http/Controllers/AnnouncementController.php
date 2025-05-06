<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index() {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('student.announcements', compact('announcements'));
    }

    public function store(Request $request) {
        $request->validate([
            'message' => 'required|string',
            'file' => 'nullable|file|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('announcements', 'public');
        }

        Announcement::create([
            'message' => $request->message,
            'supervisor_id' => Auth::id(),
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Announcement posted successfully!');
    }

    public function edit($id)
{
    $announcement = Announcement::findOrFail($id);

    // Ensure only the owner (supervisor) can edit
    if (auth()->user()->role !== 'supervisor' || auth()->id() !== $announcement->supervisor_id) {
        abort(403, 'Unauthorized action.');
    }

    return view('supervisor.edit', compact('announcement'));
}


public function update(Request $request, $id)
{
    $announcement = Announcement::findOrFail($id);

    // Ensure only the owner (supervisor) can update
    if (auth()->user()->role !== 'supervisor' || auth()->id() !== $announcement->supervisor_id) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'message' => 'required|string',
        'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ]);

    // Handle file upload
    if ($request->hasFile('file')) {
        if ($announcement->file_path) {
            Storage::disk('public')->delete($announcement->file_path);
        }
        $filePath = $request->file('file')->store('announcements', 'public');
        $announcement->file_path = $filePath;
    }

    $announcement->message = $request->message;
    $announcement->save();

    return redirect()->route('supervisor.announcement')->with('success', 'Announcement updated successfully!');
}



public function destroy($id)
{
    $announcement = Announcement::findOrFail($id);

    // Ensure only the supervisor who created the announcement can delete it
    if (Auth::user()->role !== 'supervisor' || Auth::id() !== $announcement->supervisor_id) {
        return abort(403, 'Unauthorized action.');
    }

    // Delete file if exists
    if ($announcement->file_path) {
        Storage::disk('public')->delete($announcement->file_path);
    }

    $announcement->delete();
    return redirect()->back()->with('success', 'Announcement deleted successfully!');
}
    
}

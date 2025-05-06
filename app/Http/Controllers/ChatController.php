<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    // Show chat view for the user (Supervisor, Coordinator, or Student)
    public function index()
    {
        $currentUser = Auth::user();
        
        // Fetch all other users except the logged-in user
        $users = User::where('id', '!=', $currentUser->id)->get();

        return view('chat.index', compact('users'));
    }

    // Fetch conversation between two users
    public function fetchMessages($receiver_id)
    {
        $currentUserId = Auth::id();
    
        $messages = Message::where(function ($query) use ($currentUserId, $receiver_id) {
                $query->where('sender_id', $currentUserId)->where('receiver_id', $receiver_id);
            })
            ->orWhere(function ($query) use ($currentUserId, $receiver_id) {
                $query->where('sender_id', $receiver_id)->where('receiver_id', $currentUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    
        return response()->json($messages);
    }
    

    // Send a message
    public function sendMessage(Request $request)
{
    Log::info('SendMessage Request:', $request->all());

    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'nullable|string',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt|max:2048',
    ]);

    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        try {
            $attachmentPath = $request->file('attachment')->store('public/chat_attachments');
            Log::info('File stored at: ' . $attachmentPath);
            $attachmentPath = str_replace('public/', '', $attachmentPath); 
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return response()->json(['error' => 'File upload failed'], 500);
        }
    }

    $message = Message::create([
        'sender_id' => auth()->id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message,
        'attachment' => $attachmentPath,
    ]);

    return response()->json(['success' => true, 'message' => $message]);
}

// Mark messages as read when a user opens the chat
public function markAsRead($receiver_id)
{
    $currentUserId = Auth::id();

    // Mark all messages from the receiver to the current user as read
    Message::where('sender_id', $receiver_id)
           ->where('receiver_id', $currentUserId)
           ->update(['is_read' => true]);

    return response()->json(['success' => true]);
}

}
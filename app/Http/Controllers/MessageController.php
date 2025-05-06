<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        broadcast(new NewMessage($message))->toOthers();

        return response()->json(['message' => $message]);
    }

    public function show($id)
    {
        return response()->json(Message::where(function ($query) use ($id) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('sender_id', $id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get());
    }
}


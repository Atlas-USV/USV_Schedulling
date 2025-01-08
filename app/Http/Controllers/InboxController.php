<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index()
    {
        $messages = Message::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('inbox.index', compact('messages'));
    }

    public function markAsRead($id)
    {
        $message = Message::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $message->is_read = true;
        $message->save();

        return redirect()->route('inbox.index')->with('toast_success', 'Mesajul a fost marcat ca citit.');
    }
}
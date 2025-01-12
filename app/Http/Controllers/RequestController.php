<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Support\Str;


class RequestController extends Controller
{
    public function index()
{
    $requests = UserRequest::with(['student', 'teacher', 'sender'])
        ->where(function ($query) {
            $query->where('student_id', Auth::id())
                  ->orWhere('teacher_id', Auth::id());
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return view('requests.index', compact('requests'));
}

    public function create()
{
    if (auth()->user()->hasRole('teacher')) {
        $students = User::role('student')->get();
        return view('requests.create', compact('students'));
    }

    if (auth()->user()->hasRole('student')) {
        $teachers = User::role('teacher')->get();
        return view('requests.create', compact('teachers'));
    }

    abort(403, 'Unauthorized action.');
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'recipient_id' => 'required|exists:users,id',
        'content' => 'required|string|max:500',
    ]);

    $senderId = auth()->id();
    $recipientId = $validatedData['recipient_id'];

    // Determină rolurile pentru student și profesor
    $studentId = auth()->user()->hasRole('student') ? $senderId : $recipientId;
    $teacherId = auth()->user()->hasRole('teacher') ? $senderId : $recipientId;

    UserRequest::create([
        'sender_id' => $senderId,
        'student_id' => $studentId,
        'teacher_id' => $teacherId,
        'content' => $validatedData['content'],
        'status' => 'pending',
    ]);

    return redirect()->route('requests.index')->with('toast_success', 'Request created successfully.');
}

public function updateStatus($id, Request $request)
{
    $validatedData = $request->validate([
        'status' => 'required|in:pending,approved,denied',
        'message_body' => 'nullable|string|max:1000', // Validează mesajul adițional
    ]);

    $userRequest = UserRequest::findOrFail($id);

    if (Auth::id() !== $userRequest->teacher_id && Auth::id() !== $userRequest->student_id) {
        abort(403, 'Unauthorized action.');
    }

    // Permite actualizarea doar destinatarului
    if (Auth::id() === $userRequest->sender_id) {
        abort(403, 'You cannot update the status of a request you sent.');
    }

    $userRequest->status = $validatedData['status'];
    $userRequest->save();

    // Trimitere mesaj în inbox
    $recipientId = $userRequest->sender_id;
    $subject = 'Răspuns la cererea: ' . Str::limit($userRequest->content, 50); // Primele 50 caractere din conținut
    $body = 'Statusul cererii tale a fost actualizat la: ' . ucfirst($validatedData['status']) . '.';

    if (!empty($validatedData['message_body'])) {
        $body .= "\n\n" . $validatedData['message_body']; // Adaugă textul personalizat
    }

    Message::create([
        'user_id' => $recipientId,
        'subject' => $subject,
        'body' => $body,
        'is_read' => false,
    ]);

    return redirect()->route('requests.index')->with('toast_success', 'Request status updated and message sent.');
}

public function markStatusUpdatesAsRead()
{
    UserRequest::where('sender_id', Auth::id())
        ->whereIn('status', ['approved', 'denied'])
        ->update(['status_read' => true]); // Asigură-te că ai un câmp `status_read` în tabel
    return redirect()->route('requests.index')->with('toast_success', 'Status updates marked as read.');
}


}

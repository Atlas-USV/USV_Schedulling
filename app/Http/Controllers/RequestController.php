<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function index()
    {
        $requests = UserRequest::with(['student', 'teacher'])
            ->where(function ($query) {
                if (Auth::user()->hasRole('teacher')) {
                    $query->where('teacher_id', Auth::id());
                } elseif (Auth::user()->hasRole('student')) {
                    $query->where('student_id', Auth::id());
                }
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

    if (auth()->user()->hasRole('student')) {
        $studentId = auth()->id();
        $teacherId = $validatedData['recipient_id'];
    } elseif (auth()->user()->hasRole('teacher')) {
        $studentId = $validatedData['recipient_id'];
        $teacherId = auth()->id();
    } else {
        abort(403, 'Unauthorized action.');
    }

    UserRequest::create([
        'student_id' => $studentId,
        'teacher_id' => $teacherId,
        'content' => $validatedData['content'],
        'status' => 'pending',
    ]);

    return redirect()->route('requests.index')->with('toast_success', 'Request created successfully.');
}

public function updateStatus($id, Request $request)
{
    // Validează că status-ul este o valoare acceptată
    $validatedData = $request->validate([
        'status' => 'required|in:pending,approved,denied', // Valori permise
    ]);

    // Obține request-ul din baza de date
    $userRequest = UserRequest::findOrFail($id);

    // Verifică dacă profesorul logat are permisiuni să modifice statusul
    if (Auth::user()->hasRole('teacher') && $userRequest->teacher_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    // Actualizează statusul
    $userRequest->status = $validatedData['status'];
    $userRequest->save();

    return redirect()->route('requests.index')->with('toast_success', 'Request status updated.');
}
}

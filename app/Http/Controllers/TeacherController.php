<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Faculty;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
    // Începe query-ul pentru utilizatori
    $query = User::whereHas('roles', function($q) {
        $q->where('name', 'teacher');
    });

    // Verifică dacă există un termen de căutare și adaugă filtrul
    if ($request->has('search') && !empty($request->search)) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Obține utilizatorii
    $users = $query->paginate(10);

    // Returnează view-ul cu utilizatorii
    return view('teachers.index', compact('users'));
    }
    
    public function storeSchedule(Request $request, $teacherId)
    {
        // Verifică dacă utilizatorul are rolul "teacher"
        $user = auth()->user();
        if (!$user->hasRole('teacher')) {
            return response()->json(['error' => 'You do not have permission to perform this action.'], 403);
        }

        // Validarea datelor primite
        $validated = $request->validate([
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Verifică dacă profesorul există
        $teacher = User::whereHas('roles', function ($q) {
            $q->where('name', 'teacher');
        })->findOrFail($teacherId);

        // Creează programul profesorului
        TeacherSchedule::create([
            'teacher_id' => $teacher->id,
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        return response()->json(['message' => 'Schedule added successfully!']);
    }

}

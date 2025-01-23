<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\TeacherSchedule;
use Illuminate\Support\Facades\Auth;

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

    public function getSchedule($teacherId)
    {
        // Verificăm dacă profesorul există
        $teacher = User::whereHas('roles', function ($q) {
            $q->where('name', 'teacher');
        })->with('schedules')->findOrFail($teacherId);
    
        // Returnăm o vizualizare pentru modal
        return view('teachers.schedule-modal', compact('teacher'));
    }

    public function storeSchedule(Request $request)
{
    \Log::info('Request data:', $request->all()); // Trimite în loguri


    // Validare
    $validated = $request->validate([
       'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
    ]);

    // Salvează în baza de date
    TeacherSchedule::create([
        'teacher_id' => auth()->id(),
        'day_of_week' => $validated['day_of_week'],
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
    ]);
    
    return redirect()->route('dashboard')->with('success', 'Programul a fost salvat cu succes!');
}

    public function showSchedule($teacherId)
{
    // Verificăm dacă profesorul există
    $teacher = User::findOrFail($teacherId);
    
    // Obținem programul profesorului
    $schedule = $teacher->schedule; // presupunem că ai un relaționament 'schedule' definit în modelul User

    return response()->json([
        'teacher' => $teacher,
        'schedule' => $schedule,
    ]);
}

public function addInfo()
{
    $schedules = TeacherSchedule::where('teacher_id', auth()->id())->get();

    return view('addinfo', compact('schedules'));
}

}

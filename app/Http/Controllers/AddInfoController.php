<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\Teacher_Schedule;
use Illuminate\Support\Facades\Auth;


class AddInfoController extends Controller
{
    public function create()
    {
        return view('Teachers.addinfo');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'day' => 'required|string|max:20',
            'start_time' => 'required|date_format:H:i', // Formatul HH:MM
            'end_time' => 'required|date_format:H:i|after:start_time', // Finalul după început
        ]);

        // Salvarea datelor în tabelul teacher_schedules
        Teacher_Schedule::create([
            'teacher_id' => Auth::id(), // ID-ul profesorului autentificat
            'day_of_week' => $validatedData['day'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
        ]);

        return redirect()->route('addinfo.create')->with('success', 'Detaliile orei de consultație au fost salvate cu succes!');
    }
}

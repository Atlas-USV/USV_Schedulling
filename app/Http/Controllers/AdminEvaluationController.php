<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\Room;

class AdminEvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::where('status', 'pending')->paginate(10);
        $rooms = Room::all();

        return view('evaluations.index', compact('evaluations', 'rooms'));
    }

    /*public function accept(Request $request)
{
    // Validarea inputurilor
    $request->validate([
        'evaluation_id' => 'required|exists:evaluations,id',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'room_id' => 'required|exists:rooms,id',
    ]);

    // Găsește examenul
    $evaluation = Evaluation::findOrFail($request->evaluation_id);

    // Actualizează informațiile examenului
    $evaluation->start_time = $request->start_time;
    $evaluation->end_time = $request->end_time;
    $evaluation->room_id = $request->room_id;
    $evaluation->status = 'accepted';
    $evaluation->save();

     


    return redirect()->route('evaluations.pending')->with('success', 'Examenul a fost acceptat, iar mesajele au fost trimise către utilizatori.');
} */

   /* public function delete($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->delete();

        return redirect()->route('evaluations.pending')->with('success', 'Evaluation deleted successfully.');
    } */

    public function decline(Request $request, $id)
{
    // Validare
    $request->validate([
        'reason' => 'required|string|max:255', // Motivul este obligatoriu
    ]);

    // Găsește evaluarea
    $evaluation = Evaluation::findOrFail($id);

    // Actualizează statusul evaluării
    $evaluation->status = 'declined';
    $evaluation->save();

    // Trimite mesaj utilizatorului care a creat evaluarea
    if ($evaluation->creator) {
        \App\Models\Message::create([
            'user_id' => $evaluation->creator->id,
            'subject' => 'Examen respins',
            'body' => "Examenul la disciplina '{$evaluation->subject->name}' a fost respins. Motiv: {$request->reason}",
        ]);
    }

    return redirect()->route('evaluations.pending')->with('success', 'Examenul a fost respins, iar utilizatorul a fost notificat.');
}


public function update(Request $request)
{
    $request->validate([
        'evaluation_id' => 'required|exists:evaluations,id',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'room_id' => 'required|exists:rooms,id',
    ]);

    $evaluation = Evaluation::findOrFail($request->evaluation_id);
    $evaluation->start_time = $request->start_time;
    $evaluation->end_time = $request->end_time;
    $evaluation->room_id = $request->room_id;
    $evaluation->status = 'accepted';
    $evaluation->save();

    $groupUsers = $evaluation->group->users;

    // Verifică dacă există utilizatori
    if ($groupUsers->isEmpty()) {
        return redirect()->route('evaluations.pending')->with('error', 'Nu există utilizatori în grup pentru a trimite mesaje.');
    }

    // Trimite mesaje utilizatorilor din grup
    foreach ($groupUsers as $user) {
        \App\Models\Message::create([
            'user_id' => $user->id,
            'subject' => 'Examen acceptat',
            'body' => "Examenul la disciplina '{$evaluation->subject->name}' a fost acceptat. 
            Profesor: {$evaluation->teacher->name}, 
            Dată: {$evaluation->exam_date->format('d M Y')}, 
            Oră: {$evaluation->start_time} - {$evaluation->end_time}. 
            Sala: {$evaluation->room->name}.",
        ]);
    }

    return redirect()->route('evaluations.pending')->with('success', 'Evaluation accepted successfully!');
}


public function checkAvailability(Request $request)
{
    \Log::info('Check Availability Request:', $request->all());

    try {
        $request->validate([
            'evaluation_id' => 'required|exists:evaluations,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_id' => 'required|exists:rooms,id',
        ]);

        \Log::info('Validation passed');

        $evaluation = Evaluation::findOrFail($request->evaluation_id);

        // Verificare conflicte
        $teacherConflict = Evaluation::where('teacher_id', $evaluation->teacher_id)
            ->where('exam_date', $evaluation->exam_date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        $roomConflict = Evaluation::where('room_id', $request->room_id)
            ->where('exam_date', $evaluation->exam_date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        \Log::info('Conflicts:', [
            'teacher_conflict' => $teacherConflict,
            'room_conflict' => $roomConflict
        ]);

        return response()->json([
            'teacher_conflict' => $teacherConflict,
            'room_conflict' => $roomConflict,
        ]);
    } catch (\Exception $e) {
        \Log::error('Error in checkAvailability:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Server error'], 500);
    }
}

}


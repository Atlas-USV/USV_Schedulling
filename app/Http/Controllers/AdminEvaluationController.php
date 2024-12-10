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

}


<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class AdminEvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::where('status', 'pending')->paginate(10);

        return view('evaluations.index', compact('evaluations'));
    }

    public function accept($id)
{
    // Găsește examenul după ID
    $evaluation = Evaluation::findOrFail($id);

    // Actualizează statusul în "accepted"
    $evaluation->status = 'accepted';
    $evaluation->save(); // Salvează modificările

    // Redirecționează înapoi cu un mesaj de succes
    return redirect()->route('evaluations.pending')->with('success', 'Evaluation accepted successfully!');
}

    public function delete($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->delete();

        return redirect()->route('evaluations.pending')->with('success', 'Evaluation deleted successfully.');
    }

    public function decline($id)
{
    
    $evaluation = Evaluation::findOrFail($id);

    
    $evaluation->status = 'declined';
    $evaluation->save(); 

    
    return redirect()->route('evaluations.pending')->with('success', 'Evaluation declined successfully!');
}
}


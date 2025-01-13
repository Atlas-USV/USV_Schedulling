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

}

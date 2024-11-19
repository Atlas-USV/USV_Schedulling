<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    //
    public function update(Request $request, $id)
    {
        // Găsește task-ul
        $task = Task::findOrFail($id);

        // Validează datele primite
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Actualizează task-ul
        $task->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        // Redirecționează utilizatorul cu un mesaj de succes
        return redirect()->route('dashboard')->with('success', 'Task updated successfully.');
    }
}

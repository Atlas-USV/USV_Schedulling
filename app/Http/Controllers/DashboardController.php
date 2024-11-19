<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        $faculties = Faculty::all();
        $subjects = Subject::all();
        $teachers = User::role('admin')->get();
        $rooms = Room::all();
    
        // Obține task-urile utilizatorului curent (limitate la 4)
        $tasks = Task::where('user_id', auth()->id())->take(4)->get();

        $userName = auth()->user()->name;
    
        return view('dashboard', compact('groups', 'faculties', 'subjects', 'teachers', 'rooms', 'tasks',  'userName'));
    }


    public function storeTask(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Task::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return redirect()->route('dashboard')->with('success', 'Task added successfully!');
}

public function deleteTask($id)
{
    $task = Task::findOrFail($id);

    // Asigură-te că utilizatorul poate șterge doar propriile task-uri
    if ($task->user_id === auth()->id()) {
        $task->delete();
    }

    return redirect()->route('dashboard')->with('success', 'Task deleted successfully!');
}
}


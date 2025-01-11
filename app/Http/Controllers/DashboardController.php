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
        
        $tasks = Task::where('user_id', auth()->id())
        ->orderBy('deadline', 'asc')  // Order by deadline
        ->where('deadline', '>=', now())  // Only future tasks
        ->take(4)  // Limit to 4 tasks
        ->get();

        $upcomingExams = \App\Models\Evaluation::where('group_id', 1) 
        ->where('status', 'accepted')
        ->where('exam_date', '>=', now())
        ->orderBy('exam_date', 'asc')
        ->take(4)
        ->get();

        $userName = auth()->user()->name;

        $userRole = auth()->user()->role;

        // Ultimii 5 utilizatori adăugați
    $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

    // Primele 5 examene în așteptare
    $pendingExams = \App\Models\Evaluation::where('status', 'pending')
        ->orderBy('exam_date', 'asc')
        ->take(5)
        ->get();

        \Log::info('User Role:', ['role' => $userRole]);
        \Log::info('Authenticated User:', ['user' => auth()->user()]);


    
        return view('dashboard', compact('groups', 'faculties', 'subjects', 'teachers', 'rooms', 'tasks',  'userName', 'upcomingExams', 'userRole', 'recentUsers', 'pendingExams'));
    }


    public function storeTask(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'subject' => 'required|string|max:255',
                'deadline' => 'required|date|after:now',
            ]);
    
            \Log::info('Creating task with data:', $validated);
    
            $task = Task::create([
                'user_id' => auth()->id(),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'subject' => $validated['subject'],
                'deadline' => $validated['deadline'],
                'is_completed' => false,
            ]);
    
            \Log::info('Task created successfully:', ['task_id' => $task->id]);
    
            return redirect()->route('dashboard')
                ->with('success', 'Task added successfully!')
                ->with('task_created', true);  // Add this flag
    
        } catch (\Exception $e) {
            \Log::error('Error creating task:', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
    
            return redirect()->route('dashboard')
                ->with('error', 'Failed to create task. Please try again.');
        }
    }

public function editTask($id)
{
    $task = Task::findOrFail($id);

    // Asigură-te că utilizatorul poate edita doar propriile task-uri
    if ($task->user_id !== auth()->id()) {
        return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
    }

    $subjects = Subject::all(); // Dacă ai nevoie să editezi subiectele
    return view('tasks.edit', compact('task', 'subjects'));
}

public function updateTask(Request $request, $id)
{
    $task = Task::findOrFail($id);

    if ($task->user_id !== auth()->id()) {
        return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'subject' => 'required|string|max:255',
        'deadline' => 'required|date|after:now',
    ]);

    \Log::info('Data Before Update:', $task->toArray());
    \Log::info('Data Received:', $request->all());

    $task->update($request->only(['title', 'description', 'subject', 'deadline']));

    \Log::info('Data After Update:', $task->fresh()->toArray());

    return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
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

public function showExams(Request $request)
{
    // Obține `group_id` din relația user-group
    $groupId = auth()->user()->groups()->pluck('groups.id')->first();

    // Verifică dacă utilizatorul are un grup asociat
    if (!$groupId) {
        return view('exams.index', [
            'exams' => collect([]), // Returnează o colecție goală
            'subjects' => \App\Models\Subject::all(),
        ]);
    }

    // Construiește query-ul
    $query = \App\Models\Evaluation::where('group_id', $groupId)
    ->where('status', 'accepted');

    // Aplica filtrul de timp (past/current)
    if ($request->filter === 'past') {
        $query->where('exam_date', '<', now());
    } elseif ($request->filter === 'current') {
        $query->where('exam_date', '>=', now());
    }

    // Aplica filtrul pentru subiect, dacă este setat
    if ($request->has('subject') && !empty($request->subject)) {
        $query->whereHas('subject', function ($q) use ($request) {
            $q->where('name', $request->subject);
        });
    }

    // Ordonează examenele crescător după dată
    $exams = $query->orderBy('exam_date', 'asc')->get();

    // Obține toate subiectele pentru dropdown-ul de filtrare
    $subjects = \App\Models\Subject::all();

    return view('exams.index', compact('exams', 'subjects'));
}




}


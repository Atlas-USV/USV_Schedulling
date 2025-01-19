<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

        // Obține ID-ul grupei utilizatorului autentificat
        $groupIds = auth()->user()->groups()->select('groups.id')->pluck('id'); // Obține un array cu ID-urile grupelor

        \Log::info('Group IDs:', ['groupIds' => $groupIds]); // Log the group IDs

        // Filtrează examenele pentru grupa utilizatorului doar dacă există ID-uri de grup
        $upcomingExams = collect(); // Initializează o colecție goală
        if ($groupIds->isNotEmpty()) {
            $upcomingExams = \App\Models\Evaluation::whereIn('group_id', $groupIds)
            ->where('status', 'accepted')
            ->where('exam_date', '>=', now())
            ->orderBy('exam_date', 'asc')
            ->take(4)
            ->get();
        }

        $userName = auth()->user()->name;

        $userRole = auth()->user()->roles->pluck('name');

        // Ultimii 5 utilizatori adăugați
    $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

    // Primele 5 examene în așteptare
    $pendingExams = \App\Models\Evaluation::where('status', 'pending')
        ->orderBy('exam_date', 'asc')
        ->take(5)
        ->get();


        $requests = [];
        if (auth()->user()->hasRole('teacher')) {
            $requests = \App\Models\Request::where('teacher_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->take(10) // Limitează numărul de cereri afișate
                ->get();
        }

        
        \Log::info('Upcoming Exams:', ['upcomingExams' => $upcomingExams]);


    
        return view('dashboard', compact('groups', 'faculties', 'subjects', 'teachers', 'rooms', 'tasks',  'userName', 'upcomingExams', 'userRole', 'recentUsers', 'pendingExams', 'requests'));
    }


    // public function storeTask(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'title' => 'required|string|max:255',
    //             'description' => 'required|string',
    //             'subject' => 'required|string|max:255',
    //             'deadline' => 'required|date|after:now',
    //         ]);
    
    //         \Log::info('Creating task with data:', $validated);
    
    //         $task = Task::create([
    //             'user_id' => auth()->id(),
    //             'title' => $validated['title'],
    //             'description' => $validated['description'],
    //             'subject' => $validated['subject'],
    //             'deadline' => $validated['deadline'],
    //             'is_completed' => false,
    //         ]);
    
    //         \Log::info('Task created successfully:', ['task_id' => $task->id]);
    
    //         return redirect()->route('dashboard')
    //             ->with('success', 'Task added successfully!')
    //             ->with('task_created', true);  // Add this flag
    
    //     } catch (\Exception $e) {
    //         \Log::error('Error creating task:', [
    //             'error' => $e->getMessage(),
    //             'request_data' => $request->all()
    //         ]);
    
    //         return redirect()->route('dashboard')
    //             ->with('error', 'Failed to create task. Please try again.');
    //     }
    // }

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
    // Verifică rolul utilizatorului
    if (auth()->user()->hasRole('teacher')) {
        // Dacă este profesor, afișează examenele pe care le predă
        $query = \App\Models\Evaluation::where('teacher_id', auth()->id())
            ->where('status', 'accepted');
    } else {
        // Dacă este student, obține toate grupele asociate utilizatorului
        $groupIds = auth()->user()->groups()->pluck('groups.id');

        // Verifică dacă utilizatorul are grupe asociate
        if ($groupIds->isEmpty()) {
            $emptyExams = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1, [
                'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()
            ]);
        
            return view('exams.index', [
                'exams' => $emptyExams,
                'subjects' => \App\Models\Subject::all(),
            ]);
        }

        $query = \App\Models\Evaluation::whereIn('group_id', $groupIds)
            ->where('status', 'accepted');
    }

    // Filtrează examenele curente (ziua curentă sau viitor)
    $query->where(function ($q) {
        $q->where('exam_date', '>', now())
            ->orWhere(function ($q2) {
                $q2->where('exam_date', '=', now()->toDateString())
                    ->where('end_time', '>=', now());
            });
    });

    // Aplica filtrul pentru subiect, dacă este setat
    if ($request->has('subject') && !empty($request->subject)) {
        $query->whereHas('subject', function ($q) use ($request) {
            $q->where('name', $request->subject);
        });
    }

    // Ordonează examenele crescător după dată și adaugă paginație
    $exams = $query->orderBy('exam_date', 'asc')->paginate(10); // 10 examene per pagină

    // Obține toate subiectele pentru dropdown-ul de filtrare
    $subjects = \App\Models\Subject::all();

    return view('exams.index', compact('exams', 'subjects'));
}
public function viewInCalendar($id)
{
    $exam = \App\Models\Evaluation::findOrFail($id);

    $googleCalendarUrl = sprintf(
        'https://www.google.com/calendar/render?action=TEMPLATE&text=%s&dates=%s/%s&details=%s&location=%s',
        urlencode($exam->subject->name),
        $exam->exam_date->format('Ymd\THis'),
        $exam->exam_date->format('Ymd\THis', strtotime('+2 hours')), // Adjust duration as needed
        urlencode($exam->description ?? 'No details available'),
        urlencode($exam->room->name ?? 'No room specified')
    );

    return redirect($googleCalendarUrl);
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

        Task::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'subject' => $validated['subject'],
            'deadline' => $validated['deadline'],
            'is_completed' => false,
        ]);

        // Adaugă log înainte de redirecționare
        \Log::info('Session messages:', [
            'toast_success' => 'Task added successfully!',
        ]);
        
        return redirect()->route('dashboard')->with('toast_success', 'Task added successfully!');
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Mesaje de validare detaliate
        \Log::info('Session messages:', [
            'toast_error' => implode(', ', $e->validator->errors()->all()),
        ]);

        return redirect()->route('dashboard')
            ->with('toast_error', implode(', ', $e->validator->errors()->all()));
    } catch (\Exception $e) {
        // Mesaj de eroare general
        \Log::info('Session messages:', [
            'toast_error' => 'Unexpected error: ' . $e->getMessage(),
        ]);

        return redirect()->route('dashboard')
            ->with('toast_error', 'Unexpected error: ' . $e->getMessage());
    }
}




}


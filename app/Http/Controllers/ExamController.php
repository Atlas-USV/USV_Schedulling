<?php

namespace App\Http\Controllers;

use App\Models\Evaluation; // Use the Evaluation model
use Illuminate\Http\Request;
use PDF; // Use the alias defined in config/app.php

class ExamController extends Controller
{
    public function downloadPdf()
    {
        $user = auth()->user();

        if ($user->hasRole('admin') || $user->hasRole('secretary')) {
            // Admin or secretary: all exams
            $exams = Evaluation::with(['subject', 'room', 'group'])->get();
        } elseif ($user->hasRole('teacher')) {
            // Teacher: only exams where they are assigned as the teacher
            $exams = Evaluation::with(['subject', 'room', 'group'])
                ->where('teacher_id', $user->id)
                ->get();
        } else {
            // Student: only exams for their groups
            $groupIds = $user->groups()->pluck('id'); // User's groups
            $exams = Evaluation::with(['subject', 'room', 'group'])
                ->whereIn('group_id', $groupIds)
                ->get();
        }

        if ($exams->isEmpty()) {
            session()->flash('toast_error', 'No exams available for export.');
            return redirect()->back();
        }

        $pdf = PDF::loadView('exams.pdf', compact('exams'));

        return $pdf->download('exams.pdf');
    }
}

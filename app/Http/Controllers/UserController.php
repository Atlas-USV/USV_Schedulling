<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // pentru Auth
use Illuminate\Support\Facades\Storage;
use App\Models\Faculty; // Importă modelul Faculty
use App\Models\Speciality; // Importă modelul Speciality
use App\Models\Group; // Importă modelul Group
use App\Models\Evaluation; // Importă modelul Evaluation
use App\Models\User; // Importă modelul User

class UserController extends Controller
{
    public function myAccount()
{
    $user = Auth::user(); // Utilizatorul autentificat

    $exams = [];
    if ($user->hasRole('secretary')) {
        $exams = Evaluation::with(['subject', 'room', 'teacher', 'group', 'speciality.faculty'])
            ->where('exam_date', '>', now())
            ->orderBy('exam_date', 'asc')
            ->get()
            ->map(function ($exam) {
                return [
                    'speciality' => $exam->speciality ? $exam->speciality->name : 'N/A',
                    'group' => $exam->group ? $exam->group->name : 'N/A',
                    'subject' => $exam->subject ? $exam->subject->name : 'N/A',
                    'exam_type' => $exam->type ?: 'N/A',
                    'teacher' => $exam->teacher ? $exam->teacher->name : 'N/A',
                    'room' => $exam->room ? $exam->room->name : 'N/A',
                    'start_time' => $exam->start_time ? $exam->start_time->format('d M Y, H:i') : 'N/A',
                    'end_time' => $exam->end_time ? $exam->end_time->format('d M Y, H:i') : 'N/A',
                    'faculty' => $exam->speciality->faculty ? $exam->speciality->faculty->name : 'N/A',
                ];
            });
    }

    // Verifică dacă utilizatorul este student sau profesor și preia evaluările acestora
    if ($user->hasRole('student') || $user->hasRole('teacher')) {
        $upcomingExam = $user->evaluations() // Evaluările asociate utilizatorului
            ->with(['group', 'subject', 'speciality', 'otherExaminators']) // Include relația otherExaminators
            ->where('exam_date', '>', now())
            ->orderBy('exam_date', 'asc')
            ->first();
    } else {
        $upcomingExam = null;
    }

    // Preia examenul recent pentru student/profesor
    if ($user->hasRole('student') || $user->hasRole('teacher')) {
        $recentExam = $user->evaluations()
            ->with(['group', 'subject', 'speciality', 'otherExaminators']) // Include relația otherExaminators
            ->where('exam_date', '<', now())
            ->orderBy('exam_date', 'desc')
            ->first();
    } else {
        $recentExam = null;
    }

    // Variabile pentru admin
    $numSecretaries = 0;
    $numTeachers = 0;
    $numStudents = 0;

    if ($user->hasRole('admin')) {
        $numSecretaries = User::role('secretary')->count();
        $numTeachers = User::role('teacher')->count();
        $numStudents = User::role('student')->count();
    }

    // Pregătește lista de alți examinatori pentru examenele viitoare și recente
    $otherExaminatorsUpcoming = $upcomingExam ? $upcomingExam->otherExaminators->pluck('name')->join(', ') : 'N/A';
    $otherExaminatorsRecent = $recentExam ? $recentExam->otherExaminators->pluck('name')->join(', ') : 'N/A';

    // Date adiționale despre utilizator
    $speciality = $user->speciality ? $user->speciality->name : 'N/A';
    $group = $user->groups->pluck('name')->join(', ') ?: 'N/A';
    $faculty = $user->faculty ? $user->faculty->name : 'N/A';
    $role = $user->getRoleNames()->first();
    $yearOfStudy = $user->getYearOfStudy(); // Obține anul de studiu
    $yearsOfWork = $user->getYearsOfWork();

    // Datele necesare pentru profesori
    $teacherGroups = $user->groups->pluck('name')->join(', ') ?: 'N/A';
    $teacherSpeciality = $user->speciality ? $user->speciality->name : 'N/A';

    // Returnează view-ul cu toate datele
    return view('my-account', compact(
        'user', 'speciality', 'group', 'role', 'faculty',
        'yearOfStudy', 'yearsOfWork', 'teacherGroups', 'teacherSpeciality',
        'upcomingExam', 'recentExam', 'otherExaminatorsRecent', 'otherExaminatorsUpcoming', 'exams', 'numSecretaries', 
        'numTeachers', 
        'numStudents'
    ));
}



    // Funcția pentru actualizarea contului utilizatorului
    public function updateAccount(Request $request)
    {
        $user = Auth::user(); // Obține utilizatorul autentificat

        // Validează cererea
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        // Salvare avatar dacă este încărcat
        if ($request->hasFile('avatar')) {
            // Șterge avatarul existent dacă există
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }

            // Încarcă fișierul și salvează calea
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Salvează utilizatorul
        $user->save();

        // Redirect cu mesaj de succes
        return redirect()->route('user.my-account')->with('success', 'Account updated successfully!');
    }

    // Funcția pentru actualizarea unei evaluări
    public function updateEvaluation(Request $request, $id)
    {
        $evaluation = Evaluation::find($id);

        // Salvează alți examinatori
        if ($evaluation) {
            $evaluation->otherExaminators()->sync($request->input('other_examinators'));  // Asociază examinatori noi

            // Salvează evaluarea
            $evaluation->save();

            // Redirect cu mesaj de succes
            return redirect()->back()->with('success', 'Evaluation updated successfully.');
        }

        return redirect()->back()->with('error', 'Evaluation not found.');
    }
}

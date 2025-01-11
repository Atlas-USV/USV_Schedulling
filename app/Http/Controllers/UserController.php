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

    if ($user->hasRole('student') || $user->hasRole('teacher')) {
        $upcomingExam = $user->evaluations()
            ->with(['group', 'subject', 'speciality'])
            ->where('exam_date', '>', now())
            ->orderBy('exam_date', 'asc')
            ->first();
    } else {
        $upcomingExam = null; // Sau alte acțiuni specifice rolurilor admin/secretar
    }
    

    if ($user->hasRole('student') || $user->hasRole('teacher')) {
        $recentExam = $user->evaluations()
            ->with(['group', 'subject', 'speciality'])
            ->where('exam_date', '>', now())
            ->orderBy('exam_date', 'asc')
            ->first();
    } else {
        $recentExam = null; // Sau alte acțiuni specifice rolurilor admin/secretar
    }
  

    $otherExaminatorsUpcoming = $upcomingExam && is_array($upcomingExam->other_examinators) 
    ? $upcomingExam->other_examinators 
    : ($upcomingExam ? json_decode($upcomingExam->other_examinators) : null);
    $otherExaminatorsRecent = $recentExam && is_array($recentExam->other_examinators) 
    ? $recentExam->other_examinators 
    : ($recentExam ? json_decode($recentExam->other_examinators) : null);

    // Alte date despre utilizator
    $speciality = $user->speciality ? $user->speciality->name : 'N/A';
    $group = $user->groups->pluck('name')->join(', ') ?: 'N/A';
    $faculty = $user->faculty ? $user->faculty->name : 'N/A';
    $role = $user->getRoleNames()->first();
    $yearOfStudy = $user->getYearOfStudy(); // Obține anul de studiu
    $yearsOfWork = $user->getYearsOfWork();

    // Datele necesare pentru profesori
    $teacherGroups = $user->groups->pluck('name')->join(', ') ?: 'N/A';
    $teacherSpeciality = $user->speciality ? $user->speciality->name : 'N/A';
    


    return view('my-account', compact('user', 'speciality', 'group', 'role', 'faculty','yearOfStudy','yearsOfWork', 'teacherGroups', 'teacherSpeciality', 'upcomingExam', 'recentExam', 'otherExaminatorsRecent', 'otherExaminatorsUpcoming'));
}



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

        public function updateEvaluation(Request $request, $id)
    {
        $evaluation = Evaluation::find($id);

        // Salvează alți examinatori
        $evaluation->otherExaminators()->sync($request->input('other_examinators'));

        $evaluation->save();

        return redirect()->back()->with('success', 'Evaluation updated successfully.');
    }

}
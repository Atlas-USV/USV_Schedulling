<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\Evaluation;
use App\Models\Speciality;
use App\Shared\EPermissions;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {

        $users = User::with([ 'faculty', 'roles', 'speciality'])->paginate(10);

         // Obține toate grupurile asociate utilizatorilor
    $userGroups = \DB::table('user_group')
    ->join('groups', 'user_group.group_id', '=', 'groups.id')
    ->select('user_group.user_id', 'groups.name as group_name')
    ->get()
    ->groupBy('user_id'); // Grupăm grupurile după `user_id`


        $roles = Role::all();

        return view('users.index', compact('users', 'roles', 'userGroups'));
    }

    public function edit($id)
{


    $user = User::find($id);

    if (!$user) {
        \Log::error('User not found with ID: ' . $id);
        abort(404, 'User not found');
    }



    $groups = Group::all();
    $faculties = Faculty::all();
    $roles = Role::all()->pluck('id', 'name')->toArray();
    $specialities = Speciality::all();
    $isLeader = $user->hasPermissionTo(EPermissions::PROPOSE_EXAM->value);




    return view('users.edit', [
        'editUser' => $user, // Variabilă redenumită
        'groups' => $groups,
        'faculties' => $faculties,
        'roles' => $roles,
        'specialities' => $specialities,
        'isLeader' => $isLeader,
    ]);
}

    public function update(Request $request, $id)
    {

        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'group_leader' => 'nullable|boolean',
            //'faculty_id' => 'nullable|exists:faculties,id',
            'group_id' => 'nullable|exists:groups,id',
            'speciality_id' => 'nullable|exists:specialities,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);
        $user = User::findOrFail($id);
        // Validate if group matches with selected speciality
        if ($request->group_id && $request->speciality_id) {
            $group = Group::find($request->group_id);
            if ($group->speciality_id != $request->speciality_id) {
                return back()->with('error', 'The selected group does not match the selected speciality.');
            }
        }

        // Assign or remove propose_exam permission based on group_leader
        if ($request->group_leader == "1") {
            $user->givePermissionTo(EPermissions::PROPOSE_EXAM->value);
        } else {
            $user->revokePermissionTo(EPermissions::PROPOSE_EXAM->value);
        }
        // Check if user already has a group and speciality is changed
        if ($user->groups->isNotEmpty() && $request->speciality_id && $user->speciality_id != $request->speciality_id) {
            $group = $user->groups->first();
            if ($group->speciality_id != $request->speciality_id) {
                return back()->with('error', 'The user\'s current group does not match the new selected speciality.');
            }
        }

        // If the group is set in the request and the user does not have a speciality, set the user's speciality to the group's speciality
        if ($request->group_id && !$user->speciality_id && !$request->speciality_id) {
            $group = Group::find($request->group_id);
            $user->speciality_id = $group->speciality_id;
        }
        // Actualizare câmpuri
        $user->name = $request->name;
        $user->email = $request->email;
        $user->teacher_faculty_id = $request->faculty_id;
        //$user->speciality_id = $request->speciality_id;

        // Actualizare grup (pivot table)
        if ($request->group_id) {
            $user->groups()->sync([$request->group_id]);
        }
        // Actualizare rol
        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        if ($user->save()) {
            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } else {
            return back()->with('error', 'An error occurred while updating the user.');
        }
    }

    public function getGroupsByFaculty($faculty_id)
{
    $groups = Group::whereHas('speciality', function ($query) use ($faculty_id) {
        $query->where('faculty_id', $faculty_id);
    })->get();

    return response()->json($groups);
}


    public function myAccount()
    {
        $user = Auth::user(); // Utilizatorul autentificat

        $exams = [];
        if ($user->hasRole('secretary')) {
            $exams = Evaluation::with(['subject', 'room', 'teacher', 'group', 'speciality','faculty'])
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
        // $yearOfStudy = $user->getYearOfStudy(); // Obține anul de studiu
        // $yearsOfWork = $user->getYearsOfWork();

        // Datele necesare pentru profesori
        $teacherGroups = $user->groups->pluck('name')->join(', ') ?: 'N/A';
        $teacherSpeciality = $user->speciality ? $user->speciality->name : 'N/A';

        // Returnează view-ul cu toate datele
        return view('my-account', compact(
            'user', 'speciality', 'group', 'role', 'faculty',
             'teacherGroups', 'teacherSpeciality',
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

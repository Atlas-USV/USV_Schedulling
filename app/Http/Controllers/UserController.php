<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\Speciality;
use App\Shared\EPermissions;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {

        $users = User::with(['groups', 'faculty', 'roles', 'speciality'])->paginate(10);
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function edit($id)
    {
        $user = User::with('groups', 'faculty')->findOrFail($id);
        $groups = Group::all();
        $faculties = Faculty::all();
        $roles = Role::all()->pluck('id','name')->toArray();
        $specialities = Speciality::all();
        $isLeader = $user->hasPermissionTo(EPermissions::PROPOSE_EXAM->value);
        
        return view('users.edit', compact('user', 'groups', 'faculties', 'roles', 'specialities', 'isLeader'));
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
        // Actualizare câmpuri
        $user->name = $request->name;
        $user->email = $request->email;
        $user->teacher_faculty_id = $request->faculty_id;
        $user->speciality_id = $request->speciality_id;

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
}

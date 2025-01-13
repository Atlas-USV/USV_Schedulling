<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Faculty;

class UserController extends Controller
{
    public function index()
    {
        
        $users = User::with(['groups', 'faculty', 'roles'])->paginate(10);

        return view('users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::with('groups', 'faculty')->findOrFail($id);
        $groups = Group::all();
        $faculties = Faculty::all();

        return view('users.edit', compact('user', 'groups', 'faculties'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'faculty_id' => 'nullable|exists:faculties,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $user = User::findOrFail($id);

        // Actualizare câmpuri
        $user->name = $request->name;
        $user->email = $request->email;
        $user->teacher_faculty_id = $request->faculty_id;

        // Actualizare grup (pivot table)
        if ($request->group_id) {
            $user->groups()->sync([$request->group_id]);
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

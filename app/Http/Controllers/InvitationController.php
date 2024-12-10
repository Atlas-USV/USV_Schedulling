<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Faculty;
use App\Models\Invitation;
use App\Models\Speciality;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Rules\FacultySpecialityGroupRule;
use Illuminate\Support\Facades\Log;
class InvitationController extends Controller
{

    public function __construct()
    {
    }

    public function create()
    {
        $roles = Role::all();
        $groups = Group::all();
        $faculties = Faculty::all();
        $specialities = Speciality::all();

        return view('invitation.create-invitation', compact('roles', 'groups', 'faculties', 'specialities'));
    }

    public function store(Request $request)
    {


        try{
            $validated = $request->validate([
                'email' => 'required|email|unique:users,email',
                'role_id' => 'nullable|exists:roles,id',
                'group_id' => 'nullable|exists:groups,id',

                'speciality_id' => ['nullable','exists:specialities,id'],
                'teacher_faculty_id' => ['nullable','exists:faculties,id',
                    new FacultySpecialityGroupRule($request->teacher_faculty_id, $request->role_id, $request->group_id, $request->speciality_id )],
                    ]);


            // Create the invitation
            $invitation = Invitation::create([
                'email' => $request->email,
                'teacher_faculty_id' => $request->teacher_faculty_id,
                'group_id' =>$request->group_id,
                'role_id' => $request->role_id ,
                'speciality_id' => $request->speciality_id,
                'created_by' => auth()->id(),
                'expires_at' => now()->addDays(90),
            ]);

            $signedUrl = URL::signedRoute('register', ['invitation_id' => $invitation->id]);

            Mail::to($invitation->email)->send(new InvitationMail($invitation, $signedUrl));
            session()->flash('toast_success', 'Invitatie trimisa cu succes!');
            return back();

        }catch(Exception $e){
            Log::error($e->getMessage());

        }


    }
}

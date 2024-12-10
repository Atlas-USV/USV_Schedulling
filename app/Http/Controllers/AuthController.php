<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Group;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{

    public function __construct()
    {
        // $this->middleware('guest')->except([
        //     'logout'
        // ]);
        // $this->middleware('auth')->only('logout');
        // $this->middleware('signed')->only('showRegisterForm', 'register');
        // //$this->middleware('verified')->only('home');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Show registration form
    public function showRegisterForm(Request $request,$invitation_id)
    {
         // Find the invitation by its ID
        $invitation = Invitation::find($invitation_id);

        // If invitation doesn't exist, handle accordingly
        if (!$invitation) {
            abort(419);
        }
        if (User::where('email', $invitation->email)->first() || $invitation->expires_at != null && $invitation->expires_at < now()) {
            abort(419);
        }
        // Pass only the invitation model to the view
        return view('auth.register', compact('invitation'));
    }

    // Handle registration request
    public function register(Request $request, $invitation_id)
    {
         // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        // Retrieve the invitation by ID
        $invitation = Invitation::findOrFail($invitation_id);

        // Check if the invitation is valid (optional: ensure the invitation is not expired)
        if ($invitation->expires_at != null && $invitation->expires_at < now()) {
            abort(419);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $invitation->email,
            'password' => Hash::make($request->password),
        ]);

        if ($invitation->group_id) {
            $group = Group::find($invitation->group_id); // Find the group by ID

            if ($group) {
                // Assign group speciality_id to the user
                $user->speciality_id = $group->speciality_id;
                $user->groups()->attach($group->id);
            }


            // If a teacher_faculty_id is present, assign it
            if ($invitation->teacher_faculty_id) {
                $user->teacher_faculty_id = $invitation->teacher_faculty_id;
            }
        }
        if ($invitation->role_id) {
            $role = Role::find($invitation->role_id);  // Find the role by ID
            if ($role) {
                $user->assignRole($role);  // Assign the role to the user
            }
        }
        if ($invitation->teacher_faculty_id) {
            $user->teacher_faculty_id = $invitation->teacher_faculty_id;  // Assign faculty_id
        }
        $user->save();
        Invitation::where('email', $invitation->email)->delete();
        Auth::login($user);

        // Regenerate the session to avoid session fixation attacks
        $request->session()->regenerate();

        // Redirect to the desired page (e.g., dashboard)
        return redirect()->route('home');
    }

    // Handle logout request
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

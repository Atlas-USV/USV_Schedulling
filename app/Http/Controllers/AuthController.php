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
            return redirect()->route('dashboard');
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
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
            ]);
    
            // Retrieve the invitation by ID
            $invitation = Invitation::findOrFail($invitation_id);
    
            // Check if the invitation is valid (optional: ensure the invitation is not expired)
            if ($invitation->expires_at != null && $invitation->expires_at < now()) {
                abort(419, 'The invitation has expired.');
            }
    
            // Create the user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $invitation->email,
                'password' => Hash::make($validatedData['password']),
            ]);
    
            if ($invitation->group_id) {
                $group = Group::find($invitation->group_id);
                if ($group) {
                    $user->speciality_id = $group->speciality_id;
                    $user->groups()->attach($group->id);
                }
            }
    
            if ($invitation->role_id) {
                $role = Role::find($invitation->role_id);
                if ($role) {
                    $user->assignRole($role);
                }
            }
    
            if ($invitation->teacher_faculty_id) {
                $user->teacher_faculty_id = $invitation->teacher_faculty_id;
            }
    
            $user->save();
    
            // Delete the invitation
            Invitation::where('email', $invitation->email)->delete();
    
            // Log in the user
            Auth::login($user);
    
            // Regenerate the session to prevent session fixation attacks
            $request->session()->regenerate();
    
            // Flash success message
            session()->flash('toast_success', 'Te-ai registrat cu success');
    
            // Redirect to the home page
            return redirect()->route('home');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Flash validation errors
            $errorMessages = collect($e->errors())->flatten()->implode(' '); 
            session()->flash('toast_error', $errorMessages);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Flash general errors
            session()->flash('toast_error', 'A aparut o eroare in timpul registrarii');
            return back()->withInput();
        }
    }
    
    // Handle logout request
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        
       
        return redirect('/');
    }
}

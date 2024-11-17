<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Http\Request;
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
            return redirect()->route('home')->with('error', 'Invalid invitation.');
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

        // Assign the user to the group associated with the invitation
        $group_id = $invitation->group_id;  // Assuming the invitation has a group_id attribute

        if( $group_id != null){
            $user->groups()->attach($group_id);
        }
        Invitation::where('email', $invitation->email)->delete();
        Auth::login($user);

        // Regenerate the session to avoid session fixation attacks
        $request->session()->regenerate();

        // Redirect to the desired page (e.g., dashboard)
        return redirect()->route('/');
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

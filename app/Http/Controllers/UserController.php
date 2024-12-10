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
        $user = Auth::user(); // Obține utilizatorul autentificat


        // Obține specializarea utilizatorului
        $speciality = $user->speciality ? $user->speciality->name : 'N/A';
        
        // Obține grupurile utilizatorului (dacă are mai multe)
        $group = $user->groups->pluck('name')->join(', ') ?: 'N/A';

        

        $faculty = $user->faculty ? $user->faculty->name : 'N/A';

        // Obține rolul utilizatorului (ex. profesor, student)
        $role = $user->getRoleNames()->first();

        // dd($user->evaluations);

        $evaluation=null;

        // if ($user->hasRole('student')) {
        // $evaluation = $user->evaluationsAsStudent()->get();
        // } elseif ($user->hasRole('teacher')) {
        // $evaluation = $user->evaluationsAsTeacher()->get();
        // }

        $evaluation = $user->evaluations()->with(['group', 'subject'])->latest('exam_date')->first();

        
        
        // Transmite datele către view
        return view('my-account', compact('user', 'speciality', 'group', 'role', 'evaluation', 'faculty'));
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
}

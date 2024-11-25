<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // pentru Auth
use Illuminate\Support\Facades\Storage;
use App\Models\Faculty; // Importă modelul Faculty
use App\Models\Speciality; // Importă modelul Speciality
use App\Models\Group; // Importă modelul Group
use App\Models\User; // import corect pentru modelul User


class UserController extends Controller
{
    public function myAccount()
    {
        $user = Auth::user(); // Obține utilizatorul autentificat
        
        // Încarcă relațiile (specialty, faculty, groups)
        //$user = $user->load('specialities', 'groups');
        
       
        // dd($user->speciality);
        // Obține informațiile facultății, specializării și grupului
        //$faculty = $user->faculty ? $user->faculty->name : 'N/A';
        $speciality = $user->speciality ? $user->speciality->name : 'N/A';
        $group = $user->groups->pluck('name')->join(', ') ?: 'N/A'; // Dacă utilizatorul are mai multe grupuri
        $role = $user->getRoleNames()->first();

        // Transmite datele către View
        return view('my-account', compact('user', 'speciality', 'group','role'));
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





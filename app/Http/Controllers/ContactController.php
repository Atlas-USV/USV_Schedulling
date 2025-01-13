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

class ContactController extends Controller
{
    // Metoda care returnează formularul de contact
    public function showContact()
    {
        return view('Home.contact'); // Se presupune că ai un fișier contact.blade.php
    }

    // Metoda care procesează formularul
    public function submitContact(Request $request)
    {
        // Validarea formularului
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'remember' => 'accepted',
        ]);

        // Dacă validarea trece, adăugăm un mesaj de succes în sesiune
        session()->flash('success', 'Thanks for the message');

        // Poți adăuga logica pentru a trimite un email, dacă dorești

        // Redirecționează înapoi la formular cu mesajul de succes
        return redirect('contact');
    }

}

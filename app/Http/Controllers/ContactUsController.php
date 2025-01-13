<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Mail\ContactUsMail;
use App\Models\Group;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    // Metoda care returnează formularul de contact
    public function showContactUs()
    {
        return view('ContactUs.contactus'); // Se presupune că ai un fișier contactus.blade.php
    }

    // Metoda care procesează formularul
    public function submitContactUs(Request $request)
    {
        // Validează datele formularului
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Trimite emailul către admin
        Mail::to(env('MAIL_FROM_ADDRESS','Hello@example.com'))->send(new ContactUsMail($validatedData));

        // Returnează succesul pe pagina
        return back()->with('success', 'Thanks for your message');
    }
}

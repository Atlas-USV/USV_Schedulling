@extends('layouts.app')

@section('content')
<div class="relative container mx-auto mt-8">

     
   
<div class="flex items-center justify-center mb-4 space-x-4">
    <!-- Titlul "My Account" -->
    <h2 class="text-2xl font-bold">My Account</h2>

    <!-- Container Avatar cu Iconiță -->
    <div class="relative group">
        @if ($user->avatar)
            <!-- Avatar -->
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border">
        @else
            <!-- Avatar implicit -->
            <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-2xl">
                <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
        @endif

        <!-- Input pentru fișiere (invizibil) -->
        <input type="file" id="avatar" name="avatar" class="hidden" form="edit-avatar-form" onchange="document.getElementById('edit-avatar-form').submit()">

        <!-- Iconița Edit -->
        <label for="avatar" 
               class="absolute top-0 right-0 bg-blue-500 text-white p-1 rounded-full shadow-lg cursor-pointer hover:bg-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232a3 3 0 014.243 4.243L7 22l-4 1 1-4L15.232 5.232z" />
            </svg>
        </label>
    </div>
</div>

<!-- Formular invizibil pentru avatar -->
<form action="{{ route('user.update-account') }}" method="POST" enctype="multipart/form-data" id="edit-avatar-form" class="hidden">
    @csrf
</form>

<div class="flex space-x-10">
    <!-- Card pentru informațiile despre utilizator -->
    <div class="bg-blue-100 p-10 rounded-lg shadow-lg max-w-xl w-full">
        <!-- Titlul "Personal Information" -->
        <h2 class="text-2xl font-semibold mb-6 text-left">Personal Information</h2>

        <!-- Informații utilizator - generale -->
        <div class="space-y-4 text-lg">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $role ?? 'N/A' }}</p>
        
        <!-- Informații utilizator - student -->
            @if(Auth::user()->hasRole('student'))
            <p><strong>Speciality:</strong> {{ $speciality }}</p>
            <p><strong>Group:</strong> {{ $group }}</p>
            @endif
            
        <!-- Informații utilizator - Teacher -->
            @if(Auth::user()->hasRole('teacher'))
            <p><strong>Faculty:</strong> {{ $faculty }}</p>
            @endif 
            
        </div>
    </div>
    <!-- Verificare dacă utilizatorul are rolul de admin sau secretar -->
    @if(!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('secretary'))
    <!-- Card pentru informațiile despre examen -->
    <div class="bg-blue-100 p-10 rounded-lg shadow-lg max-w-xl w-full">
        <!-- Titlul "Exam Information" -->
        <h2 class="text-2xl font-semibold mb-6 text-left">Exams Information</h2>

        <!-- Informații examen -->
        <div class="space-y-6 text-lg">

            <p><strong>Subject:</strong> {{ $evaluation->subject->name ?? 'N/A' }}</p>
            <p><strong>Type:</strong> {{ $evaluation->type ?? 'N/A' }}</p>
            <p><strong>Start Time:</strong> {{ $evaluation->start_time ?? 'N/A' }}</p>
            <p><strong>End Time:</strong> {{ $evaluation->end_time ?? 'N/A' }}</p>
            <p><strong>Room:</strong> {{ $evaluation->room->name ?? 'N/A' }}</p>
            @if(Auth::user()->hasRole('student'))
            <p><strong>Teacher:</strong> {{ $evaluation->teacher->name ?? 'N/A' }}</p>
            @endif
            @if(Auth::user()->hasRole('teacher'))
            <p><strong>Group:</strong> {{ $evaluation->group->name }}</p>
            <p><strong>Other examinators:</p>
            @endif

    
    
    @else
            <!-- Card sau conținut pentru admin sau secretar -->
            <div class="bg-green-100 p-10 rounded-lg shadow-lg max-w-xl w-full">
                <h2 class="text-2xl font-semibold mb-6 text-left">Admin or Secretary Dashboard</h2>
                <p>This section is for admins or secretaries. You can manage users and other system settings here.</p>
                <!-- Adaugă orice alt conținut relevant pentru admin sau secretar -->
            </div>
    @endif
</div>


@endsection


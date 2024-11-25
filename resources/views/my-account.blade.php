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

        <!-- Informații utilizator -->
        <div class="space-y-4 text-lg">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Speciality:</strong> {{ $speciality }}</p>
            <p><strong>Group:</strong> {{ $group }}</p>
            <p><strong>Role:</strong> {{ $role ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Card pentru informațiile despre examen -->
    <div class="bg-blue-100 p-10 rounded-lg shadow-lg max-w-xl w-full">
        <!-- Titlul "Exam Information" -->
        <h2 class="text-2xl font-semibold mb-6 text-left">Exams Information</h2>
    
<button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay" data-dropdown-delay="500" data-dropdown-trigger="hover" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Dropdown hover <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
</svg>
</button>

<!-- Dropdown menu -->
<div id="dropdownDelay" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDelayButton">
      <li>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
      </li>
      <li>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
      </li>
      <li>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
      </li>
      <li>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
      </li>
    </ul>
</div>

        <!-- Informații examen -->
        <div class="space-y-4 text-lg">
            <p><strong>Exam:</strong> {{ $exam_name ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ $exam_date ?? 'N/A' }}</p>
            <p><strong>Time:</strong> {{ $exam_time ?? 'N/A' }}</p>
            <p><strong>Grade:</strong> {{ $exam_grade ?? 'N/A' }}</p>
        </div>
    </div>
</div>

@endsection

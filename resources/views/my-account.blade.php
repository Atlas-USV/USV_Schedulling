@extends('layouts.app')

@section('content')
    <div class="relative w-full mx-auto mt-8 min-h-screen">
        <div class="flex items-center justify-center mb-4 space-x-4">
            <!-- Titlul "My Account" -->
            <h2 class="text-2xl font-bold my-account-title">My Account</h2>

            <!-- Container Avatar cu Iconiță -->
            <div class="relative group">
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                        class="w-24 h-24 rounded-full object-cover border">
                @else
                    <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-2xl">
                        <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                @endif

                <!-- Input pentru fișiere (invizibil) -->
                <input type="file" id="avatar" name="avatar" class="hidden" form="edit-avatar-form"
                    onchange="document.getElementById('edit-avatar-form').submit()">

                <!-- Iconița Edit -->
                <label for="avatar"
                    class="absolute top-0 right-0 bg-blue-500 text-white p-1 rounded-full shadow-lg cursor-pointer hover:bg-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.232 5.232a3 3 0 014.243 4.243L7 22l-4 1 1-4L15.232 5.232z" />
                    </svg>
                </label>
            </div>
        </div>

        <!-- Formular invizibil pentru avatar -->
        <form action="{{ route('user.update-account') }}" method="POST" enctype="multipart/form-data" id="edit-avatar-form"
            class="hidden">
            @csrf
        </form>

        <div class="flex space-x-10">
            <!-- Card pentru informațiile despre utilizator -->
            <div class="relative -right-20 bg-blue-100 p-10 rounded-lg shadow-lg max-w-xl w-full mr-20">
                
                <h2 class="text-3xl font-semibold mb-10 text-center">Personal Informations</h2>
    
                <div class="space-y-8 text-lg">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Role:</strong> {{ $role ?? 'N/A' }}</p>

                    @if (Auth::user()->hasRole('student'))
                        <p><strong>Speciality:</strong> {{ $speciality }}</p>
                        <p><strong>Group:</strong> {{ $group }}</p>
                        <p><strong>Year of Study:</strong> {{ $yearOfStudy }}</p>
                    @endif

                    @if (Auth::user()->hasRole('teacher'))
                        <p><strong>Faculty:</strong> {{ $faculty }}</p>
                        <p><strong>Years of Work:</strong> {{ $yearsOfWork }} years</p>
                    @endif

                    <!-- Meniu pentru schimbarea temei -->
                    <div class="flex justify mb-4">
                        <label for="theme-toggle" class="flex items-center cursor-pointer">
                            <span class="mr-2"><strong>Light/Dark Mode</strong></span> 
                            <input type="checkbox" id="theme-toggle" class="hidden">
                            <div class="relative">
                                <div class="switch-bg w-10 h-6 bg-gray-300 rounded-full shadow-inner transition-colors duration-300 ease-in-out"></div>
                                <div class="dot absolute w-6 h-6 bg-white rounded-full shadow inset-y-0 left-0 transition-transform duration-300 ease-in-out transform"></div>
                            </div>
                        </label>
                    </div>
                </div>      
            </div>

            @if (Auth::user()->hasRole('student') || Auth::user()->hasRole('teacher'))
                <!-- Card pentru informațiile despre examen -->
                <div class="relative -right-10 bg-blue-100 p-10 rounded-lg shadow-lg max-w-xl w-full">
                    <h2 class="text-3xl font-semibold mb-4 text-center">Exams Information</h2>

                    <!-- Butoane pentru History și Upcoming -->
                    <div class="flex justify-center mb-6 space-x-4">
                        <button id="btn-history" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            History
                        </button>
                        <button id="btn-upcoming" class="btn btn-secondary bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Upcoming
                        </button>
                    </div>

                    <!-- Container pentru afișarea informațiilor examenelor -->
                    <div id="exam-info" class="space-y-8 text-lg">
                        @if (Auth::user()->hasRole('student'))
                            <p><strong>History </strong> - to see the latest exam taken </p>
                            <p><strong> Upcoming </strong> - to see the the first exam to be taken  </p>
                        @endif

                        @if (Auth::user()->hasRole('teacher'))
                            <p><strong>History </strong> - to see details about the latest exam </p>
                            <p><strong> Upcoming </strong> - to see details about the first exam that follows  </p>
                        @endif
                    </div> 
                </div>
            @else
                <!-- Alte secțiuni sau mesaje pentru admin sau secretary -->
                <div class="relative -right-10 bg-blue-100 p-10 rounded-lg shadow-lg max-w-xl w-full">
                    <h2 class="text-3xl font-semibold mb-4 text-center">Administrator Section</h2>
                    <p class="text-lg">Specific information or functionality for admins and secretaries will be displayed here.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Schimbă fundalul switch-ului și poziția bulinei când este activ */
        #theme-toggle:checked + div .switch-bg {
            background-color: #3b82f6; /* Culoarea albastră */
        }
        #theme-toggle:checked + div .dot {
            transform: translateX(1.5rem); /* Mută bulina în partea dreaptă */
        }

        /* Stiluri pentru titlul My Account în modul întunecat */
        body.dark .my-account-title {
            color: #E2E8F0; /* O nuanță deschisă pentru a contrasta cu fundalul întunecat */
        }
    </style>

    <!-- Script pentru comutarea între History și Upcoming -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const historyBtn = document.getElementById('btn-history');
            const upcomingBtn = document.getElementById('btn-upcoming');
            const examInfo = document.getElementById('exam-info');
            const themeToggle = document.getElementById('theme-toggle');

            // Verifică tema curentă și setează tema la încărcarea paginii
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme === 'dark') {
                document.body.classList.add('dark');
                themeToggle.checked = true;
            }

            // Când switch-ul este schimbat
            themeToggle.addEventListener('change', function () {
                if (themeToggle.checked) {
                    document.body.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.body.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            });

            historyBtn.addEventListener('click', function () {
                examInfo.innerHTML = `
                    @if ($recentExam)
                        <p><strong>Subject:</strong> {{ $recentExam->subject->name }}</p>
                        <p><strong>Type:</strong> {{ $recentExam->type }}</p>

                        @if (Auth::user()->hasRole('student'))
                            <p><strong>Teacher:</strong> {{ $recentExam->teacher->name ?? 'N/A' }}</p>
                        @endif

                        @if (Auth::user()->hasRole('teacher'))
                            <p><strong>Speciality:</strong> {{ $recentExam->speciality->name ?? 'N/A' }}</p>
                            <p><strong>Group:</strong> {{ $recentExam->group->name ?? 'N/A' }}</p>
                        @endif

                        <p><strong>Start Time:</strong> {{ $recentExam->start_time }}</p>
                        <p><strong>End Time:</strong> {{ $recentExam->end_time }}</p>
                        <p><strong>Room:</strong> {{ $recentExam->room->name ?? 'N/A' }}</p>

                        <!-- Afișează alți examinatori pe aceeași linie -->
                        @if ($otherExaminatorsRecent && count($otherExaminatorsRecent) > 0)
                            <p><strong>Other Examinators:</strong> {{ implode(', ', $otherExaminatorsRecent) }}</p>
                        @else
                            <p><strong>Other Examinators:</strong> -</p>
                        @endif

                        @if (Auth::user()->hasRole('student'))
                            <p><strong>Grade:</strong> {{ $recentExam->grade ?? 'Not available' }}
                            @if(isset($recentExam->grade) && $recentExam->grade > 5)
                                <span class="text-green-500"> - Passed</span>
                            @else 
                                <span class="text-red-500"> - Failed</span>
                            @endif
                            </p>                        
                        @endif
                    @else
                        <p>No past exams available.</p>
                    @endif
                `;
            });

            upcomingBtn.addEventListener('click', function () {
                examInfo.innerHTML = `
                    @if ($upcomingExam)
                        <p><strong>Subject:</strong> {{ $upcomingExam->subject->name }}</p>
                        <p><strong>Type:</strong> {{ $upcomingExam->type }}</p>

                        @if (Auth::user()->hasRole('student'))
                            <p><strong>Teacher:</strong> {{ $upcomingExam->teacher->name ?? 'N/A' }}</p>
                        @endif

                        @if (Auth::user()->hasRole('teacher'))
                            <p><strong>Speciality:</strong> {{ $upcomingExam->speciality->name ?? 'N/A' }}</p>
                            <p><strong>Group:</strong> {{ $upcomingExam->group->name ?? 'N/A' }}</p>
                        @endif

                        <p><strong>Start Time:</strong> {{ $upcomingExam->start_time }}</p>
                        <p><strong>End Time:</strong> {{ $upcomingExam->end_time }}</p>
                        <p><strong>Room:</strong> {{ $upcomingExam->room->name ?? 'N/A' }}</p>
                        
                        @if ($otherExaminatorsUpcoming && count($otherExaminatorsUpcoming) > 0)
                            <p><strong>Other Examinators:</strong> {{ implode(', ', $otherExaminatorsUpcoming) }}</p>
                        @else
                            <p><strong>Other Examinators:</strong> -</p>
                        @endif
                    @else
                        <p>No upcoming exams available.</p>
                    @endif
                `;
            });
        });
    </script>
@endsection

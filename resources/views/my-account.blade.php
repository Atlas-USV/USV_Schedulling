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
                        <!-- <p><strong>Year of Study:</strong> {{ $yearOfStudy }}</p> -->
                    @endif

                    @if (Auth::user()->hasRole('teacher'))
                        <p><strong>Faculty:</strong> {{ $faculty }}</p>
                        <!-- <p><strong>Years of Work:</strong> {{ $yearsOfWork }} years</p> -->
                    @endif

                    @if (Auth::user()->hasRole('secretary'))
                        <p><strong>Faculty:</strong> {{ $faculty }}</p>
                        <!-- <p><strong>Years of Work:</strong> {{ $yearsOfWork }} years</p> -->
                    @endif

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
              
            @if (Auth::user()->hasRole('secretary'))
                <div class="relative -right-10 bg-blue-100 p-10 rounded-lg shadow-lg max-w-xl w-full">
                    <h2 class="text-3xl font-semibold mb-4 text-center">Quick view of Upcoming Exams</h2>

                <div id="exam-display" class="space-y-4">
                 <!-- Examenul curent va fi afișat aici -->
                </div>

                <div class="flex justify-between mt-4">
                    <button id="prev-btn" class="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50" disabled>Previous</button>
                    <button id="next-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
                </div>
            </div>

            <script>
                let exams = @json($exams);  // Preia examenele din controller
                let currentIndex = 0;

            function displayExam(index) {
                const examDisplay = document.getElementById('exam-display');
                    if (exams.length > 0 && index >= 0 && index < exams.length) {
                    const exam = exams[index];
                    examDisplay.innerHTML = `
                        <div class="bg-white p-4 rounded shadow space-y-8 text-lg">
                            <p><strong>Faculty:</strong> ${exam.faculty}</p>
                            <p><strong>Speciality:</strong> ${exam.speciality}</p>
                            <p><strong>Group:</strong> ${exam.group}</p>
                            <p><strong>Subject:</strong> ${exam.subject}</p>
                            <p><strong>Exam Type:</strong> ${exam.exam_type}</p>
                            <p><strong>Teacher:</strong> ${exam.teacher}</p>
                            <p><strong>Other Examinators:</strong> ${exam.other_examinators ? exam.other_examinators : 'N/A'}</p>
                            <p><strong>Room:</strong> ${exam.room}</p>
                            <p><strong>Start Time:</strong> ${exam.start_time}</p>
                            <p><strong>End Time:</strong> ${exam.end_time}</p>
                        </div>
                    `;
                }
            }

            document.getElementById('prev-btn').addEventListener('click', function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    displayExam(currentIndex);
                    toggleButtons();
                }
            });

            document.getElementById('next-btn').addEventListener('click', function() {
                if (currentIndex < exams.length - 1) {
                    currentIndex++;
                    displayExam(currentIndex);
                    toggleButtons();
                }
            });

            function toggleButtons() {
                document.getElementById('prev-btn').disabled = currentIndex === 0;
                document.getElementById('next-btn').disabled = currentIndex === exams.length - 1;
            }

            // Afișează primul examen la încărcare
            displayExam(currentIndex);
            toggleButtons();
            </script>
            @endif

            @if (Auth::user()->hasRole('admin'))
            <!-- Card pentru utilizatorii cu rolul de admin -->
            <div class="relative -right-10 bg-blue-100 p-10 rounded-lg shadow-lg max-w-xl w-full">
                <h2 class="text-3xl font-semibold mb-10 text-center">Quick view of Users Management</h2>

                <div class="space-y-8 text-lg justify">
                    <p><strong>Number of Secretaries:</strong> {{ $numSecretaries }}</p>
                    <p><strong>Number of Teachers:</strong> {{ $numTeachers }}</p>
                    <p><strong>Number of Students:</strong> {{ $numStudents }}</p>
                </div>
            </div>
            @endif

                    </div>
                </div>
            @endif
        </div>
    </div>

    

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
                        
                        
                    @else
                        <p>No upcoming exams available.</p>
                    @endif
                `;
            });
        });
    </script>
@endsection

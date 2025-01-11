{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

@section('content')
    <div class="dashboard-container grid grid-cols-12 gap-4 p-6" style="font-family: Lexend, 'Noto Sans', sans-serif;">
        <!-- Good Afternoon Section -->
        <div
            class="col-span-12 md:col-span-8 bg-gradient-to-r from-blue-400 to-blue-500 text-white rounded-lg p-6 shadow-md">
            <h1 class="text-2xl font-bold">
                Good
                @if (now()->hour < 12)
                    Morning
                @elseif(now()->hour < 18)
                    Afternoon
                @else
                    Evening
                @endif, {{ $userName }}.
            </h1>
            @if(auth()->user()->hasRole('student'))
            <p class="text-sm mt-2">
                You have {{ $tasks->count() }} task{{ $tasks->count() !== 1 ? 's' : '' }} due today.
            </p>
            @endif
        </div>

        
        <!-- Calendar Section -->
        <div class="col-span-12 md:col-span-4 bg-white rounded-lg p-4 shadow-md">
    <h2 class="text-lg font-bold">{{ now()->format('M d, Y') }}</h2>
    <p id="current-time" class="text-sm mt-2">
        <span class="text-lg font-bold">Ora curentă:</span> 
        <span id="time-display"></span>
    </p>
</div>

        <!-- Content for Students -->
        @if(auth()->user()->hasRole('student'))


        <!-- Upcoming Exams -->
<div class="col-span-12 md:col-span-8 bg-white rounded-lg p-4 shadow-md">
    <h3 class="text-lg font-bold mb-3">Upcoming Exams</h3>
    <ul>
        @forelse ($upcomingExams as $exam)
            <li class="flex justify-between items-center bg-gray-50 p-2 rounded-lg mb-2">
                <div>
                    <p class="font-medium">{{ $exam->subject->name }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $exam->exam_date->format('d M Y') }} | {{ $exam->start_time->format('H:i') }} - {{ $exam->end_time->format('H:i') }}
                    </p>
                    <p class="text-sm text-gray-400">Room: {{ $exam->room->name }} | Type: {{ $exam->type }}</p>
                </div>
            </li>
        @empty
            <p class="text-sm text-gray-500">No upcoming exams.</p>
        @endforelse
    </ul>
    <a href="{{route('exams.index')}}" class="inline-flex items-center justify-center p-5 text-base font-medium text-gray-500 rounded-lg bg-gray-50 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-3 8a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Zm2 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
</svg>
    <span class="w-full">Check out all your upcoming exams.</span>
    <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
</a> 
</div>
            <!-- Quick Add Section -->
    <div class="col-span-12 bg-white rounded-lg p-4 shadow-md">
        <h3 class="text-lg font-bold mb-3">Quick Add</h3>
        <div class="flex gap-2">
            <input
                type="text"
                id="newTaskTitle"
                class="form-input rounded-lg flex-1 border-gray-300"
                placeholder="Add a task title..."
                required
            />
            <button
                type="button"
                data-modal-target="addTaskModal"
                data-modal-toggle="addTaskModal"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
            >
                Add Task
            </button>
        </div>
    </div>

            <!-- Upcoming Tasks -->
            <div class="col-span-12 md:col-span-8 bg-white rounded-lg p-4 shadow-md">
                <h3 class="text-lg font-bold mb-3">Upcoming Tasks</h3>
                <ul>
                    @forelse ($tasks as $task)
                        <li class="flex justify-between items-center bg-gray-50 p-2 rounded-lg mb-2">
                            <div>
                                <p class="font-medium">{{ $task->title }}</p>
                                <p class="text-sm text-gray-500">{{ $task->description }}</p>
                                <p class="text-sm text-gray-400">
                                    {{ $task->deadline ? $task->deadline->format('d M Y, H:i') : 'No deadline' }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button type="button"
                                    onclick="window.location.href='{{ route('tasks.edit', $task->id) }}'"
                                    class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 rounded-lg px-5 py-2.5">
                                    Edit
                                </button>
                                <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 rounded-lg px-5 py-2.5">
                                    Delete
                                </button>
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-gray-500">No upcoming tasks.</p>
                    @endforelse
                </ul>
            </div>

            <!-- Focus Timer -->
            <div
                class="col-span-12 md:col-span-4 bg-gradient-to-r from-blue-400 to-blue-500 text-white rounded-lg p-4 shadow-md">
                <h3 class="text-lg font-bold mb-3">Focus Timer</h3>
                <p id="timer-display" class="text-4xl font-bold">25:00</p>
                <div class="mt-3 flex gap-2">
                    <button id="start-timer"
                        class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100">Start</button>
                    <button id="pause-timer"
                        class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 hidden">Pause</button>
                    <button id="reset-timer"
                        class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 hidden">Reset</button>
                </div>
            </div>

            <!-- Add Task Modal -->
<div id="addTaskModal" tabindex="-1" aria-hidden="true" 
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <button type="button"
                class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-toggle="addTaskModal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <input type="hidden" id="modalTaskTitle" name="title">
                <div class="mb-4">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">
                        Task Description
                    </label>
                    <textarea id="description" name="description" class="form-input rounded-lg w-full border-gray-300 focus:ring-primary-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:ring-primary-800" placeholder="Add a task description..." required></textarea>
                </div>
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <select id="subject" name="subject" required class="form-select rounded-lg w-full border-gray-300 focus:ring-primary-300">
                        <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select a subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->name }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                    <input type="datetime-local" id="deadline" name="deadline" value="{{ old('deadline') ?? now()->format('Y-m-d\TH:i') }}" required class="form-input rounded-lg w-full border-gray-300 focus:ring-primary-300">
                </div>
                <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-900">
                    Save Task
                </button>
            </form>
        </div>
    </div>
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-4"></div>

</div>
<!-- Delete Confirmation Modal -->
<div id="deleteTaskModal" tabindex="-1"
    class="hidden fixed top-0 left-0 right-0 z-50 p-4 overflow-x-hidden overflow-y-auto w-full md:inset-0 h-modal md:h-full">
    <!-- Change this button to include proper data attributes -->
    <button data-modal-target="deleteTaskModal" data-modal-toggle="deleteTaskModal"
        class="text-white bg-red-700 hover:bg-red-800 rounded-lg px-5 py-2.5">
        Delete
    </button>
    <div class="relative w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="p-6 text-center">
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this task?</h3>
                <form id="deleteTaskForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-800 px-5 py-2.5 rounded-lg">
                        Yes, delete it
                    </button>
                    <button type="button" data-modal-toggle="deleteTaskModal"
                        class="text-gray-500 bg-white hover:bg-gray-100 px-5 py-2.5 rounded-lg">
                        No, cancel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

        @endif


        

        <!-- Content for Professors -->
        @if(auth()->user()->hasRole('teacher'))
            <!-- Requests from Students -->
            <div class="col-span-12 md:col-span-8 bg-white rounded-lg p-4 shadow-md">
                <h3 class="text-lg font-bold mb-3">Student Requests</h3>
                <ul>
                    @forelse ($requests as $request)
                        <li class="flex justify-between items-center bg-gray-50 p-2 rounded-lg mb-2">
                            <div>
                                <p class="font-medium">{{ $request->student_name }}</p>
                                <p class="text-sm text-gray-500">Request: {{ $request->content }}</p>
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-gray-500">No requests from students.</p>
                    @endforelse
                </ul>
            </div>
        @endif
    </div>

    <!-- Content for Admin and Secretary -->
    @if(auth()->user()->hasRole('admin'))
    <!-- Recent Users -->
    <div class="col-span-12 md:col-span-6 bg-white rounded-lg p-4 shadow-md">
        <h3 class="text-lg font-bold mb-3">Recent Users</h3>
        <ul>
            @forelse ($recentUsers as $user)
                <li class="flex justify-between items-center bg-gray-50 p-2 rounded-lg mb-2">
                    <div>
                        <p class="font-medium">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <p class="text-sm text-gray-400">Joined: {{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </li>
            @empty
                <p class="text-sm text-gray-500">No new users.</p>
            @endforelse
        </ul>
        <a href="{{ url('/users') }}"
            class="inline-flex items-center justify-center p-3 text-sm font-medium text-gray-500 bg-gray-50 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
            See All Users
        </a>
    </div>

    <!-- Pending Exams -->
    <div class="col-span-12 md:col-span-6 bg-white rounded-lg p-4 shadow-md mt-4">
        <h3 class="text-lg font-bold mb-3">Pending Exams</h3>
        <ul>
            @forelse ($pendingExams as $exam)
                <li class="flex justify-between items-center bg-gray-50 p-2 rounded-lg mb-2">
                    <div>
                        <p class="font-medium">{{ $exam->subject->name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $exam->exam_date->format('d M Y') }} | {{ $exam->start_time->format('H:i') }}
                        </p>
                        <p class="text-sm text-gray-400">Room: {{ $exam->room->name }}</p>
                    </div>
                </li>
            @empty
                <p class="text-sm text-gray-500">No pending exams.</p>
            @endforelse
        </ul>
        <a href="{{ url('/evaluations/pending') }}"
            class="inline-flex items-center justify-center p-3 text-sm font-medium text-gray-500 bg-gray-50 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
            See All Pending Exams
        </a>
    </div>
@endif
@endsection




@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    @vite('resources/js/dashboardscripts.js')
@endpush
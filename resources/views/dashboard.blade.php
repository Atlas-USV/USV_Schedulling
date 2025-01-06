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
            <!-- Quick Add Section -->
            <div class="col-span-12 bg-white rounded-lg p-4 shadow-md">
                <h3 class="text-lg font-bold mb-3">Quick Add</h3>
                <div class="flex gap-2">
                    <input type="text" id="newTaskTitle" class="form-input rounded-lg flex-1 border-gray-300"
                        placeholder="Add a task title..." required />
                    <button type="button" data-modal-target="addTaskModal" data-modal-toggle="addTaskModal"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
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
    @vite('resources/js/dashboardscripts.js')
@endpush

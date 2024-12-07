@extends('layouts.app')

@section('title', 'Pending Evaluations')

@section('content')
@php
\Carbon\Carbon::setLocale('ro');
@endphp
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Subject</th>
                <th scope="col" class="px-6 py-3">Teacher</th>
                <th scope="col" class="px-6 py-3">Group</th>
                <th scope="col" class="px-6 py-3">Room</th>
                <th scope="col" class="px-6 py-3">Exam Date</th>
                <th scope="col" class="px-6 py-3">Start Time</th>
                <th scope="col" class="px-6 py-3">End Time</th>
                <th scope="col" class="px-6 py-3">Type</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Options</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($evaluations as $evaluation)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">{{ $evaluation->subject->name }}</td>
                    <td class="px-6 py-4">{{ $evaluation->teacher->name }}</td>
                    <td class="px-6 py-4">{{ $evaluation->group->name }}</td>
                    <td class="px-6 py-4">{{ $evaluation->room->name }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($evaluation->exam_date)->translatedFormat('l, d M Y') }}</td>
                    <td class="px-6 py-4">{{ $evaluation->start_time }}</td>
                    <td class="px-6 py-4">{{ $evaluation->end_time }}</td>
                    <td class="px-6 py-4">{{ ucfirst($evaluation->type) }}</td>
                    <td class="px-6 py-4">{{ $evaluation->status }}</td>
                    <td class="px-6 py-4 flex gap-2 justify-center items-center">
    <!-- Accept Button -->
    <form action="{{ route('evaluations.accept', $evaluation->id) }}" method="POST">
        @csrf
        <button type="submit" style="visibility: visible !important; display: block !important; opacity: 1 !important; background: green !important; z-index: 9999;" class="bg-green-700 text-white px-5 py-2.5 rounded-lg">
    Accept
</button>
    </form>
    <!-- Decline Button -->
<form action="{{ route('evaluations.decline', $evaluation->id) }}" method="POST">
    @csrf
    <button type="submit" class="focus:outline-none text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-900">
        Decline
    </button>
</form>
    <!-- Show More Info Button -->
    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 focus:outline-none" onclick="alert('More info about the evaluation');">
        More Info
    </button>
</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center px-6 py-4">No pending evaluations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $evaluations->links() }}
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
@endsection

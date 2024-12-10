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
                <th scope="col" class="px-6 py-3">Creator</th>
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
                    <td class="px-6 py-4">{{ $evaluation->creator ? $evaluation->creator->name : 'Unknown' }}</td>
                    <td class="px-6 py-4 flex gap-2 justify-center items-center">
    <!-- Accept Button -->
    <button type="button" onclick="openModal({{ $evaluation->id }})" class="bg-green-700 text-white px-5 py-2.5 rounded-lg">
    Accept
</button>
    </form>
    <!-- Decline Button -->
<form action="{{ route('evaluations.decline', $evaluation->id) }}" method="POST">
    @csrf
    <button type="button" onclick="openDeclineModal({{ $evaluation->id }})" class="focus:outline-none text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-900">
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


<!-- Modal -->
<div id="acceptModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Accept Evaluation</h2>
        <form id="acceptForm" method="POST" action="{{ route('evaluations.update') }}">
            @csrf
            <input type="hidden" name="evaluation_id" id="evaluationId" value="">

            <!-- Error Message -->
            <div id="errorMessage" class="mb-4 hidden text-red-600 font-medium"></div>

            <!-- Start Time -->
            <div class="mb-4">
                <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Start Time:</label>
                <div class="relative">
                    <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="time" id="start_time" name="start_time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="09:00" max="18:00" required />
                </div>
            </div>

            <!-- End Time -->
            <div class="mb-4">
                <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select End Time:</label>
                <div class="relative">
                    <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="time" id="end_time" name="end_time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="09:00" max="18:00" required />
                </div>
            </div>

            <!-- Room -->
            <div class="mb-4">
                <label for="room_id" class="block text-sm font-medium text-gray-700">Select Room:</label>
                <select name="room_id" id="room_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">Accept</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal pentru respingere -->
<div id="declineModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Respingere Examen</h2>
        <form id="declineForm" method="POST" action="">
            @csrf
            @method('POST')
            <!-- Input hidden pentru evaluare -->
            <input type="hidden" name="evaluation_id" id="declineEvaluationId" value="">
            <!-- Motivul respingerii -->
            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700">Motivul respingerii:</label>
                <textarea id="reason" name="reason" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeDeclineModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">Anulează</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Respinge</button>
            </div>
        </form>
    </div>
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

@stack('scripts')
<script>
    // Define funcțiile global
    function openModal(evaluationId) {
        document.getElementById('evaluationId').value = evaluationId;
        document.getElementById('acceptModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('acceptModal').classList.add('hidden');
    }

    function openDeclineModal(evaluationId) {
    document.getElementById('declineEvaluationId').value = evaluationId;
    document.getElementById('declineForm').action = `/evaluations/${evaluationId}/decline`; // Updatează URL-ul pentru form
    document.getElementById('declineModal').classList.remove('hidden');
}

function closeDeclineModal() {
    document.getElementById('declineModal').classList.add('hidden');
}

    // Asigură-te că restul codului este în funcția DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('acceptForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            const errorMessage = document.getElementById('errorMessage');

            // Reset mesajul de eroare
            errorMessage.textContent = '';
            errorMessage.classList.add('hidden');

            // Verifică validitatea timpului
            if (endTime <= startTime) {
                e.preventDefault();
                errorMessage.textContent = 'End time must be after start time!';
                errorMessage.classList.remove('hidden');
            }
        });
    }
});
</script>

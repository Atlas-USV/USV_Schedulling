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
     <button type="button" onclick="openModal({{ $evaluation->id }})" 
        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
        Accept
    </button>
    
    <!-- Decline Button inside form -->
    <form action="{{ route('evaluations.decline', $evaluation->id) }}" method="POST" class="m-0">
        @csrf
        <button type="button" onclick="openDeclineModal({{ $evaluation->id }})" 
            class="focus:outline-none text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">
            Decline
        </button>
    </form>

    
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


<!-- Modal Accept Evaluation -->
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
                <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900">Start Time:</label>
                <input type="time" id="start_time" name="start_time" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- End Time -->
            <div class="mb-4">
                <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900">End Time:</label>
                <input type="time" id="end_time" name="end_time" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Room -->
            <div class="mb-4">
                <label for="room_id" class="block mb-2 text-sm font-medium text-gray-900">Select Room:</label>
                <select name="room_id" id="room_id" class="w-full border rounded px-3 py-2" required>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Check Availability Button -->
            <div class="flex justify-end gap-2 mb-4">
                <button type="button" id="checkAvailabilityBtn" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Check Availability</button>
            </div>

            <!-- Submit and Cancel -->
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Cancel</button>
                <button type="submit" id="acceptSubmitBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700" disabled>Accept</button>
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

document.addEventListener('DOMContentLoaded', () => {
    const checkAvailabilityBtn = document.getElementById('checkAvailabilityBtn');
    const errorMessage = document.getElementById('errorMessage');
    const acceptSubmitBtn = document.getElementById('acceptSubmitBtn');

    checkAvailabilityBtn.addEventListener('click', () => {
        const evaluationId = document.getElementById('evaluationId').value;
        const startTime = document.getElementById('start_time').value;
        const endTime = document.getElementById('end_time').value;
        const roomId = document.getElementById('room_id').value;

        errorMessage.textContent = '';
        errorMessage.classList.add('hidden');
        acceptSubmitBtn.disabled = true;

        if (!startTime || !endTime || !roomId) {
            errorMessage.textContent = 'Selectează orele și sala pentru verificare!';
            errorMessage.classList.remove('hidden');
            return;
        }

        fetch("{{ route('evaluations.checkAvailability') }}", {
            method: "POST", // Metoda POST
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                evaluation_id: evaluationId,
                start_time: startTime,
                end_time: endTime,
                room_id: roomId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Server error: " + response.status);
            }
            return response.json();
        })
        .then(data => {
            let message = '';
            if (data.teacher_conflict) {
                message += 'Profesorul are deja un examen în acest interval orar.\n';
            }
            if (data.room_conflict) {
                message += 'Sala este deja ocupată în acest interval orar.\n';
            }

            if (!message) {
                message = 'Profesorul și sala sunt disponibile!';
                acceptSubmitBtn.disabled = false; // Activează butonul Submit
            } else {
                acceptSubmitBtn.disabled = true; // Dezactivează butonul Submit
            }

            errorMessage.textContent = message;
            errorMessage.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Eroare:', error);
            errorMessage.textContent = 'A apărut o eroare la verificare.';
            errorMessage.classList.remove('hidden');
        });
    });
});

</script>

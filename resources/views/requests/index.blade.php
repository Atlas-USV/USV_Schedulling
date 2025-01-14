@extends('layouts.app')

@section('title', 'Requests')

@section('content')

<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Requests</h1>
        <a href="{{ route('requests.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Create Request
        </a>
    </div>

    @if($requests->isEmpty())
        <p class="text-gray-600">No requests found.</p>
    @else
        <div class="bg-white shadow-md rounded-lg p-4">
            <ul class="divide-y divide-gray-200">
                @foreach($requests as $request)
                <li class="py-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">
                            {{ $request->content }}
                        </h3>
                        <p class="text-sm text-gray-600">
    @if(Auth::id() === $request->sender_id)
        Sent to: 
        {{ $request->teacher_id === Auth::id() ? $request->student->name : $request->teacher->name }}
        | Status: {{ ucfirst($request->status) }}
    @else
        From: {{ $request->sender ? $request->sender->name : 'Unknown' }} | Status: {{ ucfirst($request->status) }}
    @endif
</p>
                        <p class="text-xs text-gray-400">{{ $request->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    {{-- Permite modificarea statusului doar pentru destinatar --}}
                    @if(Auth::id() !== $request->sender_id)
                    <form action="javascript:void(0);" onsubmit="openModal('{{ route('requests.update', $request->id) }}', this.status.value)">
    <select name="status" class="form-select rounded-lg border-gray-300">
        <option value="pending" {{ $request->status === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ $request->status === 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="denied" {{ $request->status === 'denied' ? 'selected' : '' }}>Denied</option>
    </select>
    <button type="submit" class="ml-4 text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg">
        Update
    </button>
</form>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modal -->
    <div id="confirmation-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Confirm Update</h2>
        <p class="mb-4">Ești sigur că dorești să schimbi statusul cererii și să trimiți un mesaj în Inbox?</p>
        <form id="status-update-form" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" id="status-input">
            <div class="mb-4">
                <label for="message-body" class="block text-sm font-medium text-gray-700">Mesaj</label>
                <textarea id="message-body" name="message_body" rows="4" class="form-input mt-1 block w-full rounded-lg border-gray-300 shadow-sm" placeholder="Scrie mesajul pentru expeditor..."></textarea>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Confirm
                </button>
                <button type="button" onclick="closeModal()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
</div>

@endsection

@stack('scripts')
<script>
    function openModal(url, status) {
        document.getElementById('status-update-form').action = url;
        document.getElementById('status-input').value = status;
        document.getElementById('message-body').value = ''; // Resetează câmpul mesajului
        document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('confirmation-modal').classList.add('hidden');
    }
</script>
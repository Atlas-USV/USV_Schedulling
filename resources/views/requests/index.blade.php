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
                            @if(Auth::id() === $request->student_id)
                                Sent to: {{ $request->teacher->name }}
                            @elseif(Auth::id() === $request->teacher_id)
                                From: {{ $request->student->name }}
                            @endif
                            @if(Auth::user()->hasRole('teacher'))
                                | Status: {{ ucfirst($request->status) }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-400">{{ $request->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    @if(Auth::user()->hasRole('teacher'))
                    <form action="{{ route('requests.update', $request->id) }}" method="POST">
                        @csrf
                        @method('PUT')
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
</div>

@endsection

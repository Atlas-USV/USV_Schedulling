@extends('layouts.app')

@section('title', 'Create Request')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Create a Request</h1>

    <form action="{{ route('requests.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="mb-4">
            @if(auth()->user()->hasRole('student'))
                <label for="recipient_id" class="block text-sm font-medium text-gray-700">Select Teacher</label>
                <select id="recipient_id" name="recipient_id" required class="form-select rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-full">
                    <option value="">Choose a teacher</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            @elseif(auth()->user()->hasRole('teacher'))
                <label for="recipient_id" class="block text-sm font-medium text-gray-700">Select Student</label>
                <select id="recipient_id" name="recipient_id" required class="form-select rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-full">
                    <option value="">Choose a student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            @endif
            @error('recipient_id')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea id="content" name="content" rows="5" required
                class="form-input rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-full"
                placeholder="Write your message here...">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white font-medium text-sm px-5 py-2.5 rounded-lg hover:bg-blue-700">
            Send Request
        </button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
    <h1 class="text-xl font-bold mb-4">Edit Task</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}" required class="form-input rounded-lg w-full border-gray-300">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" required class="form-input rounded-lg w-full border-gray-300">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
            <select id="subject" name="subject" required class="form-select rounded-lg w-full border-gray-300">
                <option value="" disabled>Select a subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->name }}" {{ $task->subject == $subject->name ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
            <input type="datetime-local" id="deadline" name="deadline" value="{{ old('deadline', $task->deadline->format('Y-m-d\TH:i')) }}" required class="form-input rounded-lg w-full border-gray-300">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update Task</button>
        </div>
    </form>
</div>
@endsection

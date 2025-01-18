]@extends('layouts.app')

@section('title', 'Exams')

@section('content')
<div class="flex items-center justify-between mb-6 dark:text-gray-100">
    @if(auth()->user()->hasRole('teacher'))
        <h1 class="text-3xl font-bold">Exams You Teach</h1>
    @else
        <h1 class="text-3xl font-bold">Exams for Your Group </h1>
    @endif
    <!-- Filter Form -->
    <form method="GET" action="{{ route('exams.index') }}" class="flex items-center space-x-2">
        <select name="subject" class="form-select rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
            <option value="">All Subjects</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->name }}" {{ request('subject') === $subject->name ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-600 text-white font-medium text-sm px-5 py-2.5 rounded-lg hover:bg-blue-700">
            Filter
        </button>
    </form>
</div>

<div class="flex space-x-6 mb-4">
    <a href="{{ route('exams.index', array_merge(request()->all(), ['filter' => 'current'])) }}" 
       class="px-4 py-2 {{ request('filter') === 'current' || !request('filter') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} font-medium rounded-lg hover:bg-blue-700 focus:outline-none">
       Current
    </a>
    <a href="{{ route('exams.index', array_merge(request()->all(), ['filter' => 'past'])) }}" 
       class="px-4 py-2 {{ request('filter') === 'past' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} font-medium rounded-lg hover:bg-blue-700 focus:outline-none">
       Past
    </a>
</div>

@if($exams->isEmpty())
    <div class="flex flex-col items-center justify-center mt-20">
        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a2 2 0 012 2v16a2 2 0 01-4 0V4a2 2 0 012-2zM10 10h4m-2 2v4"></path>
        </svg>
        <p class="mt-4 text-gray-500 text-lg">No exams found.</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($exams as $exam)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-bold text-gray-800">{{ $exam->subject->name }}</h2>
                <p class="text-sm text-gray-600 mt-2">
                    {{ $exam->exam_date->format('d M Y') }} | {{ $exam->start_time->format('H:i') }} - {{ $exam->end_time->format('H:i') }}
                </p>
                <p class="text-sm text-gray-600">Room: {{ $exam->room->name }}</p>
                <p class="text-sm text-gray-600">Type: {{ $exam->type }}</p>
                @if(auth()->user()->hasRole('teacher'))
                    <p class="text-sm text-gray-600"><strong>Group:</strong> {{ $exam->group->name }}</p>
                @endif
                <!-- Toggle Additional Info Button -->
                <button type="button" class="mt-4 bg-blue-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none toggle-info">
                    Show Additional Info
                </button>
                <!-- Hidden Additional Info -->
                <div class="additional-info mt-4 hidden">
                    <p class="text-sm text-gray-600"><strong>Teacher:</strong> {{ $exam->teacher->name }}</p>
                    <p class="text-sm text-gray-600"><strong>Description:</strong> {{ $exam->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle Additional Info
        document.querySelectorAll('.toggle-info').forEach(button => {
            button.addEventListener('click', () => {
                const additionalInfo = button.nextElementSibling;
                if (additionalInfo.classList.contains('hidden')) {
                    additionalInfo.classList.remove('hidden');
                    button.textContent = 'Hide Additional Info';
                } else {
                    additionalInfo.classList.add('hidden');
                    button.textContent = 'Show Additional Info';
                }
            });
        });
    });
</script>
@endpush

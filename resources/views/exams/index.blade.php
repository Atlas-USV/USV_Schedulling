@extends('layouts.app')

@section('title', 'Exams')

@section('content')
<div class="flex items-center justify-between mb-6">
    @if(auth()->user()->hasRole('teacher'))
        <h1 class="text-3xl font-bold text-gray-500 dark:text-gray-200">Exams You Teach</h1>
    @else
        <h1 class="text-3xl font-bold text-gray-500 dark:text-gray-200">Exams for Your Group</h1>
    @endif
    <button id="download-pdf" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 dark:hover:bg-green-400">
        Download PDF
    </button>
</div>

<div class="">
    <table class="min-w-full bg-white border-collapse border border-gray-200 dark:bg-gray-800">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal dark:bg-gray-700 dark:text-gray-400">
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal dark:bg-gray-700 dark:text-gray-400">
                <th class="py-3 px-6 text-left">
                    <div class="relative">
                        <select id="filter-subject" name="subject"
                        data-hs-select='{
                        "hasSearch": true,
                        "searchPlaceholder": "Search subjects...",
                        "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 py-2 px-3",
                        "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-gray-800",
                        "placeholder": "All Subjects",
                        "toggleClasses": "relative py-2.5 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-50 border border-gray-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600",
                        "dropdownClasses": "mt-2 max-h-40 pb-1 px-1 space-y-0.5 z-20 w-72 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-gray-700 dark:border-gray-600",
                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600"
                    }'>
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->name }}" {{ request('subject') === $subject->name ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </th>
                <th class="py-3 px-6 text-left">Date</th>
                <th class="py-3 px-6 text-left">Time</th>
                <th class="py-3 px-6 text-left">Room</th>
                <th class="py-3 px-6 text-left">Type</th>
                @if(auth()->user()->hasRole('teacher'))
                    <th class="py-3 px-6 text-left">Group</th>
                @endif
                <th class="py-3 px-6 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light dark:text-gray-300">
            @forelse($exams as $exam)
                <tr class="border-b border-gray-200 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                    <td class="py-3 px-6">{{ $exam->subject->name }}</td>
                    <td class="py-3 px-6">{{ $exam->exam_date->format('d M Y') }}</td>
                    <td class="py-3 px-6">{{ $exam->start_time->format('H:i') }} - {{ $exam->end_time->format('H:i') }}</td>
                    <td class="py-3 px-6">{{ $exam->room->name }}</td>
                    <td class="py-3 px-6">{{ ucfirst($exam->type) }}</td>
                    @if(auth()->user()->hasRole('teacher'))
                        <td class="py-3 px-6">{{ $exam->group->name }}</td>
                    @endif
                    <td class="py-3 px-6">
                        <a href="{{ route('exams.calendar', ['exam' => $exam->id]) }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700  dark:hover:bg-blue-400">
                            View in Calendar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">
                        No exams found for the selected filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="flex justify-end mt-4">
    {{ $exams->links('vendor.pagination.flowbite') }}
</div>
@endsection

@push('scripts')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/hs-select/dist/hs-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/hs-select/dist/hs-select.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterSubject = document.querySelector('#filter-subject');

        if (filterSubject) {
            // Initialize HSSelect
            const selectSubject = HSSelect.getInstance('#filter-subject');

            // Add event listener for subject filter change
            filterSubject.addEventListener('change', function() {
                const selectedSubject = this.value;
                const url = new URL(window.location.href);
                url.searchParams.set('subject', selectedSubject || '');
                window.location.href = url.toString();
            });
        }
    });

    // PDF download functionality
    document.getElementById('download-pdf')?.addEventListener('click', function() {
        window.location.href = "{{ route('exams.downloadPdf') }}";
    });
</script>
@endpush

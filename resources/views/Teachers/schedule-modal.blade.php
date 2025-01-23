


<section class="bg-white dark:bg-gray-900 flex items-center justify-center py-12 px-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-2xl">
       

        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong>Nume:</strong> {{ $teacher->name }}</p>
            <p class="text-gray-700 dark:text-gray-300"><strong>Email:</strong> {{ $teacher->email }}</p>
        </div>

        @if ($teacher->schedules->isEmpty())
            <p class="text-gray-700 dark:text-gray-300">Acest profesor nu are program adăugat.</p>
        @else
            <div class="mb-4">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Program:</h4>
                <ul class="list-disc list-inside space-y-2">
                    @foreach ($teacher->schedules as $schedule)
                        <li class="text-gray-700 dark:text-gray-300">
                            <strong>{{ $schedule->day_of_week }}</strong>: {{ $schedule->start_time }} - {{ $schedule->end_time }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</section>

@extends('layouts.app')

@section('title', 'Teachers List')
@section('content')

<form method="GET" action="{{ route('Teachers.index') }}" class="max-w-md mx-auto mb-4">
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </div>
        <input type="search" name="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Teachers" value="{{ request('search') }}" />
        <button type="submit" class="text-base font-bold absolute end-2.5 bottom-2.5 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:bg-blue-600">Search</button>
    </div>
</form>

<!-- Modal pentru Detalii Profesor -->
<div id="detail-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-2xl">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Detalii Profesor</h3>
        <div id="modal-content">
            <!-- Conținutul va fi încărcat dinamic -->
            <p class="text-gray-700 dark:text-gray-300">Se încarcă detaliile profesorului...</p>
        </div>
        <div class="flex justify-end mt-4">
            <button data-modal-hide="detail-modal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                Închide
            </button>
        </div>
    </div>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="px-6 py-3">Nume</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Opțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $teacher)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">{{ $teacher->name }}</td>
                <td class="px-6 py-4">{{ $teacher->email }}</td>
                <td class="px-6 py-4">
                    <button class="text-blue-600 hover:underline" data-modal-show="detail-modal" data-teacher-id="{{ $teacher->id }}">Detalii</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="flex justify-end mt-4">
    {{ $users->links('vendor.pagination.flowbite') }}
</div>

@endsection

@push('scripts')
<script>
    // Funcție pentru afișarea modalului cu detalii despre profesor
    document.querySelectorAll('[data-modal-show]').forEach(button => {
        button.addEventListener('click', () => {
            const teacherId = button.getAttribute('data-teacher-id');
            const modal = document.getElementById('detail-modal');
            const modalContent = document.getElementById('modal-content');

            modalContent.innerHTML = '<p class="text-gray-700 dark:text-gray-300">Se încarcă detaliile profesorului...</p>';

            fetch(`/teachers/${teacherId}/schedule`)
                .then(response => response.text())
                .then(html => {
                    modalContent.innerHTML = html;
                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    modalContent.innerHTML = `<p class="text-red-500">Eroare la încărcarea datelor.</p>`;
                    console.error('Eroare:', error);
                });
        });
    });

    // Închiderea modalului
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('detail-modal').classList.add('hidden');
        });
    });
</script>
@endpush

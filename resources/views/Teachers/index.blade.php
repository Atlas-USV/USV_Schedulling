@extends('layouts.app')

@section('title', 'Teachers List')
@vite(['resources/js/contact.js'])
@section('content')

<form method="GET" action="{{ route('Teachers.index') }}" class="max-w-md mx-auto mb-4">   
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>
        <input type="search" name="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Teachers" value="{{ request('search') }}" />
        <button type="submit" class="text-base font-bold absolute end-2.5 bottom-2.5 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:bg-blue-600">Search</button>
    </div>
</form>

<!-- Mesaj pentru cazurile in care nu exista rezultate -->
@if(request('search') && $users->isEmpty())
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed inset-0 flex justify-center items-center z-50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Profesorul nu a fost găsit
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="flex justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="static-modal" type="button" class="text-base font-bold hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600">OK</button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modalul care se va deschide când apesi pe butonul "Detalii" -->
<div id="detail-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed inset-0 flex justify-center items-center z-50 hidden">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Detalii Profesor
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="flex justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="detail-modal" type="button" class="text-base font-bold hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600">OK</button>
            </div>
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
    <a href="#" class="text-blue-600 hover:underline" data-modal-show="detail-modal">Detalii</a>
</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Paginare -->
<div class="flex justify-end mt-4">
    {{ $users->links('vendor.pagination.flowbite') }}
</div>
<script>
    // Căutăm toate link-urile care au atributul 'data-modal-show'
    document.querySelectorAll('[data-modal-show]').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Previne comportamentul implicit al link-ului
            const modalId = this.getAttribute('data-modal-show'); // Obținem ID-ul modalului
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden'); // Eliminăm 'hidden' pentru a face modalul vizibil
        });
    });

    // Căutăm butoanele care au atributul 'data-modal-hide' pentru a închide modalul
    document.querySelectorAll('[data-modal-hide]').forEach(function(button) {
        button.addEventListener('click', function(event) {
            const modalId = this.getAttribute('data-modal-hide'); // Obținem ID-ul modalului
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden'); // Adăugăm 'hidden' pentru a ascunde modalul
        });
    });
</script>
@endsection

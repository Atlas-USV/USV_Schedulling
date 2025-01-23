@extends('layouts.app')

@section('title', 'Adăugare Consultație')

@section('content')
<section class="bg-white dark:bg-gray-900 flex items-center justify-center py-48">
    <form action="{{ route('addinfo.store') }}" method="POST">
        @csrf
        <div class="mb-6">
            <label for="day" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ziua săptămânii</label>
            <select id="day" name="day_of_week" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                <option value="" disabled selected>Alege o zi</option>
                <option value="Monday">Luni</option>
                <option value="Tuesday">Marți</option>
                <option value="Wednesday">Miercuri</option>
                <option value="Thursday">Joi</option>
                <option value="Friday">Vineri</option>
                <option value="Saturday">Sâmbătă</option>
                <option value="Sunday">Duminică</option>
            </select>
        </div>
        <div class="mb-6">
            <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ora de început</label>
            <input type="time" id="start_time" name="start_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        </div>
        <div class="mb-6">
            <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ora de sfârșit</label>
            <input type="time" id="end_time" name="end_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        </div>
        <div class="flex justify-center">
            <button type="submit" class="text-base font-bold hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600">Salvează</button>
        </div>
    </form>
</section>

@if(session('success'))
<div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed inset-0 flex justify-center items-center z-50">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Detalii salvate
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Închide</span>
                </button>
            </div>
            <div class="flex justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="static-modal" type="button" class="text-base font-bold hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600">OK</button>
            </div>
        </div>
    </div>
</div>
@endif

@if ($errors->any())
    <div class="text-red-500">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection

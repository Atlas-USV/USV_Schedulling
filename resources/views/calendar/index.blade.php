@extends('layouts.app')

@section('title', 'Calendar')
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/fullcalendar.custom.css'])
@endsection
@section('content')

    @auth
    <script>
        window.groups = @json($groups);
        window.cadri = @json($teachers);
        window.rooms = @json($rooms);
        window.subjects = @json($subjects);
        // Get current user data and roles as JSON objects
        window.currentUser = @json(auth()->user()->load(['faculty', 'speciality']));
        window.userRoles = @json(auth()->user()->roles->pluck('name'));
        // Filter cadri if user is secretary and not admin
        if (window.userRoles.includes('secretary')) {
            window.cadri = window.cadri.filter(c => c.teacher_faculty_id == window.currentUser.teacher_faculty_id);
            window.groups = window.groups.filter(g => g.speciality && g.speciality.faculty_id == window.currentUser.teacher_faculty_id);
        }
    </script>
    @endauth
    <div class="calendar-container p-2">

        @include('calendar.forms.event-info')
        @auth
        @include('calendar.forms.exam-proposal', [
            'groups' => $groups,
            'faculties' => $faculties,
            'specialities' => $specialities,
            'teachers' => $teachers,
            'subjects' => $subjects,
            'rooms' => $rooms,
        ])
        @endauth
        <div id="accordion-color" data-accordion="collapse">
            <h2 id="accordion-color-heading-1" class="mb-0">
                <button type="button"
                    class="flex items-center justify-between w-full p-1 font-small rtl:text-right text-gray-600 border  border-b-5 focus:outline-none  border-gray-200 rounded-t-xl  focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                    data-accordion-target="#accordion-color-body-1" aria-expanded="true"
                    aria-controls="accordion-color-body-1">
                    <span class="text-base ml-2">Filtre</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-1">
                <div class="border border-t-0  border-gray-200 ">

                    <div class="p-4">

                        <form id="filter-form" class="h-auto flex flex-col"> <!-- Added mb-4 for spacing -->
                            <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-5">
                                @auth
                                <div class="sm:col-span-1 rounded bg-gray-50 dark:bg-gray-800 hidden">
                                    <button id="modal-toggle" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">
                                        Adauga
                                    </button>
                                </div>
                                @endauth
                                <div class="sm:col-span-1">
                                    <label for="filter_group_dropdown"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Grupe</label>
                                    <div class="relative">
                                        <select id="filter_group_dropdown" name="filter_group_dropdown"
                                            data-hs-select='{
                        "hasSearch": true,
                        "searchPlaceholder": "Caută...", 
                        "searchClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                        "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                        "placeholder": "Alege o grupa...",
                        "toggleTag": "<button type=\"button\" id=\"filter_group_button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2.5 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-50 border border-gray-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                        "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                        "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                        }'
                                            class="hidden">
                                            <option value="">Choose</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <label for="filter_speciality_dropdown"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specialitati</label>
                                    <div class="relative">
                                        <select id="filter_speciality_dropdown" name="filter_speciality_dropdown"
                                            data-hs-select='{
                        "hasSearch": true,
                        "searchPlaceholder": "Caută...",
                        "searchClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                        "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                        "placeholder": "Alege o specialitate...",
                        "toggleTag": "<button type=\"button\" id=\"filter_speciality_button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2.5 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-50 border border-gray-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                        "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                        "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                        }'
                                            class="hidden">
                                            <option value="">Choose</option>
                                        </select>

                                    </div>
                                </div>
                                <div class=" sm:col-span-1">
                                    <label for="filter_faculty_dropdown"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Facultati</label>
                                    <div class="relative">
                                        <select id="filter_faculty_dropdown" name="filter_faculty_dropdown"
                                            data-hs-select='{
                        "hasSearch": true,
                        "searchPlaceholder": "Caută...",
                        "searchClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                        "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                        "placeholder": "Alege o facultate...",
                        "toggleTag": "<button type=\"button\" id=\"filter_faculty_button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2.5 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-50 border border-gray-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                        "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                        "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                        }'
                                            class="hidden">
                                            <option value="">Choose</option>
                                        </select>

                                    </div>
                                </div>

                                <div class=" sm:col-span-1">
                                    <label for="filter_teacher_dropdown"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cadri
                                        didactici</label>
                                    <div class="relative">
                                        <select id="filter_teacher_dropdown" name="filter_teacher_dropdown"
                                            data-hs-select='{
                        "hasSearch": true,
                        "searchPlaceholder": "Caută...",
                        "searchClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                        "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                        "placeholder": "Alege un cadru didactic...",
                        "toggleTag": "<button type=\"button\" id=\"filter_teacher_button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2.5 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-50 border border-gray-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                        "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                        "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                        }'
                                            class="hidden">
                                            <option value="">Choose</option>
                                        </select>

                                    </div>
                                </div>
                                <div class=" sm:col-span-1">
                                    <label for="filter_room_dropdown"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sali</label>
                                    <div class="relative">
                                        <select id="filter_room_dropdown" name="filter_room_dropdown"
                                            data-hs-select='{
                        "hasSearch": true,
                        "searchPlaceholder": "Caută...",
                        "searchClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                        "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                        "placeholder": "Alege o sala...",
                        "toggleTag": "<button type=\"button\" id=\"filter_room_button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2.5 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-50 border border-gray-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                        "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                        "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                        }'
                                            class="hidden">
                                            <option value="">Choose</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="py-2 px-2 mt-1 mx-2 border border-l-0 border-r-0 border-b-0 items-center flex  justify-end">

                        <div class="">
                            <button type="button" id="filter-reset-button"
                                class="items-center flex py-2 px-3 me-2 text-sm font-medium rounded-lg text-gray-900 focus:outline-none  hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <svg class="w-[17px] h-[17px] text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2.6" d="M6 18 17.94 6M18 18 6.06 6" />
                                </svg>

                                Reset
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Form Section -->


        <!-- Calendar Section -->
        <div id="calendar" class="mt-4 dark:text-gray-100"></div> <!-- Added mt-4 for spacing -->
    </div>

    @auth

    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-3xl max-h-full">




            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Programare examen
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Inchide fereastra</span>
                    </button>
                </div>


                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">

                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                        data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="flex-1 me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg focus:outline-none" id="profile-tab"
                                data-tabs-target="#exam" type="button" role="tab" aria-controls="exam"
                                aria-selected="false">Examen</button>
                        </li>
                        <li class="flex-1 me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 focus:outline-none"
                                id="retake-tab" data-tabs-target="#retake" type="button" role="tab"
                                aria-controls="retake" aria-selected="false">Restanta</button>
                        </li>
                        <li class="flex-1 me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 focus:outline-none"
                                id="colloquium-tab" data-tabs-target="#colloquium" type="button" role="tab"
                                aria-controls="colloquium" aria-selected="false">Colocviu</button>
                        </li>
                        <li class="flex-1 me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 focus:outline-none"
                                id="project-tab" data-tabs-target="#project" type="button" role="tab"
                                aria-controls="project" aria-selected="false">Proiect</button>
                        </li>
                        <li class="flex-1 me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 focus:outline-none"
                                id="reexamination-tab" data-tabs-target="#reexamination" type="button" role="tab"
                                aria-controls="reexamination" aria-selected="false">Reexaminare</button>
                        </li>
                    </ul>
                </div>
                <div id="default-tab-content">
                
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="exam" role="tabpanel"
                        aria-labelledby="exam-tab">
                        @include('calendar.forms.exam-form', [
                            'groups' => $groups,
                            'faculties' => $faculties,
                            'specialities' => $specialities,
                            'teachers' => $teachers,
                            'subjects' => $subjects,
                            'rooms' => $rooms,
                        ])
                        <!-- <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p> -->
                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="retake" role="tabpanel"
                        aria-labelledby="retake-tab">
                        @include('calendar.forms.retake-form', [
                            'faculties' => $faculties,
                            'specialities' => $specialities,
                            'teachers' => $teachers,
                            'subjects' => $subjects,
                            'rooms' => $rooms,
                        ])
                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="colloquium" role="tabpanel"
                        aria-labelledby="colloquium-tab">
                        @include('calendar.forms.colloquium-form', [
                            'groups' => $groups,
                            'faculties' => $faculties,
                            'specialities' => $specialities,
                            'teachers' => $teachers,
                            'subjects' => $subjects,
                            'rooms' => $rooms,
                        ])
                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="project" role="tabpanel"
                        aria-labelledby="project-tab">
                        @include('calendar.forms.project-form', [
                            'groups' => $groups,
                            'faculties' => $faculties,
                            'specialities' => $specialities,
                            'teachers' => $teachers,
                            'subjects' => $subjects,
                            'rooms' => $rooms,
                        ])
                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="reexamination" role="tabpanel"
                        aria-labelledby="reexamination-tab">
                        @include('calendar.forms.reexamination-form', [
                            'groups' => $groups,
                            'faculties' => $faculties,
                            'specialities' => $specialities,
                            'teachers' => $teachers,
                            'subjects' => $subjects,
                            'rooms' => $rooms,
                        ])
                    </div>
                </div>
                @endauth
                <!-- Modal body -->

            </div>
        </div>
    </div>


 

    <script>
        var grupaPlaceholder = 'Alege o grupa';
        var facultatePlaceholder = 'Alege o facultate';
        var specialitatePlaceholder = 'Alege o specialitate';
        var salaPlaceholder = 'Alege o sala';
        var cadriPlaceholder = 'Alege un cadru didactic';

        window.events = []
        window.populateDropdown = function(dropdownId, optionsArray, placeholder, valueKey = 'id', textKeys = {
            'name': ''
        }, select = null) {

            // Get the dropdown element by its ID
            const dropdown = $(`#${dropdownId}`);
            // Clear existing options
            if (select) {
                let toDelete = select.selectOptions.map(option => option.val)
                select.removeOption(toDelete)
            } else {
                dropdown.empty();
                dropdown.append(`<option value="" selected>${placeholder}</option>`);
            }

            // Add the placeholder option

            // Loop through the optionsArray and add new options
            optionsArray.forEach(option => {
                const value = option[valueKey]; // Get value using the provided key (default is 'id')

                // Build the text from the specified keys (default is ['name'])
                //const text = textKeys.map(key => option[key] || '').join(' - '); // Join with ' - ' if multiple keys are used
                let text = '';
                Object.entries(textKeys).forEach(([key, value]) => {
                    if (!value) {
                        text += `${option[key]}`
                    } else {
                        text += `${value} ${option[key]} `

                    }
                })
                if (select) {

                    select.addOption({
                        title: text,
                        val: `${value}`
                    })
                } else {
                    dropdown.append(`<option value="${value}">${text}</option>`);
                }
            });

            // Enable the dropdown if options are available, otherwise disable it
            dropdown.prop('disabled', optionsArray.length === 0);
        }

        window.lockDropdown = function(dropdownId, value, select) {
            const dropdown = $(`#${dropdownId}`);
            if (!value) value = "";
            dropdown.val(value.toString());
            dropdown.prop('disabled', true);
            if (select) {
                select.setValue(value.toString())
            }
        }

        window.unlockDropdown = function(dropdownId, select) {
            const dropdown = $(`#${dropdownId}`);

            dropdown.val("");
            dropdown.prop('disabled', false);
            if (select) {
                select.setValue('')
            }
        }




        window.filterEvents = function(allEvents = window.events) {
            const selectedFaculty = $('#filter_faculty_dropdown').val();
            const selectedSpeciality = $('#filter_speciality_dropdown').val();
            const selectedGroup = $('#filter_group_dropdown').val();
            const selectedTeacher = $('#filter_teacher_dropdown').val();
            const selectedRoom = $('#filter_room_dropdown').val();
            console.log(selectedFaculty)

            // Filter events based on selected values
            filteredEvents = allEvents.filter(event => {
                const groupMatches = !selectedGroup || event.group?.id == selectedGroup;
                const specialityMatches = selectedGroup ? true : (!selectedSpeciality || event.speciality?.id ==
                    selectedSpeciality);
                const facultyMatches = (selectedGroup || selectedSpeciality) ? true : (!selectedFaculty || event
                    .faculty_id == selectedFaculty);
                const teacherMatches = !selectedTeacher || event.teacher_id == selectedTeacher;
                const roomMatches = !selectedRoom || event.room?.id == selectedRoom;
                console.log(facultyMatches)

                return groupMatches && specialityMatches && facultyMatches && teacherMatches && roomMatches;
            });
            // Re-render the calendar with the filtered events
            $('#calendar').fullCalendar('removeEvents'); // Remove previous events
            $('#calendar').fullCalendar('addEventSource', filteredEvents); // Add filtered events
        }

        //filters

        $(document).ready(function() {
           

            const selectFaculty = HSSelect.getInstance('#filter_faculty_dropdown');
            selectFaculty.on('change', (val) => {
                console.log('changed')
            })
            const selectTeacher = HSSelect.getInstance(`#filter_teacher_dropdown`);
            const selectGroup = HSSelect.getInstance(`#filter_group_dropdown`);
            const selectSpeciality = HSSelect.getInstance(`#filter_speciality_dropdown`);
            const selectRoom = HSSelect.getInstance(`#filter_room_dropdown`);

            function initialPopulation() {
                populateDropdown('filter_faculty_dropdown', @json($faculties), facultatePlaceholder,
                    'id', {
                        'name': ''
                    }, selectFaculty)
                populateDropdown('filter_speciality_dropdown', @json($specialities),
                    specialitatePlaceholder, 'id', {
                        'name': ''
                    }, selectSpeciality)
                populateDropdown('filter_teacher_dropdown', @json($teachers), cadriPlaceholder, 'id', {
                    'name': ''
                }, selectTeacher)
                populateDropdown('filter_room_dropdown', @json($rooms), salaPlaceholder, 'id', {
                    'short_name': '',
                    'block': ' • bloc'
                }, selectRoom)
                populateDropdown('filter_group_dropdown', @json($groups), grupaPlaceholder, 'id', {
                    'name': '',
                    'speciality_short_name': ' •'
                }, selectGroup)

            }
            initialPopulation()
            $('#filter-reset-button').click(function() {
                initialPopulation()
                window.filterEvents()
            })

            $('#filter_faculty_dropdown').change(function() {
                var selectedOption = $(this).find('option:selected').val();

                if (selectedOption) {
                    const filteredTeachers = @json($teachers).filter(teacher => teacher
                        .teacher_faculty_id == selectedOption);
                    const filteredSpecialities = @json($specialities).filter(spec => spec
                        .faculty_id == selectedOption);
                    const filteredGroups = @json($groups).filter(group => group.speciality &&
                        group.speciality.faculty_id == selectedOption);
                    populateDropdown('filter_speciality_dropdown', filteredSpecialities,
                        specialitatePlaceholder, 'id', {
                            'name': ''
                        }, selectSpeciality)
                    populateDropdown('filter_teacher_dropdown', filteredTeachers, cadriPlaceholder, 'id', {
                        'name': ''
                    }, selectTeacher)
                    populateDropdown('filter_group_dropdown', filteredGroups, grupaPlaceholder, 'id', {
                        'name': '',
                        'speciality_short_name': ' •'
                    }, selectGroup)
                } else {
                    initialPopulation()
                }
                filterEvents()

            })
            $('#filter_group_dropdown').change(function() {

                var selectedOption = $(this).find('option:selected').val();
                const group = @json($groups).find(v => v.id === parseInt(selectedOption, 10))
                var selectedTeacher = $("#filter_teacher_dropdown").find('option:selected').val();

                if (selectedOption) {
                    console.log(group)
                    selectSpeciality.setValue(group.speciality_id.toString())
                    selectFaculty.setValue(group.speciality.faculty_id.toString())

                    const filteredTeachers = @json($teachers).filter(teacher => teacher
                        .teacher_faculty_id == group.speciality.faculty_id);
                    populateDropdown('filter_teacher_dropdown', filteredTeachers, cadriPlaceholder, 'id', {
                        'name': ''
                    }, selectTeacher)
                } else {
                    window.unlockDropdown("filter_speciality_dropdown")
                    window.unlockDropdown("filter_faculty_dropdown")
                    populateDropdown('filter_teacher_dropdown', @json($teachers),
                        cadriPlaceholder, 'id', {
                            'name': ''
                        }, selectTeacher)
                }
                selectTeacher.setValue(selectedTeacher.toString())
                filterEvents()
            })
            $('#filter_speciality_dropdown').change(function() {
                var selectedOption = $(this).find('option:selected').val();
                var selectedTeacher = $("#filter_teacher_dropdown").find('option:selected').val();
                if (selectedOption) {

                    const speciality = @json($specialities).find(s => s.id == selectedOption)
                    const faculty = @json($faculties).find(v => v.id == speciality.faculty_id)
                    selectFaculty.setValue(faculty.id.toString())
                    const filteredGroups = @json($groups).filter(group => group
                        .speciality_id == selectedOption);
                    populateDropdown('filter_group_dropdown', filteredGroups, grupaPlaceholder, 'id', {
                        'name': '',
                        'speciality_short_name': ' •'
                    }, selectGroup)
                    const filteredTeachers = @json($teachers).filter(teacher => teacher
                        .teacher_faculty_id == faculty.id);
                    populateDropdown('filter_teacher_dropdown', filteredTeachers, cadriPlaceholder, 'id', {
                        'name': ''
                    }, selectTeacher)

                } else {
                    window.unlockDropdown('filter_faculty_dropdown')
                    populateDropdown('filter_group_dropdown', @json($groups),
                        grupaPlaceholder, 'id', {
                            'name': '',
                            'speciality_short_name': ' •'
                        }, selectGroup)
                    populateDropdown('filter_teacher_dropdown', @json($teachers),
                        cadriPlaceholder, 'id', {
                            'name': ''
                        }, selectTeacher)
                }
                selectTeacher.setValue(selectedTeacher.toString())
                filterEvents()
            })
            $('#filter_teacher_dropdown').change(function() {
                var selectedOption = $(this).find('option:selected').val();
                var selectedGroup = $("#filter_group_dropdown").find('option:selected').val();
                var selectedSpeciality = $("#filter_speciality_dropdown").find('option:selected').val();
                if (selectedOption) {
                    const teacher = @json($teachers).find(t => t.id == selectedOption)
                    const faculty = @json($faculties).find(v => v.id == teacher
                        .teacher_faculty_id)
                    selectFaculty.setValue(faculty.id.toString())
                    if (!selectedGroup) {
                        const filteredSpecialities = @json($specialities).filter(spec => spec
                            .faculty_id == faculty.id);
                        const filteredGroups = @json($groups).filter(group => group
                            .speciality && group.speciality.faculty_id == faculty.id);
                        populateDropdown('filter_speciality_dropdown', filteredSpecialities,
                            specialitatePlaceholder, 'id', {
                                'name': ''
                            }, selectSpeciality)
                        populateDropdown('filter_group_dropdown', filteredGroups, grupaPlaceholder, 'id', {
                            'name': '',
                            'speciality_short_name': ' •'
                        }, selectGroup)
                    }
                } else {
                    if (!selectedGroup) {
                        window.unlockDropdown("filter_faculty_dropdown")
                        populateDropdown('filter_speciality_dropdown', @json($specialities),
                            specialitatePlaceholder, 'id', {
                                'name': ''
                            }, selectSpeciality)
                        populateDropdown('filter_group_dropdown', @json($groups),
                            grupaPlaceholder, 'id', {
                                'name': '',
                                'speciality_short_name': ' •'
                            }, selectGroup)
                    }

                }
                selectGroup.setValue(selectedGroup.toString())
                selectSpeciality.setValue(selectedSpeciality.toString())
                filterEvents()

            })
            $('#filter_room_dropdown').change(function() {
                var selectedOption = $(this).find('option:selected').val();
                filterEvents()
            })
        })

        function toLocalTime(time) {
            var val = new Date(time)
            var finalTime = new Date(time).toLocaleString(Intl.DateTimeFormat().resolvedOptions().locale, {
                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });
        }
        async function fetchEvents() {
            const response = await $.ajax({
                url: '/evaluations',
                type: 'GET',
                dataType: 'json',
            });

            return response.data.map(evaluation => ({
                ...evaluation,
                allDay: evaluation.allDay ?? false,
                backgroundColor: evaluation.color

            }));

        }

        function populateEventInfo(event) {
            $('#event-group-info').text('');
            const localizedExamName = JSON.parse(@json($evaluationTypes));
            $('#event-title-info').text("Info " + localizedExamName[event.type].toLowerCase());
            $('#event-evaluation-type-info').text(event.subject.name);
            $('#event-subject-info').text(event.subject.name); // Subject
            $('#event-teacher-email').text(event.teacher.email);
            event.room !== null ? $('#event-room-info').text(event.room.name) : '' // Room
            $('#event-date-info').text(event.start.local().format('DD-MM-YYYY') + '\n' + event.start.local().format(
                'H(:mm)')); // Start time (formatted)
            $('#event-duration-info').text((event.end - event.start) / (1000 * 60) + " min"); // Duration
            if (event.teacher !== null) {
                $('#event-teacher-info').text(event.teacher.name);
                $('#event-teacher-li-info').show();
            } else {
                $('#event-teacher-li-info').hide();
            }
            if (event.group !== null) {
                $('#event-group-info').text("Grupa " + event.group.name);
                $('#event-group-li-info').show();
            } else {
                $('#event-group-li-info').hide();
            }
          
            if (event.other_examinators && event.other_examinators.length > 0) {
                event.other_examinators.forEach(examinator => {
                    $('#event-teacher-info-container').append(`<span class="other_examinators text-sm dark:text-gray-200">${examinator.name}</span>`);
                });
            } else {
                $('#event-teacher-info-container .other_examinators').remove();
            }
            $('#description').html(event.description)
        }

        $(document).ready(async function() {
            events = await fetchEvents()
            //--calendar -- 
            var calendar = $('#calendar').fullCalendar({
                editable: true,
                height: '100%',
                timezone: 'local',
                timeFormat: 'H(:mm)',
                header: {
                    left: 'prev,next,@auth @if (auth()->user()->can('propose_exam')) proposeExamButton @elseif (auth()->user()->can('create_exams')) addExamButton @endif @endauth today',
                    center: 'title', 
                    right: 'month,agendaWeek,agendaDay,list'
                },
                //events: 'load.php',
                selectable: @auth @if(auth()->user()->can('create_exams')) true @else false @endif @else false @endauth,
                selectHelper: true,
                allDaySlot: true,
                displayEventTime: true,
                displayEventEnd: true,
                firstDay: 1,
                weekNumbers: false,
                weekNumberCalculation: "ISO",
                eventLimitClick: 'week', //popover
                navLinks: true,
                timeFormat: 'HH:mm',
                editable: false,
                slotLabelFormat: 'HH:mm',
                weekends: true,
                nowIndicator: true,
                dayPopoverFormat: 'dddd DD/MM',
                lazyFetching: true,
                eventLimit: true, // for all non-TimeGrid views
                eventBackgroundColor: "",
                eventTextColor: "white",
                events: events,
                //dayMaxEvents: 5,
                views: {
                    timeGrid: {
                        eventLimit: 2 // adjust to 6 only for timeGridWeek/timeGridDay
                    },
                    month: {
                        eventLimit: 5
                    }
                },
                customButtons: {
                    addExamButton: {
                        text: 'Adauga', // Button text
                        className: 'bg-blue-700 text-white px-5 py-2 rounded hover:bg-blue-800', // Tailwind classes
                        click: function() {
                            $('#modal-toggle').click()
                        }
                    },
                    proposeExamButton: {
                        text: 'Propune',
                        click: function() {
                            $('#exam-proposal-modal-toggle').click()
                        }
                    }
                },
                select: function(start) {
                    $('#modal-toggle').click()
                    const formattedStartTime = moment(start).format(
                    'YYYY-MM-DD HH:mm:ss'); // Adjust format as needed
                    $('#start_time').val(formattedStartTime);
                },
                eventClick: function(event) {
                    populateEventInfo(event)
                    console.log(event)
                    $('#event-details-modal-toggle').click()
                },
                



                eventRender: function(event, element, view) {}

            });
            const cal = $('#calendar').fullCalendar('getCalendar'); // Get the calendar instance

        });
    </script>


@endsection

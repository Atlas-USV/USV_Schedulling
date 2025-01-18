<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


    <script type="importmap">
    {
        "imports": {
            "https://esm.sh/v135/prosemirror-model@1.22.3/es2022/prosemirror-model.mjs": "https://esm.sh/v135/prosemirror-model@1.19.3/es2022/prosemirror-model.mjs",
            "https://esm.sh/v135/prosemirror-model@1.22.1/es2022/prosemirror-model.mjs": "https://esm.sh/v135/prosemirror-model@1.19.3/es2022/prosemirror-model.mjs"
        }
    }
    </script>
    <script src="
      https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
      <title>@yield('title', 'App')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])

</head>


<script>


  //toastr setup
   toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut",
      "timeOut": "5000", // 5 seconds
    };
</script>



<body class="bg-gray-50 dark:bg-gray-800">

<!-- Navbar doar cu iconița "My Account" -->
<nav class="navbar bg-white border-gray-500 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-end mx-auto p-6 ">
        <div class="flex items-center space-x-3 rtl:space-x-reverse">
            <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                <span class="sr-only">Open user menu</span>
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                        class="w-10 h-10 rounded-full object-cover border">
                @else
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-2xl">
                        <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                @endif
            </button>
            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ $user->name }}</span>
                    <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ $user->email }}</span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                        <a href="{{ route('user.my-account') }}"  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">My Account</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>


<div class=" pt-8  bg-gray-50 dark:bg-gray-900">
  <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
 </button>

<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidenav">
  <div class="overflow-y-auto py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
      <ul class="space-y-2">
      <li>
        <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg aria-hidden="true" class="w-6 h-6 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 2a1 1 0 01.707.293l7 7a1 1 0 01-1.414 1.414L10 4.414 3.707 10.707A1 1 0 012.293 9.293l7-7A1 1 0 0110 2z"></path>
                <path d="M4 10v6a2 2 0 002 2h8a2 2 0 002-2v-6h-2v6H6v-6H4z"></path>
            </svg>
            <span class="ml-3"><strong>Dashboard</strong></span>
        </a>
    </li>

    
    
    
          <li>
              <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                  <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                  <span class="flex-1 ml-3 text-left whitespace-nowrap"><strong>Pagini</strong></span>
                  <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
              <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                  <!-- <li>
                      <a href="{{ route('invitation') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Invitatii</a>
                  </li> -->
                  <!-- <li>
                      <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Kanban</a>
                  </li>
                  <li>
                      <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Calendar</a>
                  </li> -->

                  <!-- Add Exams Link -->
        <li>
            <a href="{{ route('exams.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z" clip-rule="evenodd"/>
              </svg>
              <span class="flex-1 ml-3 text-left whitespace-nowrap"><strong>Examene</strong></span>
            </a>
        </li>
        
        @if(Auth::check() && (Auth::user()->hasRole('student')))
        <li>
            <a href="{{ route('Teachers.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z" clip-rule="evenodd"/>
              </svg>
              <span class="flex-1 ml-3 text-left whitespace-nowrap"><strong>Teachers</strong></span>
            </a>
        </li>
        @endif
              </ul>
          </li>
          @if(Auth::check())
          <li>
              <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-sales" data-collapse-toggle="dropdown-sales">
              <svg class="w-6 h-6 text-gray-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
              </svg>
                  <span class="flex-1 ml-3 text-left whitespace-nowrap"><strong>Calendar</strong></span>
                  <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
              <ul id="dropdown-sales" class="hidden py-2 space-y-2">
                      <li>
                          <a href="{{ route('calendar') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"><strong>Programarea examenelor</strong></a>
                      </li>
                      <!-- <li>
                          <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Billing</a>
                      </li>
                      <li>
                          <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Invoice</a>
                      </li> -->
              </ul>
          </li>
          <li>
    <button type="button" 
        class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
        aria-controls="dropdown-requests-messages" data-collapse-toggle="dropdown-requests-messages">
        <svg class="w-6 h-6 text-gray-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16v-5.5A3.5 3.5 0 0 0 7.5 7m3.5 9H4v-5.5A3.5 3.5 0 0 1 7.5 7m3.5 9v4M7.5 7H14m0 0V4h2.5M14 7v3m-3.5 6H20v-6a3 3 0 0 0-3-3m-2 9v4m-8-6.5h1"/>
        </svg>
        <span class="flex-1 ml-3 text-left whitespace-nowrap"><strong>Notifications</strong></span>
        @php
            // Notificări pentru mesaje necitite
            $unreadMessages = App\Models\Message::where('user_id', Auth::id())->where('is_read', false)->count();
            // Cereri în pending pentru utilizatorul logat ca destinatar
            $pendingRequests = App\Models\Request::where(function ($query) {
    $query->where('teacher_id', Auth::id())
          ->orWhere('student_id', Auth::id());
})
->where('status', 'pending')
->where('sender_id', '!=', Auth::id()) // Exclude cererile trimise de utilizatorul logat
->count();

$statusChangedRequests = App\Models\Request::where('sender_id', Auth::id())
    ->whereIn('status', ['approved', 'denied'])
    ->where('status_read', false) // Afișează doar notificările necitite
    ->count();
            // Total notificări
            $totalNotifications = $unreadMessages + $pendingRequests + $statusChangedRequests;
        @endphp
        @if($totalNotifications > 0)
            <span class="inline-flex justify-center items-center w-5 h-5 text-xs font-semibold rounded-full text-white bg-red-500">
                {{ $totalNotifications }}
            </span>
        @endif
        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
    </button>
    <ul id="dropdown-requests-messages" class="hidden py-2 space-y-2">
        <li>
            <a href="{{ route('inbox.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
            <strong>Messages</strong>
                @if($unreadMessages > 0)
                    <span class="inline-flex justify-center items-center w-5 h-5 text-xs font-semibold rounded-full text-white bg-red-500 ml-auto">
                        {{ $unreadMessages }}
                    </span>
                @endif
            </a>
        </li>
        <li>
            <a href="{{ route('requests.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
            <strong>Pending Requests</strong>
                @if($pendingRequests > 0)
                    <span class="inline-flex justify-center items-center w-5 h-5 text-xs font-semibold rounded-full text-white bg-red-500 ml-auto">
                        {{ $pendingRequests }}
                    </span>
                @endif
            </a>
        </li>
        <li>
    <a href="{{ route('requests.markStatusUpdatesAsRead') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
    <strong>Status Updates</strong>
        @if($statusChangedRequests > 0)
            <span class="inline-flex justify-center items-center w-5 h-5 text-xs font-semibold rounded-full text-white bg-red-500 ml-auto">
                {{ $statusChangedRequests }}
            </span>
        @endif
    </a>
</li>
    </ul>
</li>

          @endif
         
          <li>
              <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-authentication" data-collapse-toggle="dropdown-authentication">
                  <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                  <span class="flex-1 ml-3 text-left whitespace-nowrap"><strong>Autentificare</strong></span>
                  <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
              <ul id="dropdown-authentication" class="hidden py-2 space-y-2">
              @if(Auth::check())
              <li>
                <a href="{{ route('password.change') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"><strong>Change Password</strong></a>
              </li>
              <li>
                <a href="{{ route('login') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"><strong>Log Out</strong></a>
              </li>
              @endif
              @if(!Auth::check())
              <li>
                  <a href="{{ route('login') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Sign In</a>
              </li>
              @endif
              </ul>
          </li>

          @if(Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('secretary')))
<li>
    <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-management" data-collapse-toggle="dropdown-management">
        <svg class="w-6 h-6 text-gray-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path d="M4 7h16v11a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"></path>
            <path d="M16 5V4a2 2 0 00-2-2H10a2 2 0 00-2 2v1h8z"></path>
        </svg>
        <span class="flex-1 ml-3 text-left whitespace-nowrap"><strong>Management</strong></span>
        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
    </button>
    <ul id="dropdown-management" class="hidden py-2 space-y-2">
        <li>
            <a href="{{ route('evaluations.pending') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4h16v2H4zM10 9h4v2h-4zM10 13h4v6h-4zM8 9h2v10H8zM14 9h2v10h-2z"></path>
                </svg>
                <strong>Administrare examene</strong>
            </a>
        </li>
        <li>
          <a href="{{ route('invitations') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
              <svg class="w-5 h-5 text-gray-800 dark:text-white mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M4 4h16v2H4zM10 9h4v2h-4zM10 13h4v6h-4zM8 9h2v10H8zM14 9h2v10h-2z"></path>
              </svg>
              <strong>Invitatii</strong>
            </a>
        </li>
        <li>
            <a href="{{ route('users.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4h16v2H4zM10 9h4v2h-4zM10 13h4v6h-4zM8 9h2v10H8zM14 9h2v10h-2z"></path>
                </svg>
                <strong>Administrare utilizatori</strong>
            </a>
        </li>
    </ul>
</li>
@endif
      </ul>
      <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
         
          <li>
              <a href="{{ route('contactus') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                  <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                  <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/></svg>
                  <span class="ml-3"><strong>Contact Us</strong></span>
              </a>
          </li>

           <!-- Meniu pentru schimbarea temei -->
        <li>
          <div class="overflow-y-auto py-5 px-2">
              <label for="theme-toggle" class="flex items-center cursor-pointer">
                  <span class="mr-2"><strong>Light/Dark Mode</strong></span> 
                  <input type="checkbox" id="theme-toggle" class="hidden">
                  <div class="relative">
                      <div class="switch-bg w-10 h-6 bg-gray-300 rounded-full shadow-inner transition-colors duration-300 ease-in-out"></div>
                      <div class="dot absolute w-6 h-6 bg-white rounded-full shadow inset-y-0 left-0 transition-transform duration-300 ease-in-out transform"></div>
                  </div>
              </label>
          </div>
        </li>

      </ul>

      
  </div>

  <style>
        /* Schimbă fundalul switch-ului și poziția bulinei când este activ */
        #theme-toggle:checked + div .switch-bg {
            background-color: #3b82f6; /* Culoarea albastră */
        }
        #theme-toggle:checked + div .dot {
            transform: translateX(1.5rem); /* Mută bulina în partea dreaptă */
        }

        /* Stiluri pentru titlul My Account în modul întunecat */
        body.dark .my-account-title {
            color: #E2E8F0; /* O nuanță deschisă pentru a contrasta cu fundalul întunecat */
        }
    </style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;

        // Verifică dacă tema este deja setată în localStorage
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark');
            themeToggle.checked = true;
        }

        // Ascultă evenimentul de schimbare pe checkbox
        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                body.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        });
    });
</script>

 
</aside>
<div id="main-content" class="sm:ml-64 relative  h-full bg-gray-50 lg:ml-64 dark:bg-gray-900">
    <div class="px-4 pt-1">
        @yield('content')
    </div>
</div>
</div>
<!-- Toasts -->
@if(session('success'))
    <div id="toast-success" class="fixed bottom-4 right-4 z-50 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
            ✓
        </div>
        <div class="ml-3 text-sm font-normal">{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div id="toast-error" class="fixed bottom-4 right-4 z-50 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
            ✕
        </div>
        <div class="ml-3 text-sm font-normal">{{ session('error') }}</div>
    </div>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>
</html>
@stack('scripts')
<!-- Script pentru ascunderea toast-urilor după 3 secunde -->
<script>
        setTimeout(() => {
            document.getElementById('toast-success')?.classList.add('hidden');
            document.getElementById('toast-error')?.classList.add('hidden');
        }, 3000);
    </script>
<!-- for notification -->
<script>
   $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    xhrFields: {
        withCredentials: true // Include session cookies
    }
});
// Set up global AJAX error handler
  $(document).ajaxError(function (event, jqXHR) {
      // Check if response contains JSON errors
      if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
          let errorMessages = jqXHR.responseJSON.errors;
          for (const field in errorMessages) {
              if (errorMessages.hasOwnProperty(field)) {
                  errorMessages[field].forEach(message => {
                      toastr.error(message); // Display each error message
                  });
              }
          }
      } else if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
          // Display general error message
          toastr.error(jqXHR.responseJSON.message);
      } else {
          // Fallback for unexpected errors
          toastr.error('Eroare necunoscută: ' + jqXHR.statusText);
      }
  });

  @if(session('toast_success'))
      toastr.success('{{ session('toast_success') }}');
  @endif

  @if(session('toast_error'))
      toastr.error('{{ session('toast_error') }}');
  @endif
</script>
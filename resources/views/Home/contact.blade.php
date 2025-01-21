<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="
      https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>  
      <title>@yield('title', 'Contact')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @vite(['resources/css/app.css','resources/js/contact.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <header>
    <nav class="bg-white border-b border-gray-300 px-4 lg:px-6 py-2.5 dark:bg-gray-800">

        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <a href="#" class="flex items-center">
                
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Exam Planner Pro</span>
            </a>
            <div class="flex items-center lg:order-2 space-x-4">
            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-2 lg:mt-0">
                    <li>
                        <a href="{{ route('home') }}" class="flex items-center justify-center p-2 pl-9 w-full text-base font-bold text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('features') }}" class="flex items-center justify-center p-2 pl-9 w-full text-base font-bold text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Features</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="flex items-center justify-center p-2 pl-9 w-full text-base font-bold text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Contact</a>
                    </li>
                </ul>
                <a href="{{ route('login') }}" class="flex items-center justify-center p-2 pl-9 w-full text-base font-bold text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Sign In</a>
            </div>
        </div>
    </nav>
</header>

<section class="bg-white dark:bg-gray-900 flex items-center justify-center py-48">
    <form action="{{ url('/contact') }}" method="POST">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First name</label>
                <input type="text" id="first_name" name="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required />
            </div>
            <div>
                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last name</label>
                <input type="text" id="last_name" name="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Doe" required />
            </div>
        </div>
        <div class="mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
            <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@company.com" required />
        </div> 
        <div class="mb-6">
            <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subject</label>
            <input type="text" id="subject" name="subject" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter the subject" required />
        </div> 
        <div class="mb-6">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message</label>
            <textarea id="message" name="message" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your message" rows="4" required></textarea>
        </div> 
        <div class="flex items-start mb-6">
            <div class="flex items-center h-5">
                <input id="remember" type="checkbox" name="remember" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required />
            </div>
            <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">I agree with the <a href="#" class="text-gray-900 underline dark:text-blue-500">terms and conditions</a>.</label>
        </div>
        <div class="flex justify-center">
            <button type="submit" class="text-base font-bold hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg  w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 ">Submit</button>
        </div>
    </form>
</section>

@if(session('success'))
<div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed inset-0 flex justify-center items-center z-50">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Thanks for the message
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

<section>
    <nav class="bg-white border-t border-gray-300 px-2 lg:px-4 py-1.5 dark:bg-gray-800 fixed bottom-0 left-0 w-full z-10">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <div class="max-w-screen-xl mx-auto px-2 text-center">
                <p class="text-xs">© 2025 Exam Planner Pro. All rights reserved.</p>
                <div class="flex flex-col justify-center mt-1 space-y-1">
                    <a href="{{ route('policy') }}" class="flex items-center justify-center p-1 text-sm font-normal text-gray-900 rounded-lg transition duration-75 group">Privacy Policy</a>
                    <a href="{{ route('service') }}" class="flex items-center justify-center p-1 text-sm font-normal text-gray-900 rounded-lg transition duration-75 group">Terms of Service</a>
                    <a href="{{ route('contact') }}" class="flex items-center justify-center p-1 text-sm font-normal text-gray-900 rounded-lg transition duration-75 group">Contact</a>
                </div>
            </div>
        </div>
    </nav>
</section>


<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>








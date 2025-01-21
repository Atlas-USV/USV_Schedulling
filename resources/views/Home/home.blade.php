<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="
      https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>  
      <title>@yield('title', 'Home')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
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

<main class="flex items-center justify-center h-[calc(100vh-160px)] px-8 bg-gray-50 dark:bg-gray-900">
    <div class="flex items-center space-x-8">
        <!-- Poza -->
        <img src="https://i.ibb.co/DbL7DkM/Atlas2.jpg" alt="Image" class="w-auto h-auto max-h-[80%]">
        <!-- Textul -->
        <div class="text-left">
            <p class="text-8xl font-bold leading-tight text-gray-900 dark:text-white">
                Lifting the<br> 
                weight of<br> 
                exams,<br> 
                one step at a time.
            </p>
        </div>
    </div>
</main>


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
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="
      https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>  
      <title>@yield('title', 'Features')</title>
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

<section class="bg-white dark:bg-gray-900 flex items-center justify-center py-48">
  <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
      <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
          <div>
              <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900">
                  <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
              </div>
              <h3 class="mb-2 text-xl font-bold dark:text-white">Simplified Scheduling</h3>
              <p class="text-gray-500 dark:text-gray-400">Easily coordinate exam dates and times across multiple courses and departments with our streamlined scheduling system.</p>
          </div>
          <div>
              <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900">
                  <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>
              </div>
              <h3 class="mb-2 text-xl font-bold dark:text-white">Student Management</h3>
              <p class="text-gray-500 dark:text-gray-400">Effortlessly manage student information, group assignments, and attendance for all exams in one place.</p>
          </div>
          <div>
              <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900">
                  <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path></svg>                    
              </div>
              <h3 class="mb-2 text-xl font-bold dark:text-white">Room Allocation</h3>
              <p class="text-gray-500 dark:text-gray-400">Automatically assign exam rooms based on student count and availability, ensuring an efficient setup every time.</p>
          </div>
      </div>
  </div>
</section>


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
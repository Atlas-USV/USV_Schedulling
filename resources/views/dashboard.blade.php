{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Galileo Design')

@section('content')
<div
  class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden"
  style='font-family: Lexend, "Noto Sans", sans-serif;'
>
  <div class="layout-container flex h-full grow flex-col">
    <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
      <div class="flex flex-wrap justify-between gap-3 p-4">
        <div class="flex min-w-72 flex-col gap-3">
          <p class="text-[#111518] tracking-light text-[32px] font-bold leading-tight">Welcome to your dashboard</p>
          <p class="text-[#60778a] text-sm font-normal leading-normal">Let's get started</p>
        </div>
      </div>
      
      <h3 class="text-[#111518] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Upcoming exams</h3>

      <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
        <div
          class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-14 w-fit"
          style='background-image: url("https://cdn.usegalileo.ai/sdxl10/8cc64fa7-573c-48fc-9494-00655f732d1b.png");'
        ></div>
        <div class="flex flex-col justify-center">
          <p class="text-[#111518] text-base font-medium leading-normal line-clamp-1">CS 101 Final Exam</p>
          <p class="text-[#60778a] text-sm font-normal leading-normal line-clamp-2">June 12, 2023</p>
        </div>
      </div>

      <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
        <div
          class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-14 w-fit"
          style='background-image: url("https://cdn.usegalileo.ai/sdxl10/62d89052-5909-49aa-a563-aeeafe04489c.png");'
        ></div>
        <div class="flex flex-col justify-center">
          <p class="text-[#111518] text-base font-medium leading-normal line-clamp-1">Math 54 Final Exam</p>
          <p class="text-[#60778a] text-sm font-normal leading-normal line-clamp-2">June 15, 2023</p>
        </div>
      </div>

      <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
        <div
          class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-14 w-fit"
          style='background-image: url("https://cdn.usegalileo.ai/sdxl10/482a43d7-5f01-4aba-baf1-e4ae23cf7e86.png");'
        ></div>
        <div class="flex flex-col justify-center">
          <p class="text-[#111518] text-base font-medium leading-normal line-clamp-1">History 7B Final Exam</p>
          <p class="text-[#60778a] text-sm font-normal leading-normal line-clamp-2">June 20, 2023</p>
        </div>
      </div>

      <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
        <div
          class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-14 w-fit"
          style='background-image: url("https://cdn.usegalileo.ai/sdxl10/6c81e12b-2548-4abc-8aed-ecaea8527450.png");'
        ></div>
        <div class="flex flex-col justify-center">
          <p class="text-[#111518] text-base font-medium leading-normal line-clamp-1">Econ 1 Final Exam</p>
          <p class="text-[#60778a] text-sm font-normal leading-normal line-clamp-2">June 25, 2023</p>
        </div>
      </div>

      <h3 class="text-[#111518] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Quick Add</h3>
      <div class="flex items-center gap-4 bg-white px-4 min-h-14">
        <div
          class="text-[#111518] flex items-center justify-center rounded-lg bg-[#f0f2f5] shrink-0 size-10"
          data-icon="Plus"
          data-size="24px"
          data-weight="regular"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
            <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path>
          </svg>
        </div>
        <p class="text-[#111518] text-base font-normal leading-normal flex-1 truncate">Add a task</p>
      </div>
      
      <h3 class="text-[#111518] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Request Exam</h3>
      <div class="px-4 py-3">
    <div class="flex items-center space-x-2">
    </div>
    <div class="mt-2">
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
            class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Request an exam.
        </button>
    </div>
    <div id="modal-content">
        @include('partials.modal_content', [
            'faculties' => $faculties,
            'groups' => $groups,
            'subjects' => $subjects,
            'teachers' => $teachers,
            'rooms' => $rooms
        ])
    </div>
</div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@vite('resources/js/dashboardscripts.js')
@endpush
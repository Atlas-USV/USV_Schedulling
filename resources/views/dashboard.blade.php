{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div
  class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden"
  style='font-family: Lexend, "Noto Sans", sans-serif;'
>
  <div class="layout-container flex h-full grow flex-col">
    <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
      <div class="flex flex-wrap justify-between gap-3 p-4">
        <div class="flex min-w-72 flex-col gap-3">
        <p class="text-[#111518] tracking-light text-[32px] font-bold leading-tight">
        Welcome, {{ $userName }} to your dashboard
    </p>          <p class="text-[#60778a] text-sm font-normal leading-normal">Let's get started</p>
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
      {{-- Quick Add --}}
      <h3 class="text-[#111518] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Quick Add</h3>

      <div class="px-4 py-3">
    <input
        type="text"
        id="newTaskTitle"
        class="form-input rounded-lg flex-1"
        placeholder="Add a task title..."
        required
    />
    <button
        type="button"
        data-modal-target="addTaskModal"
        data-modal-toggle="addTaskModal"
        class="text-white bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg"
    >
        Add Task
    </button>
</div>

<!-- Modal pentru adăugare task -->
<div id="addTaskModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <button type="button"
                class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-toggle="addTaskModal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <input type="hidden" id="modalTaskTitle" name="title">
                <div class="mb-4">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">
                        Task Description
                    </label>
                    <textarea id="description" name="description"
                        class="form-input rounded-lg w-full border-gray-300 focus:ring-primary-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:ring-primary-800"
                        placeholder="Add a task description..." required></textarea>
                </div>
                <button type="submit"
                    class="py-2 px-3 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-900">
                    Save Task
                </button>
            </form>
        </div>
    </div>
</div>

      {{-- Task List --}}
      <ul class="px-4">
          @foreach ($tasks as $task)
              <li class="flex items-center justify-between bg-white px-4 py-2 my-2">
                  <div>
                      <p class="font-medium">{{ $task->title }}</p>
                      <p class="text-sm text-[#60778a]">{{ $task->description }}</p>
                  </div>
                  <div class="flex gap-2">
                      <!-- Edit Button -->
                      <button type="button"
                          data-modal-target="editModal-{{ $task->id }}"
                          data-modal-toggle="editModal-{{ $task->id }}"
                          class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">
                          Edit
                      </button>

                      <!-- Delete Button -->
                      <button type="button"
                          data-modal-target="deleteModal-{{ $task->id }}"
                          data-modal-toggle="deleteModal-{{ $task->id }}"
                          class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                          Delete
                      </button>
                  </div>

                  <!-- Delete Modal -->
                  <div id="deleteModal-{{ $task->id }}" tabindex="-1" aria-hidden="true"
                      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                      <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                          <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                              <button type="button"
                                  class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                  data-modal-toggle="deleteModal-{{ $task->id }}">
                                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                      xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd"
                                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                          clip-rule="evenodd"></path>
                                  </svg>
                                  <span class="sr-only">Close modal</span>
                              </button>
                              <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this task?</p>
                              <div class="flex justify-center items-center space-x-4">
                                  <button data-modal-toggle="deleteModal-{{ $task->id }}" type="button"
                                      class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                      No, cancel
                                  </button>
                                  <form id="delete-task-{{ $task->id }}" action="{{ route('tasks.delete', $task->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit"
                                          class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                          Yes, I'm sure
                                      </button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Edit Modal -->
                  <div id="editModal-{{ $task->id }}" tabindex="-1" aria-hidden="true"
                      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                      <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                          <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                              <button type="button"
                                  class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                  data-modal-toggle="editModal-{{ $task->id }}">
                                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                      xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd"
                                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                          clip-rule="evenodd"></path>
                                  </svg>
                                  <span class="sr-only">Close modal</span>
                              </button>
                              <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="mb-4">
                                      <label for="title-{{ $task->id }}" class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Task Title</label>
                                      <input type="text" id="title-{{ $task->id }}" name="title" value="{{ $task->title }}"
                                          class="form-input rounded-lg w-full border-gray-300 focus:ring-primary-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:ring-primary-800">
                                  </div>
                                  <div class="mb-4">
                                      <label for="description-{{ $task->id }}" class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Task Description</label>
                                      <textarea id="description-{{ $task->id }}" name="description"
                                          class="form-input rounded-lg w-full border-gray-300 focus:ring-primary-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:ring-primary-800">{{ $task->description }}</textarea>
                                  </div>
                                  <button type="submit"
                                      class="py-2 px-3 text-sm font-medium text-center text-white bg-yellow-400 rounded-lg hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-900">
                                      Save changes
                                  </button>
                              </form>
                          </div>
                      </div>
                  </div>
              </li>
          @endforeach
      </ul>
    </div>
  </div>
</div>
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-4"></div>

@endsection

@push('scripts')
@vite('resources/js/dashboardscripts.js')
@endpush

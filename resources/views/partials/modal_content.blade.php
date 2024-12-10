<!-- Main modal -->
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-h-full" style="max-width: 42rem;">
      
           
            

                   <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
               <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Programare examen
                </h3>
                <button type="button" data-modal-toggle="crud-modal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
    </svg>
    <span class="sr-only">Inchide fereastra</span>
</button>
            </div>
                  <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
               <ul class="flex flex-wrap -mb-px">
                  <li class="flex-1 me-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Examen</a>
                  </li>
                  <li class="flex-1 me-2">
                        <a href="#" class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500" aria-current="page">Colocviu</a>
                  </li>
                  <li class="flex-1 me-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Restanta</a>
                  </li>
                  <li class="flex-1 me-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Reexaminare</a>
                  </li>
                  <li class="flex-1 me-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Proiect</a>
                  </li>
               </ul>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">
                           <!-- Faculty Dropdown -->
               <div class="col-span-2 sm:col-span-1">
                  <label for="faculty_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Faculty</label>
                  <select name="faculty_id" id="faculty_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                     <option value="" selected>Select a faculty</option>
                     @foreach($faculties as $faculty)
                           <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                     @endforeach
                  </select>
               </div>

               <!-- Group Dropdown -->
               <div class="col-span-2 sm:col-span-1">
                  <label for="group_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Group</label>
                  <select name="group_id" id="group_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                     <option value="" selected>Select a group</option>
                     @foreach($groups as $group)
                           <option value="{{ $group->id }}">{{ $group->name }}</option>
                     @endforeach
                  </select>
               </div>

               <!-- Subject Dropdown -->
               <div class="col-span-2 sm:col-span-1">
                  <label for="subject_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subject</label>
                  <select name="subject_id" id="subject_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                     <option value="" selected>Select a subject</option>
                     @foreach($subjects as $subject)
                           <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                     @endforeach
                  </select>
               </div>

               <!-- Teacher Dropdown -->
               <div class="col-span-2 sm:col-span-1">
                  <label for="teacher_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teacher</label>
                  <select name="teacher_id" id="teacher_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                     <option value="" selected>Select a teacher</option>
                     @foreach($teachers as $teacher)
                           <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                     @endforeach
                  </select>
               </div>

               <!-- Room Dropdown -->
               <div class="col-span-2 sm:col-span-1">
                  <label for="room_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Room</label>
                  <select name="room_id" id="room_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                     <option value="" selected>Select a room</option>
                     @foreach($rooms as $room)
                           <option value="{{ $room->id }}">{{ $room->name }}</option>
                     @endforeach
                  </select>
               </div>

               <!-- Start Time -->
               <div class="col-span-2 sm:col-span-1">
                  <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Time</label>
                  <input type="datetime-local" name="start_time" id="start_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
               </div>

               <!-- End Time -->
               <div class="col-span-2 sm:col-span-1">
                  <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Time</label>
                  <input type="datetime-local" name="end_time" id="end_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
               </div>

               <!-- Type -->
               <div class="col-span-2">
                  <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                  <select name="type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                        <option value="" selected>Select type</option>
                        <option value="exam">Exam</option>
                        <option value="colloquium">Colloquium</option>
                        <option value="project">Project</option>
                        <option value="reexamination">Reexamination</option>
                        <option value="retake">Retake</option>
                  </select>
               </div>

                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Description</label>
                        <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write product description here"></textarea>                    
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Add new product
                </button>
            </form>
        </div>
    </div>
</div> 
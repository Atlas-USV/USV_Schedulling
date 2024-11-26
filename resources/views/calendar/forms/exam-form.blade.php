<form class="p-4 md:p-5">
<div class="grid gap-4 mb-4 grid-cols-2">
                <!-- Faculty Dropdown -->
    <!-- <div class="col-span-2 sm:col-span-1">
        <label for="faculty_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Facultate</label>
        <select name="faculty_id" id="faculty_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="" selected>Alege o facultate</option>
            @foreach($faculties as $faculty)
                <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
            @endforeach
        </select>
    </div> -->

    <div class="col-span-2 sm:col-span-1">
        <label for="group_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Grupa</label>
        <select name="group_id" id="group_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="" selected>Alege o grupa</option>
            @foreach($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }} • {{ $group->speciality->short_name ?? 'N/A' }} • an {{ $group->study_year }}</option>
            @endforeach
        </select>
    </div> 

    <!-- <div class="col-span-2 sm:col-span-1">
        <label for="speciality_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specialitate</label>
        <select name="speciality_id" id="speciality_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="" selected>Alege o specialitate</option>
            @foreach($specialities as $speciality)
                <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
            @endforeach
        </select>
    </div>  -->

    <!-- Subject Dropdown -->
    <div class="col-span-2 sm:col-span-1">
        <label for="subject_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subiect</label>
        <select name="subject_id" id="subject_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="" selected>Alege un subiect</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Teacher Dropdown -->
    <div class="col-span-2 sm:col-span-1">
        <label for="teacher_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Profesor</label>
        <select name="teacher_id" id="teacher_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="" selected>Alege un profesor</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Room Dropdown -->
    <div class="col-span-2 sm:col-span-1">
        <label for="room_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sala</label>
        <select name="room_id" id="room_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="" selected>Alege o sala</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}">{{ $room->short_name }} • corp {{ $room->block }}</option>
            @endforeach
        </select>
    </div>

    <!-- Start Time -->
    <div class="col-span-2 sm:col-span-1">
        <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">De la</label>
        <input type="datetime-local" name="start_time" id="start_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
    </div>

    <!-- End Time -->
    <div class="col-span-2 sm:col-span-1">
        <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pana la</label>
        <input type="datetime-local" name="end_time" id="end_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
    </div>

        <div class="col-span-2">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descriere restanta</label>
            <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write product description here"></textarea>                    
        </div>
    </div>
    <button type="submit" id="submitButton" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
        Adauga
    </button>
</form>

<script>
    $('#submitButton').click(function (e) {
      var csrfToken = $('meta[name="csrf-token"]').attr('content');

      // Log it to the console
            e.preventDefault(); // Prevent form from submitting normally

            // Get form field values
           // const faculty_id = $('#faculty_id').val();
            const group_id = $('#group_id').val();
            const subject_id = $('#subject_id').val();
            const teacher_id = $('#teacher_id').val();
            const room_id = $('#room_id').val();
            const start_time = new Date($('#start_time').val()).toISOString();
            const end_time = new Date($('#end_time').val()).toISOString();
            const description = $('#description').val();
         //   const speciality_id = $('#speciality_id').val();
            // Prepare data to be sent in POST request
            const formData = {
                group_id: group_id,
                subject_id: subject_id,
                teacher_id: teacher_id,
                room_id: room_id,
                start_time: start_time,
                end_time: end_time,
                description: description,
              
                type: 'exam'
                //_token: "{{ csrf_token() }}" // Laravel CSRF token
            };

            // Make AJAX POST request
            $.ajax({
                url: '/evaluation', // Replace with your API URL
                type: 'POST',
                data: JSON.stringify(formData), // Convert the form data to JSON
                contentType: 'application/json', // Set the content type to JSON
                // data: formData,
                success: function (response) {
                    $('#calendar').fullCalendar('refetchEvents');

                    toastr.success('Examen salvat cu succes');
                },
                error: function (xhr, status, error) {
                    console.log(xhr)
                    console.log(error)
                    toastr.error('Eroare: ' + xhr);
                }
            });
        });
</script>
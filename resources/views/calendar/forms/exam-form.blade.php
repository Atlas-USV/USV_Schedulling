
<form class="p-4 md:p-5">
<div class="grid gap-4 mb-4 grid-cols-2">
    <div class="col-span-2 sm:col-span-1">
        <label for="group_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Grupa</label>
        <select name="group_id" id="group_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="" selected>Alege o grupa</option>
            @foreach($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }} • {{ $group->speciality->short_name ?? 'N/A' }} • an {{ $group->study_year }}</option>
            @endforeach
        </select>
    </div> 

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
        <label for="teacher_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cadru didactic</label>
        <select name="teacher_id" id="teacher_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="" selected>Alege un cadru didactic</option>
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

    <div class="col-span-2 sm:col-span-1">
    <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Durata (min)</label>
    <input type="number" id="number-input" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="120" required />
        <p id='durata-error-message'class="mt-2 text-sm text-red-600 dark:text-red-500 hidden">Durate trebuie sa fie cuprinsa intre 10 si 360 min</p>    
    </div>

        <div class="col-span-2">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Informatii aditionale:</label>
            @include('calendar.forms.rich-text-editor', ['idSuffix' => 'exam'])
            
        </div>
    </div>
    <div class="mb-2">

    </div>

    <button type="submit" id="submitExam" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
        Adauga
    </button>
</form>

@auth
    <script>
        var userRoles = "{{ auth()->user()->getRoleNames() }}"; // Assuming you use Spatie/laravel-permission
        var user = "{{ auth()->user() }}";
    </script>
@endauth

<script>
    var grupaPlaceholder = 'Alege o grupa';
    var salaPlaceholder = 'Alege o sala';
    var cadriPlaceholder = 'Alege un cadru didactic';
    var subiectPlaceholder = 'Alege un subiect';

    var groups = @json($groups);
    var cadri = @json($teachers);
    var rooms = @json($rooms);
    var subjects = @json($subjects);

    if(userRoles.includes['secretary']){
        groups = groups.filter(g => g.speciality && g.speciality.faculty_id == user.teacher_faculty_id)
        cadri = cadri.filter(c => c.teacher_faculty_id == user.teacher_faculty_id)
    }

    function initialPopulation(){
        window.populateDropdown('group_id', groups, grupaPlaceholder, 'id', {'name': '', 'speciality_short_name': ' •'})
        window.populateDropdown('teacher_id', cadri, cadriPlaceholder, 'id', {'name':''})

    }
    $(document).ready(function(){
        initialPopulation()
    })
    $('#submitExam').click(function (e) {
        
      var csrfToken = $('meta[name="csrf-token"]').attr('content');

      // Log it to the console
            e.preventDefault(); // Prevent form from submitting normally

            const numberInput = $('#number-input')
            const errorMessage = $('#durata-error-message')
            const inputValue = parseInt(numberInput.val(), 10);
            const minValue = 10;
            const maxValue = 360;
            if (isNaN(inputValue) || inputValue < minValue || inputValue > maxValue) {
                // Show error message if validation fails
                errorMessage.removeClass('hidden');
                return
            } else {
                // Hide error message if input is valid
                errorMessage.addClass('hidden');

              }
            
            const start_time = moment($('#start_time').val());
            const end_time = moment(start_time).add(inputValue, 'minutes'); // Add duration in minutes
             
            const start_time_iso = start_time.toISOString();
            const end_time_iso = end_time.toISOString();
            const group_id = $('#group_id').val();
            const subject_id = $('#subject_id').val();
            const teacher_id = $('#teacher_id').val();
            const room_id = $('#room_id').val();
            const description = $('#text-exam');
         //   const speciality_id = $('#speciality_id').val();
            // Prepare data to be sent in POST request
            const formData = {
                group_id: group_id,
                subject_id: subject_id,
                teacher_id: teacher_id,
                room_id: room_id,
                start_time: start_time_iso,
                end_time: end_time_iso,
                description: description[0].editor?.getHTML(),
              
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
                    window.events.push(response.data)
                    window.filterEvents()
                    toastr.success('Examen salvat cu succes');
                    
                    // Clear all form inputs
                    $('#group_id').val('');
                    $('#subject_id').val('');
                    $('#teacher_id').val('');
                    $('#room_id').val('');
                    $('#start_time').val('');
                    $('#number-input').val('');
                    
                    // Clear rich text editor
                    const editor = document.querySelector('#text-' + response.data.type).editor;
                    if (editor) {
                        editor.commands.setContent('');
                    }
                    
                    // Reset error message if visible
                    $('#durata-error-message').addClass('hidden');
                },
               
            });
        });
</script>
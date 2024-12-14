
<form class="p-4 md:p-5">
<div class="grid gap-4 mb-4 grid-cols-2">
   

    <!-- Subject Dropdown -->
    <div class="col-span-2 sm:col-span-1">
        <label for="retake_subject_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subiect</label>
        <div class="relative">
            <select id="retake_subject_id" name="retake_subject_id"
                data-hs-select='{
                "hasSearch": true,
                "searchPlaceholder": "Caută...",
                "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                "placeholder": "Alege un subiect...",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2.5 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-50 border border-gray-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                }'
            >
                <option value="">Choose</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Teacher Dropdown -->
    <div class="col-span-2 sm:col-span-1">
        <label for="retake_teacher_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cadru didactic</label>
        <div class="relative">
            <select id="retake_teacher_id" name="retake_teacher_id"
                data-hs-select='{
                "hasSearch": true,
                "searchPlaceholder": "Caută...",
                "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                "placeholder": "Alege un cadru didactic...",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2.5 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-50 border border-gray-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                }'
            >
                <option value="">Choose</option>
                {{-- @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach --}}
            </select>
        </div>
    </div>

    <!-- Room Dropdown -->
    <div class="col-span-2 sm:col-span-1">
        <label for="retake_room_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sala</label>
        <div class="relative">
            <select id="retake_room_id" name="retake_room_id"
                data-hs-select='{
                "hasSearch": true,
                "searchPlaceholder": "Caută...",
                "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                "placeholder": "Alege o sala...",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2.5 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-50 border border-gray-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                }'
            >
                <option value="">Choose</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->short_name }} • corp {{ $room->block }}</option>
                @endforeach
            </select>
        </div>
    </div>






    <!-- Start Time -->
    <div class="col-span-2 sm:col-span-1">
        <label for="retake_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">De la</label>
        <input type="datetime-local" name="start_time" id="retake_start_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
    </div>

    <div class="col-span-2 sm:col-span-1">
    <label for="retake-number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Durata (min)</label>
    <input type="number" id="retake-number-input" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="120" required />
        <p id='retake-durata-error-message'class="mt-2 text-sm text-red-600 dark:text-red-500 hidden">Durata trebuie sa fie cuprinsa intre 10 si 360 min</p>    
    </div>

        <div class="col-span-2">
            <label for="retake_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Informatii aditionale</label>
            @include('calendar.forms.rich-text-editor', ['idSuffix' => 'retake'])
            </div>
    </div>
    <button type="submit" id="submitRetake" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
        Adauga
    </button>
</form>



<script>
    var salaPlaceholder = 'Alege o sala';
    var cadriPlaceholder = 'Alege un cadru didactic';
    var subiectPlaceholder = 'Alege un subiect';
    
   
   
    $(document).ready(function(){
        function initialPopulation() {
        window.populateDropdown('retake_teacher_id', cadri, cadriPlaceholder, 'id', {'name':''}, selectTeacher);
    }
        const selectTeacher = window.HSSelect.getInstance(`#retake_teacher_id`);
        initialPopulation()
    })
    $('#submitRetake').click(function (e) {
      var csrfToken = $('meta[name="csrf-token"]').attr('content');

      // Log it to the console
            e.preventDefault(); // Prevent form from submitting normally

            const numberInput = $('#retake-number-input')
            const errorMessage = $('#retake-durata-error-message')
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
            
            const start_time = moment($('#retake_start_time').val());
            const end_time = moment(start_time).add(inputValue, 'minutes'); // Add duration in minutes
             
            const start_time_iso = start_time.toISOString();
            const end_time_iso = end_time.toISOString();
            const retake_subject_id = $('#retake_subject_id').val();
            const retake_teacher_id = $('#retake_teacher_id').val();
            const retake_room_id = $('#retake_room_id').val();
            const description = $('#text-retake');
         //   const speciality_id = $('#speciality_id').val();
            // Prepare data to be sent in POST request
            const formData = {
                subject_id: retake_subject_id,
                teacher_id: retake_teacher_id,
                room_id: retake_room_id,
                start_time: start_time_iso,
                end_time: end_time_iso,
                description: description[0].editor?.getHTML(),
              
                type: 'retake'
                //_token: "{{ csrf_token() }}" // Laravel CSRF token
            };

           
            $.ajax({
                url: '/evaluation', // Replace with your API URL
                type: 'POST',
                data: JSON.stringify(formData), // Convert the form data to JSON
                contentType: 'application/json', // Set the content type to JSON
                // data: formData,
                success: function (response) {
                    window.events.push(response.data)
                    window.filterEvents()
                    toastr.success('Restanta salvata cu succes');
                },
               
            });
        });
</script>
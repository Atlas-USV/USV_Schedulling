<div class="sm:col-span-1rounded bg-gray-50 dark:bg-gray-800 hidden">

<button id = "exam-proposal-modal-toggle"data-modal-target="exam-proposal-modal" data-modal-toggle="exam-proposal-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
  Toggle modal
</button>
</div>
<!-- Main modal -->
<div id="exam-proposal-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)]">
    <div class="relative p-4 w-full max-w-3xl ">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg h-auto max-h-[90vh] overflow-y-auto shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 id="event-title-info" class="text-xl font-semibold text-gray-900 dark:text-white">
                    Propunere examen @if(auth()->user()->groups) pentru grupa  {{ auth()->user()->groups->first()->name }} @endif
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="exam-proposal-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

        <form class="p-4 md:p-5">
        <div class="grid gap-4 mb-4 md:grid-cols-2 grid-cols-1">
            <div class="relative">

            <div class="col-span-2 sm:col-span-1 mb-2.5">
                <label for="exam_proposal_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tip</label>
                <select name="exam_proposal_type" id="exam_proposal_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected>Alege tipul examenului</option>
                    <option value="colloquium">Colocviu</option>
                    <option value="exam">Examen</option>
                    <option value="project">Proiect</option>
                </select>
            </div>

            <!-- Subject Dropdown -->
            <div class="col-span-2 sm:col-span-1 mb-2.5">
                <label for="exam_proposal_subject_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subiect</label>
                <select name="exam_proposal_subject_id" id="exam_proposal_subject_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected>Alege un subiect</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
             <!-- Teacher Dropdown -->
             <div class="col-span-2 sm:col-span-1 mb-2.5">
                <label for="exam_proposal_teacher_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cadru didactic</label>
                <select name="exam_proposal_teacher_id" id="exam_proposal_teacher_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected>Alege un cadru didactic</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" id="submit-exam-proposal" class="absolute bottom-0 left-0 text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                Trimite
            </button>
        </div>

        <div>
             <!-- Data examen -->
            <div class="col-span-2 sm:col-span-1">
                <label for="exam_proposal_teacher_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data examen</label>
                <div id="datepicker-exam-proposal" inline-datepicker data-date="02/25/2024"></div>
            </div>
            <div class="mt-2 grid grid-cols-2">
                <div>
                    <label for="start-time-exam-proposal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">De la:</label>
                    <div class="relative max-w-[10rem]">
                        <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input type="time" id="start-time-exam-proposal" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="09:00" max="18:00" value="00:00" required />
                    </div>
                </div>
                <div>
                <label for="number-input-exam-proposal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Durata (min)</label>
                    <input type="number" id="number-input-exam-proposal" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="120" required />
                <p id='durata-proposal-error-message'class="mt-2 text-sm text-red-600 dark:text-red-500 hidden">Durate trebuie sa fie cuprinsa intre 10 si 360 min</p>    
    
                </div>
            </div>
           
        </div>            
          
    </div>
    <div>

     </div>
  
    </div>
          
        </form>
    </div>
</div>
</div>
@auth
    <script>
        var userRoles = "{{ auth()->user()->getRoleNames() }}"; // Assuming you use Spatie/laravel-permission
        // Load the authenticated user with specified relationships
        var user = @json($user);
        
        // Log the user's faculty to confirm it works
        console.log(user);
    </script>
@endauth

<script>
    var cadriPlaceholder = 'Alege un cadru didactic';
    var subiectPlaceholder = 'Alege un subiect';

    var cadri = @json($teachers);
    var subjects = @json($subjects);

    if(user.speciality) cadri = cadri.filter(c => c.teacher_faculty_id === user.speciality.faculty_id)

    function initialPopulation(){
        window.populateDropdown('exam_proposal_teacher_id', cadri, cadriPlaceholder, 'id', {'name':''})

    }
    $(document).ready(function(){
        initialPopulation()
    })
    $('#submit-exam-proposal').click(function (e) {
        e.preventDefault(); // Prevent form from submitting normally
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        const numberInput = $('#number-input-exam-proposal')
        const errorMessage = $('#durata-proposal-error-message')
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
      // Log it to the console

            const date = moment($('#exam-proposal-date-picker').val());
            const time = $('#start-time-exam-proposal').val();
            let [hours, minutes] = time.split(':')
            date.set({hour: parseInt(hours), minute: parseInt(minutes), seconds: 0})
            const exam_proposal_subject_id = $('#exam_proposal_subject_id').val();
            const exam_proposal_teacher_id = $('#exam_proposal_teacher_id').val();
            const type = $('#exam_proposal_type').val();
         //   const speciality_id = $('#speciality_id').val();
            // Prepare data to be sent in POST request
            const formData = {
                subject_id: exam_proposal_subject_id,
                teacher_id: exam_proposal_teacher_id,
                start_time:date,
                end_time: moment(date).add(inputValue, 'minutes') ,
                type: type
                //_token: "{{ csrf_token() }}" // Laravel CSRF token
            };

            $.ajax({
                url: '/exam-propose', // Replace with your API URL
                type: 'POST',
                data: JSON.stringify(formData), // Convert the form data to JSON
                contentType: 'application/json', // Set the content type to JSON
                // data: formData,
                success: function (response) {
                    toastr.success('Propunere trimisa cu succes');
                },
               
            });
        });
</script>
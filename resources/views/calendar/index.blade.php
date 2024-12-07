@extends('layouts.app')

@section('title', 'Calendar')
@section('content')
<head>

</head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/fullcalendar.custom.css'])

</head>

<div class="p-4">
    
    @include('calendar.forms.event-info')

    <div id="accordion-color" data-accordion="collapse">
        <h2 id="accordion-color-heading-1" class="mb-0">
            <button type="button" class="flex items-center justify-between w-full p-1 font-small rtl:text-right text-gray-600 border  border-b-5 focus:outline-none  border-gray-200 rounded-t-xl  focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-1" aria-expanded="true" aria-controls="accordion-color-body-1">
            <span class="text-base ml-2">Filtre</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
            </button>
        </h2>
        <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-1">
        <form id="filter-form" class="h-auto flex flex-col overflow-auto border border-t-0  border-gray-200 dark:bg-gray-800 mb-6 p-4"> <!-- Added mb-4 for spacing -->
        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
            <div class="sm:col-span-1rounded bg-gray-50 dark:bg-gray-800 hidden">
                <button id="modal-toggle" data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                Adauga
                </button>
            </div>
            <div class="sm:col-span-1">
                <label for="filter_group_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Grupe</label>
                <select name="filter_group_dropdown" id="filter_group_dropdown" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <!-- <option value="" selected>Alege o grupa</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }} • {{ $group->speciality->short_name ?? 'N/A' }} • an {{ $group->study_year }}</option>
                    @endforeach -->
                </select>

            </div> 
            <div class="sm:col-span-1">
                <label for="filter_speciality_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specialitati</label>
                <select name="filter_speciality_dropdown" id="filter_speciality_dropdown" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <!-- <option value="" selected>Alege o specialitate</option>
                    @foreach($specialities as $spec)
                        <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                    @endforeach -->
                </select>
            </div> 
            <div class=" sm:col-span-1">
                <label for="filter_faculty_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Facultati</label>
                <select name="filter_faculty_dropdown" id="filter_faculty_dropdown" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <!-- <option value="" selected>Alege o facultate</option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                    @endforeach -->
                </select>
            </div> 
            <div class=" sm:col-span-1">
                <label for="filter_teacher_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cadri didactici</label>
                <select name="filter_teacher_dropdown" id="filter_teacher_dropdown" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <!-- <option value="" selected>Alege un cadru didactic</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach -->
                </select>
            </div> 
            <div class=" sm:col-span-1">
                <label for="filter_room_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sali</label>
                <select name="filter_room_dropdown" id="filter_room_dropdown" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <!-- <option value="" selected>Alege o sala</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->short_name }} • corp {{ $room->block }}</option>
                    @endforeach -->
                </select>
            </div> 
        </div>
    </form>
        </div>
    </div>
    <!-- Form Section -->
    

    <!-- Calendar Section -->
    <div id="calendar" class="mt-4"></div> <!-- Added mt-4 for spacing -->
</div>


<!-- Main modal -->
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full" >
      
           
            

                   <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
               <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Programare examen
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Inchide fereastra</span>
                </button>
            </div>
         

            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
               <li class="flex-1 me-2" role="presentation">
                  <button class="inline-block p-4 border-b-2 rounded-t-lg focus:outline-none" id="profile-tab" data-tabs-target="#exam" type="button" role="tab" aria-controls="exam" aria-selected="false">Examen</button>
               </li>
               <li class="flex-1 me-2" role="presentation">
                     <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 focus:outline-none" id="retake-tab" data-tabs-target="#retake" type="button" role="tab" aria-controls="retake" aria-selected="false">Restanta</button>
               </li>
               <li class="flex-1 me-2" role="presentation">
                     <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 focus:outline-none" id="colloquium-tab" data-tabs-target="#colloquium" type="button" role="tab" aria-controls="colloquium" aria-selected="false">Colocviu</button>
               </li>
               <li class="flex-1 me-2" role="presentation">
                     <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 focus:outline-none" id="project-tab" data-tabs-target="#project" type="button" role="tab" aria-controls="project" aria-selected="false">Proiect</button>
               </li>
               <li class="flex-1 me-2" role="presentation">
                     <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 focus:outline-none" id="reexamination-tab" data-tabs-target="#reexamination" type="button" role="tab" aria-controls="reexamination" aria-selected="false">Reexaminare</button>
               </li>
            </ul>
         </div>
         <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="exam" role="tabpanel" aria-labelledby="exam-tab">
            @include('calendar.forms.exam-form', ['groups' => $groups, 'faculties' => $faculties, 'specialities' => $specialities, 'teachers' => $teachers, 'subjects' => $subjects, 'rooms' => $rooms])
               <!-- <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p> -->
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="retake" role="tabpanel" aria-labelledby="retake-tab">
            @include('calendar.forms.retake-form', ['faculties' => $faculties, 'specialities' => $specialities, 'teachers' => $teachers, 'subjects' => $subjects, 'rooms' => $rooms])
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="colloquium" role="tabpanel" aria-labelledby="colloquium-tab">
            @include('calendar.forms.colloquium-form', ['groups' => $groups, 'faculties' => $faculties, 'specialities' => $specialities, 'teachers' => $teachers, 'subjects' => $subjects, 'rooms' => $rooms])
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="project" role="tabpanel" aria-labelledby="project-tab">
            @include('calendar.forms.project-form', ['groups' => $groups, 'faculties' => $faculties, 'specialities' => $specialities, 'teachers' => $teachers, 'subjects' => $subjects, 'rooms' => $rooms])
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="reexamination" role="tabpanel" aria-labelledby="reexamination-tab">
               <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
            </div>
         </div>
            <!-- Modal body -->
            
        </div>
    </div>
</div> 

<script>
   



    var grupaPlaceholder = 'Alege o grupa';
    var facultatePlaceholder = 'Alege o facultate';
    var specialitatePlaceholder = 'Alege o specialitate';
    var salaPlaceholder = 'Alege o sala';
    var cadriPlaceholder = 'Alege un cadru didactic';

    window.events = []
    window.populateDropdown = function(dropdownId, optionsArray, placeholder, valueKey = 'id', textKeys = {'name':''}) {
        // Get the dropdown element by its ID
        const dropdown = $(`#${dropdownId}`);
        // Clear existing options
        dropdown.empty();

        // Add the placeholder option
        dropdown.append(`<option value="" selected>${placeholder}</option>`);

        // Loop through the optionsArray and add new options
        optionsArray.forEach(option => {
            const value = option[valueKey]; // Get value using the provided key (default is 'id')

            // Build the text from the specified keys (default is ['name'])
            //const text = textKeys.map(key => option[key] || '').join(' - '); // Join with ' - ' if multiple keys are used
            let text = '';
            Object.entries(textKeys).forEach(([key,value]) => {
                if(!value){
                    text += `${option[key]}`
                }
                else{
                    text += `${value} ${option[key]} `

                }
            })
            dropdown.append(`<option value="${value}">${text}</option>`);
        });

        // Enable the dropdown if options are available, otherwise disable it
        dropdown.prop('disabled', optionsArray.length === 0);
    }

    window.lockDropdown = function(dropdownId, value) {
        const dropdown = $(`#${dropdownId}`);
        if(!value) value = "";
        dropdown.val(value.toString());
        dropdown.prop('disabled', true);
    }

    window.unlockDropdown = function(dropdownId) {
        const dropdown = $(`#${dropdownId}`);

        dropdown.val("");
        dropdown.prop('disabled', false);
    }
    function initialPopulation(){
        populateDropdown('filter_faculty_dropdown', @json($faculties), facultatePlaceholder, 'id', {'name':''})
        populateDropdown('filter_speciality_dropdown', @json($specialities), specialitatePlaceholder, 'id', {'name':''})
        populateDropdown('filter_teacher_dropdown', @json($teachers), cadriPlaceholder, 'id', {'name':''})
        populateDropdown('filter_room_dropdown', @json($rooms), salaPlaceholder, 'id', {'short_name': '','block' :' • bloc'})
        populateDropdown('filter_group_dropdown', @json($groups), grupaPlaceholder, 'id', {'name': '', 'speciality_short_name': ' •'})
    }

    window.filterEvents = function(allEvents = window.events) {
        const selectedFaculty = $('#filter_faculty_dropdown').val();
        const selectedSpeciality = $('#filter_speciality_dropdown').val();
        const selectedGroup = $('#filter_group_dropdown').val();
        const selectedTeacher = $('#filter_teacher_dropdown').val();
        const selectedRoom = $('#filter_room_dropdown').val();
        
       
        // Filter events based on selected values
        filteredEvents = allEvents.filter(event => {
            const groupMatches = !selectedGroup || event.group?.id == selectedGroup;
            const specialityMatches = selectedGroup ? true : (!selectedSpeciality || event.speciality?.id == selectedSpeciality);
            const facultyMatches = (selectedGroup  || selectedSpeciality ) ? true : (!selectedFaculty || event.faculty_id == selectedFaculty);
            const teacherMatches = !selectedTeacher || event.teacher_id == selectedTeacher;
            const roomMatches = !selectedRoom || event.room?.id == selectedRoom;


            return groupMatches && specialityMatches && facultyMatches && teacherMatches && roomMatches;
        });
        // Re-render the calendar with the filtered events
        $('#calendar').fullCalendar('removeEvents'); // Remove previous events
        $('#calendar').fullCalendar('addEventSource', filteredEvents); // Add filtered events
    }
   
    //filters
    $(document).ready(function() {
        initialPopulation()
        
        

        $('#filter_faculty_dropdown').change(function(){
            var selectedOption = $(this).find('option:selected').val();
            if(selectedOption){
                const filteredTeachers = @json($teachers).filter(teacher => teacher.teacher_faculty_id == selectedOption);
                const filteredSpecialities = @json($specialities).filter(spec => spec.faculty_id == selectedOption);
                const filteredGroups = @json($groups).filter(group => group.speciality && group.speciality.faculty_id == selectedOption);
                populateDropdown('filter_speciality_dropdown', filteredSpecialities, specialitatePlaceholder, 'id', {'name':''})
                populateDropdown('filter_teacher_dropdown', filteredTeachers, cadriPlaceholder, 'id', {'name':''})
                populateDropdown('filter_group_dropdown',filteredGroups, grupaPlaceholder, 'id', {'name': '', 'speciality_short_name': ' •'})
            }
            else{
                initialPopulation()
            }
            filterEvents()

        })
        $('#filter_group_dropdown').change(function(){
            var selectedOption = $(this).find('option:selected').val();
            const group = @json($groups).find(v => v.id === parseInt(selectedOption, 10))
            var selectedTeacher = $("#filter_teacher_dropdown").find('option:selected').val();
            if(selectedOption){
                lockDropdown("filter_speciality_dropdown",group.speciality_id )
                lockDropdown("filter_faculty_dropdown",group.speciality.faculty_id)
                const filteredTeachers = @json($teachers).filter(teacher => teacher.teacher_faculty_id == group.speciality.faculty_id);
                populateDropdown('filter_teacher_dropdown', filteredTeachers, cadriPlaceholder, 'id', {'name':''})
            }
            else{
                unlockDropdown("filter_speciality_dropdown")
                unlockDropdown("filter_faculty_dropdown")
                populateDropdown('filter_teacher_dropdown', @json($teachers), cadriPlaceholder, 'id', {'name':''})
            }
            $("#filter_teacher_dropdown").val(selectedTeacher)
            filterEvents()
        })
        $('#filter_speciality_dropdown').change(function(){
            var selectedOption = $(this).find('option:selected').val();
            var selectedTeacher = $("#filter_teacher_dropdown").find('option:selected').val();
            if(selectedOption){
                const speciality = @json($specialities).find(s=> s.id == selectedOption)
                const faculty = @json($faculties).find(v => v.id == speciality.faculty_id)
                lockDropdown("filter_faculty_dropdown", faculty.id)
                const filteredGroups = @json($groups).filter(group => group.speciality_id == selectedOption);
                populateDropdown('filter_group_dropdown',filteredGroups, grupaPlaceholder, 'id', {'name': '', 'speciality_short_name': ' •'})
                const filteredTeachers = @json($teachers).filter(teacher => teacher.teacher_faculty_id == faculty.id);
                populateDropdown('filter_teacher_dropdown', filteredTeachers, cadriPlaceholder, 'id', {'name':''})

            }
            else{
                unlockDropdown('filter_faculty_dropdown')
                populateDropdown('filter_group_dropdown', @json($groups), grupaPlaceholder, 'id', {'name': '', 'speciality_short_name': ' •'})
                populateDropdown('filter_teacher_dropdown', @json($teachers), cadriPlaceholder, 'id', {'name':''})
            }
            $("#filter_teacher_dropdown").val(selectedTeacher)
            filterEvents()
        })
        $('#filter_teacher_dropdown').change(function(){
            var selectedOption = $(this).find('option:selected').val();
            var selectedGroup = $("#filter_group_dropdown").find('option:selected').val();
            var selectedSpeciality = $("#filter_speciality_dropdown").find('option:selected').val();
            if(selectedOption){
                const teacher = @json($teachers).find(t=> t.id == selectedOption)
                const faculty = @json($faculties).find(v => v.id == teacher.teacher_faculty_id)
                lockDropdown("filter_faculty_dropdown", faculty.id)
                if(!selectedGroup){
                    const filteredSpecialities = @json($specialities).filter(spec => spec.faculty_id == faculty.id);
                    const filteredGroups = @json($groups).filter(group => group.speciality && group.speciality.faculty_id == faculty.id);
                    populateDropdown('filter_speciality_dropdown', filteredSpecialities, specialitatePlaceholder, 'id', {'name':''})
                    populateDropdown('filter_group_dropdown',filteredGroups, grupaPlaceholder, 'id', {'name': '', 'speciality_short_name': ' •'})
                }
            }
            else{
                if(!selectedGroup){
                    unlockDropdown("filter_faculty_dropdown")
                    populateDropdown('filter_speciality_dropdown', @json($specialities), specialitatePlaceholder, 'id', {'name':''})
                    populateDropdown('filter_group_dropdown', @json($groups), grupaPlaceholder, 'id', {'name': '', 'speciality_short_name': ' •'})
                }
              
            }
            $("#filter_group_dropdown").val(selectedGroup)
            $("#filter_speciality_dropdown").val(selectedSpeciality)
            filterEvents()

        })
        $('#filter_room_dropdown').change(function(){
            var selectedOption = $(this).find('option:selected').val();
            filterEvents()
        })
    })

   function toLocalTime(time){
      var val = new Date(time)
      var finalTime = new Date(time).toLocaleString(Intl.DateTimeFormat().resolvedOptions().locale, {
        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });
   }
   async function fetchEvents() {
        const response = await $.ajax({
            url: '/evaluations',
            type: 'GET',
            dataType: 'json',
        });

        return response.data.map(evaluation => ({
            ...evaluation,
            allDay: evaluation.allDay ?? false,
            backgroundColor: evaluation.color

        }));
       
    }
  
    function populateEventInfo(event){
        console.log(event)
        const localizedExamName = JSON.parse(@json($evaluationTypes));
        $('#event-title-info').text("Info " + localizedExamName[event.type].toLowerCase());
        $('#event-subject-info').text(event.subject.name);  // Subject
        $('#event-room-info').text(event.room.name);  // Room
        $('#event-teacher-info').text(event.teacher.name);  // Teacher
        $('#event-date-info').text(event.start.local().format('DD-MM-YYYY') + '\n' + event.start.local().format('H(:mm)'));  // Start time (formatted)
        $('#event-duration-info').text((event.end-event.start)/(1000* 60) + " min");  // Duration
        !event.group ?? $('#event-group-info').text("Grupa " + event.group.name)
        $('#description').html(event.description)
    }

   $(document).ready(async function() {
    events = await fetchEvents()
     //--calendar -- 
    var calendar = $('#calendar').fullCalendar({
     editable:true,
     timezone: 'local',
     timeFormat: 'H(:mm)',
     header:{
      left:'prev,next,myCustomButton today',
      center:'title',
      right:'month,agendaWeek,agendaDay,list'
     },
     //events: 'load.php',
    selectable:true,
    selectHelper:true,
    allDaySlot: true,
    displayEventTime: true,
    displayEventEnd: true,
    firstDay: 1,
    weekNumbers: false,
    selectable: true,
    weekNumberCalculation: "ISO",
    eventLimitClick: 'week', //popover
    navLinks: true,
    timeFormat: 'HH:mm',
    editable: false,
    slotLabelFormat: 'HH:mm', 
    weekends: true,
    nowIndicator: true,
    dayPopoverFormat: 'dddd DD/MM', 
    lazyFetching: true,
    eventLimit: true, // for all non-TimeGrid views
    eventBackgroundColor: "",
    eventTextColor: "white",
    events: events,
    //dayMaxEvents: 5,
    views: {
    timeGrid: {
      eventLimit: 2 // adjust to 6 only for timeGridWeek/timeGridDay
    },
    month: {
       eventLimit: 5
     }
    },
    customButtons: {
        myCustomButton: {
        text: 'Adauga', // Button text
        className: 'bg-blue-700 text-white px-5 py-2 rounded hover:bg-blue-800', // Tailwind classes
        click: function() {
            $('#modal-toggle').click()
        }
      }
  },
     select: function(start)
     {
        $('#modal-toggle').click()
        const formattedStartTime = moment(start).format('YYYY-MM-DD HH:mm:ss'); // Adjust format as needed
        $('#start_time').val(formattedStartTime);
     },
     eventClick:function(event)
     {
        populateEventInfo(event)
        $('#event-details-modal-toggle').click()
     },
     eventResize:function(event)
     {
      var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
      var title = event.title;
      var id = event.id;
      $.ajax({
       url:"update.php",
       type:"POST",
       data:{title:title, start:start, end:end, id:id},
       success:function(){
        calendar.fullCalendar('refetchEvents');
        alert('Event Update');
       }
      })
     },
 
     eventDrop:function(event)
     {
      var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
      var title = event.title;
      var id = event.id;
      $.ajax({
       url:"update.php",
       type:"POST",
       data:{title:title, start:start, end:end, id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Updated");
       }
      });
     },
 
    
     
     eventRender: function(event, element, view){
     }
 
    });
    const cal = $('#calendar').fullCalendar('getCalendar'); // Get the calendar instance
  
   });
   </script>


@endsection

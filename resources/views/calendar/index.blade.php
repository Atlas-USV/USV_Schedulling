@extends('layouts.app')

@section('title', 'Calendar')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    xhrFields: {
        withCredentials: true // Include session cookies
    }
});

</script>

@vite(['resources/css/fullcalendar.custom.css'])
<div class="container p-4 sm:ml-64">
   <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
   Adauga
   </button>
   <div id="calendar"></div>
  
</div>


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
               <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="project" role="tabpanel" aria-labelledby="project-tab">
               <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
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

   function toLocalTime(time){
      var val = new Date(time)
      console.log(val.toLocaleString())
      var finalTime = new Date(time).toLocaleString(Intl.DateTimeFormat().resolvedOptions().locale, {
        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });
   //  return finalTime.toISOString();
   }
   var events = [];
   $(document).ready(function() {
      
   //    $.ajax({
   //      url: '/evaluations', // Replace with your API endpoint
   //      type: 'GET',
   //      dataType: 'json',
   //      success: function(response) {
   //          console.log(response)
   //          // Assuming response is an array of event objects
   //          events = response.data.map(event => ({
   //              id: event.id,
   //              title: event.title,
   //              start: event.start,
   //              end: event.end,
   //              allDay: event.allDay || false // Ensure this property is set
   //          }));
   //      },
   //      error: function(xhr, status, error) {
   //          console.error('Failed to fetch events:', error);
   //      }
   //  });
      

     //--calendar -- 
    var calendar = $('#calendar').fullCalendar({
     editable:true,
     timezone: 'local',
     timeFormat: 'H(:mm)',
     header:{
      left:'prev,next today',
      center:'title',
      right:'month,agendaWeek,agendaDay,list'
     },
     //events: 'load.php',
     selectable:true,
     selectHelper:true,
     select: function(start, end, allDay)
     {
      var title = prompt("Enter Event Title");
      if(title)
      {
      //  var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      //  var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      //  $.ajax({
      //   url:"insert.php",
      //   type:"POST",
      //   data:{title:title, start:start, end:end},
      //   success:function()
      //   {
      //    calendar.fullCalendar('refetchEvents');
      //    alert("Added Successfully");
      //   }
      //  })
      }
     },
     editable:true,
     events: function(start, end, timezone, callback) {
            $.ajax({
                url: '/evaluations', // Replace with your endpoint
                type: 'GET',
                dataType: 'json',
                data: {
                  //   // Optional: send date range to the server
                  //   start: start.format("YYYY-MM-DD"), 
                  //   end: end.format("YYYY-MM-DD")
                },
                success: function(response) {
                    // Transform response data to FullCalendar format
                  //   console.log(response.data)
                    const events = response.data.map(evaluation => ({
                    
                        id: evaluation.id,
                        title: evaluation.title,
                        start:  evaluation.start, // Ensure the property matches your API
                        end: evaluation.end  // Ensure the property matches your API
                        // allDay: evaluation.all_day    // Optional property
                    }));
                    console.log(events)
                    // Pass events to FullCalendar
                    callback(events);
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch evaluations:', error);
                }
            });
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
 
     eventClick:function(event)
     {
      if(confirm("Are you sure you want to remove it?"))
      {
       var id = event.id;
       $.ajax({
        url:"delete.php",
        type:"POST",
        data:{id:id},
        success:function()
        {
         calendar.fullCalendar('refetchEvents');
         alert("Event Removed");
        }
       })
      }
     },
 
    });
   //  calendar.render();
   });
   
   </script>


@endsection

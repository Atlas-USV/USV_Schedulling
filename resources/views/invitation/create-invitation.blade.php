@extends('layouts.app')

@section('title', 'Create nvitation')
@section('content')
    <form action="{{ route('invitation.store') }}" method="POST">
        @csrf <!-- CSRF token for security -->
        <div class="grid gap-6 mb-6 md:grid-cols-2">


            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresa email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@company.com" required />
                @error('email')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="role_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rol</label>
                <select id="role_dropdown" name="role_dropdown" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Selecteaza un rol</option>
                    <!-- Add roles dynamically -->
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="group_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Grupa</label>
                <select id="group_dropdown" name="group_dropdown"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Selecteaza o grupa</option>
                    <!-- Add groups dynamically -->
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}" data-speciality-id="{{ $group->speciality_id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="teacher_faculty_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white ">Facultate (numai pentru profesor/secretar)</label>
                <select id="teacher_faculty_dropdown" name="teacher_faculty_dropdown" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Selecteaza o facultate</option>
                    <!-- Add faculties dynamically -->
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="speciality_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specialitate</label>
                <select id="speciality_dropdown" name="speciality_dropdown" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Selecteaza o specialitate</option>
                    <!-- Add specialities dynamically -->
                    @foreach ($specialities as $speciality)
                        <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>

    @if ($errors->has('teacher_faculty_id'))
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <!-- <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg> -->
        <span class="sr-only">Erori</span>
        <div>
            <!-- <span class="font-medium">Ensure that these requirements are met:</span> -->
            <ul class="mt-1.5 list-disc list-inside">
                @foreach ($errors->get('teacher_faculty_id') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        </div>
    @endif
    <script>
        $(document).ready(function() {
            $('#speciality_dropdown').change(function(){
                var selectedOption = $(this).find('option:selected');
                if(selectedOption.val() !== ''){
                    $('#group_dropdown').empty();
                    $('#group_dropdown').append('<option value="">Selecteaza o grupa</option>');
                    @json($groups).forEach(function(group) {
                        if(group.speciality_id == selectedOption.val()){
                            $('#group_dropdown').append('<option value="'+group.id+'" data-speciality-id="'+group.speciality_id+'">'+group.name+'</option>');
                        }
                    });
                }else{
                    $('#group_dropdown').empty();
                    $('#group_dropdown').append('<option value="">Selecteaza o grupa</option>');
                    @json($groups).forEach(function(group) {
                            $('#group_dropdown').append('<option value="'+group.id+'" data-speciality-id="'+group.speciality_id+'">'+group.name+'</option>');
                    });
                }
            })
    // Listen for changes on the groups dropdown
            $('#role_dropdown').change(function(){
                var selectedOption = $(this).find('option:selected');
                var group = $('#group_dropdown')
                var speciality = $('#speciality_dropdown')
                // Get the group name (text inside the option)
                var roleName = selectedOption.text().toLowerCase();
                if(roleName == 'student'){
                    //$('#teacher_faculty_dropdown').empty();
                    $('#teacher_faculty_dropdown').prop('disabled', true)
                    group.prop('disabled', false)
                    speciality.prop('disabled', false)
                }
                else if(roleName == 'secretary' || roleName == 'teacher'){
                    group.val(undefined);
                    $('#group_dropdown').trigger('change');
                    group.prop('disabled', true)
                    speciality.val(undefined);
                    $('#speciality_dropdown').trigger('change');
                    speciality.prop('disabled', true)
                }
                else{
                    $('#teacher_faculty_dropdown').prop('disabled', false)
                    group.prop('disabled', false)
                    speciality.prop('disabled', false)
                }
            }

            )
            $('#group_dropdown').change(function() {
                var selectedGroupSpecialityId = $('#group_dropdown option:selected').data('speciality-id');
                if (selectedGroupSpecialityId === undefined) {
                    $('#speciality_dropdown').empty();
                    $('#speciality_dropdown').append('<option value="">Selecteaza o specialitate</option>');
                    @json($specialities).forEach(function(speciality) {
                        $('#speciality_dropdown').append('<option value="' + speciality.id + '">' + speciality.name + '</option>');
                    });
                    $('#speciality_dropdown').prop('disabled', false)
                    $('#role_dropdown').prop('disabled', false)
                }
                else{
                    @json($roles).forEach(function(role){
                        if(role.name.toLowerCase() == 'student'){
                            $('#role_dropdown').val(role.id);
                            $('#role_dropdown').trigger('change')
                        }
                    })
                    $('#role_dropdown').prop('disabled', true)
                     // Clear and repopulate the specialities dropdown
                    $('#speciality_dropdown').empty();
                    $('#speciality_dropdown').append('<option value="">Selecteaza o specialitate</option>'); // Default option

                    // Loop through the specialities
                    @json($specialities).forEach(function(speciality) {
                        if (speciality.id == selectedGroupSpecialityId) {
                            $('#speciality_dropdown').append('<option value="' + speciality.id + '">' + speciality.name + '</option>');
                        }
                        if(selectedGroupSpecialityId == speciality.id){
                            $('#speciality_dropdown').val(speciality.id)
                            $('#speciality_dropdown').prop('disabled', true)
                        }
                    });
                    
                }
               

                
            });
        });

    </script>
@endsection
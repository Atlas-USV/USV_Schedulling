@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-center">Edit User</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('users.update', $editUser->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ $editUser->name }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ $editUser->email }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Faculty -->
        <div class="mb-4">
            <label for="faculty_id" class="block text-gray-700 font-medium mb-2">Faculty</label>
            <select name="faculty_id" id="faculty_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Faculty</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}" {{ $editUser->teacher_faculty_id == $faculty->id ? 'selected' : '' }}>
                        {{ $faculty->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Group -->
        <div class="mb-4">
            <label for="group_id" class="block text-gray-700 font-medium mb-2">Group</label>
            <select name="group_id" id="group_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Group</option>

                @foreach ($groups as $group)
                        <option value="{{ $group->id }}" data-speciality-id="{{ $group->speciality_id }}" {{ $editUser->groups->contains('id', $group->id) ? 'selected' : '' }}>
                            {{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Role -->
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-medium mb-2">Role</label>
            <select id='role' name='roles[]' multiple="" data-hs-select='{
            "placeholder": "Rol",
            "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-600 rounded overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
            "mode": "tags",
            "wrapperClasses": "relative ps-0.5 pe-9 min-h-[46px] flex items-center flex-wrap text-nowrap w-full border border-gray-600 rounded text-start text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400",
            "tagsItemTemplate": "<div class=\"flex flex-nowrap items-center relative z-10 bg-white border border-gray-200 rounded-md p-1 m-1 dark:bg-neutral-900 dark:border-neutral-700 \"><div class=\"size-6 me-1\" data-icon></div><div class=\"whitespace-nowrap text-gray-800 dark:text-neutral-200 \" data-title></div><div class=\"inline-flex shrink-0 justify-center items-center size-5 ms-2 rounded-md text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm dark:bg-neutral-700/50 dark:hover:bg-neutral-700 dark:text-neutral-400 cursor-pointer\" data-remove><svg class=\"shrink-0 size-3\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M18 6 6 18\"/><path d=\"m6 6 12 12\"/></svg></div></div>",
            "tagsInputId": "hs-tags-input",
            "tagsInputClasses": "py-3 px-2 rounded-md order-1 text-sm outline-none dark:bg-neutral-900 dark:placeholder-neutral-500 dark:text-neutral-400",
            "optionTemplate": "<div class=\"flex items-center\"><div class=\"size-8 me-2\" data-icon></div><div><div class=\"text-sm font-semibold text-gray-800 dark:text-neutral-200 \" data-title></div><div class=\"text-xs text-gray-500 dark:text-neutral-500 \" data-description></div></div><div class=\"ms-auto\"><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-4 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z\"/></svg></span></div></div>",
            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-700 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
            }' class="hidden">

        
            <option value="">Choose</option>
            @foreach($roles as $name => $id)
                <option value="{{ $name }}" {{ $editUser->roles->contains('name', $name) ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        </div>

        @if($editUser->roles->contains('name', 'student'))
        <!-- Sef de grupa -->
        <div class="mb-4">
            <label for="group_leader" class="block text-gray-700 font-medium mb-2">Sef de grupa</label>
            <input type="hidden" name="group_leader" value="0">
            <input type="checkbox" name="group_leader" id="group_leader" class="form-checkbox h-5 w-5 text-blue-600" value="1" {{ $isLeader ? 'checked' : '' }}>
        </div>
        @endif

        <!-- Speciality (if student) -->
        <div class="mb-4">
            <label for="speciality_id" class="block text-gray-700 font-medium mb-2">Speciality</label>
            <select name="speciality_id" id="speciality_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Selecteaza o specialitate</option>
                @foreach($specialities as $speciality)
                    <option value="{{ $speciality->id }}" {{ $editUser->speciality_id == $speciality->id ? 'selected' : '' }}>
                        {{ $speciality->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Submit -->
        <div class="flex justify-end mt-6">
            <a href="{{ route('users.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2 hover:bg-gray-400">Cancel</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    window.userRoles = @json($editUser->roles->pluck('name'));
    document.addEventListener('DOMContentLoaded', function () {
        const facultySelect = document.getElementById('faculty_id');
        const groupSelect = document.getElementById('group_id');
        const roleSelect = window.HSSelect.getInstance('#role');

        function initRoleDropdown(val){
            var group = $('#group_id')
                var speciality = $('#speciality_id')
                var faculty = $('#faculty_id')
                // Get the group name (text inside the option)
                if(val.includes('student')){
                    //$('#faculty_id').empty();
                    $('#faculty_id').prop('disabled', true)
                    group.prop('disabled', false)
                    speciality.prop('disabled', false)
                    faculty.val(undefined)
                }
                else if(val.includes('secretary') || val.includes('teacher')){
                    group.val(undefined);
                    $('#group_id').trigger('change');
                    group.prop('disabled', true)
                    speciality.val(undefined);
                    $('#speciality_id').trigger('change');
                    speciality.prop('disabled', true)
                    faculty.disabled = false
                }
                else{
                    $('#faculty_id').prop('disabled', false)
                    group.prop('disabled', false)
                    speciality.prop('disabled', false)

                }
        }
        initRoleDropdown(roleSelect.value)
        document.body.addEventListener('click', function (event) {
            // Check if the clicked element has the `data-remove` attribute
            if (event.target.closest('[data-remove]')) {
                initRoleDropdown(roleSelect.value)
            }
        });
        $('#speciality_id').change(function(){
                var selectedOption = $(this).find('option:selected');
                if(selectedOption.val() !== ''){
                    $('#group_id').empty();
                    $('#group_id').append('<option value="">Selecteaza o grupa</option>');
                    @json($groups).forEach(function(group) {
                        if(group.speciality_id == selectedOption.val()){
                            $('#group_id').append('<option value="'+group.id+'" data-speciality-id="'+group.speciality_id+'">'+group.name+'</option>');
                        }
                    });
                }else{
                    $('#group_id').empty();
                    $('#group_id').append('<option value="">Selecteaza o grupa</option>');
                    @json($groups).forEach(function(group) {
                            $('#group_id').append('<option value="'+group.id+'" data-speciality-id="'+group.speciality_id+'">'+group.name+'</option>');
                    });
                }
            })
    // Listen for changes on the groups dropdown
            roleSelect.on('change', (val) => {
                initRoleDropdown(val)
            }

            )
            $('#group_id').change(function() {
                var selectedGroupSpecialityId = $('#group_id option:selected').data('speciality-id');
                if (selectedGroupSpecialityId === undefined) {
                    $('#speciality_id').empty();
                    $('#speciality_id').append('<option value="">Selecteaza o specialitate</option>');
                    @json($specialities).forEach(function(speciality) {
                        $('#speciality_id').append('<option value="' + speciality.id + '">' + speciality.name + '</option>');
                    });
                    $('#speciality_id').prop('disabled', false)
                    //$('#role_dropdown').prop('disabled', false)
                }
                else{
                    Object.keys(@json($roles)).forEach(function(roleName){
                        console.log(roleName)
                        if(roleName.toLowerCase() == 'student'){
                            // $('#role_dropdown').val(role.id);
                            // $('#role_dropdown').trigger('change')
                        }
                    })
                    //$('#role_dropdown').prop('disabled', true)
                     // Clear and repopulate the specialities dropdown
                    $('#speciality_id').empty();
                    $('#speciality_id').append('<option value="">Selecteaza o specialitate</option>'); // Default option

                    // Loop through the specialities
                    @json($specialities).forEach(function(speciality) {
                        if (speciality.id == selectedGroupSpecialityId) {
                            $('#speciality_id').append('<option value="' + speciality.id + '">' + speciality.name + '</option>');
                        }
                        if(selectedGroupSpecialityId == speciality.id){
                            $('#speciality_id').val(speciality.id)
                            $('#speciality_id').prop('disabled', true)
                        }
                    });
                    
                }
               
            })
      
        })
</script>
@endpush
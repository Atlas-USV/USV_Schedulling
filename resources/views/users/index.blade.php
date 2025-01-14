@extends('layouts.app')

@section('title', 'User List')

@section('content')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="px-6 py-3">Nume</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Grupă</th>
                <th class="px-6 py-3">Facultate</th>
                <th class ="px-6 py-3">Specialitate</th>
                <th class="px-6 py-3">Roluri</th>
                <th class="px-6 py-3">Opțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        @foreach($user->groups as $group)
                            {{ $group->name }}
                        @endforeach
                    </td>
                    <td class="px-6 py-4">{{ $user->faculty ? $user->faculty->short_name : ($user->speciality ? $user->speciality->faculty->short_name : 'N/A') }}</td>
                    <td class="px-6 py-4">{{ $user->speciality ? $user->speciality->name : 'N/A' }}</td>
                    <td class="px-6 py-4">
                        {{ $user->roles->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Paginare -->
<div class="flex justify-end mt-4">
    {{ $users->links('vendor.pagination.flowbite') }}
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($users as $user)
            console.log('Roles for {{ $user->name }}: ', @json($user->roles->pluck('name')));
        @endforeach
    });
</script>
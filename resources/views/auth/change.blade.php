@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Change Password</h1>
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.update.change') }}">
        @csrf
        <div class="mb-4">
            <label for="current_password" class="block text-sm font-medium text-gray-900">Current Password</label>
            <div class="mt-2">
                <input id="current_password" name="current_password" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                @error('current_password')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-4">
            <label for="new_password" class="block text-sm font-medium text-gray-900">New Password</label>
            <div class="mt-2">
                <input id="new_password" name="new_password" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                @error('new_password')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-4">
            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-900">Confirm New Password</label>
            <div class="mt-2">
                <input id="new_password_confirmation" name="new_password_confirmation" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
            </div>
        </div>
        <div class="mb-0">
            <button type="submit" class="w-full flex justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Change Password
            </button>
        </div>
    </form>
</div>
@endsection

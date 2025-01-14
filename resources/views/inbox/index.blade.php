@extends('layouts.app')

@section('title', 'Mesaje')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Inbox</h1>

    @if($messages->isEmpty())
        <p class="text-gray-600">Nu ai mesaje.</p>
    @else
        <div class="bg-white shadow-md rounded-lg p-4">
            <ul class="divide-y divide-gray-200">
                @foreach($messages as $message)
                <li class="py-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold {{ $message->is_read ? 'text-gray-500' : 'text-gray-900' }}">
                            {{ $message->subject }}
                        </h3>
                        <p class="text-sm text-gray-600">{{ $message->body }}</p>
                        <p class="text-xs text-gray-400">{{ $message->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    @if(!$message->is_read)
                    <form action="{{ route('inbox.read', $message->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg">
                            Marchează ca citit
                        </button>
                    </form>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection

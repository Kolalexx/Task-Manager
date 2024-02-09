@extends('layouts.app')

@section('content')
    <h1 class="mb-5">
        Просмотр задачи: {{ $task->name }}
        @auth
            <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">
                <small class="lowercase">({{ __('views.actions.edit') }})</small>
            </a>
        @endauth
    </h1>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <p><span class="font-black">Имя:</span>{{$task->name}}</p>
    <p><span class="font-black">Статус:</span>{{$task->status->name}}</p>
    <p><span class="font-black">Описание:</span>{{$task->description}}</p>
    </div>

@endsection

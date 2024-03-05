@extends('layouts.app')

@section('content')
    <h1 class="mb-5" style="overflow: scroll;">
        {{ __('views.task.pages.show.title') }}{{ $task->name }}
        @auth
            <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">
                <small class="lowercase">({{ __('views.actions.edit') }})</small>
            </a>
        @endauth
    </h1>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-form-card>
            <p><span class="font-black">Имя:</span>{{$task->name}}</p>
            <p><span class="font-black">Статус:</span>{{$task->status->name}}</p>
            <p><span class="font-black">Описание:</span>{{$task->description}}</p>
            <div class="flex gap-2 mt-2">
                @foreach ($labels as $label)
                    <div class="bg-gray-400 white-color text-white px-3 py-0.5 rounded font-semibold">
                        <small>{{ Str::limit($label->name, 50, '...') }}</small>
                    </div>
                @endforeach
            </div>
        </x-form-card>
    </div>
@endsection

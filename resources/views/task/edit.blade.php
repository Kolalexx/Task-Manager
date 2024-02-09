@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Изменение задачи</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-form-card>
            {{ Form::model($task, ['route' => ['tasks.update', 'task' => $task], 'method' => 'PATCH']) }}
            <div class="">
                <x-text-input-block entity="task" name="name" :items=$statuses required autofocus />
                <x-text-input-block entity="task" name="description" :items=$statuses />
                <x-select-input-block entity="task" name="status_id" :items=$statuses required />
                <x-select-input-block entity="task" name="assigned_to_id" :items=$execs required />
                <x-submit entity="task" type="edit" />
            </div>
            {{ Form::close() }}
        </x-form-card>
    </div>

@endsection

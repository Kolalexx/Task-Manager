@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Создать задачу</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <x-form-card>
        {{ Form::model($task, ['route' => 'tasks.store', 'class' => 'flex flex-col gap-3']) }}
        <x-text-input-block entity="task" name="name" autofocus />
        <x-text-input-block entity="task" name="description" />
        <x-select-input-block entity="task" name="status_id" :items=$statuses />
        <x-select-input-block entity="task" name="assigned_to_id" :items=$execs />
        <x-submit entity="task" type="create" />
        {{ Form::close() }}
    </x-form-card>

@endsection

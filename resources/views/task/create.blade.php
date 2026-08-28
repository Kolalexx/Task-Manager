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
        <form method="POST" action="{{ route('tasks.store') }}" class="flex flex-col gap-3">
            @csrf
            <x-text-input-block entity="task" name="name" :model="$task" autofocus />
            <x-text-input-block entity="task" name="description" :model="$task" />
            <x-select-input-block entity="task" name="status_id" :items="$statuses" :model="$task" />
            <x-select-input-block entity="task" name="assigned_to_id" :items="$execs" :model="$task" />
            <x-select-input-block entity="task" name="labels" :items="$labels" :model="$task" multiple />
            <x-submit entity="task" type="create" />
        </form>
    </x-form-card>

@endsection

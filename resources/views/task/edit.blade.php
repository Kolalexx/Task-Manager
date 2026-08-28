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
            <form method="POST" action="{{ route('tasks.update', $task) }}" class="flex flex-col gap-3">
                @csrf
                @method('PATCH')
                <x-text-input-block entity="task" name="name" :model="$task" required autofocus />
                <x-text-input-block entity="task" name="description" :model="$task" />
                <x-select-input-block entity="task" name="status_id" :items="$statuses" :model="$task" required />
                <x-select-input-block entity="task" name="assigned_to_id" :items="$executors" :model="$task" required />
                <x-select-input-block entity="task" name="labels" :items="$labels" :model="$task" multiple />
                <x-submit entity="task" type="edit" />
            </form>
        </x-form-card>
    </div>

@endsection

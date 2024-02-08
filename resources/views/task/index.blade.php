@extends('layouts.app')

@section('content')
    @if (Session::has('errors'))
	    {{ Session::get('errors') }}
    @endif

    <h1 class="mb-5">Задачи</h1>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between">

                @auth
                    <a href="{{ route('tasks.create') }}">
                        <x-primary-button>
                            Создать задачу
                        </x-primary-button>
                    </a>
                @endauth
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xxl">
                    <table class="w-full">
                        <thead class="border-b-2 border-solid border-black text-left">
                            <tr>
                                <th>ID</th>
                                <th>Статус</th>
                                <th>Имя</th>
                                <th>Автор</th>
                                <th>Исполнитель</th>
                                <th>Дата создания</th>
                                @auth
                                    <th>Действия</th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr class="border-b border-dashed text-left">
                                    <td>{{ $task->id }}</td>
                                    <td>{{ $task->status->name }}</td>
                                    <td>
                                        <a class="text-blue-600 hover:text-blue-900"
                                            href="{{ route('tasks.show', ['task' => $task->id]) }}">
                                            {{ $task->name }}
                                        </a>
                                    </td>
                                    <td>{{ $task->creator->name }}</td>
                                    <td>{{ $task->executor->name }}</td>
                                    <td>{{ $task->formattedDate }}</td>
                                    @auth
                                        <td>
                                            @if (Auth::user()->name === $task->creator->name)
                                                <a data-confirm="Вы уверены?" data-method="delete"
                                                    class="text-red-600 hover:text-red-900"
                                                    href="{{ route('tasks.destroy', $task->id) }}">
                                                    Удалить</a>
                                            @endif

                                            <a
                                                href="{{ route('tasks.edit', ['task' => $task->id]) }}">Изменить</a>
                                        </td>
                                    @endauth

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
@endsection
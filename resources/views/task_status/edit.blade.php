@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Изменение статуса</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="w-50">
        {{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH']) }}
            <div class="flex flex-col">
                <div>
                    {{ Form::label('name', 'Имя') }}
                </div>
                <div class="mt-2">
                    <div class="rounded border-gray-300 w-1/3">
                        {{ Form::text('name') }}<br>
                    </div>
                    <div class="text-rose-600">  </div>
                    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded">
                        {{ Form::submit('Обновить') }}
                    </a>
                </div>
            </div>
        {{ Form::close() }}
    </div>

@endsection

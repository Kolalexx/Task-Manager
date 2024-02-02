@extends('layouts.app')


@section('content')
    @if (Session::has('errors'))
	    {{ Session::get('errors') }}
    @endif

    <h1 class="mb-5">Статусы</h1>

    <div>
        <a href="{{ route('task_statuses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Создать статус            </a>
    </div>

    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
            <tr class="border-b border-dashed text-left">
                <td>{{$status->id}}</td>
                <td>{{$status->name}}</td>
                <td>{{$status->created_at}}</td>
                <td>
                    <a href="{{ route('task_statuses.edit', $status) }}">Изменить</a>
                    <a href="{{route('task_statuses.destroy', $status)}}" data-confirm="Вы уверены?" data-method="delete" rel="nofollow">Удалить</a>
                </td>
            </tr>
            @endforeach
            {{ $statuses->links() }}
        </tbody>
    </table>
@endsection

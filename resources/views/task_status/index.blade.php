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
                <th>{{ __('views.status.fields.id') }}</th>
                <th>{{ __('views.status.fields.name') }}</th>
                <th>{{ __('views.status.fields.created_at') }}</th>
                @auth
                    <th>{{ __('views.actions.column_name') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
            <tr class="border-b border-dashed text-left">
                <td>{{$status->id}}</td>
                <td>{{$status->name}}</td>
                <td>{{$status->created_at}}</td>
                @auth
                    <td>
                        <a data-confirm="Вы уверены?" data-method="delete"
                            class="text-red-600 hover:text-red-900"
                            href="{{ route('task_statuses.destroy', $status->id) }}">
                            {{ __('views.actions.delete') }} </a>
                        <a href="{{ route('task_statuses.edit', ['task_status' => $status->id]) }}">{{ __('views.actions.edit') }}</a>
                    </td>
                @endauth
            </tr>
            @endforeach
            {{ $statuses->links() }}
        </tbody>
    </table>
@endsection

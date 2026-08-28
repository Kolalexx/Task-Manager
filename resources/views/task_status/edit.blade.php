@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('views.status.pages.edit.title') }}</h1>
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
        <form method="POST" action="{{ route('task_statuses.update', $taskStatus) }}">
            @csrf
            @method('PATCH')
            <div class="flex flex-col">
                <div>
                    <label for="name">Имя</label>
                </div>
                <div class="mt-2">
                    <div class="rounded border-gray-300 w-1/3">
                        <input type="text" id="name" name="name" value="{{ old('name', $taskStatus->name) }}"><br>
                    </div>
                    <div class="text-rose-600"></div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded">
                        {{ __('views.status.pages.edit.submit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

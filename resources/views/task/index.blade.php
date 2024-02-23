@extends('layouts.app')

@section('content')
    @if (Session::has('errors'))
	    {{ Session::get('errors') }}
    @endif

    <h1 class="mb-5">{{ __('views.task.pages.index.title') }}</h1>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between">
                @auth
                    <a href="{{ route('tasks.create') }}">
                        <x-primary-button>
                            {{ __('views.task.pages.index.new') }}
                        </x-primary-button>
                    </a>
                @endauth
            </div>
        </div>
    </div>
@endsection

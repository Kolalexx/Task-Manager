@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('views.label.pages.edit.title') }}</h1>
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
        <form method="POST" action="{{ route('labels.update', $label) }}" class="flex flex-col gap-3">
            @csrf
            @method('PATCH')
            <x-text-input-block entity="label" name="name" :model="$label" autofocus />
            <x-text-input-block entity="label" name="description" :model="$label" />
            <x-submit entity="label" type="edit" />
        </form>
    </x-form-card>
@endsection

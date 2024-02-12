@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('views.label.pages.create.title') }}</h1>
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
        {{ Form::model($label, ['route' => 'labels.store', 'class' => 'flex flex-col gap-3']) }}
        <x-text-input-block entity="label" name="name" autofocus />
        <x-text-input-block entity="label" name="description" />
        <x-submit entity="label" type="create" />
        {{ Form::close() }}
    </x-form-card>
@endsection

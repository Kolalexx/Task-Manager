@extends('layouts.app')

@section('content')
<h1 class="mt-5 mb-5">@lang('views.greeting')</h1>
<div>
  <h2>@lang('views.This is a simple task manager on Laravel')</h2>
  <a class="btn btn-primary" href="{{route('tasks.index')}}" role="button">@lang('views.Push me')</a>
</div>
@endsection
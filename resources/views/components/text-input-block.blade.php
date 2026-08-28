@props(['entity', 'name', 'model' => null, 'required' => false, 'autofocus' => false])

<div>
    <small><label for="{{ $name }}">{{ __('views.' . $entity . '.fields.' . $name) }}</label></small>
    <input
        type="text"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $model?->$name) }}"
        @if ($required) required @endif
        @if ($autofocus) autofocus @endif
        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >
    <x-input-error :messages="$errors->get($name)" class="" />
</div>

@props(['entity', 'name', 'items' => [], 'multiple' => false, 'required' => false, 'autofocus' => false, 'model' => null, 'selected' => null])

@php
    $selected = old($name, $selected ?? $model?->$name);
    if ($selected instanceof \Illuminate\Support\Collection) {
        $selected = $selected->modelKeys();
    }
    $selected = $multiple ? (array) $selected : $selected;
@endphp
<div>
    <select
        name="{{ $multiple ? $name . '[]' : $name }}"
        @if ($multiple) multiple @endif
        @if ($required) required @endif
        @if ($autofocus) autofocus @endif
        class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
    >
        <option value="">{{ __('views.' . $entity . '.fields.' . $name) }}</option>
        @foreach ($items as $value => $label)
            <option value="{{ $value }}"
                @if ($multiple ? in_array($value, $selected) : (string) $value === (string) $selected) selected @endif>
                {{ $label }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get($name)" class="" />
</div>

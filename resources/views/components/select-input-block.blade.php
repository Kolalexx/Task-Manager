@php
    $multiple = $multiple ?? false;
    $arrayName = $multiple ? $name . '[]' : $name;
@endphp
<div>
    {{ Form::select($arrayName, $items ?? [], null, [
        'placeholder' => __('views.' . $entity . '.fields.' . $name),
        'multiple' => $multiple ?? false,
        'required' => $required ?? false,
        'autofocus' => $autofocus ?? false,
        'selected' => 'selected',
        'class' => [
            'block',
            'border-gray-300',
            'focus:border-indigo-500',
            'focus:ring-indigo-500',
            'rounded-md',
            'shadow-sm',
            'block',
            'mt-1',
            'w-full',
        ],
    ]) }}
    <x-input-error :messages="$errors->get($name)" class="" />
</div>

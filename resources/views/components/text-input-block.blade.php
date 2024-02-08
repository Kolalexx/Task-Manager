<div>
    <small>{{ Form::label($name, __('views.' . $entity . '.fields.' . $name)) }}</small>
    {{ Form::text($name, null, [
        'required' => $required ?? false,
        'autofocus' => 'autofocus' ?? false,
        'class' => [
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
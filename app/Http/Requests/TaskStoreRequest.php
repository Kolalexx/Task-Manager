<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'unique:tasks'],
            'description' => ['nullable', 'string'],
            'status_id' => ['required', 'integer', 'exists:task_statuses,id'],
            'assigned_to_id' => ['nullable', 'integer', 'exists:users,id'],
            'labels' => ['nullable', 'array'],
            'labels.*' => ['integer', 'exists:labels,id'],
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Задача с таким именем уже существует',
            'status_id.required' => 'Это обязательное поле',
            'status_id.exists' => 'Выбранный статус не существует',
            'assigned_to_id.exists' => 'Выбранный исполнитель не существует',
            'labels.*.exists' => 'Выбранная метка не существует',
        ];
    }
}

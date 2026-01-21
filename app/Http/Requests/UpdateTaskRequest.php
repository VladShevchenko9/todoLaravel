<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'taskDescription' => 'required|string|between:5,1000',
            'taskPriority' => 'required|integer|between:1,5',
            'taskStatus' => 'required|boolean',
        ];
    }
}

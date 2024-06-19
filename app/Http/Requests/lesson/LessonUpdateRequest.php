<?php

namespace App\Http\Requests\lesson;

use Illuminate\Foundation\Http\FormRequest;

class LessonUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'media' => 'file',
            'type_id' => 'Integer|exists:types,id',
            'title' => 'string',
            'description' => 'string',
            'lesson_duration' => 'timezone'

        ];
    }
}

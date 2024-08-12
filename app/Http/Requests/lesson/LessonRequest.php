<?php

namespace App\Http\Requests\lesson;

use Illuminate\Foundation\Http\FormRequest;

class   LessonRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'file' => 'required|file',
            'lesson_duration' => [ 'regex:/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/'], // التحقق من الوقت بصيغة HH:mm


        ];
    }
}

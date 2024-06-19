<?php

namespace App\Http\Requests\enrollment;

use Illuminate\Foundation\Http\FormRequest;

class QuizUpdateRequest extends FormRequest
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
            'quiz_id' => 'required|Integer|exists:quizzes,id',
            'section_id' => 'Integer|exists:sections,id',
            'num_of_question' => 'Integer',
            'mark' => 'Integer',
        ];
    }
}

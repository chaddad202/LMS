<?php

namespace App\Http\Requests\course;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'category_id' => 'required|Integer|exists:categories,id',
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
            'skills.*.point' => 'required|integer',
            'title' => 'required|string',
            'description' => 'required|string',
            'photo' => 'file',
            'price'  => 'required|Integer',

        ];
    }
}

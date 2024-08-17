<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseSkillRequest extends FormRequest
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
            'skills_id'=>'required|exists:skills,id',
            'point' => 'required|integer',
            'status' => 'required|string'
        ];
    }
}

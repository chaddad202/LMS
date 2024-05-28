<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherProfileUpdateRequest extends FormRequest
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
            'user_id' => 'required|unique:teacher_profiles,user_id|Integer|exists:users,id',
            'photo' => 'file',
            'knowledge' => 'string',
            'headline' => 'string',
            'age' => 'Integer',
            'wallet' => 'Integer',

        ];
    }
}

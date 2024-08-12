<?php

namespace App\Http\Requests\Skills;

use Illuminate\Foundation\Http\FormRequest;

class SkillsRequest extends FormRequest
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
            'title' => 'required|unique:skills,title|string',
            'maximunBeginner' => 'required|Integer|max:25|min:0',
            'maximunIntemediate' => 'required|Integer|max:75|min:26',
            'maximunAdvanced' => 'required|Integer|max:100|min:76',

        ];
    }
}

<?php

namespace App\Http\Requests\course;

use Illuminate\Foundation\Http\FormRequest;
use Monolog\Level;

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

            'category'  => 'required|array',
            'category.*.id' => 'exists:categories,id',
            'information'  => 'required|array',
            'information.*.text' => 'required|string',
            'information.*.status' => 'required|in:will_learn,prequisites',
            'skills' => 'required|array',
            'skills.*.id' => 'exists:skills,id',
            'skills.*.point' => 'required|integer',
            'skills.*.status' => 'required|in:will_get,required',
            'title' => 'required|string',
            'level' => 'required|in:beginner,meduim,master',
            'description' => 'required|string',
            'photo' => 'file',
            'price'  => 'Integer',
            'course_duration' => 'timezone'


        ];
    }
}

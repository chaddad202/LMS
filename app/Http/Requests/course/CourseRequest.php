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

            'category_id' => 'exists:categories,id',
            'coupon_id' => 'exists:coupons,id',
            'title' => 'required|string',
            'level' => 'required|in:beginner,intemediate,advanced',
            'description' => 'required|string',
            'photo' => 'required|file',
            'price'  => 'Integer',
            'course_duration' => 'timezone',
            'gain_prequist'  => 'required|array',
            'gain_prequist.*.text' => 'required|string',
            'gain_prequist.*.status' => 'required|in:gain,prequisites',
            'skills' => 'required|array',
            'skills.*.id' => 'exists:skills,id',
            'skills.*.point' => 'required|integer',
            'skills.*.status' => 'required|in:will_get,required',


        ];
    }
}

<?php

namespace App\Http\Requests\course;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
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
            'category_id' => 'Integer|exists:categories,id',
            'coupon_id' => 'Integer|exists:coupons,id',
            'title' => 'string',
            'level' => 'in:beginner,intemediate,advanced',
            'description' => 'string',
            'photo' => 'file',
            'price'  => 'Integer',
            'course_duration' => 'timezone',
            'type'=>'in:draft,publish',

        ];
    }
}

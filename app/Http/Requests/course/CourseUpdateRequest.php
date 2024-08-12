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
            'category_id' => 'sometimes|required|Integer|exists:categories,id',
            'coupon_id' => 'sometimes|required|Integer|exists:coupons,id',
            'title' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'photo' => 'sometimes|required|file',
            'price'  => 'sometimes|required|Integer',

        ];
    }
}

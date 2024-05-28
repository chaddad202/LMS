<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest  extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            // 'role_name' => 'required',

            // 'photo' => 'required|string',
            // 'wallet'=> 'required|integer|min:4',
            // 'role_id' =>'required|integer|exists:roles,id',
            // 'company_id' =>'required|integer|exists:companies,id',

            
        ];
    }
}

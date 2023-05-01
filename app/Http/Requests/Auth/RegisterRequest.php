<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()]
        ];
    }

    public function messages()
    {
        return [
                'name.required' => 'name field is required.',
                'name.string' => 'name field should be string.',
                'name.max' => 'name field should me maximun 255 chars.',
                'email.required' => 'email field is required.',
                'email.string' => 'email field should be string.',
                'email.email' => 'email field should be valid email.',
        ];
    }
}

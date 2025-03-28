<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email harus di isi !',
            'email.string' => 'Email harus berupa karakter valid !',
            'email.email' => 'Email harus valid ! contoh : example@local.com',
            'email.max' => 'Email maksimal 255 karakter !',
            'password.required' => 'Password harus di isi !',
            'password.string' => 'Password harus berupa karakter valid !'
        ];
    }
}

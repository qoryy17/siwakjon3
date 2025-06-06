<?php

namespace App\Http\Requests\Profil;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Password harus harus di isi !',
            'password.min' => 'Password harus mengandung 8 karakter !',
            'password.string' => 'Password harus harus berupa karakter valid !',
            'password.regex' => 'Password harus mengandung huruf kapital, angka dan karakter !',
        ];
    }
}

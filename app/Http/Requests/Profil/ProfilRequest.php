<?php

namespace App\Http\Requests\Profil;

use Illuminate\Foundation\Http\FormRequest;

class ProfilRequest extends FormRequest
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
            'email' => 'required|email|string|max:255',
            'nama' => 'required|string|max:255',
            'foto' => 'file|max:5120|image|mimes:png,jpg'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email harus di isi !',
            'email.string' => 'Email harus berupa karakter valid !',
            'email.email' => 'Email harus valid ! contoh : example@local.com',
            'email.max' => 'Email maksimal 255 karakter !',
            'nama.required' => 'Nama Lengkap harus di isi !',
            'nama.string' => 'Nama Lengkap harus berupa karakter valid !',
            'nama.max' => 'Nama Lengkap maksimal 255 karakter !',
            'foto.file' => 'Foto harus berupa file !',
            'foto.image' => 'Foto harus berupa image ',
            'foto.mimes' => 'Foto harus berupa bertipe png/jpg ',
            'foto.max' => 'Foto maksimal 5MB'
        ];
    }
}

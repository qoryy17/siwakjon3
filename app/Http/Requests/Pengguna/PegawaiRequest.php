<?php

namespace App\Http\Requests\Pengguna;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string',
            'aktif' => 'required|string',
            'foto' => 'file|max:5120|image|mimes:png,jpg'
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama Lengkap harus di isi !',
            'nama.string' => 'Nama Lengkap harus berupa karakter valid !',
            'nama.max' => 'Nama Lengkap maksimal 255 karakter !',
            'jabatan.required' => 'Jabatan harus di isi !',
            'jabatan.string' => 'Jabatan harus berupa karakter valid !',
            'aktif.required' => 'Status Aktif harus di isi !',
            'aktif.string' => 'Status Aktif harus berupa karakter valid !',
            'foto.file' => 'Foto harus berupa file !',
            'foto.image' => 'Foto harus berupa image ',
            'foto.mimes' => 'Foto harus berupa bertipe png/jpg ',
            'foto.max' => 'Foto maksimal 5MB'
        ];
    }
}

<?php

namespace App\Http\Requests\Pengguna;

use Illuminate\Foundation\Http\FormRequest;

class AkunRequest extends FormRequest
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

            'pegawai' => 'required|string',
            'unitKerja' => 'required|string',
            'active' => 'required|string',
            'role' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'pegawai.required' => 'Pegawai harus di isi !',
            'pegawai.string' => 'Pegawai harus berupa karakter valid !',
            'unitKerja.required' => 'Unit Kerja harus di isi !',
            'unitKerja.string' => 'Unit Kerja harus berupa karakter valid !',
            'active.required' => 'Status Aktif harus di isi !',
            'active.string' => 'Status Aktif harus berupa karakter valid !',
            'role.required' => 'Role harus di isi !',
            'role.string' => 'Role harus berupa karakter valid !',
            'role.max' => 'Role maksimal 255 karakter !',
        ];
    }
}

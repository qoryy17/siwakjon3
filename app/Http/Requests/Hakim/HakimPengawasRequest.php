<?php

namespace App\Http\Requests\Hakim;

use Illuminate\Foundation\Http\FormRequest;

class HakimPengawasRequest extends FormRequest
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
            'pegawai' => 'required|string|max:255',
            'unitKerja' => 'required|string|max:255',
            'aktif' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'pegawai.required' => 'Pegawai harus di isi !',
            'pegawai.string' => 'Pegawai harus berupa karakter valid !',
            'pegawai.max' => 'Pegawai maksimal 255 karakter !',
            'unitKerja.required' => 'Unit Kerja harus di isi !',
            'unitKerja.string' => 'Unit Kerja harus berupa karakter valid !',
            'unitKerja.max' => 'Unit Kerja maksimal 255 karakter !',
            'aktif.required' => 'Status Aktif harus di isi !',
            'aktif.string' => 'Status Aktif harus berupa karakter valid !',
        ];
    }
}

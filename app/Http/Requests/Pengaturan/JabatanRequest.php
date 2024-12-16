<?php

namespace App\Http\Requests\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class JabatanRequest extends FormRequest
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
            'jabatan' => 'required|string|max:255',
            'kodeJabatan' => 'required|string|max:255',
            'aktif' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'jabatan.required' => 'Jabatan harus di isi !',
            'jabatan.string' => 'Jabatan harus berupa karakter valid !',
            'jabatan.max' => 'Jabatan maksimal 255 karakter !',
            'kodeJabatan.required' => 'Kode Jabatan harus di isi !',
            'kodeJabatan.string' => 'Kode Jabatan harus berupa karakter valid !',
            'kodeJabatan.max' => 'Kode Jabatan maksimal 255 karakter !',
            'aktif.required' => 'Status Aktif harus di isi !',
            'aktif.string' => 'Status Aktif harus berupa karakter valid !',
        ];
    }
}

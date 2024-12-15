<?php

namespace App\Http\Requests\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class CatatanPengembangRequest extends FormRequest
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
            'catatan' => 'required|string',
            'aktif' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'catatan.required' => 'Catatan harus di isi !',
            'catatan.string' => 'Catatan harus berupa karakter valid !',
            'aktif.required' => 'Status Aktif harus di pilih !',
            'aktif.string' => 'Status Aktif harus berupa karakter valid !',
        ];
    }
}

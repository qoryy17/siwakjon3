<?php

namespace App\Http\Requests\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class UnitKerjaRequest extends FormRequest
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
            'unitKerja' => 'required|string|max:300',
            'aktif' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'unitKerja.required' => 'Jabatan harus di isi !',
            'unitKerja.string' => 'Jabatan harus berupa karakter valid !',
            'unitKerja.max' => 'Jabatan maksimal 300 karakter !',
            'aktif.required' => 'Status Aktif harus di isi !',
            'aktif.string' => 'Status Aktif harus berupa karakter valid !',
        ];
    }
}

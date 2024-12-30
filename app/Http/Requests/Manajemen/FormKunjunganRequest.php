<?php

namespace App\Http\Requests\Manajemen;

use Illuminate\Foundation\Http\FormRequest;

class FormKunjunganRequest extends FormRequest
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
            'kodeKunjungan' => 'required|string|uuid',
            'unitKerja' => 'required|string|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'kodeKunjungan.required' => 'Kode Kunjungan harus di isi !',
            'kodeKunjungan.string' => 'Kode Kunjungan harus berupa karakter valid !',
            'kodeKunjungan.uuid' => 'Kode Kunjungan harus berupa UUID !',
            'unitKerja.required' => 'Unit Pengawasan harus di isi !',
            'unitKerja.string' => 'Unit Pengawasan harus berupa karakter valid !',
            'unitKerja.integer' => 'Unit Pengawasan harus berupa karakter angka !',
        ];
    }
}

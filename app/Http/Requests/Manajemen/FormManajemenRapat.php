<?php

namespace App\Http\Requests\Manajemen;

use Illuminate\Foundation\Http\FormRequest;

class FormManajemenRapat extends FormRequest
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
            'nomorDokumen' => 'required|string|max:255',
            'klasifikasiRapat' => 'required|string',
            'pejabatPenandatangan' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nomorDokumen.required' => 'Nomor Dokumen harus di isi !',
            'nomorDokumen.string' => 'Nomor Dokumen harus berupa karakter valid !',
            'nomorDokumen.max' => 'Nomor Dokumen maksimal 255 karakter !',
            'klasifikasiRapat.required' => 'Klasifikasi Rapat harus di isi !',
            'klasifikasiRapat.string' => 'Klasifikasi Rapat harus berupa karakter valid !',
            'pejabatPenandatangan.required' => 'Penandatangan harus wajib di pilih !',
            'pejabatPenandatangan.string' => 'Penandatangan harus berupa karakter valid !',
        ];
    }
}

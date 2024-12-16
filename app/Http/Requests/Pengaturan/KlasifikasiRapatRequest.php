<?php

namespace App\Http\Requests\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class KlasifikasiRapatRequest extends FormRequest
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
            'rapat' => 'required|string|max:255',
            'kodeKlasifikasi' => 'required|string|max:255',
            'aktif' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'rapat.required' => 'Rapat harus di isi !',
            'rapat.string' => 'Rapat harus berupa karakter valid !',
            'rapat.max' => 'Rapat maksimal 255 karakter !',
            'kodeKlasifikasi.required' => 'Kode Klasifikasi harus di isi !',
            'kodeKlasifikasi.string' => 'Kode Klasifikasi harus berupa karakter valid !',
            'kodeKlasifikasi.max' => 'Kode Klasifikasi maksimal 255 karakter !',
            'aktif.required' => 'Status Aktif harus di isi !',
            'aktif.string' => 'Status Aktif harus berupa karakter valid !',
        ];
    }
}

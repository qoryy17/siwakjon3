<?php

namespace App\Http\Requests\Monev;

use Illuminate\Foundation\Http\FormRequest;

class AgendaMonevRequest extends FormRequest
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
            'nomorAgenda' => 'required|string',
            'unitKerja' => 'required|string|max:255',
            'aktif' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'nomorAgenda.required' => 'Nomor Agenda harus di isi !',
            'nomorAgenda.string' => 'Nomor Agenda harus berupa karakter valid !',
            'unitKerja.required' => 'Unit Kerja harus di isi !',
            'unitKerja.string' => 'Unit Kerja harus berupa karakter valid !',
            'unitKerja.max' => 'Unit Kerja maksimal 255 karakter !',
            'aktif.required' => 'Status Aktif harus di isi !',
            'aktif.string' => 'Status Aktif harus berupa karakter valid !',
        ];
    }
}

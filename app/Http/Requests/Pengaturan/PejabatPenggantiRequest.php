<?php

namespace App\Http\Requests\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class PejabatPenggantiRequest extends FormRequest
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
            'pejabatPengganti' => 'required|string|max:255',
            'aktif' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'pejabatPengganti.required' => 'Pejabat Pengganti harus di isi !',
            'pejabatPengganti.string' => 'Pejabat Pengganti harus berupa karakter valid !',
            'pejabatPengganti.max' => 'Pejabat Pengganti maksimal 255 karakter !',
            'aktif.required' => 'Status Aktif harus di isi !',
            'aktif.string' => 'Status Aktif harus berupa karakter valid !',
        ];
    }
}

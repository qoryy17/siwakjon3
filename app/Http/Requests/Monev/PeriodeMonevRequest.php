<?php

namespace App\Http\Requests\Monev;

use Illuminate\Foundation\Http\FormRequest;

class PeriodeMonevRequest extends FormRequest
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
            'periode' => 'required|string',
            'aktif' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'periode.required' => 'Periode harus di isi !',
            'periode.string' => 'Periode harus berupa karakter valid !',
            'periode.max' => 'Periode maksimal 255 karakter !',
            'aktif.required' => 'Status Aktif harus di isi !',
            'aktif.string' => 'Status Aktif harus berupa karakter valid !',
        ];
    }
}

<?php

namespace App\Http\Requests\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class KodeRapatRequest extends FormRequest
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
            'rapatDinas' => 'required|string|max:255',
            'rapatPengawasan' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'rapatDinas.required' => 'Kode Rapat Dinas harus di pilih !',
            'rapatDinas.string' => 'Kode Rapat Dinas harus berupa karakter valid !',
            'rapatDinas.max' => 'Kode Rapat Dinas maksimal 255 karakter !',
            'rapatPengawasan.required' => 'Kode Rapat Pengawasan harus di pilih !',
            'rapatPengawasan.string' => 'Kode Rapat Pengawasan harus berupa karakter valid !',
            'rapatPengawasan.max' => 'Kode Rapat Pengawasan maksimal 255 karakter !',
        ];
    }
}

<?php

namespace App\Http\Requests\Manajemen;

use Illuminate\Foundation\Http\FormRequest;

class SetRapatRequest extends FormRequest
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
            'rapat' => 'required|string',
            'klasifikasi' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'rapat.required' => 'Rapat harus di isi !',
            'rapat.string' => 'Rapat harus berupa karakter valid !',
            'klasifikasi.required' => 'Klasifikasi rapat harus di isi !',
            'klasifikasi.string' => 'Klasifikasi rapat harus berupa karakter valid !',
        ];
    }
}

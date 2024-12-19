<?php

namespace App\Http\Requests\Monev;

use Illuminate\Foundation\Http\FormRequest;

class MonevRequest extends FormRequest
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
            'judulMonev' => 'required|string',
            'tanggalMonev' => 'required|string',
            'periode' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nomorAgenda.required' => 'Nomor Agenda harus di isi !',
            'nomorAgenda.string' => 'Nomor Agenda harus berupa karakter valid !',
            'judulMonev.required' => 'Judul Monev harus di isi !',
            'judulMonev.string' => 'Judul Monev harus berupa karakter valid !',
            'tanggalMonev.required' => 'Tanggal Monev harus di isi !',
            'tanggalMonev.string' => 'Tanggal Monev harus berupa karakter valid !',
            'periode.required' => 'Periode Monev harus di isi !',
            'periode.string' => 'Periode Monev harus berupa karakter valid !'
        ];
    }
}

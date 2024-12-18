<?php

namespace App\Http\Requests\Arsip;

use Illuminate\Foundation\Http\FormRequest;

class SuratKeputusanRequest extends FormRequest
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
            'nomor' => 'required|string',
            'judul' => 'required|string',
            'tanggalTerbit' => 'required|string',
            'status' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nomor.required' => 'Nomor harus di isi !',
            'nomor.string' => 'Nomor harus berupa karakter valid !',
            'judul.required' => 'Judul harus di isi !',
            'judul.string' => 'Judul harus berupa karakter valid !',
            'tanggalTerbit.required' => 'Tanggal Terbit harus di isi !',
            'tanggalTerbit.string' => 'Tanggal Terbit harus berupa karakter valid !',
            'status.required' => 'Status harus di pilih !',
            'status.string' => 'Status harus berupa karakter valid !',
        ];
    }
}

<?php

namespace App\Http\Requests\Manajemen;

use Illuminate\Foundation\Http\FormRequest;

class TemuanWasbidRequest extends FormRequest
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
            'judul' => 'required|string',
            'kondisi' => 'required|string',
            'kriteria' => 'required|string',
            'sebab' => 'required|string',
            'akibat' => 'required|string',
            'rekomendasi' => 'required|string',
            'waktuPenyelesaian' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul harus di isi !',
            'judul.string' => 'Judul harus berupa karakter valid !',
            'kondisi.required' => 'Kondisi harus di isi !',
            'kondisi.string' => 'Kondisi harus berupa karakter valid !',
            'kriteria.required' => 'Kriteria harus di isi !',
            'kriteria.string' => 'Kriteria harus berupa karakter valid !',
            'sebab.required' => 'Sebab harus di isi !',
            'sebab.string' => 'Sebab harus berupa karakter valid !',
            'akibat.required' => 'Akibat harus di isi !',
            'akibat.string' => 'Akibat harus berupa karakter valid !',
            'rekomendasi.required' => 'Rekomendasi harus di isi !',
            'rekomendasi.string' => 'Rekomendasi harus berupa karakter valid !',
            'waktuPenyelesaian.required' => 'Waktu Penyelesaian harus di isi !',
            'waktuPenyelesaian.string' => 'Waktu Penyelesaian harus berupa karakter valid !',
            'waktuPenyelesaian.max' => 'Waktu Penyelesaian maksimal 255 karakter !',

        ];
    }
}

<?php

namespace App\Http\Requests\Manajemen;

use Illuminate\Foundation\Http\FormRequest;

class FormDetailKunjunganRequest extends FormRequest
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
            'tanggal' => 'required|string',
            'waktu' => 'required|string|max:255',
            'agenda' => 'required|string|max:255',
            'pembahasan' => 'required|string',
            'hakim' => 'required|string|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal Kunjungan harus di pilih !',
            'tanggal.string' => 'Tanggal Kunjungan harus berupa karakter valid !',
            'waktu.required' => 'Waktu Kunjungan harus di isi !',
            'waktu.string' => 'Waktu Kunjungan harus berupa karakter valid !',
            'waktu.max' => 'Waktu Kunjungan maksimal 255 karakter !',
            'agenda.required' => 'Agenda harus di isi !',
            'agenda.string' => 'Agenda harus berupa karakter valid !',
            'agenda.max' => 'Agenda maksimal 255 karakter !',
            'pembahasan.required' => 'Pembahasan harus di isi !',
            'pembahasan.string' => 'Pembahasan harus berupa karakter valid !',
            'hakim.required' => 'Hakim Pengawas harus di isi !',
            'hakim.string' => 'Hakim Pengawas harus berupa karakter valid !',
            'hakim.integer' => 'Hakim Pengawas harus berupa karakter angka !'
        ];
    }
}

<?php

namespace App\Http\Requests\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class AplikasiRequest extends FormRequest
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
            'lembaga' => 'required|string|max:255',
            'badanPeradilan' => 'required|string|max:255',
            'wilayahHukum' => 'required|string|max:255',
            'kodeSatker' => 'required|string|max:255',
            'satuanKerja' => 'required|string|max:255',
            'alamat' => 'required|string',
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kodePos' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'website' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'lembaga.required' => 'Lembaga harus di isi !',
            'lembaga.string' => 'Lembaga harus berupa karakter valid !',
            'lembaga.max' => 'Lembaga maksimal 255 karakter !',
            'badanPeradilan.required' => 'Badan Peradilan harus di isi !',
            'badanPeradilan.string' => 'Badan Peradilan harus berupa karakter valid !',
            'badanPeradilan.max' => 'Badan Peradilan maksimal 255 karakter',
            'wilayahHukum.required' => 'Wilayah Hukum harus di isi !',
            'wilayahHukum.string' => 'Wilayah Hukum harus berupa karakter valid !',
            'wilayahHukum.max' => 'Wilayah Hukum maksimal 255 karakter !',
            'kodeSatker.required' => 'Kode Satker harus di isi !',
            'kodeSatker.string' => 'Kode Satker harus berupa karakter valid !',
            'kodeSatker.max' => 'Kode Satker maksimal 255 karakter !',
            'satuanKerja.required' => 'Satuan Kerja harus di isi !',
            'satuanKerja.string' => 'Satuan kerja harus berupa karakter valid !',
            'satuanKerja.max' => 'Satuan kerja maksimal 255 karakater !',
            'alamat.required' => 'Alamat harus di isi !',
            'alamat.string' => 'Alamat harus berupa karakter valid !',
            'provinsi.required' => 'Provinsi harus di isi !',
            'provinsi.string' => 'Provinsi harus berupa karakter valid !',
            'provinsi.max' => 'Provinsi maksimal 255 karakter !',
            'kota.required' => 'Kota/Kabupaten harus di isi !',
            'kota.string' => 'Kota/Kabupaten harus berupa karakter valid !',
            'kota.max' => 'Kota/Kabupaten maksimal 255 karakter !',
            'kodePos.required' => 'Kode Pos harus di isi !',
            'kodePos.string' => 'Kode Pos harus berupa karakter valid !',
            'kodePos.max' => 'Kode Pos maksimal 255 karakter !',
            'telepon.required' => 'Telepon harus di isi !',
            'telepon.string' => 'Telepon harus berupa karakter valid !',
            'telepon.max' => 'Telepon maksimal 255 karakter !',
            'email.required' => 'Email harus di isi !',
            'email.string' => 'Email harus berupa karakter valid !',
            'email.max' => 'Email maksimal 255 karakter !',
            'email.email' => 'Email harus valid ! contoh : example@local.com',
        ];
    }
}

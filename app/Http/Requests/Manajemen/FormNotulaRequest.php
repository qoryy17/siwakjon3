<?php

namespace App\Http\Requests\Manajemen;

use Illuminate\Foundation\Http\FormRequest;

class FormNotulaRequest extends FormRequest
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
            'jamSelesai' => 'required|string|max:255',
            'pembahasan' => 'required|string|max:255',
            'pimpinanRapat' => 'required|string|max:255',
            'moderator' => 'required|string|max:255',
            'notulen' => 'required|string|integer',
            'catatan' => 'required|string',
            'kesimpulan' => 'required|string',
            'disahkan' => 'required|string|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'jamSelesai.required' => 'Jam selesai harus di isi !',
            'jamSelesai.string' => 'Jam selesai harus berupa karakter valid !',
            'jamSelesai.max' => 'Jam selesai maksimal 255 karakter !',
            'pembahasan.required' => 'Pembahasan harus di isi !',
            'pembahasan.string' => 'Pembahasan harus berupa karakter valid !',
            'pembahasan.max' => 'Pembahasan maksimal 255 karakter !',
            'pimpinanRapat.required' => 'Pimpinan rapat harus di isi !',
            'pimpinanRapat.string' => 'Pimpinan rapat harus berupa karakter valid !',
            'pimpinanRapat.max' => 'Pimpinan rapat maksimal 255 karakter !',
            'moderator.required' => 'Moderator harus di isi !',
            'moderator.string' => 'Moderator harus berupa karakter valid !',
            'moderator.max' => 'Moderator maksimal 255 karakter !',
            'notulen.required' => 'Notulen harus di isi !',
            'notulen.string' => 'Notulen harus berupa karakter valid !',
            'notulen.integer' => 'Notulen harus berupa angka !',
            'catatan.required' => 'Catatan harus di isi !',
            'catatan.string' => 'Catatan harus berupa karakter valid !',
            'kesimpulan.required' => 'Kesimpulan harus di isi !',
            'kesimpulan.string' => 'Kesimpulan harus berupa karakter valid !',
            'disahkan.required' => 'Disahkan harus di isi !',
            'disahkan.string' => 'Disahkan harus berupa karakter valid !',
            'disahkan.integer' => 'Disahkan harus berupa angka !',
        ];
    }
}

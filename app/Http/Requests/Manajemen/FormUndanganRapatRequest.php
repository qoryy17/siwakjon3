<?php

namespace App\Http\Requests\Manajemen;

use Illuminate\Foundation\Http\FormRequest;

class FormUndanganRapatRequest extends FormRequest
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
            'tanggalRapat' => 'required|string',
            'sifat' => 'required|string|max:255',
            'lampiran' => 'required|string|max:255',
            'perihal' => 'required|string',
            'acara' => 'required|string',
            'agenda' => 'required|string',
            'jamRapat' => 'required|string|max:255',
            'tempat' => 'required|string',
            'peserta' => 'required|string',
            'keterangan' => 'required|string',
            'jamSelesai' => 'string|max:255',
            'pembahasan' => 'string|max:255',
            'pimpinanRapat' => 'string|max:255',
            'moderator' => 'string|max:255',
            'notulen' => 'string|integer',
            'catatan' => 'string',
            'kesimpulan' => 'string',
            'disahkan' => 'string|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'tanggalRapat.required' => 'Tanggal Rapat harus di isi !',
            'tanggalRapat.string' => 'Tanggal Rapat harus berupa karakter valid !',
            'sifat.required' => 'Sifat harus di isi !',
            'sifat.string' => 'Sifat harus berupa karakter valid ! !',
            'sifat.max' => 'Sifat maksimal 255 karakter !',
            'lampiran.required' => 'Lampiran harus di isi !, jika tidak ada silahkan isi dengan karakter "-"',
            'lampiran.string' => 'lampiran harus berupa karakter valid !',
            'lampiran.max' => 'Lampiran maksimal 255 karakter !',
            'perihal.required' => 'Perihal harus di isi !',
            'perihal.string' => 'Perihal harus berupa karakter valid !',
            'acara.required' => 'Acara harus di isi !',
            'acara.string' => 'Acara harus berupa karakter valid !',
            'agenda.required' => 'Agenda harus di isi !',
            'agenda.string' => 'Agenda harus berupa karakter valid !',
            'jamRapat.required' => 'Jam rapat harus di isi !',
            'jamRapat.string' => 'Jam rapat harus berupa karakter valid !',
            'jamRapat.max' => 'Jam rapat maksimal 255 karakter !',
            'tempat.required' => 'Tempat harus di isi !',
            'tempat.string' => 'Tempat harus berupa karakter valid !',
            'peserta.required' => 'Peserta harus di isi !',
            'peserta.string' => 'Peserta harus berupa karakter valid !',
            'keterangan.required' => 'Keterangan harus di isi !',
            'keterangan.string' => 'Keterangan harus berupa karakter valid !',
            'jamSelesai.string' => 'Jam selesai harus berupa karakter valid !',
            'jamSelesai.max' => 'Jam selesai maksimal 255 karakter !',
            'pembahasan.string' => 'Pembahasan harus berupa karakter valid !',
            'pembahasan.max' => 'Pembahasan maksimal 255 karakter !',
            'pimpinanRapat.string' => 'Pimpinan Rapat harus berupa karakter valid !',
            'pimpinanRapat.max' => 'Pimpinan Rapat maksimal 255 karakter !',
            'moderator.string' => 'Moderator harus berupa karakter valid !',
            'moderator.max' => 'Moderator harus maksimal 255 karakter !',
            'notulen.string' => 'Notulen harus berupa karakter valid !',
            'notulen' => 'Notulen harus berupa angka !',
            'catatan.string' => 'Catatan harus berupa karakter valid !',
            'kesimpulan.string' => 'Kesimpulan harus berupa karakter valid !',
            'disahkan.string' => 'Pengesah Dokumen harus berupa karakter valid !',
            'disahkan.integer' => 'Pengesah Dokumen harus berupa angka !',
        ];
    }
}

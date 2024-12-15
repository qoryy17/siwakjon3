<?php

namespace App\Http\Requests\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class VersionRequest extends FormRequest
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
            'releaseDate' => 'required|string',
            'category' => 'required|string|max:255',
            'patchVersion' => 'required|string|max:255',
            'note' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'releaseDate.required' => 'Release Date harus di pilih !',
            'releaseDate.string' => 'Release Date harus berupa karakter valid !',
            'category.required' => 'Category harus di pilih !',
            'category.string' => 'Category harus berupa karakter valid !',
            'category.max' => 'Category maksimal 255 karakter',
            'note.string' => 'Note harus berupa karakter valid !',
            'note.max' => 'Note maksimal 255 karakter',
        ];
    }
}

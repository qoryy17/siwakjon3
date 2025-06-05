<?php

namespace App\Http\Requests\Pengaturan;

use Illuminate\Foundation\Http\FormRequest;

class AIModelRequest extends FormRequest
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
            'aiModel' => 'required|string|max:255',
            'promptCatatanRapat' => 'required|string',
            'promptKesimpulanRapat' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'aiModel.required' => 'AI Model harus diisi.',
            'aiModel.string' => 'AI Model harus berupa string.',
            'aiModel.max' => 'AI Model tidak boleh lebih dari 255 karakter.',
            'promptCatatanRapat.required' => 'Prompt catatan rapat harus diisi.',
            'promptCatatanRapat.string' => 'Prompt catatan rapat harus berupa string.',
            'promptKesimpulanRapat.required' => 'Prompt kesimpulan rapat harus diisi.',
            'promptKesimpulanRapat.string' => 'Prompt kesimpulan rapat harus berupa string.',
        ];
    }
}

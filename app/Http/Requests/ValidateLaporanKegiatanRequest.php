<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateLaporanKegiatanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->profile;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'deskripsi_kegiatan' => ['required', 'string', 'min:10'],
            'hasil' => ['required', 'string', 'min:10'],
            'waktu' => ['required', 'string', 'min:11'],
            'dokumentasi' => ['nullable', 'max:2048'],
        ];
    }
}

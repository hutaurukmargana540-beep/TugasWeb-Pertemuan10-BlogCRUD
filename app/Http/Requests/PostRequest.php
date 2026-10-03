<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * REQ 5: validasi dipisah dari controller (Form Request) supaya controller tipis.
 * Dipakai untuk store (POST) dan update (PUT) — aturannya sama.
 */
class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // TR 10 belum memakai autentikasi (baru di TR 11)
    }

    public function rules(): array
    {
        return [
            'title'   => ['required', 'string', 'min:3', 'max:150'],
            'content' => ['required', 'string', 'min:10'],
            'image'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => 'Judul wajib diisi.',
            'title.min'        => 'Judul minimal :min karakter.',
            'title.max'        => 'Judul maksimal :max karakter.',
            'content.required' => 'Isi post wajib diisi.',
            'content.min'      => 'Isi post minimal :min karakter.',
            'image.image'      => 'File harus berupa gambar.',
            'image.mimes'      => 'Gambar harus berformat jpg, jpeg, png, atau webp.',
            'image.max'        => 'Ukuran gambar maksimal 2 MB.',
        ];
    }
}

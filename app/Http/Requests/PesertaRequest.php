<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PesertaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_nasabah' => ['required', 'integer', 'exists:nasabah,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_nasabah.required' => 'Nasabah wajib dipilih.',
            'id_nasabah.exists'   => 'Nasabah tidak ditemukan.',
        ];
    }
}

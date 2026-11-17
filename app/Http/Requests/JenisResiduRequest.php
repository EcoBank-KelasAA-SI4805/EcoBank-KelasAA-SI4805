<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JenisResiduRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('jenis_residu');
        return [
            'nama'             => ['required', 'string', 'max:255', Rule::unique('jenis_residu', 'nama')->ignore($id)],
            'alasan'           => ['required', 'string'],
            'cara_penanganan'  => ['required', Rule::in(['TPA', 'insinerasi', 'lainnya'])],
            'biaya_per_kg'     => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'            => 'Nama jenis residu wajib diisi.',
            'nama.unique'              => 'Nama jenis residu sudah ada.',
            'alasan.required'          => 'Alasan wajib diisi.',
            'cara_penanganan.required' => 'Cara penanganan wajib dipilih.',
            'cara_penanganan.in'       => 'Cara penanganan tidak valid.',
            'biaya_per_kg.required'    => 'Biaya per kg wajib diisi.',
            'biaya_per_kg.numeric'     => 'Biaya per kg harus berupa angka.',
            'biaya_per_kg.min'         => 'Biaya per kg tidak boleh negatif.',
        ];
    }
}

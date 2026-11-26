<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResiduRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal'        => ['required', 'date'],
            'id_jenis_residu'=> ['required', 'exists:jenis_residu,id'],
            'berat_kg'       => ['required', 'numeric', 'min:0.01'],
            'asal'           => ['required', 'string', 'max:255'],
            'status'         => ['sometimes', Rule::in(['ditampung', 'diangkut', 'dibuang'])],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.required'         => 'Tanggal wajib diisi.',
            'tanggal.date'             => 'Format tanggal tidak valid.',
            'id_jenis_residu.required' => 'Jenis residu wajib dipilih.',
            'id_jenis_residu.exists'   => 'Jenis residu tidak ditemukan.',
            'berat_kg.required'        => 'Berat (kg) wajib diisi.',
            'berat_kg.numeric'         => 'Berat harus berupa angka.',
            'berat_kg.min'             => 'Berat harus lebih dari 0.',
            'asal.required'            => 'Asal wajib diisi.',
            'status.in'                => 'Status tidak valid.',
        ];
    }
}

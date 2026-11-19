@extends('layouts.admin')
@section('title', 'Ajukan Penarikan Saldo')
@section('breadcrumb', 'Penarikan Saldo / Ajukan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gracia_p11_p12.css') }}">
@endpush

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-16 • PENARIKAN SALDO</div>
        <h1>Ajukan Penarikan Saldo</h1>
        <p>Buat pengajuan penarikan saldo tabungan nasabah.</p>
    </div>
    <a class="btn btn-outline" href="{{ route('admin.penarikan-saldo.index') }}">← Kembali</a>
</div>

<div class="panel" style="padding:22px;max-width:850px">
    <form method="POST" action="{{ route('admin.penarikan-saldo.store') }}">
        @csrf

        <div class="form-grid">
            <label class="form-field full">
                Nasabah <span style="color:#dc2626">*</span>
                <select name="nasabah_id" required>
                    <option value="">-- Pilih Nasabah --</option>
                    @foreach($nasabahList as $nasabah)
                        <option value="{{ $nasabah->id }}"
                            data-saldo="{{ $nasabah->saldo }}"
                            {{ old('nasabah_id') == $nasabah->id ? 'selected' : '' }}>
                            {{ $nasabah->nama }} (NIK: {{ $nasabah->nik }}) – Saldo: Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('nasabah_id')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                Metode Penarikan <span style="color:#dc2626">*</span>
                <select name="metode_penarikan_id" required>
                    <option value="">-- Pilih Metode --</option>
                    @foreach($metodeList as $metode)
                        <option value="{{ $metode->id }}"
                            data-minimal="{{ $metode->minimal_tarik }}"
                            {{ old('metode_penarikan_id') == $metode->id ? 'selected' : '' }}>
                            {{ $metode->nama_metode }} (Min: Rp {{ number_format($metode->minimal_tarik, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                @error('metode_penarikan_id')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                Jumlah Penarikan (Rp) <span style="color:#dc2626">*</span>
                <input type="number" name="jumlah" value="{{ old('jumlah') }}"
                       required min="1" step="1000"
                       placeholder="Contoh: 50000">
                @error('jumlah')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                Catatan (opsional)
                <textarea name="catatan" maxlength="500"
                          placeholder="Catatan tambahan untuk pengajuan...">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="modal-actions">
            <a class="btn btn-outline" href="{{ route('admin.penarikan-saldo.index') }}">Batal</a>
            <button class="btn btn-primary" type="submit">Ajukan Penarikan</button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Ubah Status Penarikan')
@section('breadcrumb', 'Penarikan Saldo / Ubah Status')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gracia_p11_p12.css') }}">
@endpush

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-16 • UBAH STATUS</div>
        <h1>Ubah Status Penarikan #{{ $penarikanSaldo->id }}</h1>
        <p>Perbarui status pengajuan penarikan nasabah.</p>
    </div>
    <a class="btn btn-outline" href="{{ route('admin.penarikan-saldo.show', $penarikanSaldo) }}">← Detail</a>
</div>

<div class="panel" style="padding:22px;max-width:650px">
    {{-- Info ringkas --}}
    <div class="detail-grid" style="margin-bottom:0;padding-bottom:0;">
        <div class="detail-item">
            <small>NASABAH</small>
            <strong>{{ $penarikanSaldo->nasabah->nama }}</strong>
        </div>
        <div class="detail-item">
            <small>JUMLAH</small>
            <strong>Rp {{ number_format($penarikanSaldo->jumlah, 0, ',', '.') }}</strong>
        </div>
        <div class="detail-item">
            <small>METODE</small>
            <strong>{{ $penarikanSaldo->metodePenarikan->nama_metode }}</strong>
        </div>
        <div class="detail-item">
            <small>STATUS SAAT INI</small>
            <span class="status {{ $penarikanSaldo->statusClass() }}" style="margin-top:4px;display:inline-flex;">
                {{ $penarikanSaldo->statusLabel() }}
            </span>
        </div>
    </div>

    <hr style="border:none;border-top:1px solid #e9eeeb;margin:18px 0;">

    <form method="POST" action="{{ route('admin.penarikan-saldo.update', $penarikanSaldo) }}">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <label class="form-field full">
                Status Baru <span style="color:#dc2626">*</span>
                <select name="status" required>
                    <option value="diajukan"  {{ old('status', $penarikanSaldo->status) === 'diajukan'  ? 'selected' : '' }}>Diajukan</option>
                    <option value="disetujui" {{ old('status', $penarikanSaldo->status) === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak"   {{ old('status', $penarikanSaldo->status) === 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                    <option value="selesai"   {{ old('status', $penarikanSaldo->status) === 'selesai'   ? 'selected' : '' }}>Selesai (saldo nasabah akan dikurangi)</option>
                </select>
                @error('status')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                Catatan Petugas
                <textarea name="catatan" maxlength="500"
                          placeholder="Alasan perubahan status atau catatan proses...">{{ old('catatan', $penarikanSaldo->catatan) }}</textarea>
                @error('catatan')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="modal-actions">
            <a class="btn btn-outline" href="{{ route('admin.penarikan-saldo.show', $penarikanSaldo) }}">Batal</a>
            <button class="btn btn-primary" type="submit">Simpan Status</button>
        </div>
    </form>
</div>
@endsection

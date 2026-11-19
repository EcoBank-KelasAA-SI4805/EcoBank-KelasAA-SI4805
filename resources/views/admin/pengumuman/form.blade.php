@extends('layouts.admin')

@section('title', $isEdit ? 'Edit Pengumuman' : 'Buat Pengumuman')
@section('breadcrumb', 'Pengumuman / ' . ($isEdit ? 'Edit' : 'Tambah'))

@section('content')
<style>
    .form-container {
        max-width: 820px;
        margin: 0 auto;
    }
    .form-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        padding: 28px;
    }
    .form-group-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 20px;
    }
    .form-group-field label {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
    }
    .form-group-field input[type="text"],
    .form-group-field input[type="date"],
    .form-group-field textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13px;
        color: #0f172a;
        background: #ffffff;
        transition: all 0.15s ease;
        outline: none;
        font-family: inherit;
    }
    .form-group-field input[type="text"]:focus,
    .form-group-field input[type="date"]:focus,
    .form-group-field textarea:focus {
        border-color: #16865b;
        box-shadow: 0 0 0 3px rgba(22, 134, 91, 0.15);
    }
    .form-group-field small {
        font-size: 11px;
        color: #64748b;
    }
    .form-footer-actions {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }
    @media (max-width: 640px) {
        .form-panel {
            padding: 18px;
        }
        .form-footer-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }
        .form-footer-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-heading">
    <div>
        <div class="eyebrow" style="color: #16865b; font-weight: 700; letter-spacing: 1.2px; font-size: 11px; margin-bottom: 4px;">P-14 · INFORMASI & PENGUMUMAN</div>
        <h1 style="font: 800 24px/1.3 'Manrope', sans-serif; color: #0f172a; margin: 0 0 4px;">{{ $isEdit ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' }}</h1>
        <p style="font-size: 12px; color: #64748b; margin: 0;">{{ $isEdit ? 'Perbarui konten pengumuman dan tanggal tayang.' : 'Tulis dan publikasikan informasi resmi pengurus bank sampah untuk nasabah.' }}</p>
    </div>
    <a class="btn btn-outline" href="{{ $isEdit ? route('admin.pengumuman.show', $pengumuman) : route('admin.pengumuman.index') }}" style="display: inline-flex; align-items: center; gap: 6px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        <span>Kembali</span>
    </a>
</div>

<div class="form-container">
    <div class="form-panel">
        <form method="POST" action="{{ $isEdit ? route('admin.pengumuman.update', $pengumuman) : route('admin.pengumuman.store') }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            {{-- Judul Pengumuman --}}
            <div class="form-group-field">
                <label>Judul Pengumuman <span style="color: #e11d48;">*</span></label>
                <input 
                    type="text" 
                    name="judul" 
                    value="{{ old('judul', $pengumuman->judul) }}" 
                    placeholder="Contoh: Jadwal Penimbangan Rutin dan Penyesuaian Harga Plastik" 
                    maxlength="150" 
                    required
                >
                <small>Maksimal 150 karakter. Buat judul singkat, jelas, dan informatif.</small>
                @error('judul')
                    <small style="color: #e11d48; font-weight: 600;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Tanggal Mulai Tayang --}}
            <div class="form-group-field">
                <label>Tanggal Mulai Tayang <span style="color: #e11d48;">*</span></label>
                <input 
                    type="date" 
                    name="tanggal_tayang" 
                    value="{{ old('tanggal_tayang', $pengumuman->tanggal_tayang ? \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->format('Y-m-d') : now()->format('Y-m-d')) }}" 
                    required
                >
                <small>Pengumuman otomatis aktif dan dapat dibaca oleh nasabah mulai tanggal ini.</small>
                @error('tanggal_tayang')
                    <small style="color: #e11d48; font-weight: 600;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Isi Pengumuman --}}
            <div class="form-group-field">
                <label>Isi Lengkap Pengumuman <span style="color: #e11d48;">*</span></label>
                <textarea 
                    name="isi" 
                    rows="8" 
                    maxlength="3000" 
                    placeholder="Tuliskan isi pengumuman secara rinci, ketentuan, jadwal, lokasi, atau informasi penting lainnya..." 
                    required
                >{{ old('isi', $pengumuman->isi) }}</textarea>
                <small>Maksimal 3.000 karakter.</small>
                @error('isi')
                    <small style="color: #e11d48; font-weight: 600;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="form-footer-actions">
                <a class="btn btn-outline" href="{{ $isEdit ? route('admin.pengumuman.show', $pengumuman) : route('admin.pengumuman.index') }}" style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                    <span>Batal</span>
                </a>
                <button class="btn btn-primary" type="submit" style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    <span>{{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan Pengumuman' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

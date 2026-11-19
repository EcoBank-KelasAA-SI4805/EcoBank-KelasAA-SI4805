@extends('layouts.admin')

@section('title', $isEdit ? 'Edit Pengeluaran' : 'Catat Pengeluaran')
@section('breadcrumb', 'Pengeluaran Operasional / ' . ($isEdit ? 'Edit' : 'Tambah'))

@section('content')
<style>
    /* Hilangkan panah spinner atas-bawah pada input angka di semua browser */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }

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
    .form-group-field input[type="number"],
    .form-group-field select,
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
    .form-group-field input:focus,
    .form-group-field select:focus,
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
    .grid-two-cols {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 640px) {
        .form-panel {
            padding: 18px;
        }
        .grid-two-cols {
            grid-template-columns: 1fr;
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
        <div class="eyebrow" style="color: #16865b; font-weight: 700; letter-spacing: 1.2px; font-size: 11px; margin-bottom: 4px;">P-13 · MASTER DATA OPERASIONAL</div>
        <h1 style="font: 800 24px/1.3 'Manrope', sans-serif; color: #0f172a; margin: 0 0 4px;">{{ $isEdit ? 'Edit Pengeluaran Operasional' : 'Catat Pengeluaran Baru' }}</h1>
        <p style="font-size: 12px; color: #64748b; margin: 0;">{{ $isEdit ? 'Perbarui informasi dan nominal pengeluaran kas.' : 'Catat transaksi pengeluaran operasional bank sampah ke dalam pembukuan kas.' }}</p>
    </div>
    <a class="btn btn-outline" href="{{ $isEdit ? route('admin.pengeluaran.show', $pengeluaran) : route('admin.pengeluaran.index') }}" style="display: inline-flex; align-items: center; gap: 6px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        <span>Kembali</span>
    </a>
</div>

<div class="form-container">
    <div class="form-panel">
        <form method="POST" action="{{ $isEdit ? route('admin.pengeluaran.update', $pengeluaran) : route('admin.pengeluaran.store') }}" id="pengeluaranForm">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid-two-cols">
                {{-- Tanggal Transaksi --}}
                <div class="form-group-field">
                    <label>Tanggal Transaksi <span style="color: #e11d48;">*</span></label>
                    <input 
                        type="date" 
                        name="tanggal" 
                        value="{{ old('tanggal', $pengeluaran->tanggal ? \Carbon\Carbon::parse($pengeluaran->tanggal)->format('Y-m-d') : now()->format('Y-m-d')) }}" 
                        required
                    >
                    @error('tanggal')
                        <small style="color: #e11d48; font-weight: 600;">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Kategori Pengeluaran --}}
                <div class="form-group-field">
                    <label>Kategori Pengeluaran <span style="color: #e11d48;">*</span></label>
                    <select name="kategori" required>
                        <option value="" disabled {{ old('kategori', $pengeluaran->kategori) ? '' : 'selected' }}>Pilih Kategori...</option>
                        @foreach($daftarKategori as $kat)
                            <option value="{{ $kat }}" {{ old('kategori', $pengeluaran->kategori) === $kat ? 'selected' : '' }}>
                                {{ $kat }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <small style="color: #e11d48; font-weight: 600;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Nominal Pengeluaran --}}
            <div class="form-group-field">
                <label>Nominal Pengeluaran (Rp) <span style="color: #e11d48;">*</span></label>
                <div style="position: relative; display: flex; align-items: center;">
                    <span style="position: absolute; left: 14px; font-weight: 800; color: #16865b; font-size: 14px; font-family: 'Manrope', sans-serif;">Rp</span>
                    <input 
                        type="number" 
                        id="nominalInput"
                        name="nominal" 
                        value="{{ old('nominal', $pengeluaran->nominal ? (int)$pengeluaran->nominal : '') }}" 
                        placeholder="Contoh: 1500000" 
                        min="0" 
                        step="any"
                        required
                        style="padding-left: 44px; font-weight: 700; font-size: 15px;"
                    >
                </div>
                <small>Ketikkan angka nominal pengeluaran kas tanpa titik/koma (contoh: 1500000).</small>
                @error('nominal')
                    <small style="color: #e11d48; font-weight: 600;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Keterangan / Rincian Biaya --}}
            <div class="form-group-field">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <label>Keterangan / Rincian Biaya</label>
                    <small id="charCount" style="color: #64748b; font-size: 11px;">0 / 500 karakter</small>
                </div>
                <textarea 
                    id="keteranganInput"
                    name="keterangan" 
                    rows="3" 
                    maxlength="500" 
                    placeholder="Contoh: Pembelian kantong sampah 5 pack dan lakban untuk operasional timbangan..."
                    oninput="updateCharCount(this.value)"
                >{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
                @error('keterangan')
                    <small style="color: #e11d48; font-weight: 600;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="form-footer-actions">
                <a class="btn btn-outline" href="{{ $isEdit ? route('admin.pengeluaran.show', $pengeluaran) : route('admin.pengeluaran.index') }}" style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                    <span>Batal</span>
                </a>
                <button class="btn btn-primary" type="submit" style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    <span>{{ $isEdit ? 'Simpan Perubahan' : 'Catat Pengeluaran' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function updateCharCount(val) {
    const el = document.getElementById('charCount');
    if (el) {
        el.textContent = (val ? val.length : 0) + ' / 500 karakter';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const ket = document.getElementById('keteranganInput');
    if (ket && ket.value) updateCharCount(ket.value);
});
</script>
@endpush
@endsection

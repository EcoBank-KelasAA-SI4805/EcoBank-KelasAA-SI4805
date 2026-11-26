
@extends('layouts.admin')

@section('title', 'Tambah Promo')
@section('breadcrumb', 'Tambah Promo')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-04 · KELOLA PROMO</div>
        <h1>Tambah Promo</h1>
        <p>Tambahkan promo atau bonus harga untuk jenis sampah.</p>
    </div>
    <a href="{{ route('admin.promo.index') }}" class="btn btn-outline">
        Kembali
    </a>
</div>

<div class="panel">
    <form method="POST" action="{{ route('admin.promo.store') }}">
        @csrf

        <div class="form-group">
            <label for="nama">Nama Promo</label>
            <input
                type="text"
                id="nama"
                name="nama"
                value="{{ old('nama') }}"
                placeholder="Contoh: Promo Bonus Plastik"
                required
            >
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_jenis">Jenis Sampah</label>
            <select id="id_jenis" name="id_jenis" required>
                <option value="">-- Pilih Jenis Sampah --</option>
                @foreach($jenisSampah as $jenis)
                    <option value="{{ $jenis->id }}"
                        @selected(old('id_jenis') == $jenis->id)>
                        {{ $jenis->nama_jenis }}
                    </option>
                @endforeach
            </select>
            @error('id_jenis')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="tipe_bonus">Tipe Bonus</label>
            <select id="tipe_bonus" name="tipe_bonus" required>
                <option value="">-- Pilih Tipe Bonus --</option>
                <option value="persen" @selected(old('tipe_bonus') == 'persen')>
                    Persentase (%)
                </option>
                <option value="rupiah" @selected(old('tipe_bonus') == 'rupiah')>
                    Rupiah (Rp)
                </option>
            </select>
            @error('tipe_bonus')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="nilai_bonus">Nilai Bonus</label>
            <input
                type="number"
                id="nilai_bonus"
                name="nilai_bonus"
                value="{{ old('nilai_bonus') }}"
                min="0.01"
                step="0.01"
                placeholder="Masukkan nilai bonus"
                required
            >
            @error('nilai_bonus')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="tgl_mulai">Tanggal Mulai</label>
            <input
                type="date"
                id="tgl_mulai"
                name="tgl_mulai"
                value="{{ old('tgl_mulai') }}"
                required
            >
            @error('tgl_mulai')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="tgl_selesai">Tanggal Selesai</label>
            <input
                type="date"
                id="tgl_selesai"
                name="tgl_selesai"
                value="{{ old('tgl_selesai') }}"
                required
            >
            @error('tgl_selesai')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.promo.index') }}" class="btn btn-outline">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                Simpan Promo
            </button>
        </div>
    </form>
</div>
@endsection

@csrf

<div class="mb-3">
    <label for="judul" class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
    <input type="text" id="judul" name="judul"
           class="form-control @error('judul') is-invalid @enderror"
           value="{{ old('judul', $kegiatan->judul ?? '') }}"
           placeholder="Contoh: Penyuluhan Pemilahan Sampah RT 05" required>
    @error('judul')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="tanggal" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
    <input type="date" id="tanggal" name="tanggal"
           class="form-control @error('tanggal') is-invalid @enderror"
           value="{{ old('tanggal', isset($kegiatan) ? $kegiatan->tanggal?->format('Y-m-d') : '') }}" required>
    @error('tanggal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="lokasi" class="form-label fw-semibold">Lokasi <span class="text-danger">*</span></label>
    <input type="text" id="lokasi" name="lokasi"
           class="form-control @error('lokasi') is-invalid @enderror"
           value="{{ old('lokasi', $kegiatan->lokasi ?? '') }}"
           placeholder="Contoh: Balai RW 03, Kelurahan Sukamaju" required>
    @error('lokasi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="kuota" class="form-label fw-semibold">Kuota Peserta <span class="text-danger">*</span></label>
    <input type="number" id="kuota" name="kuota" min="1"
           class="form-control @error('kuota') is-invalid @enderror"
           value="{{ old('kuota', $kegiatan->kuota ?? '') }}"
           placeholder="30" required>
    @error('kuota')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@isset($kegiatan->id)
<div class="mb-3">
    <label for="status" class="form-label fw-semibold">Status</label>
    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
        @foreach(['dijadwalkan', 'selesai', 'dibatalkan'] as $s)
            <option value="{{ $s }}" {{ old('status', $kegiatan->status ?? 'dijadwalkan') === $s ? 'selected' : '' }}>
                {{ ucfirst($s) }}
            </option>
        @endforeach
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@endisset

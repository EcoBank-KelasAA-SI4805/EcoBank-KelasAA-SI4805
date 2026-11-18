@csrf

<div class="mb-3">
    <label for="nama" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
           value="{{ old('nama', $jenisResidu->nama ?? '') }}" placeholder="Contoh: Popok Bayi Bekas" required>
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="alasan" class="form-label fw-semibold">Alasan Tidak Layak Daur Ulang <span class="text-danger">*</span></label>
    <textarea id="alasan" name="alasan" rows="4" class="form-control @error('alasan') is-invalid @enderror"
              placeholder="Jelaskan mengapa jenis ini tidak bisa didaur ulang..." required>{{ old('alasan', $jenisResidu->alasan ?? '') }}</textarea>
    @error('alasan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="cara_penanganan" class="form-label fw-semibold">Cara Penanganan <span class="text-danger">*</span></label>
    <select id="cara_penanganan" name="cara_penanganan" class="form-select @error('cara_penanganan') is-invalid @enderror" required>
        <option value="">-- Pilih cara penanganan --</option>
        @foreach(['TPA', 'insinerasi', 'lainnya'] as $cp)
            <option value="{{ $cp }}" {{ old('cara_penanganan', $jenisResidu->cara_penanganan ?? '') === $cp ? 'selected' : '' }}>
                {{ ucfirst($cp) }}
            </option>
        @endforeach
    </select>
    @error('cara_penanganan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="biaya_per_kg" class="form-label fw-semibold">Biaya per kg (Rp) <span class="text-danger">*</span></label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" id="biaya_per_kg" name="biaya_per_kg" step="0.01" min="0"
               class="form-control @error('biaya_per_kg') is-invalid @enderror"
               value="{{ old('biaya_per_kg', $jenisResidu->biaya_per_kg ?? '') }}"
               placeholder="0" required>
        @error('biaya_per_kg')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

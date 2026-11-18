@csrf

<div class="mb-3">
    <label for="tanggal" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
    <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
           value="{{ old('tanggal', isset($residu) ? $residu->tanggal->format('Y-m-d') : date('Y-m-d')) }}" required>
    @error('tanggal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="id_jenis_residu" class="form-label fw-semibold">Jenis Residu <span class="text-danger">*</span></label>
    <select id="id_jenis_residu" name="id_jenis_residu"
            class="form-select @error('id_jenis_residu') is-invalid @enderror" required>
        <option value="">-- Pilih jenis residu --</option>
        @foreach($jenisResiduList as $jr)
            <option value="{{ $jr->id }}"
                    data-biaya="{{ $jr->biaya_per_kg }}"
                    {{ old('id_jenis_residu', $residu->id_jenis_residu ?? '') == $jr->id ? 'selected' : '' }}>
                {{ $jr->nama }} (Rp {{ number_format($jr->biaya_per_kg, 0, ',', '.') }}/kg)
            </option>
        @endforeach
    </select>
    @error('id_jenis_residu')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="berat_kg" class="form-label fw-semibold">Berat (kg) <span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="number" id="berat_kg" name="berat_kg" step="0.01" min="0.01"
               class="form-control @error('berat_kg') is-invalid @enderror"
               value="{{ old('berat_kg', $residu->berat_kg ?? '') }}"
               placeholder="0.00" required>
        <span class="input-group-text">kg</span>
        @error('berat_kg')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="asal" class="form-label fw-semibold">Asal <span class="text-danger">*</span></label>
    <input type="text" id="asal" name="asal" class="form-control @error('asal') is-invalid @enderror"
           value="{{ old('asal', $residu->asal ?? '') }}" placeholder="Contoh: RT 01 Kelurahan Sukamaju" required>
    @error('asal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@isset($residu)
<div class="mb-3">
    <label for="status" class="form-label fw-semibold">Status</label>
    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
        @foreach(['ditampung', 'diangkut', 'dibuang'] as $st)
            <option value="{{ $st }}" {{ old('status', $residu->status ?? 'ditampung') === $st ? 'selected' : '' }}>
                {{ ucfirst($st) }}
            </option>
        @endforeach
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@endisset

{{-- Pratinjau total biaya (JavaScript) --}}
<div class="alert alert-secondary" id="preview-total" style="display:none;">
    <i class="bi bi-calculator me-2"></i>
    <strong>Estimasi Total Biaya:</strong>
    <span id="preview-nilai">Rp 0</span>
    <small class="text-muted ms-2">(perhitungan final dilakukan di server)</small>
</div>

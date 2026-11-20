@csrf

<div class="form-grid">
    <label class="form-field">
        Tanggal Penimbangan <span style="color:#d94c4c;">*</span>
        <input type="date" id="tanggal" name="tanggal"
               value="{{ old('tanggal', isset($residu) ? $residu->tanggal->format('Y-m-d') : date('Y-m-d')) }}" required>
        @error('tanggal')
            <small class="field-error" style="color:#d94c4c; font-size:10px;">{{ $message }}</small>
        @enderror
    </label>

    <label class="form-field">
        Jenis Residu <span style="color:#d94c4c;">*</span>
        <select id="id_jenis_residu" name="id_jenis_residu" onchange="hitungPreview()" required>
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
            <small class="field-error" style="color:#d94c4c; font-size:10px;">{{ $message }}</small>
        @enderror
    </label>

    <label class="form-field">
        Berat Residu (kg) <span style="color:#d94c4c;">*</span>
        <input type="number" id="berat_kg" name="berat_kg" step="0.01" min="0.01"
               value="{{ old('berat_kg', $residu->berat_kg ?? '') }}"
               placeholder="Contoh: 12.5" oninput="hitungPreview()" required>
        @error('berat_kg')
            <small class="field-error" style="color:#d94c4c; font-size:10px;">{{ $message }}</small>
        @enderror
    </label>

    <label class="form-field">
        Asal Residu (Wilayah / RT / RW) <span style="color:#d94c4c;">*</span>
        <input type="text" id="asal" name="asal" maxlength="150"
               value="{{ old('asal', $residu->asal ?? '') }}" placeholder="Contoh: RT 02 / RW 05 Sukamaju" required>
        @error('asal')
            <small class="field-error" style="color:#d94c4c; font-size:10px;">{{ $message }}</small>
        @enderror
    </label>

    @if(isset($residu))
        <label class="form-field full">
            Status Penanganan Residu <span style="color:#d94c4c;">*</span>
            <select id="status" name="status" required>
                @foreach(['ditampung', 'diangkut', 'dibuang'] as $st)
                    <option value="{{ $st }}" {{ old('status', $residu->status ?? 'ditampung') === $st ? 'selected' : '' }}>
                        {{ ucfirst($st) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <small class="field-error" style="color:#d94c4c; font-size:10px;">{{ $message }}</small>
            @enderror
        </label>
    @endif
</div>

{{-- Preview Perhitungan Otomatis Biaya --}}
<div id="preview-total" style="display: none; background: #eaf7f0; border-left: 4px solid #16865b; padding: 12px 16px; border-radius: 8px; margin-top: 18px;">
    <div style="font-size: 11px; color: #16865b; font-weight: 600;">ESTIMASI BIAYA PENANGANAN OTOMATIS:</div>
    <div id="preview-nilai" style="font-size: 18px; font-weight: 800; color: #0f172a; margin-top: 2px;">Rp 0</div>
</div>

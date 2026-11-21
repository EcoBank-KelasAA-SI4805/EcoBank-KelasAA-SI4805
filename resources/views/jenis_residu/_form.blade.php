@csrf

<div class="form-grid">
    <label class="form-field full">
        Nama Residu <span style="color:#d94c4c;">*</span>
        <input type="text" id="nama" name="nama"
               value="{{ old('nama', $jenisResidu->nama ?? '') }}" placeholder="Contoh: Popok Bayi Bekas" required maxlength="100">
        @error('nama')
            <small class="field-error" style="color:#d94c4c; font-size:10px;">{{ $message }}</small>
        @enderror
    </label>

    <label class="form-field">
        Cara Penanganan <span style="color:#d94c4c;">*</span>
        <select id="cara_penanganan" name="cara_penanganan" required>
            <option value="">-- Pilih cara penanganan --</option>
            @foreach(['TPA', 'insinerasi', 'lainnya'] as $cp)
                <option value="{{ $cp }}" {{ old('cara_penanganan', $jenisResidu->cara_penanganan ?? '') === $cp ? 'selected' : '' }}>
                    {{ ucfirst($cp) }}
                </option>
            @endforeach
        </select>
        @error('cara_penanganan')
            <small class="field-error" style="color:#d94c4c; font-size:10px;">{{ $message }}</small>
        @enderror
    </label>

    <label class="form-field">
        Biaya per kg (Rp) <span style="color:#d94c4c;">*</span>
        <input type="number" id="biaya_per_kg" name="biaya_per_kg" step="0.01" min="0"
               value="{{ old('biaya_per_kg', $jenisResidu->biaya_per_kg ?? '') }}"
               placeholder="Contoh: 1500" required>
        @error('biaya_per_kg')
            <small class="field-error" style="color:#d94c4c; font-size:10px;">{{ $message }}</small>
        @enderror
    </label>

    <label class="form-field full">
        Alasan Tidak Layak Daur Ulang <span style="color:#d94c4c;">*</span>
        <textarea id="alasan" name="alasan" rows="3" style="width:100%; padding:10px; border:1px solid #e4ebe6; border-radius:7px; font-size:11px;"
                  placeholder="Jelaskan alasan mengapa sampah ini tidak layak didaur ulang..." required>{{ old('alasan', $jenisResidu->alasan ?? '') }}</textarea>
        @error('alasan')
            <small class="field-error" style="color:#d94c4c; font-size:10px;">{{ $message }}</small>
        @enderror
    </label>
</div>

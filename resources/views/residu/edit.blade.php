@extends('layouts.app')

@section('title', 'Edit Residu')

@section('content')
<div class="mb-3">
    <a href="{{ route('residu.index') }}" class="text-decoration-none text-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
    </a>
</div>

<div class="card shadow-sm" style="max-width: 680px;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Data Residu</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('residu.update', $residu) }}" method="POST">
            @method('PUT')
            @include('residu._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Perbarui
                </button>
                <a href="{{ route('residu.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function hitungPreview() {
    const selectJenis = document.getElementById('id_jenis_residu');
    const inputBerat = document.getElementById('berat_kg');
    const previewDiv = document.getElementById('preview-total');
    const previewNilai = document.getElementById('preview-nilai');

    const selectedOption = selectJenis.options[selectJenis.selectedIndex];
    const biaya = parseFloat(selectedOption.dataset.biaya || 0);
    const berat = parseFloat(inputBerat.value || 0);

    if (biaya > 0 && berat > 0) {
        const total = berat * biaya;
        previewNilai.textContent = 'Rp ' + total.toLocaleString('id-ID', {minimumFractionDigits: 0});
        previewDiv.style.display = 'block';
    } else {
        previewDiv.style.display = 'none';
    }
}

document.getElementById('id_jenis_residu').addEventListener('change', hitungPreview);
document.getElementById('berat_kg').addEventListener('input', hitungPreview);
// Trigger on load to show current value
window.addEventListener('load', hitungPreview);
</script>
@endpush

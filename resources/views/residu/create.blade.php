@extends('layouts.admin')
@section('title', 'Catat Residu Baru')
@section('breadcrumb', 'Pencatatan Residu / Tambah')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-06 · OPERASIONAL RESIDU</div>
        <h1>Catat Residu Baru</h1>
        <p>Catat sampah residu masuk. Total biaya penanganan akan dihitung secara otomatis berdasarkan tarif jenis residu.</p>
    </div>
    <a class="btn btn-outline" href="{{ route('residu.index') }}">← Kembali ke Daftar</a>
</div>

<div class="panel" style="padding: 24px; max-width: 800px;">
    <form action="{{ route('residu.store') }}" method="POST">
        @include('residu._form')
        <div class="modal-actions" style="margin-top: 24px;">
            <a href="{{ route('residu.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Pencatatan Residu</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function hitungPreview() {
    const selectJenis = document.getElementById('id_jenis_residu');
    const inputBerat = document.getElementById('berat_kg');
    const previewDiv = document.getElementById('preview-total');
    const previewNilai = document.getElementById('preview-nilai');

    if (!selectJenis || !inputBerat || !previewDiv || !previewNilai) return;

    const selectedOption = selectJenis.options[selectJenis.selectedIndex];
    const biaya = parseFloat(selectedOption?.dataset?.biaya || 0);
    const berat = parseFloat(inputBerat.value || 0);

    if (biaya > 0 && berat > 0) {
        const total = berat * biaya;
        previewNilai.textContent = 'Rp ' + total.toLocaleString('id-ID', {minimumFractionDigits: 0});
        previewDiv.style.display = 'block';
    } else {
        previewDiv.style.display = 'none';
    }
}
document.addEventListener('DOMContentLoaded', hitungPreview);
</script>
@endpush

@extends('layouts.app')

@section('title', 'Edit Kegiatan Penyuluhan')

@section('content')
<div class="mb-3">
    <a href="{{ route('kegiatan.index') }}" class="text-decoration-none text-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
    </a>
</div>

<div class="card shadow-sm" style="max-width: 640px;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-pencil me-2 text-primary"></i>Edit Kegiatan Penyuluhan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('kegiatan.update', $kegiatan) }}" method="POST">
            @method('PUT')
            @include('kegiatan._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Perbarui
                </button>
                <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Jenis Residu')

@section('content')
<div class="mb-3">
    <a href="{{ route('jenis-residu.index') }}" class="text-decoration-none text-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
    </a>
</div>

<div class="card shadow-sm" style="max-width: 640px;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Jenis Residu</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('jenis-residu.update', $jenisResidu) }}" method="POST">
            @method('PUT')
            @include('jenis_residu._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Perbarui
                </button>
                <a href="{{ route('jenis-residu.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

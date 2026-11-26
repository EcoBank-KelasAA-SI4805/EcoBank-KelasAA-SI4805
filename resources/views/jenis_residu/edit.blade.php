@extends('layouts.admin')
@section('title', 'Edit Jenis Residu')
@section('breadcrumb', 'Jenis Residu / Edit')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-05 · MASTER DATA RESIDU</div>
        <h1>Edit Jenis Residu</h1>
        <p>Perbarui informasi atau biaya penanganan jenis residu: <strong>{{ $jenisResidu->nama }}</strong></p>
    </div>
    <a class="btn btn-outline" href="{{ route('jenis-residu.show', $jenisResidu) }}">← Kembali</a>
</div>

<div class="panel" style="padding: 24px; max-width: 760px;">
    <form action="{{ route('jenis-residu.update', $jenisResidu) }}" method="POST">
        @method('PUT')
        @include('jenis_residu._form')
        <div class="modal-actions" style="margin-top: 24px;">
            <a href="{{ route('jenis-residu.show', $jenisResidu) }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui Jenis Residu</button>
        </div>
    </form>
</div>
@endsection

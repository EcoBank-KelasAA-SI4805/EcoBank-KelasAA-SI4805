@extends('layouts.admin')
@section('title', 'Tambah Jenis Residu')
@section('breadcrumb', 'Jenis Residu / Tambah')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-05 · MASTER DATA RESIDU</div>
        <h1>Tambah Jenis Residu</h1>
        <p>Klasifikasikan jenis sampah residu baru yang masuk ke bank sampah.</p>
    </div>
    <a class="btn btn-outline" href="{{ route('jenis-residu.index') }}">← Kembali ke Daftar</a>
</div>

<div class="panel" style="padding: 24px; max-width: 760px;">
    <form action="{{ route('jenis-residu.store') }}" method="POST">
        @include('jenis_residu._form')
        <div class="modal-actions" style="margin-top: 24px;">
            <a href="{{ route('jenis-residu.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Jenis Residu</button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.admin')
@section('title','Daftar Harga Sampah')
@section('breadcrumb','Daftar Harga')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-03 · HARGA SAMPAH</div><h1>Daftar Harga Sampah</h1><p>Harga per kilogram terbaru untuk jenis sampah yang diterima.</p></div></div>
<div class="panel">
    <div class="data-toolbar">
        <div><h3>Harga terbaru</h3><p>{{ $jenis->count() }} jenis aktif</p></div>
        <form class="toolbar-actions" method="GET">
            <input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari jenis sampah...">
            <button class="btn btn-outline">Cari</button>
            @if($q)<a class="btn btn-outline" href="{{ route('admin.harga.index') }}">Reset</a>@endif
        </form>
    </div>
    <div class="table-scroll"><table>
        <thead><tr><th>JENIS SAMPAH</th><th>KATEGORI</th><th>HARGA / KG</th><th>DIPERBARUI</th></tr></thead>
        <tbody>
        @forelse($jenis as $item)
        <tr>
            <td><strong>{{ $item->nama_jenis }}</strong></td>
            <td>{{ $item->kategori }}</td>
            <td><strong>Rp {{ number_format($item->harga_per_kg,0,',','.') }}</strong></td>
            <td>{{ $item->harga_diperbarui_pada ? \Illuminate\Support\Carbon::parse($item->harga_diperbarui_pada)->format('d M Y') : $item->created_at?->format('d M Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="4" class="empty-table">Jenis sampah tidak ditemukan.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
@endsection

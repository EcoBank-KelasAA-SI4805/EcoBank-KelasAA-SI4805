@extends('layouts.admin')
@section('title','Jenis Sampah')
@section('breadcrumb','Jenis Sampah')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-03 · KATALOG JENIS SAMPAH</div><h1>Jenis Sampah</h1><p>Kelola jenis sampah yang diterima bank sampah beserta harganya.</p></div><a class="btn btn-primary" href="{{ route('admin.jenis-sampah.create') }}">＋ Tambah jenis</a></div>
@if(session('success'))<div class="flash success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="flash error">{{ session('error') }}</div>@endif
<div class="panel">
    <div class="data-toolbar">
        <div><h3>Daftar jenis sampah</h3><p>{{ $jenis->total() }} jenis terdaftar</p></div>
        <form class="toolbar-actions" method="GET">
            <input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari nama atau kategori...">
            <select name="status"><option value="">Semua status</option><option value="aktif" @selected($status==='aktif')>Aktif</option><option value="nonaktif" @selected($status==='nonaktif')>Nonaktif</option></select>
            <button class="btn btn-outline">Cari</button>
            @if($q || $status)<a class="btn btn-outline" href="{{ route('admin.jenis-sampah.index') }}">Reset</a>@endif
        </form>
    </div>
    <div class="table-scroll"><table>
        <thead><tr><th>NAMA JENIS</th><th>KATEGORI</th><th>HARGA / KG</th><th>STATUS</th><th class="align-right">AKSI</th></tr></thead>
        <tbody>
        @forelse($jenis as $item)
        <tr>
            <td><strong>{{ $item->nama_jenis }}</strong></td>
            <td>{{ $item->kategori }}</td>
            <td><strong>Rp {{ number_format($item->harga_per_kg,0,',','.') }}</strong></td>
            <td><span class="status {{ $item->status_aktif ? 'success' : 'inactive' }}">{{ $item->status_aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
            <td><div class="row-actions">
                <a class="action-btn" href="{{ route('admin.jenis-sampah.show',$item) }}">Detail</a>
                <a class="action-btn" href="{{ route('admin.jenis-sampah.edit',$item) }}">Edit</a>
                <a class="action-btn" href="{{ route('admin.harga.edit',$item) }}">Ubah harga</a>
                <form method="POST" action="{{ route('admin.jenis-sampah.status',$item) }}">@csrf @method('PATCH')<button class="action-btn {{ $item->status_aktif ? 'delete' : '' }}" type="submit">{{ $item->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                <form method="POST" action="{{ route('admin.jenis-sampah.destroy',$item) }}" onsubmit="return confirm('Hapus jenis {{ addslashes($item->nama_jenis) }}?')">@csrf @method('DELETE')<button class="action-btn delete" type="submit">Hapus</button></form>
            </div></td>
        </tr>
        @empty
        <tr><td colspan="5" class="empty-table">Belum ada jenis sampah atau data tidak ditemukan.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    <div class="table-bottom">{{ $jenis->links() }}</div>
</div>
@endsection

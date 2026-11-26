@extends('layouts.admin')
@section('title','Pengepul')
@section('breadcrumb','Pengepul')
@section('content')
<div class="page-heading"><div><div class="eyebrow">DATA MASTER · ECOBANK</div><h1>Pengepul</h1><p>Kelola data pengepul EcoBank.</p></div><a class="btn btn-primary" href="{{ route('admin.pengepul.create') }}">+ Tambah Pengepul</a></div>
<div class="panel"><div class="data-toolbar"><div><h3>Daftar Pengepul</h3><p>{{ $pengepuls->total() }} data terdaftar</p></div><form class="toolbar-actions" method="GET"><input class="data-search" name="q" value="{{ $q }}" placeholder="Cari data..."><button class="btn btn-outline">Cari</button></form></div>
<div class="table-scroll"><table><thead><tr><th>NAMA PENGEPUL</th><th>KONTAK / NOMOR TELEPON</th><th>ALAMAT</th><th>JENIS SAMPAH YANG DIBELI</th><th>AKSI</th></tr></thead><tbody>@forelse($pengepuls as $item)<tr><td>{{ $item->nama }}</td><td>{{ $item->kontak }}</td><td>{{ $item->alamat }}</td><td>{{ $item->jenis_dibeli }}</td><td><div class="action-group"><a class="act-btn view" href="{{ route('admin.pengepul.show',$item) }}">Detail</a><a class="act-btn edit" href="{{ route('admin.pengepul.edit',$item) }}">Edit</a><form method="POST" action="{{ route('admin.pengepul.destroy',$item) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="act-btn delete">Hapus</button></form></div></td></tr>@empty<tr><td colspan="5" class="empty-table">Belum ada data.</td></tr>@endforelse</tbody></table></div><div class="table-bottom">{{ $pengepuls->links() }}</div></div>
@endsection

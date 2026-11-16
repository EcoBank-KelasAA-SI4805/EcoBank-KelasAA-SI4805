@extends('layouts.admin')
@section('title','Lokasi Drop Point')
@section('breadcrumb','Lokasi Drop Point')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-02 · MANAJEMEN LOKASI</div><h1>Lokasi Drop Point</h1><p>Kelola titik setor sampah dan informasi operasionalnya.</p></div><a class="btn btn-primary" href="{{ route('admin.drop-points.create') }}">＋ Tambah lokasi</a></div>
@if(session('success'))<div class="flash success">{{ session('success') }}</div>@endif @if(session('error'))<div class="flash error">{{ session('error') }}</div>@endif
<div class="panel"><div class="data-toolbar"><div><h3>Daftar lokasi</h3><p>{{ $dropPoints->total() }} lokasi terdaftar</p></div><form class="toolbar-actions" method="GET"><input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari nama atau alamat lokasi..."><button class="btn btn-outline">Cari</button>@if($q)<a class="btn btn-outline" href="{{ route('admin.drop-points.index') }}">Reset</a>@endif</form></div>
<div class="table-scroll"><table><thead><tr><th>NAMA LOKASI</th><th>ALAMAT</th><th>JAM BUKA</th><th>STATUS</th><th class="align-right">AKSI</th></tr></thead><tbody>
@forelse($dropPoints as $item)<tr><td><strong>{{ $item->nama }}</strong></td><td>{{ $item->alamat }}</td><td>{{ $item->jam_buka }}</td><td><span class="status {{ $item->status_aktif ? 'success' : 'inactive' }}">{{ $item->status_aktif ? 'Aktif' : 'Nonaktif' }}</span></td><td><div class="row-actions"><a class="action-btn" href="{{ route('admin.drop-points.show',$item) }}">Detail</a><a class="action-btn" href="{{ route('admin.drop-points.edit',$item) }}">Edit</a><form method="POST" action="{{ route('admin.drop-points.destroy',$item) }}" onsubmit="return confirm('Hapus lokasi {{ addslashes($item->nama) }}?')">@csrf @method('DELETE')<button class="action-btn delete" type="submit">Hapus</button></form></div></td></tr>
@empty<tr><td colspan="5" class="empty-table">Belum ada lokasi drop point atau data tidak ditemukan.</td></tr>@endforelse
</tbody></table></div><div class="table-bottom">{{ $dropPoints->links() }}</div></div>
@endsection

@extends('layouts.admin')
@section('title','Wilayah/RW')
@section('breadcrumb','Wilayah/RW')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-10 · MASTER DATA</div><h1>Wilayah/RW</h1><p>Kelola wilayah layanan bank sampah dan jumlah nasabah per RW.</p></div><a class="btn btn-primary" href="{{ route('admin.wilayah.create') }}">＋ Tambah wilayah</a></div>
<div class="panel"><div class="data-toolbar"><div><h3>Daftar wilayah</h3><p>{{ $wilayah->total() }} wilayah terdaftar</p></div><form class="toolbar-actions" method="GET"><input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari RW atau kelurahan..."><button class="btn btn-outline">Cari</button>@if($q)<a class="btn btn-outline" href="{{ route('admin.wilayah.index') }}">Reset</a>@endif</form></div>
<div class="table-scroll"><table><thead><tr><th>NAMA RW</th><th>KELURAHAN</th><th>JUMLAH NASABAH</th><th class="align-right">AKSI</th></tr></thead><tbody>
@forelse($wilayah as $item)<tr><td><strong>{{ $item->nama_rw }}</strong></td><td>{{ $item->kelurahan }}</td><td>{{ $item->nasabah_count }} nasabah</td><td><div class="row-actions"><a class="action-btn" href="{{ route('admin.wilayah.show',$item) }}">Detail</a><a class="action-btn" href="{{ route('admin.wilayah.edit',$item) }}">Edit</a><form method="POST" action="{{ route('admin.wilayah.destroy',$item) }}" onsubmit="return confirm('Hapus wilayah {{ addslashes($item->nama_rw) }}?')">@csrf @method('DELETE')<button class="action-btn delete" type="submit">Hapus</button></form></div></td></tr>
@empty<tr><td colspan="4" class="empty-table">Belum ada wilayah atau data tidak ditemukan.</td></tr>@endforelse
</tbody></table></div><div class="table-bottom">{{ $wilayah->links() }}</div></div>
@endsection

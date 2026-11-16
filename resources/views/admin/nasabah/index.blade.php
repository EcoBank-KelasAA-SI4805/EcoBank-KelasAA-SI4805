@extends('layouts.admin')
@section('title','Data Nasabah')
@section('breadcrumb','Data Nasabah')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-01 · MANAJEMEN NASABAH</div><h1>Data Nasabah</h1><p>Tambah, cari, lihat saldo, ubah, dan kelola data nasabah.</p></div><a class="btn btn-primary" href="{{ route('admin.nasabah.create') }}">＋ Tambah nasabah</a></div>
@if(session('success'))<div class="flash success">{{ session('success') }}</div>@endif @if(session('error'))<div class="flash error">{{ session('error') }}</div>@endif
<div class="panel"><div class="data-toolbar"><div><h3>Daftar nasabah</h3><p>{{ $nasabah->total() }} nasabah terdaftar</p></div><form class="toolbar-actions" method="GET"><input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari nama, NIK, atau no. HP..."><button class="btn btn-outline">Cari</button>@if($q)<a class="btn btn-outline" href="{{ route('admin.nasabah.index') }}">Reset</a>@endif</form></div>
<div class="table-scroll"><table><thead><tr><th>NAMA NASABAH</th><th>NIK</th><th>NO. HP</th><th>RW</th><th>SALDO</th><th class="align-right">AKSI</th></tr></thead><tbody>
@forelse($nasabah as $item)<tr><td><strong>{{ $item->nama }}</strong><small>{{ $item->alamat }}</small></td><td>{{ $item->nik }}</td><td>{{ $item->no_hp }}</td><td>{{ $item->rw }}</td><td><strong>Rp {{ number_format($item->saldo,0,',','.') }}</strong></td><td><div class="row-actions"><a class="action-btn" href="{{ route('admin.nasabah.show',$item) }}">Detail</a><a class="action-btn" href="{{ route('admin.nasabah.edit',$item) }}">Edit</a><form method="POST" action="{{ route('admin.nasabah.destroy',$item) }}" onsubmit="return confirm('Hapus data nasabah {{ addslashes($item->nama) }}?')">@csrf @method('DELETE')<button class="action-btn delete" type="submit">Hapus</button></form></div></td></tr>
@empty<tr><td colspan="6" class="empty-table">Belum ada data nasabah atau data tidak ditemukan.</td></tr>@endforelse
</tbody></table></div><div class="table-bottom">{{ $nasabah->links() }}</div></div>
@endsection

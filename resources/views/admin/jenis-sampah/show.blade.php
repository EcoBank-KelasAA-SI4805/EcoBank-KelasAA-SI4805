@extends('layouts.admin')
@section('title','Detail Jenis Sampah')
@section('breadcrumb','Jenis Sampah / Detail')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-03 · DETAIL JENIS SAMPAH</div><h1>{{ $jenis->nama_jenis }}</h1><p>Informasi katalog dan riwayat perubahan harga.</p></div>
<div class="heading-actions"><a class="btn btn-outline" href="{{ route('admin.jenis-sampah.index') }}">← Daftar</a><a class="btn btn-outline" href="{{ route('admin.jenis-sampah.edit',$jenis) }}">Edit data</a><a class="btn btn-primary" href="{{ route('admin.harga.edit',$jenis) }}">Ubah harga</a></div></div>
@if(session('success'))<div class="flash success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="flash error">{{ session('error') }}</div>@endif
<div class="panel"><div class="detail-grid">
    <div class="detail-item"><small>NAMA JENIS</small><strong>{{ $jenis->nama_jenis }}</strong></div>
    <div class="detail-item"><small>STATUS</small><strong>{{ $jenis->status_aktif ? 'Aktif' : 'Nonaktif' }}</strong></div>
    <div class="detail-item"><small>KATEGORI</small><strong>{{ $jenis->kategori }}</strong></div>
    <div class="detail-item"><small>HARGA SAAT INI</small><strong>Rp {{ number_format($jenis->harga_per_kg,0,',','.') }} / {{ $jenis->satuan }}</strong></div>
    <div class="detail-item"><small>DITAMBAHKAN</small><strong>{{ $jenis->created_at?->format('d M Y') }}</strong></div>
</div></div>
<div class="panel">
    <div class="panel-title"><h3>Riwayat harga</h3><p>Setiap perubahan harga tercatat beserta waktunya.</p></div>
    <div class="table-scroll"><table>
        <thead><tr><th>WAKTU</th><th>HARGA LAMA</th><th>HARGA BARU</th><th>DIUBAH OLEH</th></tr></thead>
        <tbody>
        @forelse($riwayat as $r)
        <tr>
            <td>{{ $r->diubah_pada?->format('d M Y H:i') }}</td>
            <td>{{ $r->harga_lama === null ? '— (harga awal)' : 'Rp '.number_format($r->harga_lama,0,',','.') }}</td>
            <td><strong class="{{ $r->harga_lama !== null ? ((float)$r->harga_baru > (float)$r->harga_lama ? 'price-down' : 'price-up') : '' }}">Rp {{ number_format($r->harga_baru,0,',','.') }}</strong></td>
            <td>{{ $r->diubah_oleh ? 'User #'.$r->diubah_oleh : '—' }}</td>
        </tr>
        @empty
        <tr><td colspan="4" class="empty-table">Belum ada riwayat harga.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
@endsection


@extends('layouts.admin')

@section('title', 'Detail Promo')
@section('breadcrumb', 'Detail Promo')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-04 · KELOLA PROMO</div>
        <h1>Detail Promo</h1>
        <p>Informasi lengkap promo dan bonus harga.</p>
    </div>

    <a href="{{ route('admin.promo.index') }}" class="btn btn-outline">
        Kembali
    </a>
</div>

<div class="panel">
    <div class="data-toolbar">
        <div>
            <h3>{{ $promo->nama }}</h3>
            <p>Informasi promo EcoBank</p>
        </div>

        <a href="{{ route('admin.promo.edit', $promo) }}"
           class="btn btn-primary">
            Edit Promo
        </a>
    </div>

    <div class="table-scroll">
        <table>
            <tbody>
                <tr>
                    <th>Nama Promo</th>
                    <td>{{ $promo->nama }}</td>
                </tr>

                <tr>
                    <th>Jenis Sampah</th>
                    <td>{{ $promo->jenisSampah->nama_jenis ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Tipe Bonus</th>
                    <td>
                        {{ $promo->tipe_bonus === 'persen' ? 'Persentase (%)' : 'Rupiah (Rp)' }}
                    </td>
                </tr>

                <tr>
                    <th>Nilai Bonus</th>
                    <td>
                        @if($promo->tipe_bonus === 'persen')
                            {{ number_format((float) $promo->nilai_bonus, 2, ',', '.') }}%
                        @else
                            Rp {{ number_format((float) $promo->nilai_bonus, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ $promo->tgl_mulai->format('d F Y') }}</td>
                </tr>

                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ $promo->tgl_selesai->format('d F Y') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

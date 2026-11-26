
@extends('layouts.admin')

@section('title', 'Kelola Promo')
@section('breadcrumb', 'Kelola Promo')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-04 · KELOLA PROMO</div>
        <h1>Kelola Promo</h1>
        <p>Kelola promo dan bonus harga untuk jenis sampah.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.promo.create') }}">
        + Tambah Promo
    </a>
</div>

@if(session('success'))
    <div class="flash success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="flash error">{{ session('error') }}</div>
@endif

<div class="panel">
    <div class="data-toolbar">
        <div>
            <h3>Daftar Promo</h3>
            <p>{{ $promos->total() }} promo terdaftar</p>
        </div>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>NAMA PROMO</th>
                    <th>JENIS SAMPAH</th>
                    <th>TIPE BONUS</th>
                    <th>NILAI BONUS</th>
                    <th>PERIODE PROMO</th>
                    <th class="align-right">AKSI</th>
                </tr>
            </thead>

            <tbody>
                @forelse($promos as $item)
                <tr>
                    <td><strong>{{ $item->nama }}</strong></td>

                    <td>{{ $item->jenisSampah->nama_jenis ?? '-' }}</td>

                    <td>
                        {{ $item->tipe_bonus === 'persen' ? 'Persentase' : 'Rupiah' }}
                    </td>

                    <td>
                        <strong>
                            @if($item->tipe_bonus === 'persen')
                                {{ number_format((float) $item->nilai_bonus, 2, ',', '.') }}%
                            @else
                                Rp {{ number_format((float) $item->nilai_bonus, 0, ',', '.') }}
                            @endif
                        </strong>
                    </td>

                    <td>
                        {{ $item->tgl_mulai->format('d/m/Y') }}
                        -
                        {{ $item->tgl_selesai->format('d/m/Y') }}
                    </td>

                    <td>
                        <div class="row-actions">
                            <a class="action-btn"
                               href="{{ route('admin.promo.show', $item) }}">
                                Detail
                            </a>

                            <a class="action-btn"
                               href="{{ route('admin.promo.edit', $item) }}">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.promo.destroy', $item) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus promo ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="action-btn delete">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-table">
                        Belum ada data promo.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-bottom">
        {{ $promos->links() }}
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', $pageTitle ?? 'Halaman')
@section('breadcrumb', $pageTitle ?? 'Halaman')
@section('content')
<div class="page-heading"><div><div class="eyebrow">ECObank</div><h1>{{ $pageTitle ?? 'Halaman' }}</h1><p>Halaman ini berada di luar cakupan fitur F-01 dan F-10.</p></div></div>
<div class="panel empty-state"><div class="empty-icon">◷</div><h3>Halaman dalam pengembangan</h3><p>Fokus implementasi saat ini adalah Dashboard Admin dan Kelola Akun Pengguna.</p><a class="btn btn-primary" href="{{ route('admin.dashboard') }}">Kembali ke dashboard</a></div>
@endsection

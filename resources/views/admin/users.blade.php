@extends('layouts.admin')
@section('title', 'Kelola Pengguna')
@section('breadcrumb', 'Kelola Pengguna')
@section('content')
<div class="page-heading">
    <div><div class="eyebrow">MANAJEMEN AKUN</div><h1>Kelola Pengguna</h1><p>Kelola akun dan atur hak akses pengguna EcoBank.</p></div>
    <button class="btn btn-primary" id="addUserBtn">＋ Tambah pengguna</button>
</div>
<div class="user-stats">
    <div class="mini-stat"><span class="mini-stat-icon green">♙</span><div><small>Total pengguna</small><strong id="countAll">10</strong></div></div>
    <div class="mini-stat"><span class="mini-stat-icon blue">✓</span><div><small>Akun aktif</small><strong id="countActive">9</strong></div></div>
    <div class="mini-stat"><span class="mini-stat-icon gray">Ⅱ</span><div><small>Akun nonaktif</small><strong id="countInactive">1</strong></div></div>
    <div class="mini-stat"><span class="mini-stat-icon purple">♧</span><div><small>Administrator</small><strong id="countAdmin">2</strong></div></div>
</div>
<div class="panel users-panel">
    <div class="users-toolbar"><div><h3>Daftar pengguna</h3><p>Informasi seluruh akun yang terdaftar</p></div><div class="user-filters"><div class="search-box"><span>⌕</span><input id="userSearch" type="search" placeholder="Cari nama atau email..."></div><select id="roleFilter"><option value="">Semua peran</option><option>Admin</option><option>Petugas</option><option>Nasabah</option></select><select id="statusFilter"><option value="">Semua status</option><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select></div></div>
    <div class="table-scroll"><table><thead><tr><th>PENGGUNA</th><th>PERAN</th><th>TANGGAL BERGABUNG</th><th>STATUS</th><th class="align-right">AKSI</th></tr></thead><tbody id="userTableBody"></tbody></table></div>
    <div class="table-bottom"><span id="userCountLabel">Menampilkan 10 pengguna</span><span>Data contoh untuk demonstrasi UI</span></div>
</div>

<div class="modal-backdrop" id="userModal" aria-hidden="true">
    <div class="modal-card"><div class="modal-head"><div><h2 id="modalTitle">Tambah pengguna</h2><p>Lengkapi informasi akun pengguna di bawah ini.</p></div><button class="modal-close" data-close="userModal">×</button></div>
    <form id="userForm"><input type="hidden" id="editUserId"><div class="form-grid"><label class="form-field full">Nama lengkap<input id="userName" required maxlength="80" placeholder="Masukkan nama lengkap"></label><label class="form-field full">Email<input id="userEmail" type="email" required placeholder="nama@email.com"></label><label class="form-field">Peran<select id="userRole" required><option value="Nasabah">Nasabah</option><option value="Petugas">Petugas</option><option value="Admin">Admin</option></select></label><label class="form-field">Status<select id="userStatus"><option>Aktif</option><option>Nonaktif</option></select></label><label class="form-field" id="passwordField">Password<input id="userPassword" type="password" minlength="6" placeholder="Minimal 6 karakter"></label><label class="form-field" id="confirmField">Konfirmasi password<input id="userConfirm" type="password" minlength="6" placeholder="Ulangi password"></label></div><div class="form-note" id="formNote">Password minimal 6 karakter. Data disimpan sementara di browser.</div><div class="modal-actions"><button type="button" class="btn btn-outline" data-close="userModal">Batal</button><button type="submit" class="btn btn-primary">Simpan pengguna</button></div></form>
    </div>
</div>
<div class="modal-backdrop" id="confirmModal" aria-hidden="true"><div class="modal-card confirm-card"><div class="confirm-symbol">!</div><h2 id="confirmTitle">Ubah status akun?</h2><p id="confirmText">Akun akan dinonaktifkan.</p><div class="modal-actions"><button class="btn btn-outline" data-close="confirmModal">Batal</button><button class="btn btn-danger" id="confirmAction">Ya, lanjutkan</button></div></div></div>
@endsection
@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initUsers());</script>
@endpush

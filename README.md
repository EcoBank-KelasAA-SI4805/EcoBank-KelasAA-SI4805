# EcoBank — Laravel UI F-01 & F-10

Paket ini berisi implementasi UI untuk tugas Hasbi berdasarkan proposal PPL Kelompok A SI4805:
- **F-01 Kelola Akun Pengguna (FR-03)**: tambah akun nasabah/petugas/admin, daftar & pencarian/filter, edit data/peran, aktif/nonaktif.
- **F-10 Dashboard Admin (FR-20)**: kartu ringkasan total sampah/jumlah setoran/perputaran saldo, grafik sampah per jenis, total setoran vs penarikan, filter periode.

## Catatan cakupan
UI menggunakan dummy data dan JavaScript di browser. Belum ada penyimpanan database, backend CRUD, atau autentikasi sungguhan. Perubahan akun akan hilang ketika halaman di-refresh.

## Menjalankan project

Persyaratan: PHP 8.2+, Composer, Node.js + npm.

1. Ekstrak folder ini.
2. Buka terminal pada folder `EcoBank_Laravel_Hasbi`.
3. Jalankan:

```bash
composer install
copy .env.example .env
php artisan key:generate
npm install
php artisan serve
```

4. Buka `http://127.0.0.1:8000`.

Halaman:
- Dashboard: `http://127.0.0.1:8000/admin/dashboard`
- Kelola pengguna: `http://127.0.0.1:8000/admin/users`

Asset CSS dan JavaScript sudah tersedia di `public/css` dan `public/js`, jadi Vite tidak diperlukan untuk UI ini.

## Struktur penting

```text
routes/web.php
resources/views/layouts/admin.blade.php
resources/views/admin/dashboard.blade.php
resources/views/admin/users.blade.php
resources/views/admin/placeholder.blade.php
public/css/ecobank.css
public/js/ecobank.js
```

## Uji manual

### Dashboard
- Ubah pilihan periode: kartu ringkasan ikut berubah.
- Pilih tanggal awal dan akhir lalu tekan Terapkan.
- Pastikan grafik komposisi sampah dan perputaran saldo tampil.

### Kelola pengguna
- Tambahkan akun baru dengan email unik.
- Coba gunakan email yang sudah ada: harus ditolak.
- Edit nama, email, role, dan status.
- Cari nama/email.
- Filter role dan status.
- Nonaktifkan lalu aktifkan kembali akun melalui tombol aksi.

## Catatan
Nilai transaksi, nama pengguna, dan statistik merupakan data contoh untuk demonstrasi UI, bukan data operasional bank sampah.

# SIPER — Sistem Informasi Peminjaman Buku Perpustakaan

Aplikasi praktikum P11 berbasis PHP Native, MySQL, dan Laragon.

## Kebutuhan
- Laragon dengan Apache dan MySQL/MariaDB aktif
- PHP 8.1+ (PDO MySQL)
- Browser

## Instalasi
1. Ekstrak folder `SIPER_Perpus` ke `C:\laragon\www\`.
2. Jalankan Laragon, klik **Start All**.
3. Buka HeidiSQL atau phpMyAdmin.
4. Import file `database/siper_perpus.sql`.
5. Periksa `config/database.php`: host `127.0.0.1`, database `siper_perpus`, user `root`, password kosong (sesuaikan jika Laragon Anda berbeda).
6. Buka `http://localhost/SIPER_Perpus/login.php`.

## Akun demo
Semua password: `password`
- admin / password — ADMIN
- petugas / password — PETUGAS
- anggota / password — ANGGOTA

## Alur demo 5–7 menit
1. Login sebagai admin, tampilkan katalog buku dan tambah satu buku.
2. Logout, login sebagai petugas, tambah anggota.
3. Buat peminjaman buku untuk anggota tersebut.
4. Tunjukkan stok buku berkurang dan transaksi muncul di daftar.
5. Proses pengembalian, tunjukkan stok kembali bertambah.
6. Buka laporan dan tunjukkan relasi anggota, buku, petugas, dan status.
7. Login sebagai anggota dan tunjukkan riwayat miliknya.
8. Tunjukkan validasi gagal dan percobaan akses URL yang tidak berhak.

## Struktur
- `config/` koneksi database
- `includes/` autentikasi, validasi dasar, escaping, CSRF, layout
- `books/` daftar, form, proses simpan buku
- `members/` daftar, form, proses simpan anggota
- `loans/` daftar, form, simpan transaksi, pengembalian
- `reports/` laporan transaksi
- `database/` skema dan data dummy
- `docs/` analisis, ERD, test case, bug log

## Catatan keamanan dan ruang lingkup
- Query dinamis menggunakan PDO prepared statement.
- Output database ditampilkan melalui `htmlspecialchars`.
- Otorisasi diperiksa di file proses, bukan hanya menyembunyikan menu.
- Form POST memakai token CSRF.
- Transaksi peminjaman/pengembalian menggunakan database transaction dan penguncian baris stok.
- Versi tugas ini memakai satu detail buku per transaksi agar alur integrasi mudah didemonstrasikan. Struktur `loan_details` tetap mendukung relasi transaksi-buku.
- Setelah berhasil diuji di komputer sendiri, isi kolom hasil aktual dan status pada dokumen testing. Jangan mengisi lulus sebelum benar-benar mencoba.

## Troubleshooting
- `Access denied`: sesuaikan user/password MySQL di `config/database.php`.
- `Unknown database`: import SQL terlebih dahulu.
- 404: pastikan folder berada di `C:\laragon\www\SIPER_Perpus`.
- Login gagal: import ulang SQL, pastikan hash akun demo utuh.
- Jika nama folder diubah, sesuaikan base URL `/SIPER_Perpus` pada `includes/header.php` dan `includes/auth.php`.


Catatan perbaikan: versi ini mendeteksi otomatis nama folder aplikasi di Laragon, sehingga folder boleh dinamai sesuai NIM/nama tanpa merusak tautan CSS dan menu. Jika memakai database lama yang berisi tabel proyek lain, buat database baru bernama `siper_perpus` sebelum mengimpor SQL.

# Matriks Test Case SIPER

Isi kolom hasil aktual dan status setelah pengujian manual. Status awal sengaja `BELUM DIUJI`.

| ID | Skenario / langkah dan data uji | Jenis | Hasil yang diharapkan | Hasil aktual | Status |
|---|---|---|---|---|---|
| T01 | Login admin dengan password benar | Positif | Dashboard admin terbuka | Belum diuji | BELUM DIUJI |
| T02 | Login dengan password salah | Negatif | Login ditolak tanpa membocorkan password | Belum diuji | BELUM DIUJI |
| T03 | Admin membuka form tambah buku dan menyimpan data valid | Positif | Buku tersimpan dan tampil di katalog | Belum diuji | BELUM DIUJI |
| T04 | Petugas mencoba membuka `/books/form.php` | Otorisasi negatif | Server menolak dengan HTTP 403 | Belum diuji | BELUM DIUJI |
| T05 | Tambah anggota dengan nama kosong melalui manipulasi request | Validasi negatif | Data ditolak backend | Belum diuji | BELUM DIUJI |
| T06 | Tambah anggota dengan email `abc` | Validasi negatif | Data ditolak | Belum diuji | BELUM DIUJI |
| T07 | Tambah buku dengan stok -1 atau 10001 | Batas nilai | Data ditolak backend | Belum diuji | BELUM DIUJI |
| T08 | Peminjaman dengan jumlah 0 atau 6 | Batas nilai | Transaksi ditolak | Belum diuji | BELUM DIUJI |
| T09 | Jatuh tempo sama/sebelum tanggal pinjam | Negatif/batas | Transaksi ditolak | Belum diuji | BELUM DIUJI |
| T10 | Pinjam jumlah lebih besar dari stok | Aturan bisnis | Transaksi ditolak, stok tetap | Belum diuji | BELUM DIUJI |
| T11 | Peminjaman valid | Integrasi | Data loans dan loan_details masuk, stok berkurang | Belum diuji | BELUM DIUJI |
| T12 | Kembalikan transaksi aktif | Integrasi | Status berubah dan stok bertambah | Belum diuji | BELUM DIUJI |
| T13 | Klik pengembalian dua kali | Negatif/regresi | Stok tidak bertambah dua kali | Belum diuji | BELUM DIUJI |
| T14 | Anggota membuka URL laporan | Otorisasi negatif | Server menolak dengan HTTP 403 | Belum diuji | BELUM DIUJI |
| T15 | Login sebagai anggota dan buka riwayat | Integrasi/role | Hanya riwayat akun anggota tersebut tampil | Belum diuji | BELUM DIUJI |
| T16 | Masukkan teks `<script>alert(1)</script>` pada nama anggota | Keamanan | Teks tampil sebagai teks, tidak dieksekusi | Belum diuji | BELUM DIUJI |

## Bukti pengujian
Ambil screenshot setiap skenario penting. Tempelkan di laporan dengan format:
- Screenshot Txx — [nama skenario]
- Hasil yang terlihat: [...]
- Kesimpulan: LULUS/GAGAL

Jangan mengubah status menjadi LULUS sebelum pengujian benar-benar dijalankan.

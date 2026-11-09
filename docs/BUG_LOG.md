# Bug Log dan Regression Testing

Catat minimal dua bug yang benar-benar ditemukan ketika menjalankan aplikasi. Contoh di bawah adalah skenario latihan untuk direproduksi, bukan klaim bahwa bug sudah ditemukan.

## Template pencatatan
| ID | Gejala | Langkah reproduksi | Akar masalah (setelah dibuktikan) | Perbaikan | Tes ulang |
|---|---|---|---|---|---|
| BUG-01 | Isi setelah ditemukan | Isi langkah nyata | Isi hasil diagnosis | Isi perubahan kode | ID test dan hasil |
| BUG-02 | Isi setelah ditemukan | Isi langkah nyata | Isi hasil diagnosis | Isi perubahan kode | ID test dan hasil |

## Skenario bug latihan yang dapat dicoba
### BUG-01 — Stok tidak konsisten ketika jumlah pinjam melebihi stok
- Reproduksi: coba pinjam buku yang stoknya 2 dengan jumlah 3.
- Gejala yang diharapkan pada sistem yang benar: transaksi ditolak dan stok tetap 2.
- Pemeriksaan: lihat validasi stok pada `loans/save.php`, query `SELECT ... FOR UPDATE`, dan update bersyarat.
- Bukti perbaikan: jalankan T10, catat stok sebelum dan sesudah.

### BUG-02 — Pengembalian ganda menambah stok dua kali
- Reproduksi: kembalikan satu transaksi, lalu kirim ulang POST pengembalian dengan ID transaksi yang sama.
- Gejala yang diharapkan pada sistem yang benar: permintaan kedua ditolak karena status sudah DIKEMBALIKAN.
- Pemeriksaan: kondisi status di `loans/return.php` dan update bersyarat `WHERE status='DIPINJAM'`.
- Bukti perbaikan: jalankan T12 dan T13, bandingkan stok sebelum dan sesudah.

## Regression testing
Setelah perubahan kode, ulangi:
- T03 untuk memastikan katalog dan penambahan buku tetap berjalan.
- T11 untuk memastikan transaksi peminjaman masih mengurangi stok.
- T12 dan T13 untuk memastikan pengembalian dan perlindungan pengembalian ganda.
- T15 untuk memastikan pembatasan riwayat anggota tidak rusak.
Catat hasil aktual dan lampirkan screenshot.

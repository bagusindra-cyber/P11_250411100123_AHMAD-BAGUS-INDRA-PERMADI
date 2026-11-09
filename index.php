<?php
require_once __DIR__ . '/includes/bootstrap.php';
requireLogin();
$pageTitle='Dashboard';
$user=currentUser();
$user['role'] = strtoupper((string)($user['role'] ?? ''));
$user['id'] = (int)($user['id'] ?? 0);
$books = 0; $members = 0; $loans = 0;
if (in_array($user['role'], ['ADMIN', 'PETUGAS'], true)) {
    $books=(int)$pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
    $members=(int)$pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
    $loans=(int)$pdo->query("SELECT COUNT(*) FROM loans WHERE status='DIPINJAM'")->fetchColumn();
} else {
    $stmt=$pdo->prepare("SELECT COUNT(*) FROM loans l JOIN members m ON m.id=l.member_id WHERE m.user_id=:uid AND l.status='DIPINJAM'");
    $stmt->execute([':uid'=>$user['id']]); $loans=(int)$stmt->fetchColumn();
}
require __DIR__ . '/includes/header.php';
?>
<section class="hero"><h1>Selamat datang di SIPER</h1><p>Sistem Informasi Peminjaman Buku Perpustakaan. Gunakan menu untuk menjalankan alur pengelolaan buku dan transaksi.</p></section>
<div class="grid">
<?php if($user['role']!=='ANGGOTA'): ?>
<div class="stat"><span>Total buku</span><strong><?= $books ?></strong></div>
<div class="stat"><span>Total anggota</span><strong><?= $members ?></strong></div>
<?php endif; ?>
<div class="stat"><span>Peminjaman aktif<?= $user['role']==='ANGGOTA'?' saya':'' ?></span><strong><?= $loans ?></strong></div>
</div>
<section class="panel"><h2>Alur demo utama</h2><ol><li>Petugas menambahkan anggota.</li><li>Admin memastikan buku dan stok tersedia.</li><li>Petugas membuat transaksi peminjaman.</li><li>Stok buku berkurang dan transaksi muncul pada daftar.</li><li>Petugas memproses pengembalian sehingga stok bertambah.</li><li>Periksa laporan untuk memastikan data terintegrasi.</li></ol></section>
<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireRole(['ADMIN','PETUGAS']);
$members=$pdo->query("SELECT m.*,u.username FROM members m LEFT JOIN users u ON u.id=m.user_id ORDER BY m.name")->fetchAll();
$pageTitle='Data Anggota'; require __DIR__ . '/../includes/header.php';
?>
<div class="panel"><div class="actions"><h1 style="flex:1">Data Anggota</h1><a class="btn" href="form.php">Tambah Anggota</a></div>
<div class="table-wrap"><table><tr><th>Kode</th><th>Nama</th><th>Email</th><th>Telepon</th><th>Akun</th></tr>
<?php foreach($members as $m): ?><tr><td><?= e($m['member_code']) ?></td><td><?= e($m['name']) ?></td><td><?= e($m['email']) ?></td><td><?= e($m['phone']) ?></td><td><?= e($m['username']??'-') ?></td></tr><?php endforeach; ?>
<?php if(!$members): ?><tr><td colspan="5">Belum ada anggota.</td></tr><?php endif; ?></table></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>

<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireRole(['ADMIN','PETUGAS']);
$summary=$pdo->query("SELECT status,COUNT(*) total FROM loans GROUP BY status")->fetchAll();
$rows=$pdo->query("SELECT l.loan_code,m.name member_name,b.title,l.loan_date,l.due_date,l.status,u.name officer
 FROM loans l JOIN members m ON m.id=l.member_id JOIN users u ON u.id=l.user_id
 JOIN loan_details d ON d.loan_id=l.id JOIN books b ON b.id=d.book_id ORDER BY l.id DESC")->fetchAll();
$pageTitle='Laporan';require __DIR__ . '/../includes/header.php';
?>
<div class="panel"><h1>Laporan Peminjaman</h1><div class="grid"><?php foreach($summary as $s): ?><div class="stat"><span><?= e($s['status']) ?></span><strong><?= (int)$s['total'] ?></strong></div><?php endforeach; ?></div></div>
<div class="panel"><h2>Rincian transaksi</h2><div class="table-wrap"><table><tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Tanggal</th><th>Jatuh tempo</th><th>Petugas</th><th>Status</th></tr>
<?php foreach($rows as $r): ?><tr><td><?= e($r['loan_code']) ?></td><td><?= e($r['member_name']) ?></td><td><?= e($r['title']) ?></td><td><?= e($r['loan_date']) ?></td><td><?= e($r['due_date']) ?></td><td><?= e($r['officer']) ?></td><td><?= e($r['status']) ?></td></tr><?php endforeach; ?>
<?php if(!$rows): ?><tr><td colspan="7">Belum ada data.</td></tr><?php endif; ?></table></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>

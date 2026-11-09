<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireRole(['ADMIN','PETUGAS']);
$sql="SELECT l.id,l.loan_code,l.loan_date,l.due_date,l.status,m.name member_name,u.name officer,
             GROUP_CONCAT(CONCAT(b.title,' (',ld.quantity,')') SEPARATOR ', ') books
      FROM loans l JOIN members m ON m.id=l.member_id JOIN users u ON u.id=l.user_id
      JOIN loan_details ld ON ld.loan_id=l.id JOIN books b ON b.id=ld.book_id
      GROUP BY l.id ORDER BY l.id DESC";
$loans=$pdo->query($sql)->fetchAll();
$pageTitle='Peminjaman'; require __DIR__ . '/../includes/header.php';
?>
<div class="panel"><div class="actions"><h1 style="flex:1">Transaksi Peminjaman</h1><a class="btn" href="form.php">Buat Peminjaman</a></div>
<div class="table-wrap"><table><tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Tanggal</th><th>Jatuh tempo</th><th>Petugas</th><th>Status</th><th>Aksi</th></tr>
<?php foreach($loans as $l): ?><tr><td><?= e($l['loan_code']) ?></td><td><?= e($l['member_name']) ?></td><td><?= e($l['books']) ?></td><td><?= e($l['loan_date']) ?></td><td><?= e($l['due_date']) ?></td><td><?= e($l['officer']) ?></td><td><span class="badge"><?= e($l['status']) ?></span></td><td>
<?php if($l['status']==='DIPINJAM'): ?><form class="inline" method="post" action="return.php" data-confirm="Proses pengembalian buku ini?"><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><input type="hidden" name="loan_id" value="<?= (int)$l['id'] ?>"><button class="btn secondary">Kembalikan</button></form><?php endif; ?>
</td></tr><?php endforeach; ?>
<?php if(!$loans): ?><tr><td colspan="8">Belum ada transaksi.</td></tr><?php endif; ?></table></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>

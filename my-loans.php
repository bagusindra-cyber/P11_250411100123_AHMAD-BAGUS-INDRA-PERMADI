<?php
require_once __DIR__ . '/includes/bootstrap.php';

requireRole(['ANGGOTA']);

$stmt = $pdo->prepare(
    "SELECT l.loan_code, l.loan_date, l.due_date, l.status,
            GROUP_CONCAT(CONCAT(b.title, ' (', d.quantity, ')') SEPARATOR ', ') AS books
     FROM loans l
     JOIN members m ON m.id = l.member_id
     JOIN loan_details d ON d.loan_id = l.id
     JOIN books b ON b.id = d.book_id
     WHERE m.user_id = :uid
     GROUP BY l.id
     ORDER BY l.id DESC"
);
$stmt->execute([':uid' => currentUser()['id']]);
$rows = $stmt->fetchAll();

$pageTitle = 'Peminjaman Saya';
require __DIR__ . '/includes/header.php';
?>
<div class="panel">
    <h1>Riwayat Peminjaman Saya</h1>
    <div class="table-wrap">
        <table>
            <tr>
                <th>Kode</th>
                <th>Buku</th>
                <th>Tanggal pinjam</th>
                <th>Jatuh tempo</th>
                <th>Status</th>
            </tr>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= e($row['loan_code']) ?></td>
                    <td><?= e($row['books']) ?></td>
                    <td><?= e($row['loan_date']) ?></td>
                    <td><?= e($row['due_date']) ?></td>
                    <td><?= e($row['status']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$rows): ?>
                <tr>
                    <td colspan="5">Belum ada riwayat peminjaman.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require_once __DIR__ . '/../includes/bootstrap.php';

requireRole(['ADMIN','PETUGAS']);

$members = $pdo->query(
    'SELECT m.*, u.username
     FROM members m
     LEFT JOIN users u ON u.id = m.user_id
     ORDER BY m.name'
)->fetchAll();
$pageTitle = 'Data Anggota';
require __DIR__ . '/../includes/header.php';
?>
<div class="panel">
    <div class="actions">
        <h1 style="flex: 1">Data Anggota</h1>
        <a class="btn" href="form.php">Tambah Anggota</a>
    </div>

    <div class="table-wrap">
        <table>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Akun</th>
            </tr>
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?= e($member['member_code']) ?></td>
                    <td><?= e($member['name']) ?></td>
                    <td><?= e($member['email']) ?></td>
                    <td><?= e($member['phone']) ?></td>
                    <td><?= e($member['username'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$members): ?>
                <tr>
                    <td colspan="5">Belum ada anggota.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

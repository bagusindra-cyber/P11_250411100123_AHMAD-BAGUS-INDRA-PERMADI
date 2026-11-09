<?php
require_once __DIR__ . '/../includes/bootstrap.php';

requireLogin();

$books = $pdo->query(
    'SELECT b.*, c.name AS category
     FROM books b
     JOIN categories c ON c.id = b.category_id
     ORDER BY b.title'
)->fetchAll();
$pageTitle = 'Daftar Buku';
require __DIR__ . '/../includes/header.php';
?>
<div class="panel">
    <div class="actions">
        <h1 style="flex: 1">Daftar Buku</h1>
        <?php if (currentUser()['role'] === 'ADMIN'): ?>
            <a class="btn" href="form.php">Tambah Buku</a>
        <?php endif; ?>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= e($book['isbn']) ?></td>
                        <td><?= e($book['title']) ?></td>
                        <td><?= e($book['category']) ?></td>
                        <td><?= e($book['author']) ?></td>
                        <td><?= (int) $book['stock'] ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$books): ?>
                    <tr>
                        <td colspan="5">Belum ada buku.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

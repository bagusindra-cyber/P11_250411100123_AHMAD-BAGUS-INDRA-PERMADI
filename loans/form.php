<?php
require_once __DIR__ . '/../includes/bootstrap.php';

requireRole(['ADMIN','PETUGAS']);

$members = $pdo->query('SELECT id, member_code, name FROM members ORDER BY name')->fetchAll();
$books = $pdo->query('SELECT id, title, stock FROM books WHERE stock > 0 ORDER BY title')->fetchAll();
$pageTitle = 'Form Peminjaman';
require __DIR__ . '/../includes/header.php';
?>
<div class="panel">
    <h1>Buat Peminjaman</h1>
    <p class="muted">Stok akan dikurangi setelah transaksi berhasil disimpan.</p>

    <form method="post" action="save.php">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">

        <label>Anggota</label>
        <select name="member_id" required>
            <option value="">Pilih anggota</option>
            <?php foreach ($members as $member): ?>
                <option value="<?= (int) $member['id'] ?>">
                    <?= e($member['member_code'] . ' - ' . $member['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Buku</label>
        <select name="book_id" required>
            <?php foreach ($books as $book): ?>
                <option value="<?= (int) $book['id'] ?>">
                    <?= e($book['title'] . ' (stok ' . $book['stock'] . ')') ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Jumlah</label>
        <input type="number" name="quantity" min="1" max="5" value="1" required>

        <label>Tanggal pinjam</label>
        <input type="date" name="loan_date" value="<?= e(date('Y-m-d')) ?>" required>

        <label>Tanggal jatuh tempo</label>
        <input type="date" name="due_date" value="<?= e(date('Y-m-d', strtotime('+7 days'))) ?>" required>

        <button>Simpan Peminjaman</button>
        <a class="btn secondary" href="index.php">Batal</a>
    </form>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

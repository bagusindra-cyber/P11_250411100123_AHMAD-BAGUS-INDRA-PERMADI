<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireRole(['ADMIN']);
$categories=$pdo->query("SELECT id,name FROM categories ORDER BY name")->fetchAll();
$pageTitle='Tambah Buku'; require __DIR__ . '/../includes/header.php';
?>
<div class="panel"><h1>Tambah Buku</h1>
<form method="post" action="save.php">
<input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
<label>ISBN</label><input name="isbn" required maxlength="20">
<label>Judul</label><input name="title" required maxlength="180">
<label>Penulis</label><input name="author" required maxlength="120">
<label>Kategori</label><select name="category_id" required><option value="">Pilih kategori</option><?php foreach($categories as $c): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?></select>
<label>Stok</label><input type="number" name="stock" min="0" max="10000" required>
<button>Simpan Buku</button> <a class="btn secondary" href="index.php">Batal</a>
</form></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>

<?php
require_once __DIR__ . '/../includes/bootstrap.php';

requireRole(['ADMIN','PETUGAS']);

$pageTitle = 'Tambah Anggota';
require __DIR__ . '/../includes/header.php';
?>
<div class="panel">
    <h1>Tambah Anggota</h1>
    <form method="post" action="save.php">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">

        <label>Kode anggota</label>
        <input name="member_code" required maxlength="20">

        <label>Nama lengkap</label>
        <input name="name" required maxlength="120">

        <label>Email (opsional)</label>
        <input type="email" name="email" maxlength="120">

        <label>Nomor telepon (opsional)</label>
        <input name="phone" maxlength="25">

        <button>Simpan Anggota</button>
        <a class="btn secondary" href="index.php">Batal</a>
    </form>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

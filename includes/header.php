<?php
$pageTitle = $pageTitle ?? 'SIPER';
$user = currentUser();
$displayName = $user['name'] ?? $user['username'] ?? 'Pengguna';
$userRole = strtoupper((string)($user['role'] ?? ''));
$base = BASE_URL;
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?> - SIPER</title>
<link rel="stylesheet" href="<?= e($base) ?>/assets/css/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="<?= e($base) ?>/index.php">SIPER</a>
  <?php if ($user): ?>
  <nav>
    <a href="<?= e($base) ?>/index.php">Dashboard</a>
    <a href="<?= e($base) ?>/books/index.php">Buku</a>
    <?php if (in_array($userRole, ['ADMIN','PETUGAS'], true)): ?>
      <a href="<?= e($base) ?>/members/index.php">Anggota</a>
      <a href="<?= e($base) ?>/loans/index.php">Peminjaman</a>
    <?php else: ?>
      <a href="<?= e($base) ?>/my-loans.php">Peminjaman Saya</a>
    <?php endif; ?>
    <?php if (in_array($userRole, ['ADMIN','PETUGAS'], true)): ?>
      <a href="<?= e($base) ?>/reports/index.php">Laporan</a>
    <?php endif; ?>
    <a href="<?= e($base) ?>/logout.php">Keluar</a>
  </nav>
  <span class="user-chip"><?= e($displayName) ?> · <?= e($userRole) ?></span>
  <?php endif; ?>
</header>
<main class="container">
<?php $notice = getFlash(); if ($notice): ?>
<div class="alert <?= e($notice['type']) ?>"><?= e($notice['message']) ?></div>
<?php endif; ?>

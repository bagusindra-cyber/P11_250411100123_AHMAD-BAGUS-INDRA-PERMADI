<?php
declare(strict_types=1);

function requireLogin(): void {
    if (empty($_SESSION['user'])) {
        flash('danger', 'Silakan login terlebih dahulu.');
        redirect(BASE_URL . '/login.php');
    }
}

function requireRole(array $roles): void {
    requireLogin();
    if (!in_array($_SESSION['user']['role'], $roles, true)) {
        http_response_code(403);
        exit('403 - Anda tidak memiliki hak akses untuk halaman ini.');
    }
}

function currentUser(): array {
    return $_SESSION['user'] ?? [];
}

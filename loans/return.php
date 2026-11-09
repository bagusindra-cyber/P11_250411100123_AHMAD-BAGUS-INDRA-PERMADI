<?php
require_once __DIR__ . '/../includes/bootstrap.php';

requireRole(['ADMIN','PETUGAS']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Metode tidak diizinkan.');
}

verifyCsrf();

$id = filter_var($_POST['loan_id'] ?? null, FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    flash('danger', 'ID transaksi tidak valid.');
    redirect('index.php');
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('SELECT id, status FROM loans WHERE id = :id FOR UPDATE');
    $stmt->execute([':id' => $id]);
    $loan = $stmt->fetch();

    if (!$loan) {
        throw new DomainException('Transaksi tidak ditemukan.');
    }

    if ($loan['status'] !== 'DIPINJAM') {
        throw new DomainException('Transaksi sudah dikembalikan atau tidak dapat diproses.');
    }

    $details = $pdo->prepare('SELECT book_id, quantity FROM loan_details WHERE loan_id = :id');
    $details->execute([':id' => $id]);

    $updateStock = $pdo->prepare('UPDATE books SET stock = stock + :qty WHERE id = :book');
    foreach ($details as $detail) {
        $updateStock->execute([
            ':qty' => $detail['quantity'],
            ':book' => $detail['book_id'],
        ]);
    }

    $updateLoan = $pdo->prepare(
        "UPDATE loans
         SET status = 'DIKEMBALIKAN', returned_at = NOW()
         WHERE id = :id AND status = 'DIPINJAM'"
    );
    $updateLoan->execute([':id' => $id]);

    if ($updateLoan->rowCount() !== 1) {
        throw new DomainException('Status transaksi berubah.');
    }

    $pdo->commit();
    flash('success', 'Buku berhasil dikembalikan dan stok diperbarui.');
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    if ($e instanceof DomainException) {
        flash('danger', $e->getMessage());
    } else {
        error_log($e->getMessage());
        flash('danger', 'Pengembalian gagal diproses.');
    }
}

redirect('index.php');

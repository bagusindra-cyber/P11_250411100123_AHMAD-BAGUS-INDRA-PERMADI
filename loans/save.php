<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireRole(['ADMIN','PETUGAS']);
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Metode tidak diizinkan.');}
verifyCsrf();
$memberId=filter_var($_POST['member_id']??null,FILTER_VALIDATE_INT);
$bookId=filter_var($_POST['book_id']??null,FILTER_VALIDATE_INT);
$qty=filter_var($_POST['quantity']??null,FILTER_VALIDATE_INT);
$loanDate=$_POST['loan_date']??''; $dueDate=$_POST['due_date']??'';
if(!$memberId||!$bookId||$qty===false||$qty<1||$qty>5||!validDate($loanDate)||!validDate($dueDate)||$dueDate<=$loanDate){
 flash('danger','Data peminjaman tidak valid. Jumlah 1–5 dan jatuh tempo harus setelah tanggal pinjam.'); redirect('form.php');
}
try{
 $pdo->beginTransaction();
 $m=$pdo->prepare("SELECT id FROM members WHERE id=:id"); $m->execute([':id'=>$memberId]);
 if(!$m->fetch()) throw new DomainException('Anggota tidak ditemukan.');
 $b=$pdo->prepare("SELECT id,stock FROM books WHERE id=:id FOR UPDATE"); $b->execute([':id'=>$bookId]); $book=$b->fetch();
 if(!$book) throw new DomainException('Buku tidak ditemukan.');
 if((int)$book['stock']<$qty) throw new DomainException('Stok buku tidak mencukupi.');
 $code='PJ-'.date('Ymd').'-'.strtoupper(bin2hex(random_bytes(2)));
 $stmt=$pdo->prepare("INSERT INTO loans(loan_code,member_id,user_id,loan_date,due_date,status) VALUES(:code,:member,:user,:loan,:due,'DIPINJAM')");
 $stmt->execute([':code'=>$code,':member'=>$memberId,':user'=>currentUser()['id'],':loan'=>$loanDate,':due'=>$dueDate]);
 $loanId=(int)$pdo->lastInsertId();
 $detail=$pdo->prepare("INSERT INTO loan_details(loan_id,book_id,quantity) VALUES(:loan,:book,:qty)");
 $detail->execute([':loan'=>$loanId,':book'=>$bookId,':qty'=>$qty]);
 $update=$pdo->prepare("UPDATE books SET stock=stock-:qty WHERE id=:id AND stock>=:qty");
 $update->execute([':qty'=>$qty,':id'=>$bookId]);
 if($update->rowCount()!==1) throw new DomainException('Stok berubah. Silakan ulangi transaksi.');
 $pdo->commit(); flash('success','Peminjaman '.$code.' berhasil disimpan.');
}catch(Throwable $e){
 if($pdo->inTransaction()) $pdo->rollBack();
 if($e instanceof DomainException) flash('danger',$e->getMessage());
 else {error_log($e->getMessage());flash('danger','Transaksi gagal diproses. Periksa log aplikasi.');}
}
redirect('index.php');

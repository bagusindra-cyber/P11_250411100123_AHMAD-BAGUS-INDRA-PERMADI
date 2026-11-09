<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireRole(['ADMIN']);
if ($_SERVER['REQUEST_METHOD']!=='POST') { http_response_code(405); exit('Metode tidak diizinkan.'); }
verifyCsrf();
$isbn=trim($_POST['isbn']??''); $title=trim($_POST['title']??''); $author=trim($_POST['author']??'');
$categoryId=filter_var($_POST['category_id']??null,FILTER_VALIDATE_INT);
$stock=filter_var($_POST['stock']??null,FILTER_VALIDATE_INT);
if($isbn===''||$title===''||$author===''||!$categoryId||$stock===false||$stock<0||$stock>10000){
    flash('danger','Data buku tidak valid. Periksa semua kolom dan batas stok 0–10000.'); redirect('form.php');
}
try {
    $stmt=$pdo->prepare("INSERT INTO books(isbn,title,author,category_id,stock) VALUES(:isbn,:title,:author,:cat,:stock)");
    $stmt->execute([':isbn'=>$isbn,':title'=>$title,':author'=>$author,':cat'=>$categoryId,':stock'=>$stock]);
    flash('success','Buku berhasil ditambahkan.');
} catch(PDOException $e) {
    error_log($e->getMessage()); flash('danger','Buku gagal disimpan. Pastikan ISBN unik dan kategori tersedia.');
}
redirect('index.php');

<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireRole(['ADMIN','PETUGAS']);
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Metode tidak diizinkan.');}
verifyCsrf();
$code=trim($_POST['member_code']??''); $name=trim($_POST['name']??''); $email=trim($_POST['email']??''); $phone=trim($_POST['phone']??'');
if($code===''||$name===''||mb_strlen($name)>120||($email!==''&&!filter_var($email,FILTER_VALIDATE_EMAIL))){
 flash('danger','Kode dan nama wajib diisi; nama maksimal 120 karakter; email harus valid.'); redirect('form.php');
}
try{
 $stmt=$pdo->prepare("INSERT INTO members(member_code,name,email,phone) VALUES(:code,:name,:email,:phone)");
 $stmt->execute([':code'=>$code,':name'=>$name,':email'=>$email?:null,':phone'=>$phone?:null]);
 flash('success','Anggota berhasil ditambahkan.');
}catch(PDOException $e){error_log($e->getMessage());flash('danger','Gagal menyimpan. Kode anggota mungkin sudah digunakan.');}
redirect('index.php');

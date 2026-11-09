CREATE DATABASE IF NOT EXISTS siper_perpus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE siper_perpus;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS loan_details;
DROP TABLE IF EXISTS loans;
DROP TABLE IF EXISTS members;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE roles (
 id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 role_id TINYINT UNSIGNED NOT NULL,
 name VARCHAR(120) NOT NULL,
 username VARCHAR(50) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 is_active TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_users_role FOREIGN KEY(role_id) REFERENCES roles(id)
) ENGINE=InnoDB;

CREATE TABLE categories (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE books (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 category_id INT UNSIGNED NOT NULL,
 isbn VARCHAR(20) NOT NULL UNIQUE,
 title VARCHAR(180) NOT NULL,
 author VARCHAR(120) NOT NULL,
 stock INT UNSIGNED NOT NULL DEFAULT 0,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_books_category FOREIGN KEY(category_id) REFERENCES categories(id)
) ENGINE=InnoDB;

CREATE TABLE members (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NULL UNIQUE,
 member_code VARCHAR(20) NOT NULL UNIQUE,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(120) NULL,
 phone VARCHAR(25) NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_members_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE loans (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 loan_code VARCHAR(30) NOT NULL UNIQUE,
 member_id INT UNSIGNED NOT NULL,
 user_id INT UNSIGNED NOT NULL,
 loan_date DATE NOT NULL,
 due_date DATE NOT NULL,
 returned_at DATETIME NULL,
 status ENUM('DIPINJAM','DIKEMBALIKAN') NOT NULL DEFAULT 'DIPINJAM',
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_loans_member FOREIGN KEY(member_id) REFERENCES members(id),
 CONSTRAINT fk_loans_user FOREIGN KEY(user_id) REFERENCES users(id),
 CONSTRAINT chk_loan_dates CHECK(due_date > loan_date)
) ENGINE=InnoDB;

CREATE TABLE loan_details (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 loan_id BIGINT UNSIGNED NOT NULL,
 book_id INT UNSIGNED NOT NULL,
 quantity SMALLINT UNSIGNED NOT NULL,
 CONSTRAINT fk_details_loan FOREIGN KEY(loan_id) REFERENCES loans(id) ON DELETE CASCADE,
 CONSTRAINT fk_details_book FOREIGN KEY(book_id) REFERENCES books(id),
 CONSTRAINT uq_loan_book UNIQUE(loan_id,book_id),
 CONSTRAINT chk_quantity CHECK(quantity BETWEEN 1 AND 5)
) ENGINE=InnoDB;

INSERT INTO roles(name) VALUES ('ADMIN'),('PETUGAS'),('ANGGOTA');

-- Password semua akun demo: password
-- Hash dibuat menggunakan password_hash('password', PASSWORD_DEFAULT).
INSERT INTO users(role_id,name,username,password_hash,is_active) VALUES
(1,'Administrator','admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',1),
(2,'Petugas Perpustakaan','petugas','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',1),
(3,'Anggota Demo','anggota','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',1);

INSERT INTO categories(name) VALUES ('Pemrograman'),('Basis Data'),('Novel'),('Jaringan Komputer');
INSERT INTO books(category_id,isbn,title,author,stock) VALUES
(1,'978000000001','Dasar Pemrograman PHP','Tim Akademik',5),
(2,'978000000002','Pengantar Basis Data','Tim Akademik',3),
(3,'978000000003','Senja di Perpustakaan','Penulis Demo',4),
(4,'978000000004','Dasar Jaringan Komputer','Tim Akademik',2);

INSERT INTO members(user_id,member_code,name,email,phone) VALUES
(3,'AGT001','Anggota Demo','anggota@example.test','081234567890'),
(NULL,'AGT002','Budi Santoso','budi@example.test','081234567891');

<?php
require_once __DIR__ . '/includes/bootstrap.php';

if (!empty($_SESSION['user'])) {
    redirect('index.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username dan password wajib diisi.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare(
            'SELECT u.id, u.name, u.username, u.password_hash, r.name AS role
             FROM users u
             JOIN roles r ON r.id = u.role_id
             WHERE u.username = :username AND u.is_active = 1
             LIMIT 1'
        );
        $stmt->execute([':username' => $username]);
        $account = $stmt->fetch();

        if ($account && password_verify($password, $account['password_hash'])) {
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'id' => $account['id'],
                'name' => $account['name'],
                'username' => $account['username'],
                'role' => $account['role'],
            ];

            flash('success', 'Login berhasil. Selamat datang, ' . $account['name'] . '.');
            redirect('index.php');
        }

        $errors[] = 'Username atau password salah.';
    }
}

$pageTitle = 'Login';
require __DIR__ . '/includes/header.php';
?>
<div class="panel login">
    <h1>Login SIPER</h1>
    <p class="muted">Masuk sesuai akun demo yang tersedia.</p>

    <?php foreach ($errors as $error): ?>
        <div class="alert danger"><?= e($error) ?></div>
    <?php endforeach; ?>

    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">

        <label>Username</label>
        <input name="username" required maxlength="50" autocomplete="username">

        <label>Password</label>
        <input type="password" name="password" required autocomplete="current-password">

        <button type="submit">Masuk</button>
    </form>

    <hr>
    <small>
        Admin: admin / password<br>
        Petugas: petugas / password<br>
        Anggota: anggota / password
    </small>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>

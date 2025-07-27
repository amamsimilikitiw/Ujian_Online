<?php
// auth/login.php

session_start(); // pastikan session dimulai di sini
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
    // Redirect berdasarkan role yang sudah login
    if ($_SESSION['user']['role'] === 'admin') {
        header('Location: ../admin/index.php');
    } elseif ($_SESSION['user']['role'] === 'siswa') {
        header('Location: ../siswa/index.php');
    }
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // Verifikasi password dengan password_hash
        $ok = password_verify($password, $user['password_hash']);

        // Fallback: verifikasi SHA256 jika data lama
        if (!$ok && hash('sha256', $password) === $user['password_hash']) {
            $ok = true;

            // Upgrade ke bcrypt jika lolos SHA256
            $newHash = password_hash($password, PASSWORD_BCRYPT);
            $update = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
            $update->execute([$newHash, $user['id']]);
        }

        if ($ok) {
            $_SESSION['user'] = [
    'id' => $user['id'],
    'username' => $user['username'],
    'fullname' => $user['fullname'], // <-- pastikan ini ada
    'role' => $user['role'],
];



            // Redirect sesuai role
            if ($user['role'] === 'admin') {
                header('Location: ../admin/index.php');
            } elseif ($user['role'] === 'siswa') {
                header('Location: ../siswa/index.php');
            } else {
                $error = 'Role tidak dikenali.';
            }
            exit;
        }
    }

    $error = 'Username atau password salah.';
}

$title = 'Login';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
    <div class="card">
        <h2>Login</h2>
        <?php if($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button class="btn btn-primary" type="submit">Masuk</button>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

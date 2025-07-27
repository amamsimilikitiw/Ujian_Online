<?php
// admin/users.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin']);

// Hapus user
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id !== (int)current_user()['id']) { // cegah hapus diri
        $stmt = $pdo->prepare('DELETE FROM users WHERE id=?');
        $stmt->execute([$id]);
    }
    header('Location: users.php');
    exit;
}

// Tambah / update user singkat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $username = trim($_POST['username']);
    $fullname = trim($_POST['fullname']);
    $role     = $_POST['role'];
    $password = $_POST['password'] ?? '';

    if ($id) {
        if ($password) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('UPDATE users SET username=?, fullname=?, role=?, password_hash=? WHERE id=?');
            $stmt->execute([$username, $fullname, $role, $hash, $id]);
        } else {
            $stmt = $pdo->prepare('UPDATE users SET username=?, fullname=?, role=? WHERE id=?');
            $stmt->execute([$username, $fullname, $role, $id]);
        }
    } else {
        $hash = password_hash($password ?: 'password123', PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO users(username,password_hash,fullname,role) VALUES (?,?,?,?)');
        $stmt->execute([$username, $hash, $fullname, $role]);
    }

    header('Location: users.php');
    exit;
}

$users = $pdo->query('SELECT * FROM users ORDER BY id DESC')->fetchAll();
$title = 'Kelola User';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
<h2>Kelola User</h2>
<div class="card">
    <form method="post">
    <input type="hidden" name="id" value="">
    <label>Username</label>
    <input type="text" name="username" required>
    <label>Nama Lengkap</label>
    <input type="text" name="fullname" required>
    <label>Role</label>
    <select name="role">
        <option value="admin">admin</option>
        <option value="siswa" selected>siswa</option>
    </select>
    <label>Password (opsional saat edit)</label>
    <input type="password" name="password">
    <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
</div>

<table class="table">
    <thead>
    <tr>
        <th>ID</th><th>Username</th><th>Nama</th><th>Role</th><th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($users as $u): ?>
        <tr>
        <td><?= $u['id'] ?></td>
        <td><?= h($u['username']) ?></td>
        <td><?= h($u['fullname']) ?></td>
        <td><?= h($u['role']) ?></td>
        <td>
            <a class="btn btn-danger" href="?delete=<?= $u['id'] ?>" onclick="return confirm('Hapus user ini?')">Hapus</a>
        </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
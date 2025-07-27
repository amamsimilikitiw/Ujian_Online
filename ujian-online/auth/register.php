<?php
// auth/register.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (is_logged_in()) {
    header('Location: ../index.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $fullname = trim($_POST['fullname'] ?? '');
    $nis      = trim($_POST['nis'] ?? '');
    $kelas    = trim($_POST['kelas'] ?? '');
    $jurusan  = trim($_POST['jurusan'] ?? '');

    if ($username === '' || $password === '' || $fullname === '') {
        $errors[] = 'Harap isi username, password, fullname.';
    }

    if (empty($errors)) {
        // cek username
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username=?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = 'Username sudah digunakan';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $pdo->beginTransaction();
            try {
                $stmt = $pdo->prepare('INSERT INTO users(username,password_hash,fullname,role) VALUES (?,?,?,\'siswa\')');
                $stmt->execute([$username, $hash, $fullname]);
                $user_id = $pdo->lastInsertId();

                $stmt = $pdo->prepare('INSERT INTO siswa(user_id, nis, kelas, jurusan) VALUES (?,?,?,?)');
                $stmt->execute([$user_id, $nis, $kelas, $jurusan]);

                $pdo->commit();
                set_flash('register_success','Registrasi berhasil. Silakan login.');
                header('Location: login.php');
                exit;
            } catch (Exception $e) {
                $pdo->rollBack();
                $errors[] = 'Terjadi kesalahan: '.$e->getMessage();
            }
        }
    }
}

$title = 'Registrasi Siswa';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
$flash = get_flash('register_success');
?>
<div class="container">
<div class="card">
    <h2>Registrasi Siswa</h2>
    <?php if($flash): ?><div class="alert alert-success"><?= h($flash['message']) ?></div><?php endif; ?>
    <?php if($errors): ?>
    <div class="alert alert-error">
        <ul>
        <?php foreach($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <form method="post">
    <label>Username</label>
    <input type="text" name="username" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <label>Nama Lengkap</label>
    <input type="text" name="fullname" required>
    <label>NIS</label>
    <input type="text" name="nis">
    <label>Kelas</label>
    <input type="text" name="kelas">
    <label>Jurusan</label>
    <input type="text" name="jurusan">
    <button class="btn btn-primary" type="submit">Daftar</button>
    </form>
</div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
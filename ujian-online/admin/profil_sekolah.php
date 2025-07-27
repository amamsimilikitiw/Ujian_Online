<?php
// admin/profil_sekolah.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('UPDATE sekolah SET nama=?, alamat=?, email=?, telp=?, deskripsi=? WHERE id=1');
    $stmt->execute([
        $_POST['nama'], $_POST['alamat'], $_POST['email'], $_POST['telp'], $_POST['deskripsi']
    ]);
    set_flash('profil','Profil sekolah disimpan');
    header('Location: profil_sekolah.php');
    exit;
}

$stmt = $pdo->query('SELECT * FROM sekolah WHERE id=1');
$data = $stmt->fetch();
$title = 'Profil Sekolah';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
$flash = get_flash('profil');
?>
<div class="container">
<h2>Profil Sekolah</h2>
<?php if($flash): ?><div class="alert alert-success"><?= h($flash['message']) ?></div><?php endif; ?>
<div class="card">
    <form method="post">
    <label>Nama</label>
    <input type="text" name="nama" value="<?= h($data['nama']) ?>" required>
    <label>Alamat</label>
    <textarea name="alamat" required><?= h($data['alamat']) ?></textarea>
    <label>Email</label>
    <input type="email" name="email" value="<?= h($data['email']) ?>" required>
    <label>Telp</label>
    <input type="text" name="telp" value="<?= h($data['telp']) ?>" required>
    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="5"><?= h($data['deskripsi']) ?></textarea>
    <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
</div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
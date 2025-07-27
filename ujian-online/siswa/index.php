<?php
// siswa/index.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['siswa']);

$title = 'Dashboard Siswa';
$user = current_user();

$stmt = $pdo->prepare('SELECT * FROM ujian_peserta WHERE user_id=? ORDER BY id DESC');
$stmt->execute([$user['id']]);
$peserta = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
<h2>Selamat datang, <?= h($user['fullname']) ?></h2>
<div class="card">
    <p><a class="btn btn-primary" href="panduan.php">Panduan Ujian</a> <a class="btn" href="ujian_list.php">Daftar Ujian</a> <a class="btn" href="hasil.php">Hasil Saya</a></p>
</div>

<h3>Ujian Saya</h3>
<table class="table">
    <thead><tr><th>Ujian</th><th>Status</th><th>Nilai</th></tr></thead>
    <tbody>
    <?php foreach($peserta as $p):
        $uj = $pdo->prepare('SELECT nama FROM ujian WHERE id=?');
        $uj->execute([$p['ujian_id']]);
        $ujn = $uj->fetch();
    ?>
    <tr>
        <td><?= h($ujn['nama']) ?></td>
        <td><?= h($p['status']) ?></td>
        <td><?= h($p['nilai']) ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
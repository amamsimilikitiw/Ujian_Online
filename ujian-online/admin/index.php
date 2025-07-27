<?php
// admin/index.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin']);
$title = 'Dashboard Admin';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$usersCount = $pdo->query('SELECT COUNT(*) as c FROM users')->fetch()['c'];
$soalCount  = $pdo->query('SELECT COUNT(*) as c FROM bank_soal')->fetch()['c'];
$ujianCount = $pdo->query('SELECT COUNT(*) as c FROM ujian')->fetch()['c'];
?>
<div class="container">
<h2>Dashboard Admin</h2>
<div class="card">
    <p>Total User: <?= $usersCount ?></p>
    <p>Total Soal: <?= $soalCount ?></p>
    <p>Total Ujian: <?= $ujianCount ?></p>
    <p>
        <br>
        <br>
    <a class="btn btn-primary" href="users.php">Kelola User</a>
    <a class="btn btn-primary" href="soal.php">Kelola Soal</a>
    <a class="btn btn-primary" href="ujian.php">Pengaturan Tes</a>
    <a class="btn btn-primary" href="hasil.php">Hasil Tes</a>
    <a class="btn btn-primary" href="profil_sekolah.php">Profil Sekolah</a>
    </p>
</div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php
// pages/profil.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$title = 'Profil Sekolah';

$stmt = $pdo->query('SELECT * FROM sekolah WHERE id=1');
$sekolah = $stmt->fetch();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<div class="container">
    <div class="card">
        <!-- Header dengan logo dan judul -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2 class="mb-2" style="margin: 0;">Profil Sekolah</h2>
        </div>

        <!-- Informasi sekolah -->
        <p><strong>Nama:</strong> <?= h($sekolah['nama']) ?></p>
        <p><strong>Alamat:</strong> <?= nl2br(h($sekolah['alamat'])) ?></p>
        <p><strong>Email:</strong> <?= h($sekolah['email']) ?></p>
        <p><strong>Telp:</strong> <?= h($sekolah['telp']) ?></p>
        <hr class="my-2"> <br>
        <p><?= nl2br(h($sekolah['deskripsi'])) ?></p>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

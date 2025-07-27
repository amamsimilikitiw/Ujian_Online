<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

require_role(['siswa']);
$user = current_user();
$title = 'Ujian Selesai';

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
    <div class="card">
        <h2>Ujian Telah Selesai</h2>
        <p>Terima kasih, <strong><?= h($user['fullname']) ?></strong>. Jawaban Anda telah dikumpulkan.</p>
        <p><a class="btn btn-primary" href="hasil.php">Lihat Hasil</a></p>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

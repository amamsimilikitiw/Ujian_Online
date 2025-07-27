<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

require_role(['siswa']);
$user = current_user();
$title = 'Hasil Ujian';

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$stmt = $pdo->prepare('
    SELECT u.nama, up.nilai, up.status, u.mulai_at, u.selesai_at 
    FROM ujian_peserta up 
    JOIN ujian u ON u.id = up.ujian_id 
    WHERE up.user_id = ? 
    ORDER BY u.mulai_at DESC
');
$stmt->execute([$user['id']]);
$hasil = $stmt->fetchAll();
?>
<div class="container">
    <h2>Hasil Ujian Saya</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Ujian</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($hasil as $h): ?>
            <tr>
                <td><?= h($h['nama']) ?></td>
                <td><?= h($h['mulai_at']) ?> s/d <?= h($h['selesai_at']) ?></td>
                <td><?= h(ucfirst($h['status'])) ?></td>
                <td><?= is_numeric($h['nilai']) ? $h['nilai'] : '-' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

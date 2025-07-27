<?php
// siswa/ujian_list.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['siswa']);
$user = current_user();
$title = 'Daftar Ujian';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$stmt = $pdo->prepare('
    SELECT u.*, up.status 
    FROM ujian u 
    JOIN ujian_peserta up ON up.ujian_id = u.id 
    WHERE up.user_id = ? 
    ORDER BY u.mulai_at DESC
');
$stmt->execute([$user['id']]);
$ujians = $stmt->fetchAll();
$now = date('Y-m-d H:i:s');
?>
<div class="container">
<h2>Daftar Ujian</h2>
<table class="table">
    <thead><tr><th>Nama Ujian</th><th>Waktu</th><th>Durasi</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach($ujians as $u): ?>
        <tr>
        <td><?= h($u['nama']) ?></td>
        <td><?= h($u['mulai_at']) ?> s/d <?= h($u['selesai_at']) ?></td>
        <td><?= h($u['durasi_menit']) ?> menit</td>
        <td>
            <?php if($now >= $u['mulai_at'] && $now <= $u['selesai_at'] && $u['status'] === 'belum'): ?>
    <a class="btn btn-primary" href="ujian_mulai.php?id=<?= $u['id'] ?>">Mulai</a>
<?php elseif ($u['status'] === 'selesai'): ?>
    <span>Sudah dikerjakan</span>
<?php else: ?>
    <span>Tidak tersedia</span>
<?php endif; ?>
        </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
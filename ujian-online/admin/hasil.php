<?php
// admin/hasil.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin','guru']);

$ujians = $pdo->query('SELECT id,nama FROM ujian ORDER BY id DESC')->fetchAll();
$ujian_id = $_GET['ujian_id'] ?? ($ujians[0]['id'] ?? null);
$hasil = [];
if ($ujian_id) {
    $stmt = $pdo->prepare('SELECT up.*, u.fullname FROM ujian_peserta up JOIN users u ON u.id=up.user_id WHERE up.ujian_id=? ORDER BY up.id DESC');
    $stmt->execute([$ujian_id]);
    $hasil = $stmt->fetchAll();
}

$title = 'Hasil Tes Ujian';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
<h2>Hasil Tes Ujian</h2>
<form>
    <label>Pilih Ujian</label>
    <select name="ujian_id" onchange="this.form.submit()">
    <?php foreach($ujians as $u): ?>
        <option value="<?= $u['id'] ?>" <?= $u['id']==$ujian_id?'selected':'' ?>><?= h($u['nama']) ?></option>
    <?php endforeach; ?>
    </select>
</form>

<table class="table">
    <thead><tr><th>Nama Siswa</th><th>Mulai</th><th>Selesai</th><th>Status</th><th>Nilai</th></tr></thead>
    <tbody>
    <?php foreach($hasil as $h): ?>
        <tr>
        <td><?= h($h['fullname']) ?></td>
        <td><?= h($h['mulai_at']) ?></td>
        <td><?= h($h['selesai_at']) ?></td>
        <td><?= h($h['status']) ?></td>
        <td><?= h($h['nilai']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
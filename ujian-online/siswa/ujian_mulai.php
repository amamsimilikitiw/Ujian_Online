<?php
// siswa/ujian_mulai.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['siswa']);
$user = current_user();

$ujian_id = $_GET['id'] ?? 0;

// Ambil data ujian
$stmt = $pdo->prepare('SELECT * FROM ujian WHERE id = ?');
$stmt->execute([$ujian_id]);
$ujian = $stmt->fetch();

if (!$ujian) {
    echo "<h2>Ujian tidak ditemukan.</h2>";
    exit;
}

// Ambil soal berdasarkan mapel dari ujian
$stmt = $pdo->prepare('SELECT * FROM bank_soal WHERE mapel_id = ? ORDER BY RAND()');
$stmt->execute([$ujian['mapel_id']]);
$soal = $stmt->fetchAll();

$title = 'Kerjakan Ujian';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<div class="container">
<h2><?= h($ujian['nama']) ?></h2>

<?php if (count($soal) === 0): ?>
    <div class="alert alert-error">Tidak ada soal untuk mapel ini.</div>
<?php else: ?>
<form action="proses_jawab.php" method="post">
    <input type="hidden" name="ujian_id" value="<?= $ujian_id ?>">
    <?php foreach ($soal as $i => $s): ?>
        <div class="card">
            <p><strong>Soal <?= $i + 1 ?>:</strong> <?= nl2br(h($s['pertanyaan'])) ?></p>
            <?php foreach (['a','b','c','d'] as $opt): ?>
                <?php $kolom = 'opsi_' . $opt; ?>
                <?php if (!empty($s[$kolom])): ?>
                <label>
                    <input type="radio" name="jawaban[<?= $s['id'] ?>]" value="<?= strtoupper($opt) ?>" required>
                    <?= strtoupper($opt) ?>. <?= h($s[$kolom]) ?>
                </label><br>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    <button class="btn btn-primary" type="submit">Kumpulkan</button>
</form>
<?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

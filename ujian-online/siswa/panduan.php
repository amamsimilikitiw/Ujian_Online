<?php
// siswa/panduan.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['siswa']);
$title = 'Panduan Ujian';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
<div class="card">
    <h2>Panduan Ujian</h2>
    <ol>
    <li>Pastikan koneksi internet stabil.</li>
    <li>Baca instruksi ujian dengan teliti.</li>
    <li>Jangan refresh halaman saat ujian berlangsung.</li>
    <li>Jawab semua pertanyaan sebelum waktu habis.</li>
    </ol>
</div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
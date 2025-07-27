<?php
// siswa/proses_jawab.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['siswa']);
$user = current_user();

$jawaban = $_POST['jawaban'] ?? [];
$ujian_id = $_POST['ujian_id'] ?? 0;

$benar = 0;
$total = count($jawaban);

foreach ($jawaban as $soal_id => $pilihan) {
    // Ambil kunci jawaban & bobot
    $stmt = $pdo->prepare('SELECT jawaban, bobot FROM bank_soal WHERE id = ?');
    $stmt->execute([$soal_id]);
    $soal = $stmt->fetch();

    if ($soal) {
        $is_benar = (strtoupper($soal['jawaban']) === strtoupper($pilihan)) ? 1 : 0;
        if ($is_benar) $benar++;

        // Simpan ke tabel ujian_jawaban
        $stmt_insert = $pdo->prepare('INSERT INTO ujian_jawaban (ujian_id, user_id, soal_id, jawaban, is_benar, bobot) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt_insert->execute([$ujian_id, $user['id'], $soal_id, strtoupper($pilihan), $is_benar, $soal['bobot']]);
    }
}

$nilai = $total > 0 ? round(($benar / $total) * 100) : 0;

// Update status & nilai di ujian_peserta
$stmt = $pdo->prepare('UPDATE ujian_peserta SET status="selesai", nilai=? WHERE ujian_id=? AND user_id=?');
$stmt->execute([$nilai, $ujian_id, $user['id']]);

header('Location: hasil.php');
exit;

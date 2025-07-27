<?php
// admin/soal.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin','guru']);

// Hapus soal
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM bank_soal WHERE id=?');
    $stmt->execute([$id]);
    header('Location: soal.php');
    exit;
}

// Tambah / edit soal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = $_POST['id'] ?? '';
    $mapel_id = $_POST['mapel_id'] ?: null;
    $pertanyaan = $_POST['pertanyaan'];
    $opsi_a = $_POST['opsi_a'];
    $opsi_b = $_POST['opsi_b'];
    $opsi_c = $_POST['opsi_c'];
    $opsi_d = $_POST['opsi_d'];
    $jawaban = $_POST['jawaban'];
    $bobot   = (int)($_POST['bobot'] ?? 1);

    if ($id) {
        $stmt = $pdo->prepare('UPDATE bank_soal SET mapel_id=?, pertanyaan=?, opsi_a=?, opsi_b=?, opsi_c=?, opsi_d=?, jawaban=?, bobot=? WHERE id=?');
        $stmt->execute([$mapel_id, $pertanyaan, $opsi_a, $opsi_b, $opsi_c, $opsi_d, $jawaban, $bobot, $id]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO bank_soal(mapel_id,pertanyaan,opsi_a,opsi_b,opsi_c,opsi_d,jawaban,bobot,created_by) VALUES (?,?,?,?,?,?,?,?,?)');
        $stmt->execute([$mapel_id, $pertanyaan, $opsi_a, $opsi_b, $opsi_c, $opsi_d, $jawaban, $bobot, current_user()['id']]);
    }
    header('Location: soal.php');
    exit;
}

$mapel = $pdo->query('SELECT * FROM mapel ORDER BY nama')->fetchAll();
$soal = $pdo->query('SELECT s.*, m.nama as mapel_nama FROM bank_soal s LEFT JOIN mapel m ON m.id=s.mapel_id ORDER BY s.id DESC')->fetchAll();
$title = 'Kelola Soal';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
<h2>Kelola Bank Soal</h2>
<div class="card">
    <form method="post">
    <input type="hidden" name="id" value="">
    <label>Mapel</label>
    <select name="mapel_id" class="form-control" required>
    <option value="">- Pilih Mata Pelajaran -</option>
    <?php
    // Daftar mapel umum SMA
    $mapel_sma = [
        'Bahasa Indonesia',
        'Bahasa Inggris',
        'Matematika',
        'Fisika',
        'Kimia',
        'Biologi',
        'Ekonomi',
        'Sosiologi',
        'Geografi',
        'Sejarah',
        'Pendidikan Pancasila dan Kewarganegaraan (PPKn)',
        'Seni Budaya',
        'Pendidikan Jasmani, Olahraga dan Kesehatan (PJOK)',
        'Informatika / TIK',
        'Prakarya dan Kewirausahaan'
    ];

    $id = 1; // ID sementara, jika tidak dari database
    foreach ($mapel_sma as $nama_mapel):
    ?>
        <option value="<?= $id++ ?>"><?= htmlspecialchars($nama_mapel) ?></option>
    <?php endforeach; ?>
</select>

    <label>Pertanyaan</label>
    <textarea name="pertanyaan" required></textarea>
    <label>Opsi A</label>
    <textarea name="opsi_a" required></textarea>
    <label>Opsi B</label>
    <textarea name="opsi_b" required></textarea>
    <label>Opsi C</label>
    <textarea name="opsi_c" required></textarea>
    <label>Opsi D</label>
    <textarea name="opsi_d" required></textarea>
    <label>Kunci Jawaban</label>
    <select name="jawaban" required>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select>
    <label>Bobot</label>
    <input type="number" name="bobot" value="1" min="1">
    <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
</div>

<table class="table">
    <thead><tr><th>ID</th><th>Mapel</th><th>Pertanyaan</th><th>Kunci</th><th>Bobot</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach($soal as $s): ?>
        <tr>
        <td><?= $s['id'] ?></td>
        <td><?= h($s['mapel_nama']) ?></td>
        <td><?= nl2br(h($s['pertanyaan'])) ?></td>
        <td><?= h($s['jawaban']) ?></td>
        <td><?= h($s['bobot']) ?></td>
        <td>
            <a class="btn btn-danger" href="?delete=<?= $s['id'] ?>" onclick="return confirm('Hapus soal?')">Hapus</a>
        </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
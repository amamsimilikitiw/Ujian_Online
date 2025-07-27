<?php
// admin/ujian.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin','guru']);

// Hapus ujian
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM ujian WHERE id=?');
    $stmt->execute([$id]);
    header('Location: ujian.php');
    exit;
}

// Simpan ujian
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form']) && $_POST['form']==='ujian') {
    $id = $_POST['id'] ?? '';
    $nama = $_POST['nama'];
    $mapel_id = $_POST['mapel_id'] ?: null;
    $mulai_at = $_POST['mulai_at'];
    $selesai_at = $_POST['selesai_at'];
    $durasi_menit = (int)$_POST['durasi_menit'];
    $acak_soal = isset($_POST['acak_soal']) ? 1 : 0;
    $tampil_nilai = isset($_POST['tampil_nilai']) ? 1 : 0;

    if ($id) {
        $stmt = $pdo->prepare('UPDATE ujian SET nama=?, mapel_id=?, mulai_at=?, selesai_at=?, durasi_menit=?, acak_soal=?, tampil_nilai=? WHERE id=?');
        $stmt->execute([$nama, $mapel_id, $mulai_at, $selesai_at, $durasi_menit, $acak_soal, $tampil_nilai, $id]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO ujian(nama,mapel_id,mulai_at,selesai_at,durasi_menit,acak_soal,tampil_nilai,created_by) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->execute([$nama, $mapel_id, $mulai_at, $selesai_at, $durasi_menit, $acak_soal, $tampil_nilai, current_user()['id']]);
    }
    header('Location: ujian.php');
    exit;
}

// Attach soal ke ujian
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form']) && $_POST['form']==='attach_soal') {
    $ujian_id = (int)$_POST['ujian_id'];
    $soal_ids = $_POST['soal_ids'] ?? [];

    // Hapus dulu
    $pdo->prepare('DELETE FROM ujian_soal WHERE ujian_id=?')->execute([$ujian_id]);
    $stmt = $pdo->prepare('INSERT INTO ujian_soal(ujian_id,soal_id) VALUES (?,?)');
    foreach ($soal_ids as $sid) {
        $stmt->execute([$ujian_id, $sid]);
    }

    header('Location: ujian.php');
    exit;
}

// Assign peserta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form']) && $_POST['form']==='assign_peserta') {
    $ujian_id = (int)$_POST['ujian_id'];
    $user_ids = $_POST['user_ids'] ?? [];

    // Hapus dulu peserta lama
    $pdo->prepare('DELETE FROM ujian_peserta WHERE ujian_id=?')->execute([$ujian_id]);
    $stmt = $pdo->prepare('INSERT INTO ujian_peserta(ujian_id,user_id) VALUES (?,?)');
    foreach ($user_ids as $uid) {
        $stmt->execute([$ujian_id, $uid]);
    }
    header('Location: ujian.php');
    exit;
}

$mapel = $pdo->query('SELECT * FROM mapel ORDER BY nama')->fetchAll();
$ujians = $pdo->query('SELECT u.*, m.nama as mapel_nama FROM ujian u LEFT JOIN mapel m ON m.id=u.mapel_id ORDER BY u.id DESC')->fetchAll();
$soal = $pdo->query('SELECT id, pertanyaan FROM bank_soal ORDER BY id DESC')->fetchAll();
$users = $pdo->query("SELECT id, fullname FROM users WHERE role='siswa' ORDER BY fullname")->fetchAll();

$title = 'Pengaturan Tes Ujian';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
<h2>Pengaturan Tes Ujian</h2>

<div class="card">
    <h3>Buat / Edit Ujian</h3>
    <form method="post">
    <input type="hidden" name="form" value="ujian">
    <input type="hidden" name="id" value="">
    <label>Nama Ujian</label>
    <input type="text" name="nama" required>
    <label>Mapel</label>
    <select name="mapel_id">
        <option value="">-</option>
        <?php foreach($mapel as $m): ?>
        <option value="<?= $m['id'] ?>"><?= h($m['nama']) ?></option>
        <?php endforeach; ?>
    </select>
    <label>Mulai</label>
    <input type="datetime-local" name="mulai_at" required>
    <label>Selesai</label>
    <input type="datetime-local" name="selesai_at" required>
    <label>Durasi (menit)</label>
    <input type="number" name="durasi_menit" value="60" min="1">
    <label><input type="checkbox" name="acak_soal" checked> Acak Soal</label>
    <label><input type="checkbox" name="tampil_nilai" checked> Tampilkan nilai ke siswa</label>
    <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
</div>

<div class="card">
    <h3>Daftar Ujian</h3>
    <table class="table">
    <thead><tr><th>ID</th><th>Nama</th><th>Mapel</th><th>Jadwal</th><th>Durasi</th><th>Aksi</th></tr></thead>
    <tbody>
        <?php foreach($ujians as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= h($u['nama']) ?></td>
            <td><?= h($u['mapel_nama']) ?></td>
            <td><?= h($u['mulai_at']) ?> s/d <?= h($u['selesai_at']) ?></td>
            <td><?= h($u['durasi_menit']) ?> menit</td>
            <td>
            <a class="btn btn-danger" href="?delete=<?= $u['id'] ?>" onclick="return confirm('Hapus ujian?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

<div class="card">
    <h3>Attach Soal ke Ujian</h3>
    <form method="post">
    <input type="hidden" name="form" value="attach_soal">
    <label>Pilih Ujian</label>
    <select name="ujian_id">
        <?php foreach($ujians as $u): ?>
        <option value="<?= $u['id'] ?>"><?= h($u['nama']) ?></option>
        <?php endforeach; ?>
    </select>
    <label>Pilih Soal (Ctrl/Cmd untuk multi-select)</label>
    <select name="soal_ids[]" multiple size="10">
        <?php foreach($soal as $s): ?>
        <option value="<?= $s['id'] ?>">[<?= $s['id'] ?>] <?= substr(strip_tags($s['pertanyaan']),0,80) ?>...</option>
        <?php endforeach; ?>
    </select>
    <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
</div>

<div class="card">
    <h3>Assign Peserta Ujian</h3>
    <form method="post">
    <input type="hidden" name="form" value="assign_peserta">
    <label>Pilih Ujian</label>
    <select name="ujian_id">
        <?php foreach($ujians as $u): ?>
        <option value="<?= $u['id'] ?>"><?= h($u['nama']) ?></option>
        <?php endforeach; ?>
    </select>
    <label>Pilih Siswa (Ctrl/Cmd untuk multi-select)</label>
    <select name="user_ids[]" multiple size="10">
        <?php foreach($users as $s): ?>
        <option value="<?= $s['id'] ?>"><?= h($s['fullname']) ?></option>
        <?php endforeach; ?>
    </select>
    <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
</div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
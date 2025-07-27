<?php
// index.php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$title = 'Beranda';

$stmt = $pdo->query('SELECT * FROM sekolah WHERE id=1');
$sekolah = $stmt->fetch();

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div class="container">
    <div class="card">
        <h1 class="mb-3">Selamat Datang di Aplikasi Ujian Online</h1>
        <p>
            Aplikasi Ujian Online adalah platform berbasis web yang dirancang untuk memudahkan pelaksanaan ujian secara digital.
            Siswa dapat mengerjakan soal ujian dengan login menggunakan akun masing-masing, sedangkan admin atau guru dapat mengelola soal, 
            jadwal ujian, dan melihat hasil nilai siswa secara real-time.
        </p> <br>
        <p>
            Sistem ini dibuat untuk mendukung proses pembelajaran dan penilaian yang lebih efisien, transparan, dan terstruktur.
            Dengan tampilan antarmuka yang ramah pengguna dan pengelolaan data yang aman, aplikasi ini sangat cocok digunakan
            di lingkungan sekolah dan lembaga pendidikan lainnya.
        </p> <br>
        <p>
            Silakan login untuk memulai ujian atau registrasi jika belum memiliki akun.
        </p> <br> <br>
        <p>
            <a class="btn btn-primary" href="<?= base_url('auth/login.php') ?>">Masuk</a>
            <a class="btn" href="<?= base_url('auth/register.php') ?>">Registrasi Siswa</a>
        </p>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

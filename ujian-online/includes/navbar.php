<?php

$user = null;
if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
    $user = $_SESSION['user'];
} elseif (isset($_SESSION['siswa']) && is_array($_SESSION['siswa'])) {
    $user = [
        'role' => 'siswa',
        'nama' => $_SESSION['siswa']['nama_lengkap'],
        'id' => $_SESSION['siswa']['id']
    ];
}
?>

<nav class="navbar">
<div class="container">
    <a href="<?= base_url('index.php') ?>" class="brand">Ujian Online</a>
    <ul>
        <li><a href="<?= base_url('index.php') ?>">Beranda</a></li>
        <li><a href="<?= base_url('pages/profil.php') ?>">Profil Sekolah</a></li>
        <?php if(!$user): ?>
            <li><a href="<?= base_url('auth/login.php') ?>">Login</a></li>
            <li><a href="<?= base_url('auth/register.php') ?>">Registrasi</a></li>
        <?php else: ?>
            <?php if($user['role'] === 'admin'): ?>
                <li><a href="<?= base_url('admin/index.php') ?>">Admin</a></li>
            <?php elseif($user['role'] === 'siswa'): ?>
                <li><a href="<?= base_url('siswa/index.php') ?>">Dashboard</a></li>
            <?php endif; ?>
            <li><a href="<?= base_url('auth/logout.php') ?>">Logout</a></li>
        <?php endif; ?>
    </ul>
</div>
</nav>

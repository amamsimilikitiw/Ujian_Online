-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2025 at 03:27 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ujian_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_soal`
--

CREATE TABLE `bank_soal` (
  `id` int(11) NOT NULL,
  `mapel_id` int(11) DEFAULT NULL,
  `pertanyaan` text NOT NULL,
  `opsi_a` text NOT NULL,
  `opsi_b` text NOT NULL,
  `opsi_c` text NOT NULL,
  `opsi_d` text NOT NULL,
  `jawaban` char(1) NOT NULL CHECK (`jawaban` in ('A','B','C','D')),
  `bobot` int(11) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_soal`
--

INSERT INTO `bank_soal` (`id`, `mapel_id`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban`, `bobot`, `created_by`, `created_at`) VALUES
(6, 3, '1 + 1 = ?', '2', '3', '4', '5', 'A', 100, 1, '2025-07-26 15:15:59'),
(7, 1, 'AAAAAAAAAAAAAAA', '1', '2', '3', '4', 'A', 100, 1, '2025-07-26 15:17:21'),
(9, 4, '1111111111111111', '1', '2', '3', '4', 'A', 100, 1, '2025-07-26 15:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id`, `nama`) VALUES
(1, 'Bahasa Indonesia'),
(2, 'Bahasa Inggris'),
(3, 'Matematika'),
(4, 'Fisika'),
(5, 'Kimia'),
(6, 'Biologi'),
(7, 'Ekonomi'),
(8, 'Sosiologi'),
(9, 'Geografi'),
(10, 'Sejarah'),
(11, 'Pendidikan Pancasila dan Kewarganegaraan (PPKn)'),
(12, 'Seni Budaya'),
(13, 'Pendidikan Jasmani, Olahraga dan Kesehatan (PJOK)'),
(14, 'Informatika / TIK'),
(15, 'Prakarya dan Kewirausahaan');

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

CREATE TABLE `sekolah` (
  `id` int(11) NOT NULL DEFAULT 1,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telp` varchar(30) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sekolah`
--

INSERT INTO `sekolah` (`id`, `nama`, `alamat`, `email`, `telp`, `deskripsi`) VALUES
(1, 'SMKN 2 Padang', 'Jl. Baru Andalas No.5, Simpang Haru, Padang Tim., Kota Padang, Sumatera Barat 25171, Indonesia', 'info@esemka2padang', '(0751)-21930', 'Merupakan salah satu sekolah menengah yang berada di Padang, provinsi Sumatera Barat. Adapun Nomor pokok sekolah nasional (NPSN) untuk SMKN 2 PADANG ini adalah 10304848.\r\n\r\nSekolah ini menyediakan berbagai fasilitas penunjang pendidikan bagi anak didiknya. Terdapat guru-guru dengan kualitas terbaik yang kompeten dibidangnya, kegiatan penunjang pembelajaran seperti ekstrakurikuler (ekskul), organisasi siswa, komunitas belajar, tim olahraga, dan perpustakaan sehingga siswa dapat belajar secara maksimal. Proses belajar dibuat senyaman mungkin bagi murid dan siswa.\r\n\r\nKunjungi sekolah terdekat ini pada jam kerja untuk mendapatkan informasi lain seperti cek lapor anak, pengumuman hari libur atau jadwal pelajaran, list mata pelajaran sekolah, informasi ujian, pendaftaran siswa baru, hingga syarat pendaftaran siswa baru. Anda juga dapat menghubungi kontak telepon sekolah untuk mendapat respon cepat, atau mengakses website sekolah ini secara online untuk mendapatkan informasi seperti profil sekolah dan berita terkait lainnya.\r\n\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nis` varchar(30) DEFAULT NULL,
  `kelas` varchar(30) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `user_id`, `nis`, `kelas`, `jurusan`) VALUES
(1, 2, '22001', 'XII PPLG 2', 'RPL');

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `mapel_id` int(11) DEFAULT NULL,
  `mulai_at` datetime NOT NULL,
  `selesai_at` datetime NOT NULL,
  `durasi_menit` int(11) NOT NULL,
  `acak_soal` tinyint(1) DEFAULT 1,
  `tampil_nilai` tinyint(1) DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ujian`
--

INSERT INTO `ujian` (`id`, `nama`, `mapel_id`, `mulai_at`, `selesai_at`, `durasi_menit`, `acak_soal`, `tampil_nilai`, `created_by`, `created_at`) VALUES
(6, 'UH', 3, '2025-07-26 22:16:00', '2025-07-26 23:16:00', 60, 1, 1, 1, '2025-07-26 15:16:29'),
(7, 'UH BINDO', 1, '2025-07-26 22:17:00', '2025-07-26 23:17:00', 60, 1, 1, 1, '2025-07-26 15:17:43'),
(9, 'FISIKA', 4, '2025-07-26 22:56:00', '2025-07-26 23:56:00', 60, 1, 1, 1, '2025-07-26 15:56:35');

-- --------------------------------------------------------

--
-- Table structure for table `ujian_jawaban`
--

CREATE TABLE `ujian_jawaban` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `jawaban` char(1) DEFAULT NULL,
  `is_benar` tinyint(1) DEFAULT NULL,
  `bobot` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ujian_jawaban`
--

INSERT INTO `ujian_jawaban` (`id`, `ujian_id`, `user_id`, `soal_id`, `jawaban`, `is_benar`, `bobot`) VALUES
(1, 6, 2, 6, 'A', 1, 100),
(2, 7, 2, 7, 'A', 1, 100),
(3, 9, 2, 9, 'B', 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `ujian_peserta`
--

CREATE TABLE `ujian_peserta` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mulai_at` datetime DEFAULT NULL,
  `selesai_at` datetime DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `status` enum('belum','sedang','selesai') DEFAULT 'belum',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ujian_peserta`
--

INSERT INTO `ujian_peserta` (`id`, `ujian_id`, `user_id`, `mulai_at`, `selesai_at`, `nilai`, `status`, `created_at`) VALUES
(6, 6, 2, NULL, NULL, 100.00, 'selesai', '2025-07-26 15:16:43'),
(7, 7, 2, NULL, NULL, 100.00, 'selesai', '2025-07-26 15:18:23'),
(10, 9, 2, NULL, NULL, 0.00, 'selesai', '2025-07-26 15:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `ujian_soal`
--

CREATE TABLE `ujian_soal` (
  `ujian_id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ujian_soal`
--

INSERT INTO `ujian_soal` (`ujian_id`, `soal_id`) VALUES
(6, 6),
(7, 7),
(9, 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL DEFAULT 'siswa',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `fullname`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$3ahyg19vHqkRT0R1aehUDO6WOoQbFBpVO6nfYldIAjOKN2r1RYMK6', 'Administrator', 'admin', '2025-07-25 03:41:13'),
(2, 'ilham', '$2y$10$xFtT1WJWKdjyPL7jvoV2Xezdx3/FSI8mVX9JIEQVIrv8cIVNhizC6', 'Muhammad Rizki Ilham', 'siswa', '2025-07-25 04:35:03'),
(3, 'kazeoy', '$2y$10$uM/tYk3rpFpkIHi8CctGwO7WR.SHGD06jMWEDVfuTJc8ujgdeEEje', 'Keisha Reyhana', 'siswa', '2025-07-27 13:12:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_soal`
--
ALTER TABLE `bank_soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mapel_id` (`mapel_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mapel_id` (`mapel_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `ujian_jawaban`
--
ALTER TABLE `ujian_jawaban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ujian_id` (`ujian_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `soal_id` (`soal_id`);

--
-- Indexes for table `ujian_peserta`
--
ALTER TABLE `ujian_peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ujian_id` (`ujian_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD PRIMARY KEY (`ujian_id`,`soal_id`),
  ADD KEY `soal_id` (`soal_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_soal`
--
ALTER TABLE `bank_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ujian_jawaban`
--
ALTER TABLE `ujian_jawaban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ujian_peserta`
--
ALTER TABLE `ujian_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_soal`
--
ALTER TABLE `bank_soal`
  ADD CONSTRAINT `bank_soal_ibfk_1` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bank_soal_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ujian`
--
ALTER TABLE `ujian`
  ADD CONSTRAINT `ujian_ibfk_1` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ujian_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ujian_jawaban`
--
ALTER TABLE `ujian_jawaban`
  ADD CONSTRAINT `ujian_jawaban_ibfk_1` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ujian_jawaban_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ujian_jawaban_ibfk_3` FOREIGN KEY (`soal_id`) REFERENCES `bank_soal` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ujian_peserta`
--
ALTER TABLE `ujian_peserta`
  ADD CONSTRAINT `ujian_peserta_ibfk_1` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ujian_peserta_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD CONSTRAINT `ujian_soal_ibfk_1` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ujian_soal_ibfk_2` FOREIGN KEY (`soal_id`) REFERENCES `bank_soal` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

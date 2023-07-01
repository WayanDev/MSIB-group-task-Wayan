-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jun 2023 pada 13.35
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun_desa`
--

CREATE TABLE `akun_desa` (
  `id` int(11) NOT NULL,
  `list_desa_nama` varchar(45) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','petugas') DEFAULT NULL,
  `session_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `akun_desa`
--

INSERT INTO `akun_desa` (`id`, `list_desa_nama`, `username`, `password`, `role`, `session_token`, `created_at`, `updated_at`) VALUES
(21, 'Karanggede', 'Karanggede', '$2y$10$5ZlwiaKyu1totiGPgYaDe.Of.GOZ3cj3elwfO/E5.HBzipOe2Jnse', 'petugas', NULL, '2023-06-14 21:01:59', '2023-06-14 21:01:59'),
(22, 'Kertodeso', 'Kertodeso', '$2y$10$xXmcC1x.gUzdrfPTZH6ko.4pFh6gjI8AoAcWX5SXZXD0Nm/df9ETe', 'petugas', NULL, '2023-06-14 21:07:35', '2023-06-14 21:07:35'),
(23, 'Makmur', 'Makmur', '$2y$10$msKCUSC0xZVUe1gaaFwcv.c86AlsR6FOQ6v5fhn/ZudWKJ6a9SnTu', 'petugas', NULL, '2023-06-14 21:07:49', '2023-06-14 21:07:49'),
(24, NULL, 'Admin', '$2y$10$vqf8woNsiFZINxRfUCIQtORgSOuD1SGroCltTPy7dSTcu6peHwh8y', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun_pemilih`
--

CREATE TABLE `akun_pemilih` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` enum('Sudah Memilih','Belum Memilih') DEFAULT NULL,
  `akun_desa_id` varchar(45) DEFAULT NULL,
  `session_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `akun_pemilih`
--

INSERT INTO `akun_pemilih` (`id`, `username`, `nama`, `password`, `status`, `akun_desa_id`, `session_token`, `created_at`, `updated_at`) VALUES
(14, '4444444444444444', 'ghf', '$2y$10$dyH2VbVJBs7aoSFCIujR6euyi2gBdpDOL7bEi8fhfpxcqpShQy3om', 'Sudah Memilih', 'Makmur', NULL, '2023-06-14 22:17:00', '2023-06-14 22:18:31'),
(15, '5555555555555555', 'hjhj', '$2y$10$1ABNvWQf7NDltrMLJShwruuKLj4497BQRRQzpoED7EX5HsKHc8esa', 'Sudah Memilih', 'Makmur', NULL, '2023-06-15 01:58:52', '2023-06-15 02:01:40'),
(16, '3333333333333333', 'gdfgdg', '$2y$10$yWdjtWx4JgYz9WTmrIEBRuDW0naSMEncs/mgDCSrbXJY96X2SuzkW', 'Sudah Memilih', 'Kertodeso', NULL, '2023-06-15 01:59:53', '2023-06-15 02:02:12'),
(17, '7777777777777777', 'gdfgdf', '$2y$10$DZl.h7NhwD0Sk8ytnMInyOmWLz5quScCm63gwu5/ikUZZcWSLm3.6', 'Belum Memilih', 'Kertodeso', NULL, '2023-06-15 02:00:53', '2023-06-15 02:00:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `akun_desa_id` varchar(45) DEFAULT NULL,
  `tgl_pemilihan` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id`, `akun_desa_id`, `tgl_pemilihan`, `waktu_mulai`, `waktu_selesai`, `created_at`, `updated_at`) VALUES
(19, 'Karanggede', '2023-06-03', '10:41:00', '16:41:00', '2023-06-03 20:35:09', '2023-06-14 21:10:03'),
(20, 'Kertodeso', '2023-06-03', '00:26:00', '00:26:00', '2023-06-04 04:20:51', '2023-06-14 21:10:10'),
(21, 'Makmur', '2023-06-15', '17:16:00', '17:16:00', '2023-06-14 21:10:23', '2023-06-14 21:10:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kandidat`
--

CREATE TABLE `kandidat` (
  `id` int(11) NOT NULL,
  `akun_desa_id` varchar(45) DEFAULT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `usia` int(11) DEFAULT NULL,
  `visi` varchar(255) DEFAULT NULL,
  `misi` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `kandidat`
--

INSERT INTO `kandidat` (`id`, `akun_desa_id`, `nama`, `jenis_kelamin`, `usia`, `visi`, `misi`, `foto`, `created_at`, `updated_at`) VALUES
(32, 'Kertodeso', 'dfgg', 'Laki-laki', 76, 'jhgjhjghj', 'ghjgj', 'photos/noimage.png', '2023-06-14 21:45:01', '2023-06-14 21:45:01'),
(33, 'Kertodeso', 'tyrtyryfgh', 'Laki-laki', 77, 'hjgjgjgjg', 'jgj', 'photos/noimage.png', '2023-06-14 21:45:52', '2023-06-14 21:45:52'),
(34, 'Makmur', 'gfdghgh', 'Laki-laki', 67, 'ghgjgj', 'ghjhghjg', 'photos/noimage.png', '2023-06-14 22:17:27', '2023-06-14 22:17:27'),
(35, 'Makmur', 'bv', 'Laki-laki', 7686, 'hmbnbm', 'bmhjk', 'photos/noimage.png', '2023-06-14 22:17:39', '2023-06-14 22:17:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `list_desa`
--

CREATE TABLE `list_desa` (
  `nama` varchar(45) NOT NULL,
  `alamat_kantor` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `list_desa`
--

INSERT INTO `list_desa` (`nama`, `alamat_kantor`, `created_at`, `updated_at`) VALUES
('Karanggede', 'Jl. Raya Gentan Mirit Km. 6,5 Desa Karanggede, Kec. Mirit, Kab. Kebumen', '2023-05-26 20:58:42', '2023-06-14 21:10:38'),
('Kertodeso', 'JL Martoyudo NO1 DESA KERTODESO', '2023-05-26 20:06:17', '2023-06-14 22:10:14'),
('Makmur', 'jl makmur', '2023-06-04 08:13:03', '2023-06-04 08:14:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_05_27_041550_drop_foreign_key_constraint_on_pemilih_table', 1),
(2, '2023_05_27_041852_change_akun_desa_id_data_type_in_pemilih_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemilih`
--

CREATE TABLE `pemilih` (
  `nik` varchar(255) NOT NULL,
  `akun_desa_id` varchar(45) DEFAULT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `tmp_lahir` varchar(45) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `status_perkawinan` varchar(40) DEFAULT NULL,
  `pekerjaan` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `pemilih`
--

INSERT INTO `pemilih` (`nik`, `akun_desa_id`, `nama`, `tmp_lahir`, `tgl_lahir`, `jenis_kelamin`, `alamat`, `status_perkawinan`, `pekerjaan`, `created_at`, `updated_at`) VALUES
('3333333333333333', 'Kertodeso', 'gdfgdg', 'gfhfg', '1546-06-15', 'Laki-laki', 'bvcb', 'ghfh', 'ty', '2023-06-14 21:43:43', '2023-06-14 21:43:43'),
('4444444444444444', 'Makmur', 'ghf', 'hfhggh', '1989-06-10', 'Laki-laki', 'gnghj', 'ghjg', 'jh', '2023-06-14 22:16:19', '2023-06-14 22:16:19'),
('5555555555555555', 'Makmur', 'hjhj', 'hjh', '2005-06-17', 'Perempuan', 'ttyuyu', 'yiui', 'iuiu', '2023-06-14 22:16:44', '2023-06-14 22:16:44'),
('7777777777777777', 'Kertodeso', 'gdfgdf', 'dgdfg', '1978-06-16', 'Laki-laki', 'vdfgdg', 'dgdg', 'dgdf', '2023-06-15 02:00:33', '2023-06-15 02:00:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `voting`
--

CREATE TABLE `voting` (
  `id` int(11) NOT NULL,
  `kandidat_id` int(11) DEFAULT NULL,
  `akun_pemilih_id` int(11) DEFAULT NULL,
  `akun_desa_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `voting`
--

INSERT INTO `voting` (`id`, `kandidat_id`, `akun_pemilih_id`, `akun_desa_id`, `created_at`, `updated_at`) VALUES
(2, 34, 14, 'Makmur', '2023-06-14 22:18:31', '2023-06-14 22:18:31'),
(3, 34, 15, 'Makmur', '2023-06-15 02:01:40', '2023-06-15 02:01:40'),
(4, 32, 16, 'Kertodeso', '2023-06-15 02:02:12', '2023-06-15 02:02:12');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun_desa`
--
ALTER TABLE `akun_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_akun_desa_list_desa1_idx` (`list_desa_nama`);

--
-- Indeks untuk tabel `akun_pemilih`
--
ALTER TABLE `akun_pemilih`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pemilih_nik_UNIQUE` (`username`),
  ADD KEY `fk_akun_pemilih_pemilih1_idx` (`username`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jadwal_akun_desa1_idx` (`akun_desa_id`);

--
-- Indeks untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kandidat_akun_desa1_idx` (`akun_desa_id`);

--
-- Indeks untuk tabel `list_desa`
--
ALTER TABLE `list_desa`
  ADD PRIMARY KEY (`nama`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemilih`
--
ALTER TABLE `pemilih`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `fk_pemilih_akun_desa1_idx` (`akun_desa_id`);

--
-- Indeks untuk tabel `voting`
--
ALTER TABLE `voting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `akun_pemilih_id_UNIQUE` (`akun_pemilih_id`),
  ADD KEY `fk_voting_kandidat1_idx` (`kandidat_id`),
  ADD KEY `fk_voting_akun_pemilih1_idx` (`akun_pemilih_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun_desa`
--
ALTER TABLE `akun_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `akun_pemilih`
--
ALTER TABLE `akun_pemilih`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `voting`
--
ALTER TABLE `voting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akun_desa`
--
ALTER TABLE `akun_desa`
  ADD CONSTRAINT `fk_akun_desa_list_desa1` FOREIGN KEY (`list_desa_nama`) REFERENCES `list_desa` (`nama`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `akun_pemilih`
--
ALTER TABLE `akun_pemilih`
  ADD CONSTRAINT `pemilih_nik` FOREIGN KEY (`username`) REFERENCES `pemilih` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `fk_jadwal_akun_desa1` FOREIGN KEY (`akun_desa_id`) REFERENCES `akun_desa` (`list_desa_nama`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  ADD CONSTRAINT `fk_kandidat_akun_desa1` FOREIGN KEY (`akun_desa_id`) REFERENCES `akun_desa` (`list_desa_nama`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemilih`
--
ALTER TABLE `pemilih`
  ADD CONSTRAINT `pemilih_ibfk_1` FOREIGN KEY (`akun_desa_id`) REFERENCES `akun_desa` (`list_desa_nama`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `voting`
--
ALTER TABLE `voting`
  ADD CONSTRAINT `fk_voting_akun_pemilih1` FOREIGN KEY (`akun_pemilih_id`) REFERENCES `akun_pemilih` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_voting_kandidat1` FOREIGN KEY (`kandidat_id`) REFERENCES `kandidat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

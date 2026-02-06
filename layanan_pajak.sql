-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Okt 2025 pada 08.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `layanan_pajak`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_balasan`
--

CREATE TABLE `dokumen_balasan` (
  `id` int(11) NOT NULL,
  `permohonan_id` int(11) NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(500) NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_upload`
--

CREATE TABLE `dokumen_upload` (
  `id` int(11) NOT NULL,
  `permohonan_id` int(11) NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `ukuran_file` int(11) DEFAULT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `path_file` varchar(500) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan_pajak`
--

CREATE TABLE `layanan_pajak` (
  `id` int(11) NOT NULL,
  `nama_layanan` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(15,2) NOT NULL,
  `syarat_dokumen` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `layanan_pajak`
--

INSERT INTO `layanan_pajak` (`id`, `nama_layanan`, `deskripsi`, `harga`, `syarat_dokumen`, `status`, `created_at`) VALUES
(1, 'Pajak Penghasilan', 'Layanan pengelolaan dan pelaporan pajak penghasilan untuk wajib pajak individu dan badan usaha.', 500000.00, 'KTP, NPWP, Surat Usaha', 'aktif', '2025-08-06 09:22:32'),
(2, 'Pajak Pertambahan Nilai', 'Layanan untuk pengelolaan dan pelaporan pajak pertambahan nilai (PPN) bagi wajib pajak.', 750000.00, 'KTP, NPWP, Faktur Pajak', 'aktif', '2025-08-06 09:22:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('permohonan_status','pembayaran_verified','tagihan_baru') NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `tagihan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nomor_pembayaran` varchar(50) NOT NULL,
  `metode_pembayaran` enum('transfer_bank','virtual_account','e_wallet','cash') NOT NULL,
  `jumlah_bayar` decimal(15,2) NOT NULL,
  `tanggal_bayar` datetime NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` enum('pending','verified','rejected') DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  `verified_by` int(11) DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `tagihan_id`, `user_id`, `nomor_pembayaran`, `metode_pembayaran`, `jumlah_bayar`, `tanggal_bayar`, `bukti_pembayaran`, `status_pembayaran`, `catatan_admin`, `verified_by`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'PAY002202563459', 'transfer_bank', 2500000.00, '2025-10-01 00:00:00', '1759319039_msieditor,+Journal+editor,+13Jurnal+Herri+Yansa+Wijaya.pdf', 'verified', '', 1, '2025-10-01 18:44:13', '2025-10-01 11:43:59', '2025-10-01 11:44:13'),
(5, 2, 2, 'PAY002202582950', 'transfer_bank', 1801000.00, '2025-10-18 00:00:00', '1760785630_msieditor,+Journal+editor,+13Jurnal+Herri+Yansa+Wijaya.pdf', 'verified', '', 1, '2025-10-18 18:07:24', '2025-10-18 11:07:10', '2025-10-18 11:07:24'),
(6, 7, 2, 'PAY002202577500', 'transfer_bank', 5000.00, '2025-10-18 00:00:00', '1760785811_msieditor,+Journal+editor,+13Jurnal+Herri+Yansa+Wijaya.pdf', 'verified', '', 1, '2025-10-18 18:10:34', '2025-10-18 11:10:11', '2025-10-18 11:10:34'),
(7, 1, 2, 'PAY001202500001', 'transfer_bank', 2500000.00, '2025-01-15 10:30:00', NULL, 'verified', NULL, NULL, NULL, '2025-10-18 11:18:59', '2025-10-18 11:18:59'),
(8, 2, 2, 'PAY002202500002', 'e_wallet', 1800000.00, '2025-01-20 14:45:00', NULL, 'pending', NULL, NULL, NULL, '2025-10-18 11:18:59', '2025-10-18 11:18:59');

--
-- Trigger `pembayaran`
--
DELIMITER $$
CREATE TRIGGER `update_tagihan_status` AFTER UPDATE ON `pembayaran` FOR EACH ROW BEGIN
    IF NEW.status_pembayaran = 'verified' AND OLD.status_pembayaran != 'verified' THEN
        UPDATE tagihan_pajak 
        SET status_tagihan = 'sudah_bayar' 
        WHERE id = NEW.tagihan_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permohonan_layanan`
--

CREATE TABLE `permohonan_layanan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `layanan_id` int(11) NOT NULL,
  `tanggal_permohonan` date NOT NULL,
  `status` enum('menunggu','disetujui','ditolak','selesai','dibatalkan') DEFAULT 'menunggu',
  `total_pembayaran` decimal(15,2) DEFAULT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `catatan_admin` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan_pajak`
--

CREATE TABLE `tagihan_pajak` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nomor_tagihan` varchar(50) NOT NULL,
  `jenis_pajak` varchar(100) NOT NULL,
  `tahun_pajak` year(4) NOT NULL,
  `periode_pajak` varchar(20) NOT NULL,
  `jumlah_tagihan` decimal(15,2) NOT NULL,
  `denda` decimal(15,2) DEFAULT 0.00,
  `total_tagihan` decimal(15,2) NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `status_tagihan` enum('belum_bayar','sudah_bayar','overdue') DEFAULT 'belum_bayar',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tagihan_pajak`
--

INSERT INTO `tagihan_pajak` (`id`, `user_id`, `nomor_tagihan`, `jenis_pajak`, `tahun_pajak`, `periode_pajak`, `jumlah_tagihan`, `denda`, `total_tagihan`, `tanggal_jatuh_tempo`, `status_tagihan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 2, 'TGH001202500001', 'Pajak Penghasilan PPh 21', '2024', 'Desember 2024', 2500000.00, 0.00, 2500000.00, '2025-01-31', 'sudah_bayar', 'Tagihan PPh 21 untuk periode Desember 2024', '2025-08-22 07:36:22', '2025-10-01 11:44:13'),
(2, 2, 'TGH001202500002', 'Pajak Pertambahan Nilai', '2024', 'Desember 2024', 1800000.00, 1000.00, 1801000.00, '2025-02-28', 'sudah_bayar', 'Tagihan PPN untuk periode Desember 2024', '2025-08-22 07:36:22', '2025-10-18 11:07:24'),
(7, 2, 'TGH002202541032', 'Pajak Penghasilan PPh 21', '2025', 'November 2025', 5000.00, 0.00, 5000.00, '2025-11-30', 'sudah_bayar', '', '2025-10-18 11:09:25', '2025-10-18 11:10:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `npwp` varchar(30) DEFAULT NULL,
  `role` enum('admin','pelanggan') DEFAULT 'pelanggan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `email`, `password`, `no_hp`, `npwp`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', '081234567890', NULL, 'admin', '2025-08-06 09:22:32', '2025-08-06 09:32:00'),
(2, 'customer', 'customer@gmail.com', 'f4ad231214cb99a985dff0f056a36242', '081234567890', '1234556677', 'pelanggan', '2025-08-06 09:22:32', '2025-08-06 10:56:56');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dokumen_balasan`
--
ALTER TABLE `dokumen_balasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permohonan_id` (`permohonan_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indeks untuk tabel `dokumen_upload`
--
ALTER TABLE `dokumen_upload`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permohonan_id` (`permohonan_id`);

--
-- Indeks untuk tabel `layanan_pajak`
--
ALTER TABLE `layanan_pajak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `is_read` (`is_read`),
  ADD KEY `created_at` (`created_at`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_pembayaran` (`nomor_pembayaran`),
  ADD KEY `tagihan_id` (`tagihan_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `verified_by` (`verified_by`);

--
-- Indeks untuk tabel `permohonan_layanan`
--
ALTER TABLE `permohonan_layanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `layanan_id` (`layanan_id`);

--
-- Indeks untuk tabel `tagihan_pajak`
--
ALTER TABLE `tagihan_pajak`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_tagihan` (`nomor_tagihan`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_tagihan` (`status_tagihan`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dokumen_balasan`
--
ALTER TABLE `dokumen_balasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `dokumen_upload`
--
ALTER TABLE `dokumen_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `layanan_pajak`
--
ALTER TABLE `layanan_pajak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `permohonan_layanan`
--
ALTER TABLE `permohonan_layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tagihan_pajak`
--
ALTER TABLE `tagihan_pajak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dokumen_balasan`
--
ALTER TABLE `dokumen_balasan`
  ADD CONSTRAINT `dokumen_balasan_ibfk_1` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan_layanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dokumen_balasan_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `dokumen_upload`
--
ALTER TABLE `dokumen_upload`
  ADD CONSTRAINT `dokumen_upload_ibfk_1` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan_layanan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan_pajak` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `permohonan_layanan`
--
ALTER TABLE `permohonan_layanan`
  ADD CONSTRAINT `permohonan_layanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permohonan_layanan_ibfk_2` FOREIGN KEY (`layanan_id`) REFERENCES `layanan_pajak` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tagihan_pajak`
--
ALTER TABLE `tagihan_pajak`
  ADD CONSTRAINT `tagihan_pajak_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

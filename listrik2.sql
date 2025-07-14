-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2025 at 04:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pembayaran_listrik`
--

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
(1, 'Reguler'),
(2, 'Premium'),
(3, 'Bisnis');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_kwh` varchar(20) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `alamat` varchar(191) DEFAULT NULL,
  `id_tarif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `username`, `password`, `nomor_kwh`, `nama_pelanggan`, `alamat`, `id_tarif`) VALUES
(5, 'admin123', '0192023a7bbd73250516f069df18b500', '21212', 'testing', '12', 3),
(11, 'admin1333333', '0192023a7bbd73250516f069df18b500', '121243', 'dapoy', '123456', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_tagihan` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `tanggal_pembayaran` datetime(3) DEFAULT NULL,
  `bulan_bayar` varchar(10) DEFAULT NULL,
  `biaya_admin` decimal(10,2) DEFAULT NULL,
  `total_bayar` decimal(10,2) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan`
--

CREATE TABLE `penggunaan` (
  `id_penggunaan` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `bulan` varchar(10) NOT NULL,
  `tahun` year(4) NOT NULL,
  `meter_awal` int(11) NOT NULL,
  `meter_ahir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penggunaan`
--

INSERT INTO `penggunaan` (`id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `meter_awal`, `meter_ahir`) VALUES
(14, 5, 'Januari', '2025', 2000, 3000),
(15, 11, 'Maret', '2025', 2000, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` int(11) NOT NULL,
  `id_penggunaan` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `bulan` varchar(10) NOT NULL,
  `tahun` year(4) NOT NULL,
  `jumlah_meter` int(11) NOT NULL,
  `status` enum('belum_bayar','sudah_bayar') NOT NULL DEFAULT 'belum_bayar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `jumlah_meter`, `status`) VALUES
(14, 14, 5, 'Januari', '2025', 1000, 'belum_bayar'),
(15, 15, 11, 'Maret', '2025', 1000, 'belum_bayar');

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` int(11) NOT NULL,
  `daya` int(11) NOT NULL,
  `tarifperkwh` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `daya`, `tarifperkwh`) VALUES
(1, 900, 1352.00),
(2, 1300, 1444.70),
(3, 2200, 1699.53);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) DEFAULT NULL,
  `id_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_admin`, `id_level`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator', 1),
(2, 'petugas', '570c396b3fc856eceb8aa7357f32af1a', 'Petugas PLN', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `pelanggan_username_key` (`username`),
  ADD UNIQUE KEY `pelanggan_nomor_kwh_key` (`nomor_kwh`),
  ADD KEY `pelanggan_id_tarif_fkey` (`id_tarif`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `pembayaran_id_tagihan_fkey` (`id_tagihan`),
  ADD KEY `pembayaran_id_pelanggan_fkey` (`id_pelanggan`),
  ADD KEY `pembayaran_id_user_fkey` (`id_user`);

--
-- Indexes for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD PRIMARY KEY (`id_penggunaan`),
  ADD KEY `penggunaan_id_pelanggan_fkey` (`id_pelanggan`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `tagihan_id_penggunaan_fkey` (`id_penggunaan`),
  ADD KEY `tagihan_id_pelanggan_fkey` (`id_pelanggan`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `user_username_key` (`username`),
  ADD KEY `user_id_level_fkey` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penggunaan`
--
ALTER TABLE `penggunaan`
  MODIFY `id_penggunaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id_tagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_id_tarif_fkey` FOREIGN KEY (`id_tarif`) REFERENCES `tarif` (`id_tarif`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_id_pelanggan_fkey` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_id_tagihan_fkey` FOREIGN KEY (`id_tagihan`) REFERENCES `tagihan` (`id_tagihan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_id_user_fkey` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD CONSTRAINT `penggunaan_id_pelanggan_fkey` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_id_pelanggan_fkey` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tagihan_id_penggunaan_fkey` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan` (`id_penggunaan`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_id_level_fkey` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

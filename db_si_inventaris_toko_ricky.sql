-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 17, 2025 at 01:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_si_inventaris_toko_ricky`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_penerimaan_produk`
--

CREATE TABLE `detail_penerimaan_produk` (
  `id_detail_penerimaan_produk` int(11) NOT NULL,
  `penerimaan_produk_id` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_beli` decimal(15,2) NOT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_penerimaan_produk`
--

INSERT INTO `detail_penerimaan_produk` (`id_detail_penerimaan_produk`, `penerimaan_produk_id`, `id_produk`, `jumlah`, `harga_beli`, `status_dihapus`) VALUES
(15, 5, 1, 1, 50000.00, 1),
(16, 4, 2, 10, 60000.00, 0),
(17, 3, 1, 10, 50000.00, 0),
(18, 6, 23, 1, 25000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pengeluaran_produk`
--

CREATE TABLE `detail_pengeluaran_produk` (
  `id_detail_pengeluaran` int(11) NOT NULL,
  `id_pengeluaran_produk` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_jual` decimal(10,2) DEFAULT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pengeluaran_produk`
--

INSERT INTO `detail_pengeluaran_produk` (`id_detail_pengeluaran`, `id_pengeluaran_produk`, `id_produk`, `jumlah`, `harga_jual`, `status_dihapus`) VALUES
(7, 2, 1, 2, 60000.00, 1),
(8, 3, 1, 2, 60000.00, 0),
(9, 4, 2, 8, 65000.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id_kategori_produk` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id_kategori_produk`, `nama_kategori`, `status_dihapus`) VALUES
(1, 'Sayur', 0),
(2, 'Sembako', 0);

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan_produk`
--

CREATE TABLE `penerimaan_produk` (
  `id_penerimaan_produk` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0,
  `id_pengguna` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penerimaan_produk`
--

INSERT INTO `penerimaan_produk` (`id_penerimaan_produk`, `tanggal`, `keterangan`, `status_dihapus`, `id_pengguna`) VALUES
(3, '2025-05-16', 'Dibeli dair Bos Bawang Tanah Jawa', 0, 1),
(4, '2025-05-16', 'Dibeli dari Malin ', 0, 1),
(5, '2025-05-17', 'Dari Awan\r\n', 1, 1),
(6, '2025-05-17', 'tre', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran_produk`
--

CREATE TABLE `pengeluaran_produk` (
  `id_pengeluaran_produk` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `penerima` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengeluaran_produk`
--

INSERT INTO `pengeluaran_produk` (`id_pengeluaran_produk`, `id_pengguna`, `tanggal`, `penerima`, `keterangan`, `status_dihapus`) VALUES
(2, 1, '2025-05-17', 'Padli', 'Cash', 1),
(3, 1, '2025-05-16', 'Padli', 'cash', 0),
(4, 1, '2025-05-17', 'Padli', 'as', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `nomor_hp` varchar(15) NOT NULL,
  `role` enum('Admin','Kasir','Pemilik') NOT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`, `nama_lengkap`, `alamat`, `jenis_kelamin`, `nomor_hp`, `role`, `status_dihapus`) VALUES
(1, 'admin', '$2y$10$TSxrwy02BupTyuKxYZhi8etGqBjF.K//4QSqGkJTrhzoUJH9FNTVq', 'Admin Utama', 'Padang', 'Laki-Laki', '081232122112', 'Admin', 0),
(2, 'pemilik', '$2y$10$I33M77.DX7tjfzceYp4yOekXZTjrQL/Y0FDZ4JcDkC/ptQiomM28a', 'Pemilik', 'Padang', 'Laki-Laki', '081232123212', 'Pemilik', 0),
(3, 'kasir', '$2y$10$VYZomIAiMs.ip/c6qNhTZeMdOFyrttg5FWao8BdE.mVu3sP8bNGjK', 'Kasir', 'Padang', 'Perempuan', '081232123212', 'Kasir', 0);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `kode_produk` varchar(20) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `id_kategori_produk` int(11) NOT NULL,
  `id_satuan_produk` int(11) NOT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `stok_minimum` int(11) NOT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama_produk`, `id_kategori_produk`, `id_satuan_produk`, `harga_beli`, `harga_jual`, `stok`, `stok_minimum`, `status_dihapus`) VALUES
(1, 'BRG001', 'Cabai Merah', 2, 12, 50000.00, 60000.00, 8, 5, 0),
(2, 'BRG002', 'Cabai Hijau', 1, 12, 60000.00, 65000.00, 2, 5, 0),
(23, 'BRG003', 'Cabai Keriting', 2, 12, 25000.00, 45000.00, 0, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `satuan_produk`
--

CREATE TABLE `satuan_produk` (
  `id_satuan_produk` int(11) NOT NULL,
  `nama_satuan` varchar(50) NOT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan_produk`
--

INSERT INTO `satuan_produk` (`id_satuan_produk`, `nama_satuan`, `status_dihapus`) VALUES
(1, 'Liter', 0),
(2, 'PCS', 0),
(12, 'Kg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_penerimaan_produk`
--
ALTER TABLE `detail_penerimaan_produk`
  ADD PRIMARY KEY (`id_detail_penerimaan_produk`),
  ADD KEY `penerimaan_produk_id` (`penerimaan_produk_id`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `detail_pengeluaran_produk`
--
ALTER TABLE `detail_pengeluaran_produk`
  ADD PRIMARY KEY (`id_detail_pengeluaran`),
  ADD KEY `id_pengeluaran_produk` (`id_pengeluaran_produk`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id_kategori_produk`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indexes for table `penerimaan_produk`
--
ALTER TABLE `penerimaan_produk`
  ADD PRIMARY KEY (`id_penerimaan_produk`),
  ADD KEY `fk_pengguna` (`id_pengguna`);

--
-- Indexes for table `pengeluaran_produk`
--
ALTER TABLE `pengeluaran_produk`
  ADD PRIMARY KEY (`id_pengeluaran_produk`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `kode_produk` (`kode_produk`),
  ADD KEY `id_kategori_produk` (`id_kategori_produk`),
  ADD KEY `id_satuan_produk` (`id_satuan_produk`);

--
-- Indexes for table `satuan_produk`
--
ALTER TABLE `satuan_produk`
  ADD PRIMARY KEY (`id_satuan_produk`),
  ADD UNIQUE KEY `nama_satuan` (`nama_satuan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_penerimaan_produk`
--
ALTER TABLE `detail_penerimaan_produk`
  MODIFY `id_detail_penerimaan_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `detail_pengeluaran_produk`
--
ALTER TABLE `detail_pengeluaran_produk`
  MODIFY `id_detail_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id_kategori_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `penerimaan_produk`
--
ALTER TABLE `penerimaan_produk`
  MODIFY `id_penerimaan_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengeluaran_produk`
--
ALTER TABLE `pengeluaran_produk`
  MODIFY `id_pengeluaran_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `satuan_produk`
--
ALTER TABLE `satuan_produk`
  MODIFY `id_satuan_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_penerimaan_produk`
--
ALTER TABLE `detail_penerimaan_produk`
  ADD CONSTRAINT `detail_penerimaan_produk_ibfk_1` FOREIGN KEY (`penerimaan_produk_id`) REFERENCES `penerimaan_produk` (`id_penerimaan_produk`),
  ADD CONSTRAINT `detail_penerimaan_produk_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `detail_pengeluaran_produk`
--
ALTER TABLE `detail_pengeluaran_produk`
  ADD CONSTRAINT `detail_pengeluaran_produk_ibfk_1` FOREIGN KEY (`id_pengeluaran_produk`) REFERENCES `pengeluaran_produk` (`id_pengeluaran_produk`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pengeluaran_produk_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `penerimaan_produk`
--
ALTER TABLE `penerimaan_produk`
  ADD CONSTRAINT `fk_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `pengeluaran_produk`
--
ALTER TABLE `pengeluaran_produk`
  ADD CONSTRAINT `pengeluaran_produk_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori_produk`) REFERENCES `kategori_produk` (`id_kategori_produk`),
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_satuan_produk`) REFERENCES `satuan_produk` (`id_satuan_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

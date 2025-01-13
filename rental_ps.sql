-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 09:27 AM
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
-- Database: `rental_ps`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `username`, `password`) VALUES
(1, 'Hasyim', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_dt` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_playstation` int(11) DEFAULT NULL,
  `jumlah_item` int(11) DEFAULT NULL,
  `harga_sewa` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_dt`, `id_transaksi`, `id_playstation`, `jumlah_item`, `harga_sewa`) VALUES
(41, 20, 3, 1, 100000.00),
(42, 21, 2, 1, 70000.00),
(43, 21, 4, 2, 30000.00),
(44, 22, 3, 2, 100000.00),
(45, 23, 4, 1, 30000.00),
(46, 23, 8, 2, 25000.00),
(47, 24, 9, 1, 90000.00),
(48, 25, 9, 1, 90000.00),
(49, 26, 4, 1, 30000.00),
(50, 27, 2, 1, 70000.00),
(51, 28, 1, 2, 50000.00),
(52, 29, 4, 2, 30000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `alamat`, `email`, `no_telepon`) VALUES
(6, 'Hasyim', 'Sleman', 'hasyimdani@gmail.com', '08954030075'),
(7, 'Steven', 'Minggir', 'venn@gmail.com', '08932478372'),
(8, 'Yudha', 'Godean', 'yudha@gmail.com', '08924728642'),
(9, 'Fairul', 'Concat', 'fairul@gmail.com', '08973846833'),
(10, 'Rehan', 'Godean', 'rehan@gmail.com', '08973826423'),
(11, 'Syaiful', 'Gamping', 'syaiful@gmail.com', '08976349893'),
(12, 'Akram', 'Seyegan', 'akram@gmail.com', '08319384623'),
(13, 'Hanif', 'Sleman', 'hanif@gmail.com', '08932938294'),
(14, 'Wikan', 'Senturan', 'wikan@gmail.com', '0893278263'),
(15, 'Dimas', 'Seyegan', 'dimss@gmail.com', '08931972842');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `metode_bayar` varchar(20) DEFAULT NULL,
  `jumlah_bayar` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_transaksi`, `tanggal_bayar`, `metode_bayar`, `jumlah_bayar`) VALUES
(13, 20, '2025-01-03', 'Transfer', 200000.00),
(14, 21, '2025-01-03', 'Cash', 130000.00),
(15, 22, '2025-01-05', 'E-Wallet', 200000.00),
(16, 23, '2025-01-15', 'Transfer', 160000.00),
(17, 26, '2025-01-13', 'Cash', 150000.00),
(18, 27, '2025-01-05', 'Cash', 215000.00),
(19, 28, '2025-01-10', 'Cash', 900000.00),
(20, 29, '2025-01-13', 'Transfer', 305000.00);

-- --------------------------------------------------------

--
-- Table structure for table `playstation`
--

CREATE TABLE `playstation` (
  `id_playstation` int(11) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `harga_sewa` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playstation`
--

INSERT INTO `playstation` (`id_playstation`, `kategori`, `harga_sewa`) VALUES
(1, 'PS4', 50000.00),
(2, 'PS4 Pro', 70000.00),
(3, 'PS5', 100000.00),
(4, 'PS3', 30000.00),
(5, 'PS2', 20000.00),
(6, 'PS1', 15000.00),
(7, 'PS Vita', 40000.00),
(8, 'PSP', 25000.00),
(9, 'PS5 Digital', 90000.00),
(10, 'PS Classic', 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `tanggal_sewa` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `tanggal_sewa`, `tanggal_kembali`, `status`) VALUES
(20, 6, '2025-01-01', '2025-01-03', 'Lunas'),
(21, 7, '2025-01-02', '2025-01-03', 'Lunas'),
(22, 8, '2025-01-04', '2025-01-05', 'Lunas'),
(23, 9, '2025-01-13', '2025-01-15', 'Lunas'),
(24, 10, '2025-01-13', '2025-01-20', 'Proses'),
(25, 11, '2025-01-01', '2025-01-13', 'Proses'),
(26, 12, '2025-01-08', '2025-01-13', 'Lunas'),
(27, 13, '2025-01-01', '2025-01-04', 'Lunas'),
(28, 14, '2025-01-01', '2025-01-10', 'Lunas'),
(29, 15, '2025-01-07', '2025-01-12', 'Lunas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_dt`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_playstation` (`id_playstation`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `playstation`
--
ALTER TABLE `playstation`
  ADD PRIMARY KEY (`id_playstation`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_dt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `playstation`
--
ALTER TABLE `playstation`
  MODIFY `id_playstation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_playstation`) REFERENCES `playstation` (`id_playstation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

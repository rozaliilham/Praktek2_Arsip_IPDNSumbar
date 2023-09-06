-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2022 at 12:49 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kas_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `kas_keluar`
--

CREATE TABLE `kas_keluar` (
  `id_kas_keluar` int(11) NOT NULL,
  `no_kas_keluar` text NOT NULL,
  `outlet_kas_keluar` text NOT NULL,
  `tgl_kas_keluar` date NOT NULL,
  `jml_kas_keluar` int(11) NOT NULL,
  `operator_kas_keluar` text NOT NULL,
  `operator_edit_kas_keluar` text DEFAULT NULL,
  `ket_kas_keluar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kas_keluar`
--

INSERT INTO `kas_keluar` (`id_kas_keluar`, `no_kas_keluar`, `outlet_kas_keluar`, `tgl_kas_keluar`, `jml_kas_keluar`, `operator_kas_keluar`, `operator_edit_kas_keluar`, `ket_kas_keluar`) VALUES
(3, '987654321', 'PT Bhakti Sentosa', '2022-01-31', 1500000, '15', NULL, 'Pembelian Aset'),
(4, '9876543278', 'PT Buana Karya', '2022-01-31', 7500000, '15', NULL, 'Pembelian CPU Set'),
(6, '6542878', 'Bengkok Ahli', '2022-01-31', 3500000, '16', NULL, 'Pembayaran Listrik'),
(7, '6541789', 'Garta Jaya', '2022-01-26', 1500000, '16', NULL, 'Pembayaran PDAM');

-- --------------------------------------------------------

--
-- Table structure for table `kas_masuk`
--

CREATE TABLE `kas_masuk` (
  `id_kas_masuk` int(11) NOT NULL,
  `no_kas_masuk` text NOT NULL,
  `outlet_kas_masuk` text NOT NULL,
  `tgl_kas_masuk` date NOT NULL,
  `jml_kas_masuk` int(11) NOT NULL,
  `operator_kas_masuk` text NOT NULL,
  `operator_edit_kas_masuk` text DEFAULT NULL,
  `ket_kas_masuk` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kas_masuk`
--

INSERT INTO `kas_masuk` (`id_kas_masuk`, `no_kas_masuk`, `outlet_kas_masuk`, `tgl_kas_masuk`, `jml_kas_masuk`, `operator_kas_masuk`, `operator_edit_kas_masuk`, `ket_kas_masuk`) VALUES
(4, '123456', 'Janggo', '2022-01-31', 1500000, '15', NULL, 'Pembelian Aset'),
(5, '654321', 'PT Santika', '2022-01-31', 2500000, '15', NULL, 'Pembelian Aset'),
(7, '65456', 'PT Kartika Sentosa', '2022-01-31', 550000, '16', NULL, 'Penjualan Kusen'),
(8, '987654', 'PT Jamba', '2022-02-02', 1500000, '16', 'Donny Kurniawan', 'Penjualan Kulkas');

-- --------------------------------------------------------

--
-- Table structure for table `mst_user`
--

CREATE TABLE `mst_user` (
  `id_user` int(11) NOT NULL,
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `level` text NOT NULL,
  `date_created` date NOT NULL,
  `image` text NOT NULL,
  `is_active` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_user`
--

INSERT INTO `mst_user` (`id_user`, `nama`, `email`, `password`, `level`, `date_created`, `image`, `is_active`) VALUES
(15, 'Donny Kurniawan', 'admin@gmail.com', '$2y$10$1CGoPtKRjQXU.kjmLiIoueroxm6TSleJ8NjyIKTKeDzOqvmyJcYwW', 'Admin', '2019-10-02', 'avatar5.png', 1),
(16, 'Ratna Damayanti', 'user@gmail.com', '$2y$10$8ShksvWp8.2l6AxLrIhTHegKP8eL4BkP6xSwuUsTmAiuoQ5qBEnkO', 'User', '2019-10-02', '21.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_activity`
--

CREATE TABLE `tb_activity` (
  `id_activity` int(11) NOT NULL,
  `sess_id` int(11) NOT NULL,
  `date_activity` date NOT NULL,
  `time_activity` time NOT NULL,
  `activity` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_activity`
--

INSERT INTO `tb_activity` (`id_activity`, `sess_id`, `date_activity`, `time_activity`, `activity`) VALUES
(1, 16, '2022-02-02', '07:15:21', 'Mengubah profil Akun'),
(2, 16, '2022-02-02', '07:17:28', 'Mengubah Password Akun'),
(3, 16, '2022-02-02', '07:17:48', 'Menginput data kas masuk dengan no : 987654'),
(4, 16, '2022-02-02', '07:26:26', 'Mengubah data kas masuk dengan no : 987654');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kas_keluar`
--
ALTER TABLE `kas_keluar`
  ADD PRIMARY KEY (`id_kas_keluar`);

--
-- Indexes for table `kas_masuk`
--
ALTER TABLE `kas_masuk`
  ADD PRIMARY KEY (`id_kas_masuk`);

--
-- Indexes for table `mst_user`
--
ALTER TABLE `mst_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_activity`
--
ALTER TABLE `tb_activity`
  ADD PRIMARY KEY (`id_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kas_keluar`
--
ALTER TABLE `kas_keluar`
  MODIFY `id_kas_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kas_masuk`
--
ALTER TABLE `kas_masuk`
  MODIFY `id_kas_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mst_user`
--
ALTER TABLE `mst_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tb_activity`
--
ALTER TABLE `tb_activity`
  MODIFY `id_activity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2019 at 12:30 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pj_zai`
--

-- --------------------------------------------------------

--
-- Table structure for table `kantor_keluar`
--

CREATE TABLE `kantor_keluar` (
  `id` int(5) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kantor_keluar`
--

INSERT INTO `kantor_keluar` (`id`, `jumlah`, `tanggal`, `keterangan`) VALUES
(27, 500000, '2019-07-01', 'Beli HP M-Banking');

-- --------------------------------------------------------

--
-- Table structure for table `kantor_masuk`
--

CREATE TABLE `kantor_masuk` (
  `id` int(5) NOT NULL,
  `keterangan` varchar(254) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kantor_masuk`
--

INSERT INTO `kantor_masuk` (`id`, `keterangan`, `tanggal`, `jumlah`) VALUES
(43, 'jack', '2019-07-01', 1000000),
(44, 'PT Hardi', '2019-08-08', 354000),
(45, 'PT Lida', '2019-08-08', 380000);

-- --------------------------------------------------------

--
-- Table structure for table `laba`
--

CREATE TABLE `laba` (
  `id_laba` varchar(254) NOT NULL,
  `total_invoice` varchar(254) NOT NULL,
  `total_zai` varchar(255) DEFAULT NULL,
  `total_saldo_laba` varchar(254) NOT NULL,
  `total_andi` varchar(255) DEFAULT NULL,
  `total_rasit` varchar(255) DEFAULT NULL,
  `total_kantor` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `tgl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laba`
--

INSERT INTO `laba` (`id_laba`, `total_invoice`, `total_zai`, `total_saldo_laba`, `total_andi`, `total_rasit`, `total_kantor`, `status`, `tgl`) VALUES
('MjAxOTA4MDgyMjIwMzc=', '3000000', '75000', '1835000', '550500', '550500', '734000', '1', '2019-08-08');

-- --------------------------------------------------------

--
-- Table structure for table `list_laba`
--

CREATE TABLE `list_laba` (
  `id_list_laba` int(11) NOT NULL,
  `id_laba` varchar(255) DEFAULT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `total_invoice` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `zai` varchar(255) DEFAULT NULL,
  `biaya_produksi` varchar(255) DEFAULT NULL,
  `saldo_laba` varchar(255) DEFAULT NULL,
  `andi` varchar(255) DEFAULT NULL,
  `rasit` varchar(255) DEFAULT NULL,
  `kantor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list_laba`
--

INSERT INTO `list_laba` (`id_list_laba`, `id_laba`, `customer`, `invoice`, `total_invoice`, `keterangan`, `zai`, `biaya_produksi`, `saldo_laba`, `andi`, `rasit`, `kantor`) VALUES
(3, 'MjAxOTA4MDgyMjIwMzc=', 'PT Hardi', 'HS01', '1000000', 'LUNAS', '25000', '90000', '885000', '265500', '265500', '354000'),
(4, 'MjAxOTA4MDgyMjIwMzc=', 'PT Lida', 'LD01', '2000000', 'LUNAS', '50000', '1000000', '950000', '285000', '285000', '380000');

-- --------------------------------------------------------

--
-- Table structure for table `operasional_keluar`
--

CREATE TABLE `operasional_keluar` (
  `id` int(5) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(254) NOT NULL,
  `tgl_membuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `operasional_masuk`
--

CREATE TABLE `operasional_masuk` (
  `id` int(5) NOT NULL,
  `keterangan` varchar(254) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(10) NOT NULL,
  `tgl_membuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(225) NOT NULL,
  `image` varchar(150) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `image`, `role_id`, `is_active`, `date_created`) VALUES
(30, 'admin', 'admin@gmail.com', '$2y$10$aIdxeVWcM4fO.QzRlhascuEP54beuaCiZte5swALQAovwFHkH1VcC', 'default.jpg', 1, 1, 1564384909),
(31, 'hardisubagyo', 'hardi@gmail.com', '$2y$10$BHVYAgZqt2QMMPPpIDkUJeKjoL0rs4IZ9aoHJzwIaB6ZFBBnHIAOC', 'default.jpg', 2, 0, 1564756233),
(32, 'Hardi Subagyo', 'hardi.subagyo@gmail.com', '$2y$10$PfN0nWHlamNv/beGgG6L6e9T5z39FYQok713iYCCzeqT6Zdzf5jZ2', 'default.jpg', 2, 0, 1564805412);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(23, 1, 6),
(40, 1, 8),
(41, 1, 3),
(42, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(4, 'test'),
(5, 'Produk'),
(6, 'Kas Kantor'),
(7, 'Laporan'),
(8, 'Kas Operasional');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `tittle` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `tittle`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(7, 1, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(11, 6, 'Kas Masuk', 'kantor/kasmasuk', 'fas fa-plus', 1),
(12, 6, 'Kas Keluar', 'kantor/kaskeluar', 'fas fa-minus', 1),
(13, 7, 'Laporan Kantor', 'reportkantor/index', 'fas fa-chart-pie', 1),
(14, 8, 'Masuk', 'operasional/kasmasuk', 'fas fa-plus', 1),
(15, 8, 'Keluar', 'operasional/kaskeluar', 'fas fa-minus', 1),
(16, 7, 'Laporan Operasional', 'reportoperasional/index', 'fas fa-chart-area', 1),
(17, 7, 'Persentase Laba', 'laba/index', 'fas fa-chart-line', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kantor_keluar`
--
ALTER TABLE `kantor_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kantor_masuk`
--
ALTER TABLE `kantor_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laba`
--
ALTER TABLE `laba`
  ADD PRIMARY KEY (`id_laba`);

--
-- Indexes for table `list_laba`
--
ALTER TABLE `list_laba`
  ADD PRIMARY KEY (`id_list_laba`);

--
-- Indexes for table `operasional_keluar`
--
ALTER TABLE `operasional_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operasional_masuk`
--
ALTER TABLE `operasional_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kantor_keluar`
--
ALTER TABLE `kantor_keluar`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `kantor_masuk`
--
ALTER TABLE `kantor_masuk`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `list_laba`
--
ALTER TABLE `list_laba`
  MODIFY `id_list_laba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `operasional_keluar`
--
ALTER TABLE `operasional_keluar`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `operasional_masuk`
--
ALTER TABLE `operasional_masuk`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

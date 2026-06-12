-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2026 at 03:51 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_latihan_trpl1a_sunusetyojati`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_tiket`
--

CREATE TABLE `tabel_tiket` (
  `id_tiket` int NOT NULL,
  `nama_film` varchar(100) NOT NULL,
  `jadwal_tayang` datetime NOT NULL,
  `jumlah_kursi` int NOT NULL,
  `harga_dasar_tiket` decimal(10,2) NOT NULL,
  `jenis_studio` enum('Regular','IMAX','Velvet') NOT NULL,
  `tipe_audio` varchar(50) DEFAULT NULL,
  `lokasi_baris` varchar(10) DEFAULT NULL,
  `kacamata_3d_id` varchar(50) DEFAULT NULL,
  `efek_gerak_fitur` varchar(50) DEFAULT NULL,
  `bantal_selimut_pack` varchar(50) DEFAULT NULL,
  `layanan_butler` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_tiket`
--

INSERT INTO `tabel_tiket` (`id_tiket`, `nama_film`, `jadwal_tayang`, `jumlah_kursi`, `harga_dasar_tiket`, `jenis_studio`, `tipe_audio`, `lokasi_baris`, `kacamata_3d_id`, `efek_gerak_fitur`, `bantal_selimut_pack`, `layanan_butler`) VALUES
(1, 'Avengers: Secret Wars', '2026-07-01 13:00:00', 100, 50000.00, 'Regular', 'Dolby Digital 5.1', 'Baris A-E', NULL, NULL, NULL, NULL),
(2, 'Avengers: Secret Wars', '2026-07-01 16:00:00', 100, 50000.00, 'Regular', 'Dolby Digital 5.1', 'Baris F-J', NULL, NULL, NULL, NULL),
(3, 'Avatar 3', '2026-07-01 14:00:00', 120, 50000.00, 'Regular', 'DTS:X', 'Baris A-E', NULL, NULL, NULL, NULL),
(4, 'Avatar 3', '2026-07-01 19:00:00', 120, 55000.00, 'Regular', 'DTS:X', 'Baris F-J', NULL, NULL, NULL, NULL),
(5, 'Batman: Resurgence', '2026-07-02 13:00:00', 90, 50000.00, 'Regular', 'Standard Stereo', 'Baris A-D', NULL, NULL, NULL, NULL),
(6, 'Batman: Resurgence', '2026-07-02 18:30:00', 90, 55000.00, 'Regular', 'Standard Stereo', NULL, NULL, NULL, NULL, NULL),
(7, 'Spiderman: No Way Home', '2026-07-02 21:00:00', 100, 55000.00, 'Regular', NULL, 'Baris E-G', NULL, NULL, NULL, NULL),
(8, 'Interstellar Remastered', '2026-07-01 12:00:00', 150, 75000.00, 'IMAX', NULL, NULL, '3D-IMAX-001', 'Standard NoMotion', NULL, NULL),
(9, 'Interstellar Remastered', '2026-07-01 15:30:00', 150, 75000.00, 'IMAX', NULL, NULL, '3D-IMAX-002', 'Standard NoMotion', NULL, NULL),
(10, 'Dune: Part Three', '2026-07-01 19:00:00', 150, 85000.00, 'IMAX', NULL, NULL, '3D-IMAX-003', '4DX Motion Active', NULL, NULL),
(11, 'Dune: Part Three', '2026-07-01 22:30:00', 150, 85000.00, 'IMAX', NULL, NULL, '3D-IMAX-004', '4DX Motion Active', NULL, NULL),
(12, 'Star Wars: New Order', '2026-07-02 14:00:00', 150, 75000.00, 'IMAX', NULL, NULL, NULL, 'Standard NoMotion', NULL, NULL),
(13, 'Star Wars: New Order', '2026-07-02 20:00:00', 150, 85000.00, 'IMAX', NULL, NULL, NULL, '4DX Motion Active', NULL, NULL),
(14, 'Inception 2', '2026-07-03 16:00:00', 150, 75000.00, 'IMAX', NULL, NULL, '3D-IMAX-005', NULL, NULL, NULL),
(15, 'Titanic: Love Lives On', '2026-07-01 14:45:00', 40, 150000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Satin Pack Gold', 'Butler On-Call'),
(16, 'Titanic: Love Lives On', '2026-07-01 20:15:00', 40, 175000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Satin Pack Gold', 'Butler On-Call'),
(17, 'The Notebook 2', '2026-07-02 15:00:00', 40, 150000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Silk Pack Platinum', 'VIP Private Service'),
(18, 'The Notebook 2', '2026-07-02 19:30:00', 40, 175000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Silk Pack Platinum', 'VIP Private Service'),
(19, 'La La Land Sequel', '2026-07-03 13:00:00', 40, 150000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Standard Velvet Pack', 'Butler On-Call'),
(20, 'Midnight in Paris 2', '2026-07-03 21:00:00', 40, 175000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Standard Velvet Pack', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  ADD PRIMARY KEY (`id_tiket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

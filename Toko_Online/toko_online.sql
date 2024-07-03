-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 10:45 AM
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
-- Database: `toko_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`) VALUES
(1, 'Baju Pria'),
(2, 'Baju Wanita'),
(3, 'Hoodie'),
(4, 'Jam Tangan'),
(5, 'Topi'),
(14, 'sepatu');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama_pembeli` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `tanggal_pembayaran` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `user_id`, `nama_pembeli`, `alamat`, `nomor_telepon`, `total_harga`, `tanggal_pembayaran`) VALUES
(3, 2, 'User1', 'Cikarang', '081234567890', 1480000, '2024-06-27 15:03:12'),
(4, 2, 'User1', 'Cikarang', '081234567890', 1280000, '2024-06-27 16:06:48'),
(5, 2, 'User1', 'cikarang', '081234567890', 560000, '2024-07-02 12:03:26'),
(6, 2, 'User1', 'cikarang', '081234567890', 560000, '2024-07-02 12:08:52'),
(7, 2, 'User1', 'Cikarang', '081234567890', 560000, '2024-07-02 12:19:45'),
(8, 2, 'User1', 'cikarang', '081234567890', 560000, '2024-07-02 12:25:38');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_detail`
--

CREATE TABLE `pembayaran_detail` (
  `id` int(11) NOT NULL,
  `pembayaran_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga_satuan` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran_detail`
--

INSERT INTO `pembayaran_detail` (`id`, `pembayaran_id`, `produk_id`, `nama_produk`, `jumlah`, `harga_satuan`, `total_harga`) VALUES
(4, 3, 3, NULL, 2, 120000, 240000),
(5, 3, 6, NULL, 1, 1000000, 1000000),
(6, 3, 8, NULL, 3, 80000, 240000),
(7, 4, 2, 'Baju 1', 2, 100000, 200000),
(8, 4, 6, 'Jam Tangan 1', 1, 1000000, 1000000),
(9, 4, 8, 'Topi 1', 1, 80000, 80000),
(10, 5, 2, 'Baju 1', 3, 100000, 300000),
(11, 5, 4, 'Baju 3', 2, 130000, 260000),
(12, 6, 2, 'Baju 1', 3, 100000, 300000),
(13, 6, 4, 'Baju 3', 2, 130000, 260000),
(14, 7, 2, 'Baju 1', 3, 100000, 300000),
(15, 7, 4, 'Baju 3', 2, 130000, 260000),
(16, 8, 2, 'Baju 1', 3, 100000, 300000),
(17, 8, 4, 'Baju 3', 2, 130000, 260000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` double NOT NULL,
  `modal` double NOT NULL,
  `stok` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `ketersediaan_stok` enum('habis','tersedia') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kategori_id`, `nama`, `harga`, `modal`, `stok`, `foto`, `detail`, `ketersediaan_stok`) VALUES
(2, 1, 'Baju 1', 100000, 70000, 3, 'Hcs7s4AnjpuphZjrzHiy.jpg', '                                                                        Ini Detail Produk                                                            ', 'tersedia'),
(3, 2, 'Baju 2', 120000, 80000, 2, 'lkThyimuB4563hqgpO3Z.jpg', '                        Ini detail produk                    ', 'tersedia'),
(4, 1, 'Baju 3', 130000, 0, 1, 'o3BjZAvsq1A3x3nGHOMk.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur omnis ad sunt doloribus optio nobis perferendis architecto quibusdam vel repellendus alias adipisci, saepe molestias modi voluptatem sint. Sed, facere. Ex, officia? Fugiat magnam corrupti quo repellat quidem. Sit necessitatibus dolore voluptatibus rem, ipsa corporis, animi molestiae cupiditate eveniet fugit molestias adipisci. Veniam pariatur quidem atque illum. Quidem dolorum cupiditate molestias voluptas excepturi et vero veritatis, sit assumenda eum quo, veniam aliquid neque quam blanditiis commodi? Veniam officia natus nesciunt quae. Dolorum facilis provident, alias, vitae repellat odio blanditiis harum numquam quae, neque porro assumenda quisquam eligendi recusandae obcaecati pariatur accusantium!', 'tersedia'),
(5, 2, 'Baju 4', 130000, 0, 0, 'QOrtVYNlRmwrljVLR3UB.jpg', 'Ini detail produk', 'habis'),
(6, 4, 'Jam Tangan 1', 1000000, 0, 1, 'wBMuEtKAUFJULfPZnYP0.jpg', 'Ini detail produk', 'tersedia'),
(7, 4, 'Jam Tangan 2', 1500000, 0, 0, 'lOC2HOZXU3ePfF8hIB5E.jpg', 'Ini detail produk', 'habis'),
(8, 5, 'Topi 1', 80000, 0, 4, 'M8BjYZqPYJ8bXLY2xaLt.jpg', 'Ini detail produk', 'tersedia'),
(9, 5, 'Topi 2', 60000, 0, 0, '1ky018j0sAtYhKslwSre.jpg', 'Ini detail produk', 'habis'),
(10, 1, 'baju 5', 100000, 0, 2, 'q5zg2Y2sc8pgfmPwXmnM.jpg', 'ini detail produk', 'tersedia');

--
-- Triggers `produk`
--
DELIMITER $$
CREATE TRIGGER `update_ketersediaan_stok` BEFORE UPDATE ON `produk` FOR EACH ROW BEGIN
    IF NEW.stok = 0 THEN
        SET NEW.ketersediaan_stok = 'habis';
    ELSE
        SET NEW.ketersediaan_stok = 'tersedia';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id`, `user_id`, `foto_profil`, `email`, `alamat`, `nomor_telepon`, `tanggal_lahir`) VALUES
(1, 1, 'profil.jpg', NULL, NULL, NULL, NULL),
(2, 2, 'profil_2_1719905836.jpg', 'ricoprasetya24@gmail.com', 'cikarang selatan', '089526152552', '2004-01-24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2a$12$iO955st./2FI4RVBKWL.qOGJbwsm3kvgHIOBP7PMV7SDVhR/sG2uC', 'admin'),
(2, 'User 1', '$2y$10$MWu0RMQ4k.YXW1YvQ2B/aOBEJr8fSW0teOUGZsk57frcGDUrJMS0C', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `fk_user_keranjang` (`user_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pembayaran_detail`
--
ALTER TABLE `pembayaran_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_id` (`pembayaran_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama` (`nama`),
  ADD KEY `kategori_produk` (`kategori_id`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pembayaran_detail`
--
ALTER TABLE `pembayaran_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `fk_user_keranjang` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `keranjang_produk_fk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pembayaran_detail`
--
ALTER TABLE `pembayaran_detail`
  ADD CONSTRAINT `pembayaran_detail_ibfk_1` FOREIGN KEY (`pembayaran_id`) REFERENCES `pembayaran` (`id`),
  ADD CONSTRAINT `pembayaran_detail_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `kategori_produk` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

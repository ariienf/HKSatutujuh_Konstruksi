-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2026 at 12:56 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penyewaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat_konstruksi`
--

CREATE TABLE `alat_konstruksi` (
  `id_alat` int NOT NULL,
  `nama_alat` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_alat` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `biaya_sewa` decimal(10,2) NOT NULL,
  `minimum_sewa` int NOT NULL DEFAULT '1' COMMENT '''dalam hari''',
  `stok` int NOT NULL DEFAULT '0',
  `status_alat` enum('tersedia','habis','maintenance') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tersedia',
  `gambar_alat` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alat_konstruksi`
--

INSERT INTO `alat_konstruksi` (`id_alat`, `nama_alat`, `jenis_alat`, `deskripsi`, `biaya_sewa`, `minimum_sewa`, `stok`, `status_alat`, `gambar_alat`, `created_at`) VALUES
(1, 'Mini Excavator (5 Ton)', 'Alat Berat', 'Merk : Kobelco SK50\r\n\r\nBerat Operasional (kg) : 4.720Kg\r\nKapasitas Bucket (m3) : 0,14 m3\r\nKedalaman Gali Maksimum (m) : 3,6m\r\nTinggi (Transportasi) (m) : 2,5m\r\nPanjang (Transportasi) (m) : 5,4m\r\nLebar (Transportasi) (m) : 1,9m\r\n\r\nHarga sewa sudah dengan operator alat berat', '4495000.00', 1, 3, 'tersedia', 'alat_1781097050_843.png', '2026-06-10 13:08:11'),
(2, 'Excavator (20 Ton)', 'Alat Berat', 'Merk : Komatsu PC200\r\n\r\nBerat Operasional (kg) : 20.010Kg\r\nKapasitas Bucket (m3) : 1,10 m3\r\nKedalaman Gali Maksimum (m) : 6,09m\r\nTinggi (Transportasi) (m) : 3,2m\r\nPanjang (Transportasi) (m) : 5,7m\r\nLebar (Transportasi) (m) : 3m\r\n\r\nHarga sewa sudah dengan operator alat berat', '4495000.00', 1, 5, 'tersedia', 'alat_1781097986_282.png', '2026-06-10 13:26:26'),
(3, 'Mini Excavator (7,5 Ton)', 'Alat Berat', 'Merk : Komatsu PC75\r\n\r\nBerat Operasional (kg) : 7.400Kg\r\nKapasitas Bucket (m3) : 0,30 m3\r\nKedalaman Gali Maksimum (m) : 4,25m\r\nTinggi (Transportasi) (m) : 2,66m\r\nPanjang (Transportasi) (m) : 6m\r\nLebar (Transportasi) (m) : 2m\r\n\r\nHarga sewa sudah dengan operator alat berat', '4495000.00', 1, 5, 'tersedia', 'alat_1781098148_980.png', '2026-06-10 13:29:08'),
(4, 'Dozer Komatsu D65 (20 Ton)', 'Alat Berat', 'Merk : Komatsu D65\r\n\r\nBerat Operasional (kg) : 19.440kg\r\nLebar (mm) : 3.000mm\r\nPanjang Tanpa Blade (mm) : 4430mm\r\nPanjang Blade (mm) : 5.540mm\r\nTinggi Blade (mm) : 1.100mm\r\nKedalaman Potong (mm) : 540mm\r\nKapasitas Bahan Bakar : 406 Liter\r\n\r\nHarga sewa sudah dengan operator alat berat', '5935000.00', 1, 5, 'tersedia', 'alat_1781098229_861.png', '2026-06-10 13:30:29'),
(5, 'Dozer Komatsu D31P (8 Ton)', 'Alat Berat', 'Merk : Komatsu D31P\r\n\r\nBerat Operasional (kg) : 6.700kg\r\nLebar (mm) : 2.050mm\r\nPanjang Tanpa Blade (mm) : 3.030mm\r\nPanjang Blade (mm) : 3.850mm\r\nTinggi Blade (mm) : 780mm\r\nKedalaman Potong (mm) : 350mm\r\nKapasitas Bahan Bakar : 115 Liter\r\n\r\nHarga sewa sudah dengan operator alat berat', '4975000.00', 1, 5, 'tersedia', 'alat_1781098315_120.png', '2026-06-10 13:31:55'),
(6, 'Motor Grader Komatsu', 'Alat Berat', 'Merk : GD511A\r\n\r\nBerat Operasional (kg) : 12.000Kg\r\nTinggi (Transportasi) (m) : 3,7m\r\nPanjang (Transportasi) (m) : 7,9m\r\nLebar (Transportasi) (m) : 2,4m\r\n\r\nHarga sewa sudah dengan operator alat berat', '4975000.00', 1, 5, 'tersedia', 'alat_1781098420_628.png', '2026-06-10 13:33:40'),
(7, 'Genset 50-60 kVA', 'Alat Listrik', 'Merk : Airman SDG60S-3A6\r\n      \r\nDaya Output (kVA) : 50/60\r\nFrekuensi (Hz) : 50/60\r\nFaktor Tenaga (%) : 80\r\nDisplacement (L) : 4.329\r\nJumlah Silinder : 4\r\nKapasitas Tangki (L) : 170\r\nTegangan (V) : 200/400 atau 220/440', '500000.00', 30, 4, 'tersedia', 'alat_1784437742_857.png', '2026-07-19 05:09:02'),
(8, 'Forklift Doosan (3 Ton)', 'Alat Berat', 'Merk : Doosan D30S-5\r\n      \r\nKapasitas Beban (kg) : 3.000kg\r\nBerat Operasional (kg) : 4.450mm\r\nPanjang (mm) : 3.030mm\r\nPanjang Blade (mm) : 2.700mm\r\nLebar (mm) : 1.197mm\r\nTinggi (mm) : 2.183mm\r\nPusat Beban (mm) : 500mm\r\nRadius Belok Minimum (mm) : 2.365mm\r\nKecepatan Jalan dengan Beban (km/jam) : 18,5\r\nKecepatan Angkat dengan Beban (mm/s) : 500\r\nTenaga : Diesel\r\n\r\nHarga sewa sudah dengan operator alat berat', '850000.00', 30, 10, 'tersedia', 'alat_1784437855_944.png', '2026-07-19 05:10:55'),
(9, 'Forklift Doosan (7 Ton)', 'Alat Berat', 'Merk : Doosan D70S-5\r\n      \r\nKapasitas Beban (kg) : 7.030 Kg\r\nBerat Operasional (kg) : 9.970mm\r\nPanjang (mm) : 3.647mm\r\nLebar (mm) : 2.108mm\r\nTinggi (mm) : 2.500mm\r\nPusat Beban (mm) : 610mm\r\nRadius Belok Minimum (mm) : 3.380mm\r\nKecepatan Jalan dengan Beban (km/jam) : 28,5\r\nKecepatan Angkat dengan Beban (mm/s) : 445\r\nTenaga : Diesel\r\n\r\nHarga sewa sudah dengan operator alat berat', '1370000.00', 30, 10, 'tersedia', 'alat_1784437938_837.png', '2026-07-19 05:12:19');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penyewaan`
--

CREATE TABLE `detail_penyewaan` (
  `id_detail` int NOT NULL,
  `id_penyewaan` int NOT NULL,
  `id_alat` int NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_penyewaan`
--

INSERT INTO `detail_penyewaan` (`id_detail`, `id_penyewaan`, `id_alat`, `jumlah`, `subtotal`) VALUES
(1, 1, 6, 1, '400000.00'),
(2, 2, 6, 1, '400000.00'),
(3, 3, 4, 2, '1440000.00'),
(4, 4, 2, 1, '8990000.00'),
(5, 5, 7, 1, '15000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int NOT NULL,
  `nama_pelanggan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(13) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `foto_ktp` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_perusahaan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `email`, `password`, `no_hp`, `alamat`, `jenis_kelamin`, `foto_ktp`, `nama_perusahaan`, `created_at`) VALUES
(1, 'Arie Nur Fauzi', 'arie@gmail.com', '$2y$10$Xkkky/kkdN2B1qHGeF32Su/8ZpzvIBmtxTGPs2DmYrAHixen4Vxvu', '081285004500', 'Jl. Kawi Raya', 'Laki-laki', 'ktp_1781099669_664.jpg', 'PT. Makin Maju Sejahtera', '2026-06-10 13:54:29'),
(2, 'Eky Kenamon', 'eky@gmail.com', '$2y$10$z6mI0BNUHR8lq0rYyL2QiuuMFya59dUR7LqG4JLuWSen202BuUHB.', '081280809090', 'Jl. Koala No. 10, Kel. Jatinegara, Jakarta Timur', 'Laki-laki', 'ktp_1784469196_212.jpeg', 'PT. Sumber Rezeki', '2026-07-19 13:53:17');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_penyewaan` int NOT NULL,
  `kode_transaksi` varchar(17) NOT NULL,
  `total_bayar` decimal(12,2) NOT NULL,
  `metode_bayar` enum('transfer_bank','qris','tunai') NOT NULL,
  `status_bayar` enum('menunggu','lunas','gagal') DEFAULT 'menunggu',
  `tanggal_bayar` datetime DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_penyewaan`, `kode_transaksi`, `total_bayar`, `metode_bayar`, `status_bayar`, `tanggal_bayar`, `bukti_bayar`, `created_at`) VALUES
(1, 1, 'TRX-20260610-0001', '400000.00', 'transfer_bank', 'lunas', '2026-06-10 14:24:27', 'bukti_1781100856_238.jpeg', '2026-06-10 14:14:16'),
(2, 2, 'TRX-20260615-0001', '400000.00', 'transfer_bank', 'lunas', '2026-06-15 04:07:44', 'bukti_1781495611_955.jpeg', '2026-06-15 03:53:31'),
(3, 3, 'TRX-20260627-0001', '1440000.00', 'transfer_bank', 'lunas', '2026-06-27 03:00:34', 'bukti_1782529164_556.jpeg', '2026-06-27 02:59:24'),
(4, 4, 'TRX-20260719-0001', '8990000.00', 'transfer_bank', 'lunas', '2026-07-19 14:01:02', 'bukti_1784469496_669.jpg', '2026-07-19 13:58:16'),
(5, 5, 'TRX-20260719-0002', '15000000.00', 'transfer_bank', 'lunas', '2026-07-19 14:19:49', 'bukti_1784470754_101.jpg', '2026-07-19 14:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int NOT NULL,
  `id_penyewaan` int NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `status_pengembalian` enum('tepat_waktu','terlambat') DEFAULT 'tepat_waktu',
  `denda` decimal(10,2) DEFAULT '0.00',
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `id_penyewaan`, `tanggal_pengembalian`, `status_pengembalian`, `denda`, `keterangan`, `created_at`) VALUES
(1, 1, '2026-06-13', 'tepat_waktu', '0.00', 'Kondisi aman dan tidak ada kendala', '2026-06-13 16:16:23'),
(2, 2, '2026-06-27', 'terlambat', '180000.00', 'Alat kondisi baik', '2026-06-27 02:45:04'),
(3, 3, '2026-07-01', 'terlambat', '48000.00', 'Kondisi aman', '2026-07-01 15:13:20'),
(4, 4, '2026-07-22', 'tepat_waktu', '0.00', 'Kondisi alat baik dan tidak ada kendala', '2026-07-19 14:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `penyewaan`
--

CREATE TABLE `penyewaan` (
  `id_penyewaan` int NOT NULL,
  `kode_penyewaan` varchar(17) NOT NULL,
  `id_pelanggan` int NOT NULL,
  `tanggal_sewa` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `lama_sewa` int NOT NULL COMMENT 'dalam hari',
  `lokasi_pengiriman` text NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `status_penyewaan` enum('menunggu','diproses','aktif','selesai','dibatalkan') DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penyewaan`
--

INSERT INTO `penyewaan` (`id_penyewaan`, `kode_penyewaan`, `id_pelanggan`, `tanggal_sewa`, `tanggal_kembali`, `lama_sewa`, `lokasi_pengiriman`, `total_harga`, `status_penyewaan`, `created_at`) VALUES
(1, 'SW-20260610-0001', 1, '2026-06-11', '2026-06-13', 2, 'Gedung Proklamasi Depok', '400000.00', 'selesai', '2026-06-10 14:07:54'),
(2, 'SW-20260615-0001', 1, '2026-06-16', '2026-06-18', 2, 'Jl. Arjuna Raya No.1, Mekar Jaya, Kec. Sukmajaya, Kota Depok, Jawa Barat 16411', '400000.00', 'selesai', '2026-06-15 03:52:29'),
(3, 'SW-20260627-0001', 1, '2026-06-27', '2026-06-30', 3, 'Jl. Merdeka', '1440000.00', 'selesai', '2026-06-27 02:58:45'),
(4, 'SW-20260719-0001', 2, '2026-07-20', '2026-07-22', 2, 'Jl. Beruang No. 15, Kec. Matraman, Jakarta Timur', '8990000.00', 'selesai', '2026-07-19 13:57:23'),
(5, 'SW-20260719-0002', 2, '2026-07-19', '2026-08-18', 30, 'Jl. Mata Elang Blok 1 No. 25, Kec. Ragunan, Jakarta Selatan', '15000000.00', 'aktif', '2026-07-19 14:19:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat_konstruksi`
--
ALTER TABLE `alat_konstruksi`
  ADD PRIMARY KEY (`id_alat`);

--
-- Indexes for table `detail_penyewaan`
--
ALTER TABLE `detail_penyewaan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_penyewaan` (`id_penyewaan`),
  ADD KEY `id_alat` (`id_alat`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `id_penyewaan` (`id_penyewaan`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_penyewaan` (`id_penyewaan`);

--
-- Indexes for table `penyewaan`
--
ALTER TABLE `penyewaan`
  ADD PRIMARY KEY (`id_penyewaan`),
  ADD UNIQUE KEY `kode_penyewaan` (`kode_penyewaan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat_konstruksi`
--
ALTER TABLE `alat_konstruksi`
  MODIFY `id_alat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `detail_penyewaan`
--
ALTER TABLE `detail_penyewaan`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penyewaan`
--
ALTER TABLE `penyewaan`
  MODIFY `id_penyewaan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_penyewaan`
--
ALTER TABLE `detail_penyewaan`
  ADD CONSTRAINT `detail_penyewaan_ibfk_1` FOREIGN KEY (`id_penyewaan`) REFERENCES `penyewaan` (`id_penyewaan`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_penyewaan_ibfk_2` FOREIGN KEY (`id_alat`) REFERENCES `alat_konstruksi` (`id_alat`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_penyewaan`) REFERENCES `penyewaan` (`id_penyewaan`) ON DELETE CASCADE;

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_penyewaan`) REFERENCES `penyewaan` (`id_penyewaan`) ON DELETE CASCADE;

--
-- Constraints for table `penyewaan`
--
ALTER TABLE `penyewaan`
  ADD CONSTRAINT `penyewaan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

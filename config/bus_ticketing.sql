-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 22 Jan 2025 pada 12.59
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bus_ticketing`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bus`
--

CREATE TABLE `bus` (
  `bus_id` int NOT NULL,
  `nama_bus` varchar(100) DEFAULT NULL,
  `terminal_asal` varchar(100) DEFAULT NULL,
  `terminal_tujuan` varchar(100) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `harga_tiket` decimal(10,2) DEFAULT NULL,
  `jam_berangkat` time DEFAULT NULL,
  `jam_tiba` time DEFAULT NULL,
  `kapasitas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `bus`
--

INSERT INTO `bus` (`bus_id`, `nama_bus`, `terminal_asal`, `terminal_tujuan`, `kelas`, `harga_tiket`, `jam_berangkat`, `jam_tiba`, `kapasitas`) VALUES
(1, 'Harapan Haya', 'Sragen', 'Bekasi', 'Ekonomi', 2000.00, '19:57:57', '19:57:59', 10),
(3, 'Harapan Haya', 'Kalioso', 'Ciputat', 'Ekonomi', 10000.00, '18:52:42', '18:52:43', 10),
(4, 'Rosalia Indah', 'Sragen', 'Bekasi', 'VIP', 10000.00, '18:53:01', '18:53:02', 10),
(8, 'Laju Prima', 'Bandung', 'Jogja', 'Sleeper', 200000.00, '06:58:00', '22:59:00', NULL),
(9, 'Sinar Jaya', 'Tirtonadi', 'Lebakbulus', 'Sleeper', 12.00, '15:17:00', '20:17:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `pemesanan_id` int NOT NULL,
  `penumpang_id` int DEFAULT NULL,
  `bus_id` int DEFAULT NULL,
  `tanggal_pesan` date DEFAULT NULL,
  `nomor_kursi` int DEFAULT NULL,
  `status_pemesanan` enum('dipesan','dibayar','dibatalkan','kadaluarsa','check-in') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`pemesanan_id`, `penumpang_id`, `bus_id`, `tanggal_pesan`, `nomor_kursi`, `status_pemesanan`) VALUES
(38, 1, 1, '2025-01-10', 1, 'check-in'),
(39, 1, 3, '2025-01-10', 2, 'dibatalkan'),
(40, 1, 1, '2025-01-10', 1, 'check-in'),
(41, 1, 4, '2025-01-10', 10, 'check-in'),
(42, 1, 4, '2025-01-10', 1, 'dipesan'),
(43, 1, 4, '2025-01-10', 2, 'dipesan'),
(44, 1, 1, '2025-01-18', 1, 'dipesan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penumpang`
--

CREATE TABLE `penumpang` (
  `penumpang_id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `NIK` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `penumpang`
--

INSERT INTO `penumpang` (`penumpang_id`, `nama`, `NIK`, `email`, `password`) VALUES
(1, 'maspo', '123', 'maspouhuy@gmail.com', '$2y$10$7FJsZaCCAiZ4iORuVlLwrOWNw365U6Nf518EZAye4TQgKroBzfX8C');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket`
--

CREATE TABLE `tiket` (
  `tiket_id` int NOT NULL,
  `pemesanan_id` int DEFAULT NULL,
  `nomor_kursi` int DEFAULT NULL,
  `status_tiket` enum('dipesan','dibayar','dibatalkan','kadaluarsa','check-in') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nomor_tiket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tiket`
--

INSERT INTO `tiket` (`tiket_id`, `pemesanan_id`, `nomor_kursi`, `status_tiket`, `nomor_tiket`) VALUES
(37, 38, 1, 'check-in', 'TKT-20250110-1'),
(38, 39, 2, 'dipesan', 'TKT-20250110-2'),
(39, 40, 1, 'check-in', 'TKT-20250110-1'),
(40, 41, 10, 'check-in', 'TKT-20250110-10'),
(41, 42, 1, 'dipesan', 'TKT-20250110-1'),
(42, 43, 2, 'dipesan', 'TKT-20250110-2'),
(43, 44, 1, 'dipesan', 'TKT-20250118-1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`bus_id`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`pemesanan_id`),
  ADD KEY `penumpang_id` (`penumpang_id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indeks untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  ADD PRIMARY KEY (`penumpang_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`tiket_id`),
  ADD KEY `pemesanan_id` (`pemesanan_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bus`
--
ALTER TABLE `bus`
  MODIFY `bus_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `pemesanan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  MODIFY `penumpang_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `tiket_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`penumpang_id`) REFERENCES `penumpang` (`penumpang_id`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`bus_id`);

--
-- Ketidakleluasaan untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanan` (`pemesanan_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

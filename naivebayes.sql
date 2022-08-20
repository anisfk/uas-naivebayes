-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Agu 2022 pada 17.22
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `naivebayes`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_testing`
--

CREATE TABLE `tb_testing` (
  `id` int(11) NOT NULL,
  `outlook` varchar(20) CHARACTER SET latin1 NOT NULL,
  `temperature` varchar(20) CHARACTER SET latin1 NOT NULL,
  `humidity` varchar(20) CHARACTER SET latin1 NOT NULL,
  `windy` varchar(20) CHARACTER SET latin1 NOT NULL,
  `play` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_testing`
--

INSERT INTO `tb_testing` (`id`, `outlook`, `temperature`, `humidity`, `windy`, `play`) VALUES
(1, 'sunny', 'hot', 'high', 'false', 'no'),
(2, 'rainy', 'mild', 'high', 'false', 'yes'),
(3, 'cloudy', 'cool', 'normal', 'true', 'yes'),
(4, 'sunny', 'mild', 'high', 'false', 'no'),
(5, 'cloudy', 'mild', 'high', 'true', 'yes'),
(6, 'sunny', 'mild', 'normal', 'true', 'no');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_training`
--

CREATE TABLE `tb_training` (
  `id` int(11) NOT NULL,
  `outlook` varchar(20) CHARACTER SET latin1 NOT NULL,
  `temperature` varchar(20) CHARACTER SET latin1 NOT NULL,
  `humidity` varchar(20) CHARACTER SET latin1 NOT NULL,
  `windy` varchar(20) CHARACTER SET latin1 NOT NULL,
  `play` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_training`
--

INSERT INTO `tb_training` (`id`, `outlook`, `temperature`, `humidity`, `windy`, `play`) VALUES
(1, 'sunny', 'hot', 'high', 'false', 'yes'),
(2, 'sunny', 'hot', 'high', 'true', 'no'),
(3, 'cloudy', 'hot', 'high', 'false', 'yes'),
(4, 'rainy', 'mild', 'high', 'false', 'yes'),
(6, 'rainy', 'cool', 'normal', 'true', 'yes'),
(7, 'cloudy', 'cool', 'normal', 'true', 'yes'),
(8, 'sunny', 'mild', 'high', 'false', 'no'),
(9, 'sunny', 'cool', 'normal', 'false', 'yes'),
(10, 'rainy', 'mild', 'normal', 'false', 'yes'),
(11, 'sunny', 'mild', 'normal', 'true', 'yes'),
(12, 'cloudy', 'mild', 'high', 'true', 'yes'),
(13, 'cloudy', 'hot', 'normal', 'false', 'yes');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_testing`
--
ALTER TABLE `tb_testing`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_training`
--
ALTER TABLE `tb_training`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_testing`
--
ALTER TABLE `tb_testing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_training`
--
ALTER TABLE `tb_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

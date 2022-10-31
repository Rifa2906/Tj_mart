-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Okt 2022 pada 08.55
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tj_mart`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_keluar`
--

CREATE TABLE `tb_barang_keluar` (
  `id_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `jumlah` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_barang_keluar`
--

INSERT INTO `tb_barang_keluar` (`id_keluar`, `id_barang`, `id_satuan`, `id_jenis`, `tanggal_keluar`, `jumlah`) VALUES
(75, 21, 9, 1, '2022-07-30', 100),
(76, 21, 9, 1, '2022-08-30', 30),
(77, 21, 9, 1, '2022-09-30', 15),
(78, 22, 9, 1, '2022-10-31', 70),
(79, 22, 9, 1, '2022-11-30', 25);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_masuk`
--

CREATE TABLE `tb_barang_masuk` (
  `id_masuk` int(11) NOT NULL,
  `id_barang` int(10) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `id_pemasok` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `jumlah` int(5) NOT NULL,
  `tanggal_kadaluarsa` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jenis_barang`
--

CREATE TABLE `tb_jenis_barang` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(30) NOT NULL,
  `minimal_stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_jenis_barang`
--

INSERT INTO `tb_jenis_barang` (`id_jenis`, `nama_jenis`, `minimal_stok`) VALUES
(1, 'Minuman', 10),
(4, 'Makanan', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kadaluarsa`
--

CREATE TABLE `tb_kadaluarsa` (
  `id_kadaluarsa` int(11) NOT NULL,
  `tanggal_kadaluarsa` date NOT NULL,
  `id_barang` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_monitoring_kadaluarsa`
--

CREATE TABLE `tb_monitoring_kadaluarsa` (
  `id_monitoring` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `tanggal_kadaluarsa` date NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pemasok`
--

CREATE TABLE `tb_pemasok` (
  `id_pemasok` int(11) NOT NULL,
  `kode_pemasok` varchar(20) NOT NULL,
  `nama_pemasok` varchar(50) NOT NULL,
  `no_telpon` varchar(12) NOT NULL,
  `alamat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pemasok`
--

INSERT INTO `tb_pemasok` (`id_pemasok`, `kode_pemasok`, `nama_pemasok`, `no_telpon`, `alamat`) VALUES
(8, 'PM0001', 'PT. Harja Gunatama Lestari', '120394857321', 'Komp. Setrasari Mall II Kav. A-7 Bandung'),
(9, 'PM0002', 'PT. Pinus Merah Abadi ', '120394857321', 'Jl. Soekarno Hatta no 563 Bandung '),
(10, 'PM0003', 'PT. Yakult', '120394857321', 'Jl. Soekarno Hatta No 341 Rt 03 Rw 02 Kebon Lega B'),
(11, 'PM0004', 'CV JAZA VENUS BANDUNG ', '120394857321', 'JL Arcamanik Endah Raya no109 Bandung'),
(12, 'PM0005', 'PT CAHAYA INTI GLOBAL PRATAMA', '120394857321', 'JL HAJI KURDI 81 RT 01 RW 06 KEL.PELINDUNG HEWAN '),
(13, 'PM0006', 'L\'AMOR PARFUME ', '120394857321', 'Dago,Bandung ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_telpon` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `kata_sandi` varchar(50) NOT NULL,
  `hak_pengguna` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id_pengguna`, `nama`, `alamat`, `no_telpon`, `email`, `kata_sandi`, `hak_pengguna`) VALUES
(1, 'Euis Mulyani', 'Cisitu', '028467352738', 'euis_mulyani@gmail.com', 'mulyani', 'kepala gudang'),
(23, 'Hary', 'Bandung', '120394857321', 'hary@gmail.com', 'hary', 'staf gudang'),
(24, 'Rifa', 'Tasikmalaya', '082315728130', 'rifa@gmail.com', 'rifa', 'staf administrasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_peramalan`
--

CREATE TABLE `tb_peramalan` (
  `id_peramalan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `minimal_stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_peramalan`
--

INSERT INTO `tb_peramalan` (`id_peramalan`, `id_barang`, `id_satuan`, `id_jenis`, `minimal_stok`) VALUES
(18, 21, 9, 1, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_permintaan`
--

CREATE TABLE `tb_permintaan` (
  `id_permintaan` int(11) NOT NULL,
  `id_peramalan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `jumlah_pengadaan` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_permintaan`
--

INSERT INTO `tb_permintaan` (`id_permintaan`, `id_peramalan`, `id_barang`, `id_satuan`, `jumlah_pengadaan`, `status`) VALUES
(10, 17, 21, 9, 44, 'Sudah disetujui');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` int(11) NOT NULL,
  `id_pemasok` int(11) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `harga_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_satuan`
--

CREATE TABLE `tb_satuan` (
  `id_satuan` int(11) NOT NULL,
  `satuan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_satuan`
--

INSERT INTO `tb_satuan` (`id_satuan`, `satuan`) VALUES
(8, 'KG'),
(9, 'BTL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_stok_barang`
--

CREATE TABLE `tb_stok_barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_stok_barang`
--

INSERT INTO `tb_stok_barang` (`id_barang`, `kode_barang`, `nama_barang`, `id_jenis`, `id_satuan`, `stok`) VALUES
(21, 'BRG0001', 'Yakult', 1, 9, 5),
(22, 'BRG0002', 'Aqua', 1, 9, 5);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_barang_keluar`
--
ALTER TABLE `tb_barang_keluar`
  ADD PRIMARY KEY (`id_keluar`);

--
-- Indeks untuk tabel `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  ADD PRIMARY KEY (`id_masuk`);

--
-- Indeks untuk tabel `tb_jenis_barang`
--
ALTER TABLE `tb_jenis_barang`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `tb_kadaluarsa`
--
ALTER TABLE `tb_kadaluarsa`
  ADD PRIMARY KEY (`id_kadaluarsa`);

--
-- Indeks untuk tabel `tb_monitoring_kadaluarsa`
--
ALTER TABLE `tb_monitoring_kadaluarsa`
  ADD PRIMARY KEY (`id_monitoring`);

--
-- Indeks untuk tabel `tb_pemasok`
--
ALTER TABLE `tb_pemasok`
  ADD PRIMARY KEY (`id_pemasok`);

--
-- Indeks untuk tabel `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `tb_peramalan`
--
ALTER TABLE `tb_peramalan`
  ADD PRIMARY KEY (`id_peramalan`);

--
-- Indeks untuk tabel `tb_permintaan`
--
ALTER TABLE `tb_permintaan`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indeks untuk tabel `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `tb_satuan`
--
ALTER TABLE `tb_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `tb_stok_barang`
--
ALTER TABLE `tb_stok_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_barang_keluar`
--
ALTER TABLE `tb_barang_keluar`
  MODIFY `id_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT untuk tabel `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `tb_jenis_barang`
--
ALTER TABLE `tb_jenis_barang`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_kadaluarsa`
--
ALTER TABLE `tb_kadaluarsa`
  MODIFY `id_kadaluarsa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tb_monitoring_kadaluarsa`
--
ALTER TABLE `tb_monitoring_kadaluarsa`
  MODIFY `id_monitoring` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_pemasok`
--
ALTER TABLE `tb_pemasok`
  MODIFY `id_pemasok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `tb_peramalan`
--
ALTER TABLE `tb_peramalan`
  MODIFY `id_peramalan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tb_permintaan`
--
ALTER TABLE `tb_permintaan`
  MODIFY `id_permintaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_satuan`
--
ALTER TABLE `tb_satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_stok_barang`
--
ALTER TABLE `tb_stok_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

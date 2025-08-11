-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Des 2023 pada 16.56
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring_mahasiswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `departemen`
--

CREATE TABLE `departemen` (
  `nip` varchar(25) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kabkota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `notelp` varchar(12) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `departemen`
--

INSERT INTO `departemen` (`nip`, `nama`, `email`, `alamat`, `kabkota`, `provinsi`, `notelp`, `foto`) VALUES
('197404011999031002', 'Dr. Aris Puji Widodo, S.Si., M.T.', 'arispuji@if.undip.ac.id', 'Jl Raya Semarang', 'Semarang', 'Jawa Tengah', '088834561223', 'aris.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosenwali`
--

CREATE TABLE `dosenwali` (
  `nip` varchar(25) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kabkota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `notelp` varchar(12) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosenwali`
--

INSERT INTO `dosenwali` (`nip`, `nama`, `email`, `alamat`, `kabkota`, `provinsi`, `notelp`, `foto`) VALUES
('197907202003121002', 'Nurdin Bahtiar, S.Si., M.T.', 'nurdin@gmail.com', 'Jl Lingkar Semarang', 'Semarang', 'Jawa Tengah', '088732145699', 'nurdin.jpg'),
('198012272015041002', 'Guruh Aryotejo, S.Kom., M.Sc.', 'guruh@gmail.com', 'Jl Banyumanik', 'Surabaya', 'Jawa Timur', '088621341764', 'guruh.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `irs`
--

CREATE TABLE `irs` (
  `nim` varchar(14) NOT NULL,
  `semester` varchar(2) NOT NULL,
  `jumlahsks` varchar(4) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `fileirs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `irs`
--

INSERT INTO `irs` (`nim`, `semester`, `jumlahsks`, `status`, `fileirs`) VALUES
('24060117130018', '1', '24', '1', 'sitismt1.pdf'),
('24060117130018', '2', '21', '1', 'sitismt2.pdf'),
('24060117130018', '3', '24', '1', 'sitismt3.pdf'),
('24060117130018', '4', '20', '1', 'sitismt4.pdf'),
('24060117130018', '5', '24', '1', 'sitismt5.pdf'),
('24060117130018', '6', '12', '1', 'sitismt6.pdf'),
('24060117130018', '7', '15', '1', 'sitismt7.pdf'),
('24060117130018', '8', '6', '1', 'sitismt8.pdf'),
('24060117141018', '1', '24', '1', 'adityasmt1.pdf'),
('24060117141018', '2', '21', '1', 'adityasmt2.pdf'),
('24060117141018', '3', '24', '1', 'adityasmt3.pdf'),
('24060117141018', '4', '18', '1', 'adityasmt4.pdf'),
('24060117141018', '5', '24', '1', 'adityasmt5.pdf'),
('24060117141018', '6', '16', '1', 'adityasmt6.pdf'),
('24060117141018', '7', '12', '1', 'adityasmt7.pdf'),
('24060117141018', '8', '6', '1', 'adityasmt8.pdf'),
('24060118112027', '1', '21', '1', 'putrismt1.pdf'),
('24060118112027', '2', '24', '1', 'putrismt2.pdf'),
('24060118112027', '3', '24', '1', 'putrismt3.pdf'),
('24060118112027', '4', '22', '1', 'putrismt4.pdf'),
('24060118112027', '5', '24', '1', 'putrismt5.pdf'),
('24060118112027', '6', '12', '1', 'putrismt6.pdf'),
('24060118112027', '7', '10', '1', 'putrismt7.pdf'),
('24060118112027', '8', '8', '1', 'putrismt8.pdf'),
('24060118113017', '1', '21', '1', 'irfansmt1.pdf'),
('24060118113017', '2', '22', '1', 'irfansmt2.pdf'),
('24060118113017', '3', '22', '1', 'irfansmt3.pdf'),
('24060118113017', '4', '24', '1', 'irfansmt4.pdf'),
('24060118113017', '5', '24', '1', 'irfansmt5.pdf'),
('24060118113017', '6', '12', '1', 'irfansmt6.pdf'),
('24060118113017', '7', '16', '1', 'irfansmt7.pdf'),
('24060118113017', '8', '6', '1', 'irfansmt8.pdf'),
('24060119113012', '1', '21', '1', 'banusmt1.pdf'),
('24060119113012', '2', '21', '1', 'banusmt2.pdf'),
('24060119113012', '3', '22', '1', 'banusmt3.pdf'),
('24060119113012', '4', '15', '1', 'banusmt4.pdf'),
('24060119113012', '5', '22', '1', 'banusmt5.pdf'),
('24060119113012', '6', '12', '1', 'banusmt6.pdf'),
('24060119113012', '7', '16', '1', 'banusmt7.pdf'),
('24060119113012', '8', '8', '1', 'banusmt8.pdf'),
('24060119113012', '9', '8', '1', 'banusmt9.pdf'),
('24060119140158', '1', '21', '1', 'devinsmt1.pdf'),
('24060119140158', '2', '24', '1', 'devinsmt2.pdf'),
('24060119140158', '3', '22', '1', 'devinsmt3.pdf'),
('24060119140158', '4', '18', '1', 'devinsmt4.pdf'),
('24060119140158', '5', '24', '1', 'devinsmt5.pdf'),
('24060119140158', '6', '16', '1', 'devinsmt6.pdf'),
('24060119140158', '7', '12', '1', 'devinsmt7.pdf'),
('24060119140158', '8', '8', '1', 'devinsmt8.pdf'),
('24060120120010', '1', '21', '1', 'vinasmt1.pdf'),
('24060120120010', '2', '24', '1', 'vinasmt2.pdf'),
('24060120120010', '3', '22', '1', 'vinasmt3.pdf'),
('24060120120010', '4', '18', '1', 'vinasmt4.pdf'),
('24060120120010', '5', '24', '1', 'vinasmt5.pdf'),
('24060120120010', '6', '16', '1', 'vinasmt6.pdf'),
('24060120130078', '1', '21', '1', 'hernansmt1.pdf'),
('24060120130078', '2', '24', '1', 'hernansmt2.pdf'),
('24060120130078', '3', '22', '1', 'hernansmt3.pdf'),
('24060120130078', '4', '18', '1', 'hernansmt4.pdf'),
('24060120130078', '5', '24', '1', 'hernansmt5.pdf'),
('24060120130078', '6', '16', '1', 'hernansmt6.pdf'),
('24060120130078', '7', '10', '1', 'hernansmt7.pdf'),
('24060121140118', '1', '21', '1', 'anandasmt1.pdf'),
('24060121140118', '2', '21', '1', 'anandasmt2.pdf'),
('24060121140118', '3', '22', '1', 'anandasmt3.pdf'),
('24060121140118', '4', '15', '1', 'anandasmt4.pdf'),
('24060121140118', '5', '24', '1', 'anandasmt5.pdf'),
('24060121141178', '1', '21', '1', 'sarsonosmt1.pdf'),
('24060121141178', '2', '24', '1', 'sarsonosmt2.pdf'),
('24060121141178', '3', '24', '1', 'sarsonosmt3.pdf'),
('24060121141178', '4', '20', '1', 'sarsonosmt4.pdf'),
('24060121141178', '5', '24', '1', 'sarsonosmt5.pdf'),
('24060122130066', '1', '21', '1', 'bryansmt1.pdf'),
('24060122130066', '2', '24', '1', 'bryansmt2.pdf'),
('24060122130066', '3', '22', '1', 'bryansmt3.pdf'),
('24060122140177', '1', '21', '1', 'arfansmt1.pdf'),
('24060122140177', '2', '21', '1', 'arfansmt2.pdf'),
('24060122140177', '3', '22', '1', 'arfansmt3.pdf'),
('24060123120014', '1', '24', '1', 'putrismt1.pdf'),
('24060123140115', '1', '21', '1', 'jokosmt1.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `khs`
--

CREATE TABLE `khs` (
  `nim` varchar(14) NOT NULL,
  `semester` varchar(2) NOT NULL,
  `skss` varchar(4) NOT NULL,
  `sksk` varchar(4) NOT NULL,
  `ips` varchar(4) NOT NULL,
  `ipk` varchar(4) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `filekhs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `khs`
--

INSERT INTO `khs` (`nim`, `semester`, `skss`, `sksk`, `ips`, `ipk`, `status`, `filekhs`) VALUES
('24060117130018', '1', '24', '24', '4.00', '4.00', '1', 'sitismt1.pdf'),
('24060117130018', '2', '21', '45', '3.78', '3.89', '1', 'sitismt2.pdf'),
('24060117130018', '3', '24', '69', '3.50', '3.76', '1', 'sitismt3.pdf'),
('24060117130018', '4', '20', '89', '4.00', '3.82', '1', 'sitismt4.pdf'),
('24060117130018', '5', '24', '113', '3.67', '3.79', '1', 'sitismt5.pdf'),
('24060117130018', '6', '12', '125', '3.67', '3.77', '1', 'sitismt6.pdf'),
('24060117130018', '7', '15', '140', '3.50', '3.73', '1', 'sitismt7.pdf'),
('24060117130018', '8', '6', '146', '3.00', '3.64', '1', 'sitismt8.pdf'),
('24060117141018', '1', '24', '24', '3.67', '3.67', '1', 'adityasmt1.pdf'),
('24060117141018', '2', '21', '45', '4.00', '3.84', '1', 'adityasmt2.pdf'),
('24060117141018', '3', '24', '69', '3.50', '3.72', '1', 'adityasmt3.pdf'),
('24060117141018', '4', '18', '87', '3.00', '3.54', '1', 'adityasmt4.pdf'),
('24060117141018', '5', '24', '111', '3.00', '3.43', '1', 'adityasmt5.pdf'),
('24060117141018', '6', '16', '127', '3.50', '3.45', '1', 'adityasmt6.pdf'),
('24060117141018', '7', '12', '139', '3.00', '3.38', '1', 'adityasmt7.pdf'),
('24060117141018', '8', '6', '145', '2.00', '3.21', '1', 'adityasmt8.pdf'),
('24060118112027', '1', '21', '21', '4.00', '4.00', '1', 'putrismt1.pdf'),
('24060118112027', '2', '24', '45', '4.00', '4.00', '1', 'putrismt2.pdf'),
('24060118112027', '3', '24', '69', '4.00', '4.00', '1', 'putrismt3.pdf'),
('24060118112027', '4', '22', '91', '4.00', '4.00', '1', 'putrismt4.pdf'),
('24060118112027', '5', '24', '115', '3.79', '3.96', '1', 'putrismt5.pdf'),
('24060118112027', '6', '12', '127', '3.67', '3.91', '1', 'putrismt6.pdf'),
('24060118112027', '7', '10', '137', '4.00', '3.92', '1', 'putrismt7.pdf'),
('24060118112027', '8', '8', '145', '4.00', '3.93', '1', 'putrismt8.pdf'),
('24060118113017', '1', '21', '21', '3.79', '3.79', '1', 'irfansmt1.pdf'),
('24060118113017', '2', '22', '43', '4.00', '3.90', '1', 'irfansmt2.pdf'),
('24060118113017', '3', '22', '65', '4.00', '3.93', '1', 'irfansmt3.pdf'),
('24060118113017', '4', '24', '89', '3.50', '3.83', '1', 'irfansmt4.pdf'),
('24060118113017', '5', '24', '113', '3.67', '3.79', '1', 'irfansmt5.pdf'),
('24060118113017', '6', '12', '125', '3.50', '3.74', '1', 'irfansmt6.pdf'),
('24060118113017', '7', '18', '143', '3.79', '3.75', '1', 'irfansmt7.pdf'),
('24060118113017', '8', '6', '149', '3.00', '3.66', '1', 'irfansmt8.pdf'),
('24060119113012', '1', '21', '21', '3.00', '3.00', '1', 'banusmt1.pdf'),
('24060119113012', '2', '21', '42', '3.00', '3.00', '1', 'banusmt2.pdf'),
('24060119113012', '3', '22', '64', '3.50', '3.17', '1', 'banusmt3.pdf'),
('24060119113012', '4', '15', '79', '3.20', '3.18', '1', 'banusmt4.pdf'),
('24060119113012', '5', '22', '101', '3.67', '3.27', '1', 'banusmt5.pdf'),
('24060119113012', '6', '12', '113', '3.00', '3.23', '1', 'banusmt6.pdf'),
('24060119113012', '7', '16', '129', '3.10', '3.21', '1', 'banusmt7.pdf'),
('24060119113012', '8', '8', '137', '3.00', '3.18', '1', 'banusmt8.pdf'),
('24060119140158', '1', '21', '21', '4.00', '4.00', '1', 'devinsmt1.pdf'),
('24060119140158', '2', '24', '45', '4.00', '4.00', '1', 'devinsmt2.pdf'),
('24060119140158', '3', '22', '67', '3.50', '3.83', '1', 'devinsmt3.pdf'),
('24060119140158', '4', '18', '85', '3.50', '3.75', '1', 'devinsmt4.pdf'),
('24060119140158', '5', '24', '109', '3.67', '3.73', '1', 'devinsmt5.pdf'),
('24060119140158', '6', '16', '125', '3.20', '3.65', '1', 'devinsmt6.pdf'),
('24060119140158', '7', '12', '137', '3.40', '3.61', '1', 'devinsmt7.pdf'),
('24060119140158', '8', '8', '145', '4.00', '3.66', '1', 'devinsmt8.pdf'),
('24060120120010', '1', '21', '21', '4.00', '4.00', '1', 'vinasmt1.pdf'),
('24060120120010', '2', '24', '45', '4.00', '4.00', '1', 'vinasmt2.pdf'),
('24060120120010', '3', '22', '67', '3.50', '3.83', '1', 'vinasmt3.pdf'),
('24060120120010', '4', '18', '85', '3.50', '3.75', '1', 'vinasmt4.pdf'),
('24060120120010', '5', '24', '109', '3.67', '3.73', '1', 'vinasmt5.pdf'),
('24060120120010', '6', '16', '125', '3.20', '3.65', '1', 'vinasmt6.pdf'),
('24060120130078', '1', '21', '21', '4.00', '4.00', '1', 'hernansmt1.pdf'),
('24060120130078', '2', '24', '45', '4.00', '4.00', '1', 'hernansmt2.pdf'),
('24060120130078', '3', '22', '67', '4.00', '4.00', '1', 'hernansmt3.pdf'),
('24060120130078', '4', '18', '85', '4.00', '4.00', '1', 'hernansmt4.pdf'),
('24060120130078', '5', '24', '109', '3.79', '3.96', '1', 'hernansmt5.pdf'),
('24060120130078', '6', '16', '125', '3.20', '3.83', '1', 'hernansmt6.pdf'),
('24060121140118', '1', '21', '21', '4.00', '4.00', '1', 'anandasmt1.pdf'),
('24060121140118', '2', '21', '42', '4.00', '4.00', '1', 'anandasmt2.pdf'),
('24060121140118', '3', '22', '64', '4.00', '4.00', '1', 'anandasmt3.pdf'),
('24060121140118', '4', '15', '79', '4.00', '4.00', '1', 'anandasmt4.pdf'),
('24060121141178', '1', '21', '21', '3.00', '3.00', '1', 'sarsonosmt1.pdf'),
('24060121141178', '2', '24', '45', '4.00', '3.50', '1', 'sarsonosmt2.pdf'),
('24060121141178', '3', '24', '69', '3.50', '3.50', '1', 'sarsonosmt3.pdf'),
('24060121141178', '4', '20', '89', '3.70', '3.55', '1', 'sarsonosmt4.pdf'),
('24060122130066', '1', '21', '21', '4.00', '4.00', '1', 'bryansmt1.pdf'),
('24060122130066', '2', '24', '45', '4.00', '4.00', '1', 'bryansmt2.pdf'),
('24060122140177', '1', '21', '21', '4.00', '4.00', '1', 'arfansmt1.pdf'),
('24060122140177', '2', '21', '42', '3.79', '3.89', '1', 'arfansmt2.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(14) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kabkota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `notelp` varchar(12) DEFAULT NULL,
  `angkatan` varchar(4) NOT NULL,
  `status` enum('aktif','cuti','mangkir','undur diri','lulus','do','meninggal dunia') DEFAULT 'aktif',
  `dosenwali` varchar(255) NOT NULL,
  `jalurmasuk` enum('snmptn','sbmptn','mandiri') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `email`, `alamat`, `kabkota`, `provinsi`, `notelp`, `angkatan`, `status`, `dosenwali`, `jalurmasuk`, `foto`) VALUES
('24060117130018', 'Siti Rahayu', 'siti@students.undip.ac.id', 'JL Brokoli', 'Tegal', 'Jawa Tengah', '089819672081', '2017', 'lulus', 'Nurdin Bahtiar, S.Si., M.T.', 'sbmptn', 'siti.jpg'),
('24060117141018', 'Aditya Nugraha', 'adityanugraha@students.undip.ac.id', 'JL Kangkung ', 'Tangerang', 'Banten', '081311792459', '2017', 'lulus', 'Guruh Aryotejo,\r\nS.Kom., M.Sc.', 'mandiri', 'aditya.jpg'),
('24060118112027', 'Putri Damayanti', 'putri@students.undip.ac.id', 'JL Seledri', 'Depok', 'Jawa Barat', '081311792459', '2018', 'lulus', 'Nurdin Bahtiar, S.Si., M.T.', 'snmptn', 'putri.jpg'),
('24060118113017', 'Irfan Saputra', 'irfansaputra@students.undip.ac.id', 'JL Mangga', 'Bekasi', 'Jawa Barat', '081311798913', '2018', 'lulus', 'Guruh Aryotejo,\r\nS.Kom., M.Sc.', 'sbmptn', 'irfan.jpg'),
('24060119113012', 'Banu Khumar', 'banu@students.undip.ac.id', 'JL Pare', 'Garut', 'Jawa Barat', '081311787314', '2019', 'aktif', 'Guruh Aryotejo,\r\nS.Kom., M.Sc.', 'sbmptn', 'banu.jpg'),
('24060119140158', 'Devin Januar Siahaan', 'devin@students.ac.id', 'Jl Kumaha A', 'Cirebon', 'Jawa Tengah', '087845312098', '2019', 'lulus', 'Nurdin Bahtiar, S.Si., M.T.', 'sbmptn', 'devin.jpg'),
('24060120120010', 'Vina Ireniza', 'vina@students.undip.ac.id', 'JL Mawar', 'Seram', 'Maluku', '087889541913', '2020', 'cuti', 'Guruh Aryotejo, S.Kom., M.Sc.', 'snmptn', 'vina.jpg'),
('24060120130078', 'Hernan Sandi Laksono', 'hernanlaksono@students.undip.ac.id', 'JL Jurang Belimbing', 'Pemalang', 'Jawa Tengah', '088213422675', '2020', 'aktif', 'Nurdin Bahtiar, S.Si., M.T.', 'sbmptn', 'hernan.jpg'),
('24060121140118', 'Ananda Rizky Pratama', 'boy@students.undip.ac.id', 'Jl Jalan Terus', 'Tangerang Selatan', 'Banten', '082123451122', '2021', 'aktif', 'Nurdin Bahtiar, S.Si., M.T.', 'mandiri', 'boy.jpg'),
('24060121141178', 'Sarsono', 'sarsono@students.undip.ac.id', 'JL Bau Tanah', 'Curug', 'Banten', '085611212459', '2021', 'aktif', 'Guruh Aryotejo,\r\nS.Kom., M.Sc.', 'sbmptn', 'sarsono.jpg'),
('24060122130066', 'Bonifasius Bryan Suryaningtyas', 'bryan@students.undip.ac.id', 'Jl Merdeka', 'Cirebon', 'Jawa Barat', '087865324523', '2022', 'aktif', 'Guruh Aryotejo, S.Kom., M.Sc.', 'sbmptn', 'bryan.jpg'),
('24060122140177', 'Arfan Maulana', 'arfan@students.undip.ac.id', 'JL Melon', 'Sukabumi', 'Jawa Barat', '087811302459', '2022', 'aktif', 'Nurdin Bahtiar, S.Si., M.T.', 'mandiri', 'arfan.jpg'),
('24060123120014', 'Putri Nurhaliza', 'putri@students.undip.ac.id', 'JL Semangka', 'Bogor', 'Jawa Barat', '087821302459', '2023', 'aktif', 'Guruh Aryotejo,\r\nS.Kom., M.Sc.', 'snmptn', 'putri.jpg'),
('24060123140115', 'Joko Susanto', 'joko@students.undip.ac.id', 'JL Wortel', 'Semarang', 'Jawa Tengah', '085625302714', '2023', 'aktif', 'Nurdin Bahtiar, S.Si., M.T.', 'mandiri', 'joko.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `operator`
--

CREATE TABLE `operator` (
  `nip` varchar(25) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kabkota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `notelp` varchar(12) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `operator`
--

INSERT INTO `operator` (`nip`, `nama`, `email`, `alamat`, `kabkota`, `provinsi`, `notelp`, `foto`) VALUES
('H.7.198611152023101001', 'Beny Nugroho, S.Kom.', 'benny@gmail.com', 'Jl Gondang Selatan', 'Semarang', 'Jawa Tengah', '085412667891', 'benny.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl`
--

CREATE TABLE `pkl` (
  `nim` varchar(14) NOT NULL,
  `semester` varchar(2) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `nilai` varchar(1) NOT NULL,
  `status_pkl` enum('belum ambil','sedang ambil','lulus') NOT NULL DEFAULT 'lulus',
  `filepkl` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `pkl`
--

INSERT INTO `pkl` (`nim`, `semester`, `status`, `nilai`, `status_pkl`, `filepkl`) VALUES
('24060117130018', '6', '1', 'B', 'lulus', 'sitipkl.pdf'),
('24060117141018', '5', '1', 'B', 'lulus', 'adityapkl.pdf'),
('24060118112027', '5', '1', 'A', 'lulus', 'putripkl.pdf'),
('24060118113017', '5', '1', 'B', 'lulus', 'irfanpkl.pdf'),
('24060119113012', '6', '1', 'C', 'lulus', 'banupkl.pdf'),
('24060119140158', '5', '1', 'B', 'lulus', 'devinpkl.pdf'),
('24060120120010', '5', '1', 'A', 'lulus', 'vinapkl.pdf'),
('24060120130078', '5', '1', 'A', 'lulus', 'hernanpkl.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi`
--

CREATE TABLE `skripsi` (
  `nim` varchar(14) NOT NULL,
  `semester` varchar(2) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `nilai` varchar(1) NOT NULL,
  `tglsidang` date DEFAULT NULL,
  `status_skripsi` enum('belum ambil','sedang ambil','lulus') NOT NULL DEFAULT 'lulus',
  `fileskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `skripsi`
--

INSERT INTO `skripsi` (`nim`, `semester`, `status`, `nilai`, `tglsidang`, `status_skripsi`, `fileskripsi`) VALUES
('24060117130018', '8', '1', 'B', '2021-03-16', 'lulus', 'sitiskripsi.pdf'),
('24060117141018', '8', '1', 'C', '2021-03-16', 'lulus', 'adityaskripsi.pdf'),
('24060118112027', '8', '1', 'A', '2022-03-15', 'lulus', 'putriskripsi.pdf'),
('24060118113017', '8', '1', 'B', '2022-03-14', 'lulus', 'irfanskripsi.pdf'),
('24060119140158', '8', '1', 'B', '2023-03-17', 'lulus', 'devinskripsi.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','dosenwali','departemen','operator') NOT NULL DEFAULT 'mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('197404011999031002', '$2y$10$CnDvRnnqvdSNpa.0x4dwbOhBQCXW8y04cFoFNAH88Q.1UByaaBSQS', 'departemen'),
('197907202003121002', '$2y$10$MjPXE1HqzhEhtUsyCox2f.9VX7ZIuTHlw4BCcmMi4HUN9v9dw2g/G', 'dosenwali'),
('198012272015041002', '$2y$10$Mq/dW2yMHt/KH15uCy/lGutBQdDsiFBGq/uVC4eUGLEB4qfQgHJey', 'dosenwali'),
('24060117130018', '$2y$10$pOk7iKFMxQTHfrVvDZU3EOQHyuLLxYv04imRrGI1roH/HUvsmCrIa', 'mahasiswa'),
('24060117141018', '$2y$10$9Fdop/WhFlGe.Q0e5XibtuNZCqQbLezCvd3ypo.b6saFq4X96ysAW', 'mahasiswa'),
('24060118112027', '$2y$10$0W/PABvf7jlUU4EOBF849OGVRmpX/gsHdxy/hqOU2gMX5MXUm3iDW', 'mahasiswa'),
('24060118113017', '$2y$10$jfJhivN2dlebKdhyEqzVJu/BJwKmrdlBTfrt7zDWHHT7AeiNV0imO', 'mahasiswa'),
('24060119113012', '$2y$10$do9AoVtmSdmeWgkvccxrqeK.DVSAcyp0/e/bX.d770cGWEbHhfDaS', 'mahasiswa'),
('24060119140158', '$2y$10$WY76OPH/L3door80Zk530eTSQu2JRQtMRXZy.S0f31lxLBg4tYN6S', 'mahasiswa'),
('24060120120010', '$2y$10$WoN655kW8OVloJyDwoPx.Oll0Mdn3Ng43dEXXHpo0D2SfpHGYSub2', 'mahasiswa'),
('24060120130078', '$2y$10$PnQeI9qFOe6WelFXxYWV3.SmuqUp6LSP1Kw6Kye0H.ZHJYqlvzOCm', 'mahasiswa'),
('24060121140118', '$2y$10$bUDOlZU2uTBzN1k5wvBii.DzuC0gTagkkKyklYC01gn99dxYyBPjm', 'mahasiswa'),
('24060121141178', '$2y$10$h0U7BUvqK19UzpCDMZqbH.cet9Nwy69CmJVY5GH5/yGcPPrLNLCK2', 'mahasiswa'),
('24060122130066', '$2y$10$JGi56cte/VrvqvA81LF83Or.v21TpIsKyk8at/IfGOtRhvKkwOKW6', 'mahasiswa'),
('24060122140177', '$2y$10$MeQ/y.2PuZDkAvx.oXijjOSsXQciLk0qanSo0Ms6Wij9/0.KlcS16', 'mahasiswa'),
('24060123120014', '$2y$10$wlnF0Ei9lxF3il4iGGdO1u6MquUgq.TILmYsRiudFX7qmlkphLUTS', 'mahasiswa'),
('24060123140115', '$2y$10$MySc1/qz85JnFohX1MH4p.TKA54vkkhAYQ/e/XJLRB1iLfm49b982', 'mahasiswa'),
('H.7.198611152023101001', '$2y$10$TkpvKMl8tiOKbQA9QQSX4O6YX6KVA0Sry605yLCct.nqNnek1PicO', 'operator');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`nip`);

--
-- Indeks untuk tabel `dosenwali`
--
ALTER TABLE `dosenwali`
  ADD PRIMARY KEY (`nip`);

--
-- Indeks untuk tabel `irs`
--
ALTER TABLE `irs`
  ADD PRIMARY KEY (`nim`,`semester`);

--
-- Indeks untuk tabel `khs`
--
ALTER TABLE `khs`
  ADD PRIMARY KEY (`nim`,`semester`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`nip`);

--
-- Indeks untuk tabel `pkl`
--
ALTER TABLE `pkl`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `skripsi`
--
ALTER TABLE `skripsi`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

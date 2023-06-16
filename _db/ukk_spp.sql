-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2023 at 04:44 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukk_spp`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cekLoginPetugas` (`uname` VARCHAR(100), `pass` VARCHAR(100))   BEGIN
	SELECT * FROM petugas
	    WHERE username = uname AND PASSWORD=pass;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cekLoginSiswa` (`nis_` VARCHAR(100), `pass` VARCHAR(100))   BEGIN
	SELECT * 
	    FROM siswa
	    WHERE nis = nis_ and password=pass;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `levelPetugas` (`uname` VARCHAR(100), `pass` VARCHAR(100))   BEGIN
	SELECT * 
	    FROM petugas
	    WHERE username = uname and password=pass;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampilData` (IN `tabel` VARCHAR(50), IN `kolom` VARCHAR(50))   BEGIN
	DECLARE tab varchar(50);
	SET tab= tabel;
	SELECT * FROM tab order by kolom desc;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `PembayaranPetugas` (`uIdPetugas` INT) RETURNS INT(11)  BEGIN
	RETURN (SELECT COUNT(*)
            FROM pembayaran 
            WHERE id_petugas = uIdPetugas);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `kompetensi_keahlian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES
(6, '10 RPL', 'Rekayasa Perangkat Lunak'),
(8, '12 TKJ', 'Teknik komputer jaringan'),
(9, '12 RPL ', 'Rekaya Perangkat Lunak');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `nisn` varchar(15) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `bulan_dibayar` varchar(10) NOT NULL,
  `tahun_dibayar` int(11) NOT NULL,
  `id_spp` int(11) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_petugas`, `nisn`, `tgl_bayar`, `bulan_dibayar`, `tahun_dibayar`, `id_spp`, `jumlah_bayar`) VALUES
(19, 5, '1234567892', '2023-01-28', 'Januari', 2021, 17, 100000),
(20, 6, '1234567893', '2023-01-28', 'Januari', 2021, 17, 120000),
(21, 5, '1234567893', '2023-01-31', 'Februari', 2021, 17, 100000),
(23, 5, '1234567891', '2023-01-31', 'Januari', 2021, 17, 100000),
(24, 5, '1234567891', '2023-06-15', 'Maret', 2021, 17, 900000),
(25, 5, '1234567892', '2023-01-28', 'Januari', 2021, 17, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_petugas` varchar(100) NOT NULL,
  `level` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`) VALUES
(5, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Moderator', 'admin'),
(6, 'herman', 'a1a6907c989946085b0e35493786fce3', 'Hermawan', 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nisn` varchar(15) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `id_spp` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_spp`, `id_kelas`, `password`, `alamat`, `no_telp`) VALUES
('1234567891', '2001002', 'Abdul rahman', 17, 6, '0f7e44a922df352c05c5f73cb40ba115', 'jl. mandau jaya', '0822233232'),
('1234567892', '2001001', 'Hidayat', 18, 9, '1855c11f044cc8944e8cdac9cae5def8', 'Jl. Landak no. 17', '0218081'),
('1234567893', '2001003', 'Widya', 17, 8, '43042f668f07adfd174cb1823d4795e1', 'dirumah', '0880808'),
('1234567894', '2001004', 'Mamat', 17, 9, 'a62d7fd579f2791cdbcdcc654b7195f2', 'Jl. Manggis 18', '0824018481');

--
-- Triggers `siswa`
--
DELIMITER $$
CREATE TRIGGER `create_pass` BEFORE INSERT ON `siswa` FOR EACH ROW BEGIN
	IF NEW.password IS NULL THEN
    	SET NEW.password := MD5(NEW.nisn);
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `spp`
--

CREATE TABLE `spp` (
  `id_spp` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `spp`
--

INSERT INTO `spp` (`id_spp`, `tahun`, `nominal`) VALUES
(17, 2021, 1000000),
(18, 2022, 1500000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_spp` (`id_spp`),
  ADD KEY `nisn` (`nisn`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nisn`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_spp` (`id_spp`);

--
-- Indexes for table `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`id_spp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `spp`
--
ALTER TABLE `spp`
  MODIFY `id_spp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id_spp`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`nisn`) REFERENCES `siswa` (`nisn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id_spp`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

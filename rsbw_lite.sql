-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2024 at 04:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsbw_lite`
--

-- --------------------------------------------------------

--
-- Table structure for table `file_casemix`
--

CREATE TABLE `file_casemix` (
  `id` int(50) NOT NULL,
  `no_rkm_medis` varchar(50) NOT NULL,
  `no_rawat` varchar(50) NOT NULL,
  `nama_pasein` varchar(100) NOT NULL,
  `jenis_berkas` varchar(50) NOT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_farmasi`
--

CREATE TABLE `file_farmasi` (
  `id` int(10) NOT NULL,
  `no_rkm_medis` varchar(50) NOT NULL,
  `no_rawat` varchar(50) NOT NULL,
  `nama_pasein` varchar(100) NOT NULL,
  `jenis_berkas` varchar(50) NOT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_lookbook`
--

CREATE TABLE `jenis_lookbook` (
  `kd_jesni_lb` varchar(15) NOT NULL,
  `nama_jenis_lb` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_lookbook`
--

INSERT INTO `jenis_lookbook` (`kd_jesni_lb`, `nama_jenis_lb`) VALUES
('PRAPK001', 'LOG BOOK PERAWAT PRA PK'),
('PRHD001', 'LOG BOOK PERAWAT HD PK II '),
('PRPK001', 'LOG BOOK PERAWAT PK I'),
('PRPK002', 'LOG BOOK PERAWAT PK II'),
('PSNIPK001', 'LOG BOOK PERAWAT SEMINATAN KMB NON INFEKSI PK III');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_lookbook_kegiatan_lain`
--

CREATE TABLE `jenis_lookbook_kegiatan_lain` (
  `id_kegiatan` varchar(50) NOT NULL,
  `nama_kegiatan` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_lookbook_kegiatan_lain`
--

INSERT INTO `jenis_lookbook_kegiatan_lain` (`id_kegiatan`, `nama_kegiatan`) VALUES
('KGL01', 'Melaksanakan kegiatan lain'),
('KGL02', 'Mengikuti rapat/pertemuan'),
('KGL03', 'Penerapan Etik dan Disiplin  Profesi'),
('KGL04', 'Pengembangan Diri Profesional');

-- --------------------------------------------------------

--
-- Table structure for table `list_dokter`
--

CREATE TABLE `list_dokter` (
  `kd_dokter` varchar(255) NOT NULL,
  `nama_dokter` varchar(255) NOT NULL,
  `kd_loket` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logbook_keperawatan`
--

CREATE TABLE `logbook_keperawatan` (
  `id_logbook` int(50) NOT NULL,
  `kd_kegiatan` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `no_rkm_medis` varchar(50) NOT NULL,
  `mandiri` varchar(50) NOT NULL,
  `supervisi` varchar(50) NOT NULL,
  `tanggal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logbook_keperawatan`
--

INSERT INTO `logbook_keperawatan` (`id_logbook`, `kd_kegiatan`, `user`, `no_rkm_medis`, `mandiri`, `supervisi`, `tanggal`) VALUES
(89, 'D0001', '22081999', '336811', '1', '0', '2024-02-28'),
(90, 'E0001', '22081999', '336811', '1', '1', '2024-02-28'),
(91, 'E0001', '22081999', '336811', '0', '1', '2024-02-28'),
(92, 'E0001', '22081999', '336811', '0', '1', '2024-02-28'),
(93, 'D0001', '22081999', '336811', '1', '0', '2024-02-28'),
(94, 'E0001', '22081999', '336811', '0', '1', '2024-02-28'),
(95, 'D0001', '22081999', '336811', '1', '0', '2024-02-28'),
(96, 'D0001', '22081999', '336811', '1', '0', '2024-02-28'),
(97, 'D0001', '22081999', '336811', '1', '0', '2024-02-28'),
(98, 'D0001', '22081999', '336811', '1', '0', '2024-02-28'),
(99, 'D0001', '22081999', '336811', '1', '0', '2024-02-28'),
(100, 'D0001', '22081999', '336811', '1', '0', '2024-02-28'),
(101, 'E0001', '22081999', '336811', '0', '1', '2024-02-28'),
(102, 'E0002', '22081999', '336811', '0', '1', '2024-02-28'),
(103, 'E0003', '22081999', '336811', '1', '1', '2024-02-28'),
(104, 'A0001', '22081999', '365608', '1', '0', '2024-03-04'),
(105, 'A0002', '22081999', '365608', '1', '0', '2024-03-04'),
(106, 'A0003', '22081999', '365608', '1', '0', '2024-03-04'),
(107, 'A0004', '22081999', '365608', '1', '0', '2024-03-04'),
(108, 'A0005', '22081999', '365608', '1', '0', '2024-03-04'),
(109, 'A0019', '22081999', '365608', '1', '0', '2024-03-04'),
(110, 'B0031', '22081999', '365608', '1', '0', '2024-03-04'),
(111, 'E0001', '22081999', '365609', '1', '0', '2024-03-04'),
(112, 'E0005', '22081999', '365609', '1', '1', '2024-03-04'),
(113, 'E0003', '22081999', '365609', '0', '1', '2024-03-04'),
(114, 'A0001', '0101.01.0638', '350324', '1', '0', '2024-03-07'),
(115, 'A0013', '0101.01.0638', '350324', '1', '0', '2024-03-07'),
(116, 'A0021', '0101.01.0638', '350324', '1', '0', '2024-03-07'),
(117, 'A0044', '0101.01.0638', '350324', '1', '0', '2024-03-07'),
(118, 'E0001', '22081999', '365608', '0', '1', '2024-03-08'),
(119, 'E0002', '22081999', '365608', '0', '1', '2024-03-08'),
(120, 'E0001', '22081999', '365608', '0', '1', '2024-03-08'),
(121, 'E0001', '22081999', '365607', '0', '1', '2024-03-08'),
(122, 'E0001', '22081999', '365607', '0', '1', '2024-03-08'),
(123, 'E0010', '22081999', '365601', '0', '1', '2024-03-08'),
(124, 'E0001', '22081999', '365601', '0', '1', '2024-03-08'),
(125, 'E0001', '22081999', '365601', '0', '1', '2024-03-07'),
(126, 'A0001', '22081999', '365608', '1', '0', '2024-03-08'),
(127, 'A0001', '22081999', '365608', '1', '0', '2024-03-08'),
(128, 'A0001', '22081999', '365608', '1', '0', '2024-03-08'),
(129, 'A0001', '22081999', '365601', '1', '0', '2024-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `logbook_keperawatan_kegiatanlain`
--

CREATE TABLE `logbook_keperawatan_kegiatanlain` (
  `id_kegiatan_keperawatanlain` int(50) NOT NULL,
  `id_kegiatan` varchar(50) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `deskripsi` text NOT NULL,
  `user` varchar(50) NOT NULL,
  `mandiri` varchar(10) NOT NULL,
  `supervisi` varchar(10) NOT NULL,
  `tanggal` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logbook_keperawatan_kewenangankhusus`
--

CREATE TABLE `logbook_keperawatan_kewenangankhusus` (
  `id_kewenangankhusus` int(11) NOT NULL,
  `kd_kewenangan` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `no_rkm_medis` varchar(50) NOT NULL,
  `mandiri` varchar(50) NOT NULL,
  `supervisi` varchar(50) NOT NULL,
  `tanggal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_antrian_loket`
--

CREATE TABLE `log_antrian_loket` (
  `no_rawat` varchar(255) NOT NULL,
  `kd_loket` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loket`
--

CREATE TABLE `loket` (
  `kd_loket` varchar(255) NOT NULL,
  `nama_loket` varchar(255) NOT NULL,
  `kd_pendaftaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loket`
--

INSERT INTO `loket` (`kd_loket`, `nama_loket`, `kd_pendaftaran`) VALUES
('LOKET A', 'LOKET A', 'A'),
('LOKET B', 'LOKET B', 'A'),
('LOKET D', 'LOKET D', 'B'),
('LOKET E', 'LOKET E', 'B'),
('LOKET F', 'LOKET F', 'B'),
('LOKET FISIO', 'LOKET FISIOTERAPI', 'FISIO'),
('LOKET G5', 'LOKET G5', 'G5');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `kd_pendaftaran` varchar(255) NOT NULL,
  `nama_pendaftaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`kd_pendaftaran`, `nama_pendaftaran`) VALUES
('A', 'PENDAFTARAN A'),
('B', 'PENDAFTARAN B'),
('FISIO', 'FISIOTERAPI'),
('G5', 'PENDAFTARAN G5');

-- --------------------------------------------------------

--
-- Table structure for table `rsbw_kewenangankhusus_keperawatan`
--

CREATE TABLE `rsbw_kewenangankhusus_keperawatan` (
  `kd_kewenangan` varchar(50) NOT NULL,
  `nama_kewenangan` varchar(250) NOT NULL,
  `kd_jesni_lb` varchar(50) NOT NULL,
  `default_mandiri` varchar(20) NOT NULL,
  `default_supervisi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rsbw_kewenangankhusus_keperawatan`
--

INSERT INTO `rsbw_kewenangankhusus_keperawatan` (`kd_kewenangan`, `nama_kewenangan`, `kd_jesni_lb`, `default_mandiri`, `default_supervisi`) VALUES
('KWA001', 'Melakukan perawatan pre dan post operasi.', 'PRPK001', 'true', 'false'),
('KWA002', 'Melakukan suction pada pasien dengan  alat bantu nafas.', 'PRPK001', 'true', 'false'),
('KWA003', 'Melepas Intra vena  (IV) line central', 'PRPK001', 'true', 'false'),
('KWA004', 'Melakukan komunikasi dengan klien dengan hambatan komunikasi', 'PRPK001', 'true', 'false'),
('KWA005', 'Mendampingi pasien untuk tindakan bone morrow punction (BMP) dan lumbal punction(LP)', 'PRPK001', 'true', 'false'),
('KWA006', 'Memberikan makan pada pasien dengan disfagia', 'PRPK001', 'true', 'false'),
('KWA007', 'Memfasilitasi kebutuhan oksigenasi dengan High Flow (Baging, juction rice)', 'PRPK001', 'false', 'true'),
('KWA008', 'Menyiapkan pasien untuk dilakukan perspirasi test', 'PRPK001', 'false', 'true'),
('KWA009', 'Melakukan perawatan pasien terpasang WSD', 'PRPK001', 'false', 'true'),
('KWA010', 'Melakukan perawatan pasien post pemasangan double lumen', 'PRPK001', 'false', 'true'),
('KWA011', 'Melakukan perawatan pasien post pemasangan AV Shunting', 'PRPK001', 'false', 'true'),
('KWA012', 'Mengambil sampel darah melalui arteri untuk pemeriksaan BGA', 'PRPK001', 'false', 'true'),
('KWB001', 'Melakukan perawatan pre dan post operasi.', 'PRPK002', 'true', 'false'),
('KWB002', 'Melakukan suction pada pasien dengan  alat bantu nafas.', 'PRPK002', 'true', 'false'),
('KWB003', 'Melepas Intra vena  (IV) line central', 'PRPK002', 'true', 'false'),
('KWB004', 'Melakukan komunikasi dengan klien dengan hambatan komunikasi', 'PRPK002', 'true', 'false'),
('KWB005', 'Mendampingi pasien untuk tindakan bone morrow punction (BMP) dan lumbal punction(LP)', 'PRPK002', 'true', 'false'),
('KWB006', 'Memberikan makan pada pasien dengan disfagia', 'PRPK002', 'true', 'false'),
('KWB007', 'Memfasilitasi kebutuhan oksigenasi dengan High Flow (Baging, juction rice)', 'PRPK002', 'true', 'false'),
('KWB008', 'Menyiapkan pasien untuk dilakukan perspirasi test', 'PRPK002', 'true', 'false'),
('KWB009', 'Melakukan perawatan pasien terpasang WSD', 'PRPK002', 'true', 'false'),
('KWB010', 'Melakukan perawatan pasien post pemasangan double lumen', 'PRPK002', 'true', 'false'),
('KWB011', 'Melakukan perawatan pasien post pemasangan AV Shunting', 'PRPK002', 'true', 'false'),
('KWB012', 'Mengambil sampel darah melalui arteri untuk pemeriksaan BGA', 'PRPK002', 'true', 'false'),
('KWB013', 'Memfasilitasi pasien dalam peer group', 'PRPK002', 'false', 'true'),
('KWB014', 'Melakukan Discharge Planing', 'PRPK002', 'false', 'true'),
('KWB015', 'Melakukan fisioterapi dada', 'PRPK002', 'false', 'true'),
('KWB016', 'Interpretasi hasil kritis.', 'PRPK002', 'false', 'true'),
('KWB017', 'Merawat pasien dengan acut lung odema', 'PRPK002', 'false', 'true'),
('KWB018', 'Melakukan penelitian perawatan medikal secara bersama', 'PRPK002', 'false', 'true'),
('KWB019', 'Mengatur posisi netral kepala, leher, tulang punggung untuk meminimalisasi gangguan neurologis ', 'PRPK002', 'false', 'true'),
('KWB020', 'Melakukan preceptorship dan mentorship', 'PRPK002', 'false', 'true'),
('KWB021', 'Melakukan perawatan akhir hayat', 'PRPK002', 'false', 'true'),
('KWB022', 'Interpretasi EKG', 'PRPK002', 'false', 'true'),
('KWC001', 'Melakukan perawatan pre dan post operasi.', 'PSNIPK001', 'true', 'false'),
('KWC002', 'Melakukan suction pada pasien dengan  alat bantu nafas.', 'PSNIPK001', 'true', 'false'),
('KWC003', 'Melepas Intra vena  (IV) line central', 'PSNIPK001', 'true', 'false'),
('KWC004', 'Melakukan komunikasi dengan klien dengan hambatan komunikasi', 'PSNIPK001', 'true', 'false'),
('KWC005', 'Mendampingi pasien untuk tindakan bone morrow punction (BMP) dan lumbal punction(LP)', 'PSNIPK001', 'true', 'false'),
('KWC006', 'Memberikan makan pada pasien dengan disfagia', 'PSNIPK001', 'true', 'false'),
('KWC007', 'Memfasilitasi kebutuhan oksigenasi dengan High Flow (Baging, juction rice)', 'PSNIPK001', 'true', 'false'),
('KWC008', 'Menyiapkan pasien untuk dilakukan perspirasi test', 'PSNIPK001', 'true', 'false'),
('KWC009', 'Melakukan perawatan pasien terpasang WSD', 'PSNIPK001', 'true', 'false'),
('KWC010', 'Melakukan perawatan pasien post pemasangan double lumen', 'PSNIPK001', 'true', 'false'),
('KWC011', 'Melakukan perawatan pasien post pemasangan AV Shunting', 'PSNIPK001', 'true', 'false'),
('KWC012', 'Mengambil sampel darah melalui arteri untuk pemeriksaan BGA', 'PSNIPK001', 'true', 'false'),
('KWC013', 'Memfasilitasi pasien dalam peer group', 'PSNIPK001', 'true', 'false'),
('KWC014', 'Melakukan Discharge Planing', 'PSNIPK001', 'true', 'false'),
('KWC015', 'Melakukan fisioterapi dada', 'PSNIPK001', 'true', 'false'),
('KWC016', 'Interpretasi hasil kritis.', 'PSNIPK001', 'true', 'false'),
('KWC017', 'Merawat pasien dengan acut lung odema', 'PSNIPK001', 'true', 'false'),
('KWC018', 'Melakukan penelitian perawatan medikal secara bersama', 'PSNIPK001', 'true', 'false'),
('KWC019', 'Mengatur posisi netral kepala, leher, tulang punggung untuk meminimalisasi gangguan neurologis ', 'PSNIPK001', 'true', 'false'),
('KWC020', 'Melakukan preceptorship dan mentorship', 'PSNIPK001', 'true', 'false'),
('KWC021', 'Melakukan perawatan akhir hayat', 'PSNIPK001', 'true', 'false'),
('KWC022', 'Interpretasi EKG', 'PSNIPK001', 'true', 'false'),
('KWC023', 'Memverifikasi dan Mengevaluasi mutu asuhan keperawatan', 'PSNIPK001', 'false', 'true'),
('KWC024', 'Melakukan kolaborasi dengan profesi lain dalam memberikan asuhan keperawatan.', 'PSNIPK001', 'false', 'true'),
('KWC025', 'Melakukan pengelolaan asuhan keperawatan pasien dengan gangguan konsep diri.', 'PSNIPK001', 'false', 'true'),
('KWC026', 'Melakukan pengelolaan asuhan keperawatan pasien dalam menghadapi stres adaptasi.', 'PSNIPK001', 'false', 'true'),
('KWC027', 'Melakukan edukasi dan kolabarasi therapy komplementer dengan tim profesi lain.', 'PSNIPK001', 'false', 'true'),
('KWC028', 'Mampu memberikan konseling terhadap pasien dan keluarga dengan masalah seksualitas.', 'PSNIPK001', 'false', 'true'),
('KWC029', 'Melakukan supervisi lapangan ', 'PSNIPK001', 'false', 'true'),
('KWC030', 'Konseling pada satu bidang yang dikuasainya.', 'PSNIPK001', 'false', 'true'),
('KWC031', 'Melakukan bimbingan pada PK dibawahnya', 'PSNIPK001', 'false', 'true'),
('KWC032', 'Melakukan, mengelola dan melaksanakan pendidikan keperawatan kepada  pasien dan keluarga', 'PSNIPK001', 'false', 'true'),
('KWC033', 'Melaksanakan penelitian keperawatan medikal secara individu', 'PSNIPK001', 'false', 'true'),
('KWC034', 'Melakukan kolaborasi asuhan keperawatan pada pasien khusus dengan profesi lain didalam maupun diluar rumah sakit.', 'PSNIPK001', 'false', 'true'),
('KWE001', 'Melakukan perawatan pre dan post operasi.', 'PRAPK001', 'false', 'true'),
('KWE002', 'Melakukan suction pada pasien dengan  alat bantu nafas.', 'PRAPK001', 'false', 'true'),
('KWE003', 'Melepas Intra vena  (IV) line central', 'PRAPK001', 'false', 'true'),
('KWE004', 'Melakukan komunikasi dengan klien dengan hambatan komunikasi', 'PRAPK001', 'false', 'true'),
('KWE005', 'Mendampingi pasien untuk tindakan bone morrow punction (BMP) dan lumbal punction(LP)', 'PRAPK001', 'false', 'true'),
('KWE006', 'Memberikan makan pada pasien dengan disfagia', 'PRAPK001', 'false', 'true'),
('KWE007', 'Memfasilitasi kebutuhan oksigenasi dengan High Flow (Baging, juction rice)', 'PRAPK001', 'false', 'true'),
('KWE008', 'Menyiapkan pasien untuk dilakukan perspirasi test', 'PRAPK001', 'false', 'true'),
('KWE009', 'Melakukan perawatan pasien terpasang WSD', 'PRAPK001', 'false', 'true'),
('KWE010', 'Melakukan perawatan pasien post pemasangan double lumen', 'PRAPK001', 'false', 'true'),
('KWE011', 'Melakukan perawatan pasien post pemasangan AV Shunting', 'PRAPK001', 'false', 'true'),
('KWE012', 'Mengambil sampel darah melalui arteri untuk pemeriksaan BGA', 'PRAPK001', 'false', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `rsbw_nm_kegiatan_keperawatan`
--

CREATE TABLE `rsbw_nm_kegiatan_keperawatan` (
  `kd_kegiatan` varchar(122) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `kd_jesni_lb` varchar(15) NOT NULL,
  `default_mandiri` varchar(12) NOT NULL,
  `default_supervisi` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rsbw_nm_kegiatan_keperawatan`
--

INSERT INTO `rsbw_nm_kegiatan_keperawatan` (`kd_kegiatan`, `nama_kegiatan`, `kd_jesni_lb`, `default_mandiri`, `default_supervisi`) VALUES
('A0001', 'Melakukan asuhan keperawatan (pengkajian, menetapkan diagnosis keperawatan, menetapkan intervensi dan melaksanakan tindakan keperawatan serta evaluasi) dengan lingkup keterampilan tehnik dasar.', 'PRPK001', 'true', 'false'),
('A0002', 'Menerapkan prinsip etik, legal, dan peka budaya dalam asuhan keperawatan.', 'PRPK001', 'true', 'false'),
('A0003', 'Melakukan komunikasi terapeutik di dalam asuhan keperawatan.', 'PRPK001', 'true', 'false'),
('A0004', 'Menerapkan caring dalam keperawatan.', 'PRPK001', 'true', 'false'),
('A0005', 'Menerapkan prinsip keselamatan klien.', 'PRPK001', 'true', 'false'),
('A0006', 'Menerapkan prinsip Pengendalian dan Pencegahan Infeksi.', 'PRPK001', 'true', 'false'),
('A0007', 'Melakukan kerjasama tim dalam asuhan keperawatan.', 'PRPK001', 'true', 'false'),
('A0008', 'Menerapkan prinsip mutu dalam tindakan keperawatan.', 'PRPK001', 'true', 'false'),
('A0009', 'Melakukan proses edukasi kesehatan pada klien terkait dengan kebutuhan dasar.', 'PRPK001', 'true', 'false'),
('A0010', 'Mengumpulkan data kuantitatif untuk kegiatan pembuatan laporan kasus klien.', 'PRPK001', 'true', 'false'),
('A0011', 'Mengumpulkan data riset sebagai anggota tim penelitian.', 'PRPK001', 'true', 'false'),
('A0012', 'Menunjukkan sikap memperlakukan klien tanpa membedakan suku, agama, ras dan antar golongan.', 'PRPK001', 'true', 'false'),
('A0013', 'Menunjukkan sikap pengharapan dan keyakinan terhadap pasien.', 'PRPK001', 'true', 'false'),
('A0014', 'Menunjukkan hubungan saling percaya dengan klien dan keluarga.', 'PRPK001', 'true', 'false'),
('A0015', 'Menunjukkan sikap asertif.', 'PRPK001', 'true', 'false'),
('A0016', 'Menunjukkan sikap empati.', 'PRPK001', 'true', 'false'),
('A0017', 'Menunjukkan sikap etik.', 'PRPK001', 'true', 'false'),
('A0018', 'Menunjukkan kepatuhan terhadap penerapan standar dan pedoman keperawatan.', 'PRPK001', 'true', 'false'),
('A0019', 'Menunjukkan tanggung jawab terhadap penerapan asuhan keperawatan sesuai kewenangannya.', 'PRPK001', 'true', 'false'),
('A0020', 'Menunjukkan sikap kerja yang efektif dan efisien dalam pengelolaan klien.', 'PRPK001', 'true', 'false'),
('A0021', 'Menunjukkan sikap saling percaya dan menghargai antara anggota tim dalam pengelolaan asuhan keperawatan.', 'PRPK001', 'true', 'false'),
('A0022', 'Melakukan tindakan-tindakan untuk mencegah cedera pada Klien', 'PRPK001', 'true', 'false'),
('A0023', 'Melakukan  alih baring dan Range Of Motion (ROM)', 'PRPK001', 'true', 'false'),
('A0024', 'Melakukan ambulasi ', 'PRPK001', 'true', 'false'),
('A0025', 'Mengelola terapi oksigen aliran rendah (nasal canule, masker sederhana, masker rebreathing, masker non re breathing)', 'PRPK001', 'true', 'false'),
('A0026', 'Mengelola terapi nebulizer', 'PRPK001', 'true', 'false'),
('A0027', 'Melakukan suction pada pasien tanpa alat bantu nafas.', 'PRPK001', 'true', 'false'),
('A0028', 'Menghitung balance cairan', 'PRPK001', 'true', 'false'),
('A0029', 'Memasang dan melepas Intra Veneus line chateter tanpa penyulit', 'PRPK001', 'true', 'false'),
('A0030', 'Memasang dan melepas urine chatheter tanpa penyulit', 'PRPK001', 'true', 'false'),
('A0031', 'Mengukur tanda-tanda vital', 'PRPK001', 'true', 'false'),
('A0032', 'Melakukan perekaman EKG', 'PRPK001', 'true', 'false'),
('A0033', 'Melakukan  pemeriksaan kesadaran kualitatif dan kuantitatif', 'PRPK001', 'true', 'false'),
('A0034', 'Mengkaji tanda kegawat daruratan (kriteria Bellomo)', 'PRPK001', 'true', 'false'),
('A0035', 'Melakukan pemeriksaan gula darah dengan glukosa stik', 'PRPK001', 'true', 'false'),
('A0036', 'Melakukan pengambilan sampel laborat (darah vena, urine, feses)', 'PRPK001', 'true', 'false'),
('A0037', 'Melakukan perawatan luka bersih', 'PRPK001', 'true', 'false'),
('A0038', 'Memberikan obat melalui oral, intra  vena, intra muscular, sub cutan, intra cutan, sub lingual, suppositoria, topikal', 'PRPK001', 'true', 'false'),
('A0039', 'Memberikan produk darah ', 'PRPK001', 'true', 'false'),
('A0040', 'Melakukan bantuan hidup dasar', 'PRPK001', 'true', 'false'),
('A0041', 'Melakukan manajemen nyeri', 'PRPK001', 'true', 'false'),
('A0042', 'Memenuhi kebutuhan istirahat dan tidur', 'PRPK001', 'true', 'false'),
('A0043', 'Memenuhi kebutuhan thermoregulasi', 'PRPK001', 'true', 'false'),
('A0044', 'Memenuhi kebutuhan spiritual', 'PRPK001', 'true', 'false'),
('A0045', 'Memenuhi  kebutuhan personal hygiene', 'PRPK001', 'true', 'false'),
('A0046', 'Membantu eliminasi BAB dan BAK', 'PRPK001', 'true', 'false'),
('A0047', 'Memberikan nutrisi per oral', 'PRPK001', 'true', 'false'),
('A0048', 'Memberikan nutrisi enteral  (Oro Gastric Tube (OGT), Naso Gastric Tube(NGT))', 'PRPK001', 'true', 'false'),
('A0049', 'Memasang dan Melepas Oro Gastric Tube (OGT), Naso Gastric Tube(NGT)) tanpa penyulit', 'PRPK001', 'true', 'false'),
('A0050', 'Mengelola pasien dengan restrain', 'PRPK001', 'true', 'false'),
('A0051', 'Menyiapkan pemeriksaan urine esbach', 'PRPK001', 'true', 'false'),
('A0052', 'Memberikan terapi titrasi', 'PRPK001', 'true', 'false'),
('B0001', 'Melakukan asuhan keperawatan dengan tahapan dan pendekatan proses keperawatan pada klien dengan tingkat ketergantungan partial dan total care.', 'PRPK002', 'true', 'false'),
('B0002', 'Menerapkan prinsip kepemimpinan dalam melaksanakan asuhan keperawatan.', 'PRPK002', 'true', 'false'),
('B0003', 'Menerapkan konsep pengelolaan asuhan keperawatan pada sekelompok klien.', 'PRPK002', 'true', 'false'),
('B0004', 'Mengidentifikasi tingkat ketergantungan klien untuk menentukan intervensi keperawatan', 'PRPK002', 'true', 'false'),
('B0005', 'Menetapkan jenis intervensi keperawatan sesuai tingkat ketergantugan klien.', 'PRPK002', 'true', 'false'),
('B0006', 'Menerapkan prinsip etik, legal, dan peka budaya dalam pemberian asuhan keperawatan.', 'PRPK002', 'true', 'false'),
('B0007', 'Menggunakan komunikasi terapeutik yang sesuai dengan karakteristik dan masalah klien.', 'PRPK002', 'true', 'false'),
('B0008', 'Menerapkan caring yang sesuai dengan karakteristik dan masalah klien.', 'PRPK002', 'true', 'false'),
('B0009', 'Melakukan kajian insiden keselamatan klien dan manajemen risiko klinis.', 'PRPK002', 'true', 'false'),
('B0010', 'Melakukan kajian terhadap kejadian dan risiko infeksi pada klien.', 'PRPK002', 'true', 'false'),
('B0011', 'Melakukan kerjasama antar tim.', 'PRPK002', 'true', 'false'),
('B0012', 'Menerapkan pengendalian mutu dengan satu metoda tertentu sesuai kebijakan rumah sakit setempat.', 'PRPK002', 'true', 'false'),
('B0013', 'Mengimplementasikan pengendalian mutu asuhan keperawatan.', 'PRPK002', 'true', 'false'),
('B0014', 'Merumuskan kebutuhan belajar klien dan keluarga secara holistik sesuai dengan masalah kesehatan klien.', 'PRPK002', 'true', 'false'),
('B0015', 'Menyusun rancangan pembelajaran sesuai dengan kebutuhan belajar klien dan keluarga.', 'PRPK002', 'true', 'false'),
('B0016', 'Melakukan proses edukasi kesehatan pada klien dan keluarga.', 'PRPK002', 'true', 'false'),
('B0017', 'Mengevaluasi ketercapaian edukasi kesehatan dan rencana tindak lanjut.', 'PRPK002', 'true', 'false'),
('B0018', 'Melaksanakan preceptorsip pada tenaga perawat di bawah bimbingannya dan praktikan.', 'PRPK002', 'true', 'false'),
('B0019', 'Melakukan diskusi refleksi kasus untuk meningkatkan kualitas pemberian asuhan keperawatan.', 'PRPK002', 'true', 'false'),
('B0020', 'Menggunakan hasil penelitian dalam pemberian asuhan keperawatan.', 'PRPK002', 'true', 'false'),
('B0021', 'Membantu pelaksanaan riset keperawatan deskriptif.', 'PRPK002', 'true', 'false'),
('B0022', 'Melakukan survey keperawatan.', 'PRPK002', 'true', 'false'),
('B0023', 'Menunjukkan sikap memperlakukan klien tanpa membedakan suku, agama, ras dan antar golongan.', 'PRPK002', 'true', 'false'),
('B0024', 'Menunjukkan sikap pengharapan dan keyakinan terhadap pasien.', 'PRPK002', 'true', 'false'),
('B0025', 'Menunjukkan hubungan saling percaya dengan klien dan keluarga.', 'PRPK002', 'true', 'false'),
('B0026', 'Menunjukkan sikap asertif.', 'PRPK002', 'true', 'false'),
('B0027', 'Menunjukkan sikap empati.', 'PRPK002', 'true', 'false'),
('B0028', 'Menunjukkan sikap etik.', 'PRPK002', 'true', 'false'),
('B0029', 'Menunjukkan kepatuhan terhadap penerapan standar dan pedoman keperawatan.', 'PRPK002', 'true', 'false'),
('B0030', 'Menunjukkan tanggung jawab terhadap penerapan asuhan keperawatan sesuai kewenangannya.', 'PRPK002', 'true', 'false'),
('B0031', 'Menunjukkan sikap kerja yang efektif dan efisien dalam pengelolaan klien.', 'PRPK002', 'true', 'false'),
('B0032', 'Menunjukkan sikap saling percaya dan menghargai antara anggota tim dalam pengelolaan asuhan keperawatan.', 'PRPK002', 'true', 'false'),
('B0033', 'Melakukan tindakan-tindakan untuk mencegah cedera pada Klien', 'PRPK002', 'true', 'false'),
('B0034', 'Melakukan  alih baring dan Range Of Motion (ROM)', 'PRPK002', 'true', 'false'),
('B0035', 'Melakukan ambulasi ', 'PRPK002', 'true', 'false'),
('B0036', 'Mengelola terapi oksigen aliran rendah (nasal canule, masker sederhana, masker rebreathing, masker non re breathing)', 'PRPK002', 'true', 'false'),
('B0037', 'Mengelola terapi nebulizer', 'PRPK002', 'true', 'false'),
('B0038', 'Melakukan suction pada pasien tanpa alat bantu nafas.', 'PRPK002', 'true', 'false'),
('B0039', 'Menghitung balance cairan', 'PRPK002', 'true', 'false'),
('B0040', 'Memasang dan melepas Intra Veneus line chateter tanpa penyulit', 'PRPK002', 'true', 'false'),
('B0041', 'Memasang dan melepas urine chatheter tanpa penyulit', 'PRPK002', 'true', 'false'),
('B0042', 'Mengukur tanda-tanda vital', 'PRPK002', 'true', 'false'),
('B0043', 'Melakukan perekaman EKG', 'PRPK002', 'true', 'false'),
('B0044', 'Melakukan  pemeriksaan kesadaran kualitatif dan kuantitatif', 'PRPK002', 'true', 'false'),
('B0045', 'Mengkaji tanda kegawat daruratan (kriteria Bellomo)', 'PRPK002', 'true', 'false'),
('B0046', 'Melakukan pemeriksaan gula darah dengan glukosa stik', 'PRPK002', 'true', 'false'),
('B0047', 'Melakukan pengambilan sampel laborat (darah vena, urine, feses)', 'PRPK002', 'true', 'false'),
('B0048', 'Melakukan perawatan luka bersih', 'PRPK002', 'true', 'false'),
('B0049', 'Memberikan obat melalui oral, intra  vena, intra muscular, sub cutan, intra cutan, sub lingual, suppositoria, topikal', 'PRPK002', 'true', 'false'),
('B0050', 'Memberikan produk darah ', 'PRPK002', 'true', 'false'),
('B0051', 'Melakukan bantuan hidup dasar', 'PRPK002', 'true', 'false'),
('B0052', 'Melakukan manajemen nyeri', 'PRPK002', 'true', 'false'),
('B0053', 'Memenuhi kebutuhan istirahat dan tidur', 'PRPK002', 'true', 'false'),
('B0054', 'Memenuhi kebutuhan thermoregulasi', 'PRPK002', 'true', 'false'),
('B0055', 'Memenuhi kebutuhan spiritual', 'PRPK002', 'true', 'false'),
('B0056', 'Memenuhi  kebutuhan personal hygiene', 'PRPK002', 'true', 'false'),
('B0057', 'Membantu eliminasi BAB dan BAK', 'PRPK002', 'true', 'false'),
('B0058', 'Memberikan nutrisi per oral', 'PRPK002', 'true', 'false'),
('B0059', 'Memberikan nutrisi enteral  (Oro Gastric Tube (OGT), Naso Gastric Tube(NGT))', 'PRPK002', 'true', 'false'),
('B0060', 'Memasang dan Melepas Oro Gastric Tube (OGT), Naso Gastric Tube(NGT)) tanpa penyulit', 'PRPK002', 'true', 'false'),
('B0061', 'Mengelola pasien dengan restrain', 'PRPK002', 'true', 'false'),
('B0062', 'Menyiapkan pemeriksaan urine esbach', 'PRPK002', 'true', 'false'),
('B0063', 'Memberikan terapi titrasi', 'PRPK002', 'true', 'false'),
('C0001', 'Melakukan pemberian asuhan keperawatan pada klien dengan tingkat ketergantung partial dan total dengan masalah kompleks di area keperawatan spesifik.', 'PSNIPK001', 'true', 'false'),
('C0002', 'Menerapkan filosofi dasar keperawatan pada area keperawatan spesifik.', 'PSNIPK001', 'true', 'false'),
('C0003', 'Menerapkan penyelesaian dan pengambilan keputusan masalah etik, legal dalam asuhan keperawatan di unit keperawatan.', 'PSNIPK001', 'true', 'false'),
('C0004', 'Menetapkan jenis intervensi keperawatan sesuai tingkat ketergantungan klien pada lingkup area spesifik.', 'PSNIPK001', 'true', 'false'),
('C0005', 'Menerapkan prinsip kepemimpinan dalam melaksanakan asuhan keperawatan.', 'PSNIPK001', 'true', 'false'),
('C0006', 'Menerapkan konsep pengelolaan asuhan keperawatan pada unit ruang rawat.', 'PSNIPK001', 'true', 'false'),
('C0007', 'Menggunakan metode penugasan yang sesuai dalam pengelolaan asuhan keperawatan di unit ruang rawat.', 'PSNIPK001', 'true', 'false'),
('C0008', 'Menetapkan masalah mutu asuhan keperawatan berdasarkan kajian standar dan kebijakan mutu.', 'PSNIPK001', 'true', 'false'),
('C0009', 'Melaksanakan analisis akar masalah (RCA) dan membuat grading risiko terhadap masalah klinis.', 'PSNIPK001', 'true', 'false'),
('C0010', 'Mengidentifikasi kebutuhan belajar klien dan keluarga secara holistik sesuai dengan masalah kesehatan klien di area spesifik.', 'PSNIPK001', 'true', 'false'),
('C0011', 'Mengidentifikasi dan memilih sumber-sumber yang tersedia untuk edukasi kesehatan pada area spesifik.', 'PSNIPK001', 'true', 'false'),
('C0012', 'Melakukan tahapan penyelesaian masalah etik, legal dalam asuhan keperawatan.', 'PSNIPK001', 'true', 'false'),
('C0013', 'Menggunakan komunikasi terapeutik yang sesuai dengan karakteristik dan masalah klien dan keluarga pada area spesifik.', 'PSNIPK001', 'true', 'false'),
('C0014', 'Menerapkan caring yang sesuai dengan karakteristik dan masalah klien di area spesifik.', 'PSNIPK001', 'true', 'false'),
('C0015', 'Menerapkan prinsip kerjasama interdisiplin.', 'PSNIPK001', 'true', 'false'),
('C0016', 'Melaksanakan pengendalian mutu asuhan keperawatan di unit.', 'PSNIPK001', 'true', 'false'),
('C0017', 'Menyusun rancangan pembelajaran sesuai dengan kebutuhan belajar klien dan keluarga pada area spesifik.', 'PSNIPK001', 'true', 'false'),
('C0018', 'Melakukan proses edukasi kesehatan pada klien dan keluarga pada area spesifik.', 'PSNIPK001', 'true', 'false'),
('C0019', 'Mengevaluasi ketercapaian edukasi kesehatan pada area spesifik dan rencana tindak lanjut.', 'PSNIPK001', 'true', 'false'),
('C0020', 'Melaksanakan preceptorship dan mentorship pada area spesifik.', 'PSNIPK001', 'true', 'false'),
('C0021', 'Menginterpretasi hasil penelitian dalam pemberian asuhan keperawatan pada area spesifik.', 'PSNIPK001', 'true', 'false'),
('C0022', 'Menggunakan hasil penelitian dalam pemberian asuhan keperawatan pada area spesifik.', 'PSNIPK001', 'true', 'false'),
('C0023', 'Melakukan riset keperawatan deskriptif analitik dan inferensial.', 'PSNIPK001', 'true', 'false'),
('C0024', 'Menunjukkan sikap memperlakukan klien tanpa membedakan suku, agama, ras dan antar golongan.', 'PSNIPK001', 'true', 'false'),
('C0025', 'Menunjukkan sikap pengharapan dan keyakinan terhadap pasien.', 'PSNIPK001', 'true', 'false'),
('C0026', 'Menunjukkan hubungan saling percaya dengan klien dan keluarga.', 'PSNIPK001', 'true', 'false'),
('C0027', 'Menunjukkan sikap asertif.', 'PSNIPK001', 'true', 'false'),
('C0028', 'Menunjukkan sikap etik.', 'PSNIPK001', 'true', 'false'),
('C0029', 'Menunjukkan sikap empati.', 'PSNIPK001', 'true', 'false'),
('C0030', 'Menunjukkan kepatuhan terhadap penerapan standar dan pedoman keperawatan.', 'PSNIPK001', 'true', 'false'),
('C0031', 'Menunjukkan tanggung jawab terhadap penerapan asuhan keperawatan sesuai kewenangannya.', 'PSNIPK001', 'true', 'false'),
('C0032', 'Menunjukkan sikap kerja yang efektif dan efisien dalam pengelolaan klien.', 'PSNIPK001', 'true', 'false'),
('C0033', 'Menunjukkan sikap saling percaya dan menghargai antara anggota tim dalam pengelolaan asuhan keperawatan.', 'PSNIPK001', 'true', 'false'),
('C0034', 'Melakukan tindakan-tindakan untuk mencegah cedera pada Klien', 'PSNIPK001', 'true', 'false'),
('C0035', 'Melakukan  alih baring dan Range Of Motion (ROM)', 'PSNIPK001', 'true', 'false'),
('C0036', 'Melakukan ambulasi ', 'PSNIPK001', 'true', 'false'),
('C0037', 'Mengelola terapi oksigen aliran rendah (nasal canule, masker sederhana, masker rebreathing, masker non re breathing)', 'PSNIPK001', 'true', 'false'),
('C0038', 'Mengelola terapi nebulizer', 'PSNIPK001', 'true', 'false'),
('C0039', 'Melakukan suction pada pasien tanpa alat bantu nafas.', 'PSNIPK001', 'true', 'false'),
('C0040', 'Menghitung balance cairan', 'PSNIPK001', 'true', 'false'),
('C0041', 'Memasang dan melepas Intra Venous line chateter ', 'PSNIPK001', 'true', 'false'),
('C0042', 'Memasang dan melepas urine chatheter', 'PSNIPK001', 'true', 'false'),
('C0043', 'Mengukur tanda-tanda vital', 'PSNIPK001', 'true', 'false'),
('C0044', 'Melakukan perekaman EKG', 'PSNIPK001', 'true', 'false'),
('C0045', 'Melakukan  pemeriksaan kesadaran kualitatif dan kuantitatif', 'PSNIPK001', 'true', 'false'),
('C0046', 'Mengkaji tanda kegawat daruratan (kriteria Bellomo)', 'PSNIPK001', 'true', 'false'),
('C0047', 'Melakukan pemeriksaan gula darah dengan glukosa stik', 'PSNIPK001', 'true', 'false'),
('C0048', 'Melakukan pengambilan sampel laborat (darah vena, urine, feses)', 'PSNIPK001', 'true', 'false'),
('C0049', 'Melakukan perawatan luka bersih', 'PSNIPK001', 'true', 'false'),
('C0050', 'Memberikan obat melalui oral, intra  vena, intra muscular, sub cutan, intra cutan, sub lingual, suppositoria, topikal', 'PSNIPK001', 'true', 'false'),
('C0051', 'Memberikan produk darah ', 'PSNIPK001', 'true', 'false'),
('C0052', 'Melakukan bantuan hidup dasar', 'PSNIPK001', 'true', 'false'),
('C0053', 'Melakukan manajemen nyeri', 'PSNIPK001', 'true', 'false'),
('C0054', 'Memenuhi kebutuhan istirahat dan tidur', 'PSNIPK001', 'true', 'false'),
('C0055', 'Memenuhi kebutuhan thermoregulasi', 'PSNIPK001', 'true', 'false'),
('C0056', 'Memenuhi kebutuhan spiritual', 'PSNIPK001', 'true', 'false'),
('C0057', 'Memenuhi  kebutuhan personal hygiene', 'PSNIPK001', 'true', 'false'),
('C0058', 'Membantu eliminasi BAB dan BAK', 'PSNIPK001', 'true', 'false'),
('C0059', 'Memberikan nutrisi per oral', 'PSNIPK001', 'true', 'false'),
('C0060', 'Memberikan nutrisi enteral  (Oro Gastric Tube (OGT), Naso Gastric Tube(NGT))', 'PSNIPK001', 'true', 'false'),
('C0061', 'Memasang dan Melepas Oro Gastric Tube (OGT), Naso Gastric Tube(NGT))', 'PSNIPK001', 'true', 'false'),
('C0062', 'Mengelola pasien dengan restrain', 'PSNIPK001', 'true', 'false'),
('D0001', 'Melakukan pengkajian pasien yang akan menjalani HD, selama HD dan setelah HD', 'PRHD001', 'true', 'false'),
('D0002', 'Melakukan analisa data hasil pengkajian', 'PRHD001', 'true', 'false'),
('D0003', 'Menentukan masalah/diagnosa keperawatan pasien', 'PRHD001', 'true', 'false'),
('D0004', 'Menyusun rencana asuhan keperawatan berdasarkan diagnosa keperawatan yang  ada', 'PRHD001', 'true', 'false'),
('D0005', 'Melakukan dokumentasi asuhan keperawatan', 'PRHD001', 'true', 'false'),
('D0006', 'Membuat resume keparawatan', 'PRHD001', 'true', 'false'),
('D0007', 'Menjaga privasi & kerahasian status kesehatan pasien', 'PRHD001', 'true', 'false'),
('D0008', 'Meminta persetujuan setiap tindakan keperawatan yang akan dilakukan', 'PRHD001', 'true', 'false'),
('D0009', 'Melakukan komunikasi terapeutik', 'PRHD001', 'true', 'false'),
('D0010', 'Melakukan 5 saat dan 6 langkah hand hygiene dengan benar', 'PRHD001', 'true', 'false'),
('D0011', 'Menggunakan APD secara rasional/sesuai indikasi dengan benar', 'PRHD001', 'true', 'false'),
('D0012', 'Melakukan persiapan pasien HD', 'PRHD001', 'true', 'false'),
('D0013', 'Mempersiapkan alat dan bahan sebelum HD', 'PRHD001', 'true', 'false'),
('D0014', 'Mengidentifikasi kesiapan klien/pasien HD', 'PRHD001', 'true', 'false'),
('D0015', 'Pemberian antikoagulan ', 'PRHD001', 'true', 'false'),
('D0016', 'Akses vascular AV-Fistula ', 'PRHD001', 'true', 'false'),
('D0017', 'Akses vascular femoral ', 'PRHD001', 'true', 'false'),
('D0018', 'Perawatan HD Catheter', 'PRHD001', 'true', 'false'),
('D0019', 'Monitoring pasien selama HD', 'PRHD001', 'true', 'false'),
('D0020', 'Mendokumentasikan askep pasien HD', 'PRHD001', 'true', 'false'),
('D0021', 'Melakukan serah terima pasien di ruang HD', 'PRHD001', 'true', 'false'),
('D0022', 'Observasi pasien pasca HD', 'PRHD001', 'true', 'false'),
('D0023', 'Memberikan oksigen dengan sungkup rebreathing', 'PRHD001', 'true', 'false'),
('D0024', 'Memberikan oksigen dengan sungkup non rebreathing', 'PRHD001', 'true', 'false'),
('D0025', 'Penangganan komplikasi tehnik ( Clotting, blood leak, dll )', 'PRHD001', 'true', 'false'),
('D0026', 'Penanganan komplikasi non tehnik ( hipotensi, kram, menggigil dll)', 'PRHD001', 'true', 'false'),
('D0027', 'Terminasi HD', 'PRHD001', 'true', 'false'),
('D0028', 'Penilaian adekuasidialisis (URR atau Kt/V)', 'PRHD001', 'true', 'false'),
('D0029', 'Reprocessing dialiser ', 'PRHD001', 'true', 'false'),
('D0030', 'Menajemen perawatan dialysis', 'PRHD001', 'true', 'false'),
('D0031', 'Manajemen limbah', 'PRHD001', 'true', 'false'),
('D0032', 'Manajemen code blue', 'PRHD001', 'true', 'false'),
('E0001', 'Melakukan asuhan keperawatan (pengkajian, menetapkan diagnosis keperawatan, menetapkan intervensi dan melaksanakan tindakan keperawatan serta evaluasi) dengan lingkup keterampilan tehnik dasar.', 'PRAPK001', 'false', 'true'),
('E0002', 'Menerapkan prinsip etik, legal, dan peka budaya dalam asuhan keperawatan.', 'PRAPK001', 'false', 'true'),
('E0003', 'Melakukan komunikasi terapeutik di dalam asuhan keperawatan.', 'PRAPK001', 'false', 'true'),
('E0004', 'Menerapkan caring dalam keperawatan.', 'PRAPK001', 'false', 'true'),
('E0005', 'Menerapkan prinsip keselamatan klien.', 'PRAPK001', 'false', 'true'),
('E0006', 'Menerapkan prinsip Pengendalian dan Pencegahan Infeksi.', 'PRAPK001', 'false', 'true'),
('E0007', 'Melakukan kerjasama tim dalam asuhan keperawatan.', 'PRAPK001', 'false', 'true'),
('E0008', 'Menerapkan prinsip mutu dalam tindakan keperawatan.', 'PRAPK001', 'false', 'true'),
('E0009', 'Melakukan proses edukasi kesehatan pada klien terkait dengan kebutuhan dasar.', 'PRAPK001', 'false', 'true'),
('E0010', 'Mengumpulkan data kuantitatif untuk kegiatan pembuatan laporan kasus klien.', 'PRAPK001', 'false', 'true'),
('E0011', 'Mengumpulkan data riset sebagai anggota tim penelitian.', 'PRAPK001', 'false', 'true'),
('E0012', 'Menunjukkan sikap memperlakukan klien tanpa membedakan suku, agama, ras dan antar golongan.', 'PRAPK001', 'false', 'true'),
('E0013', 'Menunjukkan sikap pengharapan dan keyakinan terhadap pasien.', 'PRAPK001', 'false', 'true'),
('E0014', 'Menunjukkan hubungan saling percaya dengan klien dan keluarga.', 'PRAPK001', 'false', 'true'),
('E0015', 'Menunjukkan sikap asertif.', 'PRAPK001', 'false', 'true'),
('E0016', 'Menunjukkan sikap empati.', 'PRAPK001', 'false', 'true'),
('E0017', 'Menunjukkan sikap etik.', 'PRAPK001', 'false', 'true'),
('E0018', 'Menunjukkan kepatuhan terhadap penerapan standar dan pedoman keperawatan.', 'PRAPK001', 'false', 'true'),
('E0019', 'Menunjukkan tanggung jawab terhadap penerapan asuhan keperawatan sesuai kewenangannya.', 'PRAPK001', 'false', 'true'),
('E0020', 'Menunjukkan sikap kerja yang efektif dan efisien dalam pengelolaan klien.', 'PRAPK001', 'false', 'true'),
('E0021', 'Menunjukkan sikap saling percaya dan menghargai antara anggota tim dalam pengelolaan asuhan keperawatan.', 'PRAPK001', 'false', 'true'),
('E0022', 'Melakukan tindakan-tindakan untuk mencegah cedera pada Klien', 'PRAPK001', 'false', 'true'),
('E0023', 'Melakukan  alih baring dan Range Of Motion (ROM)', 'PRAPK001', 'false', 'true'),
('E0024', 'Melakukan ambulasi ', 'PRAPK001', 'false', 'true'),
('E0025', 'Mengelola terapi oksigen aliran rendah (nasal canule, masker sederhana, masker rebreathing, masker non re breathing)', 'PRAPK001', 'false', 'true'),
('E0026', 'Mengelola terapi nebulizer', 'PRAPK001', 'false', 'true'),
('E0027', 'Melakukan suction pada pasien tanpa alat bantu nafas.', 'PRAPK001', 'false', 'true'),
('E0028', 'Menghitung balance cairan', 'PRAPK001', 'false', 'true'),
('E0029', 'Memasang dan melepas Intra Veneus line chateter tanpa penyulit', 'PRAPK001', 'false', 'true'),
('E0030', 'Memasang dan melepas urine chatheter tanpa penyulit', 'PRAPK001', 'false', 'true'),
('E0031', 'Mengukur tanda-tanda vital', 'PRAPK001', 'false', 'true'),
('E0032', 'Melakukan perekaman EKG', 'PRAPK001', 'false', 'true'),
('E0033', 'Melakukan  pemeriksaan kesadaran kualitatif dan kuantitatif', 'PRAPK001', 'false', 'true'),
('E0034', 'Mengkaji tanda kegawat daruratan (kriteria Bellomo)', 'PRAPK001', 'false', 'true'),
('E0035', 'Melakukan pemeriksaan gula darah dengan glukosa stik', 'PRAPK001', 'false', 'true'),
('E0036', 'Melakukan pengambilan sampel laborat (darah vena, urine, feses)', 'PRAPK001', 'false', 'true'),
('E0037', 'Melakukan perawatan luka bersih', 'PRAPK001', 'false', 'true'),
('E0038', 'Memberikan obat melalui oral, intra  vena, intra muscular, sub cutan, intra cutan, sub lingual, suppositoria, topikal', 'PRAPK001', 'false', 'true'),
('E0039', 'Memberikan produk darah ', 'PRAPK001', 'false', 'true'),
('E0040', 'Melakukan bantuan hidup dasar', 'PRAPK001', 'false', 'true'),
('E0041', 'Melakukan manajemen nyeri', 'PRAPK001', 'false', 'true'),
('E0042', 'Memenuhi kebutuhan istirahat dan tidur', 'PRAPK001', 'false', 'true'),
('E0043', 'Memenuhi kebutuhan thermoregulasi', 'PRAPK001', 'false', 'true'),
('E0044', 'Memenuhi kebutuhan spiritual', 'PRAPK001', 'false', 'true'),
('E0045', 'Memenuhi  kebutuhan personal hygiene', 'PRAPK001', 'false', 'true'),
('E0046', 'Membantu eliminasi BAB dan BAK', 'PRAPK001', 'false', 'true'),
('E0047', 'Memberikan nutrisi per oral', 'PRAPK001', 'false', 'true'),
('E0048', 'Memberikan nutrisi enteral  (Oro Gastric Tube (OGT), Naso Gastric Tube(NGT))', 'PRAPK001', 'false', 'true'),
('E0049', 'Memasang dan Melepas Oro Gastric Tube (OGT), Naso Gastric Tube(NGT)) tanpa penyulit', 'PRAPK001', 'false', 'true'),
('E0050', 'Mengelola pasien dengan restrain', 'PRAPK001', 'false', 'true'),
('E0051', 'Menyiapkan pemeriksaan urine esbach', 'PRAPK001', 'false', 'true'),
('E0052', 'Memberikan terapi titrasi', 'PRAPK001', 'false', 'true');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_casemix`
--
ALTER TABLE `file_casemix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_farmasi`
--
ALTER TABLE `file_farmasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_lookbook`
--
ALTER TABLE `jenis_lookbook`
  ADD PRIMARY KEY (`kd_jesni_lb`);

--
-- Indexes for table `jenis_lookbook_kegiatan_lain`
--
ALTER TABLE `jenis_lookbook_kegiatan_lain`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `list_dokter`
--
ALTER TABLE `list_dokter`
  ADD PRIMARY KEY (`kd_dokter`),
  ADD KEY `list_dokter_kd_loket_foreign` (`kd_loket`);

--
-- Indexes for table `logbook_keperawatan`
--
ALTER TABLE `logbook_keperawatan`
  ADD PRIMARY KEY (`id_logbook`);

--
-- Indexes for table `logbook_keperawatan_kegiatanlain`
--
ALTER TABLE `logbook_keperawatan_kegiatanlain`
  ADD PRIMARY KEY (`id_kegiatan_keperawatanlain`);

--
-- Indexes for table `logbook_keperawatan_kewenangankhusus`
--
ALTER TABLE `logbook_keperawatan_kewenangankhusus`
  ADD PRIMARY KEY (`id_kewenangankhusus`);

--
-- Indexes for table `log_antrian_loket`
--
ALTER TABLE `log_antrian_loket`
  ADD PRIMARY KEY (`no_rawat`),
  ADD KEY `log_antrian_loket_kd_loket_foreign` (`kd_loket`);

--
-- Indexes for table `loket`
--
ALTER TABLE `loket`
  ADD PRIMARY KEY (`kd_loket`),
  ADD KEY `loket_kd_pendaftaran_foreign` (`kd_pendaftaran`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`kd_pendaftaran`);

--
-- Indexes for table `rsbw_kewenangankhusus_keperawatan`
--
ALTER TABLE `rsbw_kewenangankhusus_keperawatan`
  ADD PRIMARY KEY (`kd_kewenangan`),
  ADD KEY `kd_jesni_lb_2` (`kd_jesni_lb`);

--
-- Indexes for table `rsbw_nm_kegiatan_keperawatan`
--
ALTER TABLE `rsbw_nm_kegiatan_keperawatan`
  ADD PRIMARY KEY (`kd_kegiatan`),
  ADD KEY `kd_jesni_lb` (`kd_jesni_lb`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file_casemix`
--
ALTER TABLE `file_casemix`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_farmasi`
--
ALTER TABLE `file_farmasi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logbook_keperawatan`
--
ALTER TABLE `logbook_keperawatan`
  MODIFY `id_logbook` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `logbook_keperawatan_kegiatanlain`
--
ALTER TABLE `logbook_keperawatan_kegiatanlain`
  MODIFY `id_kegiatan_keperawatanlain` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logbook_keperawatan_kewenangankhusus`
--
ALTER TABLE `logbook_keperawatan_kewenangankhusus`
  MODIFY `id_kewenangankhusus` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `list_dokter`
--
ALTER TABLE `list_dokter`
  ADD CONSTRAINT `list_dokter_kd_loket_foreign` FOREIGN KEY (`kd_loket`) REFERENCES `loket` (`kd_loket`) ON DELETE CASCADE;

--
-- Constraints for table `log_antrian_loket`
--
ALTER TABLE `log_antrian_loket`
  ADD CONSTRAINT `log_antrian_loket_kd_loket_foreign` FOREIGN KEY (`kd_loket`) REFERENCES `loket` (`kd_loket`) ON DELETE CASCADE;

--
-- Constraints for table `loket`
--
ALTER TABLE `loket`
  ADD CONSTRAINT `loket_kd_pendaftaran_foreign` FOREIGN KEY (`kd_pendaftaran`) REFERENCES `pendaftaran` (`kd_pendaftaran`) ON DELETE CASCADE;

--
-- Constraints for table `rsbw_kewenangankhusus_keperawatan`
--
ALTER TABLE `rsbw_kewenangankhusus_keperawatan`
  ADD CONSTRAINT `rsbw_kewenangankhusus_keperawatan_ibfk_1` FOREIGN KEY (`kd_jesni_lb`) REFERENCES `jenis_lookbook` (`kd_jesni_lb`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rsbw_nm_kegiatan_keperawatan`
--
ALTER TABLE `rsbw_nm_kegiatan_keperawatan`
  ADD CONSTRAINT `rsbw_nm_kegiatan_keperawatan_ibfk_1` FOREIGN KEY (`kd_jesni_lb`) REFERENCES `jenis_lookbook` (`kd_jesni_lb`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

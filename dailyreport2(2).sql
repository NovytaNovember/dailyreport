-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 03:26 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dailyreport2`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_today`
--

CREATE TABLE `activity_today` (
  `id_activity_today` int(11) NOT NULL,
  `id_cpp` int(11) DEFAULT NULL,
  `no` int(11) NOT NULL,
  `nama_activity_today` varchar(255) NOT NULL,
  `status_activity_today` varchar(20) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_today`
--

INSERT INTO `activity_today` (`id_activity_today`, `id_cpp`, `no`, `nama_activity_today`, `status_activity_today`, `tanggal`) VALUES
(1349, 986, 1, 'Tool Box Meeting', 'Done', '2024-12-31'),
(1350, 986, 2, 'Run Plant Crushing ', 'Done', '2024-12-31'),
(1351, 986, 3, 'Greas Feeder & Sizer', 'Done', '2024-12-31'),
(1352, 986, 4, 'Check Plant Crushing', 'Done', '2024-12-31'),
(1353, 986, 5, 'Pengisian Fuel LV & Alat Berat', 'Done', '2024-12-31'),
(1354, 986, 6, 'Check Tram Magnet dan Metal Detector cv11', 'Done', '2024-12-31'),
(1355, 986, 7, 'Check Drump Feeder Breaker', 'Done', '2024-12-31'),
(1356, 986, 8, 'Continue Loading BG. MISHA', 'Complete', '2024-12-31'),
(1357, 986, 9, 'Tidak ada data', 'Belum selesai', '2024-12-31'),
(1358, 986, 10, 'Tidak ada data', 'Belum selesai', '2024-12-31'),
(1359, 986, 11, 'Tidak ada data', 'Belum selesai', '2024-12-31'),
(1360, 986, 12, 'Tidak ada data', 'Belum selesai', '2024-12-31'),
(1361, 986, 13, 'Tidak ada data', 'Belum selesai', '2024-12-31'),
(1362, 986, 14, 'Tidak ada data', 'Belum selesai', '2024-12-31'),
(1363, 986, 15, 'Tidak ada data', 'Belum selesai', '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `chemical_pic130_white_container`
--

CREATE TABLE `chemical_pic130_white_container` (
  `id_chemical_pic130_white_container` int(11) NOT NULL,
  `id_cpp` int(11) DEFAULT NULL,
  `based_awal_shift` float DEFAULT NULL,
  `based_akhir_shift` float DEFAULT NULL,
  `total_consumption` float DEFAULT NULL,
  `consumption` float DEFAULT NULL,
  `use_awal_shift` float DEFAULT NULL,
  `use_akhir_shift` float DEFAULT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chemical_pic130_white_container`
--

INSERT INTO `chemical_pic130_white_container` (`id_chemical_pic130_white_container`, `id_cpp`, `based_awal_shift`, `based_akhir_shift`, `total_consumption`, `consumption`, `use_awal_shift`, `use_akhir_shift`, `tanggal`) VALUES
(125, 986, 0, 0, 0, 0, 0, 0, '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `chemical_startron_grey_container`
--

CREATE TABLE `chemical_startron_grey_container` (
  `id_chemical_startron_grey_container` int(11) NOT NULL,
  `id_cpp` int(11) DEFAULT NULL,
  `based_awal_shift` float DEFAULT NULL,
  `based_akhir_shift` float DEFAULT NULL,
  `use_awal_shift` float DEFAULT NULL,
  `use_akhir_shift` float DEFAULT NULL,
  `total_consumption` float DEFAULT NULL,
  `consumption` float DEFAULT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chemical_startron_grey_container`
--

INSERT INTO `chemical_startron_grey_container` (`id_chemical_startron_grey_container`, `id_cpp`, `based_awal_shift`, `based_akhir_shift`, `use_awal_shift`, `use_akhir_shift`, `total_consumption`, `consumption`, `tanggal`) VALUES
(138, 986, 194, 193, 25802, 25669, 1, 0, '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `cm`
--

CREATE TABLE `cm` (
  `id_cm` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `no_cm` int(11) NOT NULL,
  `nama_cm` varchar(255) NOT NULL,
  `status_cm` varchar(20) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cm`
--

INSERT INTO `cm` (`id_cm`, `id_cpp`, `no_cm`, `nama_cm`, `status_cm`, `tanggal`) VALUES
(748, 986, 1, 'Cek Angka/ Settingan Beltscale olc 1', 'Done', '2024-12-31'),
(749, 986, 2, 'Mematikan api atau bara area stockpile dengan Exca LC29', 'Done', '2024-12-31'),
(750, 986, 3, 'Tidak ada data', 'Done', '2024-12-31'),
(751, 986, 4, 'Tidak ada data', 'Done', '2024-12-31'),
(752, 986, 5, 'Tidak ada data', 'Done', '2024-12-31'),
(753, 986, 6, 'Tidak ada data', 'Done', '2024-12-31'),
(754, 986, 7, 'Tidak ada data', 'Done', '2024-12-31'),
(755, 986, 8, 'Tidak ada data', 'Done', '2024-12-31'),
(756, 986, 9, 'Tidak ada data', 'Done', '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `cpp_data`
--

CREATE TABLE `cpp_data` (
  `id_cpp` int(11) NOT NULL,
  `nama_cpp` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `upload_date` date DEFAULT NULL,
  `actual_upload_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cpp_data`
--

INSERT INTO `cpp_data` (`id_cpp`, `nama_cpp`, `deskripsi`, `upload_date`, `actual_upload_time`) VALUES
(986, 'Ubah File CPP - 17 Oktober  2024 _14.xlsx', NULL, '2024-12-31', '2024-12-31 22:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `cpp_runtime`
--

CREATE TABLE `cpp_runtime` (
  `id_cpp_runtime` int(11) NOT NULL,
  `id_cpp` int(11) DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `run_time_from` time DEFAULT NULL,
  `run_time_to` time DEFAULT NULL,
  `duration_minutes_runtime` int(11) DEFAULT NULL,
  `delay_time_from` time DEFAULT NULL,
  `delay_time_to` time DEFAULT NULL,
  `duration_minutes_delay` int(11) DEFAULT NULL,
  `type_delay` text DEFAULT NULL,
  `total_delay_time` int(11) DEFAULT 0,
  `total_run_time` int(11) DEFAULT 0,
  `total_type_delayed` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cpp_runtime`
--

INSERT INTO `cpp_runtime` (`id_cpp_runtime`, `id_cpp`, `explanation`, `rate`, `run_time_from`, `run_time_to`, `duration_minutes_runtime`, `delay_time_from`, `delay_time_to`, `duration_minutes_delay`, `type_delay`, `total_delay_time`, `total_run_time`, `total_type_delayed`) VALUES
(12018, 986, 'Stacking SP 4 LS-Ts= 0.25-Ash= 3.6 = 4645', 0, '19:00:00', '00:00:00', 300, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12019, 986, 'Stop, Meal Break.Rain ( Hujan )', 0, '00:00:00', '00:00:00', 0, '00:00:00', '05:00:00', 300, 'Rain Waiting Slippery ( Hujan )', 360, 360, 720),
(12020, 986, 'Stacking SP 4 LS-Ts= 0.25-Ash= 3.6 = 4800 MT', 0, '05:00:00', '06:00:00', 60, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12021, 986, 'Stop, Waiting Supply, Over shif', 0, '00:00:00', '00:00:00', 0, '06:00:00', '07:00:00', 60, 'Tidak ada data', 360, 360, 720),
(12022, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12023, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12024, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12025, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12026, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12027, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12028, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12029, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12030, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12031, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12032, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12033, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720),
(12034, 986, 'Tidak ada data', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, 'Tidak ada data', 360, 360, 720);

-- --------------------------------------------------------

--
-- Table structure for table `daily_stock_cpp`
--

CREATE TABLE `daily_stock_cpp` (
  `id` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `awal_shift` float NOT NULL,
  `akhir_shift` float DEFAULT NULL,
  `supply` float NOT NULL,
  `total_consumption` float NOT NULL,
  `awal_shift_flow` float NOT NULL,
  `akhir_shift_flow` float NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daily_stock_cpp`
--

INSERT INTO `daily_stock_cpp` (`id`, `id_cpp`, `awal_shift`, `akhir_shift`, `supply`, `total_consumption`, `awal_shift_flow`, `akhir_shift_flow`, `tanggal`) VALUES
(421, 986, 3796, 3796, 0, 0, 162279, 162279, '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `daily_tank_cap`
--

CREATE TABLE `daily_tank_cap` (
  `id_daily_tank_cap` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `awal_shift_based` float DEFAULT NULL,
  `akhir_shift_based` float DEFAULT NULL,
  `useoffuel_awal_shift` float DEFAULT NULL,
  `useoffuel_akhir_shift` float DEFAULT NULL,
  `flow_meter_outlet_awal_shift` float DEFAULT NULL,
  `flow_meter_outlet_akhir_shift` float DEFAULT NULL,
  `total_consumption` float DEFAULT NULL,
  `consumption` float DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daily_tank_cap`
--

INSERT INTO `daily_tank_cap` (`id_daily_tank_cap`, `id_cpp`, `tanggal`, `awal_shift_based`, `akhir_shift_based`, `useoffuel_awal_shift`, `useoffuel_akhir_shift`, `flow_meter_outlet_awal_shift`, `flow_meter_outlet_akhir_shift`, `total_consumption`, `consumption`, `total`) VALUES
(253, 986, '2024-12-07', 29.2, 29.2, 29223, 29223, 64548, 64548, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hauling_to_pltu`
--

CREATE TABLE `hauling_to_pltu` (
  `id_hauling_to_pltu` int(11) NOT NULL,
  `id_cpp` int(11) DEFAULT NULL,
  `no` int(11) DEFAULT NULL,
  `hauling_to_pltu_explanation` varchar(255) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `time_from` time DEFAULT NULL,
  `time_to` time DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `total_time` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hauling_to_pltu`
--

INSERT INTO `hauling_to_pltu` (`id_hauling_to_pltu`, `id_cpp`, `no`, `hauling_to_pltu_explanation`, `rate`, `time_from`, `time_to`, `duration_minutes`, `total_time`, `tanggal`) VALUES
(205, 986, 1, 'WL 28 SP 3 Depan SP 2 Belakang 19:35', NULL, '19:10:00', '00:10:00', 300, 300, '2024-12-31'),
(206, 986, 2, NULL, NULL, '01:10:00', '04:20:00', 190, 490, '2024-12-31'),
(207, 986, 3, 'WL 33 SP 7-6 Depan', NULL, '19:55:00', '00:10:00', 255, 745, '2024-12-31'),
(208, 986, 4, NULL, NULL, '01:10:00', '04:20:00', 190, 935, '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `olc_runtime`
--

CREATE TABLE `olc_runtime` (
  `id_olc_runtime` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `explanation` text DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `run_time_from` time DEFAULT NULL,
  `run_time_to` time DEFAULT NULL,
  `duration_minutes_runtime` int(11) DEFAULT NULL,
  `delay_time_from` time DEFAULT NULL,
  `delay_time_to` time DEFAULT NULL,
  `duration_minutes_delay` int(11) DEFAULT NULL,
  `type_delay` text DEFAULT NULL,
  `total_run_time` int(11) NOT NULL DEFAULT 0,
  `total_delay_time` int(11) NOT NULL DEFAULT 0,
  `total_type_delayed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `olc_runtime`
--

INSERT INTO `olc_runtime` (`id_olc_runtime`, `id_cpp`, `explanation`, `rate`, `run_time_from`, `run_time_to`, `duration_minutes_runtime`, `delay_time_from`, `delay_time_to`, `duration_minutes_delay`, `type_delay`, `total_run_time`, `total_delay_time`, `total_type_delayed`) VALUES
(7974, 986, 'Stop,waiting Supplay alat Dorongan ', 0, NULL, NULL, 0, '19:00:00', '19:25:00', 25, '', 0, 0, 0),
(7975, 986, 'Continue Loding BG.MISHA RV2 Bypass', 1700, '19:25:00', '20:05:00', 40, NULL, NULL, 0, '', 0, 0, 0),
(7976, 986, 'Loading BG.MISHA RV2 Bypass=1200 + RV3 LC 29 =500', 1700, '20:05:00', '21:55:00', 110, NULL, NULL, 0, '', 0, 0, 0),
(7977, 986, 'Loading BG.MISHA RV2 Bypass 60 % + RV3 LC 29 + Dozer 40%', 1700, '21:55:00', '22:35:00', 40, NULL, NULL, 0, 'Dozer Breakdown 22:35 ', 0, 0, 0),
(7978, 986, 'Loading BG.MISHA RV2 Bypass + RV3 LC 29 =  500 ', 1500, '22:35:00', '23:05:00', 30, NULL, NULL, 0, '', 0, 0, 0),
(7979, 986, 'Close Surgebin Dfrat Check OLC= 9500 MT Cv13= 4320 MT', 0, '23:05:00', '00:05:00', 60, NULL, NULL, 0, '', 0, 0, 0),
(7980, 986, 'Nambah 300 MT', 0, '00:05:00', '00:20:00', 15, NULL, NULL, 0, '', 0, 0, 0),
(7981, 986, 'Close Surgebin Dfrat Check OLC= 9800 MT Cv13= 4320 MT', 0, '00:20:00', '00:45:00', 25, NULL, NULL, 0, '', 0, 0, 0),
(7982, 986, 'Loading Complete', 0, NULL, NULL, 0, '00:45:00', '07:00:00', 375, '', 0, 0, 0),
(7983, 986, '', 0, NULL, NULL, 0, NULL, NULL, 0, '', 0, 0, 0),
(7984, 986, '', 0, NULL, NULL, 0, NULL, NULL, 0, '', 0, 0, 0),
(7985, 986, '', 0, NULL, NULL, 0, NULL, NULL, 0, '', 0, 0, 0),
(7986, 986, '', 0, NULL, NULL, 0, NULL, NULL, 0, '', 0, 0, 0),
(7987, 986, '', 0, NULL, NULL, 0, NULL, NULL, 0, '', 0, 0, 0),
(7988, 986, '', 0, NULL, NULL, 0, NULL, NULL, 0, '', 0, 0, 0),
(7989, 986, '', 0, NULL, NULL, 0, NULL, NULL, 0, '', 0, 0, 0),
(7990, 986, '', 0, NULL, NULL, 0, NULL, NULL, 0, '', 0, 0, 0),
(7991, 986, '', 0, NULL, NULL, 0, NULL, NULL, 0, '', 0, 0, 0),
(7992, 986, 'Total', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 320, 400, 720);

-- --------------------------------------------------------

--
-- Table structure for table `pm`
--

CREATE TABLE `pm` (
  `id_pm` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `no_pm` int(11) NOT NULL,
  `nama_pm` varchar(255) NOT NULL,
  `status_pm` varchar(20) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pm`
--

INSERT INTO `pm` (`id_pm`, `id_cpp`, `no_pm`, `nama_pm`, `status_pm`, `tanggal`) VALUES
(1009, 986, 1, 'CA043480 1M PENEMPATAN RACUN TIKUS DI LUAR MCC4', 'Done', '2024-12-31'),
(1010, 986, 2, 'CA043463 MONTHLY INSPECTION ELECTRIC MOTOR CV13', 'Done', '2024-12-31'),
(1011, 986, 3, 'CA043478 WEEKLY TEMPERATURE CHECK CV13 CPP', 'Done', '2024-12-31'),
(1012, 986, 4, 'CA043490 2 WEEKLY PM-ACV11 LIGHTING SYSTEM INSP', 'Done', '2024-12-31'),
(1013, 986, 5, 'CA043488 WEEKLY TEMPERATURE CHECK SIZER CPP', 'Done', '2024-12-31'),
(1014, 986, 6, 'CA043479 2 WEEKLY INSP LIGHTING SYSTEM AFB01', 'Done', '2024-12-31'),
(1015, 986, 7, 'Tidak ada data', 'Done', '2024-12-31'),
(1016, 986, 8, 'Tidak ada data', 'Done', '2024-12-31'),
(1017, 986, 9, 'Tidak ada data', 'Done', '2024-12-31'),
(1018, 986, 10, 'Tidak ada data', 'Belum selesai', '2024-12-31'),
(1019, 986, 11, 'Tidak ada data', 'Belum selesai', '2024-12-31'),
(1020, 986, 12, 'Tidak ada data', 'Belum selesai', '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `production_today`
--

CREATE TABLE `production_today` (
  `id_production_today` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `production_today` varchar(50) DEFAULT NULL,
  `awal` double DEFAULT NULL,
  `akhir` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `production_today`
--

INSERT INTO `production_today` (`id_production_today`, `id_cpp`, `production_today`, `awal`, `akhir`, `total`, `tanggal`) VALUES
(2517, 986, 'Belt Scale CV 11', 17744924, 17749834, 4910, '2024-12-07'),
(2518, 986, 'Belt Scale CV 13', 1590312, 1594632, 4320, '2024-12-07'),
(2519, 986, 'Belt Scale OLC 1', 6517430, 6522590, 5160, '2024-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `total_ritase`
--

CREATE TABLE `total_ritase` (
  `id_ritase` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `ritase_type` varchar(255) DEFAULT NULL,
  `total_ritase` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `total_ritase`
--

INSERT INTO `total_ritase` (`id_ritase`, `id_cpp`, `ritase_type`, `total_ritase`, `tanggal`) VALUES
(2959, 986, 'Total ritase Tambang ke Hopper', 187, '2024-12-07'),
(2960, 986, 'Total ritase keluar stockpile CPP', 120, '2024-12-07'),
(2961, 986, 'Total ritase Tambang ke ROM', 1, '2024-12-07'),
(2962, 986, 'Total rehandling ROM to Hopper', 0, '2024-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `use_of_fuel_genset04`
--

CREATE TABLE `use_of_fuel_genset04` (
  `id_use_of_fuel_genset04` int(11) NOT NULL,
  `id_cpp` int(11) DEFAULT NULL,
  `input_awal` float DEFAULT NULL,
  `output_awal` float DEFAULT NULL,
  `kwh_awal` float DEFAULT NULL,
  `kvrah_awal` float DEFAULT NULL,
  `run_hour_awal` float DEFAULT NULL,
  `input_akhir` float DEFAULT NULL,
  `output_akhir` float DEFAULT NULL,
  `kwh_akhir` float DEFAULT NULL,
  `kvrah_akhir` float DEFAULT NULL,
  `run_hour_akhir` float DEFAULT NULL,
  `total_input_consumption` float DEFAULT NULL,
  `total_output_consumption` float DEFAULT NULL,
  `total_fuel_consumption` float DEFAULT NULL,
  `total_kwh` float DEFAULT NULL,
  `total_kvarh` float DEFAULT NULL,
  `total_run_hour` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `use_of_fuel_genset04`
--

INSERT INTO `use_of_fuel_genset04` (`id_use_of_fuel_genset04`, `id_cpp`, `input_awal`, `output_awal`, `kwh_awal`, `kvrah_awal`, `run_hour_awal`, `input_akhir`, `output_akhir`, `kwh_akhir`, `kvrah_akhir`, `run_hour_akhir`, `total_input_consumption`, `total_output_consumption`, `total_fuel_consumption`, `total_kwh`, `total_kvarh`, `total_run_hour`) VALUES
(120, 986, 6557920, 5320650, 1801, 1382, 7814.2, 6557920, 5320650, 1801, 1382, 7814.2, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `use_of_fuel_genset05`
--

CREATE TABLE `use_of_fuel_genset05` (
  `id_use_of_fuel_genset05` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `input_awal` float DEFAULT NULL,
  `output_awal` float DEFAULT NULL,
  `kwh_awal` float DEFAULT NULL,
  `kvrah_awal` float DEFAULT NULL,
  `run_hour_awal` float DEFAULT NULL,
  `input_akhir` float DEFAULT NULL,
  `output_akhir` float DEFAULT NULL,
  `kwh_akhir` float DEFAULT NULL,
  `kvrah_akhir` float DEFAULT NULL,
  `run_hour_akhir` float DEFAULT NULL,
  `total_input_consumption` float DEFAULT NULL,
  `total_output_consumption` float DEFAULT NULL,
  `total_fuel_consumption` float DEFAULT NULL,
  `total_kwh` float DEFAULT NULL,
  `total_kvarh` float DEFAULT NULL,
  `total_run_hour` float DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `use_of_fuel_genset05`
--

INSERT INTO `use_of_fuel_genset05` (`id_use_of_fuel_genset05`, `id_cpp`, `input_awal`, `output_awal`, `kwh_awal`, `kvrah_awal`, `run_hour_awal`, `input_akhir`, `output_akhir`, `kwh_akhir`, `kvrah_akhir`, `run_hour_akhir`, `total_input_consumption`, `total_output_consumption`, `total_fuel_consumption`, `total_kwh`, `total_kvarh`, `total_run_hour`, `tanggal`) VALUES
(105, 986, 7767190, 6319970, 4299000, 2728380, 8977.4, 7767190, 6319970, 4299000, 2728380, 8977.4, 0, 0, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `use_of_heavy_vehicles`
--

CREATE TABLE `use_of_heavy_vehicles` (
  `id_use` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `company` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `start_hm` double DEFAULT NULL,
  `stop_hm` double DEFAULT NULL,
  `operator` varchar(50) DEFAULT NULL,
  `total_hm` double DEFAULT NULL,
  `fuel` double DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `use_of_heavy_vehicles`
--

INSERT INTO `use_of_heavy_vehicles` (`id_use`, `id_cpp`, `company`, `unit`, `start_hm`, `stop_hm`, `operator`, `total_hm`, `fuel`, `remark`, `tanggal`, `total`) VALUES
(17287, 986, 'Company', 'Unit', 0, 0, NULL, 0, 0, 'Remark', '2024-12-07', 0),
(17288, 986, 'WM', 'WL 33', 19330.5, 19337.9, NULL, 7.4000000000015, 0, 'PLTU 19:55', '2024-12-07', 0),
(17289, 986, 'Tidak ada data', 'WL 28', 6922.7, 6931.8, NULL, 9.1000000000004, 0, 'PLTU 19:05', '2024-12-07', 0),
(17290, 986, 'Tidak ada data', 'WL 31', 3453.1, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17291, 986, 'Tidak ada data', 'DZ 20', 8165.8, 8166.9, NULL, 1.0999999999995, 0, 'Support Loading 21:50', '2024-12-07', 0),
(17292, 986, 'Tidak ada data', 'DZ 30 ', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17293, 986, 'Tidak ada data', 'LC 24 ', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17294, 986, 'Tidak ada data', 'LC 26', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17295, 986, 'Tidak ada data', 'LC 29', 14452.1, 14457.7, NULL, 5.6000000000004, 0, 'Support Loading SP 6', '2024-12-07', 0),
(17296, 986, 'Tidak ada data', 'LC 94 ', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17297, 986, 'Tidak ada data', 'TL 20', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17298, 986, 'Tidak ada data', 'WM 01', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17299, 986, 'Tidak ada data', 'WM 02', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17300, 986, 'Tidak ada data', 'WM 06', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17301, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17302, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17303, 986, 'Company', 'Unit', 0, 0, NULL, 0, 0, 'Remark', '2024-12-07', 0),
(17304, 986, 'DT', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17305, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17306, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17307, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17308, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17309, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17310, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17311, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17312, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17313, 986, 'AI', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17314, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17315, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17316, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17317, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0),
(17318, 986, 'Tidak ada data', 'Tidak ada data', 0, 0, NULL, 0, 0, 'Tidak ada data', '2024-12-07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `use_of_kwh_pln_to_cpp`
--

CREATE TABLE `use_of_kwh_pln_to_cpp` (
  `id_use_of_kwh_pln_to_cpp` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `awal` float NOT NULL,
  `akhir` float NOT NULL,
  `total_use` float NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `use_of_kwh_pln_to_cpp`
--

INSERT INTO `use_of_kwh_pln_to_cpp` (`id_use_of_kwh_pln_to_cpp`, `id_cpp`, `awal`, `akhir`, `total_use`, `tanggal`) VALUES
(123, 986, 6.7813, 6.7851, 0.0038, '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `water_level_on_recervoir_tank`
--

CREATE TABLE `water_level_on_recervoir_tank` (
  `id_water_level_on_recervoir_tank` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `awal_shift` float NOT NULL,
  `akhir_shift` float NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `water_level_on_recervoir_tank`
--

INSERT INTO `water_level_on_recervoir_tank` (`id_water_level_on_recervoir_tank`, `id_cpp`, `awal_shift`, `akhir_shift`, `tanggal`) VALUES
(159, 986, 80, 80, '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `water_level_on_settling_pond`
--

CREATE TABLE `water_level_on_settling_pond` (
  `id_water_level_on_settling_pond` int(11) NOT NULL,
  `id_cpp` int(11) NOT NULL,
  `based_awal_shift` float NOT NULL,
  `based_akhir_shift` float NOT NULL,
  `use_of_water_awal_shift` float NOT NULL,
  `use_of_water_akhir_shift` float NOT NULL,
  `total_consumption` float NOT NULL,
  `consumption` float NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `water_level_on_settling_pond`
--

INSERT INTO `water_level_on_settling_pond` (`id_water_level_on_settling_pond`, `id_cpp`, `based_awal_shift`, `based_akhir_shift`, `use_of_water_awal_shift`, `use_of_water_akhir_shift`, `total_consumption`, `consumption`, `tanggal`) VALUES
(234, 986, 80, 80, 1116180, 1116180, 0, 0, '2024-12-31'),
(235, 986, 80, 80, 1116180, 1116180, 0, 0, '2024-12-07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_today`
--
ALTER TABLE `activity_today`
  ADD PRIMARY KEY (`id_activity_today`),
  ADD KEY `activity_today_ibfk_1` (`id_cpp`);

--
-- Indexes for table `chemical_pic130_white_container`
--
ALTER TABLE `chemical_pic130_white_container`
  ADD PRIMARY KEY (`id_chemical_pic130_white_container`),
  ADD KEY `fk_cpp` (`id_cpp`);

--
-- Indexes for table `chemical_startron_grey_container`
--
ALTER TABLE `chemical_startron_grey_container`
  ADD PRIMARY KEY (`id_chemical_startron_grey_container`),
  ADD KEY `chemical_startron_grey_container_ibfk_1` (`id_cpp`);

--
-- Indexes for table `cm`
--
ALTER TABLE `cm`
  ADD PRIMARY KEY (`id_cm`),
  ADD KEY `idx_id_cpp` (`id_cpp`);

--
-- Indexes for table `cpp_data`
--
ALTER TABLE `cpp_data`
  ADD PRIMARY KEY (`id_cpp`);

--
-- Indexes for table `cpp_runtime`
--
ALTER TABLE `cpp_runtime`
  ADD PRIMARY KEY (`id_cpp_runtime`),
  ADD KEY `cpp_runtime_ibfk_1` (`id_cpp`);

--
-- Indexes for table `daily_stock_cpp`
--
ALTER TABLE `daily_stock_cpp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cpp` (`id_cpp`);

--
-- Indexes for table `daily_tank_cap`
--
ALTER TABLE `daily_tank_cap`
  ADD PRIMARY KEY (`id_daily_tank_cap`),
  ADD KEY `id_cpp` (`id_cpp`);

--
-- Indexes for table `hauling_to_pltu`
--
ALTER TABLE `hauling_to_pltu`
  ADD PRIMARY KEY (`id_hauling_to_pltu`),
  ADD KEY `id_cpp` (`id_cpp`);

--
-- Indexes for table `olc_runtime`
--
ALTER TABLE `olc_runtime`
  ADD PRIMARY KEY (`id_olc_runtime`),
  ADD KEY `fk_id_cpp` (`id_cpp`);

--
-- Indexes for table `pm`
--
ALTER TABLE `pm`
  ADD PRIMARY KEY (`id_pm`),
  ADD KEY `pm_ibfk_1` (`id_cpp`);

--
-- Indexes for table `production_today`
--
ALTER TABLE `production_today`
  ADD PRIMARY KEY (`id_production_today`),
  ADD KEY `fk_id_cpp` (`id_cpp`);

--
-- Indexes for table `total_ritase`
--
ALTER TABLE `total_ritase`
  ADD PRIMARY KEY (`id_ritase`),
  ADD KEY `fk_total_ritase_id_cpp` (`id_cpp`);

--
-- Indexes for table `use_of_fuel_genset04`
--
ALTER TABLE `use_of_fuel_genset04`
  ADD PRIMARY KEY (`id_use_of_fuel_genset04`),
  ADD KEY `use_of_fuel_genset04_ibfk_1` (`id_cpp`);

--
-- Indexes for table `use_of_fuel_genset05`
--
ALTER TABLE `use_of_fuel_genset05`
  ADD PRIMARY KEY (`id_use_of_fuel_genset05`),
  ADD KEY `use_of_fuel_genset05_ibfk_1` (`id_cpp`);

--
-- Indexes for table `use_of_heavy_vehicles`
--
ALTER TABLE `use_of_heavy_vehicles`
  ADD PRIMARY KEY (`id_use`),
  ADD KEY `fk_use_of_heavy_vehicles_id_cpp` (`id_cpp`);

--
-- Indexes for table `use_of_kwh_pln_to_cpp`
--
ALTER TABLE `use_of_kwh_pln_to_cpp`
  ADD PRIMARY KEY (`id_use_of_kwh_pln_to_cpp`),
  ADD KEY `use_of_kwh_pln_to_cpp_ibfk_1` (`id_cpp`);

--
-- Indexes for table `water_level_on_recervoir_tank`
--
ALTER TABLE `water_level_on_recervoir_tank`
  ADD PRIMARY KEY (`id_water_level_on_recervoir_tank`),
  ADD KEY `water_level_on_recervoir_tank_ibfk_1` (`id_cpp`);

--
-- Indexes for table `water_level_on_settling_pond`
--
ALTER TABLE `water_level_on_settling_pond`
  ADD PRIMARY KEY (`id_water_level_on_settling_pond`),
  ADD KEY `water_level_on_settling_pond_ibfk_1` (`id_cpp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_today`
--
ALTER TABLE `activity_today`
  MODIFY `id_activity_today` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1364;

--
-- AUTO_INCREMENT for table `chemical_pic130_white_container`
--
ALTER TABLE `chemical_pic130_white_container`
  MODIFY `id_chemical_pic130_white_container` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `chemical_startron_grey_container`
--
ALTER TABLE `chemical_startron_grey_container`
  MODIFY `id_chemical_startron_grey_container` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `cm`
--
ALTER TABLE `cm`
  MODIFY `id_cm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=757;

--
-- AUTO_INCREMENT for table `cpp_data`
--
ALTER TABLE `cpp_data`
  MODIFY `id_cpp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=987;

--
-- AUTO_INCREMENT for table `cpp_runtime`
--
ALTER TABLE `cpp_runtime`
  MODIFY `id_cpp_runtime` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12035;

--
-- AUTO_INCREMENT for table `daily_stock_cpp`
--
ALTER TABLE `daily_stock_cpp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;

--
-- AUTO_INCREMENT for table `daily_tank_cap`
--
ALTER TABLE `daily_tank_cap`
  MODIFY `id_daily_tank_cap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `hauling_to_pltu`
--
ALTER TABLE `hauling_to_pltu`
  MODIFY `id_hauling_to_pltu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `olc_runtime`
--
ALTER TABLE `olc_runtime`
  MODIFY `id_olc_runtime` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7993;

--
-- AUTO_INCREMENT for table `pm`
--
ALTER TABLE `pm`
  MODIFY `id_pm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1021;

--
-- AUTO_INCREMENT for table `production_today`
--
ALTER TABLE `production_today`
  MODIFY `id_production_today` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2520;

--
-- AUTO_INCREMENT for table `total_ritase`
--
ALTER TABLE `total_ritase`
  MODIFY `id_ritase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2963;

--
-- AUTO_INCREMENT for table `use_of_fuel_genset04`
--
ALTER TABLE `use_of_fuel_genset04`
  MODIFY `id_use_of_fuel_genset04` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `use_of_fuel_genset05`
--
ALTER TABLE `use_of_fuel_genset05`
  MODIFY `id_use_of_fuel_genset05` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `use_of_heavy_vehicles`
--
ALTER TABLE `use_of_heavy_vehicles`
  MODIFY `id_use` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17319;

--
-- AUTO_INCREMENT for table `use_of_kwh_pln_to_cpp`
--
ALTER TABLE `use_of_kwh_pln_to_cpp`
  MODIFY `id_use_of_kwh_pln_to_cpp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `water_level_on_recervoir_tank`
--
ALTER TABLE `water_level_on_recervoir_tank`
  MODIFY `id_water_level_on_recervoir_tank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `water_level_on_settling_pond`
--
ALTER TABLE `water_level_on_settling_pond`
  MODIFY `id_water_level_on_settling_pond` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_today`
--
ALTER TABLE `activity_today`
  ADD CONSTRAINT `activity_today_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `chemical_pic130_white_container`
--
ALTER TABLE `chemical_pic130_white_container`
  ADD CONSTRAINT `chemical_pic130_white_container_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cpp` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `chemical_startron_grey_container`
--
ALTER TABLE `chemical_startron_grey_container`
  ADD CONSTRAINT `chemical_startron_grey_container_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `cm`
--
ALTER TABLE `cm`
  ADD CONSTRAINT `cm_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `cpp_runtime`
--
ALTER TABLE `cpp_runtime`
  ADD CONSTRAINT `cpp_runtime_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `daily_tank_cap`
--
ALTER TABLE `daily_tank_cap`
  ADD CONSTRAINT `daily_tank_cap_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hauling_to_pltu`
--
ALTER TABLE `hauling_to_pltu`
  ADD CONSTRAINT `hauling_to_pltu_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `olc_runtime`
--
ALTER TABLE `olc_runtime`
  ADD CONSTRAINT `fk_id_cpp` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pm`
--
ALTER TABLE `pm`
  ADD CONSTRAINT `pm_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `total_ritase`
--
ALTER TABLE `total_ritase`
  ADD CONSTRAINT `fk_total_ritase_id_cpp` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `use_of_fuel_genset04`
--
ALTER TABLE `use_of_fuel_genset04`
  ADD CONSTRAINT `use_of_fuel_genset04_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `use_of_fuel_genset05`
--
ALTER TABLE `use_of_fuel_genset05`
  ADD CONSTRAINT `use_of_fuel_genset05_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `use_of_heavy_vehicles`
--
ALTER TABLE `use_of_heavy_vehicles`
  ADD CONSTRAINT `fk_use_of_heavy_vehicles_id_cpp` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `use_of_kwh_pln_to_cpp`
--
ALTER TABLE `use_of_kwh_pln_to_cpp`
  ADD CONSTRAINT `use_of_kwh_pln_to_cpp_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `water_level_on_recervoir_tank`
--
ALTER TABLE `water_level_on_recervoir_tank`
  ADD CONSTRAINT `water_level_on_recervoir_tank_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;

--
-- Constraints for table `water_level_on_settling_pond`
--
ALTER TABLE `water_level_on_settling_pond`
  ADD CONSTRAINT `fk_water_level_on_settling_pond_id_cpp` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE,
  ADD CONSTRAINT `water_level_on_settling_pond_ibfk_1` FOREIGN KEY (`id_cpp`) REFERENCES `cpp_data` (`id_cpp`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

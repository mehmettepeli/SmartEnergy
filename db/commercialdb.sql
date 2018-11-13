-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2018 at 10:40 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_energy_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `commercialdb`
--

CREATE TABLE `commercialdb` (
  `id` int(11) NOT NULL,
  `hour` int(2) NOT NULL,
  `energy` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commercialdb`
--

INSERT INTO `commercialdb` (`id`, `hour`, `energy`) VALUES
(1, 0, 753232.4301),
(2, 1, 753282.6347),
(3, 2, 753332.7107),
(4, 3, 753382.2093),
(5, 4, 753432.1478),
(6, 5, 753481.6851),
(7, 6, 753531.6565),
(8, 7, 753581.16),
(9, 8, 753650.8339),
(10, 9, 753728.1475),
(11, 10, 753801.6508),
(12, 11, 753890.1542),
(13, 12, 753999.3178),
(14, 13, 754104.8376),
(15, 14, 754215.3777),
(16, 15, 754324.3679),
(17, 16, 754428.6598),
(18, 17, 754527.3921),
(19, 18, 754616.0253),
(20, 19, 754687.8213),
(21, 20, 754749.0318),
(22, 21, 754807.2742),
(23, 22, 754864.7952),
(24, 23, 754921.4637);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commercialdb`
--
ALTER TABLE `commercialdb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commercialdb`
--
ALTER TABLE `commercialdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

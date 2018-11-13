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
-- Table structure for table `householddb`
--

CREATE TABLE `householddb` (
  `id` int(11) NOT NULL,
  `hour` int(2) NOT NULL,
  `energy` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `householddb`
--

INSERT INTO `householddb` (`id`, `hour`, `energy`) VALUES
(1, 0, 3721.9557),
(2, 1, 3722.0593),
(3, 2, 3722.1449),
(4, 3, 3722.2283),
(5, 4, 3722.3265),
(6, 5, 3722.4163),
(7, 6, 3722.5163),
(8, 7, 3722.617),
(9, 8, 3722.7008),
(10, 9, 3722.7999),
(11, 10, 3723.3128),
(12, 11, 3723.4707),
(13, 12, 3723.6002),
(14, 13, 3724.1698),
(15, 14, 3724.35),
(16, 15, 3724.8936),
(17, 16, 3725.0457),
(18, 17, 3725.1285),
(19, 18, 3725.2316),
(20, 19, 3725.3299),
(21, 20, 3725.4158),
(22, 21, 3725.7819),
(23, 22, 3725.8986),
(24, 23, 3725.9646);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `householddb`
--
ALTER TABLE `householddb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `householddb`
--
ALTER TABLE `householddb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

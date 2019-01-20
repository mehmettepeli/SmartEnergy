-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Jan 2019 um 18:04
-- Server-Version: 10.1.37-MariaDB
-- PHP-Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `smart_energy_system`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `commercialdb`
--

CREATE TABLE `commercialdb` (
  `id` int(11) NOT NULL,
  `hour` int(2) NOT NULL,
  `energy` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `commercialdb`
--

INSERT INTO `commercialdb` (`id`, `hour`, `energy`) VALUES
(25, 0, 502.046),
(26, 1, 50.2046),
(27, 2, 50.076),
(28, 3, 49.4986),
(29, 4, 49.9385),
(30, 5, 49.5373),
(31, 6, 49.9714),
(32, 7, 49.5035),
(33, 8, 69.6739),
(34, 9, 77.3136),
(35, 10, 73.5033),
(36, 11, 88.5034),
(37, 12, 109.1636),
(38, 13, 105.5198),
(39, 14, 110.5401),
(40, 15, 108.9902),
(41, 16, 104.2919),
(42, 17, 98.7323),
(43, 18, 88.6332),
(44, 19, 71.796),
(45, 20, 61.2105),
(46, 21, 58.2424),
(47, 22, 57.521),
(48, 23, 56.6685);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dynamic_pricing`
--

CREATE TABLE `dynamic_pricing` (
  `id` int(11) NOT NULL,
  `hour` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `dynamic_pricing`
--

INSERT INTO `dynamic_pricing` (`id`, `hour`, `price`) VALUES
(1, 0, 0.0423),
(2, 1, 0.0409),
(3, 2, 0.0438),
(4, 3, 0.0451),
(5, 4, 0.0479),
(6, 5, 0.0498),
(7, 6, 0.0548),
(8, 7, 0.0731),
(9, 8, 0.0769),
(10, 9, 0.0743),
(11, 10, 0.0705),
(12, 11, 0.069),
(13, 12, 0.0689),
(14, 13, 0.0653),
(15, 14, 0.0674),
(16, 15, 0.0681),
(17, 16, 0.069),
(18, 17, 0.075),
(19, 18, 0.0761),
(20, 19, 0.0725),
(21, 20, 0.0618),
(22, 21, 0.0592),
(23, 22, 0.0567),
(24, 23, 0.0532);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `householddb`
--

CREATE TABLE `householddb` (
  `id` int(11) NOT NULL,
  `hour` int(2) NOT NULL,
  `energy` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `householddb`
--

INSERT INTO `householddb` (`id`, `hour`, `energy`) VALUES
(25, 0, 1.036),
(26, 1, 0.1036),
(27, 2, 0.0856),
(28, 3, 0.0834),
(29, 4, 0.0982),
(30, 5, 0.0898),
(31, 6, 0.1),
(32, 7, 0.1007),
(33, 8, 0.0838),
(34, 9, 0.0991),
(35, 10, 0.5129),
(36, 11, 0.1579),
(37, 12, 0.1295),
(38, 13, 0.5696),
(39, 14, 0.1802),
(40, 15, 0.5436),
(41, 16, 0.1521),
(42, 17, 0.0828),
(43, 18, 0.1031),
(44, 19, 0.0983),
(45, 20, 0.0859),
(46, 21, 0.3661),
(47, 22, 0.1167),
(48, 23, 0.066);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `setupdb`
--

CREATE TABLE `setupdb` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `wind_roter` float DEFAULT NULL,
  `panel_area` float DEFAULT NULL,
  `panel_yield` float DEFAULT NULL,
  `panel_angle` int(11) DEFAULT NULL,
  `sHorizon` float DEFAULT NULL,
  `bat_max_cap` float DEFAULT NULL,
  `bat_max_charging` float DEFAULT NULL,
  `bat_max_discharging` float DEFAULT NULL,
  `bat_eff_charging` float DEFAULT NULL,
  `bat_eff_discharging` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `setupdb`
--

INSERT INTO `setupdb` (`id`, `user_id`, `wind_roter`, `panel_area`, `panel_yield`, `panel_angle`, `sHorizon`, `bat_max_cap`, `bat_max_charging`, `bat_max_discharging`, `bat_eff_charging`, `bat_eff_discharging`) VALUES
(1, 1, 1.8, 1.3, 0.2, 33, 3.47, 200, 20, 20, 0.9, 0.9);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shifted_energydb`
--

CREATE TABLE `shifted_energydb` (
  `id` int(11) NOT NULL,
  `shifted_hour` int(11) NOT NULL,
  `shifted_energy` double NOT NULL,
  `actual_hour` int(11) NOT NULL,
  `sender` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `shifted_energydb`
--

INSERT INTO `shifted_energydb` (`id`, `shifted_hour`, `shifted_energy`, `actual_hour`, `sender`) VALUES
(1, 2, 41.219, 0, 'F'),
(2, 4, 41.3565, 0, 'F'),
(3, 3, 41.7964, 0, 'F'),
(4, 1, 41.0904, 0, 'F'),
(5, 5, 41.7577, 0, 'F'),
(6, 23, 34.6265, 0, 'F'),
(7, 6, 9.1765, 0, 'F');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `solardb`
--

CREATE TABLE `solardb` (
  `id` int(11) NOT NULL,
  `Date` varchar(20) NOT NULL,
  `Hour` int(2) NOT NULL,
  `Temp` float NOT NULL,
  `ProducedEnergy` double NOT NULL,
  `track` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `solardb`
--

INSERT INTO `solardb` (`id`, `Date`, `Hour`, `Temp`, `ProducedEnergy`, `track`) VALUES
(9, '2019-01-17', 19, 3, 1.2342, 'today'),
(10, '2019-01-18', 19, -3.26, 1.2342, 'tomorrow'),
(13, '2019-01-17', 20, 2.63, 1.2342, 'today'),
(14, '2019-01-18', 20, -3.26, 1.2342, 'tomorrow'),
(15, '2019-01-17', 21, 2.56, 1.2342, 'today'),
(16, '2019-01-18', 21, -4.734, 1.2342, 'tomorrow'),
(19, '2019-01-17', 22, 2.56, 1.2342, 'today'),
(20, '2019-01-18', 22, -4.734, 1.2342, 'tomorrow'),
(21, '2019-01-18', 7, -273.15, 1.2302, 'today'),
(25, '2019-01-19', 7, -6.509, 1.2302, 'tomorrow'),
(80, '2019-01-18', 8, 0, 1.2302, 'today'),
(81, '2019-01-19', 8, -6.509, 1.2302, 'tomorrow'),
(182, '2019-01-18', 20, -2.25, 1.2302, 'today'),
(184, '2019-01-19', 20, -5.836, 1.2302, 'tomorrow'),
(187, '2019-01-18', 20, -2.24, 1.2302, 'today'),
(198, '2019-01-18', 21, -2, 1.2302, 'today'),
(199, '2019-01-19', 21, -7.88, 1.2302, 'tomorrow'),
(230, '2019-01-18', 22, -3, 1.2302, 'today'),
(231, '2019-01-19', 22, -7.88, 1.2302, 'tomorrow'),
(295, '2019-01-19', 23, -7.88, 1.2302, 'tomorrow'),
(296, '2019-01-18', 23, -4, 1.2302, 'today'),
(422, '2019-01-19', 0, -4, 1.2262, 'today'),
(423, '2019-01-20', 0, -7.929, 1.2262, 'tomorrow'),
(678, '2019-01-19', 1, -3, 1.2262, 'today'),
(679, '2019-01-20', 1, -7.929, 1.2262, 'tomorrow'),
(1190, '2019-01-19', 2, -4, 1.2262, 'today'),
(1191, '2019-01-20', 2, -7.929, 1.2262, 'tomorrow'),
(3587, '2019-01-19', 3, -3, 1.2262, 'today'),
(4262, '2019-01-19', 4, -273.15, 1.2262, 'today'),
(6310, '2019-01-19', 5, -273.15, 1.2262, 'today'),
(10406, '2019-01-19', 6, -273.15, 1.2262, 'today'),
(18598, '2019-01-19', 7, -273.15, 1.2262, 'today'),
(44864, '2019-01-19', 8, -273.15, 1.2262, 'today'),
(44865, '2019-01-19', 14, -1.32, 1.2262, 'today'),
(44866, '2019-01-20', 14, -1.181, 1.2262, 'tomorrow'),
(44867, '2019-01-19', 15, -1.31, 1.2262, 'today'),
(44868, '2019-01-20', 15, -0.501, 1.2262, 'tomorrow'),
(44869, '2019-01-19', 15, -1.44, 1.2262, 'today'),
(44870, '2019-01-20', 15, -0.501, 1.2262, 'tomorrow'),
(44871, '2019-01-19', 20, -6, 1.2262, 'today'),
(44872, '2019-01-20', 20, -2.657, 1.2262, 'tomorrow'),
(44873, '2019-01-19', 21, -6, 1.2262, 'today'),
(44874, '2019-01-20', 21, -3.708, 1.2262, 'tomorrow'),
(44875, '2019-01-19', 22, -6, 1.2262, 'today'),
(44876, '2019-01-20', 22, -3.708, 1.2262, 'tomorrow'),
(44877, '2019-01-19', 22, -6, 1.2262, 'today'),
(44878, '2019-01-20', 22, -3.708, 1.2262, 'tomorrow'),
(44879, '2019-01-19', 23, -273.15, 1.2262, 'today'),
(44880, '2019-01-19', 23, -273.15, 1.2262, 'today'),
(44881, '2019-01-19', 23, -273.15, 1.2262, 'today'),
(44882, '2019-01-19', 23, -273.15, 1.2262, 'today'),
(44883, '2019-01-20', 0, -273.15, 1.222, 'today'),
(44884, '2019-01-20', 0, -273.15, 1.222, 'today'),
(44885, '2019-01-20', 0, -273.15, 1.222, 'today'),
(44886, '2019-01-20', 0, -273.15, 1.222, 'today'),
(44887, '2019-01-20', 0, -273.15, 1.222, 'today'),
(44888, '2019-01-20', 0, -273.15, 1.222, 'today'),
(44889, '2019-01-20', 0, -273.15, 1.222, 'today'),
(44890, '2019-01-20', 0, -273.15, 1.222, 'today'),
(44891, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44892, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44893, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44894, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44895, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44896, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44897, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44898, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44899, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44900, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44901, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44902, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44903, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44904, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44905, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44906, '2019-01-20', 10, -273.15, 1.222, 'today'),
(44907, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44908, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44909, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44910, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44911, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44912, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44913, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44914, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44915, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44916, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44917, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44918, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44919, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44920, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44921, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44922, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44923, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44924, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44925, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44926, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44927, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44928, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44929, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44930, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44931, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44932, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44933, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44934, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44935, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44936, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44937, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44938, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44939, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44940, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44941, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44942, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44943, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44944, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44945, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44946, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44947, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44948, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44949, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44950, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44951, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44952, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44953, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44954, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44955, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44956, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44957, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44958, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44959, '2019-01-20', 12, -4.1, 1.222, 'today'),
(44960, '2019-01-21', 12, -4.276, 1.222, 'tomorrow'),
(44961, '2019-01-20', 13, -4.12, 1.222, 'today'),
(44962, '2019-01-21', 13, -4.276, 1.222, 'tomorrow'),
(44963, '2019-01-20', 14, -3.1, 1.222, 'today'),
(44964, '2019-01-21', 14, -4.276, 1.222, 'tomorrow'),
(44967, '2019-01-20', 15, -2.1, 1.222, 'today'),
(44968, '2019-01-21', 15, -3.647, 1.222, 'tomorrow'),
(44975, '2019-01-20', 16, -1.65, 1.222, 'today'),
(44976, '2019-01-21', 16, -3.647, 1.222, 'tomorrow'),
(44991, '2019-01-20', 17, -2.66, 1.222, 'today'),
(45024, '2019-01-21', 17, -3.647, 1.222, 'tomorrow');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `winddb`
--

CREATE TABLE `winddb` (
  `id` int(11) NOT NULL,
  `Date` varchar(20) NOT NULL,
  `Hour` int(2) NOT NULL,
  `Temp` float NOT NULL,
  `ProducedEnergy` double NOT NULL,
  `track` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `winddb`
--

INSERT INTO `winddb` (`id`, `Date`, `Hour`, `Temp`, `ProducedEnergy`, `track`) VALUES
(9, '2019-01-17', 19, 3, 1.9506, 'today'),
(10, '2019-01-18', 19, -3.26, 0.0512, 'tomorrow'),
(13, '2019-01-17', 20, 2.63, 0.3031, 'today'),
(14, '2019-01-18', 20, -3.26, 0.0512, 'tomorrow'),
(15, '2019-01-17', 21, 2.56, 0.194, 'today'),
(16, '2019-01-18', 21, -4.734, 0.0562, 'tomorrow'),
(19, '2019-01-17', 22, 2.56, 0.194, 'today'),
(20, '2019-01-18', 22, -4.734, 0.0562, 'tomorrow'),
(96, '2019-01-18', 8, 0, 0.3081, 'today'),
(98, '2019-01-19', 8, -6.509, 0.0328, 'tomorrow'),
(167, '2019-01-18', 18, -1, 0.0224, 'today'),
(168, '2019-01-19', 18, -5.836, 0.018, 'tomorrow'),
(173, '2019-01-18', 19, -1, 0.0224, 'today'),
(174, '2019-01-19', 19, -5.836, 0.018, 'tomorrow'),
(177, '2019-01-18', 20, -2.25, 0.0225, 'today'),
(179, '2019-01-19', 20, -5.836, 0.018, 'tomorrow'),
(193, '2019-01-18', 21, -2, 0.0225, 'today'),
(194, '2019-01-19', 21, -7.88, 0.0145, 'tomorrow'),
(225, '2019-01-18', 22, -3, 0.1175, 'today'),
(226, '2019-01-19', 22, -7.88, 0.0145, 'tomorrow'),
(289, '2019-01-18', 23, -4, 0.0621, 'today'),
(290, '2019-01-19', 23, -7.88, 0.0145, 'tomorrow'),
(464, '2019-01-19', 0, -4, 0.0067, 'today'),
(465, '2019-01-20', 0, -7.929, 0.0149, 'tomorrow'),
(673, '2019-01-19', 1, -3, 0.0067, 'today'),
(674, '2019-01-20', 1, -7.929, 0.0149, 'tomorrow'),
(1185, '2019-01-19', 2, -4, 0.0008, 'today'),
(1186, '2019-01-20', 2, -7.929, 0.0149, 'tomorrow'),
(2209, '2019-01-19', 3, -3, 0.0008, 'today'),
(2210, '2019-01-20', 3, -7.82, 0.0145, 'tomorrow'),
(4257, '2019-01-19', 14, -1.32, 0.0613, 'today'),
(4258, '2019-01-20', 14, -1.181, 0.0258, 'tomorrow'),
(4259, '2019-01-19', 15, -1.31, 0.0613, 'today'),
(4260, '2019-01-20', 15, -0.501, 0.0405, 'tomorrow'),
(4263, '2019-01-19', 20, -6, 0.0227, 'today'),
(4264, '2019-01-20', 20, -2.657, 0.0178, 'tomorrow'),
(4265, '2019-01-19', 21, -6, 0.0227, 'today'),
(4266, '2019-01-20', 21, -3.708, 0.0179, 'tomorrow'),
(4269, '2019-01-19', 22, -6, 0.0008, 'today'),
(4270, '2019-01-20', 22, -3.708, 0.0179, 'tomorrow'),
(4316, '2019-01-20', 12, -4.1, 0.0008, 'today'),
(4322, '2019-01-21', 12, -4.276, 0.0448, 'tomorrow'),
(4325, '2019-01-20', 13, -4.12, 0.0226, 'today'),
(4326, '2019-01-21', 13, -4.276, 0.0448, 'tomorrow'),
(4327, '2019-01-20', 14, -3.1, 0.0008, 'today'),
(4328, '2019-01-21', 14, -4.276, 0.0448, 'tomorrow'),
(4331, '2019-01-20', 15, -2.1, 0.0008, 'today'),
(4332, '2019-01-21', 15, -3.647, 0.0183, 'tomorrow'),
(4339, '2019-01-20', 16, -1.65, 0.0066, 'today'),
(4340, '2019-01-21', 16, -3.647, 0.0183, 'tomorrow'),
(4355, '2019-01-20', 17, -2.66, 0.0616, 'today'),
(4356, '2019-01-21', 17, -3.647, 0.0183, 'tomorrow'),
(4387, '2019-01-20', 17, -2.65, 0.117, 'today'),
(4388, '2019-01-21', 17, -3.647, 0.0183, 'tomorrow');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `commercialdb`
--
ALTER TABLE `commercialdb`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `dynamic_pricing`
--
ALTER TABLE `dynamic_pricing`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `householddb`
--
ALTER TABLE `householddb`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `setupdb`
--
ALTER TABLE `setupdb`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `shifted_energydb`
--
ALTER TABLE `shifted_energydb`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `solardb`
--
ALTER TABLE `solardb`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `winddb`
--
ALTER TABLE `winddb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `commercialdb`
--
ALTER TABLE `commercialdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT für Tabelle `dynamic_pricing`
--
ALTER TABLE `dynamic_pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT für Tabelle `householddb`
--
ALTER TABLE `householddb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT für Tabelle `setupdb`
--
ALTER TABLE `setupdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `shifted_energydb`
--
ALTER TABLE `shifted_energydb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `solardb`
--
ALTER TABLE `solardb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45025;

--
-- AUTO_INCREMENT für Tabelle `winddb`
--
ALTER TABLE `winddb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4389;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

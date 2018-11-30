-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Nov 2018 um 20:26
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
-- Datenbank: `smart-energy`
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
(1, 0, 0.028),
(2, 1, 0.028),
(3, 2, 0.028),
(4, 3, 0.028),
(5, 4, 0.028),
(6, 5, 0.028),
(7, 6, 0.028),
(9, 7, 0.058),
(10, 8, 0.058),
(11, 9, 0.058),
(12, 10, 0.17),
(13, 11, 0.17),
(14, 12, 0.17),
(15, 13, 0.29),
(16, 14, 0.29),
(17, 15, 0.29),
(18, 16, 0.29),
(19, 17, 0.29),
(20, 18, 0.29),
(21, 19, 0.21),
(22, 20, 0.21),
(23, 21, 0.21),
(24, 22, 0.058),
(25, 23, 0.058);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `householddb`
--

CREATE TABLE `householddb` (
  `id` int(11) NOT NULL,
  `hour` int(2) NOT NULL,
  `energy` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT für Tabelle `dynamic_pricing`
--
ALTER TABLE `dynamic_pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT für Tabelle `householddb`
--
ALTER TABLE `householddb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT für Tabelle `shifted_energydb`
--
ALTER TABLE `shifted_energydb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `solardb`
--
ALTER TABLE `solardb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `winddb`
--
ALTER TABLE `winddb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

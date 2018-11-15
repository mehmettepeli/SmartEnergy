-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Nov 2018 um 19:06
-- Server-Version: 10.1.25-MariaDB
-- PHP-Version: 7.1.7

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
-- Indizes für die Tabelle `householddb`
--
ALTER TABLE `householddb`
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
-- AUTO_INCREMENT für Tabelle `householddb`
--
ALTER TABLE `householddb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT für Tabelle `solardb`
--
ALTER TABLE `solardb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `winddb`
--
ALTER TABLE `winddb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

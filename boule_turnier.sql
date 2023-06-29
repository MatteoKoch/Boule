-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 29. Jun 2023 um 18:39
-- Server-Version: 10.4.20-MariaDB
-- PHP-Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `boule_turnier`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spiele`
--

CREATE TABLE `spiele` (
  `id` int(11) NOT NULL,
  `team_1_id` int(11) NOT NULL,
  `team_1_punkte` tinyint(11) DEFAULT NULL,
  `team_2_id` int(11) NOT NULL,
  `team_2_punkte` tinyint(11) DEFAULT NULL,
  `erstellt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `spielplatz` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spiele_backup`
--

CREATE TABLE `spiele_backup` (
  `id` int(11) NOT NULL,
  `team_1_id` int(11) NOT NULL,
  `team_1_punkte` tinyint(4) DEFAULT NULL,
  `team_2_id` int(11) NOT NULL,
  `team_2_punkte` tinyint(4) DEFAULT NULL,
  `erstellt` timestamp NOT NULL DEFAULT current_timestamp(),
  `spielplatz` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `erstellt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teams_backup`
--

CREATE TABLE `teams_backup` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `erstellt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teams_mitglieder`
--

CREATE TABLE `teams_mitglieder` (
  `id` int(11) NOT NULL,
  `teams_id` int(11) DEFAULT NULL,
  `mitglied` text DEFAULT NULL,
  `erstellt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teams_mitglieder_backup`
--

CREATE TABLE `teams_mitglieder_backup` (
  `id` int(11) NOT NULL,
  `teams_id` int(11) DEFAULT NULL,
  `mitglied` text DEFAULT NULL,
  `erstellt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `spiele`
--
ALTER TABLE `spiele`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `spiele_backup`
--
ALTER TABLE `spiele_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `teams_backup`
--
ALTER TABLE `teams_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `teams_mitglieder`
--
ALTER TABLE `teams_mitglieder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_id` (`teams_id`);

--
-- Indizes für die Tabelle `teams_mitglieder_backup`
--
ALTER TABLE `teams_mitglieder_backup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_id` (`teams_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `spiele`
--
ALTER TABLE `spiele`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `spiele_backup`
--
ALTER TABLE `spiele_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT für Tabelle `teams_backup`
--
ALTER TABLE `teams_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT für Tabelle `teams_mitglieder`
--
ALTER TABLE `teams_mitglieder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `teams_mitglieder_backup`
--
ALTER TABLE `teams_mitglieder_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `teams_mitglieder`
--
ALTER TABLE `teams_mitglieder`
  ADD CONSTRAINT `teams_mitglieder_ibfk_1` FOREIGN KEY (`teams_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `teams_mitglieder_backup`
--
ALTER TABLE `teams_mitglieder_backup`
  ADD CONSTRAINT `teams_mitglieder_backup_ibfk_1` FOREIGN KEY (`teams_id`) REFERENCES `teams_backup` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

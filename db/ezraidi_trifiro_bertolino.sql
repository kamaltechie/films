-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ott 26, 2023 alle 19:39
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezraidi_trifiro_bertolino`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admin`
--

CREATE TABLE `admin` (
  `ID_ADMIN` int(2) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(20) DEFAULT NULL,
  `PASSWORD` char(64) DEFAULT NULL,
  PRIMARY KEY (ID_ADMIN)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `appartient`
--

CREATE TABLE `appartient` (
  `ID_COLLECTION` int(2) NOT NULL,
  `ID_FILM` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `client`
--

CREATE TABLE `client` (
  `ID_CLIENT` int(2) NOT NULL AUTO_INCREMENT,
  `ID_ADMIN` int(2) DEFAULT NULL,
  `NOM` varchar(20) DEFAULT NULL,
  `PRENOM` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(40) DEFAULT NULL,
  `ADRESSE` varchar(80) DEFAULT NULL,
  `PASSWORD` char(64) DEFAULT NULL,
  PRIMARY KEY (ID_CLIENT)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `collection`
--

CREATE TABLE `collection` (
  `ID_COLLECTION` int(2) NOT NULL AUTO_INCREMENT,
  `ID_ADMIN` int(2) NOT NULL,
  `NAME` varchar(20) DEFAULT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL,
  `DATE_CREATION` datetime DEFAULT NULL,
  PRIMARY KEY (ID_COLLECTION)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `commande`
--

CREATE TABLE `commande` (
  `NUM_COM` int(2) NOT NULL AUTO_INCREMENT,
  `ID_CLIENT` int(2) NOT NULL,
  `DATE_COM` date DEFAULT NULL,
  `STATUT_COM` varchar(15) DEFAULT NULL,
  `TOTAL` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (NUM_COM)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `commande_item`
--

CREATE TABLE `commande_item` (
  `NUM_COM` int(2) NOT NULL,
  `ID_FILM` int(2) NOT NULL,
  `QUANTITY` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `film`
--

CREATE TABLE `film` (
  `ID_FILM` int(2) NOT NULL AUTO_INCREMENT,
  `TITRE` varchar(40) DEFAULT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL,
  `PRIX` decimal(6,2) DEFAULT NULL,
  `CATEGORY` varchar(15) DEFAULT NULL,
  `STATUT` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (ID_FILM)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admin`
--


--
-- Indici per le tabelle `appartient`
--
ALTER TABLE `appartient`
  ADD PRIMARY KEY (`ID_COLLECTION`,`ID_FILM`),
  ADD KEY `I_FK_APPARTIENT_COLLECTION` (`ID_COLLECTION`),
  ADD KEY `I_FK_APPARTIENT_FILM` (`ID_FILM`);

--
-- Indici per le tabelle `client`
--
ALTER TABLE `client`
  ADD KEY `I_FK_CLIENT_ADMIN` (`ID_ADMIN`);

--
-- Indici per le tabelle `collection`
--
ALTER TABLE `collection`
  ADD KEY `I_FK_COLLECTION_ADMIN` (`ID_ADMIN`);

--
-- Indici per le tabelle `commande`
--
ALTER TABLE `commande`
  ADD KEY `I_FK_COMMANDE_CLIENT` (`ID_CLIENT`);

--
-- Indici per le tabelle `commande_item`
--
ALTER TABLE `commande_item`
  ADD PRIMARY KEY (`NUM_COM`,`ID_FILM`),
  ADD KEY `I_FK_COMMANDE_ITEM_COMMANDE` (`NUM_COM`),
  ADD KEY `I_FK_COMMANDE_ITEM_FILM` (`ID_FILM`);

--
-- Indici per le tabelle `film`
--

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appartient`
--
ALTER TABLE `appartient`
  ADD CONSTRAINT `FK_APPARTIENT_COLLECTION` FOREIGN KEY (`ID_COLLECTION`) REFERENCES `collection` (`ID_COLLECTION`),
  ADD CONSTRAINT `FK_APPARTIENT_FILM` FOREIGN KEY (`ID_FILM`) REFERENCES `film` (`ID_FILM`);

--
-- Limiti per la tabella `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_CLIENT_ADMIN` FOREIGN KEY (`ID_ADMIN`) REFERENCES `admin` (`ID_ADMIN`);

--
-- Limiti per la tabella `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `FK_COLLECTION_ADMIN` FOREIGN KEY (`ID_ADMIN`) REFERENCES `admin` (`ID_ADMIN`);

--
-- Limiti per la tabella `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_COMMANDE_CLIENT` FOREIGN KEY (`ID_CLIENT`) REFERENCES `client` (`ID_CLIENT`);

--
-- Limiti per la tabella `commande_item`
--
ALTER TABLE `commande_item`
  ADD CONSTRAINT `FK_COMMANDE_ITEM_COMMANDE` FOREIGN KEY (`NUM_COM`) REFERENCES `commande` (`NUM_COM`),
  ADD CONSTRAINT `FK_COMMANDE_ITEM_FILM` FOREIGN KEY (`ID_FILM`) REFERENCES `film` (`ID_FILM`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

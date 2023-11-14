-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2023 at 01:55 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID_ADMIN` int(2) NOT NULL,
  `USERNAME` varchar(20) DEFAULT NULL,
  `PASSWORD` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID_ADMIN`, `USERNAME`, `PASSWORD`) VALUES
(1, 'kamal', '$2y$10$6O3AfNPudCPLoGDkjlyK6ezQK/iuTwtY.OtB30YtpuXe2aszTJVme');

-- --------------------------------------------------------

--
-- Table structure for table `appartient`
--

CREATE TABLE `appartient` (
  `ID_COLLECTION` int(2) NOT NULL,
  `ID_FILM` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `ID_CLIENT` int(2) NOT NULL,
  `ID_ADMIN` int(2) DEFAULT NULL,
  `NOM` varchar(20) DEFAULT NULL,
  `PRENOM` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(40) DEFAULT NULL,
  `ADRESSE` varchar(80) DEFAULT NULL,
  `PASSWORD` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `ID_COLLECTION` int(2) NOT NULL,
  `ID_ADMIN` int(2) NOT NULL,
  `NAME` varchar(20) DEFAULT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL,
  `DATE_CREATION` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `NUM_COM` int(2) NOT NULL,
  `ID_CLIENT` int(2) NOT NULL,
  `DATE_COM` date DEFAULT NULL,
  `STATUT_COM` varchar(15) DEFAULT NULL,
  `TOTAL` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commande_item`
--

CREATE TABLE `commande_item` (
  `NUM_COM` int(2) NOT NULL,
  `ID_FILM` int(2) NOT NULL,
  `QUANTITY` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `ID_FILM` int(2) NOT NULL,
  `TITRE` varchar(40) DEFAULT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL,
  `PRIX` decimal(6,2) DEFAULT NULL,
  `CATEGORY` varchar(15) DEFAULT NULL,
  `STATUT` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_ADMIN`);

--
-- Indexes for table `appartient`
--
ALTER TABLE `appartient`
  ADD PRIMARY KEY (`ID_COLLECTION`,`ID_FILM`),
  ADD KEY `I_FK_APPARTIENT_COLLECTION` (`ID_COLLECTION`),
  ADD KEY `I_FK_APPARTIENT_FILM` (`ID_FILM`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ID_CLIENT`),
  ADD KEY `I_FK_CLIENT_ADMIN` (`ID_ADMIN`);

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`ID_COLLECTION`),
  ADD KEY `I_FK_COLLECTION_ADMIN` (`ID_ADMIN`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`NUM_COM`),
  ADD KEY `I_FK_COMMANDE_CLIENT` (`ID_CLIENT`);

--
-- Indexes for table `commande_item`
--
ALTER TABLE `commande_item`
  ADD PRIMARY KEY (`NUM_COM`,`ID_FILM`),
  ADD KEY `I_FK_COMMANDE_ITEM_COMMANDE` (`NUM_COM`),
  ADD KEY `I_FK_COMMANDE_ITEM_FILM` (`ID_FILM`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`ID_FILM`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_ADMIN` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `ID_CLIENT` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `ID_COLLECTION` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `NUM_COM` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `ID_FILM` int(2) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appartient`
--
ALTER TABLE `appartient`
  ADD CONSTRAINT `FK_APPARTIENT_COLLECTION` FOREIGN KEY (`ID_COLLECTION`) REFERENCES `collection` (`ID_COLLECTION`),
  ADD CONSTRAINT `FK_APPARTIENT_FILM` FOREIGN KEY (`ID_FILM`) REFERENCES `film` (`ID_FILM`);

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_CLIENT_ADMIN` FOREIGN KEY (`ID_ADMIN`) REFERENCES `admin` (`ID_ADMIN`);

--
-- Constraints for table `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `FK_COLLECTION_ADMIN` FOREIGN KEY (`ID_ADMIN`) REFERENCES `admin` (`ID_ADMIN`);

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_COMMANDE_CLIENT` FOREIGN KEY (`ID_CLIENT`) REFERENCES `client` (`ID_CLIENT`);

--
-- Constraints for table `commande_item`
--
ALTER TABLE `commande_item`
  ADD CONSTRAINT `FK_COMMANDE_ITEM_COMMANDE` FOREIGN KEY (`NUM_COM`) REFERENCES `commande` (`NUM_COM`),
  ADD CONSTRAINT `FK_COMMANDE_ITEM_FILM` FOREIGN KEY (`ID_FILM`) REFERENCES `film` (`ID_FILM`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
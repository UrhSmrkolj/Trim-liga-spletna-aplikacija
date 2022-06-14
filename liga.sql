-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 14. jun 2022 ob 23.02
-- Različica strežnika: 10.4.21-MariaDB
-- Različica PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `liga`
--

-- --------------------------------------------------------

--
-- Struktura tabele `admin`
--

CREATE TABLE `admin` (
  `username` varchar(20) NOT NULL,
  `geslo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `admin`
--

INSERT INTO `admin` (`username`, `geslo`) VALUES
('admin1', 'geslo1'),
('admin2', 'geslo2'),
('admin3', 'geslo3');

-- --------------------------------------------------------

--
-- Struktura tabele `igralec`
--

CREATE TABLE `igralec` (
  `ID` int(10) NOT NULL,
  `ime` varchar(20) NOT NULL,
  `priimek` varchar(20) NOT NULL,
  `klub` varchar(20) NOT NULL,
  `gol` int(10) NOT NULL,
  `karton` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `igralec`
--

INSERT INTO `igralec` (`ID`, `ime`, `priimek`, `klub`, `gol`, `karton`) VALUES
(1, 'Miha', 'Novak', 'Kisovec', 8, 4),
(3, 'Jure', 'Kos', 'Zagorje', 0, 0),
(6, 'Stefan', 'Bas', 'Kisovec', 2, 3),
(7, 'Boris', 'Tot', 'Trbovlje', 0, 0),
(9, 'Martin', 'Kavcic', 'Trbovlje', 3, 3),
(15, 'Ziga', 'Kovacic', 'Izlake', 0, 0),
(21, 'Ime1', 'Priimek1', 'Izlake', 0, 0),
(24, 'Ime3', 'Priimek3', 'Izlake', 0, 0),
(32, 'Urh', 'Smrkolj', 'Kisovec', 3, 3),
(33, 'Tina', 'Nose', 'Zagorje', 1, 3),
(34, 'Zan', 'Ocepek', 'Kisovec', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabele `klub`
--

CREATE TABLE `klub` (
  `klub` varchar(20) NOT NULL,
  `točke` int(10) DEFAULT NULL,
  `liga` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `klub`
--

INSERT INTO `klub` (`klub`, `točke`, `liga`) VALUES
('Izlake', 0, 2),
('Kisovec', 21, 1),
('Litija', 0, 2),
('Trbovlje', 3, 1),
('Trojane', 0, 2),
('Zagorje', 0, 1);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indeksi tabele `igralec`
--
ALTER TABLE `igralec`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `klub` (`klub`);

--
-- Indeksi tabele `klub`
--
ALTER TABLE `klub`
  ADD PRIMARY KEY (`klub`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `igralec`
--
ALTER TABLE `igralec`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `igralec`
--
ALTER TABLE `igralec`
  ADD CONSTRAINT `igralec_ibfk_1` FOREIGN KEY (`klub`) REFERENCES `klub` (`klub`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

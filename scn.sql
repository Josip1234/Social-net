-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2021 at 11:29 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scn`
--

-- --------------------------------------------------------

--
-- Table structure for table `kvaliteta`
--

CREATE TABLE `kvaliteta` (
  `id` int(11) NOT NULL,
  `firstname` varchar(60) COLLATE utf8_croatian_ci NOT NULL,
  `lastname` varchar(60) COLLATE utf8_croatian_ci NOT NULL,
  `suggestion` varchar(255) COLLATE utf8_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `kvaliteta`
--

INSERT INTO `kvaliteta` (`id`, `firstname`, `lastname`, `suggestion`) VALUES
(1, '', '', ''),
(2, 'Josip', 'Bošnjak', 'Treba napraviti bla bla pa onda bla bla bla i tek onda bla bla bla.'),
(3, 'Josip', 'Bošnjak', 'Blabla bi trebalo promijeniti staviti blablabla.'),
(4, 'Josip', 'Bošnjak', 'Blabla bi trebalo promijeniti staviti blablabla.'),
(5, 'Mario', 'Mandžukić', 'Treba mi napadačka vrba.'),
(6, 'Ivan', 'Perišić', 'Imam coronu. Ne mogu igrati.'),
(7, 'Josip', 'Bošnjak', 'Napravljen unos feedbacka za stranicu. Popraviti bug koji dodaje prazno mjesto u tablicu. Napraviti neki captcha za odgodu novog unosa.'),
(8, 'Josip', 'Bošnjak', 'Sada treba napraviti registracijsku formu. Treba napraviti i stranicu koja omogućuje adminu da  uređuje feedbackove. Feedbackove može vidjeti samo admin.');

-- --------------------------------------------------------

--
-- Table structure for table `obavljeno`
--

CREATE TABLE `obavljeno` (
  `id` int(11) NOT NULL,
  `obavljeno` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `obavljeno`
--

INSERT INTO `obavljeno` (`id`, `obavljeno`, `user_id`) VALUES
(1, 1, 4),
(3, 1, 4),
(5, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `profilna`
--

CREATE TABLE `profilna` (
  `imageId` tinyint(4) NOT NULL,
  `imageType` varchar(25) COLLATE utf8_croatian_ci NOT NULL,
  `imageData` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8_croatian_ci NOT NULL,
  `dateofbirth` date NOT NULL,
  `cityofbirth` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `countryofbirth` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `fname`, `lname`, `sex`, `dateofbirth`, `cityofbirth`, `countryofbirth`, `pass`, `email`) VALUES
(4, 'hrgiho', 'hgoirhgo', 'm', '0005-02-05', 'grgrg', 'rggere', 'gfeeg', 'jbosnjak34@gmail.com'),
(5, 'Josip', 'Bošnjak', 'm', '1992-11-05', 'VVinterthur', 'Švicarska', '4854848484fege', 'jbosnjak3@gmail.com'),
(6, 'Marko', 'Marković', 'm', '1988-07-08', 'Požega', 'Hrvatska', 'volimhrvatsku', 'mmarkovic@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `uloge`
--

CREATE TABLE `uloge` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `uloga` enum('Administrator','Korisnik','Banovani korisnik') COLLATE utf8_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kvaliteta`
--
ALTER TABLE `kvaliteta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `firstname` (`firstname`),
  ADD KEY `lastname` (`lastname`),
  ADD KEY `suggestion` (`suggestion`);

--
-- Indexes for table `obavljeno`
--
ALTER TABLE `obavljeno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `profilna`
--
ALTER TABLE `profilna`
  ADD PRIMARY KEY (`imageId`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fname` (`fname`),
  ADD KEY `lname` (`lname`);

--
-- Indexes for table `uloge`
--
ALTER TABLE `uloge`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kvaliteta`
--
ALTER TABLE `kvaliteta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `obavljeno`
--
ALTER TABLE `obavljeno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profilna`
--
ALTER TABLE `profilna`
  MODIFY `imageId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `uloge`
--
ALTER TABLE `uloge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `obavljeno`
--
ALTER TABLE `obavljeno`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `registration` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

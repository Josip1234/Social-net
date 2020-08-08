-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2020 at 03:09 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

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
CREATE DATABASE IF NOT EXISTS `scn` DEFAULT CHARACTER SET utf8 COLLATE utf8_croatian_ci;
USE `scn`;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `imageId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `imageType` varchar(25) COLLATE utf8_croatian_ci NOT NULL,
  `imageData` longblob NOT NULL,
  `email` varchar(255) COLLATE utf8_croatian_ci NOT NULL,
  `date_of_addition` datetime NOT NULL,
  PRIMARY KEY (`imageId`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Triggers `profile`
--
DROP TRIGGER IF EXISTS `profile_OnInsert`;
DELIMITER $$
CREATE TRIGGER `profile_OnInsert` BEFORE INSERT ON `profile` FOR EACH ROW SET NEW.`date_of_addition` = IFNULL(NEW.`date_of_addition`, NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
CREATE TABLE IF NOT EXISTS `registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8_croatian_ci NOT NULL,
  `dateofbirth` date NOT NULL,
  `cityofbirth` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `countryofbirth` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `profilepicture` longblob NOT NULL,
  `email` varchar(255) COLLATE utf8_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `email_index` FOREIGN KEY (`email`) REFERENCES `registration` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

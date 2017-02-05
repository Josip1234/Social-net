-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2017 at 11:24 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `firstname` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lastname` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `suggestion` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `kvaliteta`
--

INSERT INTO `kvaliteta` (`id`, `firstname`, `lastname`, `suggestion`) VALUES
(1, 'Josip', 'Bošnjak', 'Napravljen unos feedbacka za stranicu. Popraviti bug koji dodaje prazno mjesto u tablicu. Napraviti neki captcha za odgodu novog unosa.'),
(2, 'Josip', 'Bošnjak', 'Sada treba napraviti registracijsku formu. Treba napraviti i stranicu koja omogućuje adminu da  uređuje feedbackove. Feedbackove može vidjeti samo admin.');

-- --------------------------------------------------------

--
-- Table structure for table `obavljeno`
--

CREATE TABLE `obavljeno` (
  `id` int(11) NOT NULL,
  `obavljeno` tinyint(1) NOT NULL
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
  `profilepicture` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `fname`, `lname`, `sex`, `dateofbirth`, `cityofbirth`, `countryofbirth`, `pass`, `profilepicture`) VALUES
(4, 'hrgiho', 'hgoirhgo', 'm', '0005-02-05', 'grgrg', 'rggere', 'gfeeg', 0x57494e5f32303137303130335f31305f32375f33345f50726f2e6a7067);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kvaliteta`
--
ALTER TABLE `kvaliteta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obavljeno`
--
ALTER TABLE `obavljeno`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kvaliteta`
--
ALTER TABLE `kvaliteta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

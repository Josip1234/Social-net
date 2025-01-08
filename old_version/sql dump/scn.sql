-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 10:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `suggestion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `kvaliteta`
--

INSERT INTO `kvaliteta` (`id`, `firstname`, `lastname`, `suggestion`) VALUES
(1, '', '', ''),
(2, 'Josip', 'Bošnjak', 'Bok. Moje ime je Josip. Ovo je moj prvi upis u bazu podataka. Trebalo bi poboljšati dizajn stranice i trebalo bi se poboljšati da ne piše na stranici undefined variables. To piše jer su varijable trebale biti deklarirane na početku. Lijep pozdrav.'),
(3, 'Ivan', 'Ivić', 'Veličina polja za feedback mi se ne sviđa. Trebalo bi to promijeniti.'),
(4, 'Ryno', 'gt4', 'Hello i do not understand lot of this stuff on this website. Can you add some translation on english please? I would appreciate it.'),
(5, 'Josip', 'Bošnjak', 'Napravljen unos feedbacka za stranicu. Popraviti bug koji dodaje prazno mjesto u tablicu. Napraviti neki captcha za odgodu novog unosa.'),
(6, 'Josip', 'Bošnjak', 'Sada treba napraviti registracijsku formu. Treba napraviti i stranicu koja omogućuje adminu da  uređuje feedbackove. Feedbackove može vidjeti samo admin.');

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
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `dateofbirth` date NOT NULL,
  `cityofbirth` varchar(50) NOT NULL,
  `countryofbirth` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `profilepicture` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `obavljeno`
--
ALTER TABLE `obavljeno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

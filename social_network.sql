-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2023 at 07:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `qaqc`
--

CREATE TABLE `qaqc` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `suggestions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `qaqc`
--

INSERT INTO `qaqc` (`id`, `fname`, `lname`, `suggestions`) VALUES
(4, 'Josip', 'Bošnjak', 'Errors needs to be deal it.'),
(5, 'Josip', 'Bošnjak', 'There is multiple insertion on submit. Needs to deal with it.'),
(6, 'Josip', 'Bošnjak', 'There is multiple insertion on submit. Needs to deal with it.'),
(7, 'Josip', 'Bošnjak', 'On refresh, same value has been inserted. Need to fix that.'),
(8, 'Josip', 'Bošnjak', 'test'),
(10, 'Josip', 'Bošnjak', 'Take me to the first page please.');

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
  `profilepicture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `qaqc`
--
ALTER TABLE `qaqc`
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
-- AUTO_INCREMENT for table `qaqc`
--
ALTER TABLE `qaqc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2020 at 11:59 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dmce`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowed_sites`
--

CREATE TABLE `allowed_sites` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `allowed` text NOT NULL,
  `ipaddr` text NOT NULL,
  `request_count` int(11) NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allowed_sites`
--

INSERT INTO `allowed_sites` (`id`, `uid`, `allowed`, `ipaddr`, `request_count`, `info`) VALUES
(3, '5e2b25d2170b3', 'www.google.com', '', 5, 'email-adharcard-'),
(4, '5e2b25d2170b4', 'www.facebook.com', '', 4, 'email-'),
(5, '5e2b25d2170b5', 'www.linkedIn.com', '', 1, 'email-marksheet-'),
(6, '5e2b25d2170b6', 'www.irctc.com', '', 2, 'email-adharcard-pancard-'),
(8, '5e2b25d2170b8', 'www.instagram.com', '', 3, 'email-'),
(9, '5e2b25d2170b2', 'localhost', '192.168.43.165', 0, 'adharcard-pancard-email-'),
(10, '5e2b25d2170b2', 'localhost1', '::1', 2, 'pancard-marksheet-'),
(11, '5e2b25d2170b2', 'localhost3', '::1', 8, 'email-pancard-'),
(14, '5e2b25d2170b2', 'https://snippetsapi.000webhostapp.com/', '192.168.137.148', 1, 'adharcard-pancard-'),
(16, '5e2b25d2170b2', 'https://testforapi.000webhostapp.com/', '192.168.137.1', 2, 'adharcard-'),
(17, '5e2b25d2170b2', 'https://snipani.000webhostapp.com/', '192.168.137.223', 1, 'pancard-');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `uid` varchar(20) NOT NULL,
  `email` text NOT NULL,
  `adharcard` text NOT NULL,
  `pancard` text NOT NULL,
  `drivinglicence` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`uid`, `email`, `adharcard`, `pancard`, `drivinglicence`) VALUES
('5e2b25d2170b2', 'anuragdeore125@gmail.com', 'https://192.168.137.33/svg/files/aadhar.jpg', 'https://192.168.137.33/svg/files/pan card.jpg', 'pan card.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `fid` int(11) NOT NULL,
  `filename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`fid`, `filename`) VALUES
(8, 'aadhar.jpg'),
(9, 'driving licence.jpg'),
(10, 'pan card.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `websiteName` text NOT NULL,
  `ipaddr` text NOT NULL,
  `time` text NOT NULL,
  `info` text NOT NULL,
  `request_count` int(11) NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` varchar(20) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`) VALUES
('5e2ba665cf89b', 'abcd', '8cb2237d0679ca88db6464eac60da96345513964'),
('5e2ba91def449', 'abcdaaa', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowed_sites`
--
ALTER TABLE `allowed_sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowed_sites`
--
ALTER TABLE `allowed_sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

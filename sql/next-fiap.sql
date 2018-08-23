-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2018 at 09:09 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `next-fiap`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CalculateDistanceKm` (`lat1` FLOAT, `lon1` FLOAT, `lat2` FLOAT, `lon2` FLOAT) RETURNS FLOAT BEGIN
		DECLARE rads FLOAT DEFAULT 0;
		SET lat1 = lat1 * PI() / 180;
		SET lon1 = lon1 * PI() / 180;
		SET lat2 = lat2 * PI() / 180;
		SET lon2 = lon2 * PI() / 180;
		SET rads = ACOS( 0.5*((1.0+COS(lon1-lon2))*COS(lat1-lat2) - (1.0-COS(lon1-lon2))*COS(lat1+lat2)) ); 
		RETURN 6378.388 * rads;
	END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) NOT NULL,
  `name` varchar(15) NOT NULL,
  `appkey` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `appkey`) VALUES
(1, 'Fabio', 'c4ca4238a0b923820dcc509a6f75849b');

-- --------------------------------------------------------

--
-- Table structure for table `client_detail`
--

CREATE TABLE `client_detail` (
  `client_id` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `critic_events`
--

CREATE TABLE `critic_events` (
  `appkey` varchar(50) NOT NULL,
  `geolocation` point NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(10) NOT NULL,
  `appkey` varchar(50) NOT NULL,
  `dtemp` float NOT NULL,
  `humidity` int(11) NOT NULL,
  `stemp` float NOT NULL COMMENT 'Static Temperature',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `appkey`, `dtemp`, `humidity`, `stemp`, `datetime`) VALUES
(2, 'c4ca4238a0b923820dcc509a6f75849b', 10, 80, 11.8, '2018-07-17 15:32:51'),
(3, 'c4ca4238a0b923820dcc509a6f75849b', 11, 80, 12, '2018-07-17 17:46:25'),
(4, 'c4ca4238a0b923820dcc509a6f75849b', 15, 70, 13, '2018-07-17 19:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `appkey` varchar(50) NOT NULL,
  `geolocation` point NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `last_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `static_lat` double DEFAULT NULL,
  `static_lon` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `type` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`type`) VALUES
('off'),
('on');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`appkey`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `client_detail`
--
ALTER TABLE `client_detail`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `critic_events`
--
ALTER TABLE `critic_events`
  ADD PRIMARY KEY (`appkey`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `appkey` (`appkey`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`appkey`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_detail`
--
ALTER TABLE `client_detail`
  MODIFY `client_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_detail`
--
ALTER TABLE `client_detail`
  ADD CONSTRAINT `client_detail_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `critic_events`
--
ALTER TABLE `critic_events`
  ADD CONSTRAINT `critic_events_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status` (`type`),
  ADD CONSTRAINT `critic_events_ibfk_2` FOREIGN KEY (`appkey`) REFERENCES `clients` (`appkey`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`appkey`) REFERENCES `clients` (`appkey`);

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`appkey`) REFERENCES `clients` (`appkey`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

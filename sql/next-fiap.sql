-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2018 at 04:16 AM
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
  `cpf` varchar(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(2) NOT NULL,
  `country` varchar(50) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_detail`
--

INSERT INTO `client_detail` (`client_id`, `cpf`, `first_name`, `last_name`, `email`, `address`, `city`, `state`, `country`, `creation_date`) VALUES
(1, '11122233344', 'Fabio', 'Molliet', 'fabiomolliet@test.com', 'Avenida teste, 204', 'São Paulo', 'SP', 'Brasil', '2018-07-18 01:56:58'),
(2, '', '', '', '', '', '', '', 'Brasil', '2018-07-18 01:56:58');

--
-- Triggers `client_detail`
--
DELIMITER $$
CREATE TRIGGER `Generate_appkey` AFTER INSERT ON `client_detail` FOR EACH ROW BEGIN
	DECLARE vUser varchar(50);
	SELECT USER() INTO vUser;
    insert into clients ( id, name , appkey ) values (NEW.client_id, NEW.first_name, MD5(NEW.client_id) );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `critic_events`
--

CREATE TABLE `critic_events` (
  `appkey` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  `alert` tinyint(1) NOT NULL DEFAULT '0',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `appkey` varchar(50) NOT NULL,
  `lon` double NOT NULL,
  `lat` double NOT NULL,
  `last_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `alert` tinyint(1) NOT NULL DEFAULT '0'
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
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

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
  MODIFY `client_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`id`) REFERENCES `client_detail` (`client_id`);

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

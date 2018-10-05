-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2018 at 05:02 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(10) NOT NULL,
  `name` varchar(15) CHARACTER SET latin1 NOT NULL,
  `appkey` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `name`, `appkey`) VALUES
(1, 'FMOLLIET', 'c4ca4238a0b923820dcc509a6f75849b');

-- --------------------------------------------------------

--
-- Table structure for table `client_detail`
--

CREATE TABLE `client_detail` (
  `client_id` int(10) NOT NULL,
  `cnpj` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'CPF / CNPJ',
  `first_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `last_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `business` varchar(150) DEFAULT NULL,
  `address` varchar(150) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `city` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `state` varchar(2) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `country` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client_detail`
--

INSERT INTO `client_detail` (`client_id`, `cnpj`, `first_name`, `last_name`, `email`, `business`, `address`, `city`, `state`, `country`, `creation_date`) VALUES
(1, '32756758850', 'FABIO', 'MOLLIET', 'email@teste.com', 'Loja teste', 'rua de teste', 'São Paulo', 'SP', 'Brasil', '2018-09-07 23:10:21');

--
-- Triggers `client_detail`
--
DELIMITER $$
CREATE TRIGGER `Generate_appkey` AFTER INSERT ON `client_detail` FOR EACH ROW BEGIN
	DECLARE vUser varchar(50);
	SELECT USER() INTO vUser;
    insert into clients ( client_id, name , appkey ) values (NEW.client_id, CONCAT(LEFT(NEW.first_name,1),NEW.last_name), MD5(NEW.client_id) );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `critical_events`
--

CREATE TABLE `critical_events` (
  `ce_id` int(11) NOT NULL,
  `machine_id` varchar(50) NOT NULL,
  `appkey` varchar(50) NOT NULL,
  `msg` text NOT NULL,
  `status` varchar(10) CHARACTER SET latin1 NOT NULL,
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(10) NOT NULL,
  `machine_id` varchar(50) NOT NULL,
  `appkey` varchar(50) NOT NULL,
  `dtemp` varchar(7) NOT NULL,
  `humidity` varchar(11) NOT NULL,
  `stemp` varchar(7) NOT NULL COMMENT 'Static Temperature',
  `energy` float DEFAULT NULL,
  `alert` tinyint(1) NOT NULL DEFAULT '0',
  `sentcheck` tinyint(1) NOT NULL DEFAULT '0',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `machine_id`, `appkey`, `dtemp`, `humidity`, `stemp`, `energy`, `alert`, `sentcheck`, `insert_date`) VALUES
(24, 'C0000001', 'c4ca4238a0b923820dcc509a6f75849b', '22', '84', '22', 10, 0, 0, '2018-10-04 03:26:06'),
(25, 'C0000001', 'c4ca4238a0b923820dcc509a6f75849b', '22', '84', '22', 10, 0, 0, '2018-10-04 03:27:44'),
(26, 'C0000001', 'c4ca4238a0b923820dcc509a6f75849b', '29.10', '92.20', '29.10', 10, 0, 0, '2018-10-04 03:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id_machine` varchar(50) NOT NULL,
  `appkey` varchar(50) NOT NULL,
  `lon` double NOT NULL,
  `lat` double NOT NULL,
  `last_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `alert` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `machine_id` varchar(50) NOT NULL COMMENT 'FN+LN+AI',
  `client_appkey` varchar(50) NOT NULL COMMENT 'app key do cliente',
  `install_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de criação'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`machine_id`, `client_appkey`, `install_date`) VALUES
('C0000001', 'c4ca4238a0b923820dcc509a6f75849b', '2018-09-07 23:12:46');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `type` varchar(4) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`type`) VALUES
('off'),
('on');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `pwd` varchar(100) CHARACTER SET latin1 NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `pwd`, `creation_date`) VALUES
(1, 'fabio', '81dc9bdb52d04dc20036dbd8313ed055', '2018-07-20 16:35:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`appkey`),
  ADD UNIQUE KEY `id` (`client_id`);

--
-- Indexes for table `client_detail`
--
ALTER TABLE `client_detail`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `cpf` (`cnpj`);

--
-- Indexes for table `critical_events`
--
ALTER TABLE `critical_events`
  ADD PRIMARY KEY (`ce_id`),
  ADD KEY `status` (`status`),
  ADD KEY `machine_id` (`machine_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `appkey` (`appkey`),
  ADD KEY `id_mac` (`machine_id`) USING BTREE;

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD UNIQUE KEY `machine_id` (`id_machine`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`machine_id`),
  ADD UNIQUE KEY `client_appkey` (`client_appkey`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_detail`
--
ALTER TABLE `client_detail`
  MODIFY `client_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `critical_events`
--
ALTER TABLE `critical_events`
  MODIFY `ce_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client_detail` (`client_id`);

--
-- Constraints for table `critical_events`
--
ALTER TABLE `critical_events`
  ADD CONSTRAINT `critical_events_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status` (`type`),
  ADD CONSTRAINT `critical_events_ibfk_2` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`machine_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`machine_id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`appkey`) REFERENCES `clients` (`appkey`);

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`id_machine`) REFERENCES `machines` (`machine_id`);

--
-- Constraints for table `machines`
--
ALTER TABLE `machines`
  ADD CONSTRAINT `machines_ibfk_1` FOREIGN KEY (`client_appkey`) REFERENCES `clients` (`appkey`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

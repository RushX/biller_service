-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2022 at 02:28 PM
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
-- Database: `biller`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE `auth` (
  `uid` bigint(40) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `utype` int(20) NOT NULL,
  `createdby` varchar(100) NOT NULL,
  `status` varchar(40) NOT NULL DEFAULT '"active"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`uid`, `user_name`, `email`, `pass`, `utype`, `createdby`, `status`) VALUES
(16719157803518, 'admin2', 'admin2@biller.com', '$2y$10$YgAwXUFAWY2PD4q81xG.leqsIDvc3OLwDPFF7Dz8.hlERP84jUy3C', 2, '', 'active'),
(167187412933022, 'Super Admin', 'superadmin@biller.com', '$2y$10$tcuSsqKO7o0vf/f/bx6w3ubX1hGsnlV7//6mojxbiX1UsfOf2mJT.', 1, 'Dev', 'active'),
(167191236620671, 'Admin', 'admin@biller.com', '$2y$10$jNUyPc8RaYadTVtjEP8bVuFtr6zFMdwQ8ofVuAvqxGEEXdannI/W2', 2, '167187412933022', 'active'),
(167191256118597, 'Manager', 'manager@biller.com', '$2y$10$hgJvnTZa5/.SP6t4apFBZeFyD3.ZY1Io2gJaLL3cCoVME0wNAUIg2', 3, '167191236620671', 'active'),
(167191346901710, 'USER', 'user@biller.com', '$2y$10$OgH.uvrBl3pka/jg3a/XRuvf0O5zlf6z/p5v08XxqGJRh3XgcnpH2', 4, '167187412933022', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bid` bigint(40) NOT NULL,
  `uid` bigint(40) NOT NULL,
  `date` date NOT NULL,
  `due` date NOT NULL,
  `bill_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`bill_data`)),
  `status` varchar(30) NOT NULL,
  `pay_id` varchar(40) NOT NULL,
  `createdby` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bid`, `uid`, `date`, `due`, `bill_data`, `status`, `pay_id`, `createdby`) VALUES
(167200029794708, 167191346901710, '2022-12-25', '2023-10-10', '{\"address\":{\"house\":\"10/256,Elise Residence\",\"street\":\"Main Street\",\"landmark\":\"Near Marriot Hotel\",\"city\":\"Pune\",\"district\":\"Pune\",\"state\":\"Mahatrashtra\",\"pin\":\"411041\"},\"phone\":\"99999999\",\"email\":\"user@biller.com\",\"username\":\"USER\",\"products_data\":[{\"pid\":\"167195478488442\",\"name\":\"Prod2\",\"quantity\":3,\"info\":\"this is prod 2\",\"price\":\"2000\",\"total\":6000},{\"pid\":\"167195478488442\",\"name\":\"Prod2\",\"quantity\":3,\"info\":\"this is prod 2\",\"price\":\"2000\",\"total\":6000}],\"uid\":\"167191346901710\",\"pretax_amount\":12000,\"cgst\":9,\"sgst\":9,\"final_amount\":12018}', 'unpaid', '', '167187412933022'),
(167205757899675, 167191346901710, '2022-12-26', '2023-10-10', '{\"address\":{\"house\":\"10/256,Elise Residence\",\"street\":\"Main Street\",\"landmark\":\"Near Marriot Hotel\",\"city\":\"Pune\",\"district\":\"Pune\",\"state\":\"Mahatrashtra\",\"pin\":\"411041\"},\"phone\":\"99999999\",\"email\":\"user@biller.com\",\"username\":\"USER\",\"products_data\":[{\"pid\":\"167195478488442\",\"name\":\"Prod2\",\"quantity\":3,\"info\":\"this is prod 2\",\"price\":\"2000\",\"total\":6000},{\"pid\":\"167195478488442\",\"name\":\"Prod2\",\"quantity\":3,\"info\":\"this is prod 2\",\"price\":\"2000\",\"total\":6000}],\"uid\":\"167191346901710\",\"pretax_amount\":12000,\"cgst\":9,\"sgst\":9,\"final_amount\":12018}', 'unpaid', '', '167187412933022');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `mid` bigint(20) NOT NULL,
  `sender` bigint(20) NOT NULL,
  `reciever` bigint(20) NOT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`text`)),
  `priority` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`mid`, `sender`, `reciever`, `text`, `priority`) VALUES
(167191773801022, 167187412933022, 167191236620671, '{\"title\":\"HELLO FROM SA\",\"message\":\"hi admin\"}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `previlages`
--

CREATE TABLE `previlages` (
  `previd` int(11) NOT NULL,
  `uprev` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`uprev`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `previlages`
--

INSERT INTO `previlages` (`previd`, `uprev`) VALUES
(1, '{\r\n  \"can_add\": {\r\n    \"1\": false,\r\n    \"2\": true,\r\n    \"3\": true,\r\n    \"4\": true\r\n  },\r\n  \"can_view\": {\r\n    \"1\": false,\r\n    \"2\": true,\r\n    \"3\": true,\r\n    \"4\": true\r\n  },\r\n  \"can_block\": {\r\n    \"1\": false,\r\n    \"2\": true,\r\n    \"3\": true,\r\n    \"4\": true\r\n  },\r\n  \"can_interact\": {\r\n    \"1\": false,\r\n    \"2\": true,\r\n    \"3\": true,\r\n    \"4\": true\r\n  },\r\n\"products\": true,\r\n\"generate_bill\": true,\r\n\"billing_history\": false,\r\n  \"billing\": true\r\n}'),
(2, '{\r\n  \"can_add\": {\r\n    \"1\": false,\r\n    \"2\": false,\r\n    \"3\": true,\r\n    \"4\": true\r\n  },\r\n  \"can_view\": {\r\n    \"1\": false,\r\n    \"2\": false,\r\n    \"3\": true,\r\n    \"4\": true\r\n  },\r\n  \"can_block\": {\r\n    \"1\": false,\r\n    \"2\": false,\r\n    \"3\": true,\r\n    \"4\": true\r\n  },\r\n  \"can_interact\": {\r\n    \"1\": false,\r\n    \"2\": true,\r\n    \"3\": true,\r\n    \"4\": true\r\n  },\r\n\"products\": true,\r\n\"generate_bill\": true,\r\n\"billing_history\": true,\r\n  \"billing\": true\r\n}'),
(3, '{\r\n  \"can_add\": {\r\n    \"2\": false,\r\n    \"3\": false,\r\n    \"4\": false\r\n  },\r\n  \"can_view\": {\r\n    \"2\": false,\r\n    \"3\": false,\r\n    \"4\": true\r\n  },\r\n  \"can_block\": {\r\n    \"2\": false,\r\n    \"3\": false,\r\n    \"4\": false\r\n  },\r\n  \"can_interact\": {\r\n    \"2\": true,\r\n    \"3\": true,\r\n    \"4\": true\r\n  },\r\n\"products\": false,\r\n\"generate_bill\": false,\r\n\"billing_history\": true,\r\n  \"billing\": true\r\n}'),
(4, '{\r\n  \"can_add\": {\r\n    \"2\": false,\r\n    \"3\": false,\r\n    \"4\": false\r\n  },\r\n  \"can_view\": {\r\n    \"2\": false,\r\n    \"3\": false,\r\n    \"4\": false\r\n  },\r\n  \"can_block\": {\r\n    \"2\": false,\r\n    \"3\": false,\r\n    \"4\": false\r\n  },\r\n  \"can_interact\": {\r\n    \"2\": true,\r\n    \"3\": true,\r\n    \"4\": true\r\n  },\r\n\"products\": false,\r\n\"generate_bill\": false,\r\n\"billing_history\": true,\r\n  \"billing\": true\r\n}');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` bigint(40) NOT NULL,
  `product_name` varchar(40) NOT NULL,
  `pdata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`pdata`)),
  `createdby` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `product_name`, `pdata`, `createdby`) VALUES
(167195478488442, 'Prod2', '{\"name\":\"Prod2\",\"info\":\"this is prod 2\",\"price\":\"2000\"}', '167191236620671'),
(167197623920267, 'Prod3', '{\"name\":\"Prod3\",\"info\":\"This is test 3 product\",\"price\":\"4000\"}', '167187412933022');

-- --------------------------------------------------------

--
-- Table structure for table `udat`
--

CREATE TABLE `udat` (
  `uid` bigint(40) NOT NULL,
  `aadhar_pc` varchar(300) NOT NULL,
  `pan_pc` varchar(300) NOT NULL,
  `aadhar_no` int(12) NOT NULL,
  `pan_no` int(12) NOT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`address`)),
  `phone` bigint(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `udat`
--

INSERT INTO `udat` (`uid`, `aadhar_pc`, `pan_pc`, `aadhar_no`, `pan_no`, `address`, `phone`) VALUES
(167191346901710, 'base64', 'base64', 64, 64, '{\r\n  \"house\": \"10/256,Elise Residence\",\r\n  \"street\": \"Main Street\",\r\n  \"landmark\": \"Near Marriot Hotel\",\r\n  \"city\": \"Pune\",\r\n  \"district\": \"Pune\",\r\n  \"state\": \"Mahatrashtra\",\r\n  \"pin\": \"411041\"\r\n}', 99999999);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `previlages`
--
ALTER TABLE `previlages`
  ADD PRIMARY KEY (`previd`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `udat`
--
ALTER TABLE `udat`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth`
--
ALTER TABLE `auth`
  MODIFY `uid` bigint(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167191346901711;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bid` bigint(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167205757899676;

--
-- AUTO_INCREMENT for table `previlages`
--
ALTER TABLE `previlages`
  MODIFY `previd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` bigint(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167197623920268;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `udat`
--
ALTER TABLE `udat`
  ADD CONSTRAINT `udat_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `auth` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

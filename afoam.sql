-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2020 at 07:04 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `afoam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `first` varchar(20) NOT NULL,
  `last` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first`, `last`) VALUES
(9000, 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `shop_name` varchar(32) NOT NULL,
  `first` varchar(20) NOT NULL,
  `last` varchar(20) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `shop_name`, `first`, `last`, `phone_number`, `active`) VALUES
(7000, 'Tawakal Shop', 'Farah', 'Abdi', '0721445696', 1),
(7001, '8th St Furniture', 'Jamal', 'Ali', '0728366536', 1),
(7002, 'Ayan Shop', 'Ayan', 'Adan', '0721739252', 1),
(7003, 'SahroElmi', 'Sahro', 'Elmi', '0723783000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(6) UNSIGNED ZEROFILL NOT NULL,
  `customer_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `sales_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `is_loan` int(1) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `customer_id`, `sales_id`, `is_loan`, `date`) VALUES
(400000, 7002, 3000, 0, '2020-03-28'),
(400001, 7000, 3000, 0, '2020-01-06');

-- --------------------------------------------------------

--
-- Table structure for table `line_item`
--

CREATE TABLE `line_item` (
  `invoice_id` int(6) UNSIGNED ZEROFILL NOT NULL,
  `mattress_id` int(6) UNSIGNED ZEROFILL NOT NULL,
  `quantity` int(4) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mattress`
--

CREATE TABLE `mattress` (
  `mattress_id` int(6) UNSIGNED ZEROFILL NOT NULL,
  `type` varchar(8) NOT NULL,
  `description` varchar(255) NOT NULL,
  `size` varchar(5) NOT NULL,
  `price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mattress`
--

INSERT INTO `mattress` (`mattress_id`, `type`, `description`, `size`, `price`) VALUES
(100000, 'XL-MDB', 'Extra Large Midnight Blue Mattress', '74x70', '5499.00'),
(100001, 'SM-HD', 'Small Heavy Duty Mattress', '64x60', '2499.00'),
(100002, 'MD-LD', 'Medium Light Duty Mattress', '74x70', '5499.00');

-- --------------------------------------------------------

--
-- Table structure for table `payment_item`
--

CREATE TABLE `payment_item` (
  `invoice_id` int(6) UNSIGNED ZEROFILL NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `first` varchar(20) NOT NULL,
  `last` varchar(20) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `first`, `last`, `phone_number`, `active`) VALUES
(3000, 'Guled', 'Haji', '0723821713', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_ii`
--

CREATE TABLE `sales_ii` (
  `sales_ii_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `first` varchar(20) NOT NULL,
  `last` varchar(20) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_ii`
--

INSERT INTO `sales_ii` (`sales_ii_id`, `first`, `last`, `phone_number`, `active`) VALUES
(5000, 'Aniso', 'Jamac', '+0721832847', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `admin_id` int(4) UNSIGNED ZEROFILL DEFAULT NULL,
  `customer_id` int(4) UNSIGNED ZEROFILL DEFAULT NULL,
  `sales_II_id` int(4) UNSIGNED ZEROFILL DEFAULT NULL,
  `sales_id` int(4) UNSIGNED ZEROFILL DEFAULT NULL,
  `user_type` varchar(20) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `admin_id`, `customer_id`, `sales_II_id`, `sales_id`, `user_type`, `active`) VALUES
('Admin', '4170ac2a2782a1516fe9e13d7322ae482c1bd594', 9000, NULL, NULL, NULL, 'admin', 2),
('AnisoJamac', 'ab874467a7d1ff5fc71a4ade87dc0e098b458aae', NULL, NULL, 5000, NULL, 'salesII', 1),
('Ayan Shop', '501ab5444eae9ad32b562570b36ff628ec3790ce', NULL, 7002, NULL, NULL, 'customer', 1),
('GuledHaji', 'f56d6351aa71cff0debea014d13525e42036187a', NULL, NULL, NULL, 3000, 'sales', 1),
('JamalAli', '501ab5444eae9ad32b562570b36ff628ec3790ce', NULL, 7001, NULL, NULL, 'customer', 1),
('SahroElmi', '501ab5444eae9ad32b562570b36ff628ec3790ce', NULL, 7003, NULL, NULL, 'customer', 1),
('Tawakal2020', '501ab5444eae9ad32b562570b36ff628ec3790ce', NULL, 7000, NULL, NULL, 'customer', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `FK_1` (`customer_id`),
  ADD KEY `FK_2` (`sales_id`);

--
-- Indexes for table `line_item`
--
ALTER TABLE `line_item`
  ADD PRIMARY KEY (`invoice_id`,`mattress_id`,`quantity`) USING BTREE,
  ADD KEY `FOREIGNKEY2` (`mattress_id`);

--
-- Indexes for table `mattress`
--
ALTER TABLE `mattress`
  ADD PRIMARY KEY (`mattress_id`);

--
-- Indexes for table `payment_item`
--
ALTER TABLE `payment_item`
  ADD PRIMARY KEY (`invoice_id`,`payment_amount`,`date`) USING BTREE;

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `sales_ii`
--
ALTER TABLE `sales_ii`
  ADD PRIMARY KEY (`sales_ii_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `FK1` (`admin_id`),
  ADD KEY `FK2` (`customer_id`),
  ADD KEY `FK3` (`sales_II_id`),
  ADD KEY `FK4` (`sales_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7004;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400002;

--
-- AUTO_INCREMENT for table `mattress`
--
ALTER TABLE `mattress`
  MODIFY `mattress_id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100003;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3013;

--
-- AUTO_INCREMENT for table `sales_ii`
--
ALTER TABLE `sales_ii`
  MODIFY `sales_ii_id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5001;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `FK_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_2` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`sales_id`) ON UPDATE CASCADE;

--
-- Constraints for table `line_item`
--
ALTER TABLE `line_item`
  ADD CONSTRAINT `FOREIGNKEY1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FOREIGNKEY2` FOREIGN KEY (`mattress_id`) REFERENCES `mattress` (`mattress_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK3` FOREIGN KEY (`sales_II_id`) REFERENCES `sales_ii` (`sales_ii_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK4` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`sales_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

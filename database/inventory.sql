-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 08, 2023 at 06:45 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `productid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productid`, `name`, `price`, `quantity`) VALUES
(33, 'Soft Drinks', '15.00', 70),
(32, 'Candies', '5.00', 290),
(31, 'Cigarettes', '45.00', 50),
(30, 'Biscuits', '20.00', 188),
(29, 'Soap', '10.00', 150),
(28, 'Shampoo', '30.00', 90),
(27, 'Toothpaste', '15.00', 105),
(26, 'Cooking Oil', '40.00', 30),
(25, 'Rice', '50.00', 50),
(24, 'Canned Sardines', '25.00', 80),
(23, 'Instant Noodles', '12.00', 100),
(34, 'Detergent Powder', '25.00', 40),
(35, 'Coffee Sachets', '8.00', 120),
(36, 'Bottled Water', '10.00', 150),
(37, 'Condiments', '18.00', 70),
(38, 'Canned Goods', '30.00', 50),
(39, 'Batteries', '12.00', 40),
(40, 'Tissue Paper', '8.00', 100),
(41, 'Instant Coffee', '25.00', 60),
(42, 'Chips', '20.00', 80),
(43, 'Bread', '15.00', 60),
(44, 'Eggs', '5.00', 120),
(45, 'Laundry Soap', '20.00', 40),
(46, 'Milk', '25.00', 70),
(47, 'Cup Noodles', '10.00', 90),
(48, 'Cooking Sauce', '18.00', 50),
(49, 'Tuna', '15.00', 80),
(50, 'Chocolates', '12.00', 100),
(51, 'Toilet Paper', '8.00', 75),
(52, 'Bottled Juice', '20.00', 45);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `saleid` int NOT NULL AUTO_INCREMENT,
  `productid` int DEFAULT NULL,
  `quantitysold` int DEFAULT NULL,
  `saledate` date DEFAULT NULL,
  `totalamount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`saleid`),
  KEY `productid` (`productid`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`saleid`, `productid`, `quantitysold`, `saledate`, `totalamount`) VALUES
(90, 27, 15, '2023-12-07', '225.00'),
(89, 30, 12, '2023-12-09', '240.00'),
(88, 31, 10, '2023-12-08', '450.00'),
(86, 33, 10, '2023-12-09', '150.00'),
(87, 32, 10, '2023-12-09', '50.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`) VALUES
(1, 'owner', '$2y$10$fC8Mnm9g3YwZe6/7lszD1Oa21LTufu2XR3MnobppteW7edwpfFlUe');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

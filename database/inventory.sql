-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 05, 2023 at 07:37 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productid`, `name`, `price`, `quantity`) VALUES
(1, 'Product 1', '20.00', 99),
(2, 'Product 2', '30.00', 70),
(3, 'Product 3', '15.00', 120),
(4, 'Product 4', '40.00', 50),
(5, 'Product 5', '10.00', 200),
(6, 'Product 6', '50.00', 26),
(7, 'Product 7', '25.00', 80),
(8, 'Product 8', '10.00', 150),
(9, 'Product 9', '35.00', 60),
(10, 'Product 10', '45.00', 90),
(11, 'Product 11', '100.00', 20);

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`saleid`, `productid`, `quantitysold`, `saledate`, `totalamount`) VALUES
(1, 1, 5, '2023-12-05', '80.00'),
(2, 2, 8, '2023-12-06', '240.00'),
(3, 3, 3, '2023-01-03', '45.00'),
(4, 4, 10, '2023-01-04', '400.00'),
(5, 5, 6, '2023-01-05', '60.00'),
(6, 1, 7, '2023-01-06', '140.00'),
(7, 3, 4, '2023-01-07', '60.00'),
(8, 2, 9, '2023-01-08', '270.00'),
(9, 4, 2, '2023-01-09', '80.00'),
(10, 5, 5, '2023-01-10', '50.00'),
(11, 6, 4, '2023-12-06', '200.00'),
(12, 2, 5, '2023-12-06', '150.00'),
(13, NULL, NULL, NULL, NULL),
(14, 1, 1, '2023-12-06', '20.00');

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
(0, 'user1', 'hashed_and_salted_password1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 17, 2022 at 02:13 PM
-- Server version: 8.0.27
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freelance_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `exchange_rates`
--

DROP TABLE IF EXISTS `exchange_rates`;
CREATE TABLE IF NOT EXISTS `exchange_rates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `from_currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exchange_rates`
--

INSERT INTO `exchange_rates` (`id`, `from_currency`, `to_currency`, `rate`, `created_at`) VALUES
(1, 'GBP', 'USD', 1.30, '2022-07-16 23:08:14'),
(2, 'GBP', 'EUR', 1.10, '2022-07-16 23:10:25'),
(3, 'EUR', 'GBP', 0.90, '2022-07-16 23:10:25'),
(4, 'EUR', 'USD', 1.20, '2022-07-16 23:10:25'),
(5, 'USD', 'GBP', 0.70, '2022-07-16 23:10:25'),
(6, 'USD', 'EUR', 0.80, '2022-07-16 23:10:25');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2020 at 07:29 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `_corehealth_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `nurse_services`
--

CREATE TABLE `nurse_services` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `medical_report_id` int(11) NOT NULL,
  `transaction_id` varchar(20) DEFAULT NULL,
  `file_no` varchar(20) NOT NULL,
  `charge_amount` int(11) NOT NULL,
  `service_description` text NOT NULL,
  `nurse_user_id` int(11) NOT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `payment_date` varchar(30) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nurse_services`
--

INSERT INTO `nurse_services` (`id`, `user_id`, `medical_report_id`, `transaction_id`, `file_no`, `charge_amount`, `service_description`, `nurse_user_id`, `payment_status`, `payment_date`, `visible`, `created_at`, `updated_at`) VALUES
(1, 22, 34, '21', '971212202010', 1500, '<ol>\r\n	<li><br />\r\n	sirenge 300</li>\r\n	<li>coutoo n 500</li>\r\n	<li>labour 500</li>\r\n	<li>hydrogean 200</li>\r\n</ol>', 1, 1, '2020-11-06 13:38:24', 2, '2020-11-04 19:18:50', '2020-11-06 12:38:24'),
(2, 25, 42, '19', '713636202011', 1200, '<ol>\r\n	<li><br />\r\n	Stringe 200</li>\r\n	<li>Coutoon 200</li>\r\n	<li>Hydrogeen 300</li>\r\n	<li>labour 500</li>\r\n</ol>', 1, 0, '2020-11-05 15:22:41', 2, '2020-11-05 14:21:38', '2020-11-05 14:22:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nurse_services`
--
ALTER TABLE `nurse_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nurse_services`
--
ALTER TABLE `nurse_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

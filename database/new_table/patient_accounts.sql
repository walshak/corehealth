-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2020 at 07:26 PM
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
-- Table structure for table `patient_accounts`
--

CREATE TABLE `patient_accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_no` varchar(20) NOT NULL,
  `deposit` int(11) NOT NULL DEFAULT 0,
  `creadit` int(11) NOT NULL DEFAULT 0,
  `credit_b4` int(11) NOT NULL DEFAULT 0,
  `deposite_b4` int(11) NOT NULL DEFAULT 0,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_amount_paid` int(11) NOT NULL,
  `last_payment_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_accounts`
--

INSERT INTO `patient_accounts` (`id`, `user_id`, `file_no`, `deposit`, `creadit`, `credit_b4`, `deposite_b4`, `visible`, `created_at`, `updated_at`, `last_amount_paid`, `last_payment_date`) VALUES
(1, 24, '159466202011', 24000, 0, 0, 18000, 1, '2020-11-05 09:56:41', '2020-11-05 12:59:26', 6000, '2020-11-05 13:59:26'),
(2, 25, '713636202011', 12000, 0, 0, 0, 1, '2020-11-05 14:13:46', '2020-11-05 14:14:56', 6000, '2020-11-05 15:14:56'),
(3, 26, '635136202011', 0, 0, 0, 0, 0, '2020-11-06 15:19:33', '2020-11-06 15:22:37', 0, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patient_accounts`
--
ALTER TABLE `patient_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `file` (`file_no`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `file_2` (`file_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patient_accounts`
--
ALTER TABLE `patient_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

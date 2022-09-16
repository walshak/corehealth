-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 04, 2022 at 02:48 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `id` int(11) NOT NULL,
  `account_type_name` varchar(100) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `application_status`
--

CREATE TABLE `application_status` (
  `id` int(11) UNSIGNED NOT NULL,
  `site_name` varchar(250) DEFAULT NULL,
  `site_abbreviation` text NOT NULL,
  `header_text` varchar(250) DEFAULT NULL,
  `footer_Text` varchar(250) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `favicon` varchar(100) DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `contact_phones` varchar(255) DEFAULT NULL,
  `contact_emails` varchar(50) DEFAULT NULL,
  `social_links` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `version` varchar(100) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `debug_mode` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `allow_piece_sale` tinyint(1) NOT NULL,
  `allow_halve_sale` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `apStartDate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apEndDate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apStatus_id` bigint(20) UNSIGNED DEFAULT NULL,
  `waitTime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `id` int(11) NOT NULL,
  `ward_id` int(3) NOT NULL,
  `bed_name` varchar(100) NOT NULL,
  `describtion` varchar(200) NOT NULL,
  `bed_type` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `apStatus_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bookDate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookReason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reOccurringStatus` tinyint(4) NOT NULL,
  `nextReOccurringDate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `id` int(11) NOT NULL,
  `transaction_id` int(15) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` int(12) NOT NULL,
  `mode_of_payment` int(2) DEFAULT NULL,
  `payment_id` varchar(20) NOT NULL,
  `details` varchar(200) NOT NULL,
  `borrow_date` datetime DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  `user_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `budget_years`
--

CREATE TABLE `budget_years` (
  `id` int(1) NOT NULL,
  `year_name` varchar(10) NOT NULL,
  `closing_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `closed` tinyint(1) NOT NULL,
  `opening_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` int(11) NOT NULL,
  `spending` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `id` int(3) NOT NULL,
  `clinic_name` varchar(200) NOT NULL,
  `clinic_code` char(4) DEFAULT NULL,
  `description` varchar(240) NOT NULL,
  `clinic_note_format` longtext NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `code` varchar(20) NOT NULL,
  `customer_type_id` tinyint(1) NOT NULL,
  `credit_limit` varchar(11) DEFAULT '00',
  `phone` varchar(14) NOT NULL,
  `address` varchar(100) NOT NULL,
  `next_of_kin` varchar(60) DEFAULT NULL,
  `nk_phone` varchar(14) DEFAULT NULL,
  `nk_address` varchar(250) DEFAULT NULL,
  `relationship` int(11) DEFAULT NULL,
  `remark` varchar(250) DEFAULT NULL,
  `totalbuy` varchar(20) DEFAULT '0',
  `tootal_deposite` varchar(20) DEFAULT '0',
  `creadit` varchar(20) DEFAULT '0',
  `deposit` varchar(20) DEFAULT '0',
  `balance` varchar(20) DEFAULT '0',
  `total_borrows` varchar(20) DEFAULT '0',
  `borrow` varchar(20) DEFAULT '0',
  `date_line` date DEFAULT NULL,
  `visible` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `credit_b4` float DEFAULT NULL,
  `deposit_b4` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_budgets`
--

CREATE TABLE `customer_budgets` (
  `id` int(11) NOT NULL,
  `customer_id` int(6) NOT NULL,
  `budget_year_id` int(14) NOT NULL,
  `amount` int(15) NOT NULL,
  `increment` int(11) NOT NULL DEFAULT 0,
  `spending` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_types`
--

CREATE TABLE `customer_types` (
  `id` int(2) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `visible` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daily_expenses`
--

CREATE TABLE `daily_expenses` (
  `id` int(11) NOT NULL,
  `expense_id` varchar(100) NOT NULL,
  `beneficiary` varchar(200) NOT NULL,
  `amount` float NOT NULL,
  `mode_payment` varchar(100) NOT NULL,
  `details` varchar(200) DEFAULT NULL,
  `created_at` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(3) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dependants`
--

CREATE TABLE `dependants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` int(11) NOT NULL,
  `dob` date NOT NULL,
  `genotype` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group_id` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disability` int(11) NOT NULL DEFAULT 0,
  `clinic_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `last_visiting_date` date NOT NULL DEFAULT current_timestamp(),
  `visible` int(11) NOT NULL DEFAULT 1,
  `hmo_id` bigint(20) DEFAULT NULL,
  `hmo_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_id` bigint(20) UNSIGNED NOT NULL,
  `is_admin` tinyint(2) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `specialization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `clinic_id` bigint(20) NOT NULL DEFAULT 1,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_of_birth` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondary_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondary_phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lga_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consultation_fee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` int(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_bookings`
--

CREATE TABLE `doctor_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `booked_by` bigint(20) UNSIGNED DEFAULT NULL,
  `fee` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `paid` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `time` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `transaction_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(2) NOT NULL,
  `expenses_name` varchar(200) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hmos`
--

CREATE TABLE `hmos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inconclusive_medical_reports`
--

CREATE TABLE `inconclusive_medical_reports` (
  `id` int(11) NOT NULL,
  `medical_report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `pharmacy_id` int(11) DEFAULT 0,
  `nurse_id` int(11) DEFAULT 0,
  `pateintDiagnosisReport` text NOT NULL,
  `transaction_no` varchar(20) NOT NULL,
  `nurseContent_status` tinyint(1) NOT NULL,
  `nurseContent` longtext NOT NULL,
  `pharmacy_status` tinyint(4) NOT NULL DEFAULT 0,
  `pharmacy` text NOT NULL,
  `lab_status` tinyint(4) NOT NULL DEFAULT 0,
  `admission_status` tinyint(4) NOT NULL DEFAULT 0,
  `admission` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `report_date` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `initial_stocks`
--

CREATE TABLE `initial_stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(40) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `invoice_date` varchar(10) NOT NULL,
  `number_of_products` int(3) NOT NULL,
  `total_amount` int(14) NOT NULL,
  `visible` int(1) NOT NULL,
  `created_by` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `id` int(4) NOT NULL,
  `lab_name` varchar(100) NOT NULL,
  `description` varchar(240) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lab_services`
--

CREATE TABLE `lab_services` (
  `id` int(6) NOT NULL,
  `lab_id` int(3) NOT NULL,
  `lab_service_name` varchar(200) NOT NULL,
  `description` varchar(240) NOT NULL,
  `price_assing` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `template` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lgas`
--

CREATE TABLE `lgas` (
  `id` int(10) UNSIGNED NOT NULL,
  `state_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL DEFAULT '',
  `status_id` int(4) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `medical_reports`
--

CREATE TABLE `medical_reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dependant_id` bigint(20) DEFAULT NULL,
  `doctor_id` int(11) NOT NULL,
  `pharmacy_id` int(11) DEFAULT 0,
  `nurse_id` int(11) DEFAULT 0,
  `pateintDiagnosisReport` longtext DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `transaction_no` varchar(20) DEFAULT NULL,
  `nurseContent_status` tinyint(1) DEFAULT NULL,
  `nurseContent` longtext DEFAULT NULL,
  `pharmacy_status` tinyint(4) NOT NULL DEFAULT 0,
  `pharmacy` text DEFAULT NULL,
  `lab_status` tinyint(4) NOT NULL DEFAULT 0,
  `admission_status` tinyint(4) NOT NULL DEFAULT 0,
  `admission` tinyint(1) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  `discharge` tinyint(2) DEFAULT 0,
  `bed_assigned` int(11) DEFAULT 0,
  `ward_id` int(11) DEFAULT NULL,
  `bed_id` int(11) DEFAULT NULL,
  `dischargeChannel` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mode_of_payments`
--

CREATE TABLE `mode_of_payments` (
  `id` tinyint(2) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `navigations`
--

CREATE TABLE `navigations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `position` int(11) NOT NULL,
  `has_sub_nav` int(11) NOT NULL,
  `navigation_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `visible` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `icon` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `itype` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `latest_news` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_line` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `published` int(11) NOT NULL,
  `has_image` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `level` int(2) NOT NULL,
  `visible` int(11) NOT NULL,
  `archived` int(11) NOT NULL,
  `archived_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `verified` int(11) NOT NULL,
  `verified_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `verified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` int(11) NOT NULL,
  `deleted_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `next_of_kings`
--

CREATE TABLE `next_of_kings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(240) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `norminal_roll`
--

CREATE TABLE `norminal_roll` (
  `id` int(11) NOT NULL,
  `ap_number` varchar(10) DEFAULT NULL,
  `surname` varchar(30) DEFAULT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `othername` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `status_id` int(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nurse_services`
--

CREATE TABLE `nurse_services` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `medical_report_id` int(11) DEFAULT NULL,
  `transaction_id` varchar(20) DEFAULT NULL,
  `file_no` varchar(20) DEFAULT NULL,
  `charge_amount` int(11) NOT NULL,
  `service_description` text NOT NULL,
  `nurse_user_id` int(11) NOT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `payment_date` varchar(30) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nursing_notes`
--

CREATE TABLE `nursing_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `dependant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `nursing_note_type_id` smallint(5) UNSIGNED NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nursing_notes`
--

INSERT INTO `nursing_notes` (`id`, `patient_id`, `dependant_id`, `created_by`, `nursing_note_type_id`, `note`, `completed`, `status`, `created_at`, `updated_at`) VALUES
(1, 23, NULL, 58, 1, '<div contenteditable=\"true\" style=\"border: 1px solid black; min-height: 200px; min-width: 100%;\" spellcheck=\"false\">jfjfjfjf</div>', 1, 0, '2022-08-29 14:56:08', '2022-08-29 16:08:17'),
(2, 23, NULL, 58, 3, '<div contenteditable=\"false\" style=\"border: 1px solid gray; min-height: 200px; min-width: 100%;\" spellcheck=\"false\">jfjfjfbbsbs<div>nvnnnv</div></div>', 1, 0, '2022-08-29 15:05:08', '2022-08-29 16:18:32'),
(3, 23, NULL, 58, 4, '<div contenteditable=\"false\" style=\"border: 1px solid gray; min-height: 200px; min-width: 100%;\" spellcheck=\"false\">hfhfhf<div><br></div><div><br></div><div><br></div><div>dbdnndnd</div></div>', 1, 0, '2022-08-29 15:05:26', '2022-09-01 10:38:13'),
(4, 23, NULL, 58, 1, '<div contenteditable=\"true\" style=\"border: 1px solid black; min-height: 200px; min-width: 100%;\" spellcheck=\"false\">dhfhfd</div>', 1, 0, '2022-08-29 16:15:04', '2022-08-29 16:15:10'),
(5, 23, NULL, 58, 1, '<div contenteditable=\"false\" style=\"border: 1px solid gray; min-height: 200px; min-width: 100%;\" spellcheck=\"false\">hfhfhfdoioerro</div>', 1, 0, '2022-08-29 16:17:00', '2022-08-29 16:17:08');

-- --------------------------------------------------------

--
-- Table structure for table `nursing_note_types`
--

CREATE TABLE `nursing_note_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nursing_note_types`
--

INSERT INTO `nursing_note_types` (`id`, `name`, `template`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Observation Chart', '<table class=\"table\">\n    <thead>\n        <tr>\n            <b>Observation Chart</b>\n        </tr>\n        <tr>\n            <th>Date</th>\n            <th>Time</th>\n            <th>Temp.</th>\n            <th>Pulse</th>\n            <th>Resp.</th>\n            <th>B.P</th>\n            <th>Sign</th>\n        </tr>\n    </thead>\n    <tbody>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 90px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n    </tbody>\n</table>', 1, '2022-08-29 08:51:21', '2022-09-01 11:49:50');
INSERT INTO `nursing_note_types` (`id`, `name`, `template`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Treatment Sheet', '<table class=\"table table-sm\">\n    <th>Treatment Sheet</th>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <th style=\"border-top:2px solid black;\" colspan=\"9\">Name Of Drug <br>\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </th>\n    </tr>\n    <tr>\n        <td></td>\n        <th>Date</th>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr>\n        <th>Dose</th>\n        <th>Time</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n        <th>Intials</th>\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            Start\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            9:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Route Frequency</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            12:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            6:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\" rowspan=\"3\">\n            <b>Special Remarks</b><br>\n            <span style=\"border:1px solid black; min-width: 125px; min-height: 80px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            9:00 PM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        <td contenteditable=\"false\">\n            12:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr>\n        \n        <td contenteditable=\"false\">\n            3:00 AM\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n</table>', 1, '2022-08-29 08:51:21', '2022-09-01 12:58:40');
INSERT INTO `nursing_note_types` (`id`, `name`, `template`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Intake/Output Chart', '<table class=\"table table-sm\">\n    <tr>\n        <th colspan=\"8\">Intake / Output Chart</th>\n    </tr>\n    <tr>\n        <th colspan=\"4\">\n            Intake\n        </th>\n        <th colspan=\"4\">\n            Output\n        </th>\n    </tr>\n    <tr>\n        <th>Date</th>\n        <th>Time</th>\n        <th>Intake</th>\n        <th>Amount</th>\n        <th>Date</th>\n        <th>Time</th>\n        <th>Intake</th>\n        <th>Amount</th>\n    </tr>\n    <tbody>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n        <tr>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n            <td contenteditable=\"false\">\n                <span style=\"border:1px solid black; min-width: 80px; min-height: 25px; display:inline-block;\"\n                    contenteditable=\"true\"></span>\n            </td>\n        </tr>\n    </tbody>\n\n</table>', 1, '2022-08-29 08:52:11', '2022-09-01 13:26:59');
INSERT INTO `nursing_note_types` (`id`, `name`, `template`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Labour Records', '<table class=\"table\">\n    <th>\n        <h3>Labour Notes</h3>\n    </th>\n    <tr>\n        <td contenteditable=\"false\">\n            <h3 contenteditable=\"false\">Past obstetric history &nbsp; &nbsp; <button type=\"button\"\n                    class=\"btn btn-secondary\" onclick=\"toggle_group(\'gr22\')\">Click to expand</button></h3>\n        </td>\n    </tr>\n    <tr class=\"gr22\" style=\"display: none;\">\n        <td contenteditable=\"false\">General</td>\n        <td contenteditable=\"false\"><span\n                style=\"border:1px solid black; min-width: 300px; min-height: 100px; display:inline-block;\"\n                contenteditable=\"true\"></span></td>\n    </tr>\n    <tr class=\"gr22\" style=\"display: none;\">\n        <td contenteditable=\"false\">LMP </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 100px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>EDD</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 100px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    <tr class=\"gr22\" style=\"display: none;\">\n        <td contenteditable=\"false\">Antenatal history</td>\n        <td contenteditable=\"false\"><span\n                style=\"border:1px solid black; min-width: 300px; min-height: 100px; display:inline-block;\"\n                contenteditable=\"true\"></span></td>\n    </tr>\n    </tr>\n\n    <tr>\n        <td contenteditable=\"false\">\n            <h3 contenteditable=\"false\">Labour &nbsp; &nbsp; <button type=\"button\" class=\"btn btn-secondary\"\n                    onclick=\"toggle_group(\'gr23\')\">Click to expand</button></h3>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">Onset </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Hours</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">Spontaneous (Y/N) </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Induced (Y/N)</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">Membranes raptured at (Hour)</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Aminiotomy (Y/N)</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">General Condition (Excellent/ Good/ Fair/ Poor)</td>\n        <td contenteditable=\"false\" colspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">Abdominal Height</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Type (Multiple/ Singleton)</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">Lie</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Presentation</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">Position</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Decent (fifths)</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">Foetal Heart Rate(Minute)</td>\n        <td contenteditable=\"false\" colspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">P.V</td>\n        <td contenteditable=\"false\">Vulva</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Vagina</td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">Cervix (% effaced)</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Well/ Loosely applied to P.P</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">(cm dilated)</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Membranes ruptured</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">\n        <td contenteditable=\"false\">\n        </td>\n        <td>Intact</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">P.P at (Station)</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Position</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">CAPUT</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Moulding</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">PELVS</td>\n        <td contenteditable=\"false\">S.P (Cms)</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Sacral curve</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr23\" style=\"display: none;\">\n        <td contenteditable=\"false\">Forcast</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Ischial Spine </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n\n    <tr>\n        <td contenteditable=\"false\">\n            <h3 contenteditable=\"false\">Charts &nbsp; &nbsp; <button type=\"button\" class=\"btn btn-secondary\"\n                    onclick=\"toggle_group(\'gr24\')\">Click to expand</button></h3>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">\n            <h3 contenteditable=\"false\">Cervical dilation in CMS</h3>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">00hrs </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>01hrs</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">02hrs </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>03hrs</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">04hrs </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>05hrs</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">06hrs </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>07hrs</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">08hrs </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>09hrs</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">10hrs </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>11hrs</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">12hrs </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>13hrs</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">14hrs </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>15hrs</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">16hrs </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>17hrs</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr24\" style=\"display: none;\">\n        <td contenteditable=\"false\">18hrs </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>19hrs</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n\n    <tr>\n        <td contenteditable=\"false\">\n            <h3 contenteditable=\"false\">Summary of Labour &nbsp; &nbsp; <button type=\"button\" class=\"btn btn-secondary\"\n                    onclick=\"toggle_group(\'gr25\')\">Click to expand</button></h3>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\" colspan=\"2\"><h5>Induction of labour</h5> <br>\n            (Aminiotomy/ Oxytocin/ Prostaglandins/ Misoprosol)\n        </td>\n        <td contenteditable=\"false\" colspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\" colspan=\"2\">Induction</td>\n        <td contenteditable=\"false\" colspan=\"2\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Onset Of Labour/Induction-Internal(Hours)</td>\n        <td contenteditable=\"false\" colspan=\"3\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\"><h5>Method of Delivery(Fetus / Fetuses)</h5></td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td>Time/ Date of Delivery</td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\"><b>Cephalic presenation</b> <br>\n            (Spontaneous/ Force/ Vacum)\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\"><b>Breech Presentation</b><br>\n            (Assisted/ Extraction/ Internal Podalicversion)\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\"><b>Method of Delivery</b>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Ceasarean Section(Emergency/Elective)\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Embrayotomy(Specify)\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Anaesthesia\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\"><b>Placeta & Membranes</b>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Spontaneous\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n        <td contenteditable=\"false\">Fundal Pressure\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n        <td contenteditable=\"false\">Complete\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">\n        </td>\n        <td contenteditable=\"false\">C.C.T\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n        <td contenteditable=\"false\">Manual Removal\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n        <td contenteditable=\"false\">Incomplete\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">\n            <b>Perineum</b>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Intact\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n        <td contenteditable=\"false\">1st Degree Laceration\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">2nd Degree Laceration\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">3rd Degree Laceration\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">EPISIOTOMY\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">No. Of skin SUTURES\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Blood Loss in ml\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Treatment\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 300px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\"><b>Infant(s)</b>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Alive\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">Sex(es)\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">AGPR SCORE(1 min)\n            <br>AGPR SCORE(5 min)\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n                <br>\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Fresh S.B\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Macerated S.B\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">Weight(s)\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">Treatment\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Immediate NND\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">Malformation\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 50px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\"><b>Mother\'s Condition - One Hour Post-Partum</b>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Uterus\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">Bladder\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">B.P\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Palse\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">Temp.\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n        <td contenteditable=\"false\">Resp.\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 150px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Accoucheur <br> \n            (Pupil Midwife, Student, Staff midwife, Staff Midwife, Consultant, etc...)\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n    <tr class=\"gr25\" style=\"display: none;\">\n        <td contenteditable=\"false\">Supervisor\n        </td>\n        <td contenteditable=\"false\">\n            <span style=\"border:1px solid black; min-width: 200px; min-height: 25px; display:inline-block;\"\n                contenteditable=\"true\"></span>\n        </td>\n    </tr>\n</table>', 1, '2022-08-29 08:52:11', '2022-09-01 11:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `s1` int(2) NOT NULL,
  `category` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extra` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `visible` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publish` int(11) NOT NULL,
  `publisher_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `published_date` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_no` varchar(20) NOT NULL,
  `clinic_id` int(3) NOT NULL,
  `gender` char(1) DEFAULT NULL,
  `dob` char(10) DEFAULT NULL,
  `genotype` varchar(3) DEFAULT NULL,
  `blood_group_id` varchar(3) DEFAULT NULL,
  `hieght` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `disability` tinyint(1) DEFAULT NULL,
  `current_service_status` tinyint(1) DEFAULT NULL,
  `dieses_id` int(3) DEFAULT NULL,
  `account_type_id` tinyint(1) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `nationality` int(4) DEFAULT NULL,
  `lga` int(9) DEFAULT NULL,
  `province` varchar(220) DEFAULT NULL,
  `last_visiting_date` date DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `hmo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `hmo_no` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `patient_assign_beds`
--

CREATE TABLE `patient_assign_beds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_user_id` bigint(20) UNSIGNED NOT NULL,
  `medical_report_id` bigint(20) UNSIGNED NOT NULL,
  `ward_id` bigint(20) UNSIGNED NOT NULL,
  `bed_id` bigint(20) UNSIGNED NOT NULL,
  `bedCharges` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `numberDays` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `disChargeDate` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amountPaid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` int(11) NOT NULL,
  `partPayment` tinyint(1) NOT NULL,
  `discountPayment` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_lab_services`
--

CREATE TABLE `patient_lab_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dependant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lab_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `medical_report_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lab_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lab_service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_status` int(11) DEFAULT NULL,
  `transaction_id` bigint(20) DEFAULT NULL,
  `payment_date` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `sampeTaken` tinyint(1) DEFAULT NULL,
  `sampeDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sample_taken_by` int(11) DEFAULT NULL,
  `resultReport` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultReport_by` int(11) DEFAULT NULL,
  `resultDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `clinic_id` tinyint(4) NOT NULL,
  `registrationNo` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referenceNo` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderId` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_paid` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expected_amount` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rrr` int(12) DEFAULT NULL,
  `IsPaid` tinyint(1) DEFAULT NULL,
  `transaction_message` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_code` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type_id` tinyint(4) DEFAULT NULL,
  `payment_mode` int(3) NOT NULL,
  `status_id` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_items`
--

CREATE TABLE `payment_items` (
  `id` int(3) NOT NULL,
  `payment_type_id` int(4) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `description` varchar(240) NOT NULL,
  `amount` varchar(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` int(4) NOT NULL,
  `payment_type_name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pr_buy_price` int(11) NOT NULL,
  `initial_sale_price` int(8) NOT NULL,
  `initial_sale_date` text NOT NULL,
  `current_sale_price` float NOT NULL,
  `half_price` int(8) DEFAULT 0,
  `pieces_price` int(7) NOT NULL DEFAULT 0,
  `pieces_max_discount` int(6) NOT NULL DEFAULT 0,
  `current_sale_date` text NOT NULL,
  `max_discount` float NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `user_id` int(6) NOT NULL,
  `category_id` int(2) DEFAULT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_code` varchar(11) NOT NULL,
  `reorder_alert` int(5) NOT NULL,
  `has_have` tinyint(1) DEFAULT NULL,
  `has_piece` tinyint(1) DEFAULT NULL,
  `howmany_to` int(4) DEFAULT NULL,
  `current_quantity` int(11) NOT NULL DEFAULT 0,
  `visible` tinyint(1) NOT NULL,
  `stock_assign` tinyint(1) NOT NULL DEFAULT 0,
  `price_assign` tinyint(1) NOT NULL DEFAULT 0,
  `promotion` tinyint(1) NOT NULL DEFAULT 0,
  `1` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `promotion_name` varchar(200) NOT NULL,
  `quantity_to_buy` int(8) NOT NULL,
  `quantity_to_give` int(8) NOT NULL,
  `promotion_total_quantity` int(8) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `visible` tinyint(1) NOT NULL,
  `current_qt` int(11) NOT NULL,
  `give_qt` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promo_sales`
--

CREATE TABLE `promo_sales` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `quantity_buy` int(8) NOT NULL,
  `quantity_give` int(8) NOT NULL,
  `total_amount` int(8) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `requisitions`
--

CREATE TABLE `requisitions` (
  `id` int(15) NOT NULL,
  `customer_id` int(6) NOT NULL,
  `transaction_no` varchar(30) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `request_date` varchar(30) NOT NULL,
  `aprove_date` varchar(30) NOT NULL,
  `request_user_id` int(6) NOT NULL,
  `approve_user_id` int(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `requisitions_requests`
--

CREATE TABLE `requisitions_requests` (
  `id` int(15) NOT NULL,
  `product_id` int(11) NOT NULL,
  `requisition_id` int(15) NOT NULL,
  `price` int(9) NOT NULL,
  `quantity` int(6) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `budget_year_id` int(11) NOT NULL,
  `serial_no` varchar(50) DEFAULT NULL,
  `quantity_buy` int(11) NOT NULL,
  `sale_price` float NOT NULL,
  `pieces_quantity` int(11) DEFAULT NULL,
  `pieces_sales_price` int(11) DEFAULT NULL,
  `total_amount` text NOT NULL,
  `store_id` int(2) NOT NULL,
  `promo_qt` int(11) DEFAULT NULL,
  `gain` float NOT NULL,
  `lost` float NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `supply` tinyint(4) NOT NULL,
  `supply_date` varchar(10) NOT NULL DEFAULT '0000-00-00',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `secret_questions`
--

CREATE TABLE `secret_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visible` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_images`
--

CREATE TABLE `site_images` (
  `id` int(10) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `owner_flag_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `is_featured` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT '',
  `status_id` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT '',
  `status_id` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visible` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_categories`
--

CREATE TABLE `status_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visible` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `initial_quantity` int(11) DEFAULT NULL,
  `order_quantity` int(11) DEFAULT NULL,
  `current_quantity` int(11) DEFAULT NULL,
  `quantity_sale` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_ledges`
--

CREATE TABLE `stock_ledges` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ledge_date` varchar(12) NOT NULL,
  `in_coming` int(11) NOT NULL,
  `out_goin` int(11) NOT NULL,
  `Balance` int(11) NOT NULL,
  `initial_balance` int(11) NOT NULL,
  `user_id` int(6) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_orders`
--

CREATE TABLE `stock_orders` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_quantity` int(6) NOT NULL,
  `total_amount` float NOT NULL,
  `store_id` int(2) NOT NULL,
  `stock_date` varchar(20) NOT NULL DEFAULT '0000-00-00',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(2) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `store_stokes`
--

CREATE TABLE `store_stokes` (
  `id` int(11) NOT NULL,
  `store_id` int(2) NOT NULL,
  `product_id` int(6) NOT NULL,
  `initial_quantity` int(11) NOT NULL,
  `quantity_sale` int(11) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `current_quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_navigations`
--

CREATE TABLE `sub_navigations` (
  `id` int(10) UNSIGNED NOT NULL,
  `navigations_id` int(11) NOT NULL,
  `has_children` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `visible` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_by` int(3) NOT NULL,
  `last_payment` int(14) DEFAULT NULL,
  `last_payment_date` timestamp NULL DEFAULT current_timestamp(),
  `last_buy_date` timestamp NULL DEFAULT current_timestamp(),
  `last_buy_amount` int(14) DEFAULT NULL,
  `credit_b4` int(14) DEFAULT NULL,
  `credit` int(14) DEFAULT NULL,
  `deposit_b4` float DEFAULT NULL,
  `deposit` int(14) DEFAULT NULL,
  `tootal_deposite` float DEFAULT NULL,
  `date_line` timestamp NULL DEFAULT current_timestamp(),
  `visible` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supply_and_payments`
--

CREATE TABLE `supply_and_payments` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(20) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supply_amount` int(14) DEFAULT NULL,
  `invoice_no` varchar(20) DEFAULT NULL,
  `pay_amount` int(14) DEFAULT NULL,
  `deposit_b4` float DEFAULT NULL,
  `credit_b4` float DEFAULT NULL,
  `mode_of_payment_id` int(2) DEFAULT NULL,
  `transaction_date` timestamp NULL DEFAULT current_timestamp(),
  `details` text DEFAULT NULL,
  `staff_id` int(4) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `status_id` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_no` varchar(100) NOT NULL,
  `budget_year_id` int(11) NOT NULL,
  `supply` tinyint(1) NOT NULL,
  `transaction_type` varchar(30) NOT NULL,
  `customer_name` varchar(60) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `gender` varchar(7) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `amount_paid` int(11) DEFAULT NULL,
  `hmo_id` int(11) DEFAULT NULL,
  `deposit_b4` varchar(20) DEFAULT NULL,
  `credit_b4` varchar(20) DEFAULT NULL,
  `current_deposit` varchar(20) DEFAULT NULL,
  `current_credit` varchar(20) DEFAULT NULL,
  `customer_type_id` tinyint(1) NOT NULL,
  `mode_of_payment_id` int(2) NOT NULL,
  `bank_transaction_payment_id` varchar(30) DEFAULT NULL,
  `store_id` int(2) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_transaction_id` varchar(50) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `tr_date` varchar(20) NOT NULL,
  `tr_year` varchar(20) NOT NULL,
  `visible` int(1) NOT NULL DEFAULT 1,
  `supply_date` varchar(10) NOT NULL DEFAULT '0000-00-00',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `is_admin` int(11) DEFAULT NULL,
  `customer_id` int(6) DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_records` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `othername` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suspended` int(1) DEFAULT NULL,
  `visible` int(1) DEFAULT NULL,
  `assignRole` int(1) NOT NULL,
  `assignPermission` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vital_signs`
--

CREATE TABLE `vital_signs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dependant_id` bigint(20) DEFAULT NULL COMMENT 'if this is not null, it will imply that the vitalsign belongs to a dependant rather than the principal',
  `receptionist_id` bigint(20) UNSIGNED NOT NULL,
  `nurse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `medical_report_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `temperature` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bloodPressure` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `VitalSignReport` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(2) NOT NULL,
  `paymentVisibility` tinyint(2) NOT NULL,
  `dateProccessed` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wards`
--

CREATE TABLE `wards` (
  `id` int(3) NOT NULL,
  `clinic_id` int(3) DEFAULT NULL,
  `description` varchar(240) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `price_assing` tinyint(1) NOT NULL,
  `bed_assing` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ward_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ward_notes`
--

CREATE TABLE `ward_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `dependant_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_status`
--
ALTER TABLE `application_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_years`
--
ALTER TABLE `budget_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_budgets`
--
ALTER TABLE `customer_budgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_types`
--
ALTER TABLE `customer_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_expenses`
--
ALTER TABLE `daily_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dependants`
--
ALTER TABLE `dependants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctors_secondary_email_unique` (`secondary_email`),
  ADD UNIQUE KEY `doctors_secondary_phone_number_unique` (`secondary_phone_number`);

--
-- Indexes for table `doctor_bookings`
--
ALTER TABLE `doctor_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_bookings_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hmos`
--
ALTER TABLE `hmos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inconclusive_medical_reports`
--
ALTER TABLE `inconclusive_medical_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_report_id` (`medical_report_id`);

--
-- Indexes for table `initial_stocks`
--
ALTER TABLE `initial_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`invoice_no`);

--
-- Indexes for table `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_services`
--
ALTER TABLE `lab_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lgas`
--
ALTER TABLE `lgas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `medical_reports`
--
ALTER TABLE `medical_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `mode_of_payments`
--
ALTER TABLE `mode_of_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigations`
--
ALTER TABLE `navigations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_title_index` (`title`),
  ADD KEY `news_display_line_index` (`display_line`);

--
-- Indexes for table `next_of_kings`
--
ALTER TABLE `next_of_kings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `norminal_roll`
--
ALTER TABLE `norminal_roll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `nurse_services`
--
ALTER TABLE `nurse_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nursing_notes`
--
ALTER TABLE `nursing_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nursing_note_types`
--
ALTER TABLE `nursing_note_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_no` (`file_no`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `patients_hmo_id_foreign` (`hmo_id`);

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
-- Indexes for table `patient_assign_beds`
--
ALTER TABLE `patient_assign_beds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_lab_services`
--
ALTER TABLE `patient_lab_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_items`
--
ALTER TABLE `payment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_type_id` (`payment_type_id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo_sales`
--
ALTER TABLE `promo_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requisitions`
--
ALTER TABLE `requisitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requisitions_requests`
--
ALTER TABLE `requisitions_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secret_questions`
--
ALTER TABLE `secret_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_images`
--
ALTER TABLE `site_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_categories`
--
ALTER TABLE `status_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_ledges`
--
ALTER TABLE `stock_ledges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stock_orders`
--
ALTER TABLE `stock_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_stokes`
--
ALTER TABLE `store_stokes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_navigations`
--
ALTER TABLE `sub_navigations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supply_and_payments`
--
ALTER TABLE `supply_and_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vital_signs`
--
ALTER TABLE `vital_signs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ward_notes`
--
ALTER TABLE `ward_notes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_status`
--
ALTER TABLE `application_status`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_years`
--
ALTER TABLE `budget_years`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_budgets`
--
ALTER TABLE `customer_budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_types`
--
ALTER TABLE `customer_types`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_expenses`
--
ALTER TABLE `daily_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dependants`
--
ALTER TABLE `dependants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_bookings`
--
ALTER TABLE `doctor_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hmos`
--
ALTER TABLE `hmos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inconclusive_medical_reports`
--
ALTER TABLE `inconclusive_medical_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `initial_stocks`
--
ALTER TABLE `initial_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labs`
--
ALTER TABLE `labs`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_services`
--
ALTER TABLE `lab_services`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lgas`
--
ALTER TABLE `lgas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_reports`
--
ALTER TABLE `medical_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mode_of_payments`
--
ALTER TABLE `mode_of_payments`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `navigations`
--
ALTER TABLE `navigations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `next_of_kings`
--
ALTER TABLE `next_of_kings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `norminal_roll`
--
ALTER TABLE `norminal_roll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nurse_services`
--
ALTER TABLE `nurse_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nursing_notes`
--
ALTER TABLE `nursing_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nursing_note_types`
--
ALTER TABLE `nursing_note_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_accounts`
--
ALTER TABLE `patient_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_assign_beds`
--
ALTER TABLE `patient_assign_beds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_lab_services`
--
ALTER TABLE `patient_lab_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_items`
--
ALTER TABLE `payment_items`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promo_sales`
--
ALTER TABLE `promo_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requisitions`
--
ALTER TABLE `requisitions`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requisitions_requests`
--
ALTER TABLE `requisitions_requests`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `secret_questions`
--
ALTER TABLE `secret_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_images`
--
ALTER TABLE `site_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_categories`
--
ALTER TABLE `status_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_ledges`
--
ALTER TABLE `stock_ledges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_orders`
--
ALTER TABLE `stock_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_stokes`
--
ALTER TABLE `store_stokes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_navigations`
--
ALTER TABLE `sub_navigations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_and_payments`
--
ALTER TABLE `supply_and_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vital_signs`
--
ALTER TABLE `vital_signs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wards`
--
ALTER TABLE `wards`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ward_notes`
--
ALTER TABLE `ward_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

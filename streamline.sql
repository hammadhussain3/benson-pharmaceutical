-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 28, 2024 at 01:00 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `streamline`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `acronym` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint UNSIGNED NOT NULL,
  `batch_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `mfg_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `batch_no`, `batch_size`, `product_id`, `mfg_date`, `exp_date`, `status`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'T12356', '100', 4, '2024-11-01', '2026-11-01', 'inprocess', 1, 1, NULL, '2024-11-20 03:53:37', '2024-11-20 03:53:37'),
(4, 'T12357', '100', 4, '2024-11-01', '2026-11-01', 'inprocess', 1, 1, NULL, '2024-11-28 04:33:50', '2024-11-28 04:33:50');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `city_id` bigint UNSIGNED NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `company_id`, `name`, `address`, `country_id`, `city_id`, `phone`, `email`, `contact_person_name`, `contact_person_phone`, `contact_person_email`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Korangi Branch 1', 'Address-1', 1, 1, '+922134567890', NULL, NULL, NULL, NULL, 1, 1, NULL, '2024-11-06 03:33:05', '2024-11-06 03:33:05'),
(2, 1, 'Korangi Branch 2', 'Address-2', 1, 2, '+922134567890', NULL, NULL, NULL, NULL, 1, 1, 1, '2024-11-06 03:35:31', '2024-11-06 03:38:26'),
(3, 2, 'Industrial Area Branch 1', 'Address-3', 1, 1, '+92529466282', NULL, NULL, NULL, NULL, 1, 1, NULL, '2024-11-06 03:36:26', '2024-11-06 03:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `prefix`, `description`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Chemicals', 'CH', 'Test', 1, 1, NULL, '2024-11-09 03:27:48', '2024-11-09 03:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_accounts`
--

CREATE TABLE `chart_of_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `particular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `open_debit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `open_credit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `act_debit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `act_credit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `cl_debit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `cl_credit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `budget` decimal(15,2) NOT NULL DEFAULT '0.00',
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chart_of_accounts`
--

INSERT INTO `chart_of_accounts` (`id`, `code`, `particular`, `abbreviation`, `open_debit`, `open_credit`, `act_debit`, `act_credit`, `cl_debit`, `cl_credit`, `budget`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'COA00001', 'Rejected Items', 'RI', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 1, 1, '2024-12-02 07:01:30', '2024-12-02 07:03:24'),
(2, 'COA00002', 'Sale Items', 'SI', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 1, NULL, '2024-12-19 06:02:35', '2024-12-19 06:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `country_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Karachi', 1, 1, NULL, '2024-11-06 03:05:26', '2024-11-06 03:05:26'),
(2, 'Isalamabad', 1, 1, NULL, '2024-11-06 03:05:59', '2024-11-06 03:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `city_id` bigint UNSIGNED NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ntn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `logo_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `country_id`, `city_id`, `phone`, `email`, `website`, `ntn`, `strn`, `is_active`, `logo_path`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Company 1', 'Address-1', 1, 1, '+922134567890', 'company@example.com', NULL, NULL, NULL, 1, 'company_1730880472.jpg', 1, 1, '2024-11-06 03:07:03', '2024-11-06 03:07:52'),
(2, 'Company 2', 'Address-2', 1, 2, '+922134567890', 'company@example.com', NULL, NULL, NULL, 1, 'company_1730880721.jpg', 1, NULL, '2024-11-06 03:12:01', '2024-11-06 03:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `currency`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Pakistan', 'PKR', 1, 1, '2024-11-06 03:05:06', '2024-12-05 04:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `credit_notes`
--

CREATE TABLE `credit_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `credit_notes`
--

INSERT INTO `credit_notes` (`id`, `code`, `party_id`, `description`, `total`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'CN00001', 1, 'Checking', '100.00', 1, 1, NULL, '2024-12-19 06:03:47', '2024-12-19 06:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `credit_note_items`
--

CREATE TABLE `credit_note_items` (
  `id` bigint UNSIGNED NOT NULL,
  `credit_note_id` bigint UNSIGNED NOT NULL,
  `chart_of_account_id` bigint UNSIGNED NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `credit_note_items`
--

INSERT INTO `credit_note_items` (`id`, `credit_note_id`, `chart_of_account_id`, `debit`, `credit`, `created_at`, `updated_at`) VALUES
(3, 2, 2, '0.00', '100.00', '2024-12-19 06:03:47', '2024-12-19 06:03:47'),
(4, 2, 2, '100.00', '0.00', '2024-12-19 06:03:47', '2024-12-19 06:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `company_id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `company_id`, `branch_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Human Resources', 'Test', 1, 1, 1, NULL, '2024-11-06 03:37:29', '2024-11-06 03:37:29'),
(2, 'Accounts', 'Test', 1, 1, 1, NULL, '2024-11-06 03:39:10', '2024-11-06 03:39:10'),
(3, 'Procurement', 'Test', 1, 2, 1, NULL, '2024-11-06 03:39:43', '2024-11-06 03:39:43'),
(4, 'Human Resources', 'Test', 2, 3, 1, NULL, '2024-11-06 03:40:26', '2024-11-06 03:40:26'),
(5, 'Production', 'Test', 1, 1, 1, NULL, '2024-11-26 06:26:11', '2024-11-26 06:26:11');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'CO', 1, 1, NULL, '2024-11-06 03:41:05', '2024-11-06 03:41:05'),
(2, 'Company Manager', 1, 1, NULL, '2024-11-06 03:41:32', '2024-11-06 03:41:32'),
(3, 'Manager', 2, 1, NULL, '2024-11-06 03:44:01', '2024-11-06 03:44:01'),
(4, 'Asst. Manager', 2, 1, NULL, '2024-11-06 03:44:17', '2024-11-06 03:44:17'),
(5, 'Manager', 1, 2, NULL, '2024-11-06 04:19:31', '2024-11-06 04:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `dosage_forms`
--

CREATE TABLE `dosage_forms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosage_forms`
--

INSERT INTO `dosage_forms` (`id`, `name`, `description`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'Capsules', 'Test', 1, 1, NULL, '2024-11-09 03:42:25', '2024-11-09 03:42:25'),
(4, 'Tablets', 'Test', 1, 1, NULL, '2024-11-14 06:26:47', '2024-11-14 06:26:47');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `basic_pay` decimal(10,2) NOT NULL,
  `allowances` decimal(10,2) NOT NULL,
  `net_salary` decimal(10,2) GENERATED ALWAYS AS ((`basic_pay` + `allowances`)) VIRTUAL,
  `date_of_joining` date NOT NULL,
  `designation_id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `bank_id` bigint UNSIGNED DEFAULT NULL,
  `bank_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `branch_id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `code`, `first_name`, `last_name`, `email`, `phone`, `basic_pay`, `allowances`, `date_of_joining`, `designation_id`, `department_id`, `bank_id`, `bank_account`, `is_active`, `branch_id`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'EMP00001', 'Test', 'Admin', 'testing@gmail.com', '+922134567890', '200000.00', '30000.00', '2024-07-01', 1, 3, NULL, NULL, 1, 2, 1, 1, NULL, '2024-11-06 03:52:58', '2024-11-06 03:52:58'),
(3, 'EMP00002', 'Test', 'Manager', 'testing2@gmail.com', '+922134567890', '150000.00', '30000.00', '2024-07-01', 2, 1, NULL, NULL, 1, 1, 1, 1, NULL, '2024-11-06 03:55:09', '2024-11-06 03:55:09'),
(4, 'EMP00001', 'Test', 'Admin 2', 'testing35@gmail.com', '+92529466282', '210000.00', '25000.00', '2024-08-01', 3, 4, NULL, NULL, 1, 3, 2, 1, 1, '2024-11-06 03:58:38', '2024-11-06 07:12:54'),
(5, 'EMP00003', 'Test', 'User', 'testinguser@gmail.com', '+923363670817', '100000.00', '20000.00', '2024-08-01', 5, 1, NULL, NULL, 1, 1, 1, 2, NULL, '2024-11-06 04:41:41', '2024-11-06 04:41:41'),
(6, 'EMP00002', 'Test', 'Manager 2', 'testing5@gmail.com', '9123131313', '120000.00', '30000.00', '2024-08-01', 4, 4, NULL, NULL, 1, 3, 2, 3, NULL, '2024-11-06 05:36:45', '2024-11-06 05:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finished_goods_receivings`
--

CREATE TABLE `finished_goods_receivings` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finished_goods_receivings`
--

INSERT INTO `finished_goods_receivings` (`id`, `code`, `batch_id`, `product_id`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'FGR00001', 3, 4, 1, NULL, NULL, '2024-12-05 08:35:26', '2024-12-05 08:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `finished_goods_receiving_items`
--

CREATE TABLE `finished_goods_receiving_items` (
  `id` bigint UNSIGNED NOT NULL,
  `finished_goods_receiving_id` bigint UNSIGNED NOT NULL,
  `product_variation_id` bigint UNSIGNED NOT NULL,
  `quantity_received` decimal(10,2) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finished_goods_receiving_items`
--

INSERT INTO `finished_goods_receiving_items` (`id`, `finished_goods_receiving_id`, `product_variation_id`, `quantity_received`, `unit`, `unit_price`, `total`, `created_at`, `updated_at`) VALUES
(4, 4, 2, '90.00', 'Pack', '1000.00', '90000.00', '2024-12-05 08:35:26', '2024-12-05 08:35:26'),
(5, 4, 3, '50.00', 'Pack', '1050.00', '52500.00', '2024-12-05 08:35:26', '2024-12-05 08:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `goods_receivings`
--

CREATE TABLE `goods_receivings` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_id` bigint UNSIGNED NOT NULL,
  `party_id` bigint UNSIGNED NOT NULL,
  `supplier_bill_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `sales_tax` decimal(10,2) NOT NULL,
  `adv_tax` decimal(10,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goods_receivings`
--

INSERT INTO `goods_receivings` (`id`, `code`, `invoice_id`, `party_id`, `supplier_bill_no`, `company_id`, `sales_tax`, `adv_tax`, `total_amount`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'GRN00001', 4, 3, '12345', 1, '750.00', '0.00', '6000.00', 1, NULL, '2024-12-05 08:27:48', '2024-12-05 08:27:48'),
(2, 'GRN00002', 6, 3, '12346', 1, '0.00', '0.00', '4500.00', 1, NULL, '2024-12-05 08:30:43', '2024-12-05 08:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `goods_receiving_items`
--

CREATE TABLE `goods_receiving_items` (
  `id` bigint UNSIGNED NOT NULL,
  `goods_receiving_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `raw_material_item_id` bigint UNSIGNED DEFAULT NULL,
  `batch_id` bigint UNSIGNED DEFAULT NULL,
  `quantity_ordered` decimal(10,2) NOT NULL,
  `quantity_received` decimal(10,2) NOT NULL,
  `balance_receivable` decimal(10,2) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `last_goods_receiving_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goods_receiving_items`
--

INSERT INTO `goods_receiving_items` (`id`, `goods_receiving_id`, `product_id`, `raw_material_item_id`, `batch_id`, `quantity_ordered`, `quantity_received`, `balance_receivable`, `unit`, `unit_price`, `total_amount`, `last_goods_receiving_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, NULL, '100.00', '0.00', '50.00', 'KG', '55.00', '2750.00', NULL, NULL, NULL, '2024-12-05 08:27:48', '2024-12-05 08:27:48'),
(2, 1, NULL, 2, NULL, '25.00', '0.00', '25.00', 'EA', '100.00', '2500.00', NULL, NULL, NULL, '2024-12-05 08:27:48', '2024-12-05 08:27:48'),
(3, 2, NULL, 3, NULL, '200.00', '0.00', '150.00', 'EA', '30.00', '4500.00', NULL, NULL, NULL, '2024-12-05 08:30:43', '2024-12-05 08:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('sale','purchase','quotation') COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_id` bigint UNSIGNED NOT NULL,
  `required_date` date DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `is_urgent` int DEFAULT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `invoice_tax_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `total_invoice_tax` decimal(15,2) NOT NULL DEFAULT '0.00',
  `items_cost_with_tax` decimal(15,2) NOT NULL DEFAULT '0.00',
  `items_cost_without_tax` decimal(15,2) NOT NULL DEFAULT '0.00',
  `shipped_via` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_cost` decimal(15,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `returned_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `due_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount_type` enum('flat','percent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'flat',
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_status` enum('unpaid','partial','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `note` text COLLATE utf8mb4_unicode_ci,
  `payment_deadline` date DEFAULT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `code`, `type`, `prefix`, `party_id`, `required_date`, `order_number`, `order_date`, `is_urgent`, `company_id`, `status`, `invoice_tax_rate`, `total_invoice_tax`, `items_cost_with_tax`, `items_cost_without_tax`, `shipped_via`, `shipping_cost`, `paid_amount`, `returned_amount`, `due_amount`, `total_amount`, `discount_type`, `discount`, `payment_status`, `note`, `payment_deadline`, `invoice_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'PR00001', 'purchase', 'PR', 3, '2024-12-05', NULL, NULL, 0, 1, 'pending', '17.00', '1360.00', '9360.00', '8000.00', NULL, '0.00', '5000.00', '0.00', '4000.00', '9000.00', 'flat', '360.00', 'partial', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '2024-12-31', '2024-12-02 11:09:04', NULL, 1, '2024-12-02 06:09:04', '2024-12-11 03:22:28'),
(6, 'PR00002', 'purchase', 'PR', 3, '2024-12-07', NULL, NULL, 1, 1, 'pending', '17.00', '1020.00', '7020.00', '6000.00', NULL, '0.00', '0.00', '0.00', '0.00', '7020.00', 'flat', '0.00', 'unpaid', NULL, '2025-01-31', '2024-12-05 13:29:52', 1, 1, '2024-12-05 08:29:52', '2024-12-11 03:22:46'),
(7, 'SI00001', 'sale', 'SI', 1, NULL, '12345', '2024-12-01', NULL, 1, 'pending', '17.00', '8585.00', '59085.00', '50500.00', NULL, '500.00', '25000.00', '0.00', '30000.00', '55000.00', 'flat', '4085.00', 'partial', NULL, '2024-12-31', '2024-12-07 11:59:07', 1, 1, '2024-12-06 06:59:07', '2024-12-11 03:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_id` bigint UNSIGNED NOT NULL,
  `product_variation_id` bigint UNSIGNED DEFAULT NULL,
  `raw_material_item_id` bigint UNSIGNED DEFAULT NULL,
  `product_group_id` int DEFAULT NULL,
  `batch_id` bigint UNSIGNED DEFAULT NULL,
  `trans_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `quantity` int NOT NULL,
  `tax_rate` decimal(5,2) DEFAULT NULL,
  `discount_type` enum('flat','percent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'flat',
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `product_variation_id`, `raw_material_item_id`, `product_group_id`, `batch_id`, `trans_code`, `unit`, `unit_price`, `quantity`, `tax_rate`, `discount_type`, `discount`, `total_amount`, `created_at`, `updated_at`) VALUES
(15, 4, NULL, 1, NULL, NULL, NULL, 'KG', '55.00', 100, NULL, 'flat', '0.00', '5500.00', '2024-12-11 03:22:28', '2024-12-11 03:22:28'),
(16, 4, NULL, 2, NULL, NULL, NULL, 'EA', '100.00', 25, NULL, 'flat', '0.00', '2500.00', '2024-12-11 03:22:28', '2024-12-11 03:22:28'),
(17, 6, NULL, 3, NULL, NULL, NULL, 'EA', '30.00', 200, NULL, 'flat', '0.00', '6000.00', '2024-12-11 03:22:46', '2024-12-11 03:22:46'),
(18, 7, 2, NULL, 4, 3, NULL, 'Pack', '1000.00', 50, NULL, 'flat', '0.00', '50000.00', '2024-12-11 03:37:40', '2024-12-11 03:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_vouchers`
--

CREATE TABLE `journal_vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_debit` decimal(10,2) NOT NULL,
  `total_credit` decimal(10,2) NOT NULL,
  `currency` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal_vouchers`
--

INSERT INTO `journal_vouchers` (`id`, `code`, `year`, `total_debit`, `total_credit`, `currency`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'JV00001', '24-25', '1000.00', '0.00', 'PKR', 1, 1, NULL, '2024-12-19 06:04:47', '2024-12-19 06:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `journal_voucher_items`
--

CREATE TABLE `journal_voucher_items` (
  `id` bigint UNSIGNED NOT NULL,
  `journal_voucher_id` bigint UNSIGNED NOT NULL,
  `chart_of_account_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal_voucher_items`
--

INSERT INTO `journal_voucher_items` (`id`, `journal_voucher_id`, `chart_of_account_id`, `description`, `debit`, `credit`, `created_at`, `updated_at`) VALUES
(7, 2, 2, 'Checking', '1000.00', '0.00', '2024-12-19 06:04:47', '2024-12-19 06:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `leave_type_id` bigint UNSIGNED NOT NULL,
  `days` int NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `employee_id`, `leave_type_id`, `days`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 5, 3, 1, 1, 1, NULL, '2024-11-07 05:09:35', '2024-11-07 05:09:35'),
(2, 5, 3, 1, 1, 1, NULL, '2024-11-07 05:09:51', '2024-11-07 05:09:51');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deduction` decimal(5,2) NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `deduction`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Authorized Absence', '100.00', 1, 1, 1, '2024-11-07 05:08:19', '2024-11-07 05:42:29'),
(2, 'Unauthorized Absence', '125.00', 1, 1, 1, '2024-11-07 05:08:46', '2024-11-07 05:42:16'),
(3, 'Approved Leave with Pay', '0.00', 1, 1, NULL, '2024-11-07 05:09:03', '2024-11-07 05:09:03');

-- --------------------------------------------------------

--
-- Table structure for table `left_over_notes`
--

CREATE TABLE `left_over_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `batch_id` bigint UNSIGNED DEFAULT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `store_issue_requisition_id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `left_over_notes`
--

INSERT INTO `left_over_notes` (`id`, `code`, `product_id`, `batch_id`, `department_id`, `store_issue_requisition_id`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'LON00001', 4, 3, 5, 8, 1, 1, NULL, '2024-12-05 08:37:34', '2024-12-05 08:37:34');

-- --------------------------------------------------------

--
-- Table structure for table `left_over_note_items`
--

CREATE TABLE `left_over_note_items` (
  `id` bigint UNSIGNED NOT NULL,
  `left_over_note_id` bigint UNSIGNED NOT NULL,
  `raw_material_item_id` bigint UNSIGNED NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `left_over_note_items`
--

INSERT INTO `left_over_note_items` (`id`, `left_over_note_id`, `raw_material_item_id`, `quantity`, `unit`, `unit_price`, `total`, `remarks`, `created_at`, `updated_at`) VALUES
(5, 3, 3, '10.00', 'EA', '30.00', '300.00', NULL, '2024-12-05 08:37:34', '2024-12-05 08:37:34');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payback_months` int NOT NULL,
  `remaining` decimal(10,2) NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `employee_id`, `amount`, `payback_months`, `remaining`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 5, '50000.00', 1, '0.00', 1, 2, 1, '2024-11-06 05:06:15', '2024-11-07 05:14:17'),
(2, 6, '4000.00', 1, '4000.00', 2, 3, 3, '2024-11-06 05:44:28', '2024-11-06 05:45:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(61, '0001_01_01_000000_create_users_table', 1),
(62, '0001_01_01_000001_create_cache_table', 1),
(63, '0001_01_01_000002_create_jobs_table', 1),
(64, '2024_10_16_084615_create_countries_table', 1),
(65, '2024_10_16_084616_create_cities_table', 1),
(66, '2024_10_16_084616_create_companies_table', 1),
(67, '2024_10_16_084616_create_departments_table', 1),
(68, '2024_10_16_141316_create_designations_table', 1),
(69, '2024_10_16_142358_create_branches_table', 1),
(70, '2024_10_17_040718_create_salary_tax_slabs_table', 1),
(71, '2024_10_18_040822_create_payment_types_table', 1),
(72, '2024_10_18_044122_create_permission_tables', 1),
(74, '2024_10_19_064956_create_banks_table', 1),
(75, '2024_10_19_072037_create_employees_table', 1),
(79, '2024_10_19_083357_create_loans_table', 1),
(80, '2024_10_19_084627_create_parties_table', 1),
(81, '2024_10_24_134558_modify_model_has_roles_table_add_user_id', 1),
(82, '2024_10_26_091646_add_employee_id_to_users_table', 1),
(84, '2024_10_31_110110_branch_id_to_departments', 1),
(85, '2024_11_01_095108_add_email_and_phone_to_employees_table', 1),
(86, '2024_11_02_125218_remove_unique_constraint_from_employees_code', 1),
(91, '2024_10_19_081436_create_salary_slips_table', 2),
(92, '2024_10_26_104214_add_month_year_to_salary_slips_table', 3),
(93, '2024_10_19_074241_create_leave_types_table', 4),
(94, '2024_10_19_074440_create_leaves_table', 4),
(100, '2024_11_07_083405_create_categories_table', 5),
(101, '2024_11_07_110344_create_packing_types_table', 5),
(102, '2024_11_07_114242_create_pack_size_table', 5),
(103, '2024_11_08_071119_create_taxes_table', 5),
(104, '2024_11_08_095948_create_dosage_forms_table', 5),
(105, '2024_11_08_111939_create_product_metas_table', 6),
(106, '2024_11_08_105914_create_product_group_table', 7),
(107, '2024_11_08_111744_create_pack_form_table', 7),
(108, '2024_11_08_115902_create_products_table', 7),
(109, '2024_11_09_104721_create_product_variations_table', 8),
(113, '2024_11_11_082328_create_raw_material_items_table', 9),
(117, '2024_11_12_073106_create_purchase_requisitions_table', 11),
(118, '2024_11_12_073137_create_purchase_requisition_items_table', 11),
(127, '2024_11_09_093345_create_batch_table', 15),
(145, '2024_11_13_122653_create_finished_goods_receiving_table', 17),
(149, '2024_11_19_124244_create_finished_goods_receiving_items_table', 18),
(154, '2024_11_23_123100_create_stocks_table', 18),
(155, '2024_11_18_080811_create_store_issue_requisitions_table', 19),
(156, '2024_11_18_082637_create_store_issue_requisition_item_table', 19),
(159, '2024_11_23_081253_create_left_over_notes_table', 19),
(160, '2024_11_23_081310_create_left_over_note_items_table', 19),
(161, '2024_10_18_133538_create_chart_of_accounts_table', 20),
(162, '2024_11_11_085156_create_invoice_table', 21),
(163, '2024_11_11_090720_create_invoice_items_table', 21),
(164, '2024_11_13_090929_create_goods_receiving_table', 21),
(165, '2024_11_15_112859_create_goods_receiving_items_table', 21),
(166, '2024_11_21_093848_create_rejection_return_notes_table', 21),
(167, '2024_11_21_093958_create_rejection_return_note_items_table', 21),
(177, '2024_12_04_085716_create_credit_notes_table', 24),
(178, '2024_12_04_085723_create_credit_note_items_table', 24),
(183, '2024_12_04_113920_create_sales_returns_table', 25),
(184, '2024_12_04_113936_create_sales_return_items_table', 25),
(185, '2024_12_05_092544_create_journal_vouchers_table', 26),
(186, '2024_12_05_092550_create_journal_voucher_items_table', 26),
(187, '2024_12_03_110643_create_payment_vouchers_table', 27),
(188, '2024_12_03_110653_create_payment_voucher_items_table', 27),
(189, '2024_12_04_074830_create_receipt_vouchers_table', 27),
(190, '2024_12_04_074849_create_receipt_voucher_items_table', 27);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `user_id`) VALUES
(1, 1),
(2, 2),
(2, 3),
(3, 4),
(3, 5),
(3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `packing_types`
--

CREATE TABLE `packing_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packing_types`
--

INSERT INTO `packing_types` (`id`, `name`, `description`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'ALU PVC', 'Test', 1, 1, NULL, '2024-11-09 04:36:21', '2024-11-09 04:36:21'),
(3, 'ALU ALU', 'Test', 1, 1, NULL, '2024-11-14 06:28:38', '2024-11-14 06:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `pack_forms`
--

CREATE TABLE `pack_forms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pack_forms`
--

INSERT INTO `pack_forms` (`id`, `name`, `description`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Institution', 'Test', 1, 1, NULL, '2024-11-09 04:12:55', '2024-11-09 04:12:55'),
(2, 'Comm', 'Test', 1, 1, NULL, '2024-11-14 06:27:40', '2024-11-14 06:27:40');

-- --------------------------------------------------------

--
-- Table structure for table `pack_sizes`
--

CREATE TABLE `pack_sizes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pack_sizes`
--

INSERT INTO `pack_sizes` (`id`, `name`, `description`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '10\'s', 'Test', 1, 1, NULL, '2024-11-09 04:40:57', '2024-11-09 04:40:57'),
(2, '14\'s', 'Test', 1, 1, NULL, '2024-11-14 06:30:55', '2024-11-14 06:30:55'),
(3, '20\'s', 'Test', 1, 1, 1, '2024-11-14 06:30:55', '2024-11-14 06:31:10'),
(4, '28\'s', 'Test', 1, 1, NULL, '2024-11-14 06:31:52', '2024-11-14 06:31:52'),
(5, '2 x 10\'s', 'Test', 1, 1, NULL, '2024-11-14 06:32:19', '2024-11-14 06:32:19'),
(6, '50 x 10\'s', 'Test', 1, 1, NULL, '2024-11-14 06:32:36', '2024-11-14 06:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `city_id` bigint UNSIGNED NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_type_id` bigint UNSIGNED NOT NULL,
  `is_supplier` tinyint(1) NOT NULL DEFAULT '0',
  `is_distributor` tinyint(1) NOT NULL DEFAULT '0',
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `name`, `code`, `contact_person_name`, `contact_person_phone`, `contact_person_email`, `phone`, `email`, `country_id`, `city_id`, `address`, `payment_type_id`, `is_supplier`, `is_distributor`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Franchise Test', 'FRA00001', 'Franchise Test', '+92529466282', 'franchise@gmail.com', '+92529466282', 'franchise@gmail.com', 1, 1, NULL, 1, 0, 1, 1, 1, NULL, '2024-11-06 07:40:55', '2024-11-06 07:40:55'),
(3, 'Supplier 1', 'SUP00001', NULL, NULL, NULL, '+92529466282', 'testing@gmail.com', 1, 1, NULL, 1, 1, 0, 1, 1, NULL, '2024-11-12 06:36:38', '2024-11-12 06:36:38');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`id`, `name`, `description`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1 Month Credit', 'Test', 1, 1, NULL, '2024-11-06 06:21:15', '2024-11-06 06:21:15');

-- --------------------------------------------------------

--
-- Table structure for table `payment_vouchers`
--

CREATE TABLE `payment_vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_id` bigint UNSIGNED NOT NULL,
  `total_debit` decimal(10,2) NOT NULL,
  `total_credit` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `currency` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` enum('cheque','cash','online') COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_vouchers`
--

INSERT INTO `payment_vouchers` (`id`, `code`, `party_id`, `total_debit`, `total_credit`, `total`, `currency`, `payment_method`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'PV00001', 3, '500.00', '0.00', '500.00', 'PKR', 'cash', 1, 1, NULL, '2024-12-19 06:20:03', '2024-12-19 06:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `payment_voucher_items`
--

CREATE TABLE `payment_voucher_items` (
  `id` bigint UNSIGNED NOT NULL,
  `payment_voucher_id` bigint UNSIGNED NOT NULL,
  `chart_of_account_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_voucher_items`
--

INSERT INTO `payment_voucher_items` (`id`, `payment_voucher_id`, `chart_of_account_id`, `description`, `debit`, `credit`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Checking', '500.00', '0.00', '2024-12-19 06:20:03', '2024-12-19 06:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Employee List', 'web', '2024-11-06 03:01:14', NULL),
(2, 'Employee Create', 'web', '2024-11-06 03:01:14', NULL),
(3, 'Employee Update', 'web', '2024-11-06 03:01:14', NULL),
(4, 'Employee Delete', 'web', '2024-11-06 03:01:14', NULL),
(5, 'Employee View', 'web', '2024-11-06 03:01:14', NULL),
(6, 'Leave List', 'web', '2024-11-06 03:01:14', NULL),
(7, 'Leave Create', 'web', '2024-11-06 03:01:14', NULL),
(8, 'Leave Update', 'web', '2024-11-06 03:01:14', NULL),
(9, 'Leave Delete', 'web', '2024-11-06 03:01:14', NULL),
(10, 'Leave View', 'web', '2024-11-06 03:01:14', NULL),
(11, 'Leave Type List', 'web', '2024-11-06 03:01:14', NULL),
(12, 'Leave Type Create', 'web', '2024-11-06 03:01:14', NULL),
(13, 'Leave Type Update', 'web', '2024-11-06 03:01:14', NULL),
(14, 'Leave Type Delete', 'web', '2024-11-06 03:01:14', NULL),
(15, 'Leave Type View', 'web', '2024-11-06 03:01:14', NULL),
(16, 'Bank List', 'web', '2024-11-06 03:01:14', NULL),
(17, 'Bank Create', 'web', '2024-11-06 03:01:14', NULL),
(18, 'Bank Update', 'web', '2024-11-06 03:01:14', NULL),
(19, 'Bank Delete', 'web', '2024-11-06 03:01:14', NULL),
(20, 'Bank View', 'web', '2024-11-06 03:01:14', NULL),
(21, 'Salaries List', 'web', '2024-11-06 03:01:14', NULL),
(22, 'Salaries Create', 'web', '2024-11-06 03:01:14', NULL),
(23, 'Salaries Update', 'web', '2024-11-06 03:01:14', NULL),
(24, 'Salaries Delete', 'web', '2024-11-06 03:01:14', NULL),
(25, 'Salaries View', 'web', '2024-11-06 03:01:14', NULL),
(26, 'Loan List', 'web', '2024-11-06 03:01:14', NULL),
(27, 'Loan Create', 'web', '2024-11-06 03:01:14', NULL),
(28, 'Loan Update', 'web', '2024-11-06 03:01:14', NULL),
(29, 'Loan Delete', 'web', '2024-11-06 03:01:14', NULL),
(30, 'Loan View', 'web', '2024-11-06 03:01:14', NULL),
(31, 'Parties List', 'web', '2024-11-06 03:01:14', NULL),
(32, 'Parties Create', 'web', '2024-11-06 03:01:14', NULL),
(33, 'Parties Update', 'web', '2024-11-06 03:01:14', NULL),
(34, 'Parties Delete', 'web', '2024-11-06 03:01:14', NULL),
(35, 'Parties View', 'web', '2024-11-06 03:01:14', NULL),
(36, 'Countries List', 'web', '2024-11-06 03:01:14', NULL),
(37, 'Countries Create', 'web', '2024-11-06 03:01:14', NULL),
(38, 'Countries Update', 'web', '2024-11-06 03:01:14', NULL),
(39, 'Countries Delete', 'web', '2024-11-06 03:01:14', NULL),
(40, 'Countries View', 'web', '2024-11-06 03:01:14', NULL),
(41, 'Cities List', 'web', '2024-11-06 03:01:14', NULL),
(42, 'Cities Create', 'web', '2024-11-06 03:01:14', NULL),
(43, 'Cities Update', 'web', '2024-11-06 03:01:14', NULL),
(44, 'Cities Delete', 'web', '2024-11-06 03:01:14', NULL),
(45, 'Cities View', 'web', '2024-11-06 03:01:14', NULL),
(46, 'Companies List', 'web', '2024-11-06 03:01:14', NULL),
(47, 'Companies Create', 'web', '2024-11-06 03:01:14', NULL),
(48, 'Companies Update', 'web', '2024-11-06 03:01:14', NULL),
(49, 'Companies Delete', 'web', '2024-11-06 03:01:14', NULL),
(50, 'Companies View', 'web', '2024-11-06 03:01:14', NULL),
(51, 'Departments List', 'web', '2024-11-06 03:01:14', NULL),
(52, 'Departments Create', 'web', '2024-11-06 03:01:14', NULL),
(53, 'Departments Update', 'web', '2024-11-06 03:01:14', NULL),
(54, 'Departments Delete', 'web', '2024-11-06 03:01:14', NULL),
(55, 'Departments View', 'web', '2024-11-06 03:01:14', NULL),
(56, 'Chart Of Accounts List', 'web', '2024-11-06 03:01:14', NULL),
(57, 'Chart Of Accounts Create', 'web', '2024-11-06 03:01:14', NULL),
(58, 'Chart Of Accounts Update', 'web', '2024-11-06 03:01:14', NULL),
(59, 'Chart Of Accounts Delete', 'web', '2024-11-06 03:01:14', NULL),
(60, 'Chart Of Accounts View', 'web', '2024-11-06 03:01:14', NULL),
(61, 'Payment Types List', 'web', '2024-11-06 03:01:14', NULL),
(62, 'Payment Types Create', 'web', '2024-11-06 03:01:14', NULL),
(63, 'Payment Types Update', 'web', '2024-11-06 03:01:14', NULL),
(64, 'Payment Types Delete', 'web', '2024-11-06 03:01:14', NULL),
(65, 'Payment Types View', 'web', '2024-11-06 03:01:14', NULL),
(66, 'Branches List', 'web', '2024-11-06 03:01:14', NULL),
(67, 'Branches Create', 'web', '2024-11-06 03:01:14', NULL),
(68, 'Branches Update', 'web', '2024-11-06 03:01:14', NULL),
(69, 'Branches Delete', 'web', '2024-11-06 03:01:14', NULL),
(70, 'Branches View', 'web', '2024-11-06 03:01:14', NULL),
(71, 'Designation List', 'web', '2024-11-06 03:01:14', NULL),
(72, 'Designation Create', 'web', '2024-11-06 03:01:14', NULL),
(73, 'Designation Update', 'web', '2024-11-06 03:01:14', NULL),
(74, 'Designation Delete', 'web', '2024-11-06 03:01:14', NULL),
(75, 'Designation View', 'web', '2024-11-06 03:01:14', NULL),
(76, 'Salary Tax Slabs List', 'web', '2024-11-06 03:01:14', NULL),
(77, 'Salary Tax Slabs Create', 'web', '2024-11-06 03:01:14', NULL),
(78, 'Salary Tax Slabs Update', 'web', '2024-11-06 03:01:14', NULL),
(79, 'Salary Tax Slabs Delete', 'web', '2024-11-06 03:01:14', NULL),
(80, 'Salary Tax Slabs View', 'web', '2024-11-06 03:01:14', NULL),
(81, 'Roles List', 'web', '2024-11-06 03:01:14', NULL),
(82, 'Roles Create', 'web', '2024-11-06 03:01:14', NULL),
(83, 'Roles Update', 'web', '2024-11-06 03:01:14', NULL),
(84, 'Roles Delete', 'web', '2024-11-06 03:01:14', NULL),
(85, 'Roles View', 'web', '2024-11-06 03:01:14', NULL),
(86, 'Users List', 'web', '2024-11-06 03:01:14', NULL),
(87, 'Users Create', 'web', '2024-11-06 03:01:14', NULL),
(88, 'Users Update', 'web', '2024-11-06 03:01:14', NULL),
(89, 'Users Delete', 'web', '2024-11-06 03:01:14', NULL),
(90, 'Users View', 'web', '2024-11-06 03:01:14', NULL),
(91, 'Supplier List', 'web', '2024-11-06 03:01:14', NULL),
(92, 'Supplier Create', 'web', '2024-11-06 03:01:14', NULL),
(93, 'Supplier Update', 'web', '2024-11-06 03:01:14', NULL),
(94, 'Supplier Delete', 'web', '2024-11-06 03:01:14', NULL),
(95, 'Supplier View', 'web', '2024-11-06 03:01:14', NULL),
(96, 'Franchise List', 'web', '2024-11-06 03:01:14', NULL),
(97, 'Franchise Create', 'web', '2024-11-06 03:01:14', NULL),
(98, 'Franchise Update', 'web', '2024-11-06 03:01:14', NULL),
(99, 'Franchise Delete', 'web', '2024-11-06 03:01:14', NULL),
(100, 'Franchise View', 'web', '2024-11-06 03:01:14', NULL),
(101, 'Category List', 'web', '2024-11-06 03:01:14', NULL),
(102, 'Category Create', 'web', '2024-11-06 03:01:14', NULL),
(103, 'Category Update', 'web', '2024-11-06 03:01:14', NULL),
(104, 'Category Delete', 'web', '2024-11-06 03:01:14', NULL),
(105, 'Category View', 'web', '2024-11-06 03:01:14', NULL),
(106, 'PackingType List', 'web', '2024-11-06 03:01:14', NULL),
(107, 'PackingType Create', 'web', '2024-11-06 03:01:14', NULL),
(108, 'PackingType Update', 'web', '2024-11-06 03:01:14', NULL),
(109, 'PackingType Delete', 'web', '2024-11-06 03:01:14', NULL),
(110, 'PackingType View', 'web', '2024-11-06 03:01:14', NULL),
(111, 'PackSize List', 'web', '2024-11-06 03:01:14', NULL),
(112, 'PackSize Create', 'web', '2024-11-06 03:01:14', NULL),
(113, 'PackSize Update', 'web', '2024-11-06 03:01:14', NULL),
(114, 'PackSize Delete', 'web', '2024-11-06 03:01:14', NULL),
(115, 'PackSize View', 'web', '2024-11-06 03:01:14', NULL),
(116, 'Tax List', 'web', NULL, NULL),
(117, 'Tax Create', 'web', NULL, NULL),
(118, 'Tax Update', 'web', NULL, NULL),
(119, 'Tax Delete', 'web', NULL, NULL),
(120, 'Tax View', 'web', NULL, NULL),
(121, 'Dosage Form List', 'web', NULL, NULL),
(122, 'Dosage Form Create', 'web', NULL, NULL),
(123, 'Dosage Form Update', 'web', NULL, NULL),
(124, 'Dosage Form Delete', 'web', NULL, NULL),
(125, 'Dosage Form View', 'web', NULL, NULL),
(126, 'Product List', 'web', NULL, NULL),
(127, 'Product Create', 'web', NULL, NULL),
(128, 'Product Update', 'web', NULL, NULL),
(129, 'Product Delete', 'web', NULL, NULL),
(130, 'Product View', 'web', NULL, NULL),
(131, 'ProductGroup List', 'web', NULL, NULL),
(132, 'ProductGroup Create', 'web', NULL, NULL),
(133, 'ProductGroup Update', 'web', NULL, NULL),
(134, 'ProductGroup Delete', 'web', NULL, NULL),
(135, 'ProductGroup View', 'web', NULL, NULL),
(136, 'PackForm List', 'web', NULL, NULL),
(137, 'PackForm Create', 'web', NULL, NULL),
(138, 'PackForm Update', 'web', NULL, NULL),
(139, 'PackForm Delete', 'web', NULL, NULL),
(140, 'PackForm View', 'web', NULL, NULL),
(141, 'Product Variation List', 'web', NULL, NULL),
(142, 'Product Variation Create', 'web', NULL, NULL),
(143, 'Product Variation Update', 'web', NULL, NULL),
(144, 'Product Variation Delete', 'web', NULL, NULL),
(145, 'Product Variation View', 'web', NULL, NULL),
(146, 'Batch List', 'web', NULL, NULL),
(147, 'Batch Create', 'web', NULL, NULL),
(148, 'Batch Update', 'web', NULL, NULL),
(149, 'Batch Delete', 'web', NULL, NULL),
(150, 'Batch View', 'web', NULL, NULL),
(151, 'Raw Material Item List', 'web', NULL, NULL),
(152, 'Raw Material Item Create', 'web', NULL, NULL),
(153, 'Raw Material Item Update', 'web', NULL, NULL),
(154, 'Raw Material Item Delete', 'web', NULL, NULL),
(155, 'Raw Material Item View', 'web', NULL, NULL),
(156, 'Stock List', 'web', NULL, NULL),
(157, 'Stock Create', 'web', NULL, NULL),
(158, 'Stock Update', 'web', NULL, NULL),
(159, 'Stock Delete', 'web', NULL, NULL),
(160, 'Stock View', 'web', NULL, NULL),
(161, 'Purchase Requisition List', 'web', NULL, NULL),
(162, 'Purchase Requisition Create', 'web', NULL, NULL),
(163, 'Purchase Requisition Update', 'web', NULL, NULL),
(164, 'Purchase Requisition Delete', 'web', NULL, NULL),
(165, 'Purchase Requisition View', 'web', NULL, NULL),
(166, 'Invoice List', 'web', NULL, NULL),
(167, 'Invoice Create', 'web', NULL, NULL),
(168, 'Invoice Update', 'web', NULL, NULL),
(169, 'Invoice Delete', 'web', NULL, NULL),
(170, 'Invoice View', 'web', NULL, NULL),
(171, 'Goods Receiving List', 'web', NULL, NULL),
(172, 'Goods Receiving Create', 'web', NULL, NULL),
(173, 'Goods Receiving Update', 'web', NULL, NULL),
(174, 'Goods Receiving Delete', 'web', NULL, NULL),
(175, 'Goods Receiving View', 'web', NULL, NULL),
(176, 'Finished Goods Receiving List', 'web', NULL, NULL),
(177, 'Finished Goods Receiving Create', 'web', NULL, NULL),
(178, 'Finished Goods Receiving Update', 'web', NULL, NULL),
(179, 'Finished Goods Receiving Delete', 'web', NULL, NULL),
(180, 'Finished Goods Receiving View', 'web', NULL, NULL),
(181, 'Store Issue Rquisition List', 'web', NULL, NULL),
(182, 'Store Issue Rquisition Create', 'web', NULL, NULL),
(183, 'Store Issue Rquisition Update', 'web', NULL, NULL),
(184, 'Store Issue Rquisition Delete', 'web', NULL, NULL),
(185, 'Store Issue Rquisition View', 'web', NULL, NULL),
(186, 'Rejection Return Note List', 'web', NULL, NULL),
(187, 'Rejection Return Note Create', 'web', NULL, NULL),
(188, 'Rejection Return Note Update', 'web', NULL, NULL),
(189, 'Rejection Return Note Delete', 'web', NULL, NULL),
(190, 'Rejection Return Note View', 'web', NULL, NULL),
(191, 'Left Over Note List', 'web', NULL, NULL),
(192, 'Left Over Note Create', 'web', NULL, NULL),
(193, 'Left Over Note Update', 'web', NULL, NULL),
(194, 'Left Over Note Delete', 'web', NULL, NULL),
(195, 'Left Over Note View', 'web', NULL, NULL),
(196, 'Payment Voucher List', 'web', NULL, NULL),
(197, 'Payment Voucher Create', 'web', NULL, NULL),
(198, 'Payment Voucher Update', 'web', NULL, NULL),
(199, 'Payment Voucher Delete', 'web', NULL, NULL),
(200, 'Payment Voucher View', 'web', NULL, NULL),
(201, 'Receipt Voucher List', 'web', NULL, NULL),
(202, 'Receipt Voucher Create', 'web', NULL, NULL),
(203, 'Receipt Voucher Update', 'web', NULL, NULL),
(204, 'Receipt Voucher Delete', 'web', NULL, NULL),
(205, 'Receipt Voucher View', 'web', NULL, NULL),
(206, 'Credit Note List', 'web', NULL, NULL),
(207, 'Credit Note Create', 'web', NULL, NULL),
(208, 'Credit Note Update', 'web', NULL, NULL),
(209, 'Credit Note Delete', 'web', NULL, NULL),
(210, 'Credit Note View', 'web', NULL, NULL),
(211, 'Sales Return List', 'web', NULL, NULL),
(212, 'Sales Return Create', 'web', NULL, NULL),
(213, 'Sales Return Update', 'web', NULL, NULL),
(214, 'Sales Return Delete', 'web', NULL, NULL),
(215, 'Sales Return View', 'web', NULL, NULL),
(216, 'Journal Voucher List', 'web', NULL, NULL),
(217, 'Journal Voucher Create', 'web', NULL, NULL),
(218, 'Journal Voucher Update', 'web', NULL, NULL),
(219, 'Journal Voucher Delete', 'web', NULL, NULL),
(220, 'Journal Voucher View', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `reg_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `generic_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `therapeutic_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_group_id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `reg_no`, `name`, `generic_name`, `brand_name`, `therapeutic_class`, `code`, `product_group_id`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, '088463', 'Tamsuben 0.4MG Cap', 'Tamsulosin as Hydrochloride', 'Tamsuben 0.4MG Cap', 'Alpha Advenergic Blocker', 'PRD00001', 4, 1, 1, NULL, '2024-11-14 06:36:13', '2024-11-14 06:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_groups`
--

CREATE TABLE `product_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_groups`
--

INSERT INTO `product_groups` (`id`, `name`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'Dangerous', 1, 1, NULL, '2024-11-09 05:21:15', '2024-11-09 05:21:15');

-- --------------------------------------------------------

--
-- Table structure for table `product_metas`
--

CREATE TABLE `product_metas` (
  `id` bigint UNSIGNED NOT NULL,
  `reg_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `therapeutic_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `dosage_form_id` bigint UNSIGNED NOT NULL,
  `pack_form_id` bigint UNSIGNED NOT NULL,
  `packing_type_id` bigint UNSIGNED NOT NULL,
  `pack_size_id` bigint UNSIGNED NOT NULL,
  `trade_price` decimal(10,2) NOT NULL,
  `our_mrp` decimal(10,2) NOT NULL,
  `drap_mrp` decimal(10,2) NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `product_id`, `dosage_form_id`, `pack_form_id`, `packing_type_id`, `pack_size_id`, `trade_price`, `our_mrp`, `drap_mrp`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 4, 3, 2, 3, 1, '100.00', '10.00', '100.00', 1, 1, NULL, '2024-11-14 06:43:47', '2024-11-14 06:43:47'),
(3, 4, 3, 1, 2, 1, '100.00', '0.00', '100.00', 1, 1, NULL, '2024-11-14 06:45:11', '2024-11-14 06:45:11');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requisitions`
--

CREATE TABLE `purchase_requisitions` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `required_date` date NOT NULL,
  `supplier_id` bigint UNSIGNED DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `special_instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_requisitions`
--

INSERT INTO `purchase_requisitions` (`id`, `code`, `required_date`, `supplier_id`, `total_amount`, `special_instructions`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'MPR00001', '2024-11-30', 3, '2500.00', 'Testing purpsoe', 1, 1, NULL, '2024-11-14 07:04:09', '2024-11-14 07:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requisition_items`
--

CREATE TABLE `purchase_requisition_items` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_requisition_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_requisition_items`
--

INSERT INTO `purchase_requisition_items` (`id`, `purchase_requisition_id`, `name`, `quantity`, `unit`, `price`, `amount`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, 3, 'Tamsuben 0.4MG Cap', 20, 'EA', '100.00', '2000.00', 1, 1, NULL, '2024-11-14 07:04:09', '2024-11-14 07:04:09'),
(6, 3, 'Alerfree 10MG TAB', 5, 'EA', '100.00', '500.00', 1, 1, NULL, '2024-11-14 07:04:09', '2024-11-14 07:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `raw_material_items`
--

CREATE TABLE `raw_material_items` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_id` bigint UNSIGNED DEFAULT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raw_material_items`
--

INSERT INTO `raw_material_items` (`id`, `name`, `code`, `unit`, `min_level`, `max_level`, `party_id`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Raw Material Item 1', 'RMI00001', 'KG', '', '', 1, 1, NULL, NULL, '2024-11-11 05:23:21', '2024-11-11 05:23:21'),
(2, 'Raw Material Item 2', 'RMI00002', 'EA', '', '', 3, 1, 1, NULL, '2024-11-14 06:55:04', '2024-11-14 06:55:04'),
(3, 'Bottles', 'RMI00003', 'kg', '2', '4', 3, 1, 1, 1, '2024-11-15 06:58:00', '2024-11-26 05:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `receipt_vouchers`
--

CREATE TABLE `receipt_vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_id` bigint UNSIGNED NOT NULL,
  `total_debit` decimal(10,2) NOT NULL,
  `total_credit` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `currency` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` enum('cheque','cash','online') COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receipt_vouchers`
--

INSERT INTO `receipt_vouchers` (`id`, `code`, `party_id`, `total_debit`, `total_credit`, `total`, `currency`, `payment_method`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'RV00001', 1, '0.00', '5000.00', '5000.00', 'PKR', 'cash', 1, 1, 1, '2024-12-08 03:25:01', '2024-12-09 03:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `receipt_voucher_items`
--

CREATE TABLE `receipt_voucher_items` (
  `id` bigint UNSIGNED NOT NULL,
  `receipt_voucher_id` bigint UNSIGNED NOT NULL,
  `chart_of_account_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receipt_voucher_items`
--

INSERT INTO `receipt_voucher_items` (`id`, `receipt_voucher_id`, `chart_of_account_id`, `description`, `debit`, `credit`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 'Paid amount against invoice.', '0.00', '5000.00', '2024-12-09 03:28:02', '2024-12-09 03:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `rejection_return_notes`
--

CREATE TABLE `rejection_return_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_id` bigint UNSIGNED NOT NULL,
  `invoice_id` bigint UNSIGNED NOT NULL,
  `supplier_bill_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` bigint UNSIGNED DEFAULT NULL,
  `store_issue_requisition_id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rejection_return_notes`
--

INSERT INTO `rejection_return_notes` (`id`, `code`, `party_id`, `invoice_id`, `supplier_bill_no`, `batch_id`, `store_issue_requisition_id`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'RRN00001', 3, 6, '12346', NULL, 9, 1, 1, NULL, '2024-12-05 08:47:41', '2024-12-05 08:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `rejection_return_note_items`
--

CREATE TABLE `rejection_return_note_items` (
  `id` bigint UNSIGNED NOT NULL,
  `rejection_return_note_id` bigint UNSIGNED DEFAULT NULL,
  `raw_material_item_id` bigint UNSIGNED DEFAULT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rejection_return_note_items`
--

INSERT INTO `rejection_return_note_items` (`id`, `rejection_return_note_id`, `raw_material_item_id`, `product_id`, `quantity`, `unit`, `unit_price`, `total`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, '5.00', 'EA', '30.00', '150.00', 'Broken', '2024-12-05 08:47:41', '2024-12-05 08:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', 'web', '2024-11-06 03:01:14', '2024-11-06 03:01:14'),
(2, 'Admin', 'web', '2024-11-06 04:00:19', '2024-11-06 04:00:19'),
(3, 'Manager', 'web', '2024-11-06 04:01:35', '2024-11-06 04:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1),
(153, 1),
(154, 1),
(155, 1),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(160, 1),
(161, 1),
(162, 1),
(163, 1),
(164, 1),
(165, 1),
(166, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(171, 1),
(172, 1),
(173, 1),
(174, 1),
(175, 1),
(176, 1),
(177, 1),
(178, 1),
(179, 1),
(180, 1),
(181, 1),
(182, 1),
(183, 1),
(184, 1),
(185, 1),
(186, 1),
(187, 1),
(188, 1),
(189, 1),
(190, 1),
(191, 1),
(192, 1),
(193, 1),
(194, 1),
(195, 1),
(196, 1),
(197, 1),
(198, 1),
(199, 1),
(200, 1),
(201, 1),
(202, 1),
(203, 1),
(204, 1),
(205, 1),
(206, 1),
(207, 1),
(208, 1),
(209, 1),
(210, 1),
(211, 1),
(212, 1),
(213, 1),
(214, 1),
(215, 1),
(216, 1),
(217, 1),
(218, 1),
(219, 1),
(220, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(90, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(99, 2),
(100, 2),
(101, 2),
(102, 2),
(103, 2),
(104, 2),
(105, 2),
(106, 2),
(107, 2),
(108, 2),
(109, 2),
(110, 2),
(111, 2),
(112, 2),
(113, 2),
(114, 2),
(115, 2),
(116, 2),
(117, 2),
(118, 2),
(119, 2),
(120, 2),
(121, 2),
(122, 2),
(123, 2),
(124, 2),
(125, 2),
(126, 2),
(127, 2),
(128, 2),
(129, 2),
(130, 2),
(131, 2),
(132, 2),
(133, 2),
(134, 2),
(135, 2),
(136, 2),
(137, 2),
(138, 2),
(139, 2),
(140, 2),
(141, 2),
(142, 2),
(143, 2),
(144, 2),
(145, 2),
(146, 2),
(147, 2),
(148, 2),
(149, 2),
(150, 2),
(151, 2),
(152, 2),
(153, 2),
(154, 2),
(155, 2),
(156, 2),
(157, 2),
(158, 2),
(159, 2),
(160, 2),
(161, 2),
(162, 2),
(163, 2),
(164, 2),
(165, 2),
(171, 2),
(172, 2),
(173, 2),
(174, 2),
(175, 2),
(176, 2),
(177, 2),
(178, 2),
(179, 2),
(180, 2),
(181, 2),
(182, 2),
(183, 2),
(184, 2),
(185, 2),
(186, 2),
(187, 2),
(188, 2),
(189, 2),
(190, 2),
(191, 2),
(192, 2),
(193, 2),
(194, 2),
(195, 2),
(196, 2),
(197, 2),
(198, 2),
(199, 2),
(200, 2),
(201, 2),
(202, 2),
(203, 2),
(204, 2),
(205, 2),
(206, 2),
(207, 2),
(208, 2),
(209, 2),
(210, 2),
(211, 2),
(212, 2),
(213, 2),
(214, 2),
(215, 2),
(216, 2),
(217, 2),
(218, 2),
(219, 2),
(220, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(21, 3),
(22, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(56, 3),
(57, 3),
(58, 3),
(59, 3),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(66, 3),
(67, 3),
(68, 3),
(69, 3),
(70, 3),
(71, 3),
(72, 3),
(73, 3),
(74, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3),
(79, 3),
(80, 3),
(91, 3),
(92, 3),
(93, 3),
(94, 3),
(95, 3),
(96, 3),
(97, 3),
(98, 3),
(99, 3),
(100, 3),
(101, 3),
(102, 3),
(103, 3),
(104, 3),
(105, 3),
(106, 3),
(107, 3),
(108, 3),
(109, 3),
(110, 3),
(111, 3),
(112, 3),
(113, 3),
(114, 3),
(115, 3),
(116, 3),
(117, 3),
(118, 3),
(119, 3),
(120, 3),
(121, 3),
(122, 3),
(123, 3),
(124, 3),
(125, 3),
(126, 3),
(127, 3),
(128, 3),
(129, 3),
(130, 3),
(131, 3),
(132, 3),
(133, 3),
(134, 3),
(135, 3),
(136, 3),
(137, 3),
(138, 3),
(139, 3),
(140, 3),
(141, 3),
(142, 3),
(143, 3),
(144, 3),
(145, 3),
(146, 3),
(147, 3),
(148, 3),
(149, 3),
(150, 3),
(151, 3),
(152, 3),
(153, 3),
(154, 3),
(155, 3),
(156, 3),
(157, 3),
(158, 3),
(159, 3),
(160, 3),
(161, 3),
(162, 3),
(163, 3),
(164, 3),
(165, 3),
(171, 3),
(172, 3),
(173, 3),
(174, 3),
(175, 3),
(176, 3),
(177, 3),
(178, 3),
(179, 3),
(180, 3),
(181, 3),
(182, 3),
(183, 3),
(184, 3),
(185, 3),
(186, 3),
(187, 3),
(188, 3),
(189, 3),
(190, 3),
(191, 3),
(192, 3),
(193, 3),
(194, 3),
(195, 3),
(196, 3),
(197, 3),
(198, 3),
(199, 3),
(200, 3),
(201, 3),
(202, 3),
(203, 3),
(204, 3),
(205, 3),
(206, 3),
(207, 3),
(208, 3),
(209, 3),
(210, 3),
(211, 3),
(212, 3),
(213, 3),
(214, 3),
(215, 3),
(216, 3),
(217, 3),
(218, 3),
(219, 3),
(220, 3);

-- --------------------------------------------------------

--
-- Table structure for table `salary_slips`
--

CREATE TABLE `salary_slips` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `leaves` json DEFAULT NULL,
  `late_in_early_out_deduction` decimal(10,2) NOT NULL DEFAULT '0.00',
  `overtime` decimal(10,2) NOT NULL DEFAULT '0.00',
  `arrears` decimal(10,2) NOT NULL DEFAULT '0.00',
  `income_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `loan_advance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_mode` enum('bank_transfer','cash') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` tinyint UNSIGNED NOT NULL,
  `year` smallint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_slips`
--

INSERT INTO `salary_slips` (`id`, `employee_id`, `leaves`, `late_in_early_out_deduction`, `overtime`, `arrears`, `income_tax`, `loan_advance`, `payment_mode`, `month`, `year`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 5, '[{\"id\": \"1\", \"days\": \"0\"}, {\"id\": \"2\", \"days\": \"0\"}, {\"id\": \"3\", \"days\": \"2\"}]', '1.00', '2.00', '0.00', '15000.00', '50000.00', 'cash', 11, 2024, 1, 1, NULL, '2024-11-07 05:14:17', '2024-11-07 05:14:17');

-- --------------------------------------------------------

--
-- Table structure for table `salary_tax_slabs`
--

CREATE TABLE `salary_tax_slabs` (
  `id` bigint UNSIGNED NOT NULL,
  `slab_start` decimal(10,2) NOT NULL,
  `slab_end` decimal(10,2) NOT NULL,
  `tax_value` decimal(10,2) NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_tax_slabs`
--

INSERT INTO `salary_tax_slabs` (`id`, `slab_start`, `slab_end`, `tax_value`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '0.00', '600000.00', '0.00', 1, 2, NULL, '2024-11-06 04:04:01', '2024-11-06 04:04:01'),
(2, '600000.00', '1200000.00', '5.00', 1, 2, NULL, '2024-11-06 04:04:33', '2024-11-06 04:04:33'),
(3, '1200000.00', '2200000.00', '12.50', 1, 2, NULL, '2024-11-06 04:05:00', '2024-11-06 04:05:00'),
(4, '2200000.00', '3200000.00', '25.00', 1, 2, NULL, '2024-11-06 04:05:29', '2024-11-06 04:05:29'),
(5, '0.00', '600000.00', '0.00', 2, 3, NULL, '2024-11-06 05:41:43', '2024-11-06 05:41:43'),
(6, '600000.00', '1200000.00', '5.00', 2, 3, NULL, '2024-11-06 05:42:28', '2024-11-06 05:42:28'),
(7, '1200000.00', '2200000.00', '12.50', 2, 3, NULL, '2024-11-06 05:42:54', '2024-11-06 05:42:54'),
(8, '2200000.00', '3200000.00', '25.00', 2, 3, NULL, '2024-11-06 05:43:16', '2024-11-06 05:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `sales_returns`
--

CREATE TABLE `sales_returns` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_id` bigint UNSIGNED NOT NULL,
  `inclusive_tax` decimal(15,2) NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL,
  `exclusive_tax` decimal(15,2) NOT NULL,
  `discount_type` enum('flat','percent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'flat',
  `discount` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_items`
--

CREATE TABLE `sales_return_items` (
  `id` bigint UNSIGNED NOT NULL,
  `sales_return_id` bigint UNSIGNED NOT NULL,
  `product_variation_id` bigint UNSIGNED NOT NULL,
  `batch_id` bigint UNSIGNED DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `quantity` int NOT NULL,
  `tax_rate` decimal(5,2) DEFAULT NULL,
  `discount_type` enum('flat','percent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'flat',
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('EtbMiPknA4b5zLcMcLRzQMQkgk5UZ9sbx6sDe1dE', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibFVLaDVrdjJHY2RsNXlQS1NxZWtkd2UwWVR4Mk1BUUE2aFpIWTRPeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTczNTM4MzQ0ODt9fQ==', 1735385867),
('okdhMb8rnQutgJaepJFzY5dIdq5o6rVUpT0jNX00', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVW41eXg3NmVVdW54TmF6V2JQRVpETzJmcXpwZDVGUm9CcGpENGJGYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWxlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3MzUyODM4OTM7fX0=', 1735300195);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `raw_material_item_id` bigint UNSIGNED DEFAULT NULL,
  `product_variation_id` bigint UNSIGNED DEFAULT NULL,
  `batch_id` bigint UNSIGNED DEFAULT NULL,
  `goods_receiving_id` bigint UNSIGNED DEFAULT NULL,
  `finished_goods_receiving_id` bigint UNSIGNED DEFAULT NULL,
  `store_issue_requisition_id` bigint UNSIGNED DEFAULT NULL,
  `left_over_note_id` bigint UNSIGNED DEFAULT NULL,
  `sales_return_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(8,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `raw_material_item_id`, `product_variation_id`, `batch_id`, `goods_receiving_id`, `finished_goods_receiving_id`, `store_issue_requisition_id`, `left_over_note_id`, `sales_return_id`, `quantity`, `unit`, `unit_price`, `total`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(34, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 50, 'KG', '55.00', '2750.00', 1, 1, NULL, '2024-12-05 08:27:48', '2024-12-05 08:27:48'),
(35, NULL, 2, NULL, NULL, 1, NULL, NULL, NULL, NULL, 25, 'EA', '100.00', '2500.00', 1, 1, NULL, '2024-12-05 08:27:48', '2024-12-05 08:27:48'),
(36, NULL, 3, NULL, NULL, 2, NULL, NULL, NULL, NULL, 150, 'EA', '30.00', '4500.00', 1, 1, NULL, '2024-12-05 08:30:43', '2024-12-05 08:30:43'),
(37, NULL, 1, NULL, NULL, NULL, NULL, 8, NULL, NULL, 30, 'KG', '55.00', '1650.00', 1, 1, NULL, '2024-12-05 08:33:12', '2024-12-05 08:33:12'),
(38, NULL, 2, NULL, NULL, NULL, NULL, 8, NULL, NULL, 20, 'EA', '100.00', '2000.00', 1, 1, NULL, '2024-12-05 08:33:12', '2024-12-05 08:33:12'),
(39, NULL, 3, NULL, NULL, NULL, NULL, 8, NULL, NULL, 100, 'EA', '30.00', '3000.00', 1, 1, NULL, '2024-12-05 08:33:12', '2024-12-05 08:33:12'),
(40, NULL, NULL, 2, 3, NULL, 4, NULL, NULL, NULL, 90, 'Pack', '1000.00', '90000.00', 1, 1, NULL, '2024-12-05 08:35:26', '2024-12-05 08:35:26'),
(41, NULL, NULL, 3, 3, NULL, 4, NULL, NULL, NULL, 50, 'Pack', '1050.00', '52500.00', 1, 1, NULL, '2024-12-05 08:35:26', '2024-12-05 08:35:26'),
(42, NULL, 3, NULL, NULL, NULL, NULL, NULL, 3, NULL, 10, 'EA', '30.00', '300.00', 1, 1, NULL, '2024-12-05 08:37:34', '2024-12-05 08:37:34'),
(44, NULL, NULL, 2, 3, NULL, NULL, 10, NULL, NULL, 50, 'Pack', '1000.00', '50000.00', 1, 1, NULL, '2024-12-05 09:22:20', '2024-12-05 09:22:20'),
(45, NULL, 3, NULL, NULL, NULL, NULL, 9, NULL, NULL, 5, 'EA', '30.00', '150.00', 1, 1, NULL, '2024-12-07 06:06:56', '2024-12-07 06:06:56');

-- --------------------------------------------------------

--
-- Table structure for table `store_issue_requisitions`
--

CREATE TABLE `store_issue_requisitions` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chart_of_account_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `batch_id` bigint UNSIGNED DEFAULT NULL,
  `dn_gp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `is_general` int NOT NULL,
  `is_production` int NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_issue_requisitions`
--

INSERT INTO `store_issue_requisitions` (`id`, `code`, `chart_of_account_id`, `product_id`, `batch_id`, `dn_gp`, `company_id`, `is_general`, `is_production`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(8, 'SIR00001', NULL, 4, 3, 'DN00001', 1, 0, 1, 1, NULL, '2024-12-05 08:33:12', '2024-12-05 08:33:12'),
(9, 'SIR00002', 1, NULL, NULL, 'DN00002', 1, 1, 0, 1, 1, '2024-12-05 08:46:43', '2024-12-07 06:06:56'),
(10, 'SIR00003', 1, NULL, NULL, 'DN00003', 1, 1, 0, 1, NULL, '2024-12-05 09:22:20', '2024-12-05 09:22:20');

-- --------------------------------------------------------

--
-- Table structure for table `store_issue_requisition_items`
--

CREATE TABLE `store_issue_requisition_items` (
  `id` bigint UNSIGNED NOT NULL,
  `store_issue_requisition_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `raw_material_item_id` bigint UNSIGNED DEFAULT NULL,
  `product_variation_id` bigint UNSIGNED DEFAULT NULL,
  `batch_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_issue_requisition_items`
--

INSERT INTO `store_issue_requisition_items` (`id`, `store_issue_requisition_id`, `product_id`, `raw_material_item_id`, `product_variation_id`, `batch_id`, `quantity`, `unit`, `unit_price`, `total`, `created_at`, `updated_at`) VALUES
(12, 8, NULL, 1, NULL, NULL, 30, 'KG', '55.00', '1650.00', '2024-12-05 08:33:12', '2024-12-05 08:33:12'),
(13, 8, NULL, 2, NULL, NULL, 20, 'EA', '100.00', '2000.00', '2024-12-05 08:33:12', '2024-12-05 08:33:12'),
(14, 8, NULL, 3, NULL, NULL, 100, 'EA', '30.00', '3000.00', '2024-12-05 08:33:12', '2024-12-05 08:33:12'),
(16, 10, NULL, NULL, 2, 3, 50, 'Pack', '1000.00', '50000.00', '2024-12-05 09:22:20', '2024-12-05 09:22:20'),
(17, 9, NULL, 3, NULL, NULL, 5, 'EA', '30.00', '150.00', '2024-12-07 06:06:56', '2024-12-07 06:06:56');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `name`, `email`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 'Superadmin', 'superadmin@gmail.com', NULL, NULL, '$2y$12$NuImJ31lGdylo.5N93QZjudxo9vsPGKmjioW1neSDWDOqclg7YCui', NULL, '2024-11-06 03:01:15', '2024-12-27 06:29:43'),
(2, 2, 'Test Admin', 'testing@gmail.com', NULL, NULL, '$2y$12$0WkLR6sXdcTiXaiQdxz7xuZRHIbl2pt0oixlA.uFdzd1FqqdSTpDG', NULL, '2024-11-06 04:02:08', '2024-11-06 04:02:08'),
(3, 4, 'Test Admin 2', 'testing35@gmail.com', NULL, NULL, '$2y$12$4gQ9s/TvdX.QxYc3EVg/geHEblwpO3YX08dD0RhZKxE5dGcnc9mQe', NULL, '2024-11-06 04:02:37', '2024-11-06 07:12:54'),
(4, 3, 'Test Manager', 'testing2@gmail.com', NULL, NULL, '$2y$12$bcMjwOThSgTMGxY2OvNFyumNKMcp0Y3CRT1YUiWnDY/VPIWXEvSr.', NULL, '2024-11-06 04:16:48', '2024-11-06 04:16:48'),
(5, 5, 'Test User', 'testinguser@gmail.com', NULL, NULL, '$2y$12$UNT6ySfqNssVpjZs2xMUGeSWb3CDKuDza.xBwIpjykTwu/NvP03MO', NULL, '2024-11-06 04:42:41', '2024-11-06 04:42:41'),
(6, 6, 'Test Manager 2', 'testing5@gmail.com', NULL, NULL, '$2y$12$gVma9NGAOq.VJI57fsh7KOoTZLtPe0hvMN1CTMKhUQtoGAVd8E8Wi', NULL, '2024-11-06 05:37:10', '2024-11-06 05:37:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banks_country_id_foreign` (`country_id`),
  ADD KEY `banks_created_by_foreign` (`created_by`),
  ADD KEY `banks_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batches_company_id_foreign` (`company_id`),
  ADD KEY `batches_product_id_foreign` (`product_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branches_company_id_foreign` (`company_id`),
  ADD KEY `branches_country_id_foreign` (`country_id`),
  ADD KEY `branches_city_id_foreign` (`city_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chart_of_accounts_code_company_id_unique` (`code`,`company_id`),
  ADD KEY `chart_of_accounts_company_id_foreign` (`company_id`),
  ADD KEY `chart_of_accounts_created_by_foreign` (`created_by`),
  ADD KEY `chart_of_accounts_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_country_id_foreign` (`country_id`),
  ADD KEY `companies_city_id_foreign` (`city_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `credit_notes_company_id_foreign` (`company_id`),
  ADD KEY `credit_notes_party_id_foreign` (`party_id`);

--
-- Indexes for table `credit_note_items`
--
ALTER TABLE `credit_note_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `credit_note_items_credit_note_id_foreign` (`credit_note_id`),
  ADD KEY `credit_note_items_chart_of_account_id_foreign` (`chart_of_account_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_company_id_foreign` (`company_id`),
  ADD KEY `departments_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_company_id_foreign` (`company_id`);

--
-- Indexes for table `dosage_forms`
--
ALTER TABLE `dosage_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dosage_forms_company_id_foreign` (`company_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_designation_id_foreign` (`designation_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_bank_id_foreign` (`bank_id`),
  ADD KEY `employees_branch_id_foreign` (`branch_id`),
  ADD KEY `employees_company_id_foreign` (`company_id`),
  ADD KEY `employees_created_by_foreign` (`created_by`),
  ADD KEY `employees_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `finished_goods_receivings`
--
ALTER TABLE `finished_goods_receivings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `finished_goods_receivings_company_id_foreign` (`company_id`),
  ADD KEY `finished_goods_receivings_batch_id_foreign` (`batch_id`),
  ADD KEY `finished_goods_receivings_product_id_foreign` (`product_id`);

--
-- Indexes for table `finished_goods_receiving_items`
--
ALTER TABLE `finished_goods_receiving_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fgr_items_fgr_id_foreign` (`finished_goods_receiving_id`),
  ADD KEY `finished_goods_receiving_items_product_variation_id_foreign` (`product_variation_id`);

--
-- Indexes for table `goods_receivings`
--
ALTER TABLE `goods_receivings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_receivings_company_id_foreign` (`company_id`),
  ADD KEY `goods_receivings_invoice_id_foreign` (`invoice_id`),
  ADD KEY `goods_receivings_party_id_foreign` (`party_id`);

--
-- Indexes for table `goods_receiving_items`
--
ALTER TABLE `goods_receiving_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_receiving_items_goods_receiving_id_foreign` (`goods_receiving_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_party_id_foreign` (`party_id`),
  ADD KEY `invoices_company_id_foreign` (`company_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_vouchers`
--
ALTER TABLE `journal_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_vouchers_company_id_foreign` (`company_id`);

--
-- Indexes for table `journal_voucher_items`
--
ALTER TABLE `journal_voucher_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_voucher_items_journal_voucher_id_foreign` (`journal_voucher_id`),
  ADD KEY `journal_voucher_items_chart_of_account_id_foreign` (`chart_of_account_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_employee_id_foreign` (`employee_id`),
  ADD KEY `leaves_leave_type_id_foreign` (`leave_type_id`),
  ADD KEY `leaves_company_id_foreign` (`company_id`),
  ADD KEY `leaves_created_by_foreign` (`created_by`),
  ADD KEY `leaves_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_types_company_id_foreign` (`company_id`),
  ADD KEY `leave_types_created_by_foreign` (`created_by`),
  ADD KEY `leave_types_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `left_over_notes`
--
ALTER TABLE `left_over_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `left_over_notes_company_id_foreign` (`company_id`),
  ADD KEY `left_over_notes_product_id_foreign` (`product_id`),
  ADD KEY `left_over_notes_store_issue_requisition_id_foreign` (`store_issue_requisition_id`);

--
-- Indexes for table `left_over_note_items`
--
ALTER TABLE `left_over_note_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `left_over_note_items_left_over_note_id_foreign` (`left_over_note_id`),
  ADD KEY `left_over_note_items_raw_material_item_id_foreign` (`raw_material_item_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_employee_id_foreign` (`employee_id`),
  ADD KEY `loans_company_id_foreign` (`company_id`),
  ADD KEY `loans_created_by_foreign` (`created_by`),
  ADD KEY `loans_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `model_has_roles_user_id_foreign` (`user_id`);

--
-- Indexes for table `packing_types`
--
ALTER TABLE `packing_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packing_types_company_id_foreign` (`company_id`);

--
-- Indexes for table `pack_forms`
--
ALTER TABLE `pack_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pack_forms_company_id_foreign` (`company_id`),
  ADD KEY `pack_forms_created_by_foreign` (`created_by`),
  ADD KEY `pack_forms_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `pack_sizes`
--
ALTER TABLE `pack_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pack_sizes_company_id_foreign` (`company_id`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parties_created_by_foreign` (`created_by`),
  ADD KEY `parties_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_types_company_id_foreign` (`company_id`);

--
-- Indexes for table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_vouchers_company_id_foreign` (`company_id`),
  ADD KEY `payment_vouchers_party_id_foreign` (`party_id`);

--
-- Indexes for table `payment_voucher_items`
--
ALTER TABLE `payment_voucher_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_voucher_items_payment_voucher_id_foreign` (`payment_voucher_id`),
  ADD KEY `payment_voucher_items_chart_of_account_id_foreign` (`chart_of_account_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_company_id_foreign` (`company_id`),
  ADD KEY `products_product_group_id_foreign` (`product_group_id`);

--
-- Indexes for table `product_groups`
--
ALTER TABLE `product_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_groups_company_id_foreign` (`company_id`),
  ADD KEY `product_groups_created_by_foreign` (`created_by`),
  ADD KEY `product_groups_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_metas`
--
ALTER TABLE `product_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_metas_company_id_foreign` (`company_id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variations_company_id_foreign` (`company_id`),
  ADD KEY `product_variations_product_id_foreign` (`product_id`),
  ADD KEY `product_variations_dosage_form_id_foreign` (`dosage_form_id`),
  ADD KEY `product_variations_pack_form_id_foreign` (`pack_form_id`),
  ADD KEY `product_variations_packing_type_id_foreign` (`packing_type_id`),
  ADD KEY `product_variations_pack_size_id_foreign` (`pack_size_id`);

--
-- Indexes for table `purchase_requisitions`
--
ALTER TABLE `purchase_requisitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_requisitions_company_id_foreign` (`company_id`);

--
-- Indexes for table `purchase_requisition_items`
--
ALTER TABLE `purchase_requisition_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_requisition_items_company_id_foreign` (`company_id`),
  ADD KEY `purchase_requisition_items_purchase_requisition_id_foreign` (`purchase_requisition_id`);

--
-- Indexes for table `raw_material_items`
--
ALTER TABLE `raw_material_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raw_material_items_company_id_foreign` (`company_id`);

--
-- Indexes for table `receipt_vouchers`
--
ALTER TABLE `receipt_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipt_vouchers_company_id_foreign` (`company_id`),
  ADD KEY `receipt_vouchers_party_id_foreign` (`party_id`);

--
-- Indexes for table `receipt_voucher_items`
--
ALTER TABLE `receipt_voucher_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipt_voucher_items_receipt_voucher_id_foreign` (`receipt_voucher_id`),
  ADD KEY `receipt_voucher_items_chart_of_account_id_foreign` (`chart_of_account_id`);

--
-- Indexes for table `rejection_return_notes`
--
ALTER TABLE `rejection_return_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rejection_return_notes_company_id_foreign` (`company_id`),
  ADD KEY `rejection_return_notes_party_id_foreign` (`party_id`),
  ADD KEY `rejection_return_notes_invoice_id_foreign` (`invoice_id`),
  ADD KEY `rejection_return_notes_store_issue_requisition_id_foreign` (`store_issue_requisition_id`);

--
-- Indexes for table `rejection_return_note_items`
--
ALTER TABLE `rejection_return_note_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rejection_return_note_items_rejection_return_note_id_foreign` (`rejection_return_note_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `salary_slips`
--
ALTER TABLE `salary_slips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_slips_employee_id_foreign` (`employee_id`),
  ADD KEY `salary_slips_company_id_foreign` (`company_id`),
  ADD KEY `salary_slips_created_by_foreign` (`created_by`),
  ADD KEY `salary_slips_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `salary_tax_slabs`
--
ALTER TABLE `salary_tax_slabs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_tax_slabs_company_id_foreign` (`company_id`);

--
-- Indexes for table `sales_returns`
--
ALTER TABLE `sales_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_returns_company_id_foreign` (`company_id`),
  ADD KEY `sales_returns_party_id_foreign` (`party_id`);

--
-- Indexes for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_return_items_sales_return_id_foreign` (`sales_return_id`),
  ADD KEY `sales_return_items_product_variation_id_foreign` (`product_variation_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_company_id_foreign` (`company_id`);

--
-- Indexes for table `store_issue_requisitions`
--
ALTER TABLE `store_issue_requisitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_issue_requisitions_company_id_foreign` (`company_id`);

--
-- Indexes for table `store_issue_requisition_items`
--
ALTER TABLE `store_issue_requisition_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_issue_requisition_items_store_issue_requisition_id_foreign` (`store_issue_requisition_id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxes_company_id_foreign` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `credit_notes`
--
ALTER TABLE `credit_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `credit_note_items`
--
ALTER TABLE `credit_note_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dosage_forms`
--
ALTER TABLE `dosage_forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finished_goods_receivings`
--
ALTER TABLE `finished_goods_receivings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `finished_goods_receiving_items`
--
ALTER TABLE `finished_goods_receiving_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `goods_receivings`
--
ALTER TABLE `goods_receivings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `goods_receiving_items`
--
ALTER TABLE `goods_receiving_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_vouchers`
--
ALTER TABLE `journal_vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `journal_voucher_items`
--
ALTER TABLE `journal_voucher_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `left_over_notes`
--
ALTER TABLE `left_over_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `left_over_note_items`
--
ALTER TABLE `left_over_note_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `packing_types`
--
ALTER TABLE `packing_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pack_forms`
--
ALTER TABLE `pack_forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pack_sizes`
--
ALTER TABLE `pack_sizes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_voucher_items`
--
ALTER TABLE `payment_voucher_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_groups`
--
ALTER TABLE `product_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_metas`
--
ALTER TABLE `product_metas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase_requisitions`
--
ALTER TABLE `purchase_requisitions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_requisition_items`
--
ALTER TABLE `purchase_requisition_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `raw_material_items`
--
ALTER TABLE `raw_material_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `receipt_vouchers`
--
ALTER TABLE `receipt_vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `receipt_voucher_items`
--
ALTER TABLE `receipt_voucher_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rejection_return_notes`
--
ALTER TABLE `rejection_return_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rejection_return_note_items`
--
ALTER TABLE `rejection_return_note_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `salary_slips`
--
ALTER TABLE `salary_slips`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `salary_tax_slabs`
--
ALTER TABLE `salary_tax_slabs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales_returns`
--
ALTER TABLE `sales_returns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `store_issue_requisitions`
--
ALTER TABLE `store_issue_requisitions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `store_issue_requisition_items`
--
ALTER TABLE `store_issue_requisition_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banks`
--
ALTER TABLE `banks`
  ADD CONSTRAINT `banks_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `banks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `banks_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `batches_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branches_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branches_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD CONSTRAINT `chart_of_accounts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chart_of_accounts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `chart_of_accounts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companies_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD CONSTRAINT `credit_notes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `credit_notes_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `credit_note_items`
--
ALTER TABLE `credit_note_items`
  ADD CONSTRAINT `credit_note_items_chart_of_account_id_foreign` FOREIGN KEY (`chart_of_account_id`) REFERENCES `chart_of_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `credit_note_items_credit_note_id_foreign` FOREIGN KEY (`credit_note_id`) REFERENCES `credit_notes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `departments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `designations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dosage_forms`
--
ALTER TABLE `dosage_forms`
  ADD CONSTRAINT `dosage_forms_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employees_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `finished_goods_receivings`
--
ALTER TABLE `finished_goods_receivings`
  ADD CONSTRAINT `finished_goods_receivings_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finished_goods_receivings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finished_goods_receivings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `finished_goods_receiving_items`
--
ALTER TABLE `finished_goods_receiving_items`
  ADD CONSTRAINT `fgr_items_fgr_id_foreign` FOREIGN KEY (`finished_goods_receiving_id`) REFERENCES `finished_goods_receivings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finished_goods_receiving_items_product_variation_id_foreign` FOREIGN KEY (`product_variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goods_receivings`
--
ALTER TABLE `goods_receivings`
  ADD CONSTRAINT `goods_receivings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goods_receivings_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goods_receivings_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goods_receiving_items`
--
ALTER TABLE `goods_receiving_items`
  ADD CONSTRAINT `goods_receiving_items_goods_receiving_id_foreign` FOREIGN KEY (`goods_receiving_id`) REFERENCES `goods_receivings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journal_vouchers`
--
ALTER TABLE `journal_vouchers`
  ADD CONSTRAINT `journal_vouchers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journal_voucher_items`
--
ALTER TABLE `journal_voucher_items`
  ADD CONSTRAINT `journal_voucher_items_chart_of_account_id_foreign` FOREIGN KEY (`chart_of_account_id`) REFERENCES `chart_of_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_voucher_items_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaves_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaves_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaves_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD CONSTRAINT `leave_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leave_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leave_types_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `left_over_notes`
--
ALTER TABLE `left_over_notes`
  ADD CONSTRAINT `left_over_notes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `left_over_notes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `left_over_notes_store_issue_requisition_id_foreign` FOREIGN KEY (`store_issue_requisition_id`) REFERENCES `store_issue_requisitions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `left_over_note_items`
--
ALTER TABLE `left_over_note_items`
  ADD CONSTRAINT `left_over_note_items_left_over_note_id_foreign` FOREIGN KEY (`left_over_note_id`) REFERENCES `left_over_notes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `left_over_note_items_raw_material_item_id_foreign` FOREIGN KEY (`raw_material_item_id`) REFERENCES `raw_material_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loans_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `packing_types`
--
ALTER TABLE `packing_types`
  ADD CONSTRAINT `packing_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pack_forms`
--
ALTER TABLE `pack_forms`
  ADD CONSTRAINT `pack_forms_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pack_forms_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pack_forms_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pack_sizes`
--
ALTER TABLE `pack_sizes`
  ADD CONSTRAINT `pack_sizes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parties`
--
ALTER TABLE `parties`
  ADD CONSTRAINT `parties_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `parties_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD CONSTRAINT `payment_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  ADD CONSTRAINT `payment_vouchers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_vouchers_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_voucher_items`
--
ALTER TABLE `payment_voucher_items`
  ADD CONSTRAINT `payment_voucher_items_chart_of_account_id_foreign` FOREIGN KEY (`chart_of_account_id`) REFERENCES `chart_of_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_voucher_items_payment_voucher_id_foreign` FOREIGN KEY (`payment_voucher_id`) REFERENCES `payment_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_product_group_id_foreign` FOREIGN KEY (`product_group_id`) REFERENCES `product_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_groups`
--
ALTER TABLE `product_groups`
  ADD CONSTRAINT `product_groups_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_groups_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_metas`
--
ALTER TABLE `product_metas`
  ADD CONSTRAINT `product_metas_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variations_dosage_form_id_foreign` FOREIGN KEY (`dosage_form_id`) REFERENCES `dosage_forms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variations_pack_form_id_foreign` FOREIGN KEY (`pack_form_id`) REFERENCES `pack_forms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variations_pack_size_id_foreign` FOREIGN KEY (`pack_size_id`) REFERENCES `pack_sizes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variations_packing_type_id_foreign` FOREIGN KEY (`packing_type_id`) REFERENCES `packing_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_requisitions`
--
ALTER TABLE `purchase_requisitions`
  ADD CONSTRAINT `purchase_requisitions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_requisition_items`
--
ALTER TABLE `purchase_requisition_items`
  ADD CONSTRAINT `purchase_requisition_items_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_requisition_items_purchase_requisition_id_foreign` FOREIGN KEY (`purchase_requisition_id`) REFERENCES `purchase_requisitions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `raw_material_items`
--
ALTER TABLE `raw_material_items`
  ADD CONSTRAINT `raw_material_items_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `receipt_vouchers`
--
ALTER TABLE `receipt_vouchers`
  ADD CONSTRAINT `receipt_vouchers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `receipt_vouchers_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `receipt_voucher_items`
--
ALTER TABLE `receipt_voucher_items`
  ADD CONSTRAINT `receipt_voucher_items_chart_of_account_id_foreign` FOREIGN KEY (`chart_of_account_id`) REFERENCES `chart_of_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `receipt_voucher_items_receipt_voucher_id_foreign` FOREIGN KEY (`receipt_voucher_id`) REFERENCES `receipt_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rejection_return_notes`
--
ALTER TABLE `rejection_return_notes`
  ADD CONSTRAINT `rejection_return_notes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rejection_return_notes_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rejection_return_notes_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rejection_return_notes_store_issue_requisition_id_foreign` FOREIGN KEY (`store_issue_requisition_id`) REFERENCES `store_issue_requisitions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rejection_return_note_items`
--
ALTER TABLE `rejection_return_note_items`
  ADD CONSTRAINT `rejection_return_note_items_rejection_return_note_id_foreign` FOREIGN KEY (`rejection_return_note_id`) REFERENCES `rejection_return_notes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_slips`
--
ALTER TABLE `salary_slips`
  ADD CONSTRAINT `salary_slips_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `salary_slips_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `salary_slips_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `salary_slips_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `salary_tax_slabs`
--
ALTER TABLE `salary_tax_slabs`
  ADD CONSTRAINT `salary_tax_slabs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_returns`
--
ALTER TABLE `sales_returns`
  ADD CONSTRAINT `sales_returns_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_returns_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  ADD CONSTRAINT `sales_return_items_product_variation_id_foreign` FOREIGN KEY (`product_variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_return_items_sales_return_id_foreign` FOREIGN KEY (`sales_return_id`) REFERENCES `sales_returns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `store_issue_requisitions`
--
ALTER TABLE `store_issue_requisitions`
  ADD CONSTRAINT `store_issue_requisitions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `store_issue_requisition_items`
--
ALTER TABLE `store_issue_requisition_items`
  ADD CONSTRAINT `store_issue_requisition_items_store_issue_requisition_id_foreign` FOREIGN KEY (`store_issue_requisition_id`) REFERENCES `store_issue_requisitions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `taxes`
--
ALTER TABLE `taxes`
  ADD CONSTRAINT `taxes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

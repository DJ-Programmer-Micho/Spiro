-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 01:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `glamssdy_glam_production`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `user_id`, `start_time`, `end_time`, `duration`, `date`, `created_at`, `updated_at`) VALUES
(4, 14, '10:36:00', '11:42:00', 1, '2024-03-02', '2024-03-02 19:42:20', '2024-03-03 12:51:04'),
(6, 11, '16:36:00', '22:42:00', 6, '2024-03-02', '2024-03-02 19:43:03', '2024-03-02 19:43:03'),
(7, 18, '09:30:00', '22:30:00', 13, '2024-03-01', '2024-03-02 19:45:28', '2024-03-03 12:08:40'),
(8, 11, '09:16:00', '22:08:00', 12, '2024-02-29', '2024-03-03 09:11:06', '2024-03-03 12:53:50'),
(9, 14, '09:00:00', '22:00:00', 13, '2024-03-03', '2024-03-03 12:12:53', '2024-03-03 12:12:53'),
(12, 14, '07:45:00', '17:00:00', 9, '2024-03-03', '2024-03-03 16:45:37', '2024-03-03 16:46:14'),
(14, 11, '01:34:00', '22:35:00', 21, '1981-01-02', '2024-03-03 17:17:37', '2024-03-03 17:17:37'),
(15, 14, '08:17:00', NULL, 0, '2024-03-03', '2024-03-03 17:17:59', '2024-03-03 17:17:59'),
(16, 11, '08:19:00', NULL, 0, '2024-03-03', '2024-03-03 17:19:28', '2024-03-03 17:19:28'),
(17, 14, '08:21:00', NULL, 0, '2024-03-03', '2024-03-03 17:21:50', '2024-03-03 17:21:50'),
(18, 14, '20:22:00', '23:28:00', 3, '2024-03-03', '2024-03-03 17:22:45', '2024-03-03 17:28:31'),
(19, 14, '20:22:00', NULL, 0, '2024-03-03', '2024-03-03 17:23:09', '2024-03-03 17:23:09'),
(20, 14, '20:22:00', NULL, 0, '2024-03-03', '2024-03-03 17:23:18', '2024-03-03 17:23:18'),
(21, 14, '20:22:00', NULL, 0, '2024-03-03', '2024-03-03 17:24:01', '2024-03-03 17:24:01'),
(23, 14, '20:22:00', NULL, 0, '2024-03-03', '2024-03-03 17:25:22', '2024-03-03 17:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `bills_expenses`
--

CREATE TABLE `bills_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cost_dollar` int(11) NOT NULL,
  `cost_iraqi` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills_expenses`
--

INSERT INTO `bills_expenses` (`id`, `bill_name`, `description`, `cost_dollar`, `cost_iraqi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Water Tax', 'Government TAX', 50, 75000, 1, '2023-12-17 16:33:52', '2023-12-17 16:33:52'),
(2, 'Elec.', 'For the Stupid Government', 50, 75000, 1, '2023-12-19 17:15:32', '2023-12-19 17:15:32'),
(3, 'Rent', 'Studio Rent', 350, 525000, 1, '2023-12-21 08:07:48', '2024-01-07 07:09:55'),
(4, 'Gas for sopa', 'Only three months, (winter time)', 20, 30000, 1, '2024-01-07 07:09:38', '2024-01-07 07:09:38');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `branch_manager` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `systematic` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`systematic`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashes`
--

CREATE TABLE `cashes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `cash_date` date DEFAULT NULL,
  `payments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payments`)),
  `grand_total_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `due_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `grand_total_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `due_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `cash_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cashes`
--

INSERT INTO `cashes` (`id`, `invoice_id`, `cash_date`, `payments`, `grand_total_dollar`, `due_dollar`, `grand_total_iraqi`, `due_iraqi`, `cash_status`, `created_at`, `updated_at`) VALUES
(56, 101, '2024-01-07', '[{\"payment_date\":\"2024-01-07\",\"paymentAmountDollar\":\"100\",\"paymentAmountIraqi\":165000},{\"payment_date\":\"2024-01-08\",\"paymentAmountDollar\":\"400\",\"paymentAmountIraqi\":660000}]', 500, 0, 825000, 0, 'Complete', '2024-01-07 08:48:54', '2024-01-07 08:54:46'),
(59, 107, '2024-02-18', '[{\"payment_date\":\"2024-02-19\",\"paymentAmountDollar\":\"500\",\"paymentAmountIraqi\":750000},{\"payment_date\":\"2024-02-25\",\"paymentAmountDollar\":\"999\",\"paymentAmountIraqi\":1498500}]', 2550, 1051, 3825000, 1576500, 'Not Complete', '2024-02-18 07:17:24', '2024-02-20 08:31:32'),
(60, 87, '2024-02-18', '[{\"payment_date\":\"2023-12-29\",\"paymentAmountDollar\":\"1000\",\"paymentAmountIraqi\":\"1500000\"},{\"payment_date\":\"2024-02-18\",\"paymentAmountDollar\":\"1500\",\"paymentAmountIraqi\":2250000}]', 2500, 0, 3750000, 0, 'Complete', '2024-02-18 11:25:05', '2024-02-18 11:25:05'),
(61, 106, '2024-02-18', '[{\"payment_date\":\"2024-02-18\",\"paymentAmountDollar\":\"500\",\"paymentAmountIraqi\":\"750000\"}]', 500, 0, 750000, 0, 'Complete', '2024-02-18 11:33:30', '2024-02-18 11:33:30');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_one` varchar(255) DEFAULT NULL,
  `phone_two` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `country`, `city`, `address`, `email`, `phone_one`, `phone_two`, `created_at`, `updated_at`) VALUES
(1, 'Max Maxico', 'Iraq', 'Erbil', 'Anakawa', 'a@acom', '0654789621', '012354987', '2023-12-14 08:05:10', '2024-01-07 09:46:48'),
(2, 'Shaheen 4', 'Iraq', 'Erbil', 'Next to Blue Trash', 'cat@cat.cin', '065489654654', '65465465465', '2023-12-17 09:44:11', '2024-02-20 04:43:17'),
(3, 'shokrea', 'Basra', 'Basra', 'next to red trash', 'Shokrea@fib.vom', '+96475123', '+96477012354', '2023-12-17 09:45:28', '2024-01-07 06:26:10'),
(4, 'Gabriel Valdez', 'Dolor quam sequi nob', 'Aut voluptate offici', 'Sequi fuga Eos eni', 'foto@mailinator.com', '+1 (748) 687-5327', '+1 (736) 871-7714', '2023-12-17 14:02:21', '2023-12-17 14:02:21'),
(5, 'client 2', 'iraq', 'Erbil', 'Ankawa', 'a@a.com', '654646546', '46546546465465', '2023-12-17 16:30:49', '2023-12-17 16:31:01'),
(6, 'mine yasser', 'Japan', 'Honk kong', 'Next to trash', 'mine@me.com', '654789123', '65485213', '2023-12-18 07:35:48', '2024-02-20 04:51:23'),
(7, 'asd abc', 'asd', 'asd', 'asd', '', '123', '', '2023-12-19 17:11:59', '2024-02-20 04:52:06'),
(8, 'Georgeer', 'Iraq', 'Erbil', 'asdasd', 'a@a.com', '+965478456sdfsdf', '+654789545sdfsdf', '2023-12-21 07:58:25', '2024-02-20 05:06:56'),
(9, 'Ghusain', 'Iraq', 'Dohuk', 'dd', 'gh@a.com', '32132132', '32132132132', '2023-12-21 08:17:40', '2023-12-21 08:17:40'),
(10, 'Sam', 'USA', 'NY', 'next to bar', '', '+1456878948', '+155454723', '2024-01-07 06:26:43', '2024-01-07 06:26:43'),
(11, 'Blacv', 'Iraq', 'lkj', 'lkj', '', '+987564654', '+4654684', '2024-01-07 09:47:33', '2024-01-07 09:47:33'),
(13, 'George and sara', 'Duhok', 'دهوك', 'st1', NULL, '+964750123456789', NULL, '2024-02-18 07:03:17', '2024-02-18 07:03:17'),
(14, 'ghusain', 'iraq', 'duhok', 'st1', NULL, '1234564567454', NULL, '2024-02-18 08:13:00', '2024-02-18 08:13:00'),
(15, 'test', NULL, NULL, 'ankawa', NULL, '+964750123456', '+96475621516', '2024-02-19 08:58:19', '2024-02-19 08:58:19'),
(16, 'user test 1', NULL, NULL, 'Duhok', NULL, '+964512302158', '0770123456789', '2024-02-20 04:52:38', '2024-02-20 04:52:38'),
(17, 'saddsa', NULL, NULL, 'asdasd', NULL, '2342342', '34234234', '2024-02-20 05:06:36', '2024-02-20 05:06:36'),
(18, 'asd', NULL, NULL, 'asd', NULL, '321', '321', '2024-02-20 05:40:18', '2024-02-20 05:40:18'),
(19, 'asdd', NULL, NULL, 'asd', NULL, '321', '321', '2024-02-20 05:41:53', '2024-02-20 05:41:53'),
(20, 'wow', NULL, NULL, 'aSD', NULL, '321654654321', '1215461223', '2024-02-20 06:06:36', '2024-02-20 06:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `emp_tasks`
--

CREATE TABLE `emp_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `tasks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`tasks`)),
  `progress` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `task_status` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `approved` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emp_tasks`
--

INSERT INTO `emp_tasks` (`id`, `invoice_id`, `tasks`, `progress`, `task_status`, `status`, `approved`, `created_at`, `updated_at`) VALUES
(25, 87, '[{\"name\":\"1\",\"task\":\"3\",\"start_date\":\"2024-01-02\",\"end_date\":\"2024-01-05\",\"progress\":\"25\"},{\"name\":\"10\",\"task\":\"4\",\"start_date\":\"2024-01-16\",\"end_date\":\"2024-02-01\",\"progress\":\"90\"},{\"name\":\"10\",\"task\":\"3\",\"start_date\":\"2024-01-04\",\"end_date\":\"2024-01-07\",\"progress\":\"80\"}]', 65, 'In Process', 1, 0, '2024-01-02 07:59:18', '2024-01-07 09:27:09'),
(36, 109, '[{\"name\":\"18\",\"task\":\"1\",\"start_date\":\"2024-02-21\",\"end_date\":\"2024-02-22\",\"progress\":\"100\"},{\"name\":\"14\",\"task\":\"2\",\"start_date\":\"2024-02-21\",\"end_date\":\"2024-02-22\",\"progress\":0}]', 50, 'In Process', 1, 0, '2024-02-18 11:38:03', '2024-02-18 11:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `cost_dollar` varchar(255) NOT NULL,
  `cost_iraqi` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `payed_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `item`, `type`, `cost_dollar`, `cost_iraqi`, `description`, `payed_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Elec.', 'Bill', '50', '75000', 'For the Stupid Government', '2023-12-15', 1, '2023-12-19 17:17:46', '2023-12-19 17:17:46'),
(2, 'George', 'Salary', '400', '600000', 'Photo', '2023-12-01', 1, '2023-12-19 17:18:35', '2023-12-19 17:18:35'),
(3, 'Gas', 'Other', '20', '30000', 'Gas for Heating', '2023-12-31', 1, '2023-12-19 17:19:07', '2023-12-19 17:19:07'),
(4, 'Rent', 'Bill', '400', '600000', 'Studio Rent', '2023-12-01', 1, '2023-12-21 08:08:31', '2023-12-21 08:08:31'),
(5, 'Nazar Mohammed', 'Salary', '250', '750000', 'Video Graphic - half salary', '2023-12-21', 1, '2023-12-21 08:10:06', '2023-12-21 08:10:06'),
(6, 'Battery Camera', 'Other', '20', '30000', 'Battery for sony', '2023-12-21', 0, '2023-12-21 08:10:58', '2024-01-07 06:57:50'),
(7, 'Water Tax', 'Bill', '10', '15000', 'Government TAX', '2024-01-07', 1, '2024-01-07 06:58:34', '2024-01-07 06:58:34'),
(8, 'New EMP', 'Salary', '200', '300000', 'Editor', '2024-01-07', 1, '2024-01-07 06:58:58', '2024-01-07 06:58:58'),
(9, 'Deposit', 'Other', '100', '150000', 'Ahmed took extra money', '2024-01-07', 1, '2024-01-07 06:59:32', '2024-01-07 06:59:32'),
(10, 'shmal', 'Salary', '50', '75000', 'سحب من محل قبل راتب', '2024-02-18', 1, '2024-02-18 07:36:33', '2024-02-18 07:36:33'),
(11, 'shmal', 'Salary', '100', '150000', 'سحب', '2024-02-20', 1, '2024-02-18 07:37:34', '2024-02-18 07:37:34'),
(12, 'Sara', 'Salary', '50', '75000', 'لاىشسلاىةن', '2024-02-18', 1, '2024-02-18 07:39:23', '2024-02-18 07:39:23'),
(13, 'Rent', 'Bill', '350', '525000', 'Studio Rent', '2024-02-29', 1, '2024-02-18 07:40:08', '2024-02-18 07:40:08'),
(14, 'nizar', 'Salary', '1000', '1500000', 'video editer', '2024-02-18', 1, '2024-02-18 10:05:52', '2024-02-18 10:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`services`)),
  `notes` longtext DEFAULT NULL,
  `total_amount_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `tax_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `discount_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `first_pay_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `grand_total_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `due_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `total_amount_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `tax_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `discount_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `first_pay_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `grand_total_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `due_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `exchange_rate` varchar(255) NOT NULL DEFAULT '1500',
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `quotation_id`, `client_id`, `payment_id`, `invoice_date`, `description`, `services`, `notes`, `total_amount_dollar`, `tax_dollar`, `discount_dollar`, `first_pay_dollar`, `grand_total_dollar`, `due_dollar`, `total_amount_iraqi`, `tax_iraqi`, `discount_iraqi`, `first_pay_iraqi`, `grand_total_iraqi`, `due_iraqi`, `exchange_rate`, `status`, `created_at`, `updated_at`) VALUES
(87, NULL, 3, 1, '2023-12-29', 'FINAL TEST', '[{\"actionDate\":\"2024-01-23\",\"description\":\"T1\",\"services\":[{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":112500,\"serviceQty\":\"4\",\"serviceTotalDollar\":300,\"serviceTotalIraqi\":450000},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":525000,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":525000}]},{\"actionDate\":\"2024-01-06\",\"description\":\"T2\",\"services\":[{\"serviceCode\":\"#PTH20\",\"select_service_data\":\"4\",\"serviceDescription\":\"20 Photo Service\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":150000,\"serviceQty\":\"2\",\"serviceTotalDollar\":200,\"serviceTotalIraqi\":300000}]},{\"actionDate\":\"2024-01-12\",\"description\":\"T3 Long Description Check\",\"services\":[{\"serviceCode\":\"#PTH20\",\"select_service_data\":\"4\",\"serviceDescription\":\"20 Photo Service\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":150000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":150000},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":525000,\"serviceQty\":\"4\",\"serviceTotalDollar\":1400,\"serviceTotalIraqi\":2100000},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":525000,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":525000}]}]', 'FINAL TEST', 2700, 0, 0, 1000, 2500, 1500, 4050000, 0, 300000, 1500000, 3750000, 2250000, '1500', 1, '2023-12-29 15:59:21', '2023-12-29 15:59:21'),
(101, NULL, 3, 1, '2024-01-07', 'USA Work', '[{\"actionDate\":\"2024-01-28\",\"description\":\"Salam Song\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":495000,\"serviceQty\":\"5\",\"serviceTotalDollar\":1500,\"serviceTotalIraqi\":2475000},{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":412500,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":412500},{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":495000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":495000}]}]', 'null', 2050, 0, 50, 750, 2000, 1250, 3382500, 0, 82500, 1237500, 3300000, 2062500, '1650', 1, '2024-01-07 08:48:53', '2024-02-18 11:21:47'),
(106, NULL, 4, 1, '2024-02-18', 'Nice', '[{\"actionDate\":\"2024-02-18\",\"description\":\"Service\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":375000},{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":450000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":450000}]}]', 'null', 550, 0, 50, 500, 500, 0, 825000, 0, 75000, 750000, 750000, 0, '1500', 1, '2024-02-18 05:14:04', '2024-02-18 11:32:28'),
(107, NULL, 13, 1, '2024-02-18', 'George and Sara', '[{\"actionDate\":\"2024-02-19\",\"description\":\"\\u062d\\u062c\\u0632\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":375000},{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":450000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":450000}]},{\"actionDate\":\"2024-03-01\",\"description\":\"Weding\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":450000,\"serviceQty\":\"3\",\"serviceTotalDollar\":900,\"serviceTotalIraqi\":1350000},{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":\"2\",\"serviceTotalDollar\":500,\"serviceTotalIraqi\":750000},{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":\"2\",\"serviceTotalDollar\":500,\"serviceTotalIraqi\":750000},{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":450000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":450000}]}]', 'null', 2750, 0, 200, 500, 2550, 2050, 4125000, 0, 300000, 750000, 3825000, 3075000, '1500', 1, '2024-02-18 07:10:34', '2024-02-18 11:31:42'),
(109, NULL, 14, 5, '2024-02-18', 'wedding', '[{\"actionDate\":\"2024-02-22\",\"description\":\"wedding\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":450000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":450000},{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":375000}]},{\"actionDate\":\"2024-02-28\",\"description\":\"hafla\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":450000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":450000},{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":375000}]}]', 'null', 1100, 0, 0, 600, 1100, 500, 1650000, 0, 0, 900000, 1650000, 750000, '1500', 1, '2024-02-18 08:15:20', '2024-02-18 11:57:48'),
(111, 55, 8, 1, '2024-02-18', 'PDF Test Direct', '[{\"actionDate\":\"2024-01-07\",\"description\":\"party event 1\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":387500,\"serviceQty\":\"4\",\"serviceTotalDollar\":1000,\"serviceTotalIraqi\":1550000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":116250,\"serviceQty\":\"5\",\"serviceTotalDollar\":375,\"serviceTotalIraqi\":581250}]},{\"actionDate\":\"2024-01-08\",\"description\":\"party event 2\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":387500,\"serviceQty\":\"3\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1162500},{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"KAHSKJAHSKJAHSKJAH\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":155000,\"serviceQty\":\"2\",\"serviceTotalDollar\":200,\"serviceTotalIraqi\":310000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":116250,\"serviceQty\":\"5\",\"serviceTotalDollar\":375,\"serviceTotalIraqi\":581250}]}]', '- note 1 test\n- note 2 pdf\n- note 3 direct', 1700, 0, 1000, 0, 1700, 0, 4185000, 0, 1550000, 0, 2635000, 0, '1550', 1, '2024-02-18 10:35:07', '2024-02-18 10:35:07'),
(112, NULL, 7, 1, '2024-02-20', 'asd', '[{\"actionDate\":\"2024-02-20\",\"description\":\"dsa\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":0,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":0},{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":0,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":0}]}]', '- asd', 550, 0, 0, 0, 550, 550, 0, 0, 0, 0, 0, 0, '0', 1, '2024-02-20 05:44:26', '2024-02-20 05:44:26'),
(113, NULL, 4, 1, '2024-02-20', 'asd', '[{\"actionDate\":\"2024-02-20\",\"description\":\"dsaasd\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":450000,\"serviceQty\":\"2\",\"serviceTotalDollar\":600,\"serviceTotalIraqi\":900000},{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":\"3\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1125000}]}]', '- asd23', 1350, 0, 150, 0, 1200, 1200, 2025000, 0, 225000, 0, 1800000, 1800000, '1500', 1, '2024-02-20 05:48:12', '2024-02-20 05:54:04'),
(114, NULL, 20, 1, '2024-02-20', 'ASDASDASD', '[{\"actionDate\":\"2024-02-20\",\"description\":\"DSASDASDA\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":\"3\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1125000}]}]', '- Payment in Advance\n- No Additoipn calsm;l', 750, 0, 50, 0, 700, 700, 1125000, 0, 75000, 0, 1050000, 1050000, '1500', 1, '2024-02-20 06:07:23', '2024-02-20 06:29:59'),
(115, NULL, 4, 1, '2024-02-20', 'ghjnfg', '[{\"actionDate\":\"2024-02-07\",\"description\":\"fghfgh\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":300000,\"serviceQty\":\"3\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":900000},{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":360000,\"serviceQty\":\"1\",\"serviceTotalDollar\":300,\"serviceTotalIraqi\":360000}]}]', '- asdas', 1050, 0, 100, 0, 950, 950, 1260000, 0, 120000, 0, 1140000, 1140000, '1200', 1, '2024-02-20 06:09:30', '2024-02-20 06:29:58'),
(117, 65, 4, 1, '2024-02-20', 'asdasd', '[{\"actionDate\":\"2024-02-20\",\"description\":\"qwe\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":0,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":0},{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":0,\"serviceQty\":\"3\",\"serviceTotalDollar\":900,\"serviceTotalIraqi\":0}]}]', '- asd', 1000, 0, 150, 0, 1000, 0, 0, 0, 0, 0, 0, 0, '0', 1, '2024-02-20 06:40:42', '2024-02-20 06:40:42'),
(118, 59, 10, 1, '2024-02-20', 'Wow', '[{\"actionDate\":\"2024-01-07\",\"description\":\"test\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"Video Shot\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":375000},{\"serviceCode\":\"#PTH20\",\"select_service_data\":\"4\",\"serviceDescription\":\"20 Photo Service\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":150000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":150000}]}]', 'no notes\nno discounts', 350, 0, 0, 0, 350, 0, 525000, 0, 0, 0, 525000, 0, '1500', 1, '2024-02-20 06:40:47', '2024-02-20 06:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(138, '2014_10_12_000000_create_users_table', 1),
(139, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(140, '2019_08_19_000000_create_failed_jobs_table', 1),
(141, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(142, '2023_11_06_150356_create_clients_table', 1),
(143, '2023_11_06_150415_create_profiles_table', 1),
(144, '2023_11_08_102421_create_branches_table', 1),
(145, '2023_11_08_102429_create_services_table', 1),
(146, '2023_11_26_184207_create_payments_table', 1),
(147, '2023_11_26_184308_create_quotations_table', 1),
(148, '2023_12_07_124419_create_expenses_table', 1),
(149, '2023_12_08_140447_create_bills_expenses_table', 1),
(153, '2023_12_17_175202_create_invoices_table', 2),
(155, '2023_12_18_121100_create_cashes_table', 3),
(164, '2023_12_30_111207_create_tasks_table', 4),
(165, '2023_12_30_111411_create_emp_tasks_table', 4),
(166, '2024_03_02_171153_create_attendances_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cash In Dollar', 1, '2023-12-14 08:05:53', '2024-01-07 06:46:52'),
(5, 'Cash In Iraqi', 1, '2024-01-07 06:47:02', '2024-01-07 06:47:02');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `national_id` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `phone_number_1` varchar(255) NOT NULL,
  `phone_number_2` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `salary_dollar` varchar(255) NOT NULL,
  `salary_iraqi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `job_title`, `national_id`, `avatar`, `phone_number_1`, `phone_number_2`, `email_address`, `salary_dollar`, `salary_iraqi`, `created_at`, `updated_at`) VALUES
(11, 11, 'Owner', 'A23456', 'user.png', '0965487541516', '654654654', NULL, '0', '0', '2024-01-02 08:48:40', '2024-01-02 08:48:40'),
(14, 14, 'Editor', 'A521456', 'user.png', '09647501234567', '', '', '200', '300000', '2024-01-07 06:07:52', '2024-01-07 06:07:52'),
(18, 18, 'video editer', 'abc', 'user.png', '123456564564', '', '', '1000', '1500000', '2024-02-18 08:02:24', '2024-02-18 09:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `qoutation_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`services`)),
  `notes` longtext DEFAULT NULL,
  `total_amount_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `tax_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `discount_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `first_pay_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `grand_total_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `due_dollar` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `total_amount_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `tax_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `discount_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `first_pay_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `grand_total_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `due_iraqi` decimal(18,0) UNSIGNED NOT NULL DEFAULT 0,
  `exchange_rate` varchar(255) NOT NULL DEFAULT '1500',
  `quotation_status` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `client_id`, `payment_id`, `qoutation_date`, `description`, `services`, `notes`, `total_amount_dollar`, `tax_dollar`, `discount_dollar`, `first_pay_dollar`, `grand_total_dollar`, `due_dollar`, `total_amount_iraqi`, `tax_iraqi`, `discount_iraqi`, `first_pay_iraqi`, `grand_total_iraqi`, `due_iraqi`, `exchange_rate`, `quotation_status`, `status`, `created_at`, `updated_at`) VALUES
(40, 5, 1, '2023-12-28', 'Johan', '[{\"actionDate\":\"2023-12-30\",\"description\":\"XMAS\",\"services\":[{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":91500,\"serviceQty\":\"3\",\"serviceTotalDollar\":225,\"serviceTotalIraqi\":274500},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":427000,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":427000}]},{\"actionDate\":\"2023-12-31\",\"description\":\"Happy New Year\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":305000,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":305000}]}]', '- Payment in Advance\n- 2 Quotations', 825, 0, 0, 0, 825, 825, 1006500, 0, 0, 0, 1006500, 1006500, '1220', 'Rejected', 1, '2023-12-28 07:32:36', '2023-12-29 14:25:15'),
(43, 8, 1, '2023-12-28', 'Valentine Day', '[{\"actionDate\":\"2024-02-14\",\"description\":\"Party one at Dream Hall\",\"services\":[{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"KAHSKJAHSKJAHSKJAH\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":157000,\"serviceQty\":\"2\",\"serviceTotalDollar\":200,\"serviceTotalIraqi\":314000},{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":392500,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":392500},{\"serviceCode\":\"#ALB3080\",\"select_service_data\":\"8\",\"serviceDescription\":\"hfdhgafshdg\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":471000,\"serviceQty\":\"3\",\"serviceTotalDollar\":900,\"serviceTotalIraqi\":1413000}]},{\"actionDate\":\"2024-02-15\",\"description\":\"Party Day Two at Dream Hall Gard\",\"services\":[{\"serviceCode\":\"#ALB3080\",\"select_service_data\":\"8\",\"serviceDescription\":\"hfdhgafshdg\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":471000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":471000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":117750,\"serviceQty\":\"10\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1177500}]}]', '- Payment in Advance\n- Team Group B at 15th Feb\n- Drone Needed', 2400, 0, 333, 0, 2067, 2500, 3768000, 0, 522810, 0, 3245190, 3925000, '1570', 'Rejected', 1, '2023-12-28 07:56:09', '2024-02-20 06:45:27'),
(55, 8, 1, '2024-01-07', 'PDF Test Direct', '[{\"actionDate\":\"2024-01-07\",\"description\":\"party event 1\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":387500,\"serviceQty\":\"4\",\"serviceTotalDollar\":1000,\"serviceTotalIraqi\":1550000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":116250,\"serviceQty\":\"5\",\"serviceTotalDollar\":375,\"serviceTotalIraqi\":581250}]},{\"actionDate\":\"2024-01-08\",\"description\":\"party event 2\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":387500,\"serviceQty\":\"3\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1162500},{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"KAHSKJAHSKJAHSKJAH\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":155000,\"serviceQty\":\"2\",\"serviceTotalDollar\":200,\"serviceTotalIraqi\":310000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":116250,\"serviceQty\":\"5\",\"serviceTotalDollar\":375,\"serviceTotalIraqi\":581250}]}]', '- note 1 test\n- note 2 pdf\n- note 3 direct', 2700, 0, 1000, 0, 1700, 2000, 4185000, 0, 1550000, 0, 2635000, 3040000, '1550', 'Approved', 1, '2024-01-06 07:38:49', '2024-02-18 10:35:08'),
(59, 10, 1, '2024-01-07', 'Wow', '[{\"actionDate\":\"2024-01-07\",\"description\":\"test\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"Video Shot\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":375000},{\"serviceCode\":\"#PTH20\",\"select_service_data\":\"4\",\"serviceDescription\":\"20 Photo Service\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":150000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":150000}]}]', 'no notes\nno discounts', 350, 0, 0, 0, 350, 350, 525000, 0, 0, 0, 525000, 525000, '1500', 'Approved', 1, '2024-01-07 07:28:50', '2024-02-20 06:40:48'),
(65, 4, 1, '2024-02-20', 'asdasd', '[{\"actionDate\":\"2024-02-20\",\"description\":\"qwe\",\"services\":[{\"serviceCode\":\"Album\",\"select_service_data\":\"12\",\"serviceDescription\":\"Album\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":0,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":0},{\"serviceCode\":\"Album\",\"select_service_data\":\"11\",\"serviceDescription\":\"maroni\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":0,\"serviceQty\":\"3\",\"serviceTotalDollar\":900,\"serviceTotalIraqi\":0}]}]', '- asd', 1150, 0, 150, 0, 1000, 1000, 0, 0, 0, 0, 0, 0, '0', 'Approved', 1, '2024-02-20 06:36:41', '2024-02-20 06:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_code` varchar(255) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_description` varchar(255) DEFAULT NULL,
  `price_dollar` int(11) NOT NULL,
  `price_iraqi` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_code`, `service_name`, `service_description`, `price_dollar`, `price_iraqi`, `created_at`, `updated_at`) VALUES
(11, 'Album', ' 30*60 Maroni', 'maroni', 300, 450000, '2024-02-18 10:01:16', '2024-02-18 10:02:14'),
(12, 'Album', '30*60 Black', 'Album', 250, 340000, '2024-02-18 10:03:47', '2024-02-18 10:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_option` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_option`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Photo', 1, '2023-12-30 15:11:26', '2023-12-30 15:11:26'),
(2, 'Video', 1, '2023-12-30 15:11:36', '2023-12-30 15:11:36'),
(3, 'Video Edit', 1, '2023-12-30 15:11:53', '2023-12-30 15:11:53'),
(4, 'Drone', 1, '2023-12-31 06:10:19', '2023-12-31 06:10:19'),
(5, 'Set up', 1, '2024-02-18 07:22:17', '2024-02-18 07:22:17'),
(6, 'تعديل البوم', 1, '2024-02-18 07:25:15', '2024-02-18 07:25:15'),
(7, 'تنظيف صالة ', 1, '2024-02-18 07:25:32', '2024-02-18 07:25:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(11, 'msh', 'ghusain@glam.com', '123456', '1', '1', NULL, '2024-01-02 08:48:40', '2024-01-02 08:48:40'),
(14, 'New EMP', 'edit@me.com', '123456', '2', '1', NULL, '2024-01-07 06:07:52', '2024-01-07 06:07:52'),
(18, 'nizar', 'nizar@glam.com', '123456', '3', '1', NULL, '2024-02-18 08:02:24', '2024-02-18 09:35:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_user_id_foreign` (`user_id`);

--
-- Indexes for table `bills_expenses`
--
ALTER TABLE `bills_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashes`
--
ALTER TABLE `cashes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cashes_invoice_id_unique` (`invoice_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_tasks`
--
ALTER TABLE `emp_tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_tasks_invoice_id_unique` (`invoice_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_quotation_id_unique` (`quotation_id`),
  ADD KEY `invoices_client_id_foreign` (`client_id`),
  ADD KEY `invoices_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profiles_national_id_unique` (`national_id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotations_client_id_foreign` (`client_id`),
  ADD KEY `quotations_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `bills_expenses`
--
ALTER TABLE `bills_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashes`
--
ALTER TABLE `cashes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `emp_tasks`
--
ALTER TABLE `emp_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cashes`
--
ALTER TABLE `cashes`
  ADD CONSTRAINT `cashes_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `emp_tasks`
--
ALTER TABLE `emp_tasks`
  ADD CONSTRAINT `emp_tasks_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quotations_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

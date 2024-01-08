-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2024 at 12:27 PM
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
-- Database: `metiszec_glam`
--

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
(40, 83, '2023-12-29', '[{\"payment_date\":\"2023-12-29\",\"paymentAmountDollar\":\"1500\",\"paymentAmountIraqi\":2250000}]', 1510, 10, 2265000, 15000, 'Not Complete', '2023-12-29 15:53:01', '2023-12-29 15:53:01'),
(44, 87, '2023-12-29', '[{\"payment_date\":\"2023-12-29\",\"paymentAmountDollar\":\"1000\",\"paymentAmountIraqi\":1500000},{\"payment_date\":\"2024-01-08\",\"paymentAmountDollar\":\"1500\",\"paymentAmountIraqi\":2250000}]', 2500, 0, 3750000, 0, 'Complete', '2023-12-29 15:59:21', '2024-01-06 11:54:29'),
(45, 88, '2023-12-29', '[{\"payment_date\":\"2023-12-29\",\"paymentAmountDollar\":\"210\",\"paymentAmountIraqi\":262500},{\"payment_date\":\"2024-01-05\",\"paymentAmountDollar\":\"190\",\"paymentAmountIraqi\":237500}]', 400, 0, 500000, 0, 'Complete', '2023-12-29 16:00:33', '2023-12-29 16:10:58'),
(47, 76, '2024-01-06', '[{\"payment_date\":\"2024-01-06\",\"paymentAmountDollar\":\"500\",\"paymentAmountIraqi\":625000},{\"payment_date\":\"2024-01-07\",\"paymentAmountDollar\":\"600\",\"paymentAmountIraqi\":750000}]', 1175, 75, 1468750, 93750, 'Not Complete', '2024-01-06 09:27:55', '2024-01-06 09:49:43'),
(50, 90, '2024-01-06', '[{\"payment_date\":\"2024-01-07\",\"paymentAmountDollar\":\"3000\",\"paymentAmountIraqi\":4560000},{\"payment_date\":\"2024-01-14\",\"paymentAmountDollar\":\"1800\",\"paymentAmountIraqi\":2736000},{\"payment_date\":\"2024-01-15\",\"paymentAmountDollar\":\"200\",\"paymentAmountIraqi\":304000}]', 5000, 0, 7600000, 0, 'Complete', '2024-01-06 09:29:40', '2024-01-06 09:34:24'),
(51, 96, '2024-01-07', '[{\"payment_date\":\"2024-01-07\",\"paymentAmountDollar\":\"250\",\"paymentAmountIraqi\":330000},{\"payment_date\":\"2024-01-07\",\"paymentAmountDollar\":\"50\",\"paymentAmountIraqi\":66000}]', 300, 0, 396000, 0, 'Complete', '2024-01-07 08:24:13', '2024-01-07 08:51:30'),
(52, 97, '2024-01-07', '[{\"payment_date\":\"2024-01-07\",\"paymentAmountDollar\":\"500\",\"paymentAmountIraqi\":760000},{\"payment_date\":\"2024-01-08\",\"paymentAmountDollar\":\"150\",\"paymentAmountIraqi\":228000}]', 650, 0, 988000, 0, 'Complete', '2024-01-07 08:36:10', '2024-01-07 08:54:21'),
(56, 101, '2024-01-07', '[{\"payment_date\":\"2024-01-07\",\"paymentAmountDollar\":\"100\",\"paymentAmountIraqi\":165000},{\"payment_date\":\"2024-01-08\",\"paymentAmountDollar\":\"400\",\"paymentAmountIraqi\":660000}]', 500, 0, 825000, 0, 'Complete', '2024-01-07 08:48:54', '2024-01-07 08:54:46'),
(57, 102, '2024-01-07', '[{\"payment_date\":\"2024-01-07\",\"paymentAmountDollar\":\"100\",\"paymentAmountIraqi\":125000}]', 270, 170, 337500, 212500, 'Not Complete', '2024-01-07 13:57:55', '2024-01-07 13:57:55');

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
(2, 'Shaheen', 'Iraq', 'Erbil', 'Next to Blue Trash', 'cat@cat.cin', '065489654654', '65465465465', '2023-12-17 09:44:11', '2023-12-17 09:44:11'),
(3, 'shokrea', 'Basra', 'Basra', 'next to red trash', 'Shokrea@fib.vom', '+96475123', '+96477012354', '2023-12-17 09:45:28', '2024-01-07 06:26:10'),
(4, 'Gabriel Valdez', 'Dolor quam sequi nob', 'Aut voluptate offici', 'Sequi fuga Eos eni', 'foto@mailinator.com', '+1 (748) 687-5327', '+1 (736) 871-7714', '2023-12-17 14:02:21', '2023-12-17 14:02:21'),
(5, 'client 2', 'iraq', 'Erbil', 'Ankawa', 'a@a.com', '654646546', '46546546465465', '2023-12-17 16:30:49', '2023-12-17 16:31:01'),
(6, 'mine', 'Japan', 'Honk kong', 'Next to trash', 'mine@me.com', '654789123', '65485213', '2023-12-18 07:35:48', '2023-12-18 07:35:48'),
(7, 'asd', 'asd', 'asd', 'asd', '', '123', '', '2023-12-19 17:11:59', '2023-12-19 17:11:59'),
(8, 'George', 'Iraq', 'Erbil', 'Ankawa', 'a@a.com', '+965478456', '+654789545', '2023-12-21 07:58:25', '2023-12-21 07:58:25'),
(9, 'Ghusain', 'Iraq', 'Dohuk', 'dd', 'gh@a.com', '32132132', '32132132132', '2023-12-21 08:17:40', '2023-12-21 08:17:40'),
(10, 'Sam', 'USA', 'NY', 'next to bar', '', '+1456878948', '+155454723', '2024-01-07 06:26:43', '2024-01-07 06:26:43'),
(11, 'Blacv', 'Iraq', 'lkj', 'lkj', '', '+987564654', '+4654684', '2024-01-07 09:47:33', '2024-01-07 09:47:33');

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
(4, 83, '[{\"name\":\"1\",\"task\":\"3\",\"start_date\":\"2023-12-30\",\"end_date\":\"2024-01-02\",\"progress\":\"0\"}]', 0, 'In Pending', 1, 1, '2023-12-30 15:24:43', '2024-01-04 07:57:12'),
(8, 76, '[{\"name\":\"1\",\"task\":\"1\",\"start_date\":\"2023-12-31\",\"end_date\":\"2024-01-03\",\"progress\":\"100\"}]', 100, 'Complete', 1, 0, '2023-12-31 06:08:23', '2024-01-06 13:04:01'),
(25, 87, '[{\"name\":\"1\",\"task\":\"3\",\"start_date\":\"2024-01-02\",\"end_date\":\"2024-01-05\",\"progress\":\"25\"},{\"name\":\"10\",\"task\":\"4\",\"start_date\":\"2024-01-16\",\"end_date\":\"2024-02-01\",\"progress\":\"90\"},{\"name\":\"10\",\"task\":\"3\",\"start_date\":\"2024-01-04\",\"end_date\":\"2024-01-07\",\"progress\":\"80\"}]', 65, 'In Process', 1, 0, '2024-01-02 07:59:18', '2024-01-07 09:27:09'),
(27, 88, '[{\"name\":\"1\",\"task\":\"1\",\"start_date\":\"2024-01-06\",\"end_date\":\"2024-01-09\",\"progress\":0},{\"name\":\"12\",\"task\":\"4\",\"start_date\":\"2024-01-06\",\"end_date\":\"2024-01-09\",\"progress\":0}]', 0, 'In Pending', 1, 0, '2024-01-06 12:44:23', '2024-01-06 13:00:12');

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
(9, 'Deposit', 'Other', '100', '150000', 'Ahmed took extra money', '2024-01-07', 1, '2024-01-07 06:59:32', '2024-01-07 06:59:32');

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
(76, 41, 4, 2, '2023-12-29', 'GLAM Offer', '[{\"actionDate\":\"2023-12-24\",\"description\":\"Xmas 2025\",\"services\":[{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":472500,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":472500},{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"KAHSKJAHSKJAHSKJAH\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":135000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":135000}]},{\"actionDate\":\"2023-12-31\",\"description\":\"HNY\",\"services\":[{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":101250,\"serviceQty\":1,\"serviceTotalDollar\":75,\"serviceTotalIraqi\":101250},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":472500,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":472500},{\"serviceCode\":\"#ALB3080\",\"select_service_data\":\"8\",\"serviceDescription\":\"hfdhgafshdg\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":405000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":405000}]}]', '\"nice\"', 1175, 0, 0, 0, 1175, 1175, 1586250, 0, 0, 0, 1586250, 1586250, '1350', 1, '2023-12-29 14:37:10', '2024-01-07 08:17:03'),
(83, NULL, 2, 2, '2023-12-29', 'Test #4', '[{\"actionDate\":\"2023-12-31\",\"description\":\"T1\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":\"4\",\"serviceTotalDollar\":1000,\"serviceTotalIraqi\":1500000},{\"serviceCode\":\"#ALB\",\"select_service_data\":\"7\",\"serviceDescription\":\"Album 30 * 60\",\"serviceDefaultCostDollar\":200,\"serviceDefaultCostIraqi\":300000,\"serviceQty\":\"2\",\"serviceTotalDollar\":400,\"serviceTotalIraqi\":600000}]},{\"actionDate\":\"2024-01-04\",\"description\":\"asd\",\"services\":[{\"serviceCode\":\"#ALB\",\"select_service_data\":\"7\",\"serviceDescription\":\"Album 30 * 60\",\"serviceDefaultCostDollar\":\"210\",\"serviceDefaultCostIraqi\":315000,\"serviceQty\":1,\"serviceTotalDollar\":210,\"serviceTotalIraqi\":315000}]}]', 'null', 1610, 0, 500, 1500, 1110, 0, 2415000, 0, 750000, 2250000, 1665000, 0, '1500', 1, '2023-12-29 15:53:01', '2024-01-04 16:05:32'),
(87, NULL, 3, 1, '2023-12-29', 'FINAL TEST', '[{\"actionDate\":\"2024-01-23\",\"description\":\"T1\",\"services\":[{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":112500,\"serviceQty\":\"4\",\"serviceTotalDollar\":300,\"serviceTotalIraqi\":450000},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":525000,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":525000}]},{\"actionDate\":\"2024-01-06\",\"description\":\"T2\",\"services\":[{\"serviceCode\":\"#PTH20\",\"select_service_data\":\"4\",\"serviceDescription\":\"20 Photo Service\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":150000,\"serviceQty\":\"2\",\"serviceTotalDollar\":200,\"serviceTotalIraqi\":300000}]},{\"actionDate\":\"2024-01-12\",\"description\":\"T3 Long Description Check\",\"services\":[{\"serviceCode\":\"#PTH20\",\"select_service_data\":\"4\",\"serviceDescription\":\"20 Photo Service\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":150000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":150000},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":525000,\"serviceQty\":\"4\",\"serviceTotalDollar\":1400,\"serviceTotalIraqi\":2100000},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":525000,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":525000}]}]', 'FINAL TEST', 2700, 0, 0, 1000, 2500, 1500, 4050000, 0, 300000, 1500000, 3750000, 2250000, '1500', 1, '2023-12-29 15:59:21', '2023-12-29 15:59:21'),
(88, NULL, 6, 2, '2023-12-29', 'asd', '[{\"actionDate\":\"2023-12-07\",\"description\":\"asd\",\"services\":[{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":437500,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":437500},{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"KAHSKJAHSKJAHSKJAH\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":125000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":125000}]}]', 'asdasdasdasdasd', 450, 0, 0, 210, 400, 190, 562500, 0, 62500, 262500, 500000, 237500, '1250', 1, '2023-12-29 16:00:33', '2023-12-29 16:00:33'),
(90, NULL, 2, 1, '2024-01-06', 'Pdf Test 2', '[{\"actionDate\":\"2024-01-11\",\"description\":\"Event 1\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":380000,\"serviceQty\":\"3\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1140000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":114000,\"serviceQty\":\"10\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1140000}]},{\"actionDate\":\"2024-01-16\",\"description\":\"Event 2\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":380000,\"serviceQty\":\"3\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1140000},{\"serviceCode\":\"#PTH20\",\"select_service_data\":\"4\",\"serviceDescription\":\"20 Photo Service\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":152000,\"serviceQty\":\"2\",\"serviceTotalDollar\":200,\"serviceTotalIraqi\":304000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":114000,\"serviceQty\":\"10\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1140000}]},{\"actionDate\":\"2024-01-23\",\"description\":\"Event 3\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":380000,\"serviceQty\":\"3\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1140000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":114000,\"serviceQty\":\"12\",\"serviceTotalDollar\":900,\"serviceTotalIraqi\":1368000},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":532000,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":532000}]}]', '- Payment Should be Paid 50% Before the Event 2\n- No Extra Tools Required\n- Additionally Photo is Available', 5200, 0, 200, 0, 5000, 5000, 7904000, 0, 304000, 0, 7600000, 7600000, '1520', 1, '2024-01-06 06:47:08', '2024-01-07 08:16:49'),
(96, NULL, 10, 2, '2024-01-07', 'Test Invoice', '[{\"actionDate\":\"2024-01-08\",\"description\":\"Party 1\",\"services\":[{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"Photo Session\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":132000,\"serviceQty\":\"3\",\"serviceTotalDollar\":300,\"serviceTotalIraqi\":396000},{\"serviceCode\":\"#ALB\",\"select_service_data\":\"7\",\"serviceDescription\":\"Album 30 * 60\",\"serviceDefaultCostDollar\":200,\"serviceDefaultCostIraqi\":264000,\"serviceQty\":1,\"serviceTotalDollar\":200,\"serviceTotalIraqi\":264000}]},{\"actionDate\":\"2024-01-15\",\"description\":\"Party 2\",\"services\":[{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"Photo Session\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":132000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":132000}]}]', '\"Update the discount\"', 600, 0, 100, 250, 500, 250, 792000, 0, 132000, 330000, 660000, 330000, '1320', 1, '2024-01-07 08:24:12', '2024-01-07 14:26:30'),
(97, NULL, 3, 2, '2024-01-07', 'asd', '[{\"actionDate\":\"2024-01-09\",\"description\":\"qweqwe\",\"services\":[{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":114000,\"serviceQty\":\"10\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1140000}]}]', 'test PDFs', 750, 0, 100, 500, 650, 150, 1140000, 0, 152000, 760000, 988000, 228000, '1520', 1, '2024-01-07 08:36:08', '2024-01-07 14:31:11'),
(101, NULL, 3, 1, '2024-01-07', 'USA Work', '[{\"actionDate\":\"2024-01-28\",\"description\":\"Salam Song\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"Video Shot\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":412500,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":412500},{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"Photo Session\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":165000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":165000},{\"serviceCode\":\"#ALB\",\"select_service_data\":\"7\",\"serviceDescription\":\"Album 30 * 60\",\"serviceDefaultCostDollar\":200,\"serviceDefaultCostIraqi\":330000,\"serviceQty\":1,\"serviceTotalDollar\":200,\"serviceTotalIraqi\":330000}]}]', 'Salam / Peace', 550, 0, 50, 100, 500, 400, 907500, 0, 82500, 165000, 825000, 660000, '1650', 1, '2024-01-07 08:48:53', '2024-01-07 08:48:53'),
(102, NULL, 3, 2, '2024-01-07', 'Invoice Test', '[{\"actionDate\":\"2024-02-09\",\"description\":\"nicwe\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"Video Shot\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":312500,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":312500},{\"serviceCode\":\"#FIN\",\"select_service_data\":\"9\",\"serviceDescription\":\"check\",\"serviceDefaultCostDollar\":5,\"serviceDefaultCostIraqi\":6250,\"serviceQty\":\"4\",\"serviceTotalDollar\":20,\"serviceTotalIraqi\":25000}]}]', 'asd', 270, 0, 0, 100, 270, 170, 337500, 0, 0, 125000, 337500, 212500, '1250', 1, '2024-01-07 13:57:54', '2024-01-07 13:57:54');

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
(165, '2023_12_30_111411_create_emp_tasks_table', 4);

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
(2, 'VISA/Master', 1, '2023-12-17 16:32:50', '2023-12-21 08:02:12'),
(4, 'FastPay', 1, '2023-12-21 08:02:27', '2023-12-21 08:02:27'),
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
(1, 1, 'Photo', 'A5124578', 'user_20231215151615.jpg', '096478547412', NULL, NULL, '400', '600000', '2023-12-15 12:15:26', '2023-12-30 09:33:04'),
(10, 10, 'Video Graphic', 'A52145684', 'user_20231230123407.jpg', '+964785013215', '0750123456789', 'narazr@gmail.com', '500', '750000', '2023-12-21 07:55:40', '2024-01-02 08:52:03'),
(11, 11, 'Owner', 'A23456', 'user.png', '0965487541516', '654654654', NULL, '0', '0', '2024-01-02 08:48:40', '2024-01-02 08:48:40'),
(12, 12, 'After Effect', 'Ipsum voluptatem Fu', 'user.png', '+1 (751) 913-2175', '+1 (803) 697-3689', 'gynuc@mailinator.com', '400', '600000', '2024-01-04 05:10:23', '2024-01-07 06:01:42'),
(13, 13, 'accounting', 'asdasdasdasd', 'user_20240107090210.jpg', '123123123', '1231231231231', NULL, '300', '450000', '2024-01-06 14:12:58', '2024-01-07 06:06:57'),
(14, 14, 'Editor', 'A521456', 'user.png', '09647501234567', '', '', '200', '300000', '2024-01-07 06:07:52', '2024-01-07 06:07:52');

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
(41, 4, 2, '2023-12-28', 'GLAM Offer', '[{\"actionDate\":\"2023-12-24\",\"description\":\"Xmas 2025\",\"services\":[{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":437500,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":437500},{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"KAHSKJAHSKJAHSKJAH\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":125000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":125000}]},{\"actionDate\":\"2023-12-31\",\"description\":\"HNY\",\"services\":[{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":93750,\"serviceQty\":1,\"serviceTotalDollar\":75,\"serviceTotalIraqi\":93750},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":437500,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":437500},{\"serviceCode\":\"#ALB3080\",\"select_service_data\":\"8\",\"serviceDescription\":\"hfdhgafshdg\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":375000}]}]', '- Payment in advance\n- No Discount\n- 2 Quotations', 1175, 0, 0, 0, 1175, 1175, 1468750, 0, 0, 0, 1468750, 1468750, '1250', 'Approved', 1, '2023-12-28 07:44:01', '2023-12-29 14:37:12'),
(42, 4, 2, '2023-12-28', 'GLAM Offer', '[{\"actionDate\":\"2023-12-24\",\"description\":\"Xmas 2025\",\"services\":[{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":437500,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":437500},{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"KAHSKJAHSKJAHSKJAH\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":125000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":125000}]},{\"actionDate\":\"2023-12-31\",\"description\":\"HNY\",\"services\":[{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":93750,\"serviceQty\":1,\"serviceTotalDollar\":75,\"serviceTotalIraqi\":93750},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":437500,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":437500},{\"serviceCode\":\"#ALB3080\",\"select_service_data\":\"8\",\"serviceDescription\":\"hfdhgafshdg\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":375000}]}]', '- Payment in advance\n- No Discount\n- 2 Quotations', 1175, 0, 0, 0, 1175, 1175, 1468750, 0, 0, 0, 1468750, 1468750, '1250', 'Sent', 1, '2023-12-28 07:47:25', '2023-12-28 07:47:25'),
(43, 8, 1, '2023-12-28', 'Valentine Day', '[{\"actionDate\":\"2024-02-14\",\"description\":\"Party one at Dream Hall\",\"services\":[{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"KAHSKJAHSKJAHSKJAH\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":157000,\"serviceQty\":\"2\",\"serviceTotalDollar\":200,\"serviceTotalIraqi\":314000},{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":392500,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":392500},{\"serviceCode\":\"#ALB3080\",\"select_service_data\":\"8\",\"serviceDescription\":\"hfdhgafshdg\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":471000,\"serviceQty\":\"3\",\"serviceTotalDollar\":900,\"serviceTotalIraqi\":1413000}]},{\"actionDate\":\"2024-02-15\",\"description\":\"Party Day Two at Dream Hall Gard\",\"services\":[{\"serviceCode\":\"#ALB3080\",\"select_service_data\":\"8\",\"serviceDescription\":\"hfdhgafshdg\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":471000,\"serviceQty\":1,\"serviceTotalDollar\":300,\"serviceTotalIraqi\":471000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":117750,\"serviceQty\":\"10\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1177500}]}]', '- Payment in Advance\n- Team Group B at 15th Feb\n- Drone Needed', 2400, 0, 333, 0, 2067, 2500, 3768000, 0, 522810, 0, 3245190, 3925000, '1570', 'Sent', 1, '2023-12-28 07:56:09', '2023-12-28 10:11:57'),
(55, 8, 1, '2024-01-07', 'PDF Test Direct', '[{\"actionDate\":\"2024-01-07\",\"description\":\"party event 1\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":387500,\"serviceQty\":\"4\",\"serviceTotalDollar\":1000,\"serviceTotalIraqi\":1550000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":116250,\"serviceQty\":\"5\",\"serviceTotalDollar\":375,\"serviceTotalIraqi\":581250}]},{\"actionDate\":\"2024-01-08\",\"description\":\"party event 2\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":387500,\"serviceQty\":\"3\",\"serviceTotalDollar\":750,\"serviceTotalIraqi\":1162500},{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"KAHSKJAHSKJAHSKJAH\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":155000,\"serviceQty\":\"2\",\"serviceTotalDollar\":200,\"serviceTotalIraqi\":310000},{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":116250,\"serviceQty\":\"5\",\"serviceTotalDollar\":375,\"serviceTotalIraqi\":581250}]}]', '- note 1 test\n- note 2 pdf\n- note 3 direct', 2700, 0, 1000, 0, 1700, 2000, 4185000, 0, 1550000, 0, 2635000, 3040000, '1550', 'Rejected', 1, '2024-01-06 07:38:49', '2024-01-07 13:47:43'),
(57, 4, 4, '2024-01-06', 'Dolorem magna ut sun', '[{\"actionDate\":\"2001-11-16\",\"description\":\"16-Jan-2000\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":13000,\"serviceQty\":\"44\",\"serviceTotalDollar\":11000,\"serviceTotalIraqi\":572000},{\"serviceCode\":\"#ALB\",\"select_service_data\":\"7\",\"serviceDescription\":\"Album 30 * 60\",\"serviceDefaultCostDollar\":200,\"serviceDefaultCostIraqi\":10400,\"serviceQty\":\"121\",\"serviceTotalDollar\":24200,\"serviceTotalIraqi\":1258400}]},{\"actionDate\":\"2008-08-12\",\"description\":\"29-Dec-2008\",\"services\":[{\"serviceCode\":\"#ALB\",\"select_service_data\":\"7\",\"serviceDescription\":\"Album 30 * 60\",\"serviceDefaultCostDollar\":200,\"serviceDefaultCostIraqi\":10400,\"serviceQty\":\"597\",\"serviceTotalDollar\":119400,\"serviceTotalIraqi\":6208800}]},{\"actionDate\":\"1996-11-01\",\"description\":\"08-Feb-1987\",\"services\":[{\"serviceCode\":\"#LIT\",\"select_service_data\":\"3\",\"serviceDescription\":\"400watt\",\"serviceDefaultCostDollar\":75,\"serviceDefaultCostIraqi\":3900,\"serviceQty\":\"60\",\"serviceTotalDollar\":4500,\"serviceTotalIraqi\":234000},{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"video\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":13000,\"serviceQty\":\"670\",\"serviceTotalDollar\":167500,\"serviceTotalIraqi\":8710000}]}]', 'Sapiente tempore si', 326600, 0, 98, 0, 326502, 326502, 16983200, 0, 5096, 0, 16978104, 16978104, '52', 'Rejected', 0, '2024-01-06 08:06:18', '2024-01-06 12:09:45'),
(58, 3, 4, '2024-01-06', 'Possimus ullamco de', '[{\"actionDate\":\"1993-07-28\",\"description\":\"24-May-2012\",\"services\":[{\"serviceCode\":\"#ALB3080\",\"select_service_data\":\"8\",\"serviceDescription\":\"hfdhgafshdg\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":456000,\"serviceQty\":\"5\",\"serviceTotalDollar\":1500,\"serviceTotalIraqi\":2280000},{\"serviceCode\":\"#PTH\",\"select_service_data\":\"1\",\"serviceDescription\":\"KAHSKJAHSKJAHSKJAH\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":152000,\"serviceQty\":\"2\",\"serviceTotalDollar\":200,\"serviceTotalIraqi\":304000}]},{\"actionDate\":\"1978-06-07\",\"description\":\"07-Jul-2023\",\"services\":[{\"serviceCode\":\"#ALB3080\",\"select_service_data\":\"8\",\"serviceDescription\":\"hfdhgafshdg\",\"serviceDefaultCostDollar\":300,\"serviceDefaultCostIraqi\":456000,\"serviceQty\":\"1\",\"serviceTotalDollar\":300,\"serviceTotalIraqi\":456000}]}]', 'Qui duis sed pariatu', 2000, 0, 200, 0, 1800, 1800, 3040000, 0, 304000, 0, 2736000, 2736000, '1520', 'Sent', 1, '2024-01-06 08:07:29', '2024-01-06 08:07:29'),
(59, 10, 1, '2024-01-07', 'Wow', '[{\"actionDate\":\"2024-01-07\",\"description\":\"test\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"Video Shot\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":1,\"serviceTotalDollar\":250,\"serviceTotalIraqi\":375000},{\"serviceCode\":\"#PTH20\",\"select_service_data\":\"4\",\"serviceDescription\":\"20 Photo Service\",\"serviceDefaultCostDollar\":100,\"serviceDefaultCostIraqi\":150000,\"serviceQty\":1,\"serviceTotalDollar\":100,\"serviceTotalIraqi\":150000}]}]', 'no notes\nno discounts', 350, 0, 0, 0, 350, 350, 525000, 0, 0, 0, 525000, 525000, '1500', 'Sent', 1, '2024-01-07 07:28:50', '2024-01-07 07:28:50'),
(60, 2, 4, '2024-01-07', 'emp test', '[{\"actionDate\":\"2024-01-11\",\"description\":\"event 1\",\"services\":[{\"serviceCode\":\"#VID\",\"select_service_data\":\"2\",\"serviceDescription\":\"Video Shot\",\"serviceDefaultCostDollar\":250,\"serviceDefaultCostIraqi\":375000,\"serviceQty\":\"2\",\"serviceTotalDollar\":500,\"serviceTotalIraqi\":750000},{\"serviceCode\":\"#CLP\",\"select_service_data\":\"6\",\"serviceDescription\":\"Clip of wedding video + addition photos\",\"serviceDefaultCostDollar\":350,\"serviceDefaultCostIraqi\":525000,\"serviceQty\":1,\"serviceTotalDollar\":350,\"serviceTotalIraqi\":525000}]}]', 'Nice Action', 850, 0, 200, 0, 650, 650, 1275000, 0, 300000, 0, 975000, 975000, '1500', 'Sent', 1, '2024-01-07 13:20:55', '2024-01-07 13:20:55');

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
(1, '#PTH', 'Photo Session', 'Photo Session', 100, 160000, '2023-12-14 08:05:43', '2024-01-07 06:38:12'),
(2, '#VID', 'Video', 'Video Shot', 250, 450000, '2023-12-16 07:08:30', '2024-01-07 06:38:50'),
(3, '#LIT', 'Spot Light', '400watt', 75, 120000, '2023-12-16 07:09:10', '2023-12-16 07:09:10'),
(4, '#PTH20', 'Photo Session 20p', '20 Photo Service', 100, 150000, '2023-12-17 16:32:10', '2023-12-17 16:32:21'),
(6, '#CLP', 'Clip', 'Clip of wedding video + addition photos', 350, 500000, '2023-12-21 08:00:37', '2023-12-21 08:01:56'),
(7, '#ALB', 'Album 30 X 60', 'Album 30 * 60', 200, 400000, '2023-12-21 09:08:40', '2023-12-21 09:09:39'),
(8, '#ALB3080', 'Album 30 X 80', 'hfdhgafshdg', 300, 450000, '2023-12-21 09:09:31', '2023-12-21 09:09:31'),
(9, '#FIN', 'Finanace Service', 'check', 5, 7500, '2024-01-07 06:39:15', '2024-01-07 06:39:15');

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
(4, 'Drone', 1, '2023-12-31 06:10:19', '2023-12-31 06:10:19');

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
(1, 'Ahmed', 'George@spiro.com', '123456', '4', '1', NULL, '2023-12-15 12:15:26', '2023-12-30 09:33:04'),
(10, 'Sara', 'nazar1@glam.com', '123456', '4', '1', NULL, '2023-12-21 07:55:40', '2024-01-02 08:52:03'),
(11, 'msh', 'asd@a.com', '123456', '1', '1', NULL, '2024-01-02 08:48:40', '2024-01-02 08:48:40'),
(12, 'Leslie Mcneil', 'jywyvedu@mailinator.com', 'Dicta qui optio cul', '4', '1', NULL, '2024-01-04 05:10:23', '2024-01-07 06:01:42'),
(13, 'fin jack', 'fin@me.com', '123456', '3', '1', NULL, '2024-01-06 14:12:58', '2024-01-07 06:06:57'),
(14, 'New EMP', 'edit@me.com', '123456', '2', '1', NULL, '2024-01-07 06:07:52', '2024-01-07 06:07:52');

--
-- Indexes for dumped tables
--

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `emp_tasks`
--
ALTER TABLE `emp_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

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

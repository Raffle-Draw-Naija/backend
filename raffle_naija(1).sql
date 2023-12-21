-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 21, 2023 at 10:23 AM
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
-- Database: `raffle_naija`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `wallet` double NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `first_name`, `last_name`, `phone`, `address`, `wallet`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 'Okoro', 'Emmanuel', '080392839382', 'No. 10 Onuiyi', 0, 41, '2023-11-13 12:07:49', '2023-11-13 12:07:49'),
(6, 'Sam', 'Okoye', '08039483948', 'New Address', 0, 43, '2023-11-25 20:14:50', '2023-11-25 20:14:50'),
(7, 'Samuel', 'Idioma', '08039283920', 'New Address', 0, 44, '2023-11-25 20:15:59', '2023-11-25 20:15:59'),
(8, 'Samuel', 'Idioma', '08039283920', 'New Address', 0, 45, '2023-11-25 20:22:27', '2023-11-25 20:22:27'),
(9, 'Samuel', 'Idioma', '08039283920', 'New Address', 0, 46, '2023-11-25 20:23:25', '2023-11-25 20:23:25'),
(10, 'Samuel', 'Idioma', '08039283920', 'New Address', 0, 47, '2023-11-25 20:23:55', '2023-11-25 20:23:55'),
(11, 'Samuel', 'Idioma', '08039283920', 'New Address', 0, 48, '2023-11-25 20:26:12', '2023-11-25 20:26:12'),
(12, 'Samuel', 'Idioma', '08039283920', 'New Address', 0, 49, '2023-11-25 21:12:44', '2023-11-25 21:12:44'),
(13, 'Okafor', 'Emmanuel', '0703928394', 'New Address', 0, 50, '2023-11-25 21:22:00', '2023-11-25 21:22:00'),
(14, 'Samson', 'Okoy', '08039384938', 'Address', 0, 51, '2023-11-25 21:46:13', '2023-11-25 21:46:13'),
(15, 'Nwangwu', 'Emmanuel', '08039283928', 'No. Address', 0, 52, '2023-11-25 21:48:04', '2023-11-25 21:48:04'),
(16, 'Ugochukwu', 'Omeje', '0803928392', 'No Address', 0, 53, '2023-11-25 22:05:49', '2023-11-25 22:05:49'),
(17, 'Samson', 'John', '0803948392', 'No Address', 0, 54, '2023-11-25 22:13:40', '2023-11-25 22:13:40'),
(19, 'Oshaba', 'Samson', '0809393029', 'No Address', 11800, 56, '2023-12-07 20:33:01', '2023-12-10 02:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `agent_funding_transactions`
--

CREATE TABLE `agent_funding_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `balance_ba` double DEFAULT NULL,
  `balance_aa` double DEFAULT NULL,
  `amount` double NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `flw_ref` varchar(255) DEFAULT NULL,
  `trx_ref` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `charge_response_code` varchar(2) DEFAULT NULL,
  `company_ref` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agent_funding_transactions`
--

INSERT INTO `agent_funding_transactions` (`id`, `narration`, `balance_ba`, `balance_aa`, `amount`, `user_id`, `agent_id`, `created_at`, `updated_at`, `flw_ref`, `trx_ref`, `status`, `transaction_id`, `charge_response_code`, `company_ref`) VALUES
(1, 'Oshaba Samson Funded Account', 8000, 8500, 500, 56, 19, '2023-12-10 01:16:19', '2023-12-10 01:23:20', 'FLW-MOCK-287e1a9e3e8892f1a9e0dfcbf914279b', NULL, 'Completed', '4774336', '00', ''),
(2, NULL, NULL, NULL, 200, 56, 19, '2023-12-10 01:21:18', '2023-12-10 01:22:20', NULL, NULL, 'Cancelled', NULL, NULL, ''),
(3, NULL, NULL, NULL, 500, 56, 19, '2023-12-10 01:22:41', '2023-12-10 01:23:59', NULL, NULL, 'Cancelled', NULL, NULL, ''),
(4, NULL, NULL, NULL, 500, 56, 19, '2023-12-10 01:24:03', '2023-12-10 01:24:46', NULL, NULL, 'Cancelled', NULL, NULL, ''),
(5, NULL, NULL, NULL, 500, 56, 19, '2023-12-10 01:24:48', '2023-12-10 01:27:41', NULL, NULL, 'Cancelled', NULL, NULL, ''),
(6, 'Oshaba Samson Funded Account', 8500, 9300, 800, 56, 19, '2023-12-10 01:28:03', '2023-12-10 01:29:42', 'FLW-MOCK-43a0d1937eb42d778e647893cc2f2400', NULL, 'Cancelled', '4774352', '00', ''),
(7, NULL, NULL, NULL, 800, 56, 19, '2023-12-10 01:32:58', '2023-12-10 01:33:55', NULL, NULL, 'Cancelled', NULL, NULL, ''),
(8, 'Oshaba Samson Funded Account', 10100, 10900, 800, 56, 19, '2023-12-10 01:33:56', '2023-12-10 01:35:24', 'FLW-MOCK-9263439004eec01f57dbe9dbdfc4ae52', '1702175578715', 'Cancelled', '4774358', '00', ''),
(9, 'Oshaba Samson Funded Account', 10900, 11000, 100, 56, 19, '2023-12-10 01:35:41', '2023-12-10 01:37:38', 'FLW-MOCK-2b7d06b2e5c1d69ddf4cded949563f60', '1702175735960', 'Cancelled', '4774363', '00', ''),
(10, 'Oshaba Samson Funded Account', 11000, 11100, 100, 56, 19, '2023-12-10 01:37:41', '2023-12-10 01:39:04', 'FLW-MOCK-8b485d930a14e8caa48ba8153d1cc662', 'Raffle9ja_ 1702175853630', 'Cancelled', '4774364', '00', ''),
(11, 'Oshaba Samson Funded Account', 11100, 11200, 100, 56, 19, '2023-12-10 01:39:05', '2023-12-10 01:41:10', 'FLW-MOCK-f029ce774f714cd2c729b8e51ed036e0', 'Raffle9ja_ 1702175939644', 'Cancelled', '4774366', '00', ''),
(12, 'Oshaba Samson Funded Account', 11200, 11300, 100, 56, 19, '2023-12-10 01:41:12', '2023-12-10 01:54:59', 'FLW-MOCK-72a5087beacb3b81863c7d6abdf5fdf0', 'Raffle9ja_ 1702175945077', 'Cancelled', '4774367', '00', 'Raffle9ja_ 1702175945077'),
(13, 'Oshaba Samson Funded Account', 11300, 11400, 100, 56, 19, '2023-12-10 01:56:58', '2023-12-10 01:57:28', 'FLW-MOCK-09238163df316344bbaf1510529bc6b8', 'Raffle9ja_ 1702176071956', 'Completed', '4774380', '00', 'Raffle9ja_ 1702176071956'),
(14, NULL, NULL, NULL, 100, 56, 19, '2023-12-10 01:58:16', '2023-12-10 01:58:22', NULL, NULL, 'Cancelled', NULL, NULL, 'Raffle9ja_ 1702177018676'),
(15, 'Oshaba Samson Funded Account', 11400, 11500, 100, 56, 19, '2023-12-10 02:00:03', '2023-12-10 02:00:30', 'FLW-MOCK-b264b7b7effbe88f165936ba85deb078', 'Raffle9ja_ 1702177199982', 'Completed', '4774382', '00', 'Raffle9ja_ 1702177199982'),
(16, 'Oshaba Samson Funded Account', 11500, 11800, 300, 56, 19, '2023-12-10 02:03:52', '2023-12-10 02:04:40', 'FLW-MOCK-cd3ec879d976febd5d2e9648239aa8af', 'Raffle9ja_ 1702177419548', 'Completed', '4774386', '00', 'Raffle9ja_ 1702177419548'),
(17, NULL, NULL, NULL, 43, 56, 19, '2023-12-13 08:14:51', '2023-12-13 08:15:02', NULL, NULL, 'Cancelled', NULL, NULL, 'Raffle9ja_ 1702458875634');

-- --------------------------------------------------------

--
-- Table structure for table `agent_payments`
--

CREATE TABLE `agent_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `company_ref` varchar(255) NOT NULL,
  `flw_ref` varchar(255) DEFAULT NULL,
  `trx_ref` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `charge_response_code` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agent_payments`
--

INSERT INTO `agent_payments` (`id`, `amount`, `company_ref`, `flw_ref`, `trx_ref`, `status`, `transaction_id`, `charge_response_code`, `user_id`, `agent_id`, `created_at`, `updated_at`) VALUES
(1, 100, '1702173024713', NULL, NULL, 'Pending', NULL, NULL, 56, 19, '2023-12-10 00:54:36', '2023-12-10 00:54:36'),
(2, 100, '1702173276587', NULL, NULL, 'Pending', NULL, NULL, 56, 19, '2023-12-10 00:54:47', '2023-12-10 00:54:47'),
(3, 100, '1702173286992', NULL, NULL, 'Cancelled', NULL, NULL, 56, 19, '2023-12-10 00:56:17', '2023-12-10 00:56:28'),
(4, 100, '1702173376847', NULL, NULL, 'Pending', NULL, NULL, 56, 19, '2023-12-10 01:05:25', '2023-12-10 01:05:25');

-- --------------------------------------------------------

--
-- Table structure for table `agent_pins`
--

CREATE TABLE `agent_pins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_raffle_booking_transactions`
--

CREATE TABLE `agent_raffle_booking_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `narration` varchar(255) NOT NULL,
  `balance_bd` double NOT NULL,
  `balance_ad` double NOT NULL,
  `amount` double NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Page MFBank', '560', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(2, 'Stanbic Mobile Money', '304', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(3, 'FortisMobile', '308', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(4, 'TagPay', '328', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(5, 'FBNMobile', '309', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(6, 'First Bank of Nigeria', '011', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(7, 'Sterling Mobile', '326', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(8, 'Omoluabi Mortgage Bank', '990', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(9, 'ReadyCash (Parkway)', '311', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(10, 'Zenith Bank', '057', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(11, 'Standard Chartered Bank', '068', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(12, 'eTranzact', '306', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(13, 'Fidelity Bank', '070', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(14, 'CitiBank', '023', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(15, 'Unity Bank', '215', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(16, 'Access Money', '323', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(17, 'Eartholeum', '302', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(18, 'Hedonmark', '324', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(19, 'MoneyBox', '325', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(20, 'JAIZ Bank', '301', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(21, 'Ecobank Plc', '050', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(22, 'EcoMobile', '307', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(23, 'Fidelity Mobile', '318', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(24, 'TeasyMobile', '319', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(25, 'NIP Virtual Bank', '999', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(26, 'VTNetworks', '320', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(27, 'Stanbic IBTC Bank', '221', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(28, 'Fortis Microfinance Bank', '501', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(29, 'PayAttitude Online', '329', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(30, 'ZenithMobile', '322', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(31, 'ChamsMobile', '303', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(32, 'SafeTrust Mortgage Bank', '403', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(33, 'Covenant Microfinance Bank', '551', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(34, 'Imperial Homes Mortgage Bank', '415', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(35, 'NPF MicroFinance Bank', '552', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(36, 'Parralex', '526', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(37, 'Wema Bank', '035', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(38, 'Enterprise Bank', '084', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(39, 'Diamond Bank', '063', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(40, 'Paycom', '305', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(41, 'SunTrust Bank', '100', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(42, 'Cellulant', '317', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(43, 'ASO Savings and & Loans', '401', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(44, 'Heritage', '030', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(45, 'Jubilee Life Mortgage Bank', '402', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(46, 'GTBank Plc', '058', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(47, 'Union Bank', '032', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(48, 'Sterling Bank', '232', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(49, 'Polaris Bank', '076', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(50, 'Keystone Bank', '082', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(51, 'Pagatech', '327', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(52, 'Coronation Merchant Bank', '559', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(53, 'FSDH', '601', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(54, 'Mkudi', '313', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(55, 'First City Monument Bank', '214', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(56, 'FET', '314', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(57, 'Trustbond', '523', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(58, 'GTMobile', '315', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(59, 'United Bank for Africa', '033', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(60, 'Access Bank', '044', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(61, 'TCF MFB', '90115', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(62, 'Test bank', '090175', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(63, 'Globus Bank', '103', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(64, 'Enterprise Bank', '000019', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(65, 'Titan Trust Bank', '000025', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(66, 'Taj Bank Limited', '000026', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(67, 'Central Bank Of Nigeria', '000028', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(68, 'Lotus Bank', '000029', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(69, 'Parallex Bank', '000030', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(70, 'PremiumTrust Bank', '000031', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(71, 'ENaira', '000033', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(72, 'SIGNATURE BANK', '000034', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(73, 'Optimus Bank', '000036', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(74, 'County Finance Ltd', '050001', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(75, 'Fewchore Finance Company Limited', '050002', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(76, 'Sagegrey Finance Limited', '050003', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(77, 'Newedge Finance Ltd', '050004', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(78, 'Aaa Finance', '050005', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(79, 'Branch International Financial Services', '050006', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(80, 'Tekla Finance Ltd', '050007', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(81, 'SIMPLE FINANCE LIMITED', '050008', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(82, 'FAST CREDIT', '050009', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(83, 'FUNDQUEST FINANCIAL SERVICES LTD', '050010', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(84, 'Enco Finance', '050012', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(85, 'Dignity Finance', '050013', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(86, 'TRINITY FINANCIAL SERVICES LIMITED', '050014', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(87, 'Coronation Merchant Bank', '060001', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(88, 'FBNQUEST Merchant Bank', '060002', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(89, 'Nova Merchant Bank', '060003', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(90, 'Greenwich Merchant Bank', '060004', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(91, 'NPF MicroFinance Bank', '070001', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(92, 'Fortis Microfinance Bank', '070002', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(93, 'Covenant Microfinance Bank', '070006', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(94, 'Omoluabi savings and loans', '070007', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(95, 'Page Financials', '070008', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(96, 'Gateway Mortgage Bank', '070009', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(97, 'Abbey Mortgage Bank', '070010', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(98, 'Refuge Mortgage Bank', '070011', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(99, 'Lagos Building Investment Company', '070012', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(100, 'Platinum Mortgage Bank', '070013', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(101, 'First Generation Mortgage Bank', '070014', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(102, 'Brent Mortgage Bank', '070015', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(103, 'Infinity Trust Mortgage Bank', '070016', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(104, 'Haggai Mortgage Bank Limited', '070017', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(105, 'Mayfresh Mortgage Bank', '070019', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(106, 'Coop Mortgage Bank', '070021', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(107, 'Stb Mortgage Bank', '070022', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(108, 'Delta Trust Mortgage Bank', '070023', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(109, 'Homebase Mortgage', '070024', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(110, 'Akwa Savings & Loans Limited', '070025', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(111, 'Fha Mortgage Bank Ltd', '070026', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(112, 'Tajwallet', '080002', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(113, 'ASOSavings & Loans', '090001', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(114, 'Jubilee-Life Mortgage  Bank', '090003', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(115, 'Parralex Microfinance bank', '090004', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(116, 'Trustbond Mortgage Bank', '090005', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(117, 'SafeTrust ', '090006', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(118, 'Ekondo MFB', '090097', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(119, 'FBN Mortgages Limited', '090107', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(120, 'New Prudential Bank', '090108', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(121, 'VFD Micro Finance Bank', '090110', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(122, 'Seed Capital Microfinance Bank', '090112', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(123, 'Microvis Microfinance Bank', '090113', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(124, 'Empire trust MFB', '090114', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(125, 'TCF MFB', '090115', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(126, 'AMML MFB', '090116', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(127, 'Boctrust Microfinance Bank', '090117', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(128, 'IBILE Microfinance Bank', '090118', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(129, 'Ohafia Microfinance Bank', '090119', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(130, 'Wetland Microfinance Bank', '090120', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(131, 'Hasal Microfinance Bank', '090121', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(132, 'Gowans Microfinance Bank', '090122', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(133, 'Verite Microfinance Bank', '090123', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(134, 'Xslnce Microfinance Bank', '090124', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(135, 'Regent Microfinance Bank', '090125', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(136, 'Fidfund Microfinance Bank', '090126', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(137, 'BC Kash Microfinance Bank', '090127', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(138, 'Ndiorah Microfinance Bank', '090128', '2023-11-22 04:05:26', '2023-11-22 04:05:26'),
(139, 'Money Trust Microfinance Bank', '090129', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(140, 'Consumer Microfinance Bank', '090130', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(141, 'Allworkers Microfinance Bank', '090131', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(142, 'Richway Microfinance Bank', '090132', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(143, ' AL-Barakah Microfinance Bank', '090133', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(144, 'Accion Microfinance Bank', '090134', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(145, 'Personal Trust Microfinance Bank', '090135', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(146, 'Baobab Microfinance Bank', '090136', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(147, 'PecanTrust Microfinance Bank', '090137', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(148, 'Royal Exchange Microfinance Bank', '090138', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(149, 'Visa Microfinance Bank', '090139', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(150, 'Sagamu Microfinance Bank', '090140', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(151, 'Chikum Microfinance Bank', '090141', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(152, 'Yes Microfinance Bank', '090142', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(153, 'Apeks Microfinance Bank', '090143', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(154, 'CIT Microfinance Bank', '090144', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(155, 'Fullrange Microfinance Bank', '090145', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(156, 'Trident Microfinance Bank', '090146', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(157, 'Hackman Microfinance Bank', '090147', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(158, 'Bowen Microfinance Bank', '090148', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(159, 'IRL Microfinance Bank', '090149', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(160, 'Virtue Microfinance Bank', '090150', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(161, 'Mutual Trust Microfinance Bank', '090151', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(162, 'Nagarta Microfinance Bank', '090152', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(163, 'FFS Microfinance Bank', '090153', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(164, 'CEMCS Microfinance Bank', '090154', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(165, 'La  Fayette Microfinance Bank', '090155', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(166, 'e-Barcs Microfinance Bank', '090156', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(167, 'Infinity Microfinance Bank', '090157', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(168, 'Futo Microfinance Bank', '090158', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(169, 'Credit Afrique Microfinance Bank', '090159', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(170, 'Addosser Microfinance Bank', '090160', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(171, 'Okpoga Microfinance Bank', '090161', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(172, 'Stanford Microfinance Bak', '090162', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(173, 'First Multiple Microfinance Bank', '090163', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(174, 'First Royal Microfinance Bank', '090164', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(175, 'Petra Microfinance Bank', '090165', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(176, 'Eso-E Microfinance Bank', '090166', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(177, 'Daylight Microfinance Bank', '090167', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(178, 'Gashua Microfinance Bank', '090168', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(179, 'Alpha Kapital Microfinance Bank', '090169', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(180, 'Rahama Microfinance Bank', '090170', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(181, 'Mainstreet Microfinance Bank', '090171', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(182, 'Astrapolaris Microfinance Bank', '090172', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(183, 'Reliance Microfinance Bank', '090173', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(184, 'Malachy Microfinance Bank', '090174', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(185, 'Bosak Microfinance Bank', '090176', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(186, 'Lapo Microfinance Bank', '090177', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(187, 'GreenBank Microfinance Bank', '090178', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(188, 'FAST Microfinance Bank', '090179', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(189, 'AMJU Unique Microfinance Bank', '090180', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(190, 'Balogun Fulani  Microfinance Bank', '090181', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(191, 'Standard Microfinance Bank', '090182', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(192, 'Girei Microfinance Bank', '090186', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(193, 'Baines Credit Microfinance Bank', '090188', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(194, 'Esan Microfinance Bank', '090189', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(195, 'Mutual Benefits Microfinance Bank', '090190', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(196, 'KCMB Microfinance Bank', '090191', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(197, 'Midland Microfinance Bank', '090192', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(198, 'Unical Microfinance Bank', '090193', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(199, 'NIRSAL Microfinance Bank', '090194', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(200, 'Grooming Microfinance Bank', '090195', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(201, 'Pennywise Microfinance Bank', '090196', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(202, 'ABU Microfinance Bank', '090197', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(203, 'RenMoney Microfinance Bank', '090198', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(204, 'Xpress Payments', '090201', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(205, 'Accelerex Network', '090202', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(206, 'New Dawn Microfinance Bank', '090205', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(207, 'Itex Integrated Services Limited', '090211', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(208, 'UNN MFB', '090251', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(209, 'Yobe Microfinance Bank', '090252', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(210, 'Coalcamp Microfinance Bank', '090254', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(211, 'Imo State Microfinance Bank', '090258', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(212, 'Alekun Microfinance Bank', '090259', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(213, 'Above Only Microfinance Bank', '090260', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(214, 'Quickfund Microfinance Bank', '090261', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(215, 'Stellas Microfinance Bank', '090262', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(216, 'Navy Microfinance Bank', '090263', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(217, 'Auchi Microfinance Bank', '090264', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(218, 'Lovonus Microfinance Bank', '090265', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(219, 'Uniben Microfinance Bank', '090266', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(220, 'Kuda', '090267', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(221, 'Adeyemi College Staff Microfinance Bank', '090268', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(222, 'Greenville Microfinance Bank', '090269', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(223, 'AB Microfinance Bank', '090270', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(224, 'Lavender Microfinance Bank', '090271', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(225, 'Olabisi Onabanjo University Microfinance Bank', '090272', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(226, 'Emeralds Microfinance Bank', '090273', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(227, 'Prestige Microfinance Bank', '090274', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(228, 'Meridian Microfinance Bank', '090275', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(229, 'Trustfund Microfinance Bank', '090276', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(230, 'Al-Hayat Microfinance Bank', '090277', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(231, 'Glory Microfinance Bank ', '090278', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(232, 'Ikire Microfinance Bank', '090279', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(233, 'Megapraise Microfinance Bank', '090280', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(234, 'Mint-Finex MICROFINANCE BANK', '090281', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(235, 'Arise Microfinance Bank', '090282', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(236, 'Thrive Microfinance Bank', '090283', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(237, 'First Option Microfinance Bank', '090285', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(238, 'Safe Haven MFB', '090286', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(239, 'Assets Matrix Microfinance Bank', '090287', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(240, 'Pillar Microfinance Bank', '090289', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(241, 'Fct Microfinance Bank', '090290', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(242, 'Halacredit Microfinance Bank', '090291', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(243, 'Afekhafe Microfinance Bank', '090292', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(244, 'Brethren Microfinance Bank', '090293', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(245, 'Eagle Flight Microfinance Bank', '090294', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(246, 'Omiye Microfinance Bank', '090295', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(247, 'Polyuwanna Microfinance Bank', '090296', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(248, 'Alert Microfinance Bank', '090297', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(249, 'Federalpoly Nasarawamfb', '090298', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(250, 'Kontagora Microfinance Bank', '090299', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(251, 'Sunbeam Microfinance Bank', '090302', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(252, 'Purplemoney Microfinance Bank', '090303', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(253, 'Evangel Microfinance Bank', '090304', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(254, 'Sulsap Microfinance Bank', '090305', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(255, 'Aramoko Microfinance Bank', '090307', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(256, 'Brightway Microfinance Bank', '090308', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(257, 'Edfin Microfinance Bank', '090310', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(258, 'U And C Microfinance Bank', '090315', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(259, 'Bayero Microfinance Bank', '090316', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(260, 'PatrickGold Microfinance Bank', '090317', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(261, 'Federal University Dutse  Microfinance Bank', '090318', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(262, 'Bonghe Microfinance Bank', '090319', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(263, 'Kadpoly Microfinance Bank', '090320', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(264, 'Mayfair  Microfinance Bank', '090321', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(265, 'Rephidim Microfinance Bank', '090322', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(266, 'Mainland Microfinance Bank', '090323', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(267, 'Ikenne Microfinance Bank', '090324', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(268, 'Sparkle', '090325', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(269, 'Balogun Gambari Microfinance Bank', '090326', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(270, 'Trust Microfinance Bank', '090327', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(271, 'Eyowo MFB', '090328', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(272, 'Neptune Microfinance Bank', '090329', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(273, 'Fame Microfinance Bank', '090330', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(274, 'Unaab Microfinance Bank', '090331', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(275, 'Evergreen Microfinance Bank', '090332', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(276, 'Oche Microfinance Bank', '090333', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(277, 'Grant MF Bank', '090335', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(278, 'Bipc Microfinance Bank', '090336', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(279, 'Iyeru Okin Microfinance Bank Ltd', '090337', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(280, 'Uniuyo Microfinance Bank', '090338', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(281, 'Stockcorp  Microfinance Bank', '090340', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(282, 'Unilorin Microfinance Bank', '090341', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(283, 'Citizen Trust Microfinance Bank Ltd', '090343', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(284, 'Oau Microfinance Bank Ltd', '090345', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(285, 'Nasarawa Microfinance Bank', '090349', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(286, 'Illorin Microfinance Bank', '090350', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(287, 'Jessefield Microfinance Bank', '090352', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(288, 'Isuofia Microfinance Bank', '090353', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(289, 'Cashconnect   Microfinance Bank', '090360', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(290, 'Molusi Microfinance Bank', '090362', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(291, 'Headway Microfinance Bank', '090363', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(292, 'Nuture Microfinance Bank', '090364', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(293, 'Corestep Microfinance Bank', '090365', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(294, 'Firmus MFB', '090366', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(295, 'Seedvest Microfinance Bank', '090369', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(296, 'Ilasan Microfinance Bank', '090370', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(297, 'Agosasa Microfinance Bank', '090371', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(298, 'Legend Microfinance Bank', '090372', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(299, 'Tf Microfinance Bank', '090373', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(300, 'Coastline Microfinance Bank', '090374', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(301, 'Apple  Microfinance Bank', '090376', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(302, 'Isaleoyo Microfinance Bank', '090377', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(303, 'New Golden Pastures Microfinance Bank', '090378', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(304, 'Peniel Micorfinance Bank Ltd', '090379', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(305, 'Kredi Money Microfinance Bank', '090380', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(306, 'Manny Microfinance bank', '090383', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(307, 'Gti  Microfinance Bank', '090385', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(308, 'Interland Microfinance Bank', '090386', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(309, 'Ek-Reliable Microfinance Bank', '090389', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(310, 'Parkway Mf Bank', '090390', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(311, 'Davodani  Microfinance Bank', '090391', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(312, 'Mozfin Microfinance Bank', '090392', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(313, 'BRIDGEWAY MICROFINANCE BANK', '090393', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(314, 'Amac Microfinance Bank', '090394', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(315, 'Borgu Microfinance Bank', '090395', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(316, 'Oscotech Microfinance Bank', '090396', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(317, 'Chanelle Bank', '090397', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(318, 'Federal Polytechnic Nekede Microfinance Bank', '090398', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(319, 'Nwannegadi Microfinance Bank', '090399', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(320, 'Finca Microfinance Bank', '090400', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(321, 'Shepherd Trust Microfinance Bank', '090401', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(322, 'Peace Microfinance Bank', '090402', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(323, 'Uda Microfinance Bank', '090403', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(324, 'Olowolagba Microfinance Bank', '090404', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(325, 'Moniepoint Microfinance Bank', '090405', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(326, 'Business Support Microfinance Bank', '090406', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(327, 'Gmb Microfinance Bank', '090408', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(328, 'Fcmb Microfinance Bank', '090409', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(329, 'Maritime Microfinance Bank', '090410', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(330, 'Giginya Microfinance Bank', '090411', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(331, 'Preeminent Microfinance Bank', '090412', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(332, 'Benysta Microfinance Bank', '090413', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(333, 'Crutech  Microfinance Bank', '090414', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(334, 'Calabar Microfinance Bank', '090415', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(335, 'Chibueze Microfinance Bank', '090416', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(336, 'Imowo Microfinance Bank', '090417', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(337, 'Highland Microfinance Bank', '090418', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(338, 'Winview Bank', '090419', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(339, 'Letshego MFB', '090420', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(340, 'Izon Microfinance Bank', '090421', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(341, 'Landgold  Microfinance Bank', '090422', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(342, 'MAUTECH Microfinance Bank', '090423', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(343, 'Abucoop  Microfinance Bank', '090424', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(344, 'Banex Microfinance Bank', '090425', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(345, 'Tangerine Bank', '090426', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(346, 'Ebsu Microfinance Bank', '090427', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(347, 'Ishie  Microfinance Bank', '090428', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(348, 'Crossriver  Microfinance Bank', '090429', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(349, 'Ilora Microfinance Bank', '090430', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(350, 'Bluewhales  Microfinance Bank', '090431', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(351, 'Memphis Microfinance Bank', '090432', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(352, 'Rigo Microfinance Bank', '090433', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(353, 'Insight Microfinance Bank', '090434', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(354, 'Links Microfinance Bank', '090435', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(355, 'Spectrum Microfinance Bank', '090436', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(356, 'Oakland Microfinance Bank', '090437', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(357, 'Futminna Microfinance Bank', '090438', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(358, 'Ibeto  Microfinance Bank', '090439', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(359, 'Cherish Microfinance Bank', '090440', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(360, 'Giwa Microfinance Bank', '090441', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(361, 'Rima Microfinance Bank', '090443', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(362, 'Boi Mf Bank', '090444', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(363, 'Capstone Mf Bank', '090445', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(364, 'Support Mf Bank', '090446', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(365, 'Moyofade Mf Bank', '090448', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(366, 'Sls  Mf Bank', '090449', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(367, 'Kwasu Mf Bank', '090450', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(368, 'Atbu  Microfinance Bank', '090451', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(369, 'Unilag  Microfinance Bank', '090452', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(370, 'Uzondu Mf Bank', '090453', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(371, 'Borstal Microfinance Bank', '090454', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(372, 'MKOBO MICROFINANCE BANK LTD', '090455', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(373, 'Ospoly Microfinance Bank', '090456', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(374, 'Nice Microfinance Bank', '090459', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(375, 'Oluyole Microfinance Bank', '090460', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(376, 'Uniibadan Microfinance Bank', '090461', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(377, 'Monarch Microfinance Bank', '090462', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(378, 'Rehoboth Microfinance Bank', '090463', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(379, 'Unimaid Microfinance Bank', '090464', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(380, 'Maintrust Microfinance Bank', '090465', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(381, 'Yct Microfinance Bank', '090466', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(382, 'Good Neighbours Microfinance Bank', '090467', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(383, 'Olofin Owena Microfinance Bank', '090468', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(384, 'Aniocha Microfinance Bank', '090469', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(385, 'DOT MICROFINANCE BANK', '090470', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(386, 'Oluchukwu Microfinance Bank', '090471', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(387, 'Caretaker Microfinance Bank', '090472', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(388, 'Assets Microfinance Bank', '090473', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(389, 'Verdant Microfinance Bank', '090474', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(390, 'Giant Stride Microfinance Bank', '090475', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(391, 'Anchorage Microfinance Bank', '090476', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(392, 'Light Microfinance Bank', '090477', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(393, 'Avuenegbe Microfinance Bank', '090478', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(394, 'First Heritage Microfinance Bank', '090479', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(395, 'Cintrust Microfinance Bank', '090480', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(396, 'Prisco  Microfinance Bank', '090481', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(397, 'FEDETH MICROFINANCE BANK', '090482', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(398, 'Ada Microfinance Bank', '090483', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(399, 'Garki Microfinance Bank', '090484', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(400, 'Safegate Microfinance Bank', '090485', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(401, 'Fortress Microfinance Bank', '090486', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(402, 'Kingdom College  Microfinance Bank', '090487', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(403, 'Ibu-Aje Microfinance', '090488', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(404, 'Alvana Microfinance Bank', '090489', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(405, 'Chukwunenye  Microfinance Bank', '090490', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(406, 'Nsuk  Microfinance Bank', '090491', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(407, 'Oraukwu  Microfinance Bank', '090492', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(408, 'Iperu Microfinance Bank', '090493', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(409, 'Boji Boji Microfinance Bank', '090494', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(410, 'GOODNEWS MFB', '090495', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(411, 'Radalpha Microfinance Bank', '090496', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(412, 'Palmcoast Microfinance Bank', '090497', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(413, 'Catland Microfinance Bank', '090498', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(414, 'Pristine Divitis Microfinance Bank', '090499', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(415, 'Gwong Microfinance Bank', '090500', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(416, 'Boromu Microfinance Bank', '090501', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(417, 'Shalom Microfinance Bank', '090502', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(418, 'Projects Microfinance Bank', '090503', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(419, 'Zikora Microfinance Bank', '090504', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(420, 'Nigeria Prisonsmicrofinance Bank', '090505', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(421, 'Solid Allianze Microfinance Bank', '090506', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(422, 'Fims Microfinance Bank', '090507', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(423, 'Borno Renaissance Microfinance Bank', '090508', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(424, 'Capitalmetriq Swift Microfinance Bank', '090509', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(425, 'Umunnachi Microfinance Bank', '090510', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(426, 'Cloverleaf  Microfinance Bank', '090511', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(427, 'Bubayero Microfinance Bank', '090512', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(428, 'Seap Microfinance Bank', '090513', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(429, 'Umuchinemere Procredit Microfinance Bank', '090514', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(430, 'Rima Growth Pathway Microfinance Bank ', '090515', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(431, 'Numo Microfinance Bank', '090516', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(432, 'Uhuru Microfinance Bank', '090517', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(433, 'Afemai Microfinance Bank', '090518', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(434, 'Ibom Fadama Microfinance Bank', '090519', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(435, 'Ic Globalmicrofinance Bank', '090520', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(436, 'Foresight Microfinance Bank', '090521', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(437, 'Chase Microfinance Bank', '090523', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(438, 'Solidrock Microfinance Bank', '090524', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(439, 'Triple A Microfinance Bank', '090525', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(440, 'Crescent Microfinance Bank', '090526', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(441, 'Ojokoro Microfinance Bank', '090527', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(442, 'Mgbidi Microfinance Bank', '090528', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(443, 'Ampersand Microfinance Bank', '090529', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(444, 'Confidence Microfinance Bank Ltd', '090530', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(445, 'Aku Microfinance Bank', '090531', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(446, 'Ibolo Micorfinance Bank Ltd', '090532', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(447, 'Polyibadan Microfinance Bank', '090534', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(448, 'Nkpolu-Ust Microfinance', '090535', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(449, 'Ikoyi-Osun Microfinance Bank', '090536', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(450, 'Lobrem Microfinance Bank', '090537', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(451, 'Blue Investments Microfinance Bank', '090538', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(452, 'Enrich Microfinance Bank', '090539', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(453, 'Aztec Microfinance Bank', '090540', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(454, 'Excellent Microfinance Bank', '090541', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(455, 'Otuo Microfinance Bank Ltd', '090542', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(456, 'Iwoama Microfinance Bank', '090543', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(457, 'Aspire Microfinance Bank Ltd', '090544', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(458, 'Abulesoro Microfinance Bank Ltd', '090545', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(459, 'Ijebu-Ife Microfinance Bank Ltd', '090546', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(460, 'Rockshield Microfinance Bank', '090547', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(461, 'Ally Microfinance Bank', '090548', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(462, 'Kc Microfinance Bank', '090549', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(463, 'Green Energy Microfinance Bank Ltd', '090550', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(464, 'Fairmoney Microfinance Bank Ltd', '090551', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(465, 'Ekimogun Microfinance Bank', '090552', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(466, 'Consistent Trust Microfinance Bank Ltd', '090553', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(467, 'Kayvee Microfinance Bank', '090554', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(468, 'Bishopgate Microfinance Bank', '090555', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(469, 'Egwafin Microfinance Bank Ltd', '090556', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(470, 'Lifegate Microfinance Bank Ltd', '090557', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(471, 'Shongom Microfinance Bank Ltd', '090558', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(472, 'Shield Microfinance Bank Ltd', '090559', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(473, 'TANADI MFB (CRUST)', '090560', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(474, 'Akuchukwu Microfinance Bank Ltd', '090561', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(475, 'Cedar Microfinance Bank Ltd', '090562', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(476, 'Balera Microfinance Bank Ltd', '090563', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(477, 'Supreme Microfinance Bank Ltd', '090564', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(478, 'Oke-Aro Oredegbe Microfinance Bank Ltd', '090565', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(479, 'Okuku Microfinance Bank Ltd', '090566', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(480, 'Orokam Microfinance Bank Ltd', '090567', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(481, 'Broadview Microfinance Bank Ltd', '090568', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(482, 'Qube Microfinance Bank Ltd', '090569', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(483, 'Iyamoye Microfinance Bank Ltd', '090570', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(484, 'Ilaro Poly Microfinance Bank Ltd', '090571', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(485, 'Ewt Microfinance Bank', '090572', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(486, 'Snow Microfinance Bank', '090573', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(487, 'GOLDMAN MICROFINANCE BANK', '090574', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(488, 'Firstmidas Microfinance Bank Ltd', '090575', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(489, 'Octopus Microfinance Bank Ltd', '090576', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(490, 'Iwade Microfinance Bank Ltd', '090578', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(491, 'Gbede Microfinance Bank', '090579', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(492, 'Otech Microfinance Bank Ltd', '090580', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(493, 'BANC CORP MICROFINANCE BANK', '090581', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(494, 'STATESIDE MFB', '090583', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(495, 'ISLAND MICROFINANCE BANK ', '090584', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(496, 'GOMBE MICROFINANCE BANK LTD', '090586', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(497, 'Microbiz Microfinance Bank', '090587', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(498, 'Orisun MFB', '090588', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(499, 'Mercury MFB', '090589', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(500, 'WAYA MICROFINANCE BANK LTD', '090590', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(501, 'Gabsyn Microfinance Bank', '090591', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(502, 'KANO POLY MFB', '090592', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(503, 'TASUED MICROFINANCE BANK LTD', '090593', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(504, 'IBA MFB ', '090598', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(505, 'Greenacres MFB', '090599', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(506, 'AVE MARIA MICROFINANCE BANK LTD', '090600', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(507, 'KENECHUKWU MICROFINANCE BANK', '090602', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(508, 'Macrod MFB', '090603 ', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(509, 'KKU Microfinance Bank', '090606', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(510, 'Akpo Microfinance Bank', '090608', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(511, 'Ummah Microfinance Bank ', '090609', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(512, 'AMOYE MICROFINANCE BANK', '090610', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(513, 'Creditville Microfinance Bank', '090611', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(514, 'Medef Microfinance Bank', '090612', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(515, 'Total Trust Microfinance Bank', '090613', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(516, 'FLOURISH MFB', '090614', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(517, 'Beststar Microfinance Bank', '090615', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(518, 'RAYYAN Microfinance Bank', '090616', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(519, 'Iyin Ekiti MFB', '090620', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(520, 'GIDAUNIYAR ALHERI MICROFINANCE BANK', '090621', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(521, 'Mab Allianz MFB', '090623', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(522, 'FET', '100001', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(523, 'Parkway-ReadyCash', '100003', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(524, 'Opay', '100004', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(525, 'Cellulant', '100005', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(526, 'eTranzact', '100006', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(527, 'Stanbic IBTC @ease wallet', '100007', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(528, 'Ecobank Xpress Account', '100008', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(529, 'GTMobile', '100009', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(530, 'TeasyMobile', '100010', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(531, 'Mkudi', '100011', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(532, 'VTNetworks', '100012', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(533, 'AccessMobile', '100013', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(534, 'FBNMobile', '100014', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(535, 'Kegow', '100015', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(536, 'FortisMobile', '100016', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(537, 'Hedonmark', '100017', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(538, 'ZenithMobile', '100018', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(539, 'Fidelity Mobile', '100019', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(540, 'MoneyBox', '100020', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(541, 'Eartholeum', '100021', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(542, 'GoMoney', '100022', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(543, 'TagPay', '100023', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(544, 'Imperial Homes Mortgage Bank', '100024', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(545, 'Zinternet Nigera Limited', '100025', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(546, 'One Finance', '100026', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(547, 'Intellifin', '100027', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(548, 'AG Mortgage Bank', '100028', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(549, 'Innovectives Kesh', '100029', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(550, 'EcoMobile', '100030', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(551, 'FCMB Easy Account', '100031', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(552, 'Contec Global Infotech Limited (NowNow)', '100032', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(553, 'PALMPAY', '100033', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(554, 'Zwallet', '100034', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(555, 'M36', '100035', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(556, 'Kegow(Chamsmobile)', '100036', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(557, 'Titan-Paystack', '100039', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(558, 'Beta-Access Yello', '100052', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(559, 'ProvidusBank PLC', '101', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(560, 'PayAttitude Online', '110001', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(561, 'Flutterwave Technology Solutions Limited', '110002', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(562, 'Interswitch Limited', '110003', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(563, 'First Apple Limited', '110004', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(564, '3Line Card Management Limited', '110005', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(565, 'Paystack Payments Limited', '110006', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(566, 'TeamApt', '110007', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(567, 'Kadick Integration Limited', '110008', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(568, 'Venture Garden Nigeria Limited', '110009', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(569, 'Interswitch Financial Inclusion Services (Ifis)', '110010', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(570, 'Arca Payments', '110011', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(571, 'Cellulant Pssp', '110012', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(572, 'Qr Payments', '110013', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(573, 'Cyberspace Limited', '110014', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(574, 'Vas2Nets Limited', '110015', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(575, 'Crowdforce', '110017', '2023-11-22 04:05:27', '2023-11-22 04:05:27');
INSERT INTO `banks` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(576, 'Microsystems Investment And Development Limited', '110018', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(577, 'Nibssussd Payments', '110019', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(578, 'Bud Infrastructure Limited', '110021', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(579, 'Koraypay', '110022', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(580, 'Capricorn Digital', '110023', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(581, 'Resident Fintech Limited', '110024', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(582, 'Netapps Technology Limited', '110025', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(583, 'Spay Business', '110026', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(584, 'Yello Digital Financial Services', '110027', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(585, 'Nomba Financial Services Limited', '110028', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(586, 'Woven Finance', '110029', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(587, 'Leadremit Limited', '110044', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(588, '9 Payment Service Bank', '120001', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(589, 'Hopepsb', '120002', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(590, 'Momo Psb', '120003', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(591, 'Smartcash Payment Service Bank', '120004', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(592, 'Money Master Psb', '120005', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(593, 'FSDH Merchant Bank', '400001', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(594, 'Rand merchant Bank', '502', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(595, 'FINATRUST MICROFINANCE BANK', '608', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(596, 'CBN_TSA', '999001', '2023-11-22 04:05:27', '2023-11-22 04:05:27'),
(597, 'NIP Virtual Bank', '999999', '2023-11-22 04:05:27', '2023-11-22 04:05:27');

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `bank_code` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `user_id`, `account_no`, `bank_code`, `bank`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 25, '0044925820', '044', 'Access Bank', 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Riders', '2023-10-05 10:29:51', '2023-10-05 10:29:51'),
(2, 'Artisans', '2023-10-11 03:39:24', '2023-10-10 23:00:00'),
(3, 'General', '2023-10-11 03:40:39', '2023-10-10 23:00:00'),
(4, 'Traders', '2023-10-20 00:01:34', '2023-10-20 00:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `wallet` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `first_name`, `last_name`, `phone`, `email`, `created_at`, `updated_at`, `wallet`) VALUES
(1, 1, 'Nnamdi', 'John', '080349443733', NULL, '2023-10-05 12:27:24', '2023-12-10 06:01:06', 6000),
(2, 20, 'Nnamdi', 'John', '080349443721', NULL, '2023-10-26 07:09:26', '2023-10-26 07:09:26', 3200),
(6, 24, 'Nnamdi', 'John', '080349443700', NULL, '2023-10-26 07:19:43', '2023-10-26 07:19:43', NULL),
(7, 25, 'Nnamdi', 'John', '0803439443700', NULL, '2023-10-28 12:35:02', '2023-12-10 12:02:50', 6900);

-- --------------------------------------------------------

--
-- Table structure for table `customers_stakes`
--

CREATE TABLE `customers_stakes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` varchar(255) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `stake_price` int(11) NOT NULL,
  `stake_number` int(11) NOT NULL,
  `win` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `winning_tags_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` enum('Credit','Card') NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `stake_platform_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers_stakes`
--

INSERT INTO `customers_stakes` (`id`, `user_id`, `ticket_id`, `sub_cat_id`, `stake_price`, `stake_number`, `win`, `month`, `year`, `created_at`, `updated_at`, `winning_tags_id`, `category_id`, `customer_id`, `payment_method`, `active`, `stake_platform_id`) VALUES
(1, 1, 'sbhUy2JhH0', 1, 251, 100, 1, 11, 2023, '2023-10-19 22:22:45', '2023-10-24 19:48:13', 2, 2, 1, 'Card', 0, 1),
(2, 1, 'pGGIlmsz2F', 1, 251, 100, 0, 11, 2023, '2023-10-19 22:29:04', '2023-10-24 19:48:13', 2, 2, 1, 'Card', 0, 1),
(4, 1, 'OeXJR4Nxdt', 1, 251, 15, 1, 11, 2023, '2023-11-16 19:28:54', '2023-10-24 19:48:13', 2, 2, 1, 'Card', 0, 1),
(7, 1, 'p7hxbXVBgn', 1, 251, 15, 1, 11, 2023, '2023-10-28 13:45:23', '2023-10-28 13:45:23', 2, 2, 1, 'Card', 1, 1),
(8, 1, 'CSdM5f2DAt', 1, 251, 15, 1, 11, 2023, '2023-10-28 13:45:45', '2023-10-28 13:45:45', 2, 2, 1, 'Card', 1, 1),
(9, 1, 'l1dZ1Q83ZV', 1, 251, 15, 1, 11, 2023, '2023-11-28 13:46:31', '2023-10-28 13:46:31', 2, 2, 1, 'Card', 1, 1),
(10, 1, '5MF5pFsB8F', 1, 251, 15, 1, 11, 2023, '2023-10-28 13:46:54', '2023-10-28 13:46:54', 2, 2, 1, 'Card', 1, 1),
(11, 1, 'WFC4KVnEXB', 1, 251, 19, 0, 11, 2023, '2023-10-28 13:48:10', '2023-10-28 13:48:10', 2, 2, 1, 'Card', 1, 1),
(12, 1, 'RTJ0XQ6lhV', 1, 251, 180, 0, 11, 2023, '2023-12-28 13:54:55', '2023-10-28 13:54:55', 2, 2, 1, 'Card', 1, 1),
(13, 1, 'Nthp8M61XI', 1, 251, 180, 0, 11, 2023, '2023-10-29 08:55:48', '2023-10-29 08:55:48', 2, 2, 1, 'Card', 1, 1),
(14, 1, 'INX4VSh2XG', 1, 251, 180, 0, 11, 2023, '2023-10-29 09:43:12', '2023-10-29 09:43:12', 2, 2, 1, 'Card', 1, 1),
(15, 1, '4a6UHu59B5', 1, 251, 180, 0, 11, 2023, '2023-10-29 09:47:25', '2023-10-29 09:47:25', 2, 2, 1, 'Card', 1, 1),
(16, 1, 'g1x6ijUbbo', 1, 251, 180, 0, 11, 2023, '2023-10-29 09:47:28', '2023-10-29 09:47:28', 2, 2, 1, 'Card', 1, 1),
(17, 1, 'qwYn0kL2YD', 1, 251, 180, 0, 11, 2023, '2023-10-29 09:47:46', '2023-10-29 09:47:46', 2, 2, 1, 'Card', 1, 1),
(18, 1, 'Ca0TPTw3zk', 1, 251, 180, 0, 11, 2023, '2023-10-29 09:47:47', '2023-10-29 09:47:47', 2, 2, 1, 'Card', 1, 1),
(19, 1, '6asSdtrxXD', 1, 251, 180, 0, 11, 2023, '2023-10-29 09:50:37', '2023-10-29 09:50:37', 2, 2, 1, 'Card', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_funding_transactions`
--

CREATE TABLE `customer_funding_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `narration` varchar(255) NOT NULL,
  `balance_ba` double NOT NULL,
  `balance_aa` double NOT NULL,
  `amount` double NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_raffle_booking_transactions`
--

CREATE TABLE `customer_raffle_booking_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `narration` varchar(255) NOT NULL,
  `balance_bd` double NOT NULL,
  `balance_ad` double NOT NULL,
  `amount` double NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_transaction_history`
--

CREATE TABLE `customer_transaction_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_ref` varchar(255) NOT NULL,
  `ids` int(20) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_transaction_history`
--

INSERT INTO `customer_transaction_history` (`id`, `user_id`, `transaction_type`, `amount`, `description`, `created_at`, `updated_at`, `customer_id`, `transaction_ref`, `ids`, `status`) VALUES
(1, 1, 'Credit', 5049.87, 'Adding new Amount', '2023-10-27 01:31:47', '2023-10-27 01:31:47', 1, '', 0, NULL),
(2, 1, 'Credit', 7549.87, 'Adding new Amount', '2023-10-27 01:32:52', '2023-10-27 01:32:52', 1, '', 0, NULL),
(3, 1, 'Credit', 10049.87, 'Adding new Amount', '2023-10-27 01:32:54', '2023-10-27 01:32:54', 1, '', 0, NULL),
(4, 1, 'Credit', 12549.87, 'Adding new Amount', '2023-10-27 01:33:21', '2023-10-27 01:33:21', 1, '', 0, NULL),
(5, 1, 'Credit', 15049.87, 'Adding new Amount', '2023-10-27 01:33:42', '2023-10-27 01:33:42', 1, '', 0, NULL),
(6, 1, 'Credit', 2500, 'Adding new Amount', '2023-10-27 01:34:52', '2023-10-27 01:34:52', 1, '', 0, NULL),
(7, 1, 'Credit', 2500, 'Adding new Amount', '2023-10-27 01:34:53', '2023-10-27 01:34:53', 1, '', 0, NULL),
(8, 1, 'Debit', 1500.11, 'Payment for ticket 6asSdtrxXD', '2023-10-29 09:50:37', '2023-10-29 09:50:37', 1, 'XwcrLojHkd', 0, NULL);

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
-- Table structure for table `flutterwave_details`
--

CREATE TABLE `flutterwave_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locals`
--

CREATE TABLE `locals` (
  `local_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `local_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `locals`
--

INSERT INTO `locals` (`local_id`, `state_id`, `local_name`) VALUES
(1, 1, 'Aba South'),
(2, 1, 'Arochukwu'),
(3, 1, 'Bende'),
(4, 1, 'Ikwuano'),
(5, 1, 'Isiala Ngwa North'),
(6, 1, 'Isiala Ngwa South'),
(7, 1, 'Isuikwuato'),
(8, 1, 'Obi Ngwa'),
(9, 1, 'Ohafia'),
(10, 1, 'Osisioma'),
(11, 1, 'Ugwunagbo'),
(12, 1, 'Ukwa East'),
(13, 1, 'Ukwa West'),
(14, 1, 'Umuahia North'),
(15, 1, 'Umuahia South'),
(16, 1, 'Umu Nneochi'),
(17, 2, 'Fufure'),
(18, 2, 'Ganye'),
(19, 2, 'Gayuk'),
(20, 2, 'Gombi'),
(21, 2, 'Grie'),
(22, 2, 'Hong'),
(23, 2, 'Jada'),
(24, 2, 'Lamurde'),
(25, 2, 'Madagali'),
(26, 2, 'Maiha'),
(27, 2, 'Mayo Belwa'),
(28, 2, 'Michika'),
(29, 2, 'Mubi North'),
(30, 2, 'Mubi South'),
(31, 2, 'Numan'),
(32, 2, 'Shelleng'),
(33, 2, 'Song'),
(34, 2, 'Toungo'),
(35, 2, 'Yola North'),
(36, 2, 'Yola South'),
(37, 3, 'Eastern Obolo'),
(38, 3, 'Eket'),
(39, 3, 'Esit Eket'),
(40, 3, 'Essien Udim'),
(41, 3, 'Etim Ekpo'),
(42, 3, 'Etinan'),
(43, 3, 'Ibeno'),
(44, 3, 'Ibesikpo Asutan'),
(45, 3, 'Ibiono-Ibom'),
(46, 3, 'Ika'),
(47, 3, 'Ikono'),
(48, 3, 'Ikot Abasi'),
(49, 3, 'Ikot Ekpene'),
(50, 3, 'Ini'),
(51, 3, 'Itu'),
(52, 3, 'Mbo'),
(53, 3, 'Mkpat-Enin'),
(54, 3, 'Nsit-Atai'),
(55, 3, 'Nsit-Ibom'),
(56, 3, 'Nsit-Ubium'),
(57, 3, 'Obot Akara'),
(58, 3, 'Okobo'),
(59, 3, 'Onna'),
(60, 3, 'Oron'),
(61, 3, 'Oruk Anam'),
(62, 3, 'Udung-Uko'),
(63, 3, 'Ukanafun'),
(64, 3, 'Uruan'),
(65, 3, 'Urue-Offong/Oruko'),
(66, 3, 'Uyo'),
(67, 4, 'Anambra East'),
(68, 4, 'Anambra West'),
(69, 4, 'Anaocha'),
(70, 4, 'Awka North'),
(71, 4, 'Awka South'),
(72, 4, 'Ayamelum'),
(73, 4, 'Dunukofia'),
(74, 4, 'Ekwusigo'),
(75, 4, 'Idemili North'),
(76, 4, 'Idemili South'),
(77, 4, 'Ihiala'),
(78, 4, 'Njikoka'),
(79, 4, 'Nnewi North'),
(80, 4, 'Nnewi South'),
(81, 4, 'Ogbaru'),
(82, 4, 'Onitsha North'),
(83, 4, 'Onitsha South'),
(84, 4, 'Orumba North'),
(85, 4, 'Orumba South'),
(86, 4, 'Oyi'),
(87, 5, 'Bauchi'),
(88, 5, 'Bogoro'),
(89, 5, 'Damban'),
(90, 5, 'Darazo'),
(91, 5, 'Dass'),
(92, 5, 'Gamawa'),
(93, 5, 'Ganjuwa'),
(94, 5, 'Giade'),
(95, 5, 'Itas/Gadau'),
(96, 5, 'Jama\'are'),
(97, 5, 'Katagum'),
(98, 5, 'Kirfi'),
(99, 5, 'Misau'),
(100, 5, 'Ningi'),
(101, 5, 'Shira'),
(102, 5, 'Tafawa Balewa'),
(103, 5, 'Toro'),
(104, 5, 'Warji'),
(105, 5, 'Zaki'),
(106, 6, 'Ekeremor'),
(107, 6, 'Kolokuma/Opokuma'),
(108, 6, 'Nembe'),
(109, 6, 'Ogbia'),
(110, 6, 'Sagbama'),
(111, 6, 'Southern Ijaw'),
(112, 6, 'Yenagoa'),
(113, 7, 'Apa'),
(114, 7, 'Ado'),
(115, 7, 'Buruku'),
(116, 7, 'Gboko'),
(117, 7, 'Guma'),
(118, 7, 'Gwer East'),
(119, 7, 'Gwer West'),
(120, 7, 'Katsina-Ala'),
(121, 7, 'Konshisha'),
(122, 7, 'Kwande'),
(123, 7, 'Logo'),
(124, 7, 'Makurdi'),
(125, 7, 'Obi'),
(126, 7, 'Ogbadibo'),
(127, 7, 'Ohimini'),
(128, 7, 'Oju'),
(129, 7, 'Okpokwu'),
(130, 7, 'Oturkpo'),
(131, 7, 'Tarka'),
(132, 7, 'Ukum'),
(133, 7, 'Ushongo'),
(134, 7, 'Vandeikya'),
(135, 8, 'Askira/Uba'),
(136, 8, 'Bama'),
(137, 8, 'Bayo'),
(138, 8, 'Biu'),
(139, 8, 'Chibok'),
(140, 8, 'Damboa'),
(141, 8, 'Dikwa'),
(142, 8, 'Gubio'),
(143, 8, 'Guzamala'),
(144, 8, 'Gwoza'),
(145, 8, 'Hawul'),
(146, 8, 'Jere'),
(147, 8, 'Kaga'),
(148, 8, 'Kala/Balge'),
(149, 8, 'Konduga'),
(150, 8, 'Kukawa'),
(151, 8, 'Kwaya Kusar'),
(152, 8, 'Mafa'),
(153, 8, 'Magumeri'),
(154, 8, 'Maiduguri'),
(155, 8, 'Marte'),
(156, 8, 'Mobbar'),
(157, 8, 'Monguno'),
(158, 8, 'Ngala'),
(159, 8, 'Nganzai'),
(160, 8, 'Shani'),
(161, 9, 'Akamkpa'),
(162, 9, 'Akpabuyo'),
(163, 9, 'Bakassi'),
(164, 9, 'Bekwarra'),
(165, 9, 'Biase'),
(166, 9, 'Boki'),
(167, 9, 'Calabar Municipal'),
(168, 9, 'Calabar South'),
(169, 9, 'Etung'),
(170, 9, 'Ikom'),
(171, 9, 'Obanliku'),
(172, 9, 'Obubra'),
(173, 9, 'Obudu'),
(174, 9, 'Odukpani'),
(175, 9, 'Ogoja'),
(176, 9, 'Yakuur'),
(177, 9, 'Yala'),
(178, 10, 'Aniocha South'),
(179, 10, 'Bomadi'),
(180, 10, 'Burutu'),
(181, 10, 'Ethiope East'),
(182, 10, 'Ethiope West'),
(183, 10, 'Ika North East'),
(184, 10, 'Ika South'),
(185, 10, 'Isoko North'),
(186, 10, 'Isoko South'),
(187, 10, 'Ndokwa East'),
(188, 10, 'Ndokwa West'),
(189, 10, 'Okpe'),
(190, 10, 'Oshimili North'),
(191, 10, 'Oshimili South'),
(192, 10, 'Patani'),
(193, 10, 'Sapele'),
(194, 10, 'Udu'),
(195, 10, 'Ughelli North'),
(196, 10, 'Ughelli South'),
(197, 10, 'Ukwuani'),
(198, 10, 'Uvwie'),
(199, 10, 'Warri North'),
(200, 10, 'Warri South'),
(201, 10, 'Warri South West'),
(202, 11, 'Afikpo North'),
(203, 11, 'Afikpo South'),
(204, 11, 'Ebonyi'),
(205, 11, 'Ezza North'),
(206, 11, 'Ezza South'),
(207, 11, 'Ikwo'),
(208, 11, 'Ishielu'),
(209, 11, 'Ivo'),
(210, 11, 'Izzi'),
(211, 11, 'Ohaozara'),
(212, 11, 'Ohaukwu'),
(213, 11, 'Onicha'),
(214, 12, 'Egor'),
(215, 12, 'Esan Central'),
(216, 12, 'Esan North-East'),
(217, 12, 'Esan South-East'),
(218, 12, 'Esan West'),
(219, 12, 'Etsako Central'),
(220, 12, 'Etsako East'),
(221, 12, 'Etsako West'),
(222, 12, 'Igueben'),
(223, 12, 'Ikpoba Okha'),
(224, 12, 'Orhionmwon'),
(225, 12, 'Oredo'),
(226, 12, 'Ovia North-East'),
(227, 12, 'Ovia South-West'),
(228, 12, 'Owan East'),
(229, 12, 'Owan West'),
(230, 12, 'Uhunmwonde'),
(231, 13, 'Efon'),
(232, 13, 'Ekiti East'),
(233, 13, 'Ekiti South-West'),
(234, 13, 'Ekiti West'),
(235, 13, 'Emure'),
(236, 13, 'Gbonyin'),
(237, 13, 'Ido Osi'),
(238, 13, 'Ijero'),
(239, 13, 'Ikere'),
(240, 13, 'Ikole'),
(241, 13, 'Ilejemeje'),
(242, 13, 'Irepodun/Ifelodun'),
(243, 13, 'Ise/Orun'),
(244, 13, 'Moba'),
(245, 13, 'Oye'),
(246, 14, 'Awgu'),
(247, 14, 'Enugu East'),
(248, 14, 'Enugu North'),
(249, 14, 'Enugu South'),
(250, 14, 'Ezeagu'),
(251, 14, 'Igbo Etiti'),
(252, 14, 'Igbo Eze North'),
(253, 14, 'Igbo Eze South'),
(254, 14, 'Isi Uzo'),
(255, 14, 'Nkanu East'),
(256, 14, 'Nkanu West'),
(257, 14, 'Nsukka'),
(258, 14, 'Oji River'),
(259, 14, 'Udenu'),
(260, 14, 'Udi'),
(261, 14, 'Uzo Uwani'),
(262, 15, 'Bwari'),
(263, 15, 'Gwagwalada'),
(264, 15, 'Kuje'),
(265, 15, 'Kwali'),
(266, 15, 'Municipal Area Council'),
(267, 16, 'Balanga'),
(268, 16, 'Billiri'),
(269, 16, 'Dukku'),
(270, 16, 'Funakaye'),
(271, 16, 'Gombe'),
(272, 16, 'Kaltungo'),
(273, 16, 'Kwami'),
(274, 16, 'Nafada'),
(275, 16, 'Shongom'),
(276, 16, 'Yamaltu/Deba'),
(277, 17, 'Ahiazu Mbaise'),
(278, 17, 'Ehime Mbano'),
(279, 17, 'Ezinihitte'),
(280, 17, 'Ideato North'),
(281, 17, 'Ideato South'),
(282, 17, 'Ihitte/Uboma'),
(283, 17, 'Ikeduru'),
(284, 17, 'Isiala Mbano'),
(285, 17, 'Isu'),
(286, 17, 'Mbaitoli'),
(287, 17, 'Ngor Okpala'),
(288, 17, 'Njaba'),
(289, 17, 'Nkwerre'),
(290, 17, 'Nwangele'),
(291, 17, 'Obowo'),
(292, 17, 'Oguta'),
(293, 17, 'Ohaji/Egbema'),
(294, 17, 'Okigwe'),
(295, 17, 'Orlu'),
(296, 17, 'Orsu'),
(297, 17, 'Oru East'),
(298, 17, 'Oru West'),
(299, 17, 'Owerri Municipal'),
(300, 17, 'Owerri North'),
(301, 17, 'Owerri West'),
(302, 17, 'Unuimo'),
(303, 18, 'Babura'),
(304, 18, 'Biriniwa'),
(305, 18, 'Birnin Kudu'),
(306, 18, 'Buji'),
(307, 18, 'Dutse'),
(308, 18, 'Gagarawa'),
(309, 18, 'Garki'),
(310, 18, 'Gumel'),
(311, 18, 'Guri'),
(312, 18, 'Gwaram'),
(313, 18, 'Gwiwa'),
(314, 18, 'Hadejia'),
(315, 18, 'Jahun'),
(316, 18, 'Kafin Hausa'),
(317, 18, 'Kazaure'),
(318, 18, 'Kiri Kasama'),
(319, 18, 'Kiyawa'),
(320, 18, 'Kaugama'),
(321, 18, 'Maigatari'),
(322, 18, 'Malam Madori'),
(323, 18, 'Miga'),
(324, 18, 'Ringim'),
(325, 18, 'Roni'),
(326, 18, 'Sule Tankarkar'),
(327, 18, 'Taura'),
(328, 18, 'Yankwashi'),
(329, 19, 'Chikun'),
(330, 19, 'Giwa'),
(331, 19, 'Igabi'),
(332, 19, 'Ikara'),
(333, 19, 'Jaba'),
(334, 19, 'Jema\'a'),
(335, 19, 'Kachia'),
(336, 19, 'Kaduna North'),
(337, 19, 'Kaduna South'),
(338, 19, 'Kagarko'),
(339, 19, 'Kajuru'),
(340, 19, 'Kaura'),
(341, 19, 'Kauru'),
(342, 19, 'Kubau'),
(343, 19, 'Kudan'),
(344, 19, 'Lere'),
(345, 19, 'Makarfi'),
(346, 19, 'Sabon Gari'),
(347, 19, 'Sanga'),
(348, 19, 'Soba'),
(349, 19, 'Zangon Kataf'),
(350, 19, 'Zaria'),
(351, 20, 'Albasu'),
(352, 20, 'Bagwai'),
(353, 20, 'Bebeji'),
(354, 20, 'Bichi'),
(355, 20, 'Bunkure'),
(356, 20, 'Dala'),
(357, 20, 'Dambatta'),
(358, 20, 'Dawakin Kudu'),
(359, 20, 'Dawakin Tofa'),
(360, 20, 'Doguwa'),
(361, 20, 'Fagge'),
(362, 20, 'Gabasawa'),
(363, 20, 'Garko'),
(364, 20, 'Garun Mallam'),
(365, 20, 'Gaya'),
(366, 20, 'Gezawa'),
(367, 20, 'Gwale'),
(368, 20, 'Gwarzo'),
(369, 20, 'Kabo'),
(370, 20, 'Kano Municipal'),
(371, 20, 'Karaye'),
(372, 20, 'Kibiya'),
(373, 20, 'Kiru'),
(374, 20, 'Kumbotso'),
(375, 20, 'Kunchi'),
(376, 20, 'Kura'),
(377, 20, 'Madobi'),
(378, 20, 'Makoda'),
(379, 20, 'Minjibir'),
(380, 20, 'Nasarawa'),
(381, 20, 'Rano'),
(382, 20, 'Rimin Gado'),
(383, 20, 'Rogo'),
(384, 20, 'Shanono'),
(385, 20, 'Sumaila'),
(386, 20, 'Takai'),
(387, 20, 'Tarauni'),
(388, 20, 'Tofa'),
(389, 20, 'Tsanyawa'),
(390, 20, 'Tudun Wada'),
(391, 20, 'Ungogo'),
(392, 20, 'Warawa'),
(393, 20, 'Wudil'),
(394, 21, 'Batagarawa'),
(395, 21, 'Batsari'),
(396, 21, 'Baure'),
(397, 21, 'Bindawa'),
(398, 21, 'Charanchi'),
(399, 21, 'Dandume'),
(400, 21, 'Danja'),
(401, 21, 'Dan Musa'),
(402, 21, 'Daura'),
(403, 21, 'Dutsi'),
(404, 21, 'Dutsin Ma'),
(405, 21, 'Faskari'),
(406, 21, 'Funtua'),
(407, 21, 'Ingawa'),
(408, 21, 'Jibia'),
(409, 21, 'Kafur'),
(410, 21, 'Kaita'),
(411, 21, 'Kankara'),
(412, 21, 'Kankia'),
(413, 21, 'Katsina'),
(414, 21, 'Kurfi'),
(415, 21, 'Kusada'),
(416, 21, 'Mai\'Adua'),
(417, 21, 'Malumfashi'),
(418, 21, 'Mani'),
(419, 21, 'Mashi'),
(420, 21, 'Matazu'),
(421, 21, 'Musawa'),
(422, 21, 'Rimi'),
(423, 21, 'Sabuwa'),
(424, 21, 'Safana'),
(425, 21, 'Sandamu'),
(426, 21, 'Zango'),
(427, 22, 'Arewa Dandi'),
(428, 22, 'Argungu'),
(429, 22, 'Augie'),
(430, 22, 'Bagudo'),
(431, 22, 'Birnin Kebbi'),
(432, 22, 'Bunza'),
(433, 22, 'Dandi'),
(434, 22, 'Fakai'),
(435, 22, 'Gwandu'),
(436, 22, 'Jega'),
(437, 22, 'Kalgo'),
(438, 22, 'Koko/Besse'),
(439, 22, 'Maiyama'),
(440, 22, 'Ngaski'),
(441, 22, 'Sakaba'),
(442, 22, 'Shanga'),
(443, 22, 'Suru'),
(444, 22, 'Wasagu/Danko'),
(445, 22, 'Yauri'),
(446, 22, 'Zuru'),
(447, 23, 'Ajaokuta'),
(448, 23, 'Ankpa'),
(449, 23, 'Bassa'),
(450, 23, 'Dekina'),
(451, 23, 'Ibaji'),
(452, 23, 'Idah'),
(453, 23, 'Igalamela Odolu'),
(454, 23, 'Ijumu'),
(455, 23, 'Kabba/Bunu'),
(456, 23, 'Kogi'),
(457, 23, 'Lokoja'),
(458, 23, 'Mopa Muro'),
(459, 23, 'Ofu'),
(460, 23, 'Ogori/Magongo'),
(461, 23, 'Okehi'),
(462, 23, 'Okene'),
(463, 23, 'Olamaboro'),
(464, 23, 'Omala'),
(465, 23, 'Yagba East'),
(466, 23, 'Yagba West'),
(467, 24, 'Baruten'),
(468, 24, 'Edu'),
(469, 24, 'Ekiti'),
(470, 24, 'Ifelodun'),
(471, 24, 'Ilorin East'),
(472, 24, 'Ilorin South'),
(473, 24, 'Ilorin West'),
(474, 24, 'Irepodun'),
(475, 24, 'Isin'),
(476, 24, 'Kaiama'),
(477, 24, 'Moro'),
(478, 24, 'Offa'),
(479, 24, 'Oke Ero'),
(480, 24, 'Oyun'),
(481, 24, 'Pategi'),
(482, 25, 'Ajeromi-Ifelodun'),
(483, 25, 'Alimosho'),
(484, 25, 'Amuwo-Odofin'),
(485, 25, 'Apapa'),
(486, 25, 'Badagry'),
(487, 25, 'Epe'),
(488, 25, 'Eti Osa'),
(489, 25, 'Ibeju-Lekki'),
(490, 25, 'Ifako-Ijaiye'),
(491, 25, 'Ikeja'),
(492, 25, 'Ikorodu'),
(493, 25, 'Kosofe'),
(494, 25, 'Lagos Island'),
(495, 25, 'Lagos Mainland'),
(496, 25, 'Mushin'),
(497, 25, 'Ojo'),
(498, 25, 'Oshodi-Isolo'),
(499, 25, 'Shomolu'),
(500, 25, 'Surulere'),
(501, 26, 'Awe'),
(502, 26, 'Doma'),
(503, 26, 'Karu'),
(504, 26, 'Keana'),
(505, 26, 'Keffi'),
(506, 26, 'Kokona'),
(507, 26, 'Lafia'),
(508, 26, 'Nasarawa'),
(509, 26, 'Nasarawa Egon'),
(510, 26, 'Obi'),
(511, 26, 'Toto'),
(512, 26, 'Wamba'),
(513, 27, 'Agwara'),
(514, 27, 'Bida'),
(515, 27, 'Borgu'),
(516, 27, 'Bosso'),
(517, 27, 'Chanchaga'),
(518, 27, 'Edati'),
(519, 27, 'Gbako'),
(520, 27, 'Gurara'),
(521, 27, 'Katcha'),
(522, 27, 'Kontagora'),
(523, 27, 'Lapai'),
(524, 27, 'Lavun'),
(525, 27, 'Magama'),
(526, 27, 'Mariga'),
(527, 27, 'Mashegu'),
(528, 27, 'Mokwa'),
(529, 27, 'Moya'),
(530, 27, 'Paikoro'),
(531, 27, 'Rafi'),
(532, 27, 'Rijau'),
(533, 27, 'Shiroro'),
(534, 27, 'Suleja'),
(535, 27, 'Tafa'),
(536, 27, 'Wushishi'),
(537, 28, 'Abeokuta South'),
(538, 28, 'Ado-Odo/Ota'),
(539, 28, 'Egbado North'),
(540, 28, 'Egbado South'),
(541, 28, 'Ewekoro'),
(542, 28, 'Ifo'),
(543, 28, 'Ijebu East'),
(544, 28, 'Ijebu North'),
(545, 28, 'Ijebu North East'),
(546, 28, 'Ijebu Ode'),
(547, 28, 'Ikenne'),
(548, 28, 'Imeko Afon'),
(549, 28, 'Ipokia'),
(550, 28, 'Obafemi Owode'),
(551, 28, 'Odeda'),
(552, 28, 'Odogbolu'),
(553, 28, 'Ogun Waterside'),
(554, 28, 'Remo North'),
(555, 28, 'Shagamu'),
(556, 29, 'Akoko North-West'),
(557, 29, 'Akoko South-West'),
(558, 29, 'Akoko South-East'),
(559, 29, 'Akure North'),
(560, 29, 'Akure South'),
(561, 29, 'Ese Odo'),
(562, 29, 'Idanre'),
(563, 29, 'Ifedore'),
(564, 29, 'Ilaje'),
(565, 29, 'Ile Oluji/Okeigbo'),
(566, 29, 'Irele'),
(567, 29, 'Odigbo'),
(568, 29, 'Okitipupa'),
(569, 29, 'Ondo East'),
(570, 29, 'Ondo West'),
(571, 29, 'Ose'),
(572, 29, 'Owo'),
(573, 30, 'Atakunmosa West'),
(574, 30, 'Aiyedaade'),
(575, 30, 'Aiyedire'),
(576, 30, 'Boluwaduro'),
(577, 30, 'Boripe'),
(578, 30, 'Ede North'),
(579, 30, 'Ede South'),
(580, 30, 'Ife Central'),
(581, 30, 'Ife East'),
(582, 30, 'Ife North'),
(583, 30, 'Ife South'),
(584, 30, 'Egbedore'),
(585, 30, 'Ejigbo'),
(586, 30, 'Ifedayo'),
(587, 30, 'Ifelodun'),
(588, 30, 'Ila'),
(589, 30, 'Ilesa East'),
(590, 30, 'Ilesa West'),
(591, 30, 'Irepodun'),
(592, 30, 'Irewole'),
(593, 30, 'Isokan'),
(594, 30, 'Iwo'),
(595, 30, 'Obokun'),
(596, 30, 'Odo Otin'),
(597, 30, 'Ola Oluwa'),
(598, 30, 'Olorunda'),
(599, 30, 'Oriade'),
(600, 30, 'Orolu'),
(601, 30, 'Osogbo'),
(602, 31, 'Akinyele'),
(603, 31, 'Atiba'),
(604, 31, 'Atisbo'),
(605, 31, 'Egbeda'),
(606, 31, 'Ibadan North'),
(607, 31, 'Ibadan North-East'),
(608, 31, 'Ibadan North-West'),
(609, 31, 'Ibadan South-East'),
(610, 31, 'Ibadan South-West'),
(611, 31, 'Ibarapa Central'),
(612, 31, 'Ibarapa East'),
(613, 31, 'Ibarapa North'),
(614, 31, 'Ido'),
(615, 31, 'Irepo'),
(616, 31, 'Iseyin'),
(617, 31, 'Itesiwaju'),
(618, 31, 'Iwajowa'),
(619, 31, 'Kajola'),
(620, 31, 'Lagelu'),
(621, 31, 'Ogbomosho North'),
(622, 31, 'Ogbomosho South'),
(623, 31, 'Ogo Oluwa'),
(624, 31, 'Olorunsogo'),
(625, 31, 'Oluyole'),
(626, 31, 'Ona Ara'),
(627, 31, 'Orelope'),
(628, 31, 'Ori Ire'),
(629, 31, 'Oyo'),
(630, 31, 'Oyo East'),
(631, 31, 'Saki East'),
(632, 31, 'Saki West'),
(633, 31, 'Surulere'),
(634, 32, 'Barkin Ladi'),
(635, 32, 'Bassa'),
(636, 32, 'Jos East'),
(637, 32, 'Jos North'),
(638, 32, 'Jos South'),
(639, 32, 'Kanam'),
(640, 32, 'Kanke'),
(641, 32, 'Langtang South'),
(642, 32, 'Langtang North'),
(643, 32, 'Mangu'),
(644, 32, 'Mikang'),
(645, 32, 'Pankshin'),
(646, 32, 'Qua\'an Pan'),
(647, 32, 'Riyom'),
(648, 32, 'Shendam'),
(649, 32, 'Wase'),
(650, 33, 'Ahoada East'),
(651, 33, 'Ahoada West'),
(652, 33, 'Akuku-Toru'),
(653, 33, 'Andoni'),
(654, 33, 'Asari-Toru'),
(655, 33, 'Bonny'),
(656, 33, 'Degema'),
(657, 33, 'Eleme'),
(658, 33, 'Emuoha'),
(659, 33, 'Etche'),
(660, 33, 'Gokana'),
(661, 33, 'Ikwerre'),
(662, 33, 'Khana'),
(663, 33, 'Obio/Akpor'),
(664, 33, 'Ogba/Egbema/Ndoni'),
(665, 33, 'Ogu/Bolo'),
(666, 33, 'Okrika'),
(667, 33, 'Omuma'),
(668, 33, 'Opobo/Nkoro'),
(669, 33, 'Oyigbo'),
(670, 33, 'Port Harcourt'),
(671, 33, 'Tai'),
(672, 34, 'Bodinga'),
(673, 34, 'Dange Shuni'),
(674, 34, 'Gada'),
(675, 34, 'Goronyo'),
(676, 34, 'Gudu'),
(677, 34, 'Gwadabawa'),
(678, 34, 'Illela'),
(679, 34, 'Isa'),
(680, 34, 'Kebbe'),
(681, 34, 'Kware'),
(682, 34, 'Rabah'),
(683, 34, 'Sabon Birni'),
(684, 34, 'Shagari'),
(685, 34, 'Silame'),
(686, 34, 'Sokoto North'),
(687, 34, 'Sokoto South'),
(688, 34, 'Tambuwal'),
(689, 34, 'Tangaza'),
(690, 34, 'Tureta'),
(691, 34, 'Wamako'),
(692, 34, 'Wurno'),
(693, 34, 'Yabo'),
(694, 35, 'Bali'),
(695, 35, 'Donga'),
(696, 35, 'Gashaka'),
(697, 35, 'Gassol'),
(698, 35, 'Ibi'),
(699, 35, 'Jalingo'),
(700, 35, 'Karim Lamido'),
(701, 35, 'Kumi'),
(702, 35, 'Lau'),
(703, 35, 'Sardauna'),
(704, 35, 'Takum'),
(705, 35, 'Ussa'),
(706, 35, 'Wukari'),
(707, 35, 'Yorro'),
(708, 35, 'Zing'),
(709, 36, 'Bursari'),
(710, 36, 'Damaturu'),
(711, 36, 'Fika'),
(712, 36, 'Fune'),
(713, 36, 'Geidam'),
(714, 36, 'Gujba'),
(715, 36, 'Gulani'),
(716, 36, 'Jakusko'),
(717, 36, 'Karasuwa'),
(718, 36, 'Machina'),
(719, 36, 'Nangere'),
(720, 36, 'Nguru'),
(721, 36, 'Potiskum'),
(722, 36, 'Tarmuwa'),
(723, 36, 'Yunusari'),
(724, 36, 'Yusufari'),
(725, 37, 'Bakura'),
(726, 37, 'Birnin Magaji/Kiyaw'),
(727, 37, 'Bukkuyum'),
(728, 37, 'Bungudu'),
(729, 37, 'Gummi'),
(730, 37, 'Gusau'),
(731, 37, 'Kaura Namoda'),
(732, 37, 'Maradun'),
(733, 37, 'Maru'),
(734, 37, 'Shinkafi'),
(735, 37, 'Talata Mafara'),
(736, 37, 'Chafe'),
(737, 37, 'Zurmi');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_08_31_233644_create_categories', 1),
(6, '2023_08_31_233658_create_artisan_sub_category', 1),
(7, '2023_08_31_233708_create_winning_tags', 1),
(8, '2023_09_01_122317_add_cat_to_category_table', 2),
(9, '2023_09_01_122611_add_image_to_winning_tag_table', 3),
(12, '2023_09_24_001542_create_stake_numbers_table', 6),
(14, '2023_10_05_113837_create_stakes_table', 7),
(19, '2023_10_05_123944_add_customer_id_to_users_table', 8),
(20, '2023_09_13_195546_create_customers_table', 9),
(21, '2023_10_05_133709_add_winning_tag_id_and_category_id_to_customer_stakes_table', 10),
(22, '2023_10_05_134503_add_customer_id_to_customer_stakes_table', 11),
(24, '2023_10_11_133240_create_stake_platform_table', 12),
(25, '2023_09_08_183751_create_win_numbers_table', 13),
(27, '2023_10_12_125121_create_bank_account_table', 14),
(29, '2023_10_12_132707_add_wallet_table', 15),
(31, '2023_10_12_135939_create_customer_transaction_history_table', 16),
(32, '2023_10_12_142319_add_transaction_type_table', 17),
(33, '2023_10_15_073223_add_payment_method_to_users_table', 18),
(34, '2023_10_15_081016_add_payment_method_to_users_table', 19),
(35, '2023_10_15_081211_add_payment_method_to_customers_stakes_table', 20),
(36, '2023_10_15_092956_create_flutterwave_details_table', 21),
(37, '2023_10_15_102502_add_active_to_customers_stakes_table', 21),
(38, '2023_10_15_103047_add_stake_platform_id_to_customers_stakes_table', 22),
(39, '2023_10_16_095335_add_email_to_users_table', 23),
(40, '2023_10_16_095601_add_password_reset_to_users_table', 24),
(41, '2023_10_20_151749_add_win_nums_to_stake_platforms_table', 25),
(44, '2023_10_24_202059_add_start_day_to_stake_platforms_table', 27),
(46, '2023_10_26_080110_add_verify_code_to_users_table', 28),
(47, '2023_10_27_020547_add_customer_id_to_customer_transaction_history_table', 28),
(48, '2023_10_29_094920_add_transaction_ref_to_customer_transaction_history_table', 29),
(50, '2023_10_24_181740_add_count_winners_to_stake_platforms_table', 30),
(51, '2023_10_31_111921_add_winners_count_customers_stakes_table', 30),
(52, '2023_10_31_112513_add_max_winners_count_to_stake_platforms_table', 31),
(53, '2023_10_31_125855_add_end_date_to_stake_platforms_table', 32),
(54, '2023_10_31_145010_add_platform_id_to_stake_platforms_table', 33),
(55, '2023_11_09_143632_create_table_notifications', 34),
(56, '2023_11_09_154426_device_id_to_users_table', 35),
(57, '2023_11_13_094047_add_role_to_users_table', 36),
(58, '2023_11_13_110440_create_agents_table', 37),
(59, '2023_11_22_044030_create_banks_table', 38),
(61, '2023_11_22_051121_add_bank_code_to_bank_accounts_table', 40),
(62, '2023_11_22_053149_create_transfers_table', 41),
(63, '2023_11_22_093540_add_status_to_customer_transaction_history_table', 42),
(65, '2023_11_22_094128_create_withdrawals_table', 43),
(66, '2023_11_22_050952_add_bank_code_to_bank_accounts_table', 44),
(67, '2023_12_08_102900_add_pin_to_users_table', 44),
(69, '2023_12_08_214741_create_agent_payment_table', 45),
(72, '2023_12_09_232451_create_agent_payment_transactions_table', 46),
(73, '2023_12_09_232505_create_agent_raffle_booking_transactions_table', 46),
(74, '2023_12_09_232514_create_customer_raffle_booking_transactions_table', 46),
(75, '2023_12_09_232523_create_customer_payment_transactions_table', 46),
(76, '2023_12_10_020034_add_some_colums_to_agent_funding_transactions_table', 47),
(77, '2023_12_10_020353_add_some_colums_to_agent_funding_transactions_table', 48),
(78, '2023_12_10_033209_add_customer_id_to_bank_account_table', 49),
(79, '2023_12_10_034235_remove_column_from_bank_account', 50),
(81, '2023_12_10_112300_add_some_colums_to_withdrawals_table', 51),
(82, '2023_12_15_094438_add_role_to_users_table', 52),
(83, '2023_12_15_144924_create_keys_table', 52);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `viewed` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `body`, `viewed`, `created_at`, `updated_at`) VALUES
(1, 'New Notification', 'Raffle has been Drawn', 'No', '2023-11-09 13:57:34', '2023-11-09 13:57:34'),
(2, 'New Notification', 'Raffle has been Drawn', 'No', '2023-11-10 07:42:08', '2023-11-10 07:42:08');

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'MyAuthApp', 'c515b9d53497491063e37558fcf6f086a0c735434d7110942c8b3852d97fdef2', '[\"*\"]', '2023-10-05 10:29:51', NULL, '2023-09-01 10:39:39', '2023-10-05 10:29:51'),
(2, 'App\\Models\\User', 1, 'MyAuthApp', '3ae729e375ba9ee2a9eb906c13f39012ab80ccdea44b52b04d5f9c0a7bd9cd48', '[\"*\"]', NULL, NULL, '2023-09-12 20:10:57', '2023-09-12 20:10:57'),
(3, 'App\\Models\\User', 1, 'MyAuthApp', '4b3300498baf04d57e5c518dd6cf30ae5a5cf762fb7d6820e538c782b84722bc', '[\"*\"]', '2023-10-05 13:03:56', NULL, '2023-09-12 20:40:22', '2023-10-05 13:03:56'),
(4, 'App\\Models\\User', 1, 'MyAuthApp', 'd0efdc27bdf6d3491a3907ad366799fb3e1af5759dfac4ffa9cfe64cd40a1b35', '[\"*\"]', NULL, NULL, '2023-09-12 20:41:51', '2023-09-12 20:41:51'),
(5, 'App\\Models\\User', 1, 'MyAuthApp', '6e911ecfb8ff5ab37071f70739491fd52864613651f7f745aaf37d3e13594cd4', '[\"*\"]', NULL, NULL, '2023-09-12 20:41:52', '2023-09-12 20:41:52'),
(6, 'App\\Models\\User', 1, 'MyAuthApp', '90c1f5cb1d454fcde1158246b9cabdac852536efae2ef1c517a61daeded623d7', '[\"*\"]', '2023-10-18 22:17:18', NULL, '2023-10-05 10:32:17', '2023-10-18 22:17:18'),
(7, 'App\\Models\\User', 1, 'MyAuthApp', '0a9977097d62097e48838edcb173910ef51d0d2f449d59fcc2bb9b331f3a6dab', '[\"*\"]', NULL, NULL, '2023-10-05 10:49:39', '2023-10-05 10:49:39'),
(8, 'App\\Models\\User', 1, 'MyAuthApp', '82cb21977846014969b5fc015b8744f4b4b4a50ea059ae4f541a962707bbbff4', '[\"*\"]', '2023-10-31 10:55:00', NULL, '2023-10-05 10:55:16', '2023-10-31 10:55:00'),
(9, 'App\\Models\\User', 1, 'MyAuthApp', 'e659325845f499f7902e9b01160a1eb6f324d53e98616ee357046c1abcd416f4', '[\"*\"]', '2023-10-11 13:47:19', NULL, '2023-10-11 12:49:38', '2023-10-11 13:47:19'),
(10, 'App\\Models\\User', 1, 'MyAuthApp', '56c8cb338c556ff20fec29bd0db4953d0b142a177af6bb2bb8817e5591b03a77', '[\"*\"]', '2023-10-12 13:37:39', NULL, '2023-10-12 11:29:37', '2023-10-12 13:37:39'),
(11, 'App\\Models\\User', 1, 'MyAuthApp', '74f65ae53df9f21991474953008f6152613e1bbeeeff452a8fe0e24e3af12592', '[\"*\"]', '2023-10-19 07:43:09', NULL, '2023-10-19 07:37:41', '2023-10-19 07:43:09'),
(12, 'App\\Models\\User', 1, 'MyAuthApp', '5e2508589b658acd3f9486d3351379ebc6f86cc7cef476672b7bb331d0f910c1', '[\"*\"]', NULL, NULL, '2023-10-19 12:05:21', '2023-10-19 12:05:21'),
(13, 'App\\Models\\User', 1, 'MyAuthApp', '2c57a21dec2c2dbbe6416675882f1afc2f095290b952f15bd030bbbee6148e62', '[\"*\"]', NULL, NULL, '2023-10-24 10:47:38', '2023-10-24 10:47:38'),
(14, 'App\\Models\\User', 1, 'MyAuthApp', '321cff77530bd11e75c097196c6a46557bd46e5b5f9f5b205b8e1694897d79ae', '[\"*\"]', NULL, NULL, '2023-10-24 11:10:17', '2023-10-24 11:10:17'),
(15, 'App\\Models\\User', 1, 'MyAuthApp', 'f1a1d2e3a6111ef8cc9b287cc1873abd05daa9da7d9522f88c4fe98e0375f2dd', '[\"*\"]', NULL, NULL, '2023-10-24 11:11:23', '2023-10-24 11:11:23'),
(16, 'App\\Models\\User', 1, 'MyAuthApp', '5ba2ecda370dd4ade9b52fbda099f4deff9a3792dd2bfe535f7d944765231bca', '[\"*\"]', NULL, NULL, '2023-10-24 11:17:59', '2023-10-24 11:17:59'),
(17, 'App\\Models\\User', 1, 'MyAuthApp', 'a4303ea140b7c1442ba1b002372569658018af8d57e331c32dc9bb8bfb901d4b', '[\"*\"]', NULL, NULL, '2023-10-24 11:21:39', '2023-10-24 11:21:39'),
(18, 'App\\Models\\User', 1, 'MyAuthApp', '803df79acea01557821c11942c5c00e0e757358267e259e81c08374b3a9f9810', '[\"*\"]', NULL, NULL, '2023-10-24 11:27:42', '2023-10-24 11:27:42'),
(19, 'App\\Models\\User', 1, 'MyAuthApp', 'c96007e5a741621d741e874bc8f6aac9b5674917cc38fd37cf6b099743300ea8', '[\"*\"]', NULL, NULL, '2023-10-24 11:28:01', '2023-10-24 11:28:01'),
(20, 'App\\Models\\User', 1, 'MyAuthApp', 'a4849fc767592f2da7a8a02106cecb0e250ca8f8ca485edd01220ec5717b594a', '[\"*\"]', NULL, NULL, '2023-10-24 11:28:05', '2023-10-24 11:28:05'),
(21, 'App\\Models\\User', 1, 'MyAuthApp', '464d50f580e46687de711edd34f210da5dab69f6d3f0a370cd44c52296bd4cbc', '[\"*\"]', NULL, NULL, '2023-10-24 11:29:05', '2023-10-24 11:29:05'),
(22, 'App\\Models\\User', 1, 'MyAuthApp', 'b8b85a894949aa8f9583d56244c64265d77af451b41f3039ce41ae64ed853b15', '[\"*\"]', NULL, NULL, '2023-10-24 11:44:46', '2023-10-24 11:44:46'),
(23, 'App\\Models\\User', 1, 'MyAuthApp', '50e9371e61b994be9398217c2500a5c6564c54e90bca711931696c08a6200a02', '[\"*\"]', NULL, NULL, '2023-10-24 12:00:59', '2023-10-24 12:00:59'),
(24, 'App\\Models\\User', 1, 'MyAuthApp', '12c3a6cb1d4fa8970f236f35fba97bbf1fdeefd113d3b63d1fb43ef4867d1ae3', '[\"*\"]', NULL, NULL, '2023-10-24 12:02:51', '2023-10-24 12:02:51'),
(25, 'App\\Models\\User', 1, 'MyAuthApp', '761ecc4781346dfaa77b75f4de2bd8f169ffbe2a2856e850746755776702b457', '[\"*\"]', NULL, NULL, '2023-10-24 14:36:14', '2023-10-24 14:36:14'),
(26, 'App\\Models\\User', 1, 'MyAuthApp', '4ccee5519573062d827167b3efa99e510286df05dcd1e13c7e1497fad70e390f', '[\"*\"]', NULL, NULL, '2023-10-24 14:37:12', '2023-10-24 14:37:12'),
(27, 'App\\Models\\User', 1, 'MyAuthApp', '25938477c1666036589cb40d4f3a4308ff845033f6e3eafbd67700f4342f40c1', '[\"*\"]', NULL, NULL, '2023-10-24 14:37:29', '2023-10-24 14:37:29'),
(28, 'App\\Models\\User', 1, 'MyAuthApp', '9fe4233b3a9819ae390156ef2e3b113076ff59180b04fb6f47b85915484e7072', '[\"*\"]', NULL, NULL, '2023-10-24 14:45:05', '2023-10-24 14:45:05'),
(29, 'App\\Models\\User', 1, 'MyAuthApp', 'fa53931a21cb3fdf8fe26f3f367a5591b0d2fc677f09a73d1f58a11f0e18052b', '[\"*\"]', NULL, NULL, '2023-10-24 14:50:59', '2023-10-24 14:50:59'),
(30, 'App\\Models\\User', 1, 'MyAuthApp', 'cfe3ccd607845adfd4af29d28de7462ee4429834abc7ff92de1d7d803c6ec325', '[\"*\"]', NULL, NULL, '2023-10-24 17:01:44', '2023-10-24 17:01:44'),
(31, 'App\\Models\\User', 1, 'MyAuthApp', '703cf5fd67b6194c590ac6a573a1e2060b7a87e0f4bf9473dfc2456e716fba64', '[\"*\"]', NULL, NULL, '2023-10-24 17:11:24', '2023-10-24 17:11:24'),
(32, 'App\\Models\\User', 1, 'MyAuthApp', 'b6b29501d191655f338a6b945cf21d398633ba1db08857677374614303a2fb8d', '[\"*\"]', NULL, NULL, '2023-10-25 19:26:57', '2023-10-25 19:26:57'),
(33, 'App\\Models\\User', 1, 'MyAuthApp', '1257c02e250d36d218cbf7dbbed9e8f54ab24f3984e7d329848e737f6ac1237a', '[\"*\"]', NULL, NULL, '2023-10-28 03:30:05', '2023-10-28 03:30:05'),
(34, 'App\\Models\\User', 1, 'MyAuthApp', 'ff30568178a6f2bcdd0bdab9f96a932e4da5ed3c0b972ea3270ffe4dd6b39978', '[\"*\"]', NULL, NULL, '2023-10-29 08:39:46', '2023-10-29 08:39:46'),
(35, 'App\\Models\\User', 1, 'MyAuthApp', '12a60743093605ba35b02a750f6aef6dd05845ae8b1a32cabffa05ecc01b226c', '[\"*\"]', NULL, NULL, '2023-11-01 11:38:47', '2023-11-01 11:38:47'),
(36, 'App\\Models\\User', 1, 'MyAuthApp', '04f46727bdc19453d85beb21a2eb361a5e183399d9894f450af20864d9e1c2d0', '[\"*\"]', NULL, NULL, '2023-11-01 12:08:14', '2023-11-01 12:08:14'),
(37, 'App\\Models\\User', 1, 'MyAuthApp', '0567a82cc7a9ac3e948b5e7181bccb25e637d0dfd0000b1d33c1254596d8be42', '[\"*\"]', NULL, NULL, '2023-11-01 12:49:47', '2023-11-01 12:49:47'),
(38, 'App\\Models\\User', 1, 'MyAuthApp', '489876629b8f783546091c68216b07878d39a009c9015cb79bcadc56afa75ac4', '[\"*\"]', NULL, NULL, '2023-11-01 19:29:10', '2023-11-01 19:29:10'),
(39, 'App\\Models\\User', 1, 'MyAuthApp', '2d7358b9b0caa50dc9f9d0352a55ec8a4512b299d9f79a173f623e35f0ec632d', '[\"*\"]', NULL, NULL, '2023-11-02 06:21:55', '2023-11-02 06:21:55'),
(40, 'App\\Models\\User', 1, 'MyAuthApp', 'ee638bda9229e7f8cd8af0d40f30657777ca99bfe4a281daaec5ee93ae6af9e0', '[\"*\"]', NULL, NULL, '2023-11-03 08:14:40', '2023-11-03 08:14:40'),
(41, 'App\\Models\\User', 1, 'MyAuthApp', '4d39c28a48cafe1fbaddab30e9980b5396d23a66f0805f69704ac9dced38880b', '[\"*\"]', NULL, NULL, '2023-11-03 11:12:34', '2023-11-03 11:12:34'),
(42, 'App\\Models\\User', 41, 'MyAuthApp', '1a12f729eb347052dd126b14e2a9f21520aeb4c8c61ba7ada7505a20dae04689', '[\"*\"]', NULL, NULL, '2023-11-13 12:08:26', '2023-11-13 12:08:26'),
(43, 'App\\Models\\User', 41, 'MyAuthApp', '7e406a9629e354774d4cf4e6522290b4572073b4b948effc9e7ad7d9d945dedf', '[\"*\"]', NULL, NULL, '2023-11-13 12:13:24', '2023-11-13 12:13:24'),
(44, 'App\\Models\\User', 41, 'MyAuthApp', 'ad01370ad9d862f54ccbc55acee5ae5735a658518cc3a5d62d113ac2cc5706d8', '[\"*\"]', NULL, NULL, '2023-11-13 12:13:38', '2023-11-13 12:13:38'),
(45, 'App\\Models\\User', 41, 'MyAuthApp', '9cd3a3fc7af3caabd2cca9e76c5b136e206f7559b37d164138d6bab8f24fd68a', '[\"*\"]', NULL, NULL, '2023-11-13 12:20:50', '2023-11-13 12:20:50'),
(46, 'App\\Models\\User', 41, 'MyAuthApp', 'c2cddde9b23b992a9a0a2c75354151ecd69a19f90e81529d3cec7507384c179b', '[\"*\"]', NULL, NULL, '2023-11-13 12:21:36', '2023-11-13 12:21:36'),
(47, 'App\\Models\\User', 41, 'MyAuthApp', '42c6c8696afc13a59e0bc0841b8d0d021153a7d2ac51b75e1258ff9796c6d8e4', '[\"*\"]', NULL, NULL, '2023-11-13 13:00:39', '2023-11-13 13:00:39'),
(48, 'App\\Models\\User', 41, 'MyAuthApp', '723cfdbe0a1df3423a4e432b5727050c649b709d5f32320b7742243fb288b9c9', '[\"*\"]', NULL, NULL, '2023-11-13 13:01:26', '2023-11-13 13:01:26'),
(49, 'App\\Models\\User', 41, 'MyAuthApp', '565eddf5f87f4a5dd08bebab677b550451f6991734f118a6374744c0fc18ebd1', '[\"*\"]', NULL, NULL, '2023-11-13 13:03:28', '2023-11-13 13:03:28'),
(50, 'App\\Models\\User', 41, 'MyAuthApp', '7b2c1aade9154606335469450b5779b390d8ed9645602cda43947ac34fe9cf22', '[\"*\"]', NULL, NULL, '2023-11-13 13:04:46', '2023-11-13 13:04:46'),
(51, 'App\\Models\\User', 41, 'MyAuthApp', '74906522a69d1244db4e3bf3081e111e252368ed19075d6423324391c20efbf9', '[\"*\"]', NULL, NULL, '2023-11-13 13:05:22', '2023-11-13 13:05:22'),
(52, 'App\\Models\\User', 41, 'MyAuthApp', '6e833edaf51eb35efd6722b2eee134f93b687f3791d75e2db3e8310edc38036f', '[\"*\"]', NULL, NULL, '2023-11-13 13:07:09', '2023-11-13 13:07:09'),
(53, 'App\\Models\\User', 1, 'MyAuthApp', 'debd730abb5a308ff6c2d90fd906166f2ad08dafa21e002fa0a35041a6fac4c5', '[\"*\"]', NULL, NULL, '2023-11-21 04:10:27', '2023-11-21 04:10:27'),
(54, 'App\\Models\\User', 1, 'MyAuthApp', 'c49a4e89f7fb84571a458a78b8051e6c25271a63a4b4f0863eb6dee3f1edc4dc', '[\"*\"]', NULL, NULL, '2023-11-21 21:25:32', '2023-11-21 21:25:32'),
(55, 'App\\Models\\User', 1, 'MyAuthApp', '576be8adf45d1542891f8bf935ef9ba4a0e92424504d58b0873ead225e1599e6', '[\"*\"]', NULL, NULL, '2023-11-23 12:07:16', '2023-11-23 12:07:16'),
(56, 'App\\Models\\User', 1, 'MyAuthApp', '90a6917c4ba0790cf1c5368a18011f35924d6b7314957d8b4509822d5a5487c8', '[\"*\"]', NULL, NULL, '2023-11-23 12:33:18', '2023-11-23 12:33:18'),
(57, 'App\\Models\\User', 1, 'MyAuthApp', '6fc87d6577a38ddfd1b1ef5dfd978c80084454b6a4c10779b996887daa9612d6', '[\"*\"]', NULL, NULL, '2023-11-25 06:40:03', '2023-11-25 06:40:03'),
(58, 'App\\Models\\User', 56, 'MyAuthApp', '02679702e516e2626a0a75b87e77488f1bbe74341b65461970085245d71fe6be', '[\"*\"]', NULL, NULL, '2023-12-07 20:33:37', '2023-12-07 20:33:37'),
(59, 'App\\Models\\User', 56, 'MyAuthApp', '6967878752a390c51f83096f6e7cffa23ba35f7e45a1020ba952adbab1fb69e3', '[\"*\"]', NULL, NULL, '2023-12-07 20:33:49', '2023-12-07 20:33:49'),
(60, 'App\\Models\\User', 56, 'MyAuthApp', 'eabf6358c0e24ae6d86b6b96b102f7d672edc73f66d668231044a39bbc5855fc', '[\"*\"]', NULL, NULL, '2023-12-07 20:36:03', '2023-12-07 20:36:03'),
(61, 'App\\Models\\User', 56, 'MyAuthApp', 'ab42c392f06b07dcbe3eb780abc5956084ec56858407ecf3abd4b8b9b195902e', '[\"*\"]', NULL, NULL, '2023-12-07 20:37:26', '2023-12-07 20:37:26'),
(62, 'App\\Models\\User', 56, 'MyAuthApp', '144cf37999a3db9f79fbb7a52b2404d45507294f219addd93a4bf6ebb34f5815', '[\"*\"]', NULL, NULL, '2023-12-07 20:37:51', '2023-12-07 20:37:51'),
(63, 'App\\Models\\User', 56, 'MyAuthApp', 'd8fe70237232a2bb26846b3191d4f525a7ed5004ad65d3054d10cdf9364f9f50', '[\"*\"]', NULL, NULL, '2023-12-07 20:39:18', '2023-12-07 20:39:18'),
(64, 'App\\Models\\User', 56, 'MyAuthApp', '125ae891d3ce894227e45235842be967fec2b210de6038b29eb2e91854c0a125', '[\"*\"]', NULL, NULL, '2023-12-07 20:40:09', '2023-12-07 20:40:09'),
(65, 'App\\Models\\User', 56, 'MyAuthApp', '166c4c804beb5ebaf63d572e0c13cf2d5abee5002b70a1c15fd68c1970e748be', '[\"*\"]', NULL, NULL, '2023-12-08 09:58:23', '2023-12-08 09:58:23'),
(66, 'App\\Models\\User', 56, 'MyAuthApp', '58426bb8a6d5d02bdabc256680b481d79af8ee28de67149fe2de77bfde459a5a', '[\"*\"]', NULL, NULL, '2023-12-08 13:06:38', '2023-12-08 13:06:38'),
(67, 'App\\Models\\User', 56, 'MyAuthApp', 'fc596431a7d2511c20e412a87b5887762bc5894de2234101c779cf1f94aadef0', '[\"*\"]', NULL, NULL, '2023-12-08 13:06:46', '2023-12-08 13:06:46'),
(68, 'App\\Models\\User', 56, 'MyAuthApp', '14115cad22320d3de40b95105fb8c4bde366a5c4c226abafa82b39244591e410', '[\"*\"]', NULL, NULL, '2023-12-08 13:09:12', '2023-12-08 13:09:12'),
(69, 'App\\Models\\User', 56, 'MyAuthApp', '68827d0546f415374d605f485c56a13c7c36cb796f0f8fb8f9fc16768e917cf8', '[\"*\"]', NULL, NULL, '2023-12-08 13:10:10', '2023-12-08 13:10:10'),
(70, 'App\\Models\\User', 56, 'MyAuthApp', '111cc67cec204cfc45b6a52dd513b9b8a2d7c584559d34c56a802e64793e8c56', '[\"*\"]', NULL, NULL, '2023-12-08 13:10:14', '2023-12-08 13:10:14'),
(71, 'App\\Models\\User', 56, 'MyAuthApp', '89afb67dba3c95f500fa2690bab32c37b2b2e9422f2609c93406e6ef9d7e4a5a', '[\"*\"]', NULL, NULL, '2023-12-08 13:11:07', '2023-12-08 13:11:07'),
(72, 'App\\Models\\User', 56, 'MyAuthApp', 'a3ab005f6cf215e17b3f9dc5b71d2a39f8b54b1c22068be79d7fbc1d9a11e23e', '[\"*\"]', NULL, NULL, '2023-12-08 13:11:40', '2023-12-08 13:11:40'),
(73, 'App\\Models\\User', 56, 'MyAuthApp', '2312bbde9e7a38bb22ff002c3cda9c924b052651a87447916043a6623500fe5f', '[\"*\"]', NULL, NULL, '2023-12-08 13:12:12', '2023-12-08 13:12:12'),
(74, 'App\\Models\\User', 56, 'MyAuthApp', '0afde7cb0b3238ebce50521f1cfe94f3f29b14d3239167f7e5096f724b9d6a67', '[\"*\"]', NULL, NULL, '2023-12-08 13:12:38', '2023-12-08 13:12:38'),
(75, 'App\\Models\\User', 56, 'MyAuthApp', 'e663ac596d970e03358bdb7a4ae958d3e1c2408ca3efd7e41075372cba394694', '[\"*\"]', NULL, NULL, '2023-12-08 13:13:31', '2023-12-08 13:13:31'),
(76, 'App\\Models\\User', 56, 'MyAuthApp', '3fc9e748f5029274a008465572f2dab337a3c21e0f2390c557a13c56ea523390', '[\"*\"]', NULL, NULL, '2023-12-08 13:14:15', '2023-12-08 13:14:15'),
(77, 'App\\Models\\User', 56, 'MyAuthApp', '797513d2296475681fc7c2bbbe67b165195c98436e34c66412f38e3d2bdfbbe4', '[\"*\"]', NULL, NULL, '2023-12-08 13:14:18', '2023-12-08 13:14:18'),
(78, 'App\\Models\\User', 56, 'MyAuthApp', 'b8584c0e681e6f1dea5e69e65f5e146b017ff3c547eec7a8cadb20ddff03c09a', '[\"*\"]', NULL, NULL, '2023-12-08 13:14:19', '2023-12-08 13:14:19'),
(79, 'App\\Models\\User', 56, 'MyAuthApp', 'c209f7188be8722b160e42ca86ac6db7d89d8cba2788c6752ee4aff528110e4e', '[\"*\"]', NULL, NULL, '2023-12-08 13:14:44', '2023-12-08 13:14:44'),
(80, 'App\\Models\\User', 56, 'MyAuthApp', 'c67707bb549f6d5ec38c3a639d6d9f491484d5fcf112079ff5f298703d1cd5c6', '[\"*\"]', NULL, NULL, '2023-12-08 13:15:25', '2023-12-08 13:15:25'),
(81, 'App\\Models\\User', 56, 'MyAuthApp', '96ee79fc9feeb1be1c70da421a2ffb80740f88f829d0cbe9858b40ae9284c292', '[\"*\"]', NULL, NULL, '2023-12-08 13:19:26', '2023-12-08 13:19:26'),
(82, 'App\\Models\\User', 56, 'MyAuthApp', '7cdaabc285d3bd2f18e450a0157c061227780ebef35f3ae7d4bcadffa5645fc1', '[\"*\"]', NULL, NULL, '2023-12-08 13:22:23', '2023-12-08 13:22:23'),
(83, 'App\\Models\\User', 56, 'MyAuthApp', 'd3faa27b76de04624dd43f1924b7fd130c1fdb78d2d75d34b0a23c3305bc7345', '[\"*\"]', NULL, NULL, '2023-12-08 13:24:19', '2023-12-08 13:24:19'),
(84, 'App\\Models\\User', 56, 'MyAuthApp', 'bc19ab84af18ae497e66a30bc9d34fc4407f2fb040750a428f9a991e3910d56f', '[\"*\"]', NULL, NULL, '2023-12-08 13:24:39', '2023-12-08 13:24:39'),
(85, 'App\\Models\\User', 56, 'MyAuthApp', 'fc138a7e123d0d6fc242b4119be5f96c53d655ae75b5c8a8821cad417fedacbe', '[\"*\"]', NULL, NULL, '2023-12-08 13:25:40', '2023-12-08 13:25:40'),
(86, 'App\\Models\\User', 56, 'MyAuthApp', '6a518c5c24473566a872276f4a456b6ecb50e6aa074e5469833acefb5760e085', '[\"*\"]', NULL, NULL, '2023-12-08 13:29:07', '2023-12-08 13:29:07'),
(87, 'App\\Models\\User', 56, 'MyAuthApp', 'f2a8cc29f868c567c398bc2a386f720b87f8485d1e0b630850b5921ed9c4fee2', '[\"*\"]', NULL, NULL, '2023-12-08 13:29:29', '2023-12-08 13:29:29'),
(88, 'App\\Models\\User', 56, 'MyAuthApp', '3060a48f109c04959c9e37cff4b19d615406250f9419b0dcf056d67952e2d513', '[\"*\"]', NULL, NULL, '2023-12-08 13:30:24', '2023-12-08 13:30:24'),
(89, 'App\\Models\\User', 56, 'MyAuthApp', 'f522c5bb01224bacd7f08e8238bf665d22a12771349ccba014fa6dde46ebf4f3', '[\"*\"]', NULL, NULL, '2023-12-08 13:30:26', '2023-12-08 13:30:26'),
(90, 'App\\Models\\User', 56, 'MyAuthApp', 'ee700dfffde45fa79ec3f31951e5321385213e7a5b1d6e915b71fd60fe42984f', '[\"*\"]', NULL, NULL, '2023-12-08 13:30:30', '2023-12-08 13:30:30'),
(91, 'App\\Models\\User', 56, 'MyAuthApp', 'e239cf4a815118718b9d5f82e069050d2652c744c54be7039d2cff8f744f669a', '[\"*\"]', NULL, NULL, '2023-12-08 13:30:41', '2023-12-08 13:30:41'),
(92, 'App\\Models\\User', 56, 'MyAuthApp', '06ad27c957e66fdb5917a76d219377e9a64dd1c37ee8e751c3d2365137c3b6f7', '[\"*\"]', NULL, NULL, '2023-12-08 13:31:01', '2023-12-08 13:31:01'),
(93, 'App\\Models\\User', 56, 'MyAuthApp', 'deac119088df04bd9bcabc495d7570b8e0bf1651f1f5da9de3d2ba1f99af4a10', '[\"*\"]', NULL, NULL, '2023-12-08 13:33:03', '2023-12-08 13:33:03'),
(94, 'App\\Models\\User', 56, 'MyAuthApp', 'd8ef3b7662632b492c7c44eaa497a53ee8b0871d8455001b3ce80e3c7b8f5e46', '[\"*\"]', NULL, NULL, '2023-12-08 13:36:43', '2023-12-08 13:36:43'),
(95, 'App\\Models\\User', 56, 'MyAuthApp', '683b4b40ec90504f8a146fa3ed7573b4f4894f7c8b145eaa893ddd8c0b558663', '[\"*\"]', NULL, NULL, '2023-12-08 13:41:28', '2023-12-08 13:41:28'),
(96, 'App\\Models\\User', 56, 'MyAuthApp', '0a955f2880d0625a2376867cc880043aef5df9698b610e5fd024fcb7c9ae2126', '[\"*\"]', NULL, NULL, '2023-12-08 13:41:33', '2023-12-08 13:41:33'),
(97, 'App\\Models\\User', 56, 'MyAuthApp', '5c0562c8063b330e9d9c5a108f196c89589fafabf56b1f75f5f8ee667136f8e9', '[\"*\"]', NULL, NULL, '2023-12-08 13:41:49', '2023-12-08 13:41:49'),
(98, 'App\\Models\\User', 56, 'MyAuthApp', '9f606a1c635ee4ce95778436ef7f2a6108c679b9a1ffc8e38fe27ec531723bff', '[\"*\"]', NULL, NULL, '2023-12-08 13:41:57', '2023-12-08 13:41:57'),
(99, 'App\\Models\\User', 56, 'MyAuthApp', '90e4439c4bfaaa093a23b0abb673e74fc6caee14b8f4aa2f2ec8e3d38bcefcff', '[\"*\"]', NULL, NULL, '2023-12-08 13:42:44', '2023-12-08 13:42:44'),
(100, 'App\\Models\\User', 56, 'MyAuthApp', 'ce072e2d35914bd590a2d645c180ba0bca320a63b39bc0e6d70687884b753a84', '[\"*\"]', NULL, NULL, '2023-12-08 13:43:08', '2023-12-08 13:43:08'),
(101, 'App\\Models\\User', 56, 'MyAuthApp', '2365c90cff6f7c571ed9d7039160506f2f6a5e5708547a4b9910e8b5b41fecf4', '[\"*\"]', NULL, NULL, '2023-12-08 13:43:56', '2023-12-08 13:43:56'),
(102, 'App\\Models\\User', 56, 'MyAuthApp', '2bfc9efecf1a5c6504918fbda898f0e7f5db49a8a32bed2276a99d47c2d568e8', '[\"*\"]', NULL, NULL, '2023-12-08 13:45:02', '2023-12-08 13:45:02'),
(103, 'App\\Models\\User', 56, 'MyAuthApp', 'ef0e3be9239e3ae9d5781a4bc6037015eda915f27ffd4a19bcb96a57684979c6', '[\"*\"]', NULL, NULL, '2023-12-08 13:49:17', '2023-12-08 13:49:17'),
(104, 'App\\Models\\User', 56, 'MyAuthApp', 'b020d6182756e8887c25cda54dd02b9bff232c08da2acb3b42f2c7f81b61c579', '[\"*\"]', NULL, NULL, '2023-12-08 13:49:57', '2023-12-08 13:49:57'),
(105, 'App\\Models\\User', 56, 'MyAuthApp', 'e74a390cbb03e14e2d89847791a3ff3a9d5c6d87ec857f30b0fc04c467af7c94', '[\"*\"]', NULL, NULL, '2023-12-08 13:49:59', '2023-12-08 13:49:59'),
(106, 'App\\Models\\User', 56, 'MyAuthApp', 'ee68c4d182a811ea4b77b233886099003449696187a0f768c2a1a6fcc0ca3906', '[\"*\"]', NULL, NULL, '2023-12-08 13:52:27', '2023-12-08 13:52:27'),
(107, 'App\\Models\\User', 56, 'MyAuthApp', '4740eec4ed6ed489d513ecabe5ffa204486b4fe8941644005f9bcc7e9dbaccf5', '[\"*\"]', NULL, NULL, '2023-12-08 13:52:28', '2023-12-08 13:52:28'),
(108, 'App\\Models\\User', 56, 'MyAuthApp', '3fb16ae924638469afc842108b152618f43cbe4956d309adb4eb201917607a6e', '[\"*\"]', NULL, NULL, '2023-12-08 13:52:29', '2023-12-08 13:52:29'),
(109, 'App\\Models\\User', 56, 'MyAuthApp', 'ca479c8eb32657e5609934c1a814111922225525a769b494bb94b25db42c6023', '[\"*\"]', NULL, NULL, '2023-12-08 13:52:30', '2023-12-08 13:52:30'),
(110, 'App\\Models\\User', 56, 'MyAuthApp', '430723e1d5cd40def4fd6192b89ae16efccc3dfbf76b740a8da97243954a669f', '[\"*\"]', NULL, NULL, '2023-12-08 13:52:31', '2023-12-08 13:52:31'),
(111, 'App\\Models\\User', 56, 'MyAuthApp', '67bc17a8a1e2be28f1db50a096b247916e5ab4cc9bc2543d24e085ce44d2032a', '[\"*\"]', NULL, NULL, '2023-12-08 13:52:31', '2023-12-08 13:52:31'),
(112, 'App\\Models\\User', 56, 'MyAuthApp', 'ef6980dd00ffd333a6cc144fcf5b044b3f19cc60ca4a8f52af44d72e7c19a782', '[\"*\"]', NULL, NULL, '2023-12-08 13:52:31', '2023-12-08 13:52:31'),
(113, 'App\\Models\\User', 56, 'MyAuthApp', '34a8ddaf5c091ef51d045aec78052621f6f59d1315bfed5de6930831ccb05ea8', '[\"*\"]', NULL, NULL, '2023-12-08 13:52:31', '2023-12-08 13:52:31'),
(114, 'App\\Models\\User', 56, 'MyAuthApp', '5390b0fa12d9976e12c86a14b843ec64f54757a692544cc4980642d0dca7c2dc', '[\"*\"]', NULL, NULL, '2023-12-08 13:52:32', '2023-12-08 13:52:32'),
(115, 'App\\Models\\User', 56, 'MyAuthApp', '4bf7d0496720a73d58b310c6d1475a91f809c2095af72b05099984baf6311751', '[\"*\"]', NULL, NULL, '2023-12-08 13:52:52', '2023-12-08 13:52:52'),
(116, 'App\\Models\\User', 56, 'MyAuthApp', '496ffaa55aab9fa3304b53f7315dfd7e871fbc282c9f737884b54c5bb6b63534', '[\"*\"]', NULL, NULL, '2023-12-08 13:54:34', '2023-12-08 13:54:34'),
(117, 'App\\Models\\User', 56, 'MyAuthApp', 'a41f1b482cec33430e14253d4c3725f57edcdecb990187f45d3da891f84a2087', '[\"*\"]', NULL, NULL, '2023-12-08 13:56:18', '2023-12-08 13:56:18'),
(118, 'App\\Models\\User', 56, 'MyAuthApp', '63673d53fa1c95a91fee63f5d791e625938e132dfeeda9dec0d6d136fa46e208', '[\"*\"]', NULL, NULL, '2023-12-08 13:57:08', '2023-12-08 13:57:08'),
(119, 'App\\Models\\User', 56, 'MyAuthApp', '4cfd058261347d28d4df0a13a2b06f9d95cfa81e9957fd5dc14e96a7dd10502f', '[\"*\"]', NULL, NULL, '2023-12-08 13:57:14', '2023-12-08 13:57:14'),
(120, 'App\\Models\\User', 56, 'MyAuthApp', '0e798cf39fe2d1b3e2d32b85bdd61a7325aa8900b03bca6f165fb1a5a134d9bc', '[\"*\"]', NULL, NULL, '2023-12-08 13:57:39', '2023-12-08 13:57:39'),
(121, 'App\\Models\\User', 56, 'MyAuthApp', '3ec2fb6c517858b22db67cd527219b5a956bc6b7980fb12eb3b0a72631b0b5c0', '[\"*\"]', NULL, NULL, '2023-12-08 13:57:47', '2023-12-08 13:57:47'),
(122, 'App\\Models\\User', 56, 'MyAuthApp', '0026022de9dfbc9f4c42e3602f91cc9538d8e45880d3a3ac0c1a9c8efab214e8', '[\"*\"]', NULL, NULL, '2023-12-08 13:58:03', '2023-12-08 13:58:03'),
(123, 'App\\Models\\User', 56, 'MyAuthApp', '736fd91f61fb478b65f827aae6f1de7e7dcbd8811ef0bd2d1ad4d9a5159b7bb6', '[\"*\"]', NULL, NULL, '2023-12-08 13:58:11', '2023-12-08 13:58:11'),
(124, 'App\\Models\\User', 56, 'MyAuthApp', '18b4c1df65de9c190e670ba367acac770304a8b67a0ea1472a3c20d02692b23b', '[\"*\"]', NULL, NULL, '2023-12-08 13:58:58', '2023-12-08 13:58:58'),
(125, 'App\\Models\\User', 56, 'MyAuthApp', '8ec54aa28eb30d44eef1d1386f713781902dab416699c760d8d82f32e4d6c397', '[\"*\"]', NULL, NULL, '2023-12-08 13:59:19', '2023-12-08 13:59:19'),
(126, 'App\\Models\\User', 56, 'MyAuthApp', 'd7cfacb77ff726fc41c4f0137f34afbc3a98281fb599dd28d3f783b0ff27ea7c', '[\"*\"]', NULL, NULL, '2023-12-08 13:59:20', '2023-12-08 13:59:20'),
(127, 'App\\Models\\User', 56, 'MyAuthApp', '9882a6c42e890ca66f3cf9c28dd3a6e06a1d93b649d8915c8b3e8d206e262828', '[\"*\"]', NULL, NULL, '2023-12-08 13:59:33', '2023-12-08 13:59:33'),
(128, 'App\\Models\\User', 56, 'MyAuthApp', 'ea08e9f7a5b40a7c49dc87983d97a0010504f929d5592a30a1a64fcb94d4c9ce', '[\"*\"]', NULL, NULL, '2023-12-08 13:59:34', '2023-12-08 13:59:34'),
(129, 'App\\Models\\User', 56, 'MyAuthApp', '65d2d15e0501bc1c09e551276e824d04e5ac91561d97be3a5dad0bca776cfb21', '[\"*\"]', NULL, NULL, '2023-12-08 13:59:35', '2023-12-08 13:59:35'),
(130, 'App\\Models\\User', 56, 'MyAuthApp', '7932e6ca9250ccf2d934997add581525acbee13a01e20318b32f00973628f60b', '[\"*\"]', NULL, NULL, '2023-12-08 13:59:35', '2023-12-08 13:59:35'),
(131, 'App\\Models\\User', 56, 'MyAuthApp', 'bd7dbbc6b6cb4ca67da761e1afcdbb304c9e6870762741be32156323275e8e98', '[\"*\"]', NULL, NULL, '2023-12-08 14:00:00', '2023-12-08 14:00:00'),
(132, 'App\\Models\\User', 56, 'MyAuthApp', 'd23bc1c1c480231c25f044ed4b67860f8d7b45cfcad128b98a3f5ef39ff73c3c', '[\"*\"]', '2023-12-13 08:15:02', NULL, '2023-12-08 14:00:57', '2023-12-13 08:15:02');

-- --------------------------------------------------------

--
-- Table structure for table `stake_numbers`
--

CREATE TABLE `stake_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stake_nos` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stake_numbers`
--

INSERT INTO `stake_numbers` (`id`, `stake_nos`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-10-05 11:16:27', '2023-10-05 11:16:27'),
(2, 2, NULL, NULL),
(3, 3, NULL, NULL),
(4, 4, NULL, NULL),
(5, 5, NULL, NULL),
(6, 6, NULL, NULL),
(7, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stake_platforms`
--

CREATE TABLE `stake_platforms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `winning_tags_id` bigint(20) UNSIGNED NOT NULL,
  `start_day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `is_close` int(11) NOT NULL DEFAULT 0,
  `is_open` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `win_nos` int(11) NOT NULL,
  `count_winners` int(11) DEFAULT 0,
  `max_winner_count` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `stake_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stake_platforms`
--

INSERT INTO `stake_platforms` (`id`, `category_id`, `winning_tags_id`, `start_day`, `month`, `year`, `is_close`, `is_open`, `created_at`, `updated_at`, `win_nos`, `count_winners`, `max_winner_count`, `start_date`, `end_date`, `stake_id`) VALUES
(1, 2, 2, 0, 11, 2023, 1, 0, '2023-10-19 21:17:36', '2023-10-28 13:46:53', 5, 5, 5, NULL, NULL, ''),
(2, 2, 5, 0, 10, 2023, 0, 0, '2023-10-19 21:17:46', '2023-10-19 21:18:18', 0, 0, 0, NULL, NULL, ''),
(3, 2, 5, 0, 10, 2023, 0, 0, '2023-10-19 21:18:01', '2023-10-19 21:18:51', 0, 0, 0, NULL, NULL, ''),
(4, 1, 3, 0, 10, 2023, 0, 0, '2023-10-19 21:18:32', '2023-10-19 21:18:56', 0, 0, 0, NULL, NULL, ''),
(5, 1, 2, 0, 10, 2023, 0, 0, '2023-10-19 21:24:09', '2023-10-19 21:24:13', 0, 0, 0, NULL, NULL, ''),
(6, 2, 5, 0, 10, 2023, 0, 0, '2023-10-19 21:24:56', '2023-10-19 21:25:13', 0, 0, 0, NULL, NULL, ''),
(7, 3, 8, 0, 11, 2023, 0, 0, '2023-10-19 21:25:08', '2023-10-19 21:26:57', 0, 0, 0, NULL, NULL, ''),
(8, 3, 8, 0, 10, 2023, 0, 0, '2023-10-19 21:26:00', '2023-10-19 21:27:23', 0, 0, 0, NULL, NULL, ''),
(9, 2, 6, 0, 11, 2023, 0, 0, '2023-10-19 21:26:29', '2023-10-19 21:28:19', 0, 0, 0, NULL, NULL, ''),
(10, 1, 2, 0, 11, 2023, 0, 0, '2023-10-19 21:28:34', '2023-10-19 21:28:52', 0, 0, 0, NULL, NULL, ''),
(11, 1, 2, 0, 10, 2023, 0, 0, '2023-10-19 21:28:45', '2023-10-19 21:31:07', 0, 0, 0, NULL, NULL, ''),
(12, 2, 6, 0, 11, 2023, 0, 0, '2023-10-19 21:31:18', '2023-10-19 21:31:45', 0, 0, 0, NULL, NULL, ''),
(13, 2, 5, 0, 11, 2023, 0, 0, '2023-10-19 21:31:27', '2023-10-19 21:31:39', 0, 0, 0, NULL, NULL, ''),
(14, 1, 3, 0, 10, 2023, 0, 0, '2023-10-19 21:31:35', '2023-10-19 21:31:47', 0, 0, 0, NULL, NULL, ''),
(15, 1, 2, 0, 12, 2023, 0, 0, '2023-10-20 14:22:39', '2023-10-21 08:47:55', 10, 0, 0, NULL, NULL, ''),
(16, 1, 2, 0, 10, 2023, 0, 0, '2023-10-21 08:42:13', '2023-10-21 08:49:26', 15, 0, 0, NULL, NULL, ''),
(17, 1, 2, 0, 10, 2023, 0, 0, '2023-10-21 08:47:16', '2023-10-21 08:47:52', 9, 0, 0, NULL, NULL, ''),
(18, 1, 2, 0, 10, 2023, 0, 0, '2023-10-21 08:47:29', '2023-10-21 11:13:43', 9, 0, 0, NULL, NULL, ''),
(19, 2, 5, 0, 10, 2023, 0, 0, '2023-10-21 08:55:11', '2023-10-21 08:55:22', 2, 0, 0, NULL, NULL, ''),
(20, 2, 5, 0, 10, 2023, 0, 0, '2023-10-24 07:18:53', '2023-10-24 08:20:18', 23, 0, 0, NULL, NULL, ''),
(21, 2, 5, 0, 10, 2023, 0, 0, '2023-10-24 14:38:07', '2023-10-27 12:34:50', 9, 0, 0, NULL, NULL, ''),
(22, 2, 4, 31, 10, 2023, 0, 0, '2023-10-24 19:32:16', '2023-10-24 19:39:56', 3, 0, 0, NULL, NULL, ''),
(23, 1, 2, 31, 10, 2023, 0, 0, '2023-10-24 19:39:36', '2023-10-31 10:12:34', 2, 0, 0, NULL, NULL, ''),
(24, 1, 2, 30, 10, 2023, 0, 0, '2023-10-24 19:41:15', '2023-10-24 19:41:25', 7, 0, 0, NULL, NULL, ''),
(25, 2, 4, 23, 11, 2023, 1, 0, '2023-10-31 12:20:18', '2023-10-31 17:56:03', 2, NULL, 5, NULL, NULL, ''),
(26, 1, 2, 30, 11, 2023, 1, 0, '2023-10-31 12:37:17', '2023-11-09 13:57:34', 3, NULL, 5, NULL, NULL, ''),
(27, 2, 4, 1, 11, 2023, 1, 0, '2023-10-31 12:40:36', '2023-10-31 12:40:36', 2, NULL, 4, '2023-11-01', NULL, ''),
(28, 1, 1, 16, 10, 2023, 1, 0, '2023-10-31 12:43:22', '2023-11-09 13:53:24', 3, 0, 2, '2023-10-16', NULL, ''),
(29, 1, 3, 1, 11, 2023, 1, 0, '2023-10-31 12:44:38', '2023-10-31 12:44:38', 2, 0, 4, '2023-11-01', '2023-10-23', ''),
(30, 1, 2, 9, 11, 2023, 1, 0, '2023-11-09 14:01:21', '2023-11-10 07:42:08', 3, 0, 5, '2023-11-09', '2023-11-21', 'A9k6sfoFNM'),
(31, 3, 7, 8, 11, 2023, 0, 1, '2023-11-09 14:02:01', '2023-11-09 14:02:01', 2, 0, 1, '2023-11-08', '2023-11-07', 'TUDRkKkiUd');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`) VALUES
(1, 'Abia State'),
(2, 'Adamawa State'),
(3, 'Akwa Ibom State'),
(4, 'Anambra State'),
(5, 'Bauchi State'),
(6, 'Bayelsa State'),
(7, 'Benue State'),
(8, 'Borno State'),
(9, 'Cross River State'),
(10, 'Delta State'),
(11, 'Ebonyi State'),
(12, 'Edo State'),
(13, 'Ekiti State'),
(14, 'Enugu State'),
(15, 'FCT'),
(16, 'Gombe State'),
(17, 'Imo State'),
(18, 'Jigawa State'),
(19, 'Kaduna State'),
(20, 'Kano State'),
(21, 'Katsina State'),
(22, 'Kebbi State'),
(23, 'Kogi State'),
(24, 'Kwara State'),
(25, 'Lagos State'),
(26, 'Nasarawa State'),
(27, 'Niger State'),
(28, 'Ogun State'),
(29, 'Ondo State'),
(30, 'Osun State'),
(31, 'Oyo State'),
(32, 'Plateau State'),
(33, 'Rivers State'),
(34, 'Sokoto State'),
(35, 'Taraba State'),
(36, 'Yobe State'),
(37, 'Zamfara State');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sub_type` varchar(20) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `sub_type`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Machines', '', 2, '2023-09-01 11:01:02', '2023-09-01 11:01:02'),
(2, 'Tools', '', 2, '2023-09-03 23:00:00', '2023-10-09 08:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_code` varchar(100) NOT NULL,
  `intrabank` tinyint(4) NOT NULL,
  `minor_amount` bigint(20) NOT NULL,
  `minor_fee_amount` bigint(20) NOT NULL,
  `minor_vat_amount` bigint(20) NOT NULL DEFAULT 0,
  `name_enquiry_reference` varchar(255) DEFAULT NULL,
  `narration` varchar(255) NOT NULL,
  `Response_code` varchar(10) NOT NULL,
  `sink_account_name` varchar(100) NOT NULL,
  `sink_account_number` varchar(11) NOT NULL,
  `sink_account_provider_code` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(15) NOT NULL,
  `transaction_status` varchar(15) NOT NULL,
  `transaction_type` varchar(10) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bank_accounts` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identity` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `verified` varchar(255) NOT NULL DEFAULT '1',
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_reset` varchar(255) DEFAULT NULL,
  `verify_code` int(11) NOT NULL DEFAULT 0,
  `device_id` varchar(255) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `bank_code` varchar(255) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `charge_response_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `identity`, `username`, `verified`, `password`, `remember_token`, `created_at`, `updated_at`, `email`, `password_reset`, `verify_code`, `device_id`, `role`, `bank_code`, `pin`, `charge_response_code`) VALUES
(1, 'JxZExPlkKKIUaHD9hoSFqZwVjeDy8A9eLX3GwesZIrgRp6DTQd', 'chuksdevops@gmail.com', '1', '$2y$10$CTU6QkunZOvxiyxcKrsEcu5D9Bd11gdyfMLt7CtYc.Oc473eghaau', NULL, '2023-09-01 10:38:44', '2023-10-25 12:46:11', 'chuksdsilent@gmail.com', '837200', 0, '', 'Admin', '', '', NULL),
(19, 'BLHJDLtNa1tnhlMaHuB7HeQOyVXKM6xxTKORF6y4DjtO5awyIf', 'samch4u', '0', '$2y$10$CTU6QkunZOvxiyxcKrsEcu5D9Bd11gdyfMLt7CtYc.Oc473eghaau', NULL, '2023-10-05 12:27:24', '2023-10-05 12:27:24', '', '', 0, '', 'Agent', '', '', NULL),
(20, 'B4dxX7T0V6cQPADRDD9a4Gl4R5FTzJNXnPwjiKIk3GS9BKGXES', 'samoo', '0', '$2y$10$CTU6QkunZOvxiyxcKrsEcu5D9Bd11gdyfMLt7CtYc.Oc473eghaau', NULL, '2023-10-26 07:09:26', '2023-10-26 07:09:26', NULL, NULL, 0, '', 'Customer', '', '', NULL),
(24, 'Y08kOHKWcFIQsKDK7sZEoVjoU0DDf8VyRFoC7efplnh3i9Vyfn', 'chuks', '0', '$2y$10$CTU6QkunZOvxiyxcKrsEcu5D9Bd11gdyfMLt7CtYc.Oc473eghaau', NULL, '2023-10-26 07:19:43', '2023-10-26 07:19:43', NULL, NULL, 0, '', 'Customer', '', '', NULL),
(25, 'xfjmCjzokTaWvu7Puue9QuTrmlDVDnlaWxednN30WTs7CksQ7D', 'chukss', '0', '$2y$10$CTU6QkunZOvxiyxcKrsEcu5D9Bd11gdyfMLt7CtYc.Oc473eghaau', NULL, '2023-10-28 12:35:02', '2023-10-28 12:35:02', 'chuksdssilent@gmail.com', NULL, 502926, '', 'Customer', '', '', NULL),
(41, 'VoWYPbNmEQXgFDFxO7rUVbicU2wKrppt3XqoNRN0IXCDSSq4bC', 'okoro', '0', '$2y$10$9VN.s3j2UMzXU5XAh6t4V.CFGN5ANsnY7HBQbZNsKq15RnMar51by', NULL, '2023-11-13 12:07:49', '2023-11-13 12:07:49', 'okoro@mail.com', NULL, 544538, NULL, 'Agent', '', '', NULL),
(42, 'CNqq5AO0W0cVkS4V1as0CSJKfiMAEw71uxntnXT2BKBbKL9ED7', 'joy', '0', '$2y$10$0F//vMtNUxRhi6Xud5Ex.OBuOp8KHt0bdSTjN3W3kz3Tp7TLBDh8q', NULL, '2023-11-25 20:11:36', '2023-11-25 20:11:36', NULL, NULL, 179236, NULL, 'Agent', '', '', NULL),
(43, 'fGut8ssXo3uZ8qpTbTWZXfMo0KZcDikFOAt7sh6Ntm1XoBbDgv', 'joys', '0', '$2y$10$fTYrXpXGPkiaW.5ZSl1z.uj3VdxdOjZwrUY0ZTwJZHqvP9kYat58G', NULL, '2023-11-25 20:14:50', '2023-11-25 20:14:50', NULL, NULL, 280388, NULL, 'Agent', '', '', NULL),
(44, 'eR7cpKlMPLC5mdjhZ8iSb1axKvkJs5bU8Bs2J69dZlMKFNFwa4', 'joyful', '0', '$2y$10$/Rgp5/wXjQfoQlI1Yq8F2.pCNaBEixKISIEGu2gRBroJaKqTuIIyW', NULL, '2023-11-25 20:15:59', '2023-11-25 20:15:59', NULL, NULL, 841815, NULL, 'Agent', '', '', NULL),
(45, '8tobq7Go4tpdJIkhAW7VB6ETNzS4rMHFLfO9FNhbcosz7Pu8Lz', 'joyfuls', '0', '$2y$10$n9VYeqFEqDgrViYQlzC3XOO3sBMP3e6F4A1ow4XMK12.AKPMPl2Ha', NULL, '2023-11-25 20:22:27', '2023-11-25 20:22:27', NULL, NULL, 590482, NULL, 'Agent', '', '', NULL),
(46, '77X03pUf4hRKtk2PsxE5CtaI1FcL5pM45qb8WsECSrQpN4Yde4', 'joyfulss', '0', '$2y$10$juuh8pNygGfAkuqRhDVPtOly9jmj9OrkQlklXxRdtKElT2PcmnSCK', NULL, '2023-11-25 20:23:25', '2023-11-25 20:23:25', NULL, NULL, 611037, NULL, 'Agent', '', '', NULL),
(47, 'qL9SrHhh53gb5PHNwNt7jakWFzRBx18UDHWnpP9UnVcTk7PVYM', 'joyfulsss', '0', '$2y$10$Ku8n6EJSp8ReLZYXA8Yt0.Jopa87cJ7mfgUKv4EMmvJb1gsiTfL/C', NULL, '2023-11-25 20:23:55', '2023-11-25 20:23:55', NULL, NULL, 478709, NULL, 'Agent', '', '', NULL),
(48, 'VehJjaCjB67GcRWGeIoH0N13yOro5lac1LscbKdG9pYtHzxAQe', 'joyfulssss', '0', '$2y$10$IC9p/KlBU5uNZSA0xdAtfet7wDhw2Ii2DxYJFwWIld/JOHtszm10q', NULL, '2023-11-25 20:26:12', '2023-11-25 20:26:12', NULL, NULL, 664445, NULL, 'Agent', '', '', NULL),
(49, '0Fl6Wka0K6w9fulrSKbODjlUAy3zCqOkgHvMsIVTw2XuvbEjMG', 'joyfulssssj', '0', '$2y$10$8SkOs9TpQWy5Q8TTDFo.YOzlZFuRWReX6YgluPOk8dVSuZgrk9Jn.', NULL, '2023-11-25 21:12:44', '2023-11-25 21:12:44', NULL, NULL, 213936, NULL, 'Agent', '', '', NULL),
(50, '1saoPT1V8HBRyJlux9PRZ6wmg28ifDsFOZhFOYPZxJFwzJlrdT', 'Nwanka', '0', '$2y$10$eXy4WflFBoH3EZDN8mloXuVm.2imQi3L5XnITrYsK9Vxgy7KLw6qy', NULL, '2023-11-25 21:22:00', '2023-11-25 21:22:00', NULL, NULL, 815120, NULL, 'Agent', '', '', NULL),
(51, 'xZilq2tnh6f3iyP3AXNwrgyYNyFEn6o0vVKZz6fG9jZbjTfc0b', 'samson', '0', '$2y$10$R2QgCw9Zc/wjLXhVkaSHSuE7zCcDCpi.epHBI.kvDnY0GA9.D5.ky', NULL, '2023-11-25 21:46:13', '2023-11-25 21:46:13', NULL, NULL, 406707, NULL, 'Agent', '', '', NULL),
(52, 'e9ShLpb6sMzv6rtA8Aj2UG0YXqvh1ZmF1bog5oR7qq4DRduecO', 'Joyce', '0', '$2y$10$wlAvx1Ggin4tRNgPCjKG6.HPxhUqedM0cPx8xzVQ.WHQxgwcKB4ne', NULL, '2023-11-25 21:48:04', '2023-11-25 21:48:04', NULL, NULL, 746303, NULL, 'Agent', '', '', NULL),
(53, 'LvcWo6NPP77jiUj6DAAntmt8we22SbILukPHuLrUIHooGtRExF', 'ugo', '0', '$2y$10$hqsjDJrtEmaFsE7hSMdGZuifMds6ETlSAU9lS7Ms5p3TB4.7Msx3q', NULL, '2023-11-25 22:05:49', '2023-11-25 22:05:49', NULL, NULL, 974447, NULL, 'Agent', '', '', NULL),
(54, '0gH0JhfkMUD9JKf5RuA7DZgcPR4KREaisQZFJSrcfMWrwLdcvd', 'johnsina', '1', '$2y$10$Nn6Nu9FpMe4ajqBMMe3PTew0wiC7no/5eyKdBSkfFB3FykZ7eJJLm', NULL, '2023-11-25 22:13:40', '2023-11-26 02:32:42', NULL, NULL, 0, NULL, 'Agent', '', '', NULL),
(56, '5Rt0V2IDFcTi0tzbXbR3tED2iqqCWrsRTCgANb8X7ME5UNfYiE', 'africa', '1', '$2y$10$CTU6QkunZOvxiyxcKrsEcu5D9Bd11gdyfMLt7CtYc.Oc473eghaau', NULL, '2023-12-07 20:33:01', '2023-12-07 20:33:25', NULL, NULL, 0, NULL, 'Agent', '', '$2y$10$CTU6QkunZOvxiyxcKrsEcu5D9Bd11gdyfMLt7CtYc.Oc473eghaau', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `winning_tags`
--

CREATE TABLE `winning_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `stake_price` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `artisan_category` varchar(255) NOT NULL DEFAULT 'No Category',
  `sub_cat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `winning_tags`
--

INSERT INTO `winning_tags` (`id`, `name`, `stake_price`, `category_id`, `artisan_category`, `sub_cat_id`, `created_at`, `updated_at`, `image`) VALUES
(1, 'keke Napepe', '54.90', 1, 'No Category', NULL, '2023-10-11 02:21:52', '2023-11-21 04:30:27', 'http://localhost:8001/storage/images/image_1696994512.jpeg'),
(2, 'keke Napepesa', '1500.11', 1, 'No Category', NULL, '2023-10-11 02:24:10', '2023-10-24 09:55:17', 'http://localhost:8001/storage/images/image_1696994650.jpeg'),
(3, 'Motor bike', '3000', 1, 'No Category', NULL, '2023-10-11 02:25:06', '2023-10-11 02:25:06', 'http://localhost:8001/storage/images/image_1696994706.jpeg'),
(4, 'Welding Machine', '32000', 2, 'No Category', 1, '2023-10-11 02:30:07', '2023-10-31 17:58:27', 'http://localhost:8001/storage/images/image_1696995007.jpeg'),
(5, 'Grinding Machine', '250.90', 2, 'No Category', 1, '2023-10-11 02:30:47', '2023-10-24 10:01:08', 'http://localhost:8001/storage/images/image_1696995047.jpeg'),
(6, 'Aluminum Cutter', '3000', 2, 'No Category', 1, '2023-10-11 02:32:21', '2023-10-11 02:32:21', 'http://localhost:8001/storage/images/image_1696995141.jpeg'),
(7, 'School Fees', '3000', 3, 'No Category', NULL, '2023-10-11 02:41:43', '2023-10-11 02:41:43', 'http://localhost:8001/storage/images/image_1696995703.jpeg'),
(8, 'House', '3000', 3, 'No Category', NULL, '2023-10-11 02:42:28', '2023-10-11 02:42:28', 'http://localhost:8001/storage/images/image_1696995748.jpeg'),
(9, 'Cash', '150', 2, 'No Category', NULL, '2023-10-11 02:46:00', '2023-10-24 10:01:30', 'http://localhost:8001/storage/images/image_1696995960.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `win_numbers`
--

CREATE TABLE `win_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identity` varchar(20) NOT NULL,
  `win_num` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `winning_tag_id` bigint(20) UNSIGNED NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `win_numbers`
--

INSERT INTO `win_numbers` (`id`, `identity`, `win_num`, `category_id`, `winning_tag_id`, `month`, `year`, `created_at`, `updated_at`) VALUES
(1, 'vyEhTYAtlipD57pdEKY5', '88', 1, 2, '12', '2023', '2023-10-11 13:47:19', '2023-10-11 13:47:19');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `bank_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double NOT NULL,
  `narration` varchar(100) NOT NULL,
  `trx_ref` varchar(20) NOT NULL,
  `status` varchar(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` int(11) DEFAULT NULL,
  `bank_code` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `trx_date` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `debit_currency` varchar(255) DEFAULT NULL,
  `fee` double DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `requires_approval` int(11) DEFAULT NULL,
  `is_approved` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `user_id`, `customer_id`, `bank_account_id`, `amount`, `narration`, `trx_ref`, `status`, `created_at`, `updated_at`, `bank_name`, `account_number`, `bank_code`, `full_name`, `trx_date`, `currency`, `debit_currency`, `fee`, `reference`, `requires_approval`, `is_approved`) VALUES
(1, 1, 1, 1, 200, 'Withdrawal fromNnamdi', '9ja_kC10ZdhzSiCgRmq', 'Pending', '2023-11-22 10:52:28', '2023-11-22 12:21:30', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(5, 25, 7, 1, 100, 'Withdrawal from Nnamdi', '9ja_GxCyrj6EWf4Ae2U', 'Pending', '2023-12-10 12:01:29', '2023-12-10 12:01:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 25, 7, 1, 100, 'Withdrawal from Nnamdi', '9ja_REIFELR7yzSqGaO', 'Pending', '2023-12-10 12:01:39', '2023-12-10 12:01:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 25, 7, 1, 100, 'Withdrawal from Nnamdi', '9ja_bXUFUD6tEbkJuMp', 'Pending', '2023-12-10 12:02:36', '2023-12-10 12:02:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 25, 7, 1, 100, 'Withdrawal from Nnamdi', '9ja_VGrAkAniLn8ousb', 'Completed', '2023-12-10 12:02:49', '2023-12-10 12:02:50', 'ACCESS BANK NIGERIA', 44925820, 44, 'OSHABA SAMSON CHUKWU', '2023-12-10T13:02:51.000Z', 'NGN', 'NGN', 10.75, 'Raffle9ja_f6etZrJ9fLdURjTYKMMM', 0, 1),
(10, 25, 7, 1, 100, 'Withdrawal from Nnamdi', '9ja_2w5AM8i8ulMlsb6', 'Pending', '2023-12-10 12:03:52', '2023-12-10 12:03:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 25, 7, NULL, 100, 'Withdrawal from Nnamdi', '9ja_ivqwMbI3JkwczJv', 'Pending', '2023-12-16 05:26:31', '2023-12-16 05:26:31', NULL, NULL, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 25, 7, NULL, 100, 'Withdrawal from Nnamdi', '9ja_QCi8itsiOo4jTea', 'Pending', '2023-12-16 05:32:17', '2023-12-16 05:32:17', NULL, 690000034, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 25, 7, NULL, 100, 'Withdrawal from Nnamdi', '9ja_TSWx4qbQ08vsFUC', 'Pending', '2023-12-16 05:34:55', '2023-12-16 05:34:55', NULL, 690000034, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 25, 7, NULL, 100, 'Withdrawal from Nnamdi', '9ja_7H9QrgDDIPRB4Fn', 'Pending', '2023-12-16 05:36:52', '2023-12-16 05:36:52', NULL, 690000034, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 25, 7, NULL, 100, 'Withdrawal from Nnamdi', '9ja_PNaHP3TgwoDwcRo', 'Pending', '2023-12-16 05:37:14', '2023-12-16 05:37:14', NULL, 690000034, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 25, 7, NULL, 100, 'Withdrawal from Nnamdi', '9ja_HWdVtWVlQ8fqOF1', 'Pending', '2023-12-16 05:37:40', '2023-12-16 05:37:40', NULL, 690000034, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 25, 7, NULL, 100, 'Withdrawal from Nnamdi', '9ja_GV1VCkzFrjls2HR', 'Pending', '2023-12-16 05:38:07', '2023-12-16 05:38:07', NULL, 690000034, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 25, 7, NULL, 100, 'Withdrawal from Nnamdi', '9ja_cjM9P9dBexnEkPn', 'Pending', '2023-12-16 05:39:05', '2023-12-16 05:39:05', NULL, 690000034, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agents_user_id_foreign` (`user_id`);

--
-- Indexes for table `agent_funding_transactions`
--
ALTER TABLE `agent_funding_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_funding_transactions_user_id_foreign` (`user_id`),
  ADD KEY `agent_funding_transactions_agent_id_foreign` (`agent_id`);

--
-- Indexes for table `agent_payments`
--
ALTER TABLE `agent_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_payments_user_id_foreign` (`user_id`),
  ADD KEY `agent_payments_agent_id_foreign` (`agent_id`);

--
-- Indexes for table `agent_pins`
--
ALTER TABLE `agent_pins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_raffle_booking_transactions`
--
ALTER TABLE `agent_raffle_booking_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_raffle_booking_transactions_user_id_foreign` (`user_id`),
  ADD KEY `agent_raffle_booking_transactions_agent_id_foreign` (`agent_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_user_id_foreign` (`user_id`),
  ADD KEY `bank_accounts_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Indexes for table `customers_stakes`
--
ALTER TABLE `customers_stakes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_stakes_user_id_foreign` (`user_id`),
  ADD KEY `customers_stakes_winning_tags_id_foreign` (`winning_tags_id`),
  ADD KEY `customers_stakes_category_id_foreign` (`category_id`),
  ADD KEY `customers_stakes_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `customer_funding_transactions`
--
ALTER TABLE `customer_funding_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_funding_transactions_user_id_foreign` (`user_id`),
  ADD KEY `customer_funding_transactions_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `customer_raffle_booking_transactions`
--
ALTER TABLE `customer_raffle_booking_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_raffle_booking_transactions_user_id_foreign` (`user_id`),
  ADD KEY `customer_raffle_booking_transactions_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `customer_transaction_history`
--
ALTER TABLE `customer_transaction_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_transaction_history_user_id_foreign` (`user_id`),
  ADD KEY `customer_transaction_history_customer_id_foreign` (`customer_id`),
  ADD KEY `ids` (`ids`),
  ADD KEY `ids_2` (`ids`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flutterwave_details`
--
ALTER TABLE `flutterwave_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locals`
--
ALTER TABLE `locals`
  ADD PRIMARY KEY (`local_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `stake_numbers`
--
ALTER TABLE `stake_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stake_platforms`
--
ALTER TABLE `stake_platforms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stake_platform_category_id_foreign` (`category_id`),
  ADD KEY `stake_platform_winning_tags_id_foreign` (`winning_tags_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfers_user_id_foreign` (`user_id`),
  ADD KEY `transfers_bank_accounts_foreign` (`bank_accounts`),
  ADD KEY `transfers_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `winning_tags`
--
ALTER TABLE `winning_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `winning_tags_category_id_foreign` (`category_id`),
  ADD KEY `winning_tags_sub_cat_id_foreign` (`sub_cat_id`);

--
-- Indexes for table `win_numbers`
--
ALTER TABLE `win_numbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `win_numbers_winning_tag_id_foreign` (`winning_tag_id`),
  ADD KEY `win_numbers_category_id_foreign` (`category_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_user_id_foreign` (`user_id`),
  ADD KEY `withdrawals_customer_id_foreign` (`customer_id`),
  ADD KEY `withdrawals_bank_account_id_foreign` (`bank_account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `agent_funding_transactions`
--
ALTER TABLE `agent_funding_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `agent_payments`
--
ALTER TABLE `agent_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `agent_pins`
--
ALTER TABLE `agent_pins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_raffle_booking_transactions`
--
ALTER TABLE `agent_raffle_booking_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=598;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers_stakes`
--
ALTER TABLE `customers_stakes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `customer_funding_transactions`
--
ALTER TABLE `customer_funding_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_raffle_booking_transactions`
--
ALTER TABLE `customer_raffle_booking_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_transaction_history`
--
ALTER TABLE `customer_transaction_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flutterwave_details`
--
ALTER TABLE `flutterwave_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locals`
--
ALTER TABLE `locals`
  MODIFY `local_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=756;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `stake_numbers`
--
ALTER TABLE `stake_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stake_platforms`
--
ALTER TABLE `stake_platforms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `winning_tags`
--
ALTER TABLE `winning_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `win_numbers`
--
ALTER TABLE `win_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agent_funding_transactions`
--
ALTER TABLE `agent_funding_transactions`
  ADD CONSTRAINT `agent_funding_transactions_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agent_funding_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agent_payments`
--
ALTER TABLE `agent_payments`
  ADD CONSTRAINT `agent_payments_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agent_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agent_raffle_booking_transactions`
--
ALTER TABLE `agent_raffle_booking_transactions`
  ADD CONSTRAINT `agent_raffle_booking_transactions_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agent_raffle_booking_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bank_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers_stakes`
--
ALTER TABLE `customers_stakes`
  ADD CONSTRAINT `customers_stakes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customers_stakes_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customers_stakes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customers_stakes_winning_tags_id_foreign` FOREIGN KEY (`winning_tags_id`) REFERENCES `winning_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_funding_transactions`
--
ALTER TABLE `customer_funding_transactions`
  ADD CONSTRAINT `customer_funding_transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_funding_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_raffle_booking_transactions`
--
ALTER TABLE `customer_raffle_booking_transactions`
  ADD CONSTRAINT `customer_raffle_booking_transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_raffle_booking_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_transaction_history`
--
ALTER TABLE `customer_transaction_history`
  ADD CONSTRAINT `customer_transaction_history_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_transaction_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stake_platforms`
--
ALTER TABLE `stake_platforms`
  ADD CONSTRAINT `stake_platform_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stake_platform_winning_tags_id_foreign` FOREIGN KEY (`winning_tags_id`) REFERENCES `winning_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_bank_accounts_foreign` FOREIGN KEY (`bank_accounts`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `winning_tags`
--
ALTER TABLE `winning_tags`
  ADD CONSTRAINT `winning_tags_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `win_numbers`
--
ALTER TABLE `win_numbers`
  ADD CONSTRAINT `win_numbers_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `win_numbers_winning_tag_id_foreign` FOREIGN KEY (`winning_tag_id`) REFERENCES `winning_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `withdrawals_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `withdrawals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

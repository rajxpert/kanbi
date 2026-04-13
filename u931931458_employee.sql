-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 13, 2026 at 12:43 PM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u931931458_employee`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `activity_type` enum('login','logout') NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `employee_id`, `activity_type`, `location`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 'ADMIN001', 'logout', 'Unknown', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-09 17:11:04'),
(2, 'ADMIN001', 'login', '', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-09 17:11:36'),
(3, 'EMP0001', 'logout', 'Unknown', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-09 17:11:51'),
(4, 'emp0001', 'login', '28.6004723,77.0866534', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-09 17:12:10'),
(5, 'EMP0001', 'logout', 'Unknown', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-09 17:34:37'),
(6, 'emp0001', 'login', '28.6004723,77.0866534', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-09 17:35:54'),
(7, 'EMP0001', 'logout', 'Unknown', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-09 17:42:40'),
(8, 'EMP0011', 'login', 'Location denied', '2401:4900:1f2f:518b:bd40:7193:835d:307a', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 04:50:02'),
(9, 'EMP0013', 'login', '', '2405:201:4031:380b:cddf:3fc0:7803:f8db', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 05:11:54'),
(10, 'emp0001', 'login', '28.6004723,77.0866534', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 05:28:22'),
(11, 'emp0001', 'login', 'Location denied', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 06:37:53'),
(12, 'EMP0005', 'login', '', '2a02:6ea0:2706:3:35b1:3d20:f2bc:b265', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 09:50:51'),
(13, 'EMP0005', 'logout', 'Unknown', '2a02:6ea0:2706:3:35b1:3d20:f2bc:b265', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 09:51:20'),
(14, 'EMP0005', 'login', '39.6751269,-104.9680914', '2a02:6ea0:2706:3:35b1:3d20:f2bc:b265', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 09:51:27'),
(15, 'EMP0011', 'login', 'Location denied', '2401:4900:1f2f:518b:bd40:7193:835d:307a', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 10:30:06'),
(16, 'EMP0012', 'login', '28.6982144,77.1391488', '2401:4900:1f2f:518b:a8d2:c81b:2b7f:a26c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 10:30:51'),
(17, 'ADMIN001', 'login', '28.6034493,77.056442', '49.36.184.106', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 10:34:27'),
(18, 'emp0001', 'login', 'Location denied', '49.36.184.106', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 11:07:46'),
(19, 'EMP0012', 'login', '28.603368,77.0564415', '2605:6c80:11:2004:641b:8ba:9f49:6b23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 11:24:09'),
(20, 'EMP0001', 'logout', 'Unknown', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 12:07:45'),
(21, 'emp0001', 'login', 'Location denied', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 12:07:59'),
(22, 'EMP0011', 'login', 'Location denied', '2402:3a80:4558:954d:0:8:73bb:5b01', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 13:33:52'),
(23, 'ADMIN001', 'logout', 'Unknown', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-11 11:59:38'),
(24, 'ADMIN001', 'login', '28.5837197,77.0866534', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-11 12:00:11'),
(25, 'EMP0001', 'logout', 'Unknown', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-11 12:00:41'),
(26, 'emp0001', 'login', 'Location denied', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-11 12:00:50'),
(27, 'EMP0004', 'login', '', '2401:4900:1c47:3a6f:1997:43d6:299d:4801', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-12 13:08:30'),
(28, 'emp0002', 'login', '28.603408780382395,77.05652458301952', '2401:4900:1c47:3a6f:905d:2403:41f7:bd4c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-13 09:56:31'),
(29, 'EMP0001', 'logout', 'Unknown', '2401:4900:1c47:3a6f:a14b:d4f5:be70:b04b', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-13 10:50:44'),
(30, 'ADMIN001', 'login', 'Location denied', '2401:4900:1c47:3a6f:a14b:d4f5:be70:b04b', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-13 11:14:44'),
(31, 'ADMIN001', 'login', 'Location denied', '2401:4900:1c47:3a6f:a14b:d4f5:be70:b04b', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-13 12:34:04'),
(32, 'EMP0011', 'login', 'Location denied', '2401:4900:1c47:3a6f:8c97:e47f:1d22:41a2', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-14 04:52:26'),
(33, 'EMP0011', 'login', 'Location denied', '2401:4900:1c47:3a6f:8c97:e47f:1d22:41a2', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-14 04:52:28'),
(34, 'emp0001', 'login', 'Location denied', '2405:201:4031:380b:f40d:96c:80a6:8fcb', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-14 10:08:07'),
(35, 'EMP0001', 'logout', 'Unknown', '1.22.177.172', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-14 10:29:00'),
(36, 'emp0001', 'login', 'Location denied', '1.22.177.172', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-14 10:49:29'),
(37, 'EMP0011', 'login', 'Location denied', '2401:4900:1c48:bf9e:8c97:e47f:1d22:41a2', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-14 13:32:57'),
(38, 'EMP0011', 'login', 'Location denied', '2401:4900:1f2e:5275:8c97:e47f:1d22:41a2', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-17 04:49:43'),
(39, 'EMP0011', 'login', 'Location denied', '2401:4900:1f2e:5275:81ce:f3:6e2a:7a64', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-19 04:55:49'),
(40, 'ADMIN001', 'login', 'Location denied', '1.22.177.39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-19 06:32:49'),
(41, 'EMP0016', 'login', '28.629414671370963,77.05024135646478', '103.134.114.175', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-19 09:16:00'),
(42, 'EMP0016', 'logout', 'Unknown', '2405:204:3312:33e4:28b2:8583:cc22:8785', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-19 09:21:02'),
(43, 'EMP0016', 'login', '28.629570013200496,77.05043871332504', '2405:204:3312:33e4:28b2:8583:cc22:8785', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-19 09:21:11'),
(44, 'EMP0016', 'logout', 'Unknown', '2405:204:3312:33e4:28b2:8583:cc22:8785', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-19 09:23:47'),
(45, 'emp0001', 'login', 'Location denied', '2401:4900:1f2e:5275:899a:2585:b5b9:13e3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-19 09:39:40'),
(46, 'EMP0016', 'login', '28.629680543980452,77.05024848756108', '103.141.91.61', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-19 11:36:16'),
(47, 'EMP0016', 'logout', 'Unknown', '103.141.91.61', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-19 11:36:36'),
(48, 'EMP0016', 'login', '28.629437394848896,77.05033205734034', '49.36.186.176', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-20 04:53:18'),
(49, 'emp0001', 'login', 'Location denied', '2401:4900:1c47:18cf:91e1:c60c:5562:1cc5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-20 05:48:23'),
(50, 'EMP0016', 'login', '28.603403513249095,77.05651041951224', '2405:201:4031:380b:7d1d:4c0d:d7f3:5207', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-20 13:32:06'),
(51, 'EMP0016', 'login', '28.603422124898625,77.05647812841309', '2405:201:4031:380b:e0c9:8b6a:33c9:949a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-21 13:28:56'),
(52, 'EMP0016', 'logout', 'Unknown', '49.36.185.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 07:19:02'),
(53, 'EMP0016', 'login', '28.603420655579402,77.05649109399141', '49.36.185.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 13:34:08'),
(54, 'ADMIN001', 'login', 'Location denied', '49.36.185.52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 13:42:40'),
(55, 'ADMIN001', 'login', 'Location denied', '49.36.184.106', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-24 10:09:20'),
(56, 'EMP0016', 'login', '', '49.36.184.106', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 10:27:23'),
(57, 'EMP0016', 'login', '', '2401:4900:1f2f:5c61:94da:b02e:7d27:f2c0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 13:27:55'),
(58, 'EMP0016', 'logout', 'Unknown', '103.141.91.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-26 08:48:51'),
(59, 'EMP0016', 'login', '28.629388879750294,77.050251101251', '103.141.91.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-26 08:48:56'),
(60, 'ADMIN001', 'logout', 'Unknown', '49.36.186.224', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-27 08:51:30'),
(61, 'ADMIN001', 'login', 'Location denied', '182.69.156.31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-29 05:38:28'),
(62, 'EMP0016', 'login', 'Location denied', '103.141.91.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-29 16:15:27'),
(63, 'EMP0016', 'login', 'Location denied', '103.141.91.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-29 16:15:29'),
(64, 'EMP0016', 'login', 'Location denied', '2405:201:4031:3a82:11dd:3321:5f79:a102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-30 13:47:44'),
(65, 'ADMIN001', 'login', 'Location denied', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 05:44:28'),
(66, 'ADMIN001', 'logout', 'Unknown', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 07:05:22'),
(67, 'ADMIN001', 'login', 'Location denied', '103.112.17.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 07:05:42'),
(68, 'EMP0016', 'login', '28.629547137031484,77.05021491318831', '103.134.114.220', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 13:09:04'),
(69, 'EMP0016', 'login', '28.629547137031484,77.05021491318831', '103.134.114.220', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 13:09:05'),
(70, 'Admin001', 'login', 'Location denied', '2401:4900:5985:e344::225:3f26', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 07:01:44'),
(71, 'emp0001', 'login', '30.8558943,75.9048011', '2404:7c80:54:8325:9d61:2fb7:db04:484b', 'Mozilla/5.0 (Linux; Android 11; Smart TV Pro Build/RP1A.200622.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/144.0.7559.59 Mobile Safari/537.36', '2026-02-01 07:12:27'),
(72, 'EMP0001', 'logout', 'Unknown', '101.0.45.241', 'Mozilla/5.0 (Linux; Android 11; Smart TV Pro Build/RP1A.200622.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/144.0.7559.59 Mobile Safari/537.36', '2026-02-01 07:13:08'),
(73, 'emp0001', 'login', '30.8558954,75.9048015', '101.0.45.241', 'Mozilla/5.0 (Linux; Android 11; Smart TV Pro Build/RP1A.200622.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/144.0.7559.59 Mobile Safari/537.36', '2026-02-01 07:23:30'),
(74, 'EMP0001', 'logout', 'Unknown', '101.0.45.241', 'Mozilla/5.0 (Linux; Android 11; Smart TV Pro Build/RP1A.200622.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/144.0.7559.59 Mobile Safari/537.36', '2026-02-01 07:25:26'),
(75, 'ADMIN001', 'logout', 'Unknown', '2401:4900:5985:e344::225:3f26', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 07:40:53'),
(76, 'Admin001', 'login', 'Location denied', '2401:4900:5c75:e23b::226:3205', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-02 05:31:50'),
(77, 'EMP0016', 'login', '28.5936,77.0953', '103.141.91.157', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 06:22:04'),
(78, 'EMP0016', 'login', '28.629551714796698,77.05020221311858', '103.141.91.157', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 14:43:46'),
(79, 'EMP0016', 'login', '28.629551714796698,77.05020221311858', '103.141.91.157', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 14:43:47'),
(80, 'EMP0016', 'login', '28.603428499321428,77.056549', '2405:201:4031:3147:1a4:71f8:bf23:c406', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-05 05:34:11'),
(81, 'EMP0016', 'login', '', '2405:201:4031:3147:2479:68be:dcaa:4416', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-05 13:32:07'),
(82, 'EMP0016', 'login', '28.603431003958796,77.05654899999999', '2405:201:4031:3147:2c45:d679:82bf:d560', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-06 08:56:40'),
(83, 'EMP0016', 'login', '', '110.235.234.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 09:49:13'),
(84, 'EMP0016', 'login', '', '110.235.234.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 09:49:40'),
(85, 'EMP0016', 'login', '', '110.235.234.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 09:49:42'),
(86, 'ADMIN001', 'login', '', '2409:40e3:1f8:3b76:6020:820b:3c9e:8b6c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 16:55:08'),
(87, 'EMP0016', 'login', '', '2405:201:4031:3147:11e3:ee5f:a4e3:12c1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 13:32:09'),
(88, 'EMP0016', 'login', '', '2405:201:4031:3147:718c:83bc:cc71:c571', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 10:13:43'),
(89, 'ADMIN001', 'login', 'Location denied', '103.112.17.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 14:06:07'),
(90, 'EMP0016', 'login', '28.603422348243814,77.05654003703833', '2405:201:4031:3147:20e2:d34e:e97a:2346', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:14:24'),
(91, 'EMP0016', 'login', '', '2405:201:4031:3147:9031:8989:2c1e:1f7e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 13:34:52'),
(92, 'EMP0016', 'login', '', '2405:201:4031:3147:c9c1:238b:6dae:c5ac', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-14 05:53:33'),
(93, 'EMP0016', 'login', '28.603427496328678,77.05653466100875', '2401:4900:1c49:34c9:b4e4:a921:f3a6:d75d', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 05:33:00'),
(94, 'EMP0016', 'login', '28.60342210090898,77.05654344492415', '2401:4900:1c49:34c9:2103:608c:3f5f:4104', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-17 05:54:43'),
(95, 'EMP0016', 'login', '', '2405:201:4031:3147:9473:9dce:87cc:c975', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-18 06:02:40'),
(96, 'ADMIN001', 'login', 'Location denied', '49.36.189.16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-18 06:22:51'),
(97, 'EMP0016', 'login', '', '2405:201:4031:3147:4ec:9f10:1fc4:8d83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-18 06:23:31'),
(98, 'EMP0016', 'login', '28.60342212434853,77.05654042716776', '37.120.215.170', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-18 13:30:53'),
(99, 'ADMIN001', 'login', 'Location denied', '223.237.10.175', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-18 15:44:54'),
(100, 'EMP0016', 'login', '', '86.106.87.92', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-19 06:00:25'),
(101, 'EMP0016', 'login', '', '86.106.87.92', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-19 06:00:25'),
(102, 'EMP0016', 'login', '', '198.44.131.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-20 06:13:06'),
(103, 'EMP0016', 'login', '', '198.44.131.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-21 05:12:13'),
(104, 'EMP0016', 'login', '', '198.44.131.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-23 05:21:29'),
(105, 'EMP0016', 'login', '28.603427120742463,77.05655007262105', '2405:201:4031:3147:5419:92c1:19b1:8013', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-23 13:34:52'),
(106, 'EMP0016', 'login', '28.603426370670164,77.05654258957459', '146.70.250.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-24 05:12:49'),
(107, 'EMP0016', 'login', '28.62935642746356,77.05032044177374', '38.95.111.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-25 10:32:39'),
(108, 'ADMIN001', 'login', '', '49.36.191.22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-26 06:33:20'),
(109, 'ADMIN001', 'login', '', '103.112.17.223', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-27 05:33:35'),
(110, 'EMP0016', 'login', '28.603424510186525,77.05654816983015', '2401:4900:1c46:84f0:a868:a49f:ec89:776d', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-27 05:39:22'),
(111, 'EMP0016', 'login', '28.603424510186525,77.05654816983015', '38.95.111.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-27 05:39:25'),
(112, 'EMP0016', 'login', '28.603424510186525,77.05654816983015', '38.95.111.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-27 05:39:25'),
(113, 'EMP0016', 'login', '28.62932490041869,77.05038083937761', '38.95.111.135', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-28 06:19:45'),
(114, 'EMP0016', 'login', '', '103.141.91.111', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-28 13:31:38'),
(115, 'EMP0016', 'login', '', '110.235.234.242', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-03 17:54:40'),
(116, 'ADMIN001', 'login', '', '182.69.146.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-05 04:58:57'),
(117, 'EMP0016', 'login', '', '2405:201:4031:39ad:c16:a2c2:c8fa:e7f8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-05 13:32:03'),
(118, 'EMP0016', 'login', '28.603424118254903,77.05654686429229', '2405:201:4031:39ad:6961:fe81:5b79:9a4a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-06 06:05:34'),
(119, 'EMP0016', 'login', '28.603424118254903,77.05654686429229', '2405:201:4031:39ad:6961:fe81:5b79:9a4a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-06 06:05:35'),
(120, 'EMP0016', 'login', '28.603424118254903,77.05654686429229', '2405:201:4031:39ad:6961:fe81:5b79:9a4a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-06 06:05:35'),
(121, 'EMP0016', 'login', '28.603424118254903,77.05654686429229', '2405:201:4031:39ad:6961:fe81:5b79:9a4a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-06 06:05:36'),
(122, 'Admin001', 'login', 'Location denied', '2401:4900:5fc5:e340::22a:9ddf', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-06 14:09:37'),
(123, 'Admin001', 'login', 'Location denied', '2401:4900:30e6:68a:0:6c:7cd:d401', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-07 15:01:35'),
(124, 'EMP0016', 'login', '', '135.136.3.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-09 06:36:04'),
(125, 'Admin001', 'login', 'Location denied', '2401:4900:5ae5:e2d5::23d:9913', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-09 07:01:03'),
(126, 'ADMIN001', 'logout', 'Unknown', '2401:4900:5ae5:e2d5::23d:9913', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-09 07:03:14'),
(127, 'EMP0016', 'login', '', '38.95.111.158', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-09 11:23:37'),
(128, 'EMP0016', 'login', '', '38.95.111.158', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-09 11:23:37'),
(129, 'EMP0016', 'login', '', '2405:201:4031:3874:dd52:e252:ed78:a3f4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 05:13:03'),
(130, 'EMP0016', 'login', '', '103.134.114.187', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 17:56:28'),
(131, 'EMP0016', 'login', '', '2401:4900:1c48:c9d0:ed7b:2861:69d3:b4ab', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 05:06:39'),
(132, 'EMP0016', 'login', '', '198.44.131.178', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 13:25:18'),
(133, 'EMP0016', 'login', '', '198.44.131.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 05:23:55'),
(134, 'ADMIN001', 'login', '', '223.184.152.164', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 05:50:47'),
(135, 'EMP0016', 'login', '', '67.213.208.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 13:35:44'),
(136, 'EMP0016', 'login', '', '66.232.126.81', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-13 13:26:07'),
(137, 'EMP0016', 'login', 'Location denied', '149.102.226.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-16 04:53:49'),
(138, 'ADMIN001', 'login', '', '2401:4900:1c46:ead2:e877:c71f:67e5:afe2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-16 05:21:57'),
(139, 'EMP0016', 'login', '28.6034411006594,77.05652753987498', '162.43.191.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-16 07:38:13'),
(140, 'ADMIN001', 'login', 'Location denied', '2401:4900:1c48:56:e843:dc35:9378:ebe7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-17 09:07:25'),
(141, 'EMP0016', 'login', '28.603423517305124,77.0565573424506', '2401:4900:1c48:61e4:e5d6:9f10:30c6:576', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-18 06:59:25'),
(142, 'ADMIN001', 'login', 'Location denied', '182.69.156.92', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-13 07:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `check_in_time` datetime DEFAULT NULL,
  `check_out_time` datetime DEFAULT NULL,
  `check_in_photo` varchar(255) DEFAULT NULL,
  `check_in_location` varchar(255) DEFAULT NULL,
  `check_out_photo` varchar(255) DEFAULT NULL,
  `check_out_location` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('present','absent','late') DEFAULT 'present',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `check_in_time`, `check_out_time`, `check_in_photo`, `check_in_location`, `check_out_photo`, `check_out_location`, `date`, `status`, `created_at`) VALUES
(2, 'EMP0001', '2026-01-08 11:48:01', '2026-01-08 17:39:08', 'EMP0001_checkin_20260108_114801.jpg', NULL, 'EMP0001_checkout_20260108_173908.jpg', NULL, '2026-01-08', 'present', '2026-01-08 11:48:01'),
(3, 'EMP0002', '2026-01-08 13:16:41', '2026-01-08 17:37:16', 'EMP0002_checkin_20260108_131641.jpg', NULL, 'EMP0002_checkout_20260108_173716.jpg', NULL, '2026-01-08', 'present', '2026-01-08 13:16:41'),
(4, 'EMP0001', '2026-01-09 04:30:34', '2026-01-09 15:15:57', 'EMP0001_checkin_20260109_043034.jpg', NULL, 'EMP0001_checkout_20260109_151557.jpg', NULL, '2026-01-09', 'present', '2026-01-09 04:30:34'),
(5, 'EMP0005', '2026-01-09 04:34:25', NULL, 'EMP0005_checkin_20260109_043425.jpg', NULL, NULL, NULL, '2026-01-09', 'present', '2026-01-09 04:34:25'),
(6, 'EMP0004', '2026-01-09 04:38:23', NULL, 'EMP0004_checkin_20260109_043823.jpg', NULL, NULL, NULL, '2026-01-09', 'present', '2026-01-09 04:38:23'),
(7, 'EMP0006', '2026-01-09 04:42:22', NULL, 'EMP0006_checkin_20260109_044222.jpg', NULL, NULL, NULL, '2026-01-09', 'present', '2026-01-09 04:42:22'),
(8, 'EMP0007', '2026-01-09 04:45:55', '2026-01-09 04:46:05', 'EMP0007_checkin_20260109_044555.jpg', NULL, 'EMP0007_checkout_20260109_044605.jpg', NULL, '2026-01-09', 'present', '2026-01-09 04:45:55'),
(9, 'EMP0008', '2026-01-09 04:54:14', NULL, 'EMP0008_checkin_20260109_045414.jpg', NULL, NULL, NULL, '2026-01-09', 'present', '2026-01-09 04:54:14'),
(10, 'EMP0010', '2026-01-09 04:56:46', NULL, 'EMP0010_checkin_20260109_045646.jpg', NULL, NULL, NULL, '2026-01-09', 'present', '2026-01-09 04:56:46'),
(11, 'EMP0009', '2026-01-09 04:57:17', NULL, 'EMP0009_checkin_20260109_045717.jpg', NULL, NULL, NULL, '2026-01-09', 'present', '2026-01-09 04:57:17'),
(12, 'EMP0011', '2026-01-09 04:58:13', '2026-01-09 13:31:31', 'EMP0011_checkin_20260109_045813.jpg', NULL, 'EMP0011_checkout_20260109_133131.jpg', NULL, '2026-01-09', 'present', '2026-01-09 04:58:13'),
(13, 'EMP0012', '2026-01-09 05:04:18', '2026-01-09 05:07:19', 'EMP0012_checkin_20260109_050418.jpg', NULL, 'EMP0012_checkout_20260109_050719.jpg', NULL, '2026-01-09', 'present', '2026-01-09 05:04:18'),
(14, 'EMP0013', '2026-01-09 05:09:25', NULL, 'EMP0013_checkin_20260109_050925.jpg', NULL, NULL, NULL, '2026-01-09', 'present', '2026-01-09 05:09:25'),
(15, 'EMP0014', '2026-01-09 05:11:53', '2026-01-09 05:12:03', 'EMP0014_checkin_20260109_051153.jpg', NULL, 'EMP0014_checkout_20260109_051203.jpg', NULL, '2026-01-09', 'present', '2026-01-09 05:11:53'),
(16, 'EMP0015', '2026-01-09 14:28:25', NULL, 'EMP0015_checkin_20260109_142825.jpg', NULL, NULL, NULL, '2026-01-09', 'present', '2026-01-09 14:28:25'),
(17, 'EMP0011', '2026-01-10 04:50:09', '2026-01-10 13:34:08', 'EMP0011_checkin_20260110_045009.jpg', NULL, 'EMP0011_checkout_20260110_133408.jpg', NULL, '2026-01-10', 'present', '2026-01-10 04:50:09'),
(18, 'EMP0001', '2026-01-10 05:29:03', '2026-01-10 15:48:58', 'EMP0001_checkin_20260110_052903.jpg', NULL, 'EMP0001_checkout_20260110_154858.jpg', NULL, '2026-01-10', 'present', '2026-01-10 05:29:03'),
(19, 'EMP0005', '2026-01-10 09:51:35', '2026-01-10 13:26:55', 'EMP0005_checkin_20260110_095135.jpg', NULL, 'EMP0005_checkout_20260110_132655.jpg', NULL, '2026-01-10', 'present', '2026-01-10 09:51:35'),
(20, 'EMP0012', '2026-01-10 10:31:05', NULL, 'EMP0012_checkin_20260110_103105.jpg', NULL, NULL, NULL, '2026-01-10', 'present', '2026-01-10 10:31:05'),
(21, 'EMP0001', '2026-01-11 12:01:20', NULL, 'EMP0001_checkin_20260111_120120.jpg', NULL, NULL, NULL, '2026-01-11', 'present', '2026-01-11 12:01:20'),
(22, 'EMP0001', '2026-01-12 05:49:39', NULL, 'EMP0001_checkin_20260112_054939.jpg', NULL, NULL, NULL, '2026-01-12', 'present', '2026-01-12 05:49:39'),
(23, 'EMP0001', '2026-01-13 08:48:23', '2026-01-13 10:00:22', 'EMP0001_checkin_20260113_084823.jpg', NULL, 'EMP0001_checkout_20260113_100022.jpg', NULL, '2026-01-13', 'present', '2026-01-13 08:48:23'),
(24, 'EMP0002', '2026-01-13 09:56:46', NULL, 'EMP0002_checkin_20260113_095646.jpg', '28.603408780382395,77.05652458301952', NULL, NULL, '2026-01-13', 'present', '2026-01-13 09:56:46'),
(25, 'EMP0011', '2026-01-14 04:52:53', '2026-01-14 13:33:09', 'EMP0011_checkin_20260114_045253.jpg', '28.6034944,77.0566408', 'EMP0011_checkout_20260114_133309.jpg', '28.603519,77.0566538', '2026-01-14', 'present', '2026-01-14 04:52:53'),
(26, 'EMP0001', '2026-01-14 10:08:41', NULL, 'EMP0001_checkin_20260114_100841.jpg', NULL, NULL, NULL, '2026-01-14', 'present', '2026-01-14 10:08:41'),
(27, 'EMP0011', '2026-01-17 04:49:53', NULL, 'EMP0011_checkin_20260117_044953.jpg', '28.6034826,77.0566342', NULL, NULL, '2026-01-17', 'present', '2026-01-17 04:49:53'),
(28, 'EMP0011', '2026-01-19 04:56:03', NULL, 'EMP0011_checkin_20260119_045603.jpg', '28.6035114,77.0566303', NULL, NULL, '2026-01-19', 'present', '2026-01-19 04:56:03'),
(29, 'EMP0016', '2026-01-19 09:19:34', '2026-01-19 17:06:31', 'EMP0016_checkin_20260119_091934.jpg', '28.629461386300136,77.05043355848974', 'EMP0016_checkout_20260119_170631.jpg', '28.629437394848896,77.05033205734034', '2026-01-19', 'present', '2026-01-19 09:19:34'),
(30, 'EMP0001', '2026-01-19 15:10:12', NULL, 'EMP0001_checkin_20260119_151012.jpg', NULL, NULL, NULL, '2026-01-19', 'present', '2026-01-19 09:40:12'),
(31, 'EMP0016', '2026-01-20 10:23:31', '2026-01-20 19:02:18', 'EMP0016_checkin_20260120_102331.jpg', '28.603426,77.056348', 'EMP0016_checkout_20260120_190218.jpg', '28.603397805016897,77.05649706173278', '2026-01-20', 'present', '2026-01-20 04:53:31'),
(32, 'EMP0001', '2026-01-20 11:18:53', NULL, 'EMP0001_checkin_20260120_111853.jpg', NULL, NULL, NULL, '2026-01-20', 'present', '2026-01-20 05:48:53'),
(33, 'EMP0016', '2026-01-21 10:34:26', '2026-01-21 18:59:12', 'EMP0016_checkin_20260121_103426.jpg', '28.603420655579402,77.05649109399141', 'EMP0016_checkout_20260121_185912.jpg', '28.603397805016897,77.05649706173278', '2026-01-21', 'present', '2026-01-21 05:04:26'),
(34, 'EMP0016', '2026-01-22 10:35:10', NULL, 'EMP0016_checkin_20260122_103510.jpg', '28.603405258379947,77.05651476697025', NULL, NULL, '2026-01-22', 'present', '2026-01-22 05:05:10'),
(35, 'EMP0016', '2026-01-23 12:46:41', '2026-01-23 19:04:21', 'EMP0016_checkin_20260123_124641.jpg', '28.603420655579402,77.05649109399141', 'EMP0016_checkout_20260123_190421.jpg', '28.603397805016897,77.05649706173278', '2026-01-23', 'present', '2026-01-23 07:16:41'),
(36, 'EMP0016', '2026-01-24 16:03:08', '2026-01-24 18:58:46', 'EMP0016_checkin_20260124_160308.jpg', '28.603420462446667,77.05650815301664', 'EMP0016_checkout_20260124_185846.jpg', '28.603398060046544,77.05654117473631', '2026-01-24', 'present', '2026-01-24 10:33:08'),
(37, 'EMP0016', '2026-01-26 14:18:31', '2026-01-26 19:54:32', 'EMP0016_checkin_20260126_141831.jpg', '28.629388879750294,77.050251101251', 'EMP0016_checkout_20260126_195432.jpg', '28.62943494554559,77.05021111659443', '2026-01-26', 'present', '2026-01-26 08:48:31'),
(38, 'EMP0016', '2026-01-27 11:19:29', '2026-01-27 19:00:20', 'EMP0016_checkin_20260127_111929.jpg', '28.60338211570695,77.05653710300082', 'EMP0016_checkout_20260127_190020.jpg', '28.6034155,77.056541', '2026-01-27', 'present', '2026-01-27 05:49:29'),
(39, 'EMP0016', '2026-01-28 10:34:47', NULL, 'EMP0016_checkin_20260128_103447.jpg', '28.603397805016897,77.05649706173278', NULL, NULL, '2026-01-28', 'present', '2026-01-28 05:04:47'),
(40, 'EMP0016', '2026-01-29 11:12:33', '2026-01-29 21:46:13', 'EMP0016_checkin_20260129_111233.jpg', '28.603397805016897,77.05649706173278', 'EMP0016_checkout_20260129_214613.jpg', '28.628813,77.049286', '2026-01-29', 'present', '2026-01-29 05:42:33'),
(41, 'EMP0016', '2026-01-30 10:57:38', '2026-01-30 19:18:39', 'EMP0016_checkin_20260130_105738.jpg', '28.603496270488794,77.0565944641676', 'EMP0016_checkout_20260130_191839.jpg', '28.603418,77.056549', '2026-01-30', 'present', '2026-01-30 05:27:38'),
(42, 'EMP0016', '2026-01-31 12:14:08', '2026-01-31 22:16:53', 'EMP0016_checkin_20260131_121408.jpg', '28.629206,77.050232', 'EMP0016_checkout_20260131_221653.jpg', '28.629469830869308,77.05064255514488', '2026-01-31', 'present', '2026-01-31 06:44:08'),
(43, 'EMP0001', '2026-02-01 12:53:44', NULL, 'EMP0001_checkin_20260201_125344.jpg', '30.8558901,75.904804', NULL, NULL, '2026-02-01', 'present', '2026-02-01 07:23:44'),
(44, 'EMP0016', '2026-02-02 11:52:20', '2026-02-02 20:14:53', 'EMP0016_checkin_20260202_115220.jpg', '28.629384775708125,77.05049009510378', 'EMP0016_checkout_20260202_201453.jpg', '28.629544252787483,77.05034127066394', '2026-02-02', 'present', '2026-02-02 06:22:20'),
(45, 'EMP0016', '2026-02-03 13:35:28', '2026-02-03 18:58:57', 'EMP0016_checkin_20260203_133528.jpg', '28.603418,77.056549', 'EMP0016_checkout_20260203_185857.jpg', '28.603418,77.056549', '2026-02-03', 'present', '2026-02-03 08:05:28'),
(46, 'EMP0016', '2026-02-04 11:32:10', '2026-02-04 19:06:57', 'EMP0016_checkin_20260204_113210.jpg', NULL, 'EMP0016_checkout_20260204_190657.jpg', '28.603425359209844,77.05653437072993', '2026-02-04', 'present', '2026-02-04 06:02:10'),
(47, 'EMP0016', '2026-02-05 11:04:53', '2026-02-05 19:02:59', 'EMP0016_checkin_20260205_110453.jpg', '28.603428499321428,77.056549', 'EMP0016_checkout_20260205_190259.jpg', '28.603431003958796,77.05654899999999', '2026-02-05', 'present', '2026-02-05 05:34:53'),
(48, 'EMP0016', '2026-02-06 14:27:01', NULL, 'EMP0016_checkin_20260206_142701.jpg', '28.603431003958796,77.05654899999999', NULL, NULL, '2026-02-06', 'present', '2026-02-06 08:57:01'),
(49, 'EMP0016', '2026-02-08 15:28:27', NULL, 'EMP0016_checkin_20260208_152827.jpg', '28.628376471298314,77.04880645986628', NULL, NULL, '2026-02-08', 'present', '2026-02-08 09:58:27'),
(50, 'EMP0016', '2026-02-09 11:46:39', '2026-02-09 19:02:57', 'EMP0016_checkin_20260209_114639.jpg', '28.60343278186473,77.0565601150551', 'EMP0016_checkout_20260209_190257.jpg', '28.603480985187424,77.056601475828', '2026-02-09', 'present', '2026-02-09 06:16:39'),
(51, 'EMP0016', '2026-02-10 11:35:56', '2026-02-10 19:02:15', 'EMP0016_checkin_20260210_113556.jpg', '28.603431003958796,77.05654899999999', 'EMP0016_checkout_20260210_190215.jpg', '28.603431003958796,77.05654899999999', '2026-02-10', 'present', '2026-02-10 06:05:56'),
(52, 'EMP0016', '2026-02-11 11:21:24', '2026-02-11 18:57:53', 'EMP0016_checkin_20260211_112124.jpg', '28.603428499321428,77.056549', 'EMP0016_checkout_20260211_185753.jpg', '28.603431003958796,77.05654899999999', '2026-02-11', 'present', '2026-02-11 05:51:24'),
(53, 'EMP0016', '2026-02-12 15:43:49', NULL, 'EMP0016_checkin_20260212_154349.jpg', '28.6034247251444,77.05654224647944', NULL, NULL, '2026-02-12', 'present', '2026-02-12 10:13:49'),
(54, 'EMP0016', '2026-02-13 11:44:28', '2026-02-13 19:04:57', 'EMP0016_checkin_20260213_114428.jpg', '28.603422348243814,77.05654003703833', 'EMP0016_checkout_20260213_190457.jpg', '28.60342448470112,77.0565336576466', '2026-02-13', 'present', '2026-02-13 06:14:28'),
(55, 'EMP0016', '2026-02-14 11:23:42', '2026-02-14 19:04:51', 'EMP0016_checkin_20260214_112342.jpg', '28.603425804334073,77.05654192929286', 'EMP0016_checkout_20260214_190451.jpg', '28.60348575115786,77.05635864557519', '2026-02-14', 'present', '2026-02-14 05:53:42'),
(56, 'EMP0016', '2026-02-16 11:03:11', '2026-02-16 19:00:21', 'EMP0016_checkin_20260216_110311.jpg', '28.603427496328678,77.05653466100875', 'EMP0016_checkout_20260216_190021.jpg', '28.603407357499897,77.05644305043904', '2026-02-16', 'present', '2026-02-16 05:33:11'),
(57, 'EMP0016', '2026-02-17 11:24:54', NULL, 'EMP0016_checkin_20260217_112454.jpg', '28.60342210090898,77.05654344492415', NULL, NULL, '2026-02-17', 'present', '2026-02-17 05:54:54'),
(58, 'EMP0016', '2026-02-18 11:32:44', '2026-02-18 19:00:56', 'EMP0016_checkin_20260218_113244.jpg', '28.603398525309938,77.05646207492968', 'EMP0016_checkout_20260218_190056.jpg', '28.60342212434853,77.05654042716776', '2026-02-18', 'present', '2026-02-18 06:02:44'),
(59, 'EMP0016', '2026-02-19 11:30:51', NULL, 'EMP0016_checkin_20260219_113051.jpg', '28.60342346094053,77.05653466426965', NULL, NULL, '2026-02-19', 'present', '2026-02-19 06:00:51'),
(60, 'EMP0016', '2026-02-20 11:43:38', '2026-02-20 19:01:24', 'EMP0016_checkin_20260220_114338.jpg', '28.6034222629292,77.05654391885331', 'EMP0016_checkout_20260220_190124.jpg', '28.60342212434853,77.05654042716776', '2026-02-20', 'present', '2026-02-20 06:13:38'),
(61, 'EMP0016', '2026-02-21 10:42:25', '2026-02-21 19:04:35', 'EMP0016_checkin_20260221_104225.jpg', '28.60342483743057,77.05653668131322', 'EMP0016_checkout_20260221_190435.jpg', '28.6034247251444,77.05654224647944', '2026-02-21', 'present', '2026-02-21 05:12:25'),
(62, 'EMP0016', '2026-02-23 10:51:53', '2026-02-23 19:05:23', 'EMP0016_checkin_20260223_105153.jpg', '28.603422406803215,77.05654163498382', 'EMP0016_checkout_20260223_190523.jpg', '28.603427120742463,77.05655007262105', '2026-02-23', 'present', '2026-02-23 05:21:53'),
(63, 'EMP0016', '2026-02-24 10:43:23', NULL, 'EMP0016_checkin_20260224_104323.jpg', '28.603425562413005,77.0565433610553', NULL, NULL, '2026-02-24', 'present', '2026-02-24 05:13:23'),
(64, 'EMP0016', '2026-02-25 16:03:07', NULL, 'EMP0016_checkin_20260225_160307.jpg', '28.629468833230717,77.05049021941245', NULL, NULL, '2026-02-25', 'present', '2026-02-25 10:33:07'),
(65, 'EMP0016', '2026-02-26 10:56:27', '2026-02-26 18:57:40', 'EMP0016_checkin_20260226_105627.jpg', '28.60344533576796,77.05656204788275', 'EMP0016_checkout_20260226_185740.jpg', '28.6034251049096,77.05649285716386', '2026-02-26', 'present', '2026-02-26 05:26:27'),
(66, 'EMP0016', '2026-02-27 11:09:39', '2026-02-27 18:57:43', 'EMP0016_checkin_20260227_110939.jpg', '28.603424510186525,77.05654816983015', 'EMP0016_checkout_20260227_185743.jpg', '28.603423973086265,77.0565430057872', '2026-02-27', 'present', '2026-02-27 05:39:39'),
(67, 'EMP0016', '2026-02-28 11:50:07', '2026-02-28 19:01:50', 'EMP0016_checkin_20260228_115007.jpg', '28.62934775051977,77.0503882336328', 'EMP0016_checkout_20260228_190150.jpg', '28.629373720034184,77.0503273855838', '2026-02-28', 'present', '2026-02-28 06:20:07'),
(68, 'EMP0016', '2026-03-02 12:06:44', '2026-03-02 18:55:27', 'EMP0016_checkin_20260302_120644.jpg', '28.629140943456346,77.04993807216408', 'EMP0016_checkout_20260302_185527.jpg', '28.629113049087383,77.04999421700032', '2026-03-02', 'present', '2026-03-02 06:36:44'),
(69, 'EMP0016', '2026-03-03 23:25:03', '2026-03-03 23:25:09', 'EMP0016_checkin_20260303_232503.jpg', '28.628386789187353,77.04923237606256', 'EMP0016_checkout_20260303_232509.jpg', '28.628386789187353,77.04923237606256', '2026-03-03', 'present', '2026-03-03 17:55:03'),
(70, 'EMP0016', '2026-03-05 10:08:25', '2026-03-05 19:02:23', 'EMP0016_checkin_20260305_100825.jpg', '28.603424,77.056541', 'EMP0016_checkout_20260305_190223.jpg', '28.603424069506275,77.05654266796222', '2026-03-05', 'present', '2026-03-05 04:38:25'),
(71, 'EMP0016', '2026-03-06 11:36:15', NULL, 'EMP0016_checkin_20260306_113615.jpg', '28.603422093805225,77.05654477280746', NULL, NULL, '2026-03-06', 'present', '2026-03-06 06:06:15'),
(72, 'EMP0016', '2026-03-09 12:06:19', '2026-03-09 19:00:18', 'EMP0016_checkin_20260309_120619.jpg', '28.60341843874554,77.05654648933184', 'EMP0016_checkout_20260309_190018.jpg', '28.60342583122813,77.05655230569447', '2026-03-09', 'present', '2026-03-09 06:36:19'),
(73, 'EMP0016', '2026-03-10 10:43:36', NULL, 'EMP0016_checkin_20260310_104336.jpg', '28.603424578651733,77.05654986873368', NULL, NULL, '2026-03-10', 'present', '2026-03-10 05:13:36'),
(74, 'EMP0016', '2026-03-11 10:37:02', '2026-03-11 18:56:58', 'EMP0016_checkin_20260311_103702.jpg', '28.603423117372795,77.05653438916572', 'EMP0016_checkout_20260311_185658.jpg', '28.603441604096012,77.05655202507153', '2026-03-11', 'present', '2026-03-11 05:07:02'),
(75, 'EMP0016', '2026-03-12 10:54:04', '2026-03-12 19:06:08', 'EMP0016_checkin_20260312_105404.jpg', '28.603452751707298,77.05656187848938', 'EMP0016_checkout_20260312_190608.jpg', '28.60342708285789,77.05655192695384', '2026-03-12', 'present', '2026-03-12 05:24:04'),
(76, 'EMP0016', '2026-03-13 18:56:30', NULL, 'EMP0016_checkin_20260313_185630.jpg', NULL, NULL, NULL, '2026-03-13', 'present', '2026-03-13 13:26:30'),
(77, 'EMP0016', '2026-03-16 10:24:03', NULL, 'EMP0016_checkin_20260316_102403.jpg', NULL, NULL, NULL, '2026-03-16', 'present', '2026-03-16 04:54:03'),
(78, 'EMP0016', '2026-03-18 12:29:51', '2026-03-18 18:56:00', 'EMP0016_checkin_20260318_122951.jpg', '28.603420434773998,77.05651039976965', 'EMP0016_checkout_20260318_185600.jpg', '28.603429312267657,77.05655471003718', '2026-03-18', 'present', '2026-03-18 06:59:51');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `leave_type` enum('sick','casual','annual','emergency') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `admin_comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employee_id`, `leave_type`, `start_date`, `end_date`, `reason`, `status`, `admin_comment`, `created_at`) VALUES
(1, 'EMP0001', 'emergency', '2026-01-09', '2026-01-09', 'Going To Morket', 'approved', NULL, '2026-01-08 09:43:45'),
(2, 'EMP0002', 'emergency', '2026-01-10', '2026-01-12', 'an emargency ', 'approved', NULL, '2026-01-08 13:18:56'),
(3, 'EMP0001', 'emergency', '2026-01-16', '2026-01-16', 'An emergency ????????????????????', 'rejected', NULL, '2026-01-08 14:31:39'),
(4, 'EMP0005', 'emergency', '2026-01-10', '2026-01-10', 'An Emergency', 'approved', NULL, '2026-01-09 04:35:20'),
(5, 'EMP0004', 'emergency', '2026-01-13', '2026-01-13', 'MERI MRZI', 'approved', NULL, '2026-01-09 04:39:35'),
(6, 'EMP0001', 'emergency', '2026-01-13', '2026-01-15', 'Amjbd', 'approved', NULL, '2026-01-11 12:01:59'),
(7, 'EMP0016', 'emergency', '2026-01-19', '2026-01-19', 'Fever', 'approved', NULL, '2026-01-19 09:22:49'),
(8, 'EMP0016', 'sick', '2026-03-18', '2026-03-19', 'pet dafrd', 'pending', NULL, '2026-03-16 07:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `live_streams`
--

CREATE TABLE `live_streams` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `is_streaming` tinyint(1) DEFAULT 0,
  `last_update` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `live_streams`
--

INSERT INTO `live_streams` (`id`, `employee_id`, `is_streaming`, `last_update`) VALUES
(1, 'EMP0001', 1, '2026-01-08 12:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `salary_slips`
--

CREATE TABLE `salary_slips` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `month` varchar(7) DEFAULT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  `allowances` decimal(10,2) DEFAULT NULL,
  `deductions` decimal(10,2) DEFAULT NULL,
  `net_salary` decimal(10,2) DEFAULT NULL,
  `generated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_slips`
--

INSERT INTO `salary_slips` (`id`, `employee_id`, `month`, `basic_salary`, `allowances`, `deductions`, `net_salary`, `generated_at`) VALUES
(2, 'EMP0001', '2026-01', 55000.00, 11000.00, 5500.00, 60500.00, '2026-01-08 12:02:38'),
(3, 'EMP0002', '2026-01', 500000.00, 100000.00, 50000.00, 550000.00, '2026-01-08 13:20:58'),
(4, 'EMP0004', '2026-01', 55000.00, 11000.00, 5500.00, 60500.00, '2026-01-09 04:40:51'),
(5, 'EMP0012', '2026-01', 8000.00, 1600.00, 800.00, 8800.00, '2026-01-10 10:35:38'),
(6, 'EMP0016', '2026-02', 20000.00, 4000.00, 2000.00, 22000.00, '2026-02-08 16:58:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `role` enum('employee','admin') DEFAULT 'employee',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `name`, `email`, `password`, `phone`, `department`, `position`, `salary`, `join_date`, `profile_image`, `role`, `status`, `created_at`) VALUES
(1, 'ADMIN001', 'System Admin', 'admin@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 'active', '2026-01-08 08:20:27'),
(2, 'EMP0001', 'Raj', 'rajexpert36@gmail.com', '$2y$10$7ulZvN8s.ClMMRcPwEBYHuc4XucV7QsueTLsRiXvnh7lAQ7IGZHaO', '7388760604', 'IT', 'Developer', 55000.00, '2025-01-15', 'EMP0001.PNG', 'employee', 'active', '2026-01-08 08:24:37'),
(3, 'EMP0002', 'Dhiraj Kumar', 'kumar2dhiraj1995@gmail.com', '$2y$10$V.sX2nYu/GdnS72OFUTSNuM1Gx5/ipr64C.aS7AjjZbAI.9kghmPi', '8083821946', 'SEO', 'SEO TL', 500000.00, '2024-06-15', 'EMP0002.jpeg', 'employee', 'active', '2026-01-08 13:15:02'),
(4, 'EMP0003', 'MARTIN LOOK', 'hennerymat@gmail.com', '$2y$10$4/ch2Wh0aaafon6OundLf.ovjWsZQicTVIJZW3x1qBNKzenMKSUDq', '8178674551', 'IT', 'seo', NULL, '2024-09-02', 'EMP0003.png', 'employee', 'active', '2026-01-08 13:31:35'),
(5, 'EMP0004', 'sakshi', 'nancyoliva241@gmail.com', '$2y$10$upp380HnmWcY5G/pd4tzJ..AanQdf10y5EgPOUEupDdn7UIeJxaa.', '9315343410', 'IT', 'seo', 55000.00, '2024-09-02', 'EMP0004.jfif', 'employee', 'active', '2026-01-08 13:31:43'),
(6, 'EMP0005', 'deepak', 'deepakkum62022@gmail.com', '$2y$10$XYtdchKXpAmAXINd1W/EMuEb/RKEIEp2fY4a0MHR/rugpSSNK1c1u', '620240835', 'IT', 'SEO', NULL, '2025-05-22', 'EMP0005.jpg', 'employee', 'active', '2026-01-09 04:31:52'),
(7, 'EMP0006', 'Lucky', 'luckyprajapati.001d@gmail.com', '$2y$10$U2vmrindq1SXAlHFe/5CvOleL3alW/IL/gKM9fKoLnQwEveX.wPFO', '8882952514', 'IT', 'SEO', NULL, '2025-07-16', 'EMP0006.jpg', 'employee', 'active', '2026-01-09 04:40:10'),
(8, 'EMP0007', 'Simran', 'anjukumarixyz92@gmail.com', '$2y$10$8Sn3yN/jrh4orHU20CztN.oogunBFieLDZBgYLLvbnBb27.VbM1d6', '09818767409', 'Marketing', 'Seo', NULL, '2025-09-17', 'EMP0007.jpg', 'employee', 'active', '2026-01-09 04:45:07'),
(9, 'EMP0008', 'Mohd waris ', 'mdwaris4768@gmail.com', '$2y$10$p6GzM7ODIt.Sc2RE3gJaeu8DCV0qSqkE8xvOPSTzxDR3tLAX20U5q', '8700186557', 'IT', 'Seo', NULL, '2025-12-19', 'EMP0008.jpg', 'employee', 'active', '2026-01-09 04:53:33'),
(10, 'EMP0009', 'Krishna Moorthy', 'aurthurmorgan5000@gmail.com', '$2y$10$5EfVaApvXBBDbTFP8e2O4O7Xl/UAiqaAJqHPtHRpE.axvutOK2z9K', '8585959236', 'IT', 'SEO EXECUTIVE ', NULL, '2025-05-19', 'EMP0009.jpg', 'employee', 'active', '2026-01-09 04:55:06'),
(11, 'EMP0010', 'Ashish ', 'ashish31may2006@gmail.com', '$2y$10$DxTO.bz4GU4sxi0LYziKx.t84P8/jp4TX3itDQF0Q34WOQktZ2rgu', '8447427988', 'IT', 'SEO', NULL, '2025-12-19', 'EMP0010.jpg', 'employee', 'active', '2026-01-09 04:55:50'),
(12, 'EMP0011', 'Deepanshu', 'deept2239@gmail.com', '$2y$10$hEVRHwlaeE5WLfgb0hXE2OqxoFzOkJmjmLN7ccFI2K6PwJFxDD.e2', '8010089762', 'IT', 'SEO', NULL, '2026-01-06', 'EMP0011.jpg', 'employee', 'active', '2026-01-09 04:56:46'),
(13, 'EMP0012', 'Diksha', 'dishuk2004@gmail.com', '$2y$10$dvaDORVNb98rcT1WSO0FvOmpGE9taiORclS6qi06geKMFBQjCAvI2', '8587899057', 'IT', 'Seo', 8000.00, '2025-08-07', 'EMP0012.webp', 'employee', 'active', '2026-01-09 04:57:58'),
(14, 'EMP0013', 'Aradhna', 'kumariaradhna231@gmail.com', '$2y$10$oViXKh0h2zBY0iGSViFLHunefyrFyLFTnBQuWRTIbbwMaz3eppkky', '9266136647', 'IT', 'Seo', NULL, '2025-06-06', 'EMP0013.jpg', 'employee', 'active', '2026-01-09 05:08:35'),
(15, 'EMP0014', 'Jyoti kumari ', 'jyoti2007bhardwaj@gmail.com', '$2y$10$m.bGw8YzgPsRhE4xRSmznudgp6zKIBICUhSH50DBFEw88NoD6HXvS', '8920885712', 'IT', 'Seo ', NULL, '2025-12-24', 'EMP0014.jpg', 'employee', 'active', '2026-01-09 05:08:44'),
(16, 'EMP0015', 'Karl Fomer', 'fomerkarl@gmail.com', '$2y$10$YUuuQ1JAJKlyB2EkbtLE9.Ni/1racEONQRDgPjTuE0uM3CJVLcFq2', '1-866-323-6665', 'Marketing', 'seo ', NULL, '2025-12-31', 'EMP0015.jfif', 'employee', 'active', '2026-01-09 14:27:36'),
(17, 'EMP0016', 'Yashika', 'jamsyashika321@gmail.com', '$2y$10$XtL0i3.z/oEArQF0WWP1eudC5zqC2qCjdj3MhVZiG32I/38SiQJF6', '9654736628', 'Operations', 'Support', 20000.00, '2025-12-24', 'EMP0016.jpeg', 'employee', 'active', '2026-01-19 09:15:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `activity_type` (`activity_type`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `live_streams`
--
ALTER TABLE `live_streams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `salary_slips`
--
ALTER TABLE `salary_slips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `live_streams`
--
ALTER TABLE `live_streams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `salary_slips`
--
ALTER TABLE `salary_slips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`employee_id`);

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`employee_id`);

--
-- Constraints for table `live_streams`
--
ALTER TABLE `live_streams`
  ADD CONSTRAINT `live_streams_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`employee_id`);

--
-- Constraints for table `salary_slips`
--
ALTER TABLE `salary_slips`
  ADD CONSTRAINT `salary_slips_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

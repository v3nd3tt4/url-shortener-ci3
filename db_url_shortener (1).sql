-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2025 at 09:33 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_url_shortener`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'admin', '$2y$10$ZhC6Btl7MgjpwFbuZ7jACeoym1Ap7xtPds/Dw0GDKS1cZFInHYdgu', 'admin@example.com', '2025-07-20 03:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `click_logs`
--

CREATE TABLE `click_logs` (
  `id` int(11) NOT NULL,
  `url_id` int(11) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `clicked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `click_logs`
--

INSERT INTO `click_logs` (`id`, `url_id`, `ip_address`, `user_agent`, `referer`, `country`, `city`, `clicked_at`) VALUES
(4, 5, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'http://localhost/urlshortener/url/dashboard', NULL, NULL, '2025-07-20 05:51:26'),
(5, 6, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'http://localhost/urlshortener/url/dashboard', NULL, NULL, '2025-07-20 05:52:28'),
(6, 6, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', NULL, NULL, NULL, '2025-07-20 05:54:00'),
(7, 8, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'http://localhost/urlshortener/url/dashboard', NULL, NULL, '2025-07-20 06:12:55'),
(8, 8, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', NULL, NULL, NULL, '2025-07-20 06:13:17'),
(9, 9, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'http://localhost/urlshortener/', NULL, NULL, '2025-07-20 06:13:59'),
(11, 14, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'http://localhost/urlshortener/url/shorten', NULL, NULL, '2025-07-20 06:32:48'),
(13, 17, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'http://localhost/urlshortener/url/dashboard', NULL, NULL, '2025-07-20 06:40:55'),
(14, 23, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'http://localhost/urlshortener/url/dashboard', NULL, NULL, '2025-07-20 06:56:38'),
(15, 30, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'http://localhost/urlshortener/url/shorten', NULL, NULL, '2025-07-20 07:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `urls`
--

CREATE TABLE `urls` (
  `id` int(11) NOT NULL,
  `original_url` text NOT NULL,
  `short_code` varchar(20) NOT NULL,
  `custom_url` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `clicks` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `expired_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `urls`
--

INSERT INTO `urls` (`id`, `original_url`, `short_code`, `custom_url`, `title`, `description`, `clicks`, `is_active`, `expired_at`, `created_at`, `updated_at`, `ip_address`, `user_agent`) VALUES
(5, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'uo', 'uo', NULL, NULL, 1, 1, '2025-07-21 13:50:00', '2025-07-19 23:50:10', '2025-07-20 01:08:50', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(6, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'pilopa', 'pilopa', NULL, NULL, 2, 1, '2025-07-23 13:51:00', '2025-07-19 23:51:50', '2025-07-20 00:30:25', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(8, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'ggsgs', 'ggsgs', NULL, NULL, 2, 1, '2025-07-27 07:58:11', '2025-07-19 23:58:11', '2025-07-20 06:13:17', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(9, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'eb9f84', NULL, NULL, NULL, 1, 1, '2025-08-19 08:13:52', '2025-07-20 00:13:52', '2025-07-20 06:13:59', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(13, 'https://www.youtube.com/watch?v=tY5I0eFshRI', '2a6564', NULL, NULL, NULL, 0, 1, '2025-08-19 08:30:38', '2025-07-20 00:30:38', '2025-07-20 06:30:38', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(14, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'pembinaanKMA', 'pembinaanKMA', NULL, NULL, 1, 1, '2025-08-19 08:32:44', '2025-07-20 00:32:44', '2025-07-20 06:32:48', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(16, 'https://www.youtube.com/watch?v=tY5I0eFshRI', '782d33', NULL, NULL, NULL, 0, 1, '2025-08-19 08:39:10', '2025-07-20 00:39:10', '2025-07-20 06:39:10', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(17, 'https://www.youtube.com/watch?v=tY5I0eFshRI', '0fa1d5', NULL, NULL, NULL, 1, 1, '2025-08-19 08:39:15', '2025-07-20 00:39:15', '2025-07-20 06:40:55', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(19, 'https://yourls.org/docs/guide/install', 'LinkCoba', 'LinkCoba', NULL, NULL, 0, 1, '2025-08-19 08:42:00', '2025-07-20 00:42:48', '2025-07-20 00:48:37', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(20, 'https://yourls.org/docs/guide/install', 'f8c9f9', NULL, NULL, NULL, 0, 1, '2025-08-19 08:55:35', '2025-07-20 00:55:35', '2025-07-20 06:55:35', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(21, 'https://yourls.org/docs/guide/install', '5a227a', NULL, NULL, NULL, 0, 1, '2025-08-19 08:55:41', '2025-07-20 00:55:41', '2025-07-20 06:55:41', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(22, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'ii', 'ii', NULL, NULL, 0, 1, '2025-08-19 08:56:02', '2025-07-20 00:56:02', '2025-07-20 06:56:02', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(23, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'kkiif', 'kkiif', NULL, NULL, 1, 1, '2025-08-19 08:56:00', '2025-07-20 00:56:09', '2025-07-20 06:56:38', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(24, 'https://yourls.org/docs/guide/install', 'hh', 'hh', NULL, NULL, 0, 1, '2025-08-19 08:59:43', '2025-07-20 00:59:43', '2025-07-20 06:59:43', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(25, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'LinkCobadd', 'LinkCobadd', NULL, NULL, 0, 1, '2025-08-19 09:03:22', '2025-07-20 01:03:22', '2025-07-20 07:03:22', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(26, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'LinkCobaddff', 'LinkCobaddff', NULL, NULL, 0, 1, '2025-08-19 09:03:30', '2025-07-20 01:03:30', '2025-07-20 07:03:30', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(27, 'https://yourls.org/docs/guide/install', 'ebfb8a', NULL, NULL, NULL, 0, 1, '2025-08-19 09:05:15', '2025-07-20 01:05:15', '2025-07-20 07:05:15', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(28, 'https://www.youtube.com/watch?v=tY5I0eFshRI', '0e4412', NULL, NULL, NULL, 0, 1, '2025-08-19 09:05:41', '2025-07-20 01:05:41', '2025-07-20 07:05:41', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(29, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'c5c1b4', NULL, NULL, NULL, 0, 1, '2025-08-19 09:05:46', '2025-07-20 01:05:46', '2025-07-20 07:05:46', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(30, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'uuuu', 'uuuu', NULL, NULL, 1, 1, '2025-08-19 09:05:57', '2025-07-20 01:05:57', '2025-07-20 07:06:05', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(31, 'https://yourls.org/docs/guide/install', '91615c', NULL, NULL, NULL, 0, 1, '2025-08-19 09:06:26', '2025-07-20 01:06:26', '2025-07-20 07:06:26', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(32, 'https://yourls.org/docs/guide/install', 'e39cb7', NULL, NULL, NULL, 0, 1, '2025-08-19 09:10:51', '2025-07-20 01:10:51', '2025-07-20 07:10:51', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(33, 'https://yourls.org/docs/guide/install', 'd6fd01', NULL, NULL, NULL, 0, 1, '2025-08-19 09:10:54', '2025-07-20 01:10:54', '2025-07-20 07:10:54', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(34, 'https://yourls.org/docs/guide/install', '564c54', NULL, NULL, NULL, 0, 1, '2025-08-19 09:10:58', '2025-07-20 01:10:58', '2025-07-20 07:10:58', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(35, 'https://yourls.org/docs/guide/install', 'f49d69', NULL, NULL, NULL, 0, 1, '2025-08-19 09:11:02', '2025-07-20 01:11:02', '2025-07-20 07:11:02', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(36, 'https://www.youtube.com/watch?v=tY5I0eFshRI', '7faf13', NULL, NULL, NULL, 0, 1, '2025-08-19 09:11:31', '2025-07-20 01:11:31', '2025-07-20 07:11:31', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(37, 'https://www.youtube.com/watch?v=tY5I0eFshRI', 'c4ed9e', NULL, NULL, NULL, 0, 1, '2025-08-19 09:14:14', '2025-07-20 01:14:14', '2025-07-20 07:14:14', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(38, 'https://www.youtube.com/watch?v=tY5I0eFshRI', '387c13', NULL, NULL, NULL, 0, 1, '2025-08-19 09:16:29', '2025-07-20 01:16:29', '2025-07-20 07:16:29', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(39, 'https://yourls.org/docs/guide/install', '8a120a', NULL, NULL, NULL, 0, 1, '2025-08-19 09:32:37', '2025-07-20 01:32:37', '2025-07-20 07:32:37', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36'),
(40, 'https://yourls.org/docs/guide/install', 'cfe374', NULL, NULL, NULL, 0, 1, '2025-08-19 09:32:47', '2025-07-20 01:32:47', '2025-07-20 07:32:47', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `click_logs`
--
ALTER TABLE `click_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `url_id` (`url_id`);

--
-- Indexes for table `urls`
--
ALTER TABLE `urls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_code` (`short_code`),
  ADD UNIQUE KEY `custom_url` (`custom_url`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `click_logs`
--
ALTER TABLE `click_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `urls`
--
ALTER TABLE `urls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `click_logs`
--
ALTER TABLE `click_logs`
  ADD CONSTRAINT `click_logs_ibfk_1` FOREIGN KEY (`url_id`) REFERENCES `urls` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

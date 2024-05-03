-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 02, 2024 at 12:08 PM
-- Server version: 8.0.35-0ubuntu0.23.04.1
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm_tesst`
--

-- --------------------------------------------------------

--
-- Table structure for table `crm_celliers`
--

CREATE TABLE `crm_celliers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surface` double(8,3) DEFAULT NULL,
  `price` double(8,3) DEFAULT NULL,
  `client_id` bigint UNSIGNED DEFAULT NULL,
  `residence_id` bigint UNSIGNED DEFAULT NULL,
  `etage_id` bigint DEFAULT NULL,
  `appart_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crm_celliers`
--

INSERT INTO `crm_celliers` (`id`, `name`, `surface`, `price`, `client_id`, `residence_id`, `etage_id`, `appart_id`, `created_at`, `updated_at`) VALUES
(1, 'C 1', NULL, NULL, 46, 3, 12, 41, NULL, '2024-01-25 15:11:15'),
(2, 'NÂ° 6', NULL, NULL, NULL, 2, 0, 0, NULL, NULL),
(3, 'NÂ° 6', NULL, NULL, NULL, 2, 0, 0, NULL, NULL),
(4, 'C 2', NULL, NULL, 48, 3, 0, 0, NULL, '2024-01-05 14:06:27'),
(5, 'NÂ° 7', NULL, NULL, NULL, 2, 0, 0, NULL, NULL),
(6, 'NÂ° 7', NULL, NULL, NULL, 2, 0, 0, NULL, NULL),
(7, 'NÂ° 7', NULL, NULL, NULL, 2, 0, 0, NULL, NULL),
(8, 'NÂ° 7', NULL, NULL, NULL, 2, 0, 0, NULL, NULL),
(9, '01', NULL, NULL, NULL, 7, 0, 0, NULL, NULL),
(10, 'NÂ° 2', NULL, NULL, NULL, 7, 0, 0, NULL, NULL),
(11, 'NÂ° 1', NULL, NULL, NULL, 7, 0, 0, NULL, NULL),
(12, 'NÂ° 3', NULL, NULL, NULL, 7, 0, 0, NULL, NULL),
(13, 'NÂ° 5', NULL, NULL, NULL, 7, 0, 0, NULL, NULL),
(14, 'NÂ° 6', NULL, NULL, NULL, 7, 0, 0, NULL, NULL),
(15, 'NÂ° 7', NULL, NULL, NULL, 7, 0, 0, NULL, NULL),
(16, 'NÂ°9', NULL, NULL, NULL, 7, 0, 0, NULL, NULL),
(17, 'NÂ° 5', NULL, NULL, 113, 7, 0, 0, NULL, NULL),
(18, 'NÂ° 5', NULL, NULL, 113, 7, 0, 0, NULL, NULL),
(19, 'NÂ° 5', NULL, NULL, 113, 7, 0, 0, NULL, NULL),
(20, 'C 4', NULL, NULL, 52, 3, 0, 0, '2024-01-05 14:06:52', '2024-01-05 14:06:52'),
(22, 'C 3', NULL, NULL, 59, 3, 0, 0, '2024-01-05 14:07:14', '2024-01-05 14:07:14'),
(23, 'G 3', NULL, NULL, 47, 3, 0, 0, '2024-01-05 14:07:39', '2024-01-05 14:08:19'),
(24, 'G 2', NULL, NULL, 50, 3, 0, 0, '2024-01-05 14:08:44', '2024-01-05 14:08:44'),
(25, 'G 6', NULL, NULL, 51, 3, 0, 0, '2024-01-05 14:09:00', '2024-01-05 14:09:00'),
(26, 'G 4', NULL, NULL, 54, 3, 0, 0, '2024-01-05 14:09:21', '2024-01-05 14:09:21'),
(27, 'G 5', NULL, NULL, 54, 3, 0, 0, '2024-01-05 14:09:46', '2024-01-05 14:16:29'),
(28, 'G 1', NULL, NULL, 54, 3, 0, 0, '2024-01-05 14:16:55', '2024-01-05 14:16:55'),
(29, '10', NULL, NULL, 84, 2, 0, 0, '2024-01-13 20:01:10', '2024-01-13 20:35:02'),
(31, '12', NULL, NULL, NULL, 1, 2, NULL, '2024-01-25 14:43:03', '2024-01-25 14:43:03'),
(32, '12', NULL, NULL, 110, 7, 29, NULL, '2024-01-25 15:03:36', '2024-01-25 15:03:36'),
(33, 'V1', NULL, NULL, 50, 3, 11, 45, '2024-01-25 15:11:30', '2024-01-25 15:11:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm_celliers`
--
ALTER TABLE `crm_celliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crm_celliers_residence_id_foreign` (`residence_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crm_celliers`
--
ALTER TABLE `crm_celliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crm_celliers`
--
ALTER TABLE `crm_celliers`
  ADD CONSTRAINT `crm_celliers_residence_id_foreign` FOREIGN KEY (`residence_id`) REFERENCES `crm_residences` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

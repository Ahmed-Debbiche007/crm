-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 02, 2024 at 04:11 PM
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
-- Table structure for table `crm_garages`
--

CREATE TABLE `crm_garages` (
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
-- Dumping data for table `crm_garages`
--

INSERT INTO `crm_garages` (`id`, `name`, `surface`, `price`, `client_id`, `residence_id`, `etage_id`, `appart_id`, `created_at`, `updated_at`) VALUES
(2, '12', 12.000, 12.000, 35, 2, 5, 98, '2024-05-02 09:29:14', '2024-05-02 09:29:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm_garages`
--
ALTER TABLE `crm_garages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crm_celliers_residence_id_foreign` (`residence_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crm_garages`
--
ALTER TABLE `crm_garages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crm_garages`
--
ALTER TABLE `crm_garages`
  ADD CONSTRAINT `crm_garages_residence_id_foreign` FOREIGN KEY (`residence_id`) REFERENCES `crm_residences` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

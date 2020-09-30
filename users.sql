-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 30, 2020 at 05:02 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `01_pms_quickadminpanel`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` int(11) DEFAULT NULL,
  `banned` int(11) DEFAULT NULL,
  `ban_reason` longtext COLLATE utf8mb4_unicode_ci,
  `last_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `online_time` int(11) DEFAULT NULL,
  `smtp_email_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_encription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_host_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_port` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_additional_flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_postmaster_run` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_path_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marketting_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marketing_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marketing_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vacation_balance` int(11) DEFAULT NULL,
  `vacation_counterdown` int(11) DEFAULT NULL,
  `date_of_join` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_insurance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vacation_verified` int(11) DEFAULT NULL,
  `role_id` int(10) UNSIGNED DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `username`, `activated`, `banned`, `ban_reason`, `last_ip`, `last_login`, `online_time`, `smtp_email_type`, `smtp_encription`, `smtp_action`, `smtp_host_name`, `smtp_user_name`, `smtp_password`, `smtp_port`, `smtp_additional_flag`, `last_postmaster_run`, `media_path_slug`, `marketting_username`, `marketing_password`, `marketing_type`, `sp_username`, `sp_password`, `vacation_balance`, `vacation_counterdown`, `date_of_join`, `date_of_insurance`, `vacation_verified`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$10$l4lxnsIGTo5mEhGh3q756.Q51fJWdRB.QTpCsUHp8oR7fo6EqaXoW', NULL, '', NULL, NULL, NULL, '', NULL, NULL, '', '', '', '', '', NULL, '', '', '', '', '', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(7, 'ceo', 'ceo@onetecgroup.com', NULL, '$2y$10$XI.F3VmDU2Ob/xzP3x9Rweolx9/vHZeAFs49VKm92fhvo6o.utZA6', NULL, NULL, 1, 0, 'NULL', '197.246.246.232', NULL, 1584350260, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'marketing@onetecgroup.com', 'hple1901w', 'cutomer', NULL, NULL, 21, 21, NULL, NULL, 0, NULL, '2020-09-30 03:01:35', '2020-09-30 03:01:35', NULL),
(8, 'mosayed', 'mohab@onetecgroup.com', NULL, '$2y$10$rwYBh3yHBpPuG/MpTrKFf.9EyzwCdVzwqZIS7ecja7VxpHXml4Ah2', NULL, NULL, 1, 0, 'NULL', '41.42.178.84', NULL, 1584366179, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'marketing@onetecgroup.com', 'hple1901w', 'cutomer', 'marketing@onetecgroup.com', 'hple1901w', 21, 21, NULL, NULL, 0, NULL, '2020-09-30 03:01:35', '2020-09-30 03:01:35', NULL),
(9, 'mayman', 'mayman@onetecgroup.com', NULL, '$2y$10$YlSIbBcWtk2NCCq6QLvpeuo/sdOesBno74m3YUALDHA5hGhUYZPem', NULL, NULL, 0, 1, 'Terminated', '41.42.185.255', NULL, 1584365954, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'mayman', 'marketing@onetecgroup.com', 'hple1901w', 'cutomer', 'marketing@onetecgroup.com', 'hple1901w', 21, 21, NULL, NULL, 0, NULL, '2020-09-30 03:01:35', '2020-09-30 03:01:35', NULL),
(10, 'abozeid', 'abozeid@onetecgroup.com', NULL, '$2y$10$fNEd3J.ccqqXBc1LPjQRbOtm1BljXpJV0WvxxTP0cLlzLoh/0x.Qu', NULL, NULL, 1, 0, 'NULL', '156.213.159.4', NULL, 1588683242, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'aabozeid', 'marketing@onetecgroup.com', 'hple1901w', 'cutomer', NULL, NULL, 21, 21, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(11, 'weltaweel', 'weltaweel@onetecgroup.com', NULL, '$2y$10$ns/M00h4mHR//JMKaBII9OnLXsGnTtYexmwelFUNivJGb2fIZhUNG', NULL, NULL, 0, 1, 'Resigned', '41.42.185.255', NULL, 1584354783, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'weltaweel', 'NULL', 'NULL', 'NULL', NULL, NULL, 21, 21, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(12, 'cfo', 'cfo@onetecgroup.com', NULL, '$2y$10$eSXiYBBbwQm0fYdEk0uwdOiW4Z9QDJB8hWtpinulOaZOJbwbkE10u', NULL, NULL, 1, 0, 'NULL', '41.42.185.255', NULL, 1567351577, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'cfo', 'NULL', 'NULL', 'NULL', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(13, 'Ismael', 'Ismaeleffat@gmail.com', NULL, '$2y$10$y82YBj5rphMG/xU3UQSYEul/6nf9Ko40CTE76sZjj6Rzm6blibkmW', NULL, NULL, 0, 0, 'NULL', '41.42.185.255', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'ismael', 'NULL', 'NULL', 'NULL', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(14, 'AhmedAyad', 'a.ayad@pcasa.ae', NULL, '$2y$10$jdt2ONwDb1OaYKmbeS7KIOT3Ve471pPg1WzKeP.SpRqKqr4vrCiX.', NULL, NULL, 0, 0, 'NULL', '41.42.185.255', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'ahmedayad', 'NULL', 'NULL', 'NULL', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(15, 'Ahmed Emara', 'emara@stallingkott.ae', NULL, '$2y$10$vV.pVYpqV7faFOf6XRUSuu2j6kMf2aMWnT9eSPOfUVnViSpF.vPUu', NULL, NULL, 0, 0, 'NULL', '41.42.185.255', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'ahmed_emara', 'NULL', 'NULL', 'NULL', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(16, 'msaleh', 'msaleh@onetecgroup.com', NULL, '$2y$10$QxNjq3BgxGhQfRXKrY5LUePWpSBu1SVF9V1jFe56g/0VwIKYAcmOu', NULL, NULL, 1, 0, 'NULL', '41.42.185.255', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'msaleh', 'NULL', 'NULL', 'NULL', NULL, NULL, 0, 21, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(17, 'sahamid', 'sahamid@onetecgroup.com', NULL, '$2y$10$E2YkVgIVnXXP6puqCl44LuXN4ov0R7qqHbes7lEHMR/HZopmEiybS', NULL, NULL, 0, 1, 'Resigned', '41.42.185.255', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', NULL, NULL, 0, 21, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(18, 'aragab', 'aragab@onetecgroup.com', NULL, '$2y$10$gSIlqgT6GSQjCm6/mllmrenp0O5z9QMAod7TzSBr1/XC/7p.F0bBC', NULL, NULL, 0, 1, 'NULL', '41.42.185.255', NULL, 1574603696, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'aragab', 'NULL', 'NULL', 'NULL', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(19, 'redamohamed', 'rmohamed@onetecgroup.com', NULL, '$2y$10$Uov16J7IKyPv8g7wzbehfO.MoNRzib90eIsaIyEZy0VEki4PeQxCy', NULL, NULL, 0, 1, 'Resigned', '41.42.185.255', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(20, 'afawzy', 'afawzy@onetecgroup.com', NULL, '$2y$10$vaHV2r7o2VPMBiVR0EwKZ.1jKKw4EywY8Tg/gKFRtCztmm8F6tXU6', NULL, NULL, 0, 1, 'He resigned. ', '41.42.185.255', NULL, 1575968243, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'afawzy', 'NULL', 'NULL', 'NULL', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:36', '2020-09-30 03:01:36', NULL),
(21, 'ghadawagih', 'ghada@onetecgroup.com', NULL, '$2y$10$jKNQ5xt75Bi3yFif4eNRrOGOCUyi.hHJ669dLksfNnRzTrm3HTe.G', NULL, NULL, 0, 1, 'Left the office', '41.42.185.255', NULL, 1583839790, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'ghadawagih', 'NULL', 'NULL', 'NULL', NULL, NULL, 21, 21, NULL, NULL, 0, NULL, '2020-09-30 03:01:37', '2020-09-30 03:01:37', NULL),
(22, 'norhan', 'norhan@onetecgroup.com', NULL, '$2y$10$sBddyULr05gNCFA331HWlesJJEyjmK2K9kNCDc0Tv6WmeVKaB8Xl.', NULL, NULL, 0, 1, 'Resigned', '41.42.185.255', NULL, 1584285028, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'norhan', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 21, 21, NULL, NULL, 0, NULL, '2020-09-30 03:01:37', '2020-09-30 03:01:37', NULL),
(23, 'marwa', 'marwa@onetecgroup.com', NULL, '$2y$10$TEckrH9dUszDSfuDqeUbB.jmnHUa4OsNQp7gPH8.XbvMzOFNZfdQi', NULL, NULL, 1, 0, 'NULL', '41.42.185.255', NULL, 1584364802, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'marwa', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 21, 21, NULL, NULL, 0, NULL, '2020-09-30 03:01:37', '2020-09-30 03:01:37', NULL),
(24, 'shrouk', 'shrouk@onetecgroup.com', NULL, '$2y$10$iec1yGo6/1aFhpyqjHkRZOaQ8liE1uSW50PBCf01WH.69AOxhtn2u', NULL, NULL, 0, 1, 'Terminated ', '41.42.185.255', NULL, 1584365703, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'shrouk', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 11, 11, NULL, NULL, 0, NULL, '2020-09-30 03:01:37', '2020-09-30 03:01:37', NULL),
(25, 'moaaz', 'moaaz@onetecgroup.com', NULL, '$2y$10$mPmxdZ7IJem3.GLiwlKS5uLxiRARXcb9h7OGM692/fbnFgphL7pdK', NULL, NULL, 1, 0, 'NULL', '91.74.215.134', NULL, 1584365200, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'moaaz', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 11, 11, NULL, NULL, 0, NULL, '2020-09-30 03:01:37', '2020-09-30 03:01:37', NULL),
(26, 'Valuecamps', 'camps@valid.com', NULL, '$2y$10$XCaUKimUC9G5BRCEl5JamuWLcdSAOn9iNXIYGAgWEygfwcnNj1E56', NULL, NULL, 1, 0, 'NULL', '156.213.53.38', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'valuecamps', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:37', '2020-09-30 03:01:37', NULL),
(27, 'aaaaa', 'n.gamal@lesaffre.com', NULL, '$2y$10$4lOuo4FRZXnBTwh7Oq61XehbVYNqViUc55sW2bFniGb/3mGIJITla', NULL, NULL, 1, 0, 'NULL', '196.154.1.72', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'aaaaa', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:37', '2020-09-30 03:01:37', NULL),
(28, 'ahmedradwan98', 'radwan@onetecgroup.com', NULL, '$2y$10$Lk8jjI8HLNK64lGsl4kX/usWB.wxq1f/LHmdnJrjVRumgkNrB9l7u', NULL, NULL, 0, 1, 'Resigned', '197.37.233.70', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'radwan', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:37', '2020-09-30 03:01:37', NULL),
(29, 'nana', 'na@na.com', NULL, '$2y$10$hSwUUBfQ.gV7L3HYbGzdYeYCZMxFfTec8oajaS2/luTkFPKFIsM/u', NULL, NULL, 1, 0, 'NULL', '197.246.212.249', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'nana', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:38', '2020-09-30 03:01:38', NULL),
(30, 'hamed', 'hamed@onetecgroup.com', NULL, '$2y$10$Zo9h6nCxJLlih.R...a/5uuA2nLSh6bdaP27T0u0SsPgyOmavDrby', NULL, NULL, 1, 0, 'NULL', '156.213.65.23', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'hamed', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 5, 5, NULL, NULL, 0, NULL, '2020-09-30 03:01:38', '2020-09-30 03:01:38', NULL),
(31, 'ahmedfaruk', 'saidahmedfarouka@gmail.com', NULL, '$2y$10$VBFaRBAwYm/jMFayngHhJ.MMPfanzSvNPbwf8w9U5dzJuBdNWmCT.', NULL, NULL, 1, 0, 'NULL', '156.196.239.98', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'ahmedfaruk', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:38', '2020-09-30 03:01:38', NULL),
(32, 'Mahmoud', 'mahmoudsaidelbokl@gmail.com', NULL, '$2y$10$SQIxzV3S7NX3rdQHNA1ZS.hA5fpnwLBEZZvisb6dz7KNvAShb2bDm', NULL, NULL, 1, 0, 'NULL', '196.158.201.24', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'mahmoud', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 5, 5, NULL, NULL, 0, NULL, '2020-09-30 03:01:38', '2020-09-30 03:01:38', NULL),
(33, 'mostafa', 'm.elgammal@onetecgroup.com', NULL, '$2y$10$HyALO3ArqVctu7US6ly6GOJY65cBFzXjgBA4EBCwBLMsRAdLXqKBi', NULL, NULL, 1, 0, 'NULL', '156.213.160.48', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'mostafa', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:38', '2020-09-30 03:01:38', NULL),
(34, 'shady', 'shady.osama@onetecgroup.com', NULL, '$2y$10$afsiNA4HTvwj2frmctTn/eOHbS1bs9FNA2EZftv.MQ6yytWSxgYJm', NULL, NULL, 1, 0, 'NULL', '156.213.65.23', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'shady', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:38', '2020-09-30 03:01:38', NULL),
(35, 'ali', 'ali.emad@onetecgroup.com', NULL, '$2y$10$EM8AbL2BLyYKClKJ4Dmlz.oDXB1tXYRdgn7YO8derUkOkXUjnjmOi', NULL, NULL, 1, 0, 'NULL', '156.196.99.162', NULL, 0, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'ali', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 0, 0, NULL, NULL, 0, NULL, '2020-09-30 03:01:38', '2020-09-30 03:01:38', NULL);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

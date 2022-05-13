-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2022 at 09:33 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sia_project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins_table`
--

CREATE TABLE `admins_table` (
  `admin_id` int(11) NOT NULL,
  `admin_firstname` text NOT NULL,
  `admin_lastname` text NOT NULL,
  `admin_middlename` text NOT NULL,
  `admin_gender` text NOT NULL,
  `admin_email` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins_table`
--

INSERT INTO `admins_table` (`admin_id`, `admin_firstname`, `admin_lastname`, `admin_middlename`, `admin_gender`, `admin_email`, `password`) VALUES
(1, 'berwyn', 'felismenia', 'daita', 'gender', '201910432@gordoncollege.edu.ph', '123123123');

-- --------------------------------------------------------

--
-- Table structure for table `events_table`
--

CREATE TABLE `events_table` (
  `event_id` int(11) NOT NULL,
  `event_title` text NOT NULL,
  `event_description` text NOT NULL,
  `event_location` text NOT NULL,
  `event_capacity` int(11) NOT NULL,
  `event_startdatetime` timestamp NULL DEFAULT NULL,
  `event_enddatetime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events_table`
--

INSERT INTO `events_table` (`event_id`, `event_title`, `event_description`, `event_location`, `event_capacity`, `event_startdatetime`, `event_enddatetime`) VALUES
(1, 'sample update title', 'sample description', 'Google Meet', 100, '2022-05-14 02:24:11', '2022-05-14 02:24:11'),
(2, 'sample title 2', 'sample description 2', 'Google Meet', 100, '2022-05-13 14:57:30', '2022-05-13 14:57:35'),
(3, 'sample title 3', 'sample description 3', 'Google Meet', 100, '2022-05-11 07:00:37', '2022-05-11 07:00:37'),
(4, '', '', '', 0, '2022-05-12 07:34:07', '2022-05-12 07:34:07'),
(5, 'qwe', 'qwe', 'qwe', 0, '2022-05-13 06:16:48', '2022-05-13 06:16:48');

-- --------------------------------------------------------

--
-- Table structure for table `event_details_table`
--

CREATE TABLE `event_details_table` (
  `event_detail_id` int(11) NOT NULL,
  `event_id_e` int(11) NOT NULL,
  `event_detail_image` text NOT NULL,
  `event_detail_organizer` text NOT NULL,
  `event_detail_type` text NOT NULL,
  `event_detail_category` text NOT NULL,
  `event_detail_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_details_table`
--

INSERT INTO `event_details_table` (`event_detail_id`, `event_id_e`, `event_detail_image`, `event_detail_organizer`, `event_detail_type`, `event_detail_category`, `event_detail_created_at`, `deleted_at`) VALUES
(1, 1, '1652322251.png', 'Algen and friends', '', 'ccs', '2022-05-12 02:24:11', NULL),
(2, 2, '1652338943.png', 'Algen and Friends', '', 'ccs', '2022-05-12 07:02:23', NULL),
(3, 3, '1652341700.png', 'Algen and Friends', '', 'ceas', '2022-05-12 07:48:20', NULL),
(4, 4, '', '', '', '', '2022-05-12 07:34:11', NULL),
(5, 5, '1652422958.png', 'qqwe', '', 'chtm', '2022-05-13 06:22:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news_details_table`
--

CREATE TABLE `news_details_table` (
  `news_details_id` int(11) NOT NULL,
  `news_id_n` int(11) NOT NULL,
  `news_details_image` text NOT NULL,
  `news_details_organizer` text NOT NULL,
  `news_details_category` text NOT NULL,
  `news_details_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news_details_table`
--

INSERT INTO `news_details_table` (`news_details_id`, `news_id_n`, `news_details_image`, `news_details_organizer`, `news_details_category`, `news_details_created_at`, `deleted_at`) VALUES
(91, 102, '1652114550.jpeg', 'algen and friends', '2', '2022-05-09 16:56:59', '2022-05-10 00:56:59'),
(93, 105, '1652115540.png', 'qweqwe', '1', '2022-05-09 16:59:00', NULL),
(94, 107, '1652416329.png', 'organizer', 'gc', '2022-05-13 04:32:09', NULL),
(95, 108, '1652422471.jpeg', 'Algen and friends', 'ceas', '2022-05-13 06:14:31', NULL),
(96, 109, '', 'qwe', 'ceas', '2022-05-13 06:14:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news_table`
--

CREATE TABLE `news_table` (
  `news_id` int(11) NOT NULL,
  `news_title` text NOT NULL,
  `news_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news_table`
--

INSERT INTO `news_table` (`news_id`, `news_title`, `news_description`) VALUES
(102, 'updated!', 'sample update'),
(105, 'qwe', 'qweqwe'),
(107, 'sample news', 'sample description news'),
(108, 'bundok', 'bundok na may puno'),
(109, 'qwe', 'qwe');

-- --------------------------------------------------------

--
-- Table structure for table `registration_table`
--

CREATE TABLE `registration_table` (
  `registration_id` int(11) NOT NULL,
  `event_id_r` int(11) NOT NULL,
  `user_studnum_r` int(11) NOT NULL,
  `registration_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cancelled_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration_table`
--

INSERT INTO `registration_table` (`registration_id`, `event_id_r`, `user_studnum_r`, `registration_created_at`, `cancelled_at`) VALUES
(3, 1, 201910432, '2022-05-09 16:52:05', NULL),
(4, 8, 201910432, '2022-05-10 07:42:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_table`
--

CREATE TABLE `users_table` (
  `user_studnum` int(11) NOT NULL,
  `user_firstname` text NOT NULL,
  `user_lastname` text NOT NULL,
  `user_middlename` text NOT NULL,
  `user_gender` text NOT NULL,
  `user_department` text NOT NULL,
  `user_yearlevel` text NOT NULL,
  `user_block` text NOT NULL,
  `user_email` text NOT NULL,
  `user_password` text NOT NULL,
  `user_priviledge` text NOT NULL,
  `user_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`user_studnum`, `user_firstname`, `user_lastname`, `user_middlename`, `user_gender`, `user_department`, `user_yearlevel`, `user_block`, `user_email`, `user_password`, `user_priviledge`, `user_created_at`) VALUES
(201910432, 'berwyn', 'felismenia', 'daita', 'gender', 'ccs', '3', 'B', '201910432@gordoncollege.edu.ph', '123123123', '', '2022-04-21 12:11:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins_table`
--
ALTER TABLE `admins_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `events_table`
--
ALTER TABLE `events_table`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_details_table`
--
ALTER TABLE `event_details_table`
  ADD PRIMARY KEY (`event_detail_id`),
  ADD KEY `events_tbl_foreign_key_e` (`event_id_e`);

--
-- Indexes for table `news_details_table`
--
ALTER TABLE `news_details_table`
  ADD PRIMARY KEY (`news_details_id`),
  ADD KEY `news_tbl_foreign_key_n` (`news_id_n`);

--
-- Indexes for table `news_table`
--
ALTER TABLE `news_table`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `registration_table`
--
ALTER TABLE `registration_table`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `events_tbl_foreign_key_r` (`event_id_r`),
  ADD KEY `users_tbl_foreign_key_r` (`user_studnum_r`);

--
-- Indexes for table `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`user_studnum`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins_table`
--
ALTER TABLE `admins_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events_table`
--
ALTER TABLE `events_table`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_details_table`
--
ALTER TABLE `event_details_table`
  MODIFY `event_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `news_details_table`
--
ALTER TABLE `news_details_table`
  MODIFY `news_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `news_table`
--
ALTER TABLE `news_table`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `registration_table`
--
ALTER TABLE `registration_table`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE `users_table`
  MODIFY `user_studnum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201910433;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_details_table`
--
ALTER TABLE `event_details_table`
  ADD CONSTRAINT `events_tbl_foreign_key_e` FOREIGN KEY (`event_id_e`) REFERENCES `events_table` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news_details_table`
--
ALTER TABLE `news_details_table`
  ADD CONSTRAINT `news_tbl_foreign_key_n` FOREIGN KEY (`news_id_n`) REFERENCES `news_table` (`news_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registration_table`
--
ALTER TABLE `registration_table`
  ADD CONSTRAINT `events_tbl_foreign_key_r` FOREIGN KEY (`event_id_r`) REFERENCES `events_table` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_tbl_foreign_key_r` FOREIGN KEY (`user_studnum_r`) REFERENCES `users_table` (`user_studnum`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2022 at 04:50 PM
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
  `event_startdatetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_enddatetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `event_detail_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `news_details_table`
--

CREATE TABLE `news_details_table` (
  `news_details_id` int(11) NOT NULL,
  `news_id_n` int(11) NOT NULL,
  `news_details_image` text NOT NULL,
  `news_details_organizer` text NOT NULL,
  `news_details_type` text NOT NULL,
  `news_details_category` text NOT NULL,
  `news_details_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `news_table`
--

CREATE TABLE `news_table` (
  `news_id` int(11) NOT NULL,
  `news_title` text NOT NULL,
  `news_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `registration_table`
--

CREATE TABLE `registration_table` (
  `registration_id` int(11) NOT NULL,
  `event_id_r` int(11) NOT NULL,
  `user_studnum_r` int(11) NOT NULL,
  `registration_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_table`
--
ALTER TABLE `events_table`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_details_table`
--
ALTER TABLE `event_details_table`
  MODIFY `event_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_details_table`
--
ALTER TABLE `news_details_table`
  MODIFY `news_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_table`
--
ALTER TABLE `news_table`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_table`
--
ALTER TABLE `registration_table`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE `users_table`
  MODIFY `user_studnum` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_details_table`
--
ALTER TABLE `event_details_table`
  ADD CONSTRAINT `events_tbl_foreign_key_e` FOREIGN KEY (`event_id_e`) REFERENCES `events_table` (`event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `news_details_table`
--
ALTER TABLE `news_details_table`
  ADD CONSTRAINT `news_tbl_foreign_key_n` FOREIGN KEY (`news_id_n`) REFERENCES `news_table` (`news_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `registration_table`
--
ALTER TABLE `registration_table`
  ADD CONSTRAINT `events_tbl_foreign_key_r` FOREIGN KEY (`event_id_r`) REFERENCES `events_table` (`event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_tbl_foreign_key_r` FOREIGN KEY (`user_studnum_r`) REFERENCES `users_table` (`user_studnum`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

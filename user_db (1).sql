-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2024 at 04:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `0`
--

CREATE TABLE `0` (
  `id` int(10) NOT NULL,
  `stud_id` int(255) NOT NULL,
  `stud_fname` varchar(100) NOT NULL,
  `stud_lname` varchar(100) NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `room_num` bigint(20) NOT NULL,
  `start_time` varchar(100) NOT NULL,
  `end_time` varchar(100) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `comb` varchar(100) NOT NULL,
  `room_section` varchar(100) NOT NULL,
  `room_year` varchar(100) NOT NULL,
  `room_subject` varchar(100) NOT NULL,
  `attend` int(100) NOT NULL,
  `not_attend` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_request`
--

CREATE TABLE `admin_request` (
  `id` int(11) NOT NULL,
  `sent_to` text NOT NULL,
  `sent_by` text NOT NULL,
  `req_type` text NOT NULL,
  `req_title` text NOT NULL,
  `req_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_request`
--

INSERT INTO `admin_request` (`id`, `sent_to`, `sent_by`, `req_type`, `req_title`, `req_desc`) VALUES
(1, 'Admin', 'Yvana Nocon', 'Room Request', 'CCL 1', '12:18, 15:18, 3rdyear , Section_C'),
(2, 'Admin', 'Yvana Nocon', 'Room Request', 'CCL 1', '12:52, 14:52, 3rdyear , Section_B'),
(3, 'Super_Admin', 'Yvana Nocon', 'Subject Request', 'asdas asdasd', '1st, Section_D'),
(4, 'Admin', 'Yvana Nocon', 'Other Request', 'aasdad', 'asdas'),
(5, 'Admin', 'Yvana Nocon', 'Room Request', 'CCL 1', '17:03, 17:03, 3rdyear , Section_D');

-- --------------------------------------------------------

--
-- Table structure for table `roomtbl`
--

CREATE TABLE `roomtbl` (
  `sched_code` int(10) NOT NULL,
  `prof_fname` varchar(100) NOT NULL,
  `prof_lname` varchar(100) NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `room_num` bigint(20) NOT NULL,
  `start_time` varchar(100) NOT NULL,
  `end_time` varchar(100) NOT NULL,
  `room_day` varchar(100) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `comb` varchar(100) NOT NULL,
  `room_section` varchar(100) NOT NULL,
  `room_year` varchar(100) NOT NULL,
  `madeby` int(20) NOT NULL,
  `seen` smallint(1) NOT NULL,
  `prof_seen` smallint(1) NOT NULL,
  `attend` int(100) NOT NULL,
  `not_attend` int(100) NOT NULL,
  `made_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usertbl`
--

CREATE TABLE `usertbl` (
  `id` int(200) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `mobile_number` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `subjects` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertbl`
--

INSERT INTO `usertbl` (`id`, `first_name`, `last_name`, `mobile_number`, `email`, `user_type`, `password`, `section`, `year`, `subjects`) VALUES
(0, 'Admin', '', '', 'admin@admin.com', 'Admin', 'admin123', '', '', ''),
(202400, 'JR', 'PACTOR', '0912512512', 'ahwa.pactorjr@gmail.com', 'Student', 'September12003!', 'Section_A', '4th', ' ITEC90 ITEC85 DCIT23 ITEC85 ITEC75 INSY55 DCIT23 DCIT55 DCIT60'),
(202402, 'Yvana', 'Nocon', '0912512512', 'yvananocon@gmail.com', 'Teacher', 'September12003!', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `0`
--
ALTER TABLE `0`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_request`
--
ALTER TABLE `admin_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roomtbl`
--
ALTER TABLE `roomtbl`
  ADD PRIMARY KEY (`sched_code`);

--
-- Indexes for table `usertbl`
--
ALTER TABLE `usertbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `0`
--
ALTER TABLE `0`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_request`
--
ALTER TABLE `admin_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roomtbl`
--
ALTER TABLE `roomtbl`
  MODIFY `sched_code` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `usertbl`
--
ALTER TABLE `usertbl`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202403;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

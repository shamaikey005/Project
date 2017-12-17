-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2017 at 07:24 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pj01`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `class_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_grade` tinyint(4) NOT NULL,
  `class_room` tinyint(4) NOT NULL,
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`, `class_grade`, `class_room`, `teacher_id`) VALUES
('c1-1', NULL, 1, 1, 't001'),
('c4-1', NULL, 4, 1, 't002');

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE `period` (
  `student_id` int(11) NOT NULL,
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schedule_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `period_count` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `class_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `subjects_id`, `class_id`, `teacher_id`) VALUES
(1, 'se01', 'c1-1', 't001'),
(2, 'st04', 'c4-1', 't002');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_detail`
--

CREATE TABLE `schedule_detail` (
  `schedule_id` int(11) NOT NULL,
  `shcedule_begin_time` time NOT NULL,
  `shcedule_end_time` time NOT NULL,
  `schedule_weekday` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `schedule_detail`
--

INSERT INTO `schedule_detail` (`schedule_id`, `shcedule_begin_time`, `shcedule_end_time`, `schedule_weekday`) VALUES
(1, '08:00:00', '10:00:00', 3),
(1, '14:00:00', '15:00:00', 5),
(2, '10:00:00', '12:00:00', 4),
(2, '08:00:00', '09:00:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schedule_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `score_score` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `student_firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `student_lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `student_birthday` date DEFAULT NULL,
  `student_address` text COLLATE utf8_unicode_ci,
  `student_idcard` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_firstname`, `student_lastname`, `student_birthday`, `student_address`, `student_idcard`, `class_id`, `user_id`) VALUES
('s001', 'student', '01', NULL, NULL, NULL, 'c1-1', 's001'),
('s002', 'student', '02', NULL, NULL, NULL, 'c4-1', 's002');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subjects_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subjects_type` tinyint(4) NOT NULL,
  `subjects_credit` tinyint(4) NOT NULL,
  `subjects_time` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subjects_id`, `subjects_name`, `subjects_type`, `subjects_credit`, `subjects_time`) VALUES
('se01', 'ภาษาอังกฤษ ป.1', 1, 3, 3),
('st04', 'ภาษาไทย ป.4', 1, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_birthday` date DEFAULT NULL,
  `teacher_address` text COLLATE utf8_unicode_ci,
  `teacher_tel` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `teacher_firstname`, `teacher_lastname`, `teacher_birthday`, `teacher_address`, `teacher_tel`, `user_id`) VALUES
('t001', 'teacher', '01', NULL, NULL, NULL, 't001'),
('t002', 'teacher', '02', NULL, NULL, NULL, 't002');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` tinyint(4) NOT NULL DEFAULT '0',
  `user_level` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_password`, `user_status`, `user_level`) VALUES
('admin', '1234', 1, 127),
('s001', '1234', 1, 1),
('s002', '1234', 1, 1),
('t001', '1234', 1, 2),
('t002', '1234', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subjects_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2018 at 05:50 AM
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
  `class_id` int(11) NOT NULL,
  `class_grade` tinyint(4) NOT NULL,
  `class_room` tinyint(4) NOT NULL,
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_grade`, `class_room`, `teacher_id`) VALUES
(3, 2, 1, 't002');

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE `period` (
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `period_count` tinyint(4) NOT NULL DEFAULT '0',
  `period_max` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roll`
--

CREATE TABLE `roll` (
  `roll_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `term` tinyint(4) NOT NULL,
  `year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roll_detail`
--

CREATE TABLE `roll_detail` (
  `roll_id` int(11) NOT NULL,
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `roll_sick_leave` smallint(6) NOT NULL DEFAULT '0',
  `roll_personal_leave` smallint(6) NOT NULL DEFAULT '0',
  `roll_absent` smallint(6) NOT NULL DEFAULT '0',
  `roll_attend` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `year` year(4) NOT NULL,
  `term` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `score_id` int(11) NOT NULL,
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `score_score` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `score_detail`
--

CREATE TABLE `score_detail` (
  `score_id` int(11) NOT NULL,
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `scored_part` tinyint(4) NOT NULL,
  `scored_point` tinyint(4) NOT NULL DEFAULT '0',
  `scored_max` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `score_detail_2`
--

CREATE TABLE `score_detail_2` (
  `score_id` int(11) NOT NULL,
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `scored_score` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `student_firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `student_lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `student_num` tinyint(4) NOT NULL DEFAULT '0',
  `student_birthday` date DEFAULT NULL,
  `student_sex` tinyint(4) NOT NULL DEFAULT '0',
  `student_address` text COLLATE utf8_unicode_ci,
  `student_idcard` varchar(17) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `user_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_firstname`, `student_lastname`, `student_num`, `student_birthday`, `student_sex`, `student_address`, `student_idcard`, `class_id`, `user_id`) VALUES
('7423', 'ตรัยคุณ', 'วรรณรักษ์', 1, '2011-10-10', 1, '1', '2-7675-24538-54-2', 3, 's001'),
('7429', 'ไกรวิชญ์', 'ศิริสม', 2, '2011-08-05', 1, '2', '1-5164-62151-94-2', NULL, 's002'),
('7461', 'สรวิชญ์', 'แย้มเกสร', 3, '2011-05-02', 1, '3', '1-1689-49461-65-1', NULL, 's003'),
('7614', 'พัชรดนัย', 'บุตรทา', 4, '2011-06-22', 1, '4', '1-1684-94611-69-8', NULL, 's004'),
('8102', 'อคอง', 'เท่า', 5, '2011-09-08', 1, '5', '1-1489-46132-16-4', NULL, 's005'),
('8134', 'นัฐวุฒิ', 'สุขสวัสดิ์', 6, '2011-10-20', 1, '6', '1-1649-87984-51-3', NULL, 's006');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subjects_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subjects_type` tinyint(4) NOT NULL DEFAULT '0',
  `subjects_credit` tinyint(4) DEFAULT NULL,
  `subjects_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subjects_id`, `subjects_name`, `subjects_type`, `subjects_credit`, `subjects_time`) VALUES
('ก11101', 'แนะแนว', 3, 0, 40),
('ก11102', 'ลูกเสือยุวกาชาด', 3, 0, 40),
('ก11103', 'ชมรม', 3, 0, 40),
('ค11101', 'คณิตศาสตร์', 1, 5, 200),
('ง11101', 'การงานอาชีพและเทคโนโลยี', 1, 1, 40),
('ท11101', 'ภาษาไทย', 1, 5, 200),
('พ11101', 'สุขศึกษาและพละศึกษา', 1, 2, 80),
('ว11101', 'วิทยาศาสตร์', 1, 2, 80),
('ศ11101', 'ศิลปะ', 1, 2, 80),
('ส11102', 'ประวัติศาสตร์', 1, 1, 40),
('ส11201', 'หน้าที่พลเมือง', 2, 1, 40),
('อ11101', 'ภาษาอังกฤษ', 1, 1, 40);

-- --------------------------------------------------------

--
-- Table structure for table `subjects_type`
--

CREATE TABLE `subjects_type` (
  `subjects_type` tinyint(4) NOT NULL,
  `subjects_type_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subjects_type`
--

INSERT INTO `subjects_type` (`subjects_type`, `subjects_type_name`) VALUES
(1, 'พื้นฐาน'),
(2, 'เพิ่มเติม'),
(3, 'กิจกรรม');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_title` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `teacher_firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_birthday` date DEFAULT NULL,
  `teacher_address` text COLLATE utf8_unicode_ci,
  `teacher_tel` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `teacher_title`, `teacher_firstname`, `teacher_lastname`, `teacher_birthday`, `teacher_address`, `teacher_tel`, `user_id`) VALUES
('t002', 'asd', 'qeq', 'sdfsdf', '2018-02-01', 'asdasd', '045-275-2722', 't002'),
('t005', 'sdfds', 'dfgsd', 'fgdg', '2018-02-01', 'asdasd', '785-278-7527', 't005');

-- --------------------------------------------------------

--
-- Table structure for table `trait`
--

CREATE TABLE `trait` (
  `trait_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `term` tinyint(4) NOT NULL,
  `year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trait_detail`
--

CREATE TABLE `trait_detail` (
  `trait_id` int(11) NOT NULL,
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `trait_1` tinyint(4) NOT NULL DEFAULT '0',
  `trait_2` tinyint(4) NOT NULL DEFAULT '0',
  `trait_3` tinyint(4) NOT NULL DEFAULT '0',
  `trait_4` tinyint(4) NOT NULL DEFAULT '0',
  `trait_5` tinyint(4) NOT NULL DEFAULT '0',
  `trait_6` tinyint(4) NOT NULL DEFAULT '0',
  `trait_7` tinyint(4) NOT NULL DEFAULT '0',
  `trait_8` tinyint(4) NOT NULL DEFAULT '0',
  `trait_readwrite` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
('s003', '1234', 1, 1),
('s004', '1234', 1, 1),
('s005', '1234', 1, 1),
('s006', '1234', 1, 1),
('t002', '1234', 1, 2),
('t005', '1123', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `period`
--
ALTER TABLE `period`
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subjects_id` (`subjects_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `roll`
--
ALTER TABLE `roll`
  ADD PRIMARY KEY (`roll_id`),
  ADD KEY `roll_id` (`roll_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `roll_detail`
--
ALTER TABLE `roll_detail`
  ADD KEY `roll_id` (`roll_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `subjects_id` (`subjects_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `score_id` (`score_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subjects_id` (`subjects_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `score_detail`
--
ALTER TABLE `score_detail`
  ADD KEY `score_id` (`score_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `score_detail_2`
--
ALTER TABLE `score_detail_2`
  ADD KEY `score_id` (`score_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subjects_id`),
  ADD KEY `subjects_id` (`subjects_id`),
  ADD KEY `subjects_type` (`subjects_type`);

--
-- Indexes for table `subjects_type`
--
ALTER TABLE `subjects_type`
  ADD PRIMARY KEY (`subjects_type`),
  ADD KEY `subjects_type` (`subjects_type`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trait`
--
ALTER TABLE `trait`
  ADD PRIMARY KEY (`trait_id`),
  ADD KEY `trait_id` (`trait_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `trait_detail`
--
ALTER TABLE `trait_detail`
  ADD KEY `trait_id` (`trait_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_3` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roll`
--
ALTER TABLE `roll`
  MODIFY `roll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `trait`
--
ALTER TABLE `trait`
  MODIFY `trait_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Constraints for table `period`
--
ALTER TABLE `period`
  ADD CONSTRAINT `period_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `period_ibfk_2` FOREIGN KEY (`subjects_id`) REFERENCES `subjects` (`subjects_id`),
  ADD CONSTRAINT `period_ibfk_3` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`schedule_id`);

--
-- Constraints for table `roll`
--
ALTER TABLE `roll`
  ADD CONSTRAINT `roll_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`);

--
-- Constraints for table `roll_detail`
--
ALTER TABLE `roll_detail`
  ADD CONSTRAINT `roll_detail_ibfk_1` FOREIGN KEY (`roll_id`) REFERENCES `roll` (`roll_id`),
  ADD CONSTRAINT `roll_detail_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`subjects_id`) REFERENCES `subjects` (`subjects_id`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`),
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `score_ibfk_2` FOREIGN KEY (`subjects_id`) REFERENCES `subjects` (`subjects_id`),
  ADD CONSTRAINT `score_ibfk_3` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`schedule_id`);

--
-- Constraints for table `score_detail`
--
ALTER TABLE `score_detail`
  ADD CONSTRAINT `score_detail_ibfk_1` FOREIGN KEY (`score_id`) REFERENCES `score` (`score_id`),
  ADD CONSTRAINT `score_detail_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `score_detail_2`
--
ALTER TABLE `score_detail_2`
  ADD CONSTRAINT `score_detail_2_ibfk_1` FOREIGN KEY (`score_id`) REFERENCES `score` (`score_id`),
  ADD CONSTRAINT `score_detail_2_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`subjects_type`) REFERENCES `subjects_type` (`subjects_type`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `trait`
--
ALTER TABLE `trait`
  ADD CONSTRAINT `trait_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`);

--
-- Constraints for table `trait_detail`
--
ALTER TABLE `trait_detail`
  ADD CONSTRAINT `trait_detail_ibfk_1` FOREIGN KEY (`trait_id`) REFERENCES `trait` (`trait_id`),
  ADD CONSTRAINT `trait_detail_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

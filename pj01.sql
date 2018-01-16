-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2018 at 08:35 PM
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
  `class_grade` tinyint(4) NOT NULL,
  `class_room` tinyint(4) NOT NULL,
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_grade`, `class_room`, `teacher_id`) VALUES
('c1-1', 1, 1, 't001');

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE `period` (
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schedule_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `period_count` tinyint(4) NOT NULL DEFAULT '0',
  `period_max` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `period`
--

INSERT INTO `period` (`student_id`, `subjects_id`, `schedule_id`, `period_count`, `period_max`) VALUES
('7423', 'ค11101', '12', 0, 127),
('7429', 'ค11101', '12', 0, 127),
('7461', 'ค11101', '12', 0, 127),
('7614', 'ค11101', '12', 0, 127),
('8102', 'ค11101', '12', 0, 127),
('8134', 'ค11101', '12', 0, 127),
('8137', 'ค11101', '12', 0, 127),
('7423', 'ก11101', '13', 0, 40),
('7429', 'ก11101', '13', 0, 40),
('7461', 'ก11101', '13', 0, 40),
('7614', 'ก11101', '13', 0, 40),
('8102', 'ก11101', '13', 0, 40),
('8134', 'ก11101', '13', 0, 40),
('8137', 'ก11101', '13', 0, 40);

-- --------------------------------------------------------

--
-- Table structure for table `roll`
--

CREATE TABLE `roll` (
  `roll_id` int(11) NOT NULL,
  `class_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `term` tinyint(4) NOT NULL,
  `year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roll`
--

INSERT INTO `roll` (`roll_id`, `class_id`, `term`, `year`) VALUES
(6, 'c1-1', 1, 2017),
(7, 'c1-1', 2, 2017);

-- --------------------------------------------------------

--
-- Table structure for table `roll_detail`
--

CREATE TABLE `roll_detail` (
  `roll_id` int(11) NOT NULL,
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `roll_sick_leave` smallint(6) NOT NULL DEFAULT '0',
  `roll_personal_leave` smallint(6) NOT NULL DEFAULT '0',
  `roll_absent` smallint(6) NOT NULL DEFAULT '0',
  `roll_attend` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roll_detail`
--

INSERT INTO `roll_detail` (`roll_id`, `student_id`, `roll_sick_leave`, `roll_personal_leave`, `roll_absent`, `roll_attend`) VALUES
(6, '7423', 1, 1, 2, 5),
(6, '7429', 0, 0, 0, 0),
(6, '7461', 0, 0, 0, 0),
(6, '7614', 0, 0, 0, 0),
(6, '8102', 0, 0, 0, 0),
(6, '8134', 0, 0, 0, 0),
(6, '8137', 0, 0, 0, 0),
(7, '7423', 0, 0, 0, 0),
(7, '7429', 0, 0, 0, 0),
(7, '7461', 0, 0, 0, 0),
(7, '7614', 0, 0, 0, 0),
(7, '8102', 0, 0, 0, 0),
(7, '8134', 0, 0, 0, 0),
(7, '8137', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `class_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `year` year(4) NOT NULL,
  `term` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `subjects_id`, `class_id`, `teacher_id`, `year`, `term`, `status`) VALUES
(12, 'ค11101', 'c1-1', 't001', 2017, 1, 1),
(13, 'ก11101', 'c1-1', 't001', 2017, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `score_id` int(11) NOT NULL,
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subjects_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schedule_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `score_score` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`score_id`, `student_id`, `subjects_id`, `schedule_id`, `score_score`) VALUES
(14, '7423', 'ค11101', '12', 5),
(15, '7429', 'ค11101', '12', 0),
(16, '7461', 'ค11101', '12', 0),
(17, '7614', 'ค11101', '12', 0),
(18, '8102', 'ค11101', '12', 0),
(19, '8134', 'ค11101', '12', 0),
(20, '8137', 'ค11101', '12', 0),
(21, '7423', 'ก11101', '13', 0),
(22, '7429', 'ก11101', '13', 0),
(23, '7461', 'ก11101', '13', 0),
(24, '7614', 'ก11101', '13', 0),
(25, '8102', 'ก11101', '13', 0),
(26, '8134', 'ก11101', '13', 0),
(27, '8137', 'ก11101', '13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `score_detail`
--

CREATE TABLE `score_detail` (
  `score_id` int(11) NOT NULL,
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `scored_part` tinyint(4) NOT NULL,
  `scored_point` tinyint(4) NOT NULL DEFAULT '0',
  `scored_max` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `score_detail`
--

INSERT INTO `score_detail` (`score_id`, `student_id`, `scored_part`, `scored_point`, `scored_max`) VALUES
(14, '7423', 1, 1, 10),
(14, '7423', 2, 1, 10),
(14, '7423', 3, 1, 10),
(14, '7423', 4, 2, 10),
(14, '7423', 5, 0, 10),
(14, '7423', 6, 0, 10),
(14, '7423', 7, 0, 10),
(14, '7423', 8, 0, 30),
(15, '7429', 1, 0, 10),
(15, '7429', 2, 0, 10),
(15, '7429', 3, 0, 10),
(15, '7429', 4, 0, 10),
(15, '7429', 5, 0, 10),
(15, '7429', 6, 0, 10),
(15, '7429', 7, 0, 10),
(15, '7429', 8, 0, 30),
(16, '7461', 1, 0, 10),
(16, '7461', 2, 0, 10),
(16, '7461', 3, 0, 10),
(16, '7461', 4, 0, 10),
(16, '7461', 5, 0, 10),
(16, '7461', 6, 0, 10),
(16, '7461', 7, 0, 10),
(16, '7461', 8, 0, 30),
(17, '7614', 1, 0, 10),
(17, '7614', 2, 0, 10),
(17, '7614', 3, 0, 10),
(17, '7614', 4, 0, 10),
(17, '7614', 5, 0, 10),
(17, '7614', 6, 0, 10),
(17, '7614', 7, 0, 10),
(17, '7614', 8, 0, 30),
(18, '8102', 1, 0, 10),
(18, '8102', 2, 0, 10),
(18, '8102', 3, 0, 10),
(18, '8102', 4, 0, 10),
(18, '8102', 5, 0, 10),
(18, '8102', 6, 0, 10),
(18, '8102', 7, 0, 10),
(18, '8102', 8, 0, 30),
(19, '8134', 1, 0, 10),
(19, '8134', 2, 0, 10),
(19, '8134', 3, 0, 10),
(19, '8134', 4, 0, 10),
(19, '8134', 5, 0, 10),
(19, '8134', 6, 0, 10),
(19, '8134', 7, 0, 10),
(19, '8134', 8, 0, 30),
(20, '8137', 1, 0, 10),
(20, '8137', 2, 0, 10),
(20, '8137', 3, 0, 10),
(20, '8137', 4, 0, 10),
(20, '8137', 5, 0, 10),
(20, '8137', 6, 0, 10),
(20, '8137', 7, 0, 10),
(20, '8137', 8, 0, 30);

-- --------------------------------------------------------

--
-- Table structure for table `score_detail_2`
--

CREATE TABLE `score_detail_2` (
  `score_id` int(11) NOT NULL,
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `scored_score` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `score_detail_2`
--

INSERT INTO `score_detail_2` (`score_id`, `student_id`, `scored_score`) VALUES
(21, '7423', 0),
(22, '7429', 0),
(23, '7461', 1),
(24, '7614', 1),
(25, '8102', 1),
(26, '8134', 1),
(27, '8137', 1);

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
  `class_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_firstname`, `student_lastname`, `student_num`, `student_birthday`, `student_sex`, `student_address`, `student_idcard`, `class_id`, `user_id`) VALUES
('7423', 'ตรัยคุณ', 'วรรณรักษ์', 1, '2011-10-10', 1, '1', '2-7675-24538-54-2', 'c1-1', 's001'),
('7429', 'ไกรวิชญ์', 'ศิริสม', 2, '2011-08-05', 1, '2', '1-5164-62151-94-2', 'c1-1', 's002'),
('7461', 'สรวิชญ์', 'แย้มเกสร', 3, '2011-05-02', 1, '3', '1-1689-49461-65-1', 'c1-1', 's003'),
('7614', 'พัชรดนัย', 'บุตรทา', 4, '2011-06-22', 1, '4', '1-1684-94611-69-8', 'c1-1', 's004'),
('8102', 'อคอง', 'เท่า', 5, '2011-09-08', 1, '5', '1-1489-46132-16-4', 'c1-1', 's005'),
('8134', 'นัฐวุฒิ', 'สุขสวัสดิ์', 6, '2011-10-20', 1, '6', '1-1649-87984-51-3', 'c1-1', 's006'),
('8137', 'ภควัต', 'ชาติทุ่ง', 7, '2011-12-15', 1, '7', '1-1587-98413-22-4', 'c1-1', 's007');

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
('ส11101', 'สังคมศึกษา ศาสนาและวัฒนธรรม', 1, 2, 80),
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
('t001', NULL, 'เบญจณัฐ', 'บุญธง', '1988-05-10', '101', '089-531-3485', 't001');

-- --------------------------------------------------------

--
-- Table structure for table `trait`
--

CREATE TABLE `trait` (
  `trait_id` int(11) NOT NULL,
  `class_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `term` tinyint(4) NOT NULL,
  `year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `trait`
--

INSERT INTO `trait` (`trait_id`, `class_id`, `term`, `year`) VALUES
(3, 'c1-1', 1, 2017),
(4, 'c1-1', 2, 2017);

-- --------------------------------------------------------

--
-- Table structure for table `trait_detail`
--

CREATE TABLE `trait_detail` (
  `trait_id` int(11) NOT NULL,
  `student_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
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

--
-- Dumping data for table `trait_detail`
--

INSERT INTO `trait_detail` (`trait_id`, `student_id`, `trait_1`, `trait_2`, `trait_3`, `trait_4`, `trait_5`, `trait_6`, `trait_7`, `trait_8`, `trait_readwrite`) VALUES
(3, '7423', 1, 0, 0, 0, 0, 0, 0, 0, 0),
(3, '7429', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, '7461', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, '7614', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, '8102', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, '8134', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, '8137', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, '7423', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, '7429', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, '7461', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, '7614', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, '8102', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, '8134', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, '8137', 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
('s007', '', 1, 1),
('t001', '1234', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `roll`
--
ALTER TABLE `roll`
  ADD PRIMARY KEY (`roll_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`score_id`);

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
-- Indexes for table `subjects_type`
--
ALTER TABLE `subjects_type`
  ADD PRIMARY KEY (`subjects_type`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `trait`
--
ALTER TABLE `trait`
  ADD PRIMARY KEY (`trait_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roll`
--
ALTER TABLE `roll`
  MODIFY `roll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `trait`
--
ALTER TABLE `trait`
  MODIFY `trait_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

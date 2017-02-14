-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2016 at 06:35 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_nim`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_batch`
--

CREATE TABLE IF NOT EXISTS `tbl_batch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `center_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `sub_course_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `trainers` varchar(500) NOT NULL,
  `start_date` date NOT NULL,
  `description` text NOT NULL,
  `is_completed` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_batch`
--

INSERT INTO `tbl_batch` (`id`, `center_id`, `course_id`, `sub_course_id`, `name`, `trainers`, `start_date`, `description`, `is_completed`, `created`, `modified`) VALUES
(1, 1, 1, 2, 'Evening 7 to 8', '2', '2016-05-10', 'banking', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_center`
--

CREATE TABLE IF NOT EXISTS `tbl_center` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `center_name` varchar(255) NOT NULL,
  `center_loc_id` int(11) NOT NULL,
  `center_coordinator_id` int(11) NOT NULL,
  `center_address` text NOT NULL,
  `center_mobile` varchar(15) NOT NULL,
  `center_extension` varchar(10) NOT NULL,
  `center_landline` varchar(10) NOT NULL,
  `center_pincode` varchar(10) NOT NULL,
  `center_code` varchar(50) NOT NULL,
  `center_timing` varchar(10) NOT NULL,
  `created_by` int(11) NOT NULL,
  `center_status` tinyint(1) NOT NULL DEFAULT '1',
  `center_is_deleted` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_center`
--

INSERT INTO `tbl_center` (`id`, `center_name`, `center_loc_id`, `center_coordinator_id`, `center_address`, `center_mobile`, `center_extension`, `center_landline`, `center_pincode`, `center_code`, `center_timing`, `created_by`, `center_status`, `center_is_deleted`, `created`, `modified`) VALUES
(1, 'IMS ADMIN', 1, 0, '', '', '', '', '', '1001', '', 0, 1, 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE IF NOT EXISTS `tbl_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`id`, `name`, `description`, `status`, `created`, `modified`) VALUES
(1, 'Banking', 'banking', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE IF NOT EXISTS `tbl_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_number` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `m_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `marital` varchar(50) NOT NULL,
  `street1` text NOT NULL,
  `street2` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `home_telephone` varchar(20) NOT NULL,
  `doc_detail` varchar(255) NOT NULL,
  `joining_date` date NOT NULL,
  `employee_type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `emer_relation` varchar(255) NOT NULL,
  `emer_mobile` varchar(255) NOT NULL,
  `emer_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `password` varchar(255) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`id`, `emp_number`, `f_name`, `m_name`, `l_name`, `father_name`, `dob`, `marital`, `street1`, `street2`, `city`, `state`, `zipcode`, `home_telephone`, `doc_detail`, `joining_date`, `employee_type`, `email`, `mobile`, `emer_relation`, `emer_mobile`, `emer_name`, `image`, `gender`, `status`, `password`, `group_id`, `center_id`, `created`, `modified`) VALUES
(1, 'admin', 'admin', 'Orla Ramsey', 'Shellie Snider', 'Tyler Singleton', '2003-10-09', 'single', 'test1', '1', 'testtet', '1111', '878221', '234234', '', '0000-00-00', 'other', 'jefyro@gmail.com', '234234', 'test', '9797979797', 'test', '1457730033f148d83342980f663f47b3591eced52e_d03845c0-d16b-499c-8d8a-22636fae6675.jpg', 'F', 1, 'MTIzNDU=', 4, 0, '0000-00-00 00:00:00', '0000-00-00'),
(2, 'NAT/20160510/2', 'Vipul', 'Kumar', 'GANGWAL', 'ABC', '0000-00-00', 'married', 'STREET 1', 'STREET 2', 'JAIPUR', 'RAJASTHAN', '302000', '01412503111', '', '0000-00-00', '', 'ABC@GAMIL.COM', '9999999999', 'NEAR ONE', '11111111111', 'ABC', '', 'M', 1, 'MTIzNDU=', 5, 0, '0000-00-00 00:00:00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_qualification`
--

CREATE TABLE IF NOT EXISTS `tbl_emp_qualification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `level` int(11) NOT NULL COMMENT 'refer qualification table',
  `discipline` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `passYear` varchar(20) NOT NULL,
  `gpa_score` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_emp_qualification`
--

INSERT INTO `tbl_emp_qualification` (`id`, `emp_id`, `level`, `discipline`, `college`, `specialization`, `passYear`, `gpa_score`, `created`, `modified`) VALUES
(2, 41, 2, 'Full time', 'UOR,JAIPUR', 'MATHS', '2014', 90, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_error_log`
--

CREATE TABLE IF NOT EXISTS `tbl_error_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `error_type` varchar(255) NOT NULL,
  `error_msg` varchar(255) NOT NULL,
  `error_file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_error_log`
--

INSERT INTO `tbl_error_log` (`id`, `error_type`, `error_msg`, `error_file`) VALUES
(1, 'test', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exm_package`
--

CREATE TABLE IF NOT EXISTS `tbl_exm_package` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '1=>paid 2=>free no need of duration',
  `duration_in_days` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `size` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_exm_package`
--

INSERT INTO `tbl_exm_package` (`id`, `name`, `type`, `duration_in_days`, `start_date`, `end_date`, `size`, `price`, `center_id`, `status`, `created`, `modified`) VALUES
(1, 'SPEED TEST-IBPS', 1, 60, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 500, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'test', 1, 180, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 234, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exm_papers`
--

CREATE TABLE IF NOT EXISTS `tbl_exm_papers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'total timing for paper',
  `tot_question` int(11) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `right_mark` decimal(10,2) NOT NULL,
  `wrong_mark` decimal(10,2) NOT NULL,
  `ppr_view_duration` int(11) NOT NULL COMMENT 'used to strt nd ending paper date',
  `options` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `center_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_exm_papers`
--

INSERT INTO `tbl_exm_papers` (`id`, `name`, `description`, `subject_id`, `duration`, `tot_question`, `activation_code`, `right_mark`, `wrong_mark`, `ppr_view_duration`, `options`, `status`, `center_id`, `created`, `modified`) VALUES
(1, 'IBPS-PO-1', '<p>MCQ TYPE</p>', '1,2,3,4', 120, 40, '405', '1.00', '1.00', 50, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'IBPS-SO-1', '<p>TECHNICAL</p>', '1', 60, 1, '405', '1.00', '1.00', 0, 2, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exm_pkg_paper`
--

CREATE TABLE IF NOT EXISTS `tbl_exm_pkg_paper` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pkg_id` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_exm_pkg_paper`
--

INSERT INTO `tbl_exm_pkg_paper` (`id`, `pkg_id`, `paper_id`, `created`, `modified`, `created_by`) VALUES
(2, 1, 1, '2016-05-10 19:35:06', '0000-00-00 00:00:00', 1),
(3, 1, 2, '2016-05-10 19:35:06', '0000-00-00 00:00:00', 1),
(4, 2, 1, '2016-05-16 23:39:50', '0000-00-00 00:00:00', 1),
(5, 2, 2, '2016-05-16 23:39:50', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exm_ppr_attmpted`
--

CREATE TABLE IF NOT EXISTS `tbl_exm_ppr_attmpted` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) NOT NULL,
  `ppr_id` int(20) NOT NULL,
  `start_time` bigint(20) NOT NULL,
  `end_time` bigint(20) NOT NULL,
  `last_view_time` bigint(20) NOT NULL,
  `right_mark` decimal(10,2) NOT NULL,
  `wrong_mark` decimal(10,2) NOT NULL,
  `declaration` text COLLATE utf8_unicode_ci NOT NULL,
  `accept_declaration` tinyint(4) NOT NULL DEFAULT '0',
  `ranking` int(11) NOT NULL,
  `total_ques_attempt` int(11) NOT NULL,
  `total_right_ques` int(11) NOT NULL,
  `total_wrong_ques` int(11) NOT NULL,
  `positive_mark` float NOT NULL,
  `negative_mark` float NOT NULL,
  `max_marks` float NOT NULL,
  `obtain_marks` float NOT NULL,
  `is_practice_set` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=>not fr practice 1=>for practice',
  `is_completed` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=>not complete 1=>paper completed',
  `attempt_count` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_exm_ppr_attmpted`
--

INSERT INTO `tbl_exm_ppr_attmpted` (`id`, `student_id`, `ppr_id`, `start_time`, `end_time`, `last_view_time`, `right_mark`, `wrong_mark`, `declaration`, `accept_declaration`, `ranking`, `total_ques_attempt`, `total_right_ques`, `total_wrong_ques`, `positive_mark`, `negative_mark`, `max_marks`, `obtain_marks`, `is_practice_set`, `is_completed`, `attempt_count`, `created`, `modified`) VALUES
(2, 1, 1, 20160521004943, 20160521024943, 20160521004943, '1.00', '1.00', '<p>MCQ TYPE</p>', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exm_questions`
--

CREATE TABLE IF NOT EXISTS `tbl_exm_questions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `paper_id` text NOT NULL,
  `sub_id` int(11) NOT NULL,
  `eng_ques` text NOT NULL,
  `hin_ques` text CHARACTER SET utf8 NOT NULL,
  `choice` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=>single 2=>multiple',
  `option1` text NOT NULL,
  `option2` text NOT NULL,
  `option3` text NOT NULL,
  `option4` text NOT NULL,
  `option5` text NOT NULL,
  `option1_hin` text CHARACTER SET utf8 NOT NULL,
  `option2_hin` text CHARACTER SET utf8 NOT NULL,
  `option3_hin` text CHARACTER SET utf8 NOT NULL,
  `option4_hin` text CHARACTER SET utf8 NOT NULL,
  `option5_hin` text CHARACTER SET utf8 NOT NULL,
  `answer` varchar(255) NOT NULL,
  `options` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `tbl_exm_questions`
--

INSERT INTO `tbl_exm_questions` (`id`, `paper_id`, `sub_id`, `eng_ques`, `hin_ques`, `choice`, `option1`, `option2`, `option3`, `option4`, `option5`, `option1_hin`, `option2_hin`, `option3_hin`, `option4_hin`, `option5_hin`, `answer`, `options`, `status`, `created_by`, `created`, `modified`) VALUES
(1, '1,2', 4, '<p>(2+3)=?-5</p>', '<p>(2+3)=?-5</p>', 1, '10', '2', '1', 'None of these', '', '10', '2', '1', 'None of these', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '1', 4, '<p>Equal number of red and yellow balls were ordered by shop. 45 extra red balls were deliv- ered &amp; ratio of red balls to yellow balls became 1/5,1/6 Find the original number of red balls at the store?', '<p>Equal number of red and yellow balls were ordered by shop. 45 extra red balls were deliv- ered &amp; ratio of red balls to yellow balls became 1/5,1/6 Find the original number of red balls at the store?</p>', 1, '450', '270', '225', 'None', '', '', '', '', '', '', '3', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '1', 4, '<p>&nbsp;I am 3 times as old as my son. 5 years later, I shall be 2 1/2 times as old as my son. What is my age?</p>', '<p>&nbsp;I am 3 times as old as my son. 5 years later, I shall be 2 1/2 times as old as my son. What is my age?</p>', 1, '45', '75', '65', '85', '', '', '', '', '', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, '1', 4, '<p>&gamma;&rsquo;s father will be 2 times his age 6 years from now &amp; his mother was 2 times his age 2 years before. If person &gamma; will be 24 after 2 years, calculate difference between his father&rsquo;s and mother&rsquo;s age?</p>', '<p>&gamma;&rsquo;s father will be 2 times his age 6 years from now &amp; his mother was 2 times his age 2 years before. If person &gamma; will be 24 after 2 years, calculate difference between his father&rsquo;s and mother&rsquo;s age?</p>', 1, '4', '6', '8', '10', '', '', '', '', '', '', '3', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, '1', 4, '<p>Match the pattern similar to 2: 3</p>', '<p>Match the pattern similar to 2: 3</p>', 1, '9:3', '1:3', '7:1', '4:6', '', '9:3', '1:3', '7:1', '4:6', '', '3', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '1', 4, '<p>A nonstop bus to place &alpha; overtakes a bicycle also moving towards Place &alpha; at 10 AM. The bus reaches place &alpha; at 12.30 PM and starts on the return journey after 1 hr. On the way, back it meets the bicycle at 2 PM. At what time the bicycle will reach Place &alpha;?</p>', '<p>A nonstop bus to place &alpha; overtakes a bicycle also moving towards Place &alpha; at 10 AM. The bus reaches place &alpha; at 12.30 PM and starts on the return journey after 1 hr. On the way, back it meets the bicycle at 2 PM. At what time the bicycle will reach Place &alpha;?</p>', 1, '2:30 PM', '3:00 PM', '3:15 PM', '3:30 PM', '', '2:30 PM', '2:30 PM', '2:30 PM', '2:30 PM', '', '2', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, '1', 4, '<p>A man was going by cycle. After going 2/3rd of total distance, the cycle broke down and he had to complete the journey on foot. At the end, he found that he walked twice as long as he was on cycle. Speed of cycle is how many times the speed of walking?</p>', '<p>A man was going by cycle. After going 2/3rd of total distance, the cycle broke down and he had to complete the journey on foot. At the end, he found that he walked twice as long as he was on cycle. Speed of cycle is how many times the speed of walking?</p>', 1, '4 times', '2 times', '3 times', '6 times', '', '4 times', '2 times', '2 times', '6 times', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, '1', 4, '<p>&nbsp;Person walks 5/6th of his usual rate &amp; is 40 minutes late. Find his usual time?</p>', '<p>Person walks 5/6th of his usual rate &amp; is 40 minutes late. Find his usual time?</p>', 1, '3 hr. 20 min', '4 hr. 30 min', '3 hr. 40 min', '4 hr. 50 min', '', '3 hr. 20 min', '4 hr. 30 min', '3 hr. 40 min', '4 hr. 50 min', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, '1', 4, '<p>&nbsp;Car travels fixed distance taking 7 hr. in forward journey &amp; increased speed of 12km/hr during return journey &amp; takes 5 hr. What is the distance travelled?</p>', '<p>&nbsp;Car travels fixed distance taking 7 hr. in forward journey &amp; increased speed of 12km/hr during return journey &amp; takes 5 hr. What is the distance travelled?</p>', 1, '210 km', '230 Km', '320 Km', 'None', '', '210 Km', '230 Km', '320 Km', 'None', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, '1', 4, '<p>&nbsp;Create a ratio using 2, 4, 4, 8.</p>', '<p>&nbsp;Create a ratio using 2, 4, 4, 8.</p>', 1, '4:5', '3:3', '1:5', 'None', '', '4:5', '3:3', '1:5', 'None', '', '4', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, '1', 1, '<p>The father of computer is :</p>\r\n\r\n<p>&nbsp;</p>', '<p>&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>Ã Â¤Â•Ã Â¤Â®Ã Â¥ÂÃ Â¤ÂªÃ Â¥ÂÃ Â¤Â¯Ã Â¥ÂÃ Â¤ÂŸÃ Â¤Â° Ã Â¤Â•Ã Â¥Â‡ Ã Â¤ÂœÃ Â¤Â¨Ã Â¤Â• Ã Â¤Â¹Ã Â¥Âˆ:</p>', 1, 'love lice', 'Charles babbage', 'Charles dikens', 'Oliver twist', '', 'Ã Â¤Â²Ã Â¤Âµ Ã Â¤Â²Ã Â¤Â¾Ã Â¤Â‡Ã Â¤Â¸', 'Ã Â¤ÂšÃ Â¤Â¾Ã Â¤Â°Ã Â¥ÂÃ Â¤Â²Ã Â¥ÂÃ Â¤Â¸ Ã Â¤Â¬Ã Â¥ÂˆÃ Â¤Â¬Ã Â¥Â‡Ã Â¤Âœ', 'Ã Â¤ÂšÃ Â¤Â¾Ã Â¤Â°Ã Â¥ÂÃ Â¤Â²Ã Â¥ÂÃ Â¤Â¸ Ã Â¤Â¡Ã Â¥ÂˆÃ Â¤Â•Ã Â¥ÂˆÃ Â¤Â¨', 'Ã Â¤Â“Ã Â¤Â²Ã Â¤Â¿Ã Â¤ÂµÃ Â¤Â° Ã Â¤ÂŸÃ Â¥ÂÃ Â¤ÂµÃ Â¤Â¿Ã Â¤Â¸Ã Â¥ÂÃ Â¤ÂŸ', '', '2', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, '1', 1, '<p>Indian first talkie film produced in 1931 was :</p>\r\n\r\n<p>&nbsp;&nbsp;</p>', '<p>1931 Ã Â¤Â®Ã Â¥Â‡Ã Â¤Â‚ Ã Â¤Â­Ã Â¤Â¾Ã Â¤Â°Ã Â¤Â¤ Ã Â¤ÂµÃ Â¤Â°Ã Â¥ÂÃ Â¤Â· Ã Â¤Â®Ã Â¥Â‡Ã Â¤Â‚ Ã Â¤Â¨Ã Â¤Â¿Ã Â¤Â°Ã Â¥ÂÃ Â¤Â®Ã Â¤Â¿Ã Â¤Â¤ Ã Â¤ÂªÃ Â¤Â¹Ã Â¤Â²Ã Â¥Â€ Ã Â¤Â¬Ã Â¥Â‹Ã Â¤Â²Ã Â¤Â¨Ã Â¥Â‡ Ã Â¤ÂµÃ Â¤Â¾Ã Â¤Â²Ã Â¥Â€ Ã Â¤Â«Ã Â¤Â¿Ã Â¤Â²Ã Â¥ÂÃ Â¤Â® Ã Â¤Â•Ã Â¥ÂŒÃ Â¤Â¨-Ã Â¤Â¸Ã Â¥Â€ Ã Â¤Â¥Ã Â¥Â€?</p>\r\n\r\n<p>&nbsp;</p>', 1, 'Neel kamal', 'Shakuntala', 'Alam ara', 'Indra sabha', '', 'Ã Â¤Â¨Ã Â¥Â€Ã Â¤Â²Ã Â¤Â•Ã Â¤Â®Ã Â¤Â²', 'Ã Â¤Â¶Ã Â¤Â•Ã Â¥ÂÃ Â¤Â‚Ã Â¤Â¤Ã Â¤Â²Ã Â¤Â¾', 'Ã Â¤Â†Ã Â¤Â²Ã Â¤Â®Ã Â¤Â†Ã Â¤Â°Ã Â¤Â¾', 'Ã Â¤Â‡Ã Â¤Â¨Ã Â¥ÂÃ Â¤Â¦Ã Â¥ÂÃ Â¤Â°Ã Â¤Â¸Ã Â¤Â­Ã Â¤Â¾', '', '3', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, '1', 1, '<p>Waksman got the Noble prize for the discovery of :</p>\r\n\r\n<p>&nbsp;</p>', '<p>&nbsp;&nbsp;&nbsp; Ã Â¤Â‡Ã Â¤Â¸Ã Â¤Â•Ã Â¥Â€ Ã Â¤Â–Ã Â¥Â‹Ã Â¤Âœ Ã Â¤Â•Ã Â¥Â‡ Ã Â¤Â•Ã Â¤Â¾Ã Â¤Â°Ã Â¤Â£ Ã Â¤ÂµÃ Â¤Â¾Ã Â¤Â•Ã Â¥ÂÃ Â¤Â¸Ã Â¤Â®Ã Â¥ÂˆÃ Â¤Â‚Ã Â¤Â¨ Ã Â¤Â•Ã Â¥Â‹ Ã Â¤Â¨Ã Â¥Â‹Ã Â¤Â¬Ã Â¥Â‡Ã Â¤Â² Ã Â¤ÂªÃ Â¥ÂÃ Â¤Â°Ã Â¤Â¸Ã Â¥ÂÃ Â¤Â•Ã Â¤Â¾Ã Â¤Â° Ã Â¤Â¦Ã Â¤Â¿Ã Â¤Â¯Ã Â¤Â¾ Ã Â¤Â—Ã Â¤Â¯Ã Â¤Â¾ :</p>\r\n\r\n<p>&nbsp;&nbsp;</p>', 1, 'Chloromycetin', 'Streptomycin', 'penicillin', 'Neomycin', '', 'Ã Â¤Â•Ã Â¥ÂÃ Â¤Â²Ã Â¥Â‹Ã Â¤Â°Ã Â¥Â‹Ã Â¤Â®Ã Â¤Â¾Ã Â¤Â‡Ã Â¤Â¸Ã Â¥Â€Ã Â¤ÂŸÃ Â¤Â¿Ã Â¤Â¨', 'Ã Â¤Â¸Ã Â¥ÂÃ Â¤ÂŸÃ Â¥ÂÃ Â¤Â°Ã Â¥ÂˆÃ Â¤ÂªÃ Â¥ÂÃ Â¤ÂŸÃ Â¥Â‹Ã Â¤Â®Ã Â¤Â¾Ã Â¤Â‡Ã Â¤Â¸Ã Â¤Â¿Ã Â¤Â¨', 'Ã Â¤ÂªÃ Â¥ÂˆÃ Â¤Â¨Ã Â¥Â€Ã Â¤Â¸Ã Â¤Â¿Ã Â¤Â²Ã Â¥Â€Ã Â¤Â¨', 'Ã Â¤Â¨Ã Â¤Â¿Ã Â¤Â“Ã Â¤Â®Ã Â¤Â¾Ã Â¤Â‡Ã Â¤Â¸Ã Â¥Â€Ã Â¤Â¨', '', '3', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, '1', 1, '<p>Microbial type culture collection centre is situated at:</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;</p>', '<p>Ã Â¤Â¸Ã Â¥Â‚Ã Â¤Â•Ã Â¥ÂÃ Â¤Â·Ã Â¥ÂÃ Â¤Â®Ã Â¤ÂœÃ Â¥Â€Ã Â¤ÂµÃ Â¥Â€Ã Â¤Â¯ Ã Â¤Â•Ã Â¤Â¿Ã Â¤Â¸Ã Â¥ÂÃ Â¤Â® Ã Â¤Â•Ã Â¥Â‡ Ã Â¤Â¸Ã Â¤Â‚Ã Â¤ÂµÃ Â¤Â°Ã Â¥ÂÃ Â¤Â§Ã Â¤Â¨ Ã Â¤Â•Ã Â¤Â¾ Ã Â¤Â¸Ã Â¤Â‚Ã Â¤Â—Ã Â¥ÂÃ Â¤Â°Ã Â¤Â¹Ã Â¤Â£ Ã Â¤Â•Ã Â¥Â‡Ã Â¤Â¨Ã Â¥ÂÃ Â¤Â¦Ã Â¥ÂÃ Â¤Â° Ã Â¤Â¯Ã Â¤Â¹Ã Â¤Â¾Ã Â¤Â Ã Â¤Â¸Ã Â¥ÂÃ Â¤Â¥Ã Â¤Â¿Ã Â¤Â¤ Ã Â¤Â¹Ã Â¥Âˆ :</p>\r\n\r\n<p>&nbsp;&nbsp;</p>', 1, 'Chandigarh', 'New Delhi', 'Bangalore', 'Hyderabad', '', 'Ã Â¤ÂšÃ Â¤Â‚Ã Â¤Â¡Ã Â¥Â€Ã Â¤Â—Ã Â¥Â', 'Ã Â¤Â¨Ã Â¤Âˆ Ã Â¤Â¦Ã Â¤Â¿Ã Â¤Â²Ã Â¥ÂÃ Â¤Â²Ã Â¥Â€', 'Ã Â¤Â¬Ã Â¥ÂˆÃ Â¤Â—Ã Â¤Â²Ã Â¥Â‹Ã Â¤Â°', 'Ã Â¤Â¹Ã Â¥ÂˆÃ Â¤Â¦Ã Â¤Â°Ã Â¤Â¾Ã Â¤Â¬Ã Â¤Â¾Ã Â¤Â¦', '', '3', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, '1', 1, '<p>5. In which year did Dada Saheb Phalke produce the first Feature Film?</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp; (a) 1913 (b)&nbsp; 1910 (c)&nbsp; 1911 (d)&nbsp; 1912</p>\r\n\r\n<p>&nbsp;</p>', '<p>Ã Â¤Â¦Ã Â¤Â¾Ã Â¤Â¦Ã Â¤Â¾ Ã Â¤Â¸Ã Â¤Â¾Ã Â¤Â¹Ã Â¥Â‡Ã Â¤Â¬ Ã Â¤Â«Ã Â¤Â¾Ã Â¤Â²Ã Â¥ÂÃ Â¤Â•Ã Â¥Â‡ Ã Â¤Â¨Ã Â¥Â‡ Ã Â¤Â•Ã Â¤Â¿Ã Â¤Â¸ Ã Â¤ÂµÃ Â¤Â°Ã Â¥ÂÃ Â¤Â· Ã Â¤Â…Ã Â¤ÂªÃ Â¤Â¨Ã Â¥Â€ Ã Â¤ÂªÃ Â¤Â¹Ã Â¤Â²Ã Â¥Â€ Ã Â¤Â«Ã Â¥Â€Ã Â¤ÂšÃ Â¤Â° Ã Â¥ÂžÃ Â¤Â¿Ã Â¤Â²Ã Â¥ÂÃ Â¤Â® Ã Â¤Â¤Ã Â¥ÂˆÃ Â¤Â¯Ã Â¤Â¾Ã Â¤Â° Ã Â¤Â•Ã Â¥Â€ Ã Â¤Â¥Ã Â¥Â€?</p>', 1, '1913', '1910', '1911', '1912', '', '1913', '1910', '1911', '1912', '', '2', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, '1', 1, '<p>when a helium atom loses an electron it becomes:</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>', '<p>when a helium atom loses an electron it becomes:</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;</p>', 1, 'a negative helium ion', 'an alpha particle', 'a proton', 'a positive helium ion', '', 'Ã Â¤Â‹Ã Â¤Â£Ã Â¤Â¾Ã Â¤Â¤Ã Â¥ÂÃ Â¤Â®Ã Â¤Â• Ã Â¤Â¹Ã Â¥Â€Ã Â¤Â²Ã Â¤Â¿Ã Â¤Â¯Ã Â¤Â® Ã Â¤Â†Ã Â¤Â¯Ã Â¤Â¨', 'Ã Â¤Â…Ã Â¤Â²Ã Â¥ÂÃ Â¥ÂžÃ Â¤Â¾ Ã Â¤Â•Ã Â¤Â£', 'Ã Â¤ÂªÃ Â¥ÂÃ Â¤Â°Ã Â¥Â‹Ã Â¤ÂŸÃ Â¤Â¾Ã Â¤Â¨', 'Ã Â¤Â§Ã Â¤Â¨Ã Â¤Â¾Ã Â¤Â¤Ã Â¥ÂÃ Â¤Â®Ã Â¤Â• Ã Â¤Â¹Ã Â¥Â€Ã Â¤Â²Ã Â¤Â¿Ã Â¤Â¯Ã Â¤Â® Ã Â¤Â†Ã Â¤Â¯Ã Â¤Â¨', '', '4', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, '1', 1, '<p>Which of&nbsp; the following costs is related to Marginal cost ?</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>', '<p>Ã Â¤Â¨Ã Â¤Â¿Ã Â¤Â®Ã Â¥ÂÃ Â¤Â¨Ã Â¤Â²Ã Â¤Â¿Ã Â¤Â–Ã Â¤Â¿Ã Â¤Â¤ Ã Â¤Â•Ã Â¤Â¿Ã Â¤Â¸ Ã Â¤Â²Ã Â¤Â¾Ã Â¤Â—Ã Â¤Â¤ Ã Â¤Â•Ã Â¤Â¾ Ã Â¤Â¸Ã Â¤Â‚Ã Â¤Â¬Ã Â¤Â‚Ã Â¤Â§ Ã Â¤Â¨Ã Â¥ÂÃ Â¤Â¯Ã Â¥Â‚Ã Â¤Â¨Ã Â¤Â¤Ã Â¤Â® Ã Â¤Â²Ã Â¤Â¾Ã Â¤Â—Ã Â¤Â¤ Ã Â¤Â¸Ã Â¥Â‡ Ã Â¤Â¹Ã Â¥Âˆ?</p>\r\n\r\n<p>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</p>', 1, 'Variable cost', 'fixed cost', 'implicit cost', 'prime cost', '', 'Ã Â¤ÂªÃ Â¤Â°Ã Â¤Â¿Ã Â¤ÂµÃ Â¤Â°Ã Â¥ÂÃ Â¤Â¤Ã Â¥Â€ Ã Â¤Â²Ã Â¤Â¾Ã Â¤Â—Ã Â¤Â¤', 'Ã Â¤Â¸Ã Â¥ÂÃ Â¤Â¥Ã Â¤Â¿Ã Â¤Â° Ã Â¤Â²Ã Â¤Â¾Ã Â¤Â—Ã Â¤Â¤', 'Ã Â¤Â…Ã Â¤Â¸Ã Â¥ÂÃ Â¤ÂªÃ Â¤Â·Ã Â¥ÂÃ Â¤ÂŸ Ã Â¤Â²Ã Â¤Â¾Ã Â¤Â—Ã Â¤Â¤', 'Ã Â¤Â®Ã Â¥ÂÃ Â¤Â²Ã Â¤Â­Ã Â¥ÂÃ Â¤Â¤ Ã Â¤Â²Ã Â¤Â¾Ã Â¤Â—Ã Â¤Â¤', '', '3', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, '1', 1, '<p>The Mediterranean region are characterized by heavy rain in :</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;</p>', '<p>Ã Â¤Â…Ã Â¤Â¤Ã Â¥ÂÃ Â¤Â¯Ã Â¤Â§Ã Â¤Â¿Ã Â¤Â• Ã Â¤ÂµÃ Â¤Â°Ã Â¥ÂÃ Â¤Â·Ã Â¤Â¾ Ã Â¤Â•Ã Â¥Â‡ Ã Â¤Â•Ã Â¤Â¾Ã Â¤Â°Ã Â¤Â£ Ã Â¤Â­Ã Â¥Â‚Ã Â¤Â®Ã Â¤Â§Ã Â¥ÂÃ Â¤Â¯Ã Â¤Â¸Ã Â¤Â¾Ã Â¤Â—Ã Â¤Â°Ã Â¥Â€Ã Â¤Â¯ Ã Â¤Â•Ã Â¥ÂÃ Â¤Â·Ã Â¥Â‡Ã Â¤Â¤Ã Â¥ÂÃ Â¤Â° Ã Â¤ÂªÃ Â¤Â¹Ã Â¤ÂšÃ Â¤Â¾Ã Â¤Â¨Ã Â¤Â¾ Ã Â¤ÂœÃ Â¤Â¾Ã Â¤Â¤Ã Â¤Â¾ Ã Â¤Â¹Ã Â¥Âˆ :</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>', 1, 'Autumn', 'Winter', 'Summer', 'Spring', '', 'Ã Â¤ÂªÃ Â¤Â¤Ã Â¤ÂÃ Â¥Âœ Ã Â¤Â®Ã Â¥Â‡Ã Â¤Â‚', 'Ã Â¤Â¶Ã Â¥Â€Ã Â¤Â¤Ã Â¤Â•Ã Â¤Â¾Ã Â¤Â² Ã Â¤Â®Ã Â¥Â‡Ã Â¤Â‚', 'Ã Â¤Â—Ã Â¥ÂÃ Â¤Â°Ã Â¥Â€Ã Â¤Â·Ã Â¥ÂÃ Â¤Â® Ã Â¤Â•Ã Â¤Â¾Ã Â¤Â² Ã Â¤Â®Ã Â¥Â‡Ã Â¤Â‚', 'Ã Â¤ÂµÃ Â¤Â¸Ã Â¤Â‚Ã Â¤Â¤ Ã Â¤Â‹Ã Â¤Â¤Ã Â¥Â Ã Â¤Â®Ã Â¥Â‡Ã Â¤Â‚', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, '1', 1, '<p>The women&rsquo;s&nbsp; reservation bill seeks how much reservation for women in the state assemblies and Lok</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sabha ?</p>', '<p>&nbsp;Ã Â¤Â°Ã Â¤Â¾Ã Â¤ÂœÃ Â¥ÂÃ Â¤Â¯ Ã Â¤ÂµÃ Â¤Â¿Ã Â¤Â§Ã Â¤Â¾Ã Â¤Â¨ Ã Â¤Â¸Ã Â¤Â­Ã Â¤Â¾ Ã Â¤Â¤Ã Â¤Â¥Ã Â¤Â¾ Ã Â¤Â²Ã Â¥Â‹Ã Â¤Â• Ã Â¤Â¸Ã Â¤Â­Ã Â¤Â¾ Ã Â¤Â®Ã Â¥Â‡Ã Â¤Â‚ Ã Â¤Â®Ã Â¤Â¹Ã Â¤Â¿Ã Â¤Â²Ã Â¤Â¾Ã Â¤Â“Ã Â¤Â‚ Ã Â¤Â•Ã Â¥Â‡ Ã Â¤Â²Ã Â¤Â¿Ã Â¤Â¯Ã Â¥Â‡ Ã Â¤Â†Ã Â¤Â°Ã Â¤Â•Ã Â¥ÂÃ Â¤Â·Ã Â¤Â£ Ã Â¤Â¬Ã Â¤Â¿Ã Â¤Â² Ã Â¤Â®Ã Â¥Â‡Ã Â¤Â‚ Ã Â¤Â•Ã Â¤Â¿Ã Â¤Â¤Ã Â¤Â¨Ã Â¥Â‡ Ã Â¤Â†Ã Â¤Â°Ã Â¤Â•Ã Â¥ÂÃ Â¤Â·Ã Â¤Â£ Ã Â¤Â•Ã Â¥Â€ Ã Â¤Â¬Ã Â¤Â¾Ã Â¤Â¤ Ã Â¤Â•Ã Â¤Â¹Ã Â¥Â€</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp; Ã Â¤Â—Ã Â¤Âˆ Ã Â¤Â¹Ã Â¥Âˆ ?</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;\r\n<p>&nbsp;</p>\r\n</p>', 1, '36%', '25%', '30%', '33%', '', '36%', '36%', '30%', '33%', '', '4', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, '1', 1, '<p>&nbsp;the earth completes one rotation on its axis in :</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;</p>', '<p>Ã Â¤Â…Ã Â¤ÂªÃ Â¤Â¨Ã Â¥Â‡ Ã Â¤Â…Ã Â¤Â•Ã Â¥ÂÃ Â¤Â· Ã Â¤ÂªÃ Â¤Â° Ã Â¤ÂªÃ Â¥ÂÃ Â¤Â°Ã Â¤Â¥Ã Â¥ÂÃ Â¤ÂµÃ Â¥Â€ Ã Â¤ÂÃ Â¤Â• Ã Â¤ÂšÃ Â¤Â•Ã Â¥ÂÃ Â¤Â•Ã Â¤Â° Ã Â¤Â•Ã Â¤Â¿Ã Â¤Â¤Ã Â¤Â¨Ã Â¥Â‡ Ã Â¤Â¸Ã Â¤Â®Ã Â¤Â¯ Ã Â¤Â®Ã Â¥Â‡Ã Â¤Â‚ Ã Â¤ÂªÃ Â¥Â‚Ã Â¤Â°Ã Â¤Â¾ Ã Â¤Â•Ã Â¤Â°Ã Â¤Â¤Ã Â¥Â€ Ã Â¤Â¹Ã Â¥Âˆ?</p>', 1, '23h10min2sec', '23h30min', '23h56min4.9sec', '24 h', '', '23h10min2sec', '23h30min', '23h56min4.9sec', '24 h', '', '4', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, '1', 1, '<p>Xenobiotics which are inherently resistant to microbial attack are called as :</p>\r\n\r\n<p>&nbsp; &nbsp;&nbsp;&nbsp;</p>', '<p>Ã Â¤ÂœÃ Â¤Â¿Ã Â¤Â¨Ã Â¥Â‹Ã Â¤Â¬Ã Â¤Â¾Ã Â¤Â¯Ã Â¥Â‹Ã Â¤ÂŸÃ Â¤Â¿Ã Â¤Â•Ã Â¥ÂÃ Â¤Â¸ Ã Â¤ÂœÃ Â¥Â‹ Ã Â¤Â¸Ã Â¥Â‚Ã Â¤Â•Ã Â¥ÂÃ Â¤Â·Ã Â¥ÂÃ Â¤Â®Ã Â¤ÂœÃ Â¥Â€Ã Â¤ÂµÃ Â¤Â¿Ã Â¤Â¯ Ã Â¤Â†Ã Â¤Â•Ã Â¥ÂÃ Â¤Â°Ã Â¤Â®Ã Â¤Â£Ã Â¥Â‹Ã Â¤Â‚ Ã Â¤Â•Ã Â¥Â‡ Ã Â¤ÂªÃ Â¥ÂÃ Â¤Â°Ã Â¤Â¤Ã Â¤Â¿ Ã Â¤Â†Ã Â¤Â¨Ã Â¥ÂÃ Â¤ÂµÃ Â¤Â‚Ã Â¤Â¶Ã Â¤Â¿Ã Â¤Â• Ã Â¤Â°Ã Â¥Â‚Ã Â¤Âª Ã Â¤Â¸Ã Â¥Â‡ Ã Â¤ÂªÃ Â¥ÂÃ Â¤Â°Ã Â¤Â¤Ã Â¤Â¿Ã Â¤Â°Ã Â¥Â‹Ã Â¤Â§Ã Â¥Â€ Ã Â¤Â¹Ã Â¥Âˆ Ã Â¤ÂµÃ Â¤Â¹ Ã Â¤Â•Ã Â¤Â¹Ã Â¤Â²Ã Â¤Â¾Ã Â¤Â¤Ã Â¥Â‡ Ã Â¤Â¹Ã Â¥Âˆ :</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;</p>', 1, 'Biodegradable', 'persisten', 'Recalcitran', 'all of the above', '', 'Ã Â¤Â¬Ã Â¤Â¾Ã Â¤Â¯Ã Â¥Â‹Ã Â¤Â¡Ã Â¤Â¿Ã Â¤Â—Ã Â¥ÂÃ Â¤Â°Ã Â¥Â‡Ã Â¤Â¡Ã Â¥Â‡Ã Â¤Â¬Ã Â¤Â²', 'Ã Â¤ÂªÃ Â¤Â°Ã Â¤Â¸Ã Â¤Â¿Ã Â¤Â¸Ã Â¥ÂÃ Â¤ÂŸÃ Â¥ÂˆÃ Â¤Â¨Ã Â¥ÂÃ Â¤ÂŸ', 'Ã Â¤Â°Ã Â¤Â¿Ã Â¤Â•Ã Â¥ÂˆÃ Â¤Â²Ã Â¥ÂÃ Â¤Â¸Ã Â¥Â€Ã Â¤ÂŸÃ Â¥ÂÃ Â¤Â°Ã Â¥ÂˆÃ Â¤Â¨Ã Â¥ÂÃ Â¤ÂŸ', 'Ã Â¤Â‰Ã Â¤ÂªÃ Â¤Â°Ã Â¥ÂÃ Â¤Â¯Ã Â¥ÂÃ Â¤Â•Ã Â¥ÂÃ Â¤Â¤ Ã Â¤Â¸Ã Â¤Â­Ã Â¥Â€', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, '1', 1, '<p>The battle of Plassey was fought in year :</p>\r\n\r\n<p>&nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;&nbsp;</p>', '<p>Ã Â¤ÂªÃ Â¥ÂÃ Â¤Â²Ã Â¤Â¾Ã Â¤Â¸Ã Â¥Â€ Ã Â¤Â•Ã Â¤Â¾ Ã Â¤Â¯Ã Â¥ÂÃ Â¤Â¦Ã Â¥ÂÃ Â¤Â§ Ã Â¤Â•Ã Â¤Â¿Ã Â¤Â¸ Ã Â¤ÂµÃ Â¤Â°Ã Â¥ÂÃ Â¤Â· Ã Â¤Â¹Ã Â¥ÂÃ Â¤Â† Ã Â¤Â¥Ã Â¤Â¾?</p>', 1, '1761', '1757', '1775', '1576', '', '1761', '1757', '1775', '1576', '', '2', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, '1', 3, '<p>&nbsp;Who is the girl you were speaking with?</p>', '', 1, 'in', 'for', '''None', 'to', '', '', '', '', '', '', '4', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, '1', 3, '<p>This is the house I was born on.</p>', '', 1, 'beside', 'on', 'to', 'in', '', '', '', '', '', '', '4', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, '1', 3, '<p>&nbsp;What are you looking in?</p>', '', 1, 'in', 'on', 'at', 'for', '', '', '', '', '', '', '3', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, '1', 3, '<p>The manager has promised to look at the matter</p>', '', 1, 'into', 'upto', 'at', 'for', '', '', '', '', '', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, '1', 3, '<p>&nbsp;It has been raining from Monday.</p>', '', 1, 'since', 'None', 'From', 'in', '', '', '', '', '', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, '1', 3, '<p>&nbsp;I have been waiting from two hours.</p>', '', 1, 'from', 'for', 'since', 'at', '', '', '', '', '', '', '2', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, '1', 3, '<p>I will be attending the classes regularly since Monday.</p>', '', 1, 'since', 'From', 'in', 'at', '', '', '', '', '', '', '2', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, '1', 3, '<p>&nbsp;Divide the food among the children.</p>', '', 1, 'between', 'along', 'None', 'for', '', '', '', '', '', '', '3', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, '1', 3, '<p>We went to school by foot</p>', '', 1, 'on', 'by', 'with', 'at', '', '', '', '', '', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, '1', 3, '<p>Although businesses are less ________than they were before liberalization some parts of the economy remain_to restrictions.</p>', '', 1, 'fettered â€” subject', 'shunned â€” accessible', 'ignored â€” vulnerable', 'restrict â€” expose', '', '', '', '', '', '', '2', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, '1', 3, '<p>&nbsp;Today the city________free housing and hospitals and clean streets has become the______ of the entire country.</p>', '', 1, 'offers â€” example', 'known â€” pride', 'with â€” envy', 'providing â€” challenge', '', '', '', '', '', '', '2', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, '1', 2, '<p>Given:</p>\r\n\r\n<p>B&lt;C</p>\r\n\r\n<p>B&lt;D&lt;A</p>\r\n\r\n<p>Which of the following expressions is necessarily true?</p>', '', 1, 'C<D', 'D<C', 'C<A', 'None of the above', '', '', '', '', '', '', '4', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, '1', 2, '<p>K is an even number and</p>\r\n\r\n<p>P is an odd number.</p>\r\n\r\n<p>Which of the following statements is not correct?</p>', '', 1, 'P  â€“  K  â€“ 1 is an odd number', 'P  +  K  + 1 is an even number', 'P  Â·  K  +  P  is an odd number', 'P 2  +  K 2  + 1 is an even number', '', '', '', '', '', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, '1', 2, '<p>A liquid that fills a rectangular container whose dimensions are 2 cm x 10 cm x 20 cm is poured into a cylindrical container whose base radius is 5 cm.</p>\r\n\r\n<p>What height (in cm) will the surface of the liquid reach in the cylindrical container?</p>', '', 1, '16/ Ï€', '40/ Ï€', '8 Ï€', '8', '', '', '', '', '', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, '1', 2, '<p>The distance between points</p>\r\n\r\n<p>A</p>\r\n\r\n<p>and</p>\r\n\r\n<p>B is 400 meters.</p>\r\n\r\n<p>The distance between points B and C is 300 meters.</p>\r\n\r\n<p>It follows that the distance between points A and&nbsp; C is necessarily-</p>', '', 1, '100 m', '500 m', '700 m', 'It is impossible to determine from the information given.', '', '', '', '', '', '', '4', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, '1', 2, '<p>Pointing towards Vaman, Madhav said &ldquo;I am the only son of his father&rsquo;s one of the sons.&rdquo;<br />\r\n<br />\r\nHow Vaman is related to Madhav?</p>', '', 1, 'Nephew', 'Uncle', 'Either father or uncle', 'Father', '', '', '', '', '', '', '3', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, '1', 2, '<p>Pointing to a photograph, Vipul said, &quot;She is the daughter of my grandfather&#39;s only son.&quot;<br />\r\n<br />\r\nHow is Vipul related to the girl in the photograph ?</p>\r\n\r\n<table style="height:58px; width:16px">\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '', 1, 'Father', 'Brother', 'Uncle', 'Cousin', '', '', '', '', '', '', '2', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, '1', 2, '<p>Siva Reddy walked 2 km west of his house and then turned south covering 4 km. Finally,<br />\r\n<br />\r\nHe moved 3 km towards east and then again 1 km west. How far is he from his initial position?</p>', '', 1, '10 KM', '9 KM', '4 KM', '2 KM', '', '', '', '', '', '', '4', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, '1', 2, '<p>Rajesh&rsquo;s school bus is facing North when reaches his school. After starting from Rajesh&rsquo;s house,<br />\r\n<br />\r\nit turning twice and then left before reaching the school. What direction the bus facing when it<br />\r\n<br />\r\nleft the bus stop in front of Rajesh&rsquo;s house?</p>', '', 1, 'EAST', 'NORTH', 'SOUTH', 'WEST', '', '', '', '', '', '', '4', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, '1', 2, '<p>Anil wants to go the university. He starts from his house which is in the East and comes to a crossing.<br />\r\n<br />\r\nThe road to his left ends in a theatre, straight ahead is the hospital. In which direction is the<br />\r\n<br />\r\nUniversity?</p>', '', 1, 'EAST', 'NORTH', 'SOUTH', 'WEST', '', '', '', '', '', '', '2', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, '1', 2, '<p>BH : KQ : : FL : &hellip;&hellip;&hellip;.</p>', '', 1, 'PV', 'PQ', 'SV', 'SQ', '', '', '', '', '', '', '1', 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exm_stu_selected_ppr`
--

CREATE TABLE IF NOT EXISTS `tbl_exm_stu_selected_ppr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pkg_id` int(11) NOT NULL,
  `ppr_id` int(11) NOT NULL,
  `st_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `attempt_status` int(11) NOT NULL COMMENT '0=>not attempt 1=>attempt not completed 2=>attempt complete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_exm_stu_selected_ppr`
--

INSERT INTO `tbl_exm_stu_selected_ppr` (`id`, `pkg_id`, `ppr_id`, `st_id`, `start_date`, `end_date`, `attempt_status`) VALUES
(1, 1, 1, 1, '2016-05-20 22:15:23', '2016-07-09 22:15:23', 1),
(2, 1, 2, 1, '2016-05-20 22:15:23', '2016-05-20 22:15:23', 0),
(3, 1, 1, 2, '2016-05-20 22:20:14', '2016-07-09 22:20:14', 0),
(4, 1, 2, 2, '2016-05-20 22:20:14', '2016-05-20 22:20:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exm_st_select_pkg`
--

CREATE TABLE IF NOT EXISTS `tbl_exm_st_select_pkg` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `stu_id` bigint(20) NOT NULL,
  `pkg_id` bigint(20) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `paper_status` int(11) NOT NULL COMMENT '0=>''not yet attempt'' 1=>''attempted fully result pending'' ''2''=>Result Declared 3=>''attempted but remaining'' ',
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_exm_st_select_pkg`
--

INSERT INTO `tbl_exm_st_select_pkg` (`id`, `stu_id`, `pkg_id`, `start_date`, `end_date`, `paper_status`, `created_by`, `created`, `modified`) VALUES
(1, 1, 1, '2016-05-20 22:15:23', '2016-07-19 22:15:23', 0, 1, '2016-05-20 22:15:23', '0000-00-00 00:00:00'),
(2, 2, 1, '2016-05-20 22:20:14', '2016-07-19 22:20:14', 0, 1, '2016-05-20 22:20:14', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exm_subject`
--

CREATE TABLE IF NOT EXISTS `tbl_exm_subject` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `center_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_exm_subject`
--

INSERT INTO `tbl_exm_subject` (`id`, `name`, `description`, `center_id`, `created`, `modified`) VALUES
(1, 'GK', 'General Knowledge', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Reasoning', 'Reasoning QUESTIONS', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'English', 'english', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Mathematics', 'maths', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_locations`
--

CREATE TABLE IF NOT EXISTS `tbl_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mail_to` varchar(255) NOT NULL,
  `mail_cc` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_locations`
--

INSERT INTO `tbl_locations` (`id`, `name`, `mail_to`, `mail_cc`, `status`, `is_deleted`) VALUES
(1, 'JAIPUR', 'ABC@GMAIL.COM', 'BCQ', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pkg_opt`
--

CREATE TABLE IF NOT EXISTS `tbl_pkg_opt` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) NOT NULL,
  `pkg_id` bigint(20) NOT NULL,
  `price` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deactive_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qualification`
--

CREATE TABLE IF NOT EXISTS `tbl_qualification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_qualification`
--

INSERT INTO `tbl_qualification` (`id`, `name`, `description`, `created`, `modified`, `is_deleted`) VALUES
(2, 'Post Graduation', 'PG', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'Graduate', 'graduation', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'Certification', 'any certificate', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'Diploma', 'Diplome', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(6, 'others', 'others', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE IF NOT EXISTS `tbl_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `m_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `marital` varchar(50) NOT NULL,
  `street1` text NOT NULL,
  `street2` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `home_telephone` varchar(20) NOT NULL,
  `doc_detail` varchar(255) NOT NULL,
  `joining_date` date NOT NULL,
  `employee_type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `emer_relation` varchar(255) NOT NULL,
  `emer_mobile` varchar(255) NOT NULL,
  `emer_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `password` varchar(255) DEFAULT NULL,
  `batch_join` varchar(500) NOT NULL,
  `sub_course_join` varchar(500) NOT NULL,
  `study_center_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `batch_status` tinyint(2) NOT NULL DEFAULT '1',
  `pkg_opt` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=>not opt any pkg 1=>opted packages(refer tbl_exm_st_select_pkg)',
  `st_type` int(11) NOT NULL DEFAULT '1' COMMENT '1=>personal 2=>outer',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `modified` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `student_id`, `f_name`, `m_name`, `l_name`, `father_name`, `dob`, `marital`, `street1`, `street2`, `city`, `state`, `zipcode`, `home_telephone`, `doc_detail`, `joining_date`, `employee_type`, `email`, `mobile`, `emer_relation`, `emer_mobile`, `emer_name`, `image`, `gender`, `status`, `password`, `batch_join`, `sub_course_join`, `study_center_id`, `created`, `batch_status`, `pkg_opt`, `st_type`, `is_deleted`, `modified`) VALUES
(1, 'stu/20160520/1', 'anshul', 'test', 'pareek', 'vinay pareek', '1991-02-04', 'single', 'j-25 subhash marg', 'c-scheme', 'jaipur', 'rajasthan', '302001', '9799272385', '', '0000-00-00', '', 'anshulpareek@yahoo.com', '9799272385', 'self', '9829334878', 'anshul', '', 'M', 1, 'uklWyPtv', '1', '', 1, '0000-00-00 00:00:00', 1, 1, 1, 0, '0000-00-00'),
(2, 'stu/20160520/2', 'Neetu', 'sh', 'agarwal', 'test', '1989-12-22', 'single', 'test', 'test', 'test', 'rajasthan', '134234', '2342342342', '', '0000-00-00', '', 'neetuagrawal2009@gmail.com', '9799272385', 'askdf', '9799272385', 'anshul', '', 'F', 1, 'Y3IV68Gc', '1', '', 1, '0000-00-00 00:00:00', 1, 1, 1, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_exm_taken`
--

CREATE TABLE IF NOT EXISTS `tbl_student_exm_taken` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `attempt_ppr_id` int(11) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `ques_id` int(11) NOT NULL,
  `q_strt_time` bigint(20) NOT NULL,
  `q_end_time` bigint(20) NOT NULL,
  `ques_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=>not attempt 1=>attempt 2=>mark for review 3=>mark for last',
  `st_ans` tinyint(4) NOT NULL,
  `answer` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `tbl_student_exm_taken`
--

INSERT INTO `tbl_student_exm_taken` (`id`, `attempt_ppr_id`, `student_id`, `paper_id`, `sub_id`, `ques_id`, `q_strt_time`, `q_end_time`, `ques_status`, `st_ans`, `answer`, `created`, `modified`) VALUES
(1, 2, 1, 1, 1, 12, 0, 0, 0, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 2, 1, 1, 1, 21, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 1, 1, 1, 19, 0, 0, 4, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 1, 1, 1, 14, 0, 0, 4, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 2, 1, 1, 1, 13, 0, 0, 4, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 2, 1, 1, 1, 15, 0, 0, 4, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 2, 1, 1, 1, 18, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 2, 1, 1, 1, 22, 0, 0, 4, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 2, 1, 1, 1, 11, 0, 0, 4, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 2, 1, 1, 1, 20, 0, 0, 4, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 2, 1, 1, 2, 39, 0, 0, 4, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 2, 1, 1, 2, 40, 0, 0, 4, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 2, 1, 1, 2, 42, 0, 0, 4, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 2, 1, 1, 2, 43, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 2, 1, 1, 2, 37, 0, 0, 4, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 2, 1, 1, 2, 35, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 2, 1, 1, 2, 36, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 2, 1, 1, 2, 38, 0, 0, 4, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 2, 1, 1, 2, 41, 0, 0, 4, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 2, 1, 1, 2, 34, 0, 0, 4, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 2, 1, 1, 3, 27, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 2, 1, 1, 3, 23, 0, 0, 4, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 2, 1, 1, 3, 26, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 2, 1, 1, 3, 29, 0, 0, 4, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 2, 1, 1, 3, 31, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 2, 1, 1, 3, 25, 0, 0, 4, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 2, 1, 1, 3, 32, 0, 0, 4, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 2, 1, 1, 3, 24, 0, 0, 4, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 2, 1, 1, 3, 33, 0, 0, 4, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 2, 1, 1, 3, 28, 0, 0, 4, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 2, 1, 1, 4, 4, 0, 0, 4, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 2, 1, 1, 4, 8, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 2, 1, 1, 4, 9, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 2, 1, 1, 4, 3, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 2, 1, 1, 4, 6, 0, 0, 4, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 2, 1, 1, 4, 1, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 2, 1, 1, 4, 7, 0, 0, 4, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 2, 1, 1, 4, 10, 0, 0, 4, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 2, 1, 1, 4, 2, 0, 0, 4, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 2, 1, 1, 4, 5, 0, 0, 4, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stu_qualification`
--

CREATE TABLE IF NOT EXISTS `tbl_stu_qualification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `level` int(11) NOT NULL COMMENT 'refer qualification table',
  `discipline` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `passYear` varchar(20) NOT NULL,
  `gpa_score` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tbl_stu_qualification`
--

INSERT INTO `tbl_stu_qualification` (`id`, `emp_id`, `level`, `discipline`, `college`, `specialization`, `passYear`, `gpa_score`, `created`, `modified`) VALUES
(8, 3, 5, 'Full time', 'Enim perferendis quia nobis dolor aliquid cum numquam molestiae minim', 'Id ipsa do eligendi recusandae Aliquid voluptatum delectus sunt nobis esse quis totam sed maxime quo itaque ad corrupti iusto', '1985', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 4, 4, 'Distance learning', 'Ratione minima totam quia deleniti nulla assumenda est minima ipsa necessitatibus sit eveniet nostrum doloribus quia', 'Perferendis et aperiam elit corporis possimus nisi aliquam amet possimus et aliquid qui ea consequatur Repellendus Omnis dolorum mollitia dolor', '2011', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 2, 0, '', '', '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 1, 3, 'Full time', 'UOR, Jaipur', 'B A', '2015', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 6, 3, 'Distance learning', 'asdf', 'asdf', '2342', 23, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 2, 0, '', '', '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_course`
--

CREATE TABLE IF NOT EXISTS `tbl_sub_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_sub_course`
--

INSERT INTO `tbl_sub_course` (`id`, `course_id`, `name`, `description`, `created`, `modified`) VALUES
(1, 1, 'sbi clerk', 'clerk', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'SBI-PO', 'PO', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_group`
--

CREATE TABLE IF NOT EXISTS `tbl_user_group` (
  `id` bigint(15) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `group_description` varchar(255) NOT NULL,
  `access_location` varchar(255) NOT NULL,
  `access_center` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_user_group`
--

INSERT INTO `tbl_user_group` (`id`, `group_name`, `group_description`, `access_location`, `access_center`, `status`, `created_by`, `is_deleted`, `created`, `modified`) VALUES
(4, 'hr1', 'hr1', '1,2', '3,4,1,2', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'ADMIN', 'TESTING', '1', '1', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_permission`
--

CREATE TABLE IF NOT EXISTS `tbl_user_permission` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `can_read` tinyint(4) NOT NULL,
  `can_update` tinyint(4) NOT NULL,
  `can_delete` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `tbl_user_permission`
--

INSERT INTO `tbl_user_permission` (`id`, `group_id`, `role_id`, `can_read`, `can_update`, `can_delete`) VALUES
(1, 4, 14, 1, 1, 1),
(2, 4, 13, 1, 1, 1),
(3, 4, 12, 1, 1, 1),
(4, 4, 11, 1, 1, 1),
(5, 4, 10, 1, 1, 1),
(6, 4, 9, 1, 1, 1),
(7, 4, 8, 1, 1, 1),
(8, 4, 7, 1, 1, 1),
(9, 4, 6, 1, 1, 1),
(10, 4, 5, 1, 1, 1),
(11, 4, 4, 1, 1, 1),
(12, 4, 3, 1, 1, 1),
(13, 4, 2, 1, 1, 1),
(14, 4, 1, 1, 1, 1),
(53, 5, 3, 1, 1, 1),
(54, 5, 4, 1, 1, 1),
(55, 5, 5, 1, 1, 1),
(56, 5, 6, 1, 1, 1),
(57, 5, 7, 1, 1, 1),
(58, 5, 10, 1, 1, 1),
(59, 5, 11, 1, 1, 1),
(60, 5, 12, 1, 1, 1),
(61, 5, 13, 1, 1, 1),
(62, 5, 14, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_name` varchar(255) NOT NULL,
  `rol_page_name` varchar(255) NOT NULL,
  `rol_description` text NOT NULL,
  `rol_module` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tbl_user_roles`
--

INSERT INTO `tbl_user_roles` (`id`, `rol_name`, `rol_page_name`, `rol_description`, `rol_module`, `created`, `modified`) VALUES
(1, 'location listing', 'mstr_location_list', 'location add delete and listing', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'center Listing rights', 'mstr_center_list', 'Center listing and center create delete update', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'qualification listing', 'mstr_qualification_list', 'qualification add delete update', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'batch listing', 'batch_list', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Listing course', 'courseList', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'sub course list', 'subCourseList', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Employee Listing', 'employeeList', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'user group description', 'user_group_list', 'group listing', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'group permission', 'user_group_permission', 'permission for user group', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'student Listing', 'student_list', 'Listing all students for add and other operations', 2, '2016-02-18 00:00:00', '2016-02-26 00:00:00'),
(11, 'subject Listing', 'subjectList', 'Listing all subjects to add and other operations', 2, '2016-02-18 00:00:00', '2016-02-26 00:00:00'),
(12, 'Exam Package Listing', 'packageList', 'Listing all package to add and other operations', 2, '2016-02-18 00:00:00', '2016-02-26 00:00:00'),
(13, 'papers listing', 'paperList', 'listing all types of papers', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Questions listing', 'questionList', 'listing Questions', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

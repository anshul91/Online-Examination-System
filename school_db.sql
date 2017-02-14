-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2016 at 04:39 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE IF NOT EXISTS `tbl_city` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `created` date NOT NULL,
  `modified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class`
--

CREATE TABLE IF NOT EXISTS `tbl_class` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `class_teacher_id` int(11) NOT NULL,
  `sec_id` tinyint(4) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE IF NOT EXISTS `tbl_course` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`id`, `name`, `status`, `created_by`, `created`, `modified`) VALUES
(1, '', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, '', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'java', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'title', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'demo', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'none', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'none', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_roles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE IF NOT EXISTS `tbl_section` (
  `id` int(11) NOT NULL,
  `title` varchar(155) NOT NULL,
  `description` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_state`
--

CREATE TABLE IF NOT EXISTS `tbl_state` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_state`
--

INSERT INTO `tbl_state` (`id`, `title`, `created`, `modified`) VALUES
(1, '0', '2016-01-01', '2016-01-02'),
(2, '0', '2016-01-08', '2016-01-16'),
(3, '0', '0000-00-00', '0000-00-00'),
(4, 'Rajasthan', '0000-00-00', '0000-00-00'),
(5, '0', '0000-00-00', '0000-00-00'),
(6, '0', '0000-00-00', '0000-00-00'),
(7, '0', '0000-00-00', '0000-00-00'),
(8, '0', '0000-00-00', '0000-00-00'),
(9, '0', '0000-00-00', '0000-00-00'),
(10, '0', '0000-00-00', '0000-00-00'),
(11, '0', '0000-00-00', '0000-00-00'),
(12, '0', '0000-00-00', '0000-00-00'),
(13, '0', '0000-00-00', '0000-00-00'),
(14, '0', '0000-00-00', '0000-00-00'),
(15, '0', '0000-00-00', '0000-00-00'),
(16, '0', '0000-00-00', '0000-00-00'),
(17, '0', '0000-00-00', '0000-00-00'),
(18, '0', '0000-00-00', '0000-00-00'),
(19, '0', '0000-00-00', '0000-00-00'),
(20, '0', '0000-00-00', '0000-00-00'),
(21, '0', '0000-00-00', '0000-00-00'),
(22, '0', '0000-00-00', '0000-00-00'),
(23, '0', '0000-00-00', '0000-00-00'),
(24, '0', '0000-00-00', '0000-00-00'),
(25, '0', '0000-00-00', '0000-00-00'),
(26, '0', '0000-00-00', '0000-00-00'),
(27, '0', '0000-00-00', '0000-00-00'),
(28, '0', '0000-00-00', '0000-00-00'),
(29, '0', '0000-00-00', '0000-00-00'),
(30, '0', '0000-00-00', '0000-00-00'),
(31, '0', '0000-00-00', '0000-00-00'),
(32, '0', '0000-00-00', '0000-00-00'),
(33, '0', '0000-00-00', '0000-00-00'),
(34, '0', '0000-00-00', '0000-00-00'),
(35, '0', '0000-00-00', '0000-00-00'),
(36, '0', '0000-00-00', '0000-00-00'),
(37, '0', '0000-00-00', '0000-00-00'),
(38, '0', '0000-00-00', '0000-00-00'),
(39, '0', '0000-00-00', '0000-00-00'),
(40, '0', '0000-00-00', '0000-00-00'),
(41, '0', '0000-00-00', '0000-00-00'),
(42, '0', '0000-00-00', '0000-00-00'),
(43, '0', '0000-00-00', '0000-00-00'),
(44, '0', '0000-00-00', '0000-00-00'),
(45, '0', '0000-00-00', '0000-00-00'),
(46, '0', '0000-00-00', '0000-00-00'),
(47, '0', '0000-00-00', '0000-00-00'),
(48, '0', '0000-00-00', '0000-00-00'),
(49, '0', '0000-00-00', '0000-00-00'),
(50, '0', '0000-00-00', '0000-00-00'),
(51, '0', '0000-00-00', '0000-00-00'),
(52, '0', '0000-00-00', '0000-00-00'),
(53, '0', '0000-00-00', '0000-00-00'),
(54, '0', '0000-00-00', '0000-00-00'),
(55, '0', '0000-00-00', '0000-00-00'),
(56, '0', '0000-00-00', '0000-00-00'),
(57, '0', '0000-00-00', '0000-00-00'),
(58, '0', '0000-00-00', '0000-00-00'),
(59, '0', '0000-00-00', '0000-00-00'),
(60, '0', '0000-00-00', '0000-00-00'),
(61, '0', '0000-00-00', '0000-00-00'),
(62, '0', '0000-00-00', '0000-00-00'),
(63, '0', '0000-00-00', '0000-00-00'),
(64, '0', '0000-00-00', '0000-00-00'),
(65, '0', '0000-00-00', '0000-00-00'),
(66, '0', '0000-00-00', '0000-00-00'),
(67, '0', '0000-00-00', '0000-00-00'),
(68, '0', '0000-00-00', '0000-00-00'),
(69, '0', '0000-00-00', '0000-00-00'),
(70, '0', '0000-00-00', '0000-00-00'),
(71, '0', '0000-00-00', '0000-00-00'),
(72, '0', '0000-00-00', '0000-00-00'),
(73, 'Delhi', '0000-00-00', '0000-00-00'),
(74, 'Delhi', '0000-00-00', '0000-00-00'),
(75, 'Delhi', '0000-00-00', '0000-00-00'),
(76, 'Delhi', '0000-00-00', '0000-00-00'),
(77, 'Delhi', '0000-00-00', '0000-00-00'),
(78, 'Delhi', '0000-00-00', '0000-00-00'),
(79, 'Delhi', '0000-00-00', '0000-00-00'),
(80, 'Delhi', '0000-00-00', '0000-00-00'),
(81, 'Delhi', '0000-00-00', '0000-00-00'),
(82, 'Delhi', '0000-00-00', '0000-00-00'),
(83, 'Delhi', '0000-00-00', '0000-00-00'),
(84, 'Delhi', '0000-00-00', '0000-00-00'),
(85, 'Delhi', '0000-00-00', '0000-00-00'),
(86, 'Delhi', '0000-00-00', '0000-00-00'),
(87, 'Delhi', '0000-00-00', '0000-00-00'),
(88, 'Delhi', '0000-00-00', '0000-00-00'),
(89, 'Delhi', '0000-00-00', '0000-00-00'),
(90, 'Delhi', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE IF NOT EXISTS `tbl_students` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `sec_id` int(11) NOT NULL,
  `landline_no` varchar(15) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `gender` tinyint(2) NOT NULL,
  `state` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `address` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `created` varchar(255) NOT NULL,
  `modified` varchar(255) NOT NULL,
  `is_icard_issued` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`id`, `first_name`, `last_name`, `full_name`, `class_id`, `sec_id`, `landline_no`, `mobile_no`, `father_name`, `mother_name`, `gender`, `state`, `city`, `address`, `image`, `created_by`, `status`, `is_deleted`, `created`, `modified`, `is_icard_issued`) VALUES
(1, 'hello this is nm', '', '', 0, 0, '', '', '', '', 0, 0, 0, '', '', 0, 0, 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE IF NOT EXISTS `tbl_teacher` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `landline` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` tinyint(4) NOT NULL DEFAULT '0',
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `pincode` varchar(15) NOT NULL,
  `designation` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_group` int(11) NOT NULL,
  `pass_modified` datetime NOT NULL,
  `pass_algo` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_group`
--

CREATE TABLE IF NOT EXISTS `tbl_user_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_description` varchar(255) NOT NULL,
  `role_id` varchar(255) NOT NULL,
  `view_class` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_state`
--
ALTER TABLE `tbl_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_group`
--
ALTER TABLE `tbl_user_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tbl_state`
--
ALTER TABLE `tbl_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user_group`
--
ALTER TABLE `tbl_user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

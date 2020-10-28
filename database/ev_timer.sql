-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 28, 2020 at 10:17 AM
-- Server version: 5.7.21
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ev_timer`
--

-- --------------------------------------------------------

--
-- Table structure for table `current_timers`
--

DROP TABLE IF EXISTS `current_timers`;
CREATE TABLE IF NOT EXISTS `current_timers` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `task_id` int(8) NOT NULL,
  `status` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_started` bigint(20) NOT NULL,
  `elapsed_time` bigint(20) NOT NULL,
  `last_time_updated` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `current_timers`
--

INSERT INTO `current_timers` (`id`, `task_id`, `status`, `user_id`, `date_started`, `elapsed_time`, `last_time_updated`) VALUES
(37, 4, 'DONE', 17, 1599473450, 0, 1599481701),
(36, 2, 'DONE', 17, 1599424384, 10, 1599424394),
(35, 2, 'DONE', 17, 1599418845, 0, 1599419074),
(34, 4, 'DONE', 17, 1599407579, 5262, 1599412845),
(33, 4, 'DONE', 17, 1599368823, 15, 1599368839),
(32, 8, 'DONE', 17, 1599368435, 60, 1599368809),
(31, 4, 'DONE', 17, 1599368414, 5, 1599368419),
(30, 4, 'DONE', 17, 1599366821, 171, 1599366994),
(38, 2, 'DONE', 17, 1599497320, 0, 1599497322),
(39, 12, 'DONE', 17, 1599497390, 0, 1599497395),
(40, 3, 'DONE', 17, 1599497404, 0, 1599497408),
(41, 4, 'DONE', 17, 1599507431, 0, 1599507434),
(42, 8, 'DONE', 17, 1599579591, 0, 1599579595),
(43, 12, 'DONE', 17, 1599584617, 31, 1599584648),
(44, 42, 'DONE', 17, 1599596210, 19, 1599596229),
(45, 37, 'DONE', 17, 1599675190, 500, 1599675699),
(46, 37, 'DONE', 17, 1599675726, 12, 1599675738),
(47, 37, 'DONE', 17, 1599675863, 53, 1599675918),
(48, 37, 'DONE', 17, 1599676129, 76, 1599676208),
(49, 37, 'DONE', 17, 1599676400, 0, 1599676409),
(50, 37, 'DONE', 17, 1599676438, 0, 1599676442),
(51, 37, 'DONE', 17, 1599676591, 0, 1599676599),
(52, 37, 'DONE', 17, 1599676963, 6, 1599676969),
(53, 37, 'DONE', 17, 1599676942, 123, 1599677066),
(54, 37, 'DONE', 17, 1599677267, 83030, 1599760311),
(55, 12, 'DONE', 17, 1599824476, 0, 1599824480),
(56, 45, 'DONE', 17, 1599838244, 51, 1599838295),
(57, 45, 'DONE', 17, 1599838543, 0, 1599838547),
(58, 37, 'DONE', 17, 1599838562, 0, 1599838567),
(59, 45, 'DONE', 17, 1599839865, 0, 1599839871),
(60, 38, 'DONE', 17, 1599842756, 72, 1599842828),
(61, 45, 'DONE', 17, 1599850931, 0, 1599850941),
(62, 45, 'DONE', 17, 1599851234, 152, 1599852225),
(63, 47, 'DONE', 17, 1599852232, 0, 1599852267),
(64, 47, 'DONE', 17, 1599854306, 13, 1599854319),
(65, 47, 'DONE', 17, 1599854859, 1007, 1599856686),
(66, 37, 'DONE', 17, 1599856709, 108, 1599856818),
(67, 37, 'DONE', 17, 1600003783, 128, 1600003912),
(68, 45, 'DONE', 17, 1600004658, 212, 1600004873),
(69, 12, 'DONE', 17, 1600005044, 308, 1600005370),
(70, 45, 'DONE', 17, 1600005457, 17, 1600005477),
(71, 12, 'DONE', 17, 1600005099, 432, 1600005532),
(72, 12, 'DONE', 17, 1600006375, 6, 1600006382),
(73, 12, 'DONE', 17, 1600006124, 294, 1600006419),
(74, 12, 'DONE', 17, 1600006504, 35, 1600006540),
(75, 12, 'DONE', 17, 1600006532, 308, 1600006841),
(76, 12, 'DONE', 17, 1600006725, 235, 1600006961),
(77, 38, 'DONE', 17, 1600010777, 2162789, 1602173574),
(78, 45, 'DONE', 17, 1602182215, 0, 1602182224),
(79, 45, 'DONE', 17, 1602182310, 0, 1602182316),
(80, 53, 'DONE', 17, 1602459852, 0, 1602459978),
(81, 53, 'DONE', 17, 1602460101, 0, 1602460104),
(82, 53, 'DONE', 17, 1602460598, 0, 1602460613),
(83, 54, 'DONE', 17, 1602460618, 0, 1602460624),
(84, 53, 'DONE', 17, 1602460628, 0, 1602460792),
(85, 12, 'DONE', 17, 1602462998, 0, 1602463002),
(86, 47, 'DONE', 17, 1602463013, 0, 1602463025),
(87, 47, 'DONE', 17, 1602463031, 0, 1602463035),
(88, 54, 'DONE', 17, 1602466274, 0, 1602466306),
(89, 54, 'DONE', 17, 1602466367, 0, 1602466379),
(90, 54, 'DONE', 17, 1602466491, 28, 1602466520),
(91, 42, 'DONE', 17, 1603072149, 92, 1603077820),
(92, 37, 'DONE', 17, 1603821689, 34272, 1603855966);

-- --------------------------------------------------------

--
-- Table structure for table `password_request`
--

DROP TABLE IF EXISTS `password_request`;
CREATE TABLE IF NOT EXISTS `password_request` (
  `id` varchar(100) NOT NULL,
  `user_id` int(8) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shared_task`
--

DROP TABLE IF EXISTS `shared_task`;
CREATE TABLE IF NOT EXISTS `shared_task` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `task_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shared_task`
--

INSERT INTO `shared_task` (`id`, `task_id`, `user_id`) VALUES
(3, 2, 19),
(4, 4, 19),
(5, 8, 19),
(12, 45, 19),
(16, 38, 19),
(17, 44, 19);

-- --------------------------------------------------------

--
-- Table structure for table `shared_task_request`
--

DROP TABLE IF EXISTS `shared_task_request`;
CREATE TABLE IF NOT EXISTS `shared_task_request` (
  `id` varchar(100) NOT NULL,
  `timer_ids` varchar(100) NOT NULL,
  `email` varchar(500) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shared_task_request`
--

INSERT INTO `shared_task_request` (`id`, `timer_ids`, `email`, `date_created`, `date_updated`, `status`) VALUES
('5f95f98a1c851', '57', 'oninsm83@yahoo.com', '2020-10-25 10:17:46', '2020-10-25 10:41:12', 'ACCEPTED'),
('5f95e8c482e34', '38', 'oninsm83@yahoo.com', '2020-10-25 09:06:12', '2020-10-27 05:10:47', 'ACCEPTED'),
('5f984797b8978', '45', 'oninsm83@yahoo.com', '2020-10-27 04:15:19', '2020-10-27 04:48:00', 'ACCEPTED'),
('5f984aa0b7484', '45', 'oninsm83@yahoo.com', '2020-10-27 04:28:16', '2020-10-27 04:51:16', 'ACCEPTED'),
('5f984aad549e0', '38', 'oninsm83@yahoo.com', '2020-10-27 04:28:29', '2020-10-27 04:50:42', 'ACCEPTED'),
('5f98554822e35', '44', 'oninsm83@yahoo.com', '2020-10-27 05:13:44', '2020-10-27 05:14:21', 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `sub_tasks`
--

DROP TABLE IF EXISTS `sub_tasks`;
CREATE TABLE IF NOT EXISTS `sub_tasks` (
  `id` bigint(8) NOT NULL AUTO_INCREMENT,
  `parent_id` int(8) NOT NULL,
  `user_id` bigint(8) NOT NULL,
  `task_intervals` json DEFAULT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_tasks`
--

INSERT INTO `sub_tasks` (`id`, `parent_id`, `user_id`, `task_intervals`, `date_created`) VALUES
(89, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfasdfsdf\"}', '2020-10-11 10:38:36'),
(87, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdgsfgdsfg\"}', '2020-10-11 10:35:34'),
(88, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdgsfgdsfg\"}', '2020-10-11 10:35:34'),
(78, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdf\"}', '2020-10-11 10:24:12'),
(79, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdf\"}', '2020-10-11 10:24:14'),
(80, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"0:01:00\"], \"task_name\": [\"qweqwasd\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdf\"}', '2020-10-11 10:26:07'),
(81, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"dfgdfg\"}', '2020-10-11 10:29:57'),
(82, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdf\"}', '2020-10-11 10:31:16'),
(83, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdfsdf\"}', '2020-10-11 10:33:17'),
(84, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfdsfgdfg\"}', '2020-10-11 10:34:30'),
(85, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfdsfgdfg\"}', '2020-10-11 10:34:30'),
(86, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"\"}', '2020-10-11 10:35:12'),
(77, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdf\"}', '2020-10-11 10:24:10'),
(76, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"asdsad\"}', '2020-10-11 10:23:05'),
(75, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"asdsad\"}', '2020-10-11 10:23:05'),
(74, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"tyuzsdfasdf\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"asdasd\"}', '2020-10-11 10:15:02'),
(72, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"tyuzsdfasdf\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"asdasd\"}', '2020-10-11 10:14:53'),
(73, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"tyuzsdfasdf\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"asdasd\"}', '2020-10-11 10:14:57'),
(69, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdfsdf\"}', '2020-10-11 10:14:09'),
(70, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdfsdf\"}', '2020-10-11 10:14:09'),
(71, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"tyuzsdfasdf\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"asdasd\"}', '2020-10-11 10:14:48'),
(68, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdfsdf\"}', '2020-10-11 10:14:09'),
(90, 0, 17, '{\"id\": \"90\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"onin\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdfsd\"}', '2020-10-19 04:38:28'),
(91, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#e10e0e\", \"#000000\"], \"duration\": [\"0:02:00\", \"0:02:00\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"sdfasdf\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"hit\"}', '2020-10-11 12:45:28'),
(110, 0, 17, '{\"id\": \"108\", \"select\": \"on\", \"bg_color\": [\"#000000\", \"#000000\", \"#000000\", \"#000000\"], \"duration\": [\"0:02:00\", \"0:02:00\", \"0:01:00\", \"0:01:00\"], \"task_name\": [\"Rounds\", \"Break\", \"Warm Up\", \"Cool Down\"], \"text_color\": [\"#ffffff\", \"#ffffff\", \"#ffffff\", \"#ffffff\"], \"timer_type\": \"2\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Test \"}', '2020-10-19 04:37:29'),
(93, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"dfghfghfh\"}', '2020-10-11 12:46:22'),
(109, 0, 17, '{\"id\": \"107\", \"bg_color\": [\"#000000\"], \"duration\": [\"0:01:00\"], \"task_name\": [\"Finali4\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Finali \"}', '2020-10-19 04:37:29'),
(95, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"dfghfghfh\"}', '2020-10-11 12:46:22'),
(96, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Test hit\"}', '2020-10-11 03:23:26'),
(97, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"asdasdasd\"}', '2020-10-11 03:24:00'),
(98, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"werwer\"}', '2020-10-11 03:25:09'),
(99, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfasdfsad\"}', '2020-10-11 03:26:31'),
(100, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"asdfasdf\"}', '2020-10-11 03:31:10'),
(101, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdsadf\"}', '2020-10-11 03:32:00'),
(102, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsdf\"}', '2020-10-11 03:33:24'),
(103, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfasdf\"}', '2020-10-11 03:33:39'),
(104, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfasd\"}', '2020-10-11 03:34:12'),
(105, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"fdfgsdfg\", \"fdfgsdfg\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"New custom\"}', '2020-10-11 03:35:45'),
(106, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"Rounds\", \"Break\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"2\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Newwww\"}', '2020-10-11 03:36:48'),
(107, 0, 17, '{\"id\": \"107\", \"bg_color\": [\"#000000\"], \"duration\": [\"0:01:00\"], \"task_name\": [\"Finali4\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Finali \"}', '2020-10-12 01:18:46'),
(108, 0, 17, '{\"id\": \"108\", \"select\": \"on\", \"bg_color\": [\"#000000\", \"#000000\", \"#000000\", \"#000000\"], \"duration\": [\"0:02:00\", \"0:02:00\", \"0:01:00\", \"0:01:00\"], \"task_name\": [\"Rounds\", \"Break\", \"Warm Up\", \"Cool Down\"], \"text_color\": [\"#ffffff\", \"#ffffff\", \"#ffffff\", \"#ffffff\"], \"timer_type\": \"2\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Test \"}', '2020-10-12 01:32:12'),
(112, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#e10e0e\", \"#000000\"], \"duration\": [\"0:02:00\", \"0:02:00\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"sdfasdf\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"hit\"}', '2020-10-19 04:37:56'),
(114, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"dfghfghfh\"}', '2020-10-19 04:37:56'),
(115, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"Rounds\", \"Break\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"2\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Newwww\"}', '2020-10-19 04:37:56'),
(116, 0, 17, '{\"id\": \"107\", \"bg_color\": [\"#000000\"], \"duration\": [\"0:01:00\"], \"task_name\": [\"Finali4\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Finali \"}', '2020-10-19 04:39:49'),
(117, 0, 17, '{\"id\": \"108\", \"select\": \"on\", \"bg_color\": [\"#000000\", \"#000000\", \"#000000\", \"#000000\"], \"duration\": [\"0:02:00\", \"0:02:00\", \"0:01:00\", \"0:01:00\"], \"task_name\": [\"Rounds\", \"Break\", \"Warm Up\", \"Cool Down\"], \"text_color\": [\"#ffffff\", \"#ffffff\", \"#ffffff\", \"#ffffff\"], \"timer_type\": \"2\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Test \"}', '2020-10-19 04:39:49'),
(118, 0, 17, '{\"id\": \"107\", \"bg_color\": [\"#000000\"], \"duration\": [\"0:01:00\"], \"task_name\": [\"Finali4\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Finali \"}', '2020-10-19 04:40:31'),
(119, 0, 17, '{\"id\": \"108\", \"select\": \"on\", \"bg_color\": [\"#000000\", \"#000000\", \"#000000\", \"#000000\"], \"duration\": [\"0:02:00\", \"0:02:00\", \"0:01:00\", \"0:01:00\"], \"task_name\": [\"Rounds\", \"Break\", \"Warm Up\", \"Cool Down\"], \"text_color\": [\"#ffffff\", \"#ffffff\", \"#ffffff\", \"#ffffff\"], \"timer_type\": \"2\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Test \"}', '2020-10-19 04:40:31'),
(120, 0, 17, '{\"id\": \"120\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"ggggggggggg\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Onin\"}', '2020-10-19 04:41:55'),
(121, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#e10e0e\", \"#000000\"], \"duration\": [\"0:02:00\", \"0:02:00\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"sdfasdf\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"hit\"}', '2020-10-19 04:41:35'),
(122, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"dfghfghfh\"}', '2020-10-19 04:41:35'),
(123, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\"], \"duration\": [\"\"], \"task_name\": [\"\"], \"text_color\": [\"#ffffff\"], \"timer_type\": \"0\", \"instruction\": [\"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"dfghfghfh\"}', '2020-10-19 04:41:35'),
(124, 0, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"Rounds\", \"Break\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"2\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"Newwww\"}', '2020-10-19 04:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(8) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(8) NOT NULL,
  `task_intervals` json DEFAULT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `task_intervals`, `date_created`) VALUES
(37, 17, '{\"id\": \"37\", \"bg_color\": [\"#a70c0c\", \"#a70c0c\", \"#ffdd00\", \"#992929\"], \"duration\": [\"0:00:30\", \"0:00:30\", \"0:00:30\", \"0:00:30\"], \"task_name\": [\"sdfsdfg dsf g\", \"Test 101\", \"sdfgdsfgdsfg\", \"dsfgsdfgsdf\"], \"text_color\": [\"#b5b6e3\", \"#b5b6e3\", \"#000000\", \"#000000\"], \"instruction\": [\"James Lindenberg, the owner of BEC and an American engineer, was the first to apply for a license to the Philippine Congress to establish a television station in 1949. His request was granted on June 14, 1950, under Republic Act No. 511. Because of the strict import controls and the lack of raw materials needed to open a TV station in the Philippines during the mid-20th century, Lindenberg branched to radio broadcasting instead with the sign-on of experimental radio station DZBC.\", \"On June 16, 1955, Republic Act No. 1343 signed by President Ramon Magsaysay granted Manila Chronicle owner Eugenio Lopez, Sr. and former Vice President Fernando Lopez, a radio-TV franchise from the Congress and immediately established Chronicle Broadcasting Network (CBN) on September 24, 1956, which initially focused only on radio broadcasting.[18][19] On February 24, 1957, Lopez invited Judge Quirino to his house for breakfast and ABS was bought under a contract written on a table napkin. The corporate name was reverted to Bolinao Electronics Corporation immediately after the purchase of ABS.\", \"Judge Antonio Quirino, brother of former President Elpidio Quirino, also tried to apply for a license to Congress, but was denied. He later purchased stocks from BEC and subsequently consummated the controlling stock to rename the company from BEC to Alto Broadcasting System (ABS).\", \"As the People Power Revolution (commonly known as EDSA Revolution) broke out in early 1986, and Marcos\' grip on power debilitated, the reformists in the military contended the broadcasting network would be a vital asset for victory. Thus, at 10 am on February 24, 1986, they attacked and took the ABS-CBN Broadcast Center that was then the home of MBS-4[17] and the long hibernation of the station ended in March.\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"This is final Tasasd asd as\"}', '2020-09-09 06:12:47'),
(36, 17, '{\"id\": \"0\", \"bg_color\": [\"#7e2525\", \"#7e2525\", \"#5e95b0\"], \"duration\": [\"0:00:30\", \"0:00:15\", \"0:00:30\"], \"task_name\": [\"qweqwasd\", \"sdfgsdfg\", \"dsfgdf\"], \"text_color\": [\"#95a4b2\", \"#95a4b2\", \"#95a4b2\"], \"timer_set_name\": \"sdfsdfgsdfg\"}', '2020-09-08 05:05:01'),
(6, 18, '{\"id\": \"0\", \"bg_color\": [\"#00ffbf\"], \"duration\": [\"0:01:00\"], \"task_name\": [\"tyuzsdfasdf\"], \"text_color\": [\"#000000\"], \"timer_set_name\": \"My timer\"}', '2020-08-26 09:11:07'),
(46, 17, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"Rounds\", \"Break\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"2\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfsfgdf\"}', '2020-09-11 10:12:36'),
(42, 17, '{\"id\": \"42\", \"bg_color\": [\"#52bfc7\", \"#661515\", \"#ffffff\"], \"duration\": [\"0:00:15\", \"0:00:15\", \"0:00:15\"], \"task_name\": [\"Copy Test\", \"test\", \"testrr\"], \"text_color\": [\"#000000\", \"#e8e8e8\", \"#803333\"], \"instruction\": [\"dffs df sdf sd\", \"fgh fdh\\r\\n/\'sdm*m\", \"fgh dfdf\\r\\nasdasdsdf \' \\\"\"], \"number_of_sets\": \"2\", \"timer_set_name\": \"New test\"}', '2020-09-08 08:16:48'),
(44, 17, '{\"id\": \"44\", \"select\": \"on\", \"bg_color\": [\"#030236\", \"#c80909\", \"#d93a3a\", \"#0bb17a\"], \"duration\": [\"0:30:00\", \"0:30:00\", \"0:30:00\", \"0:30:00\"], \"task_name\": [\"Rounds\", \"Break\", \"Warm Up\", \"Cool Down\"], \"text_color\": [\"#ffffff\", \"#c15c5c\", \"#000000\", \"#000000\"], \"timer_type\": \"2\", \"instruction\": [\"sdfsdfsd\", \"sdfsdfsd\"], \"number_of_sets\": \"8\", \"timer_set_name\": \"This Round Timer test\"}', '2020-09-11 09:59:16'),
(47, 17, '{\"id\": \"47\", \"select\": \"on\", \"bg_color\": [\"#000000\", \"#000000\", \"#b71010\", \"#06365b\", \"#1d6e07\", \"#187c68\"], \"duration\": [\"0:01:00\", \"0:01:00\", \"0:00:15\", \"0:00:15\", \"0:00:15\", \"0:00:15\"], \"task_name\": [\"fgsdfgdsfgdfg\", \"fghfdhfgh\", \"Rest Between Sets\", \"Rest Between Intervals\", \"Warm Up\", \"Cool Down\"], \"text_color\": [\"#ffffff\", \"#ffffff\", \"#ffffff\", \"#ffffff\", \"#ffffff\", \"#ffffff\"], \"timer_type\": \"3\", \"instruction\": [\"fghfg\", \"fghfghfg\"], \"number_of_sets\": \"2\", \"timer_set_name\": \"Tabata\"}', '2020-09-11 05:12:59'),
(55, 17, '{\"id\": \"54\", \"select\": \"on\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"0:02:00\", \"0:03:00\"], \"task_name\": [\"Rest Between Sub-Timers\", \"Rest Between Cycles\"], \"sub_timers\": [\"109\", \"110\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"4\", \"number_of_sets\": \"1\", \"timer_set_name\": \"New Compound\"}', '2020-10-19 04:37:29'),
(56, 17, '{\"id\": \"56\", \"select\": \"on\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"0:03:00\", \"0:04:00\"], \"task_name\": [\"Rest Between Sub-Timers\", \"Rest Between Cycles\"], \"sub_timers\": [\"112\", \"114\", \"115\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"4\", \"number_of_sets\": \"1\", \"timer_set_name\": \"Compound\"}', '2020-10-19 04:44:19'),
(53, 17, '{\"id\": \"53\", \"select\": \"on\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"0:03:00\", \"0:04:00\"], \"task_name\": [\"Rest Between Sub-Timers\", \"Rest Between Cycles\"], \"sub_timers\": [\"90\", \"91\", \"93\", \"95\", \"106\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"4\", \"number_of_sets\": \"1\", \"timer_set_name\": \"Compound\"}', '2020-10-11 11:26:42'),
(54, 17, '{\"id\": \"54\", \"select\": \"on\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"0:02:00\", \"0:03:00\"], \"task_name\": [\"Rest Between Sub-Timers\", \"Rest Between Cycles\"], \"sub_timers\": [\"107\", \"108\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"4\", \"number_of_sets\": \"1\", \"timer_set_name\": \"New Compound\"}', '2020-10-12 01:32:41'),
(58, 19, '{\"id\": \"0\", \"bg_color\": [\"#000000\", \"#000000\"], \"duration\": [\"\", \"\"], \"task_name\": [\"High Intensity\", \"Low Intensity\"], \"text_color\": [\"#ffffff\", \"#ffffff\"], \"timer_type\": \"1\", \"instruction\": [\"\", \"\"], \"number_of_sets\": \"1\", \"timer_set_name\": \"sdfgdfgsdfg\"}', '2020-10-25 11:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`) VALUES
(17, 'onin', 'selarom', 'oninsm82@yahoo.com', '$1$easy-acc$nKtQi5a2tmyNFueT.HJkU.'),
(19, 'Enrico ', 'Villanueva', 'oninsm83@yahoo.com', '$1$easy-acc$nKtQi5a2tmyNFueT.HJkU.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

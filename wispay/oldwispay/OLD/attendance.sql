-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2022 at 01:28 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `rfid` int(11) NOT NULL,
  `adate` date NOT NULL,
  `clockin` time NOT NULL,
  `clockout` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `rfid`, `adate`, `clockin`, `clockout`) VALUES
(1, 875545675, '2022-09-29', '07:21:24', '17:30:32'),
(2, 348964583, '2022-09-30', '04:38:33', '18:02:12'),
(3, 344296695, '2022-09-30', '04:39:35', '18:01:42'),
(4, 343972599, '2022-09-30', '04:39:49', '18:01:27'),
(5, 350824167, '2022-09-30', '04:41:06', '18:01:11'),
(6, 811161397, '2022-09-30', '04:56:39', '16:31:47'),
(7, 338904807, '2022-09-30', '05:48:24', '17:29:50'),
(8, 873332811, '2022-09-30', '05:54:04', '16:36:25'),
(9, 351520743, '2022-09-30', '05:55:00', '17:23:38'),
(10, 820907077, '2022-09-30', '05:55:15', '17:22:55'),
(11, 351640807, '2022-09-30', '06:05:41', '17:26:22'),
(12, 348962279, '2022-09-30', '06:19:45', '17:24:58'),
(13, 875436363, '2022-09-30', '06:23:06', '16:38:10'),
(14, 880200763, '2022-09-30', '06:23:20', '17:39:31'),
(15, 341977591, '2022-09-30', '06:23:34', '16:36:10'),
(16, 882856523, '2022-09-30', '06:23:48', '16:55:27'),
(17, 877457227, '2022-09-30', '06:24:03', '14:05:57'),
(18, 884265803, '2022-09-30', '06:24:17', '17:29:08'),
(19, 346959095, '2022-09-30', '06:24:30', '16:35:16'),
(20, 341866727, '2022-09-30', '06:24:44', '17:01:11'),
(21, 340848103, '2022-09-30', '06:27:45', '18:01:57'),
(22, 882833467, '2022-09-30', '06:28:13', '00:00:00'),
(23, 347794663, '2022-09-30', '06:29:16', '00:00:00'),
(24, 808930357, '2022-09-30', '06:34:35', '17:01:25'),
(25, 881590603, '2022-09-30', '06:39:48', '00:00:00'),
(26, 821374773, '2022-09-30', '06:42:28', '17:07:28'),
(27, 344793079, '2022-09-30', '06:49:09', '00:00:00'),
(28, 880696139, '2022-09-30', '06:50:00', '17:31:32'),
(29, 340325863, '2022-09-30', '06:50:15', '17:24:09'),
(30, 816397109, '2022-09-30', '06:52:07', '16:37:07'),
(31, 877775163, '2022-09-30', '06:52:20', '17:09:18'),
(32, 340025319, '2022-09-30', '06:52:34', '16:37:22'),
(33, 340270839, '2022-09-30', '06:52:48', '17:28:38'),
(34, 883292747, '2022-09-30', '06:53:02', '17:28:54'),
(35, 351834599, '2022-09-30', '06:53:18', '19:15:42'),
(36, 810368325, '2022-09-30', '06:54:04', '17:04:11'),
(37, 335943159, '2022-09-30', '06:54:21', '16:36:53'),
(38, 337012215, '2022-09-30', '06:54:35', '17:23:25'),
(39, 821070917, '2022-09-30', '06:54:48', '16:35:02'),
(40, 340342007, '2022-09-30', '06:55:02', '16:34:19'),
(41, 880403515, '2022-09-30', '06:55:15', '00:00:00'),
(42, 350332135, '2022-09-30', '06:55:31', '16:48:43'),
(43, 342126823, '2022-09-30', '06:55:44', '16:35:43'),
(44, 341913575, '2022-09-30', '06:55:58', '16:38:24'),
(45, 349531623, '2022-09-30', '06:56:11', '17:23:55'),
(79, 21778826, '2022-09-30', '07:27:00', '00:00:00'),
(47, 349531623, '2022-09-30', '06:56:47', '00:00:00'),
(48, 339754471, '2022-09-30', '06:57:02', '17:23:09'),
(49, 339665383, '2022-09-30', '06:57:16', '17:01:39'),
(50, 351120871, '2022-09-30', '06:58:54', '17:08:17'),
(51, 875696987, '2022-09-30', '07:07:18', '16:32:56'),
(52, 881317435, '2022-09-30', '07:09:45', '16:52:07'),
(53, 875545675, '2022-09-30', '07:10:00', '17:30:15'),
(54, 878054219, '2022-09-30', '07:11:28', '17:18:39'),
(55, 350191095, '2022-09-30', '07:11:42', '17:22:38'),
(56, 883939387, '2022-09-30', '07:12:06', '17:37:15'),
(57, 884403771, '2022-09-30', '07:13:10', '17:09:04'),
(58, 335584743, '2022-09-30', '07:13:23', '17:01:52'),
(59, 21778826, '2022-09-30', '07:15:39', '00:00:00'),
(60, 337605863, '2022-09-30', '07:16:02', '16:34:33'),
(61, 888139579, '2022-09-30', '07:16:16', '16:36:39'),
(62, 876277051, '2022-09-30', '07:17:08', '17:03:57'),
(63, 878677067, '2022-09-30', '07:17:21', '17:00:55'),
(64, 21778826, '2022-09-30', '07:17:23', '00:00:00'),
(65, 878781019, '2022-09-30', '07:17:35', '16:35:56'),
(66, 21778826, '2022-09-30', '07:17:49', '00:00:00'),
(67, 21778826, '2022-09-30', '07:18:19', '00:00:00'),
(68, 336370407, '2022-09-30', '07:18:38', '16:34:03'),
(69, 882111803, '2022-09-30', '07:20:57', '17:39:17'),
(70, 887963979, '2022-09-30', '07:21:23', '16:59:55'),
(71, 811599365, '2022-09-30', '07:23:58', '16:34:48'),
(72, 343239655, '2022-09-30', '07:24:11', '16:35:30'),
(73, 885392715, '2022-09-30', '07:24:26', '16:33:29'),
(74, 876812363, '2022-09-30', '07:25:01', '13:42:41'),
(75, 2147483647, '2022-09-30', '07:25:05', '00:00:00'),
(76, 876812363, '2022-09-30', '07:25:22', '00:00:00'),
(77, 336336887, '2022-09-30', '07:25:37', '16:31:08'),
(78, 809379653, '2022-09-30', '07:25:54', '17:30:17'),
(80, 341525751, '2022-09-30', '07:30:57', '16:41:35'),
(81, 21778826, '2022-09-30', '07:31:10', '00:00:00'),
(82, 881984331, '2022-09-30', '07:33:39', '17:44:07'),
(83, 886704203, '2022-09-30', '07:33:53', '17:30:04'),
(84, 336038903, '2022-09-30', '07:47:02', '17:32:46'),
(85, 886244443, '2022-09-30', '07:58:50', '15:26:30'),
(86, 21778826, '2022-09-30', '08:34:44', '00:00:00'),
(87, 21778826, '2022-09-30', '08:34:46', '00:00:00'),
(88, 21778826, '2022-09-30', '08:34:48', '00:00:00'),
(89, 338904807, '2022-10-01', '05:55:22', '00:00:00'),
(90, 341866727, '2022-10-01', '06:14:33', '00:00:00'),
(91, 808930357, '2022-10-01', '06:40:55', '00:00:00'),
(92, 810368325, '2022-10-01', '07:01:41', '00:00:00'),
(93, 347794663, '2022-10-01', '07:07:04', '00:00:00'),
(94, 351120871, '2022-10-01', '07:17:04', '00:00:00'),
(95, 821374773, '2022-10-01', '07:18:49', '00:00:00'),
(96, 340325863, '2022-10-01', '07:50:01', '00:00:00'),
(97, 339665383, '2022-10-01', '07:56:54', '00:00:00'),
(98, 351520743, '2022-10-01', '07:58:47', '00:00:00'),
(99, 348962279, '2022-10-01', '07:59:03', '00:00:00'),
(100, 809379653, '2022-10-01', '07:59:47', '00:00:00'),
(101, 336038903, '2022-10-01', '08:03:54', '00:00:00'),
(102, 878054219, '2022-10-01', '09:11:22', '15:00:00'),
(103, 341866727, '2022-10-01', '11:02:26', '00:00:00'),
(104, 809379653, '2022-10-01', '11:02:42', '00:00:00'),
(105, 348962279, '2022-10-01', '11:02:57', '00:00:00'),
(106, 821374773, '2022-10-01', '11:03:10', '00:00:00'),
(107, 808930357, '2022-10-01', '11:03:26', '00:00:00'),
(108, 339665383, '2022-10-01', '11:03:40', '00:00:00'),
(109, 2147483647, '2022-10-01', '11:03:44', '00:00:00'),
(110, 339665383, '2022-10-01', '11:03:58', '00:00:00'),
(111, 810368325, '2022-10-01', '11:04:12', '00:00:00'),
(112, 338904807, '2022-10-01', '11:04:26', '00:00:00'),
(113, 351520743, '2022-10-01', '11:04:43', '00:00:00'),
(114, 340325863, '2022-10-01', '11:05:03', '00:00:00'),
(115, 811161397, '2022-10-03', '04:52:34', '17:07:12'),
(116, 349531623, '2022-10-03', '05:49:15', '17:18:30'),
(117, 341977591, '2022-10-03', '06:23:32', '16:39:19'),
(118, 880200763, '2022-10-03', '06:23:46', '17:41:04'),
(119, 884265803, '2022-10-03', '06:24:01', '16:38:02'),
(120, 877457227, '2022-10-03', '06:24:16', '16:33:21'),
(121, 346959095, '2022-10-03', '06:24:30', '16:38:49'),
(122, 882856523, '2022-10-03', '06:24:44', '17:19:18'),
(123, 341866727, '2022-10-03', '06:24:58', '17:07:51'),
(124, 347794663, '2022-10-03', '06:28:57', '17:02:05'),
(125, 348962279, '2022-10-03', '06:31:26', '17:12:59'),
(126, 340848103, '2022-10-03', '06:32:05', '18:04:39'),
(127, 351834599, '2022-10-03', '06:37:57', '16:40:24'),
(128, 351640807, '2022-10-03', '06:46:20', '17:18:07'),
(129, 808930357, '2022-10-03', '06:46:59', '17:07:24'),
(130, 880696139, '2022-10-03', '06:48:40', '17:30:32'),
(131, 821374773, '2022-10-03', '06:51:08', '17:06:56'),
(132, 340270839, '2022-10-03', '06:54:30', '17:57:03'),
(133, 883292747, '2022-10-03', '06:54:44', '17:57:42'),
(134, 340342007, '2022-10-03', '06:55:01', '17:30:45'),
(135, 821070917, '2022-10-03', '06:55:14', '17:30:56'),
(136, 878768443, '2022-10-03', '06:55:28', '16:37:24'),
(137, 342126823, '2022-10-03', '06:55:41', '16:39:04'),
(138, 339754471, '2022-10-03', '06:55:55', '17:34:45'),
(139, 877775163, '2022-10-03', '06:56:09', '17:48:46'),
(140, 340025319, '2022-10-03', '06:56:23', '16:37:36'),
(141, 810368325, '2022-10-03', '06:57:41', '17:04:33'),
(142, 338904807, '2022-10-03', '06:58:01', '17:08:19'),
(143, 339665383, '2022-10-03', '06:58:59', '17:06:09'),
(144, 821959749, '2022-10-03', '06:59:59', '17:06:45'),
(145, 351120871, '2022-10-03', '07:02:26', '17:05:49'),
(146, 884403771, '2022-10-03', '07:02:55', '17:00:30'),
(147, 881317435, '2022-10-03', '07:03:28', '16:52:01'),
(148, 875696987, '2022-10-03', '07:04:31', '16:38:20'),
(149, 337605863, '2022-10-03', '07:05:17', '16:35:30'),
(150, 875436363, '2022-10-03', '07:07:01', '16:35:43'),
(151, 881463643, '2022-10-03', '07:08:02', '17:04:09'),
(152, 335584743, '2022-10-03', '07:12:30', '19:04:04'),
(153, 351826919, '2022-10-03', '07:12:59', '16:36:29'),
(154, 886704203, '2022-10-03', '07:13:20', '16:34:20'),
(155, 888139579, '2022-10-03', '07:13:38', '17:07:35'),
(156, 350191095, '2022-10-03', '07:14:01', '18:26:28'),
(157, 885392715, '2022-10-03', '07:15:32', '16:38:34'),
(158, 876812363, '2022-10-03', '07:15:46', '16:56:31'),
(159, 336370407, '2022-10-03', '07:16:00', '16:32:29'),
(160, 883939387, '2022-10-03', '07:17:25', '17:36:46'),
(161, 887963979, '2022-10-03', '07:17:39', '17:48:34'),
(162, 341525751, '2022-10-03', '07:19:37', '16:52:47'),
(163, 878677067, '2022-10-03', '07:20:01', '17:00:07'),
(164, 876277051, '2022-10-03', '07:20:15', '17:04:21'),
(165, 881984331, '2022-10-03', '07:20:30', '17:38:03'),
(166, 885236043, '2022-10-03', '07:23:15', '17:31:10'),
(167, 878781019, '2022-10-03', '07:23:28', '16:37:48'),
(168, 878054219, '2022-10-03', '07:23:42', '17:01:00'),
(169, 335943159, '2022-10-03', '07:24:10', '16:39:32'),
(170, 336336887, '2022-10-03', '07:24:25', '17:17:14'),
(171, 809379653, '2022-10-03', '07:24:40', '17:39:39'),
(172, 811599365, '2022-10-03', '07:24:55', '16:33:09'),
(173, 875545675, '2022-10-03', '07:26:30', '17:30:06'),
(174, 343239655, '2022-10-03', '07:27:46', '17:11:11'),
(175, 882111803, '2022-10-03', '07:28:01', '17:32:02'),
(176, 340325863, '2022-10-03', '07:45:31', '17:18:18'),
(177, 886244443, '2022-10-03', '07:48:32', '12:22:48'),
(178, 336038903, '2022-10-03', '07:53:00', '17:06:29'),
(179, 337012215, '2022-10-03', '08:02:43', '17:17:51'),
(180, 886166075, '2022-10-03', '07:09:51', '17:00:44'),
(181, 350824167, '2022-10-04', '04:34:31', '00:00:00'),
(182, 344296695, '2022-10-04', '04:34:45', '00:00:00'),
(183, 343972599, '2022-10-04', '04:34:58', '00:00:00'),
(184, 348964583, '2022-10-04', '04:43:26', '00:00:00'),
(185, 811161397, '2022-10-04', '04:50:57', '00:00:00'),
(186, 873332811, '2022-10-04', '05:26:02', '00:00:00'),
(187, 349531623, '2022-10-04', '05:52:07', '00:00:00'),
(188, 338904807, '2022-10-04', '05:52:40', '00:00:00'),
(189, 820907077, '2022-10-04', '05:53:59', '00:00:00'),
(190, 351520743, '2022-10-04', '05:59:33', '00:00:00'),
(191, 347794663, '2022-10-04', '06:21:28', '00:00:00'),
(192, 348962279, '2022-10-04', '06:24:49', '00:00:00'),
(193, 875436363, '2022-10-04', '06:25:13', '00:00:00'),
(194, 341977591, '2022-10-04', '06:25:25', '00:00:00'),
(195, 884265803, '2022-10-04', '06:25:36', '00:00:00'),
(196, 880200763, '2022-10-04', '06:25:47', '00:00:00'),
(197, 877457227, '2022-10-04', '06:26:00', '00:00:00'),
(198, 346959095, '2022-10-04', '06:26:11', '00:00:00'),
(199, 882856523, '2022-10-04', '06:26:24', '00:00:00'),
(200, 341866727, '2022-10-04', '06:26:36', '00:00:00'),
(201, 340848103, '2022-10-04', '06:27:27', '00:00:00'),
(202, 882833467, '2022-10-04', '06:28:24', '00:00:00'),
(203, 351834599, '2022-10-04', '06:28:35', '00:00:00'),
(204, 880696139, '2022-10-04', '06:28:47', '00:00:00'),
(205, 351728359, '2022-10-04', '06:28:59', '00:00:00'),
(206, 808930357, '2022-10-04', '06:41:14', '00:00:00'),
(207, 881317435, '2022-10-04', '06:42:41', '00:00:00'),
(208, 810368325, '2022-10-04', '06:49:33', '00:00:00'),
(209, 335943159, '2022-10-04', '06:50:19', '00:00:00'),
(210, 821070917, '2022-10-04', '06:50:30', '00:00:00'),
(211, 340342007, '2022-10-04', '06:50:42', '00:00:00'),
(212, 878768443, '2022-10-04', '06:50:54', '00:00:00'),
(213, 350191095, '2022-10-04', '06:51:06', '00:00:00'),
(214, 337012215, '2022-10-04', '06:51:17', '00:00:00'),
(215, 884403771, '2022-10-04', '06:51:28', '00:00:00'),
(216, 883292747, '2022-10-04', '06:51:41', '00:00:00'),
(217, 340270839, '2022-10-04', '06:51:52', '00:00:00'),
(218, 339754471, '2022-10-04', '06:52:04', '00:00:00'),
(219, 342126823, '2022-10-04', '06:52:18', '00:00:00'),
(220, 821374773, '2022-10-04', '06:52:29', '00:00:00'),
(221, 877775163, '2022-10-04', '06:52:41', '00:00:00'),
(222, 340025319, '2022-10-04', '06:52:53', '00:00:00'),
(223, 339665383, '2022-10-04', '06:56:02', '00:00:00'),
(224, 821959749, '2022-10-04', '06:56:38', '00:00:00'),
(225, 350332135, '2022-10-04', '06:59:03', '00:00:00'),
(226, 341913575, '2022-10-04', '06:59:14', '00:00:00'),
(227, 886704203, '2022-10-04', '07:01:09', '00:00:00'),
(228, 875696987, '2022-10-04', '07:02:47', '00:00:00'),
(229, 885392715, '2022-10-04', '07:03:41', '00:00:00'),
(230, 1051383107, '2022-10-04', '07:05:05', '00:00:00'),
(231, 1051383107, '2022-10-04', '07:05:18', '00:00:00'),
(232, 1051383107, '2022-10-04', '07:05:34', '00:00:00'),
(233, 1051383107, '2022-10-04', '07:05:48', '00:00:00'),
(234, 881463643, '2022-10-04', '07:06:03', '00:00:00'),
(235, 336370407, '2022-10-04', '07:06:45', '00:00:00'),
(236, 876812363, '2022-10-04', '07:09:38', '00:00:00'),
(237, 887963979, '2022-10-04', '07:10:10', '00:00:00'),
(238, 337605863, '2022-10-04', '07:10:33', '00:00:00'),
(239, 351826919, '2022-10-04', '07:12:09', '00:00:00'),
(240, 2147483647, '2022-10-04', '07:12:12', '00:00:00'),
(241, 351826919, '2022-10-04', '07:12:24', '00:00:00'),
(242, 672753124, '2022-10-04', '07:12:37', '00:00:00'),
(243, 888139579, '2022-10-04', '07:14:21', '00:00:00'),
(244, 878054219, '2022-10-04', '07:15:04', '00:00:00'),
(245, 875545675, '2022-10-04', '07:17:17', '00:00:00'),
(246, 341525751, '2022-10-04', '07:18:19', '00:00:00'),
(247, 878781019, '2022-10-04', '07:18:35', '00:00:00'),
(248, 335584743, '2022-10-04', '07:19:12', '00:00:00'),
(249, 876277051, '2022-10-04', '07:19:54', '00:00:00'),
(250, 336336887, '2022-10-04', '07:20:20', '00:00:00'),
(251, 343239655, '2022-10-04', '07:21:54', '00:00:00'),
(252, 883939387, '2022-10-04', '07:22:17', '00:00:00'),
(253, 809379653, '2022-10-04', '07:27:43', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `rfid` int(11) NOT NULL,
  `fname` text NOT NULL,
  `mname` text NOT NULL,
  `lname` text NOT NULL,
  `position` text NOT NULL,
  `dob` date NOT NULL,
  `email` text NOT NULL,
  `mobile` text NOT NULL,
  `vacchist` text NOT NULL,
  `photo` text NOT NULL,
  `isactive` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `rfid`, `fname`, `mname`, `lname`, `position`, `dob`, `email`, `mobile`, `vacchist`, `photo`, `isactive`) VALUES
(1, 875545675, 'Chester', 'Lacson', 'Sigua', 'Chief Information Technology Offficer', '1985-09-12', 'cio@westfields.edu.ph', '639292998228', 'Fully Vaccinated', 'siguachester.jpg', 1),
(2, 877341787, 'Myla ', 'Sales', 'Diano', 'Chief Operations Officer', '1967-09-19', 'myla.diano@westfields.edu.ph ', '639178627807', 'Fully Vaccinated', 'dianomyla.jpg', 1),
(3, 883939387, 'Valerie Anne', 'Ocampo', 'Santos', 'Chief Finance Officer', '1990-04-29', 'valerie.santos@westfields.edu.ph ', '639754601240', 'Fully Vaccinated', 'santosvalerie.jpg', 1),
(4, 881984331, 'Bryan', 'Balajonda', 'Manalac', 'Guidance Advisor', '1977-10-19', 'guidance@westfields.edu.ph', '639255406972', 'Fully Vaccinated', 'manalacbryan.jpg', 1),
(5, 339754471, 'Alexander', 'Villar', 'Fajardo', 'Admission Officer', '1992-05-05', 'alex.fajardo@westfields.edu.ph', '639397880363', 'Fully Vaccinated', 'fajardoalex.jpg', 1),
(6, 878054219, 'Michael Vincent', 'Sanchez', 'Tamayo', 'IT Officer / Safety Officer', '1996-01-18', 'mike.tamayo@westfields.edu.ph', '639216819206', 'Fully Vaccinated', 'tamayomichael.jpg', 1),
(7, 886166075, 'Freddie', 'Guanzon', 'Barcia', 'IT Officer / Tech Support Officer', '1979-11-30', 'freddie.barcia@westfields.edu.ph', '639164161751', 'Fully Vaccinated', 'barciafreddie.jpg', 1),
(8, 882111803, 'Rosette', 'Sagun', 'Tiglao', 'HR Payroll', '1995-07-21', 'hr@westfields.edu.ph', '639270458771', 'Fully Vaccinated', 'tiglaorosette.jpg', 1),
(9, 880696139, 'Joyce Kelly', 'T', 'Mallari', 'Accounts Receivable Officer', '1999-03-27', 'cashier@westfields.edu.ph', '639619764197', 'Fully Vaccinated', 'mallarijoyce.jpg', 1),
(10, 880200763, 'Juliber Anne', 'Canlas', 'Ombrog', 'Disbursement', '1994-09-18', 'juliber.ombrog@westfields.edu.ph', '639363111323', 'Fully Vaccinated', 'ombrogjulliber.jpg', 1),
(11, 886704203, 'Ana ', 'Avila', 'Ledesma', 'Bookstore Attendant / Purchasing Officer', '1982-06-25', 'ana. ledesma@westfields.edu.ph', '639097684267', 'Fully Vaccinated', 'ledesmaana.jpg', 1),
(12, 886244443, 'Abigail', 'S', 'Magtoto', 'Registrar', '1978-04-20', 'registrar@westfields.edu.ph', '639175811030', 'Fully Vaccinated', 'magtotoabigail.jpg', 1),
(13, 881317435, 'Ma. Elisa', 'M', 'Del Rosario', 'Primary School Teacher', '1969-07-10', 'elisa.delrosario@westfields.edu.ph', '639267072889', 'Fully Vaccinated', 'delrosarioelisa.jpg', 1),
(14, 883292747, 'Angelica', 'L', 'Ordanza', 'Primary School Teacher', '1997-01-25', 'angelica.ordanza@westfields.edu.ph', '639096933065', 'Fully Vaccinated', 'ordanzaangel.jpg', 1),
(15, 881590603, 'Niza', 'G ', 'Sanchez', 'Primary School Teacher', '1976-02-03', 'niza.sanchez@westfields.edu.ph', '639493049003', 'Fully Vaccinated', 'sanchezniza.jpg', 1),
(16, 882833467, 'Marites', 'L', 'Abrazaldo', 'Primary School Teacher', '1995-11-21', 'marites.abrazaldo@westfields.edu.ph', '639167006375', 'Fully Vaccinated', 'abrazaldomarites.jpg', 1),
(17, 884265803, 'Raymark Joseph', 'M', 'Dizon', 'Primary School Teacher', '1997-04-13', 'raymark.dizon@westfields.edu.ph', '639217591169', 'Fully Vaccinated', 'dizonraymark.jpg', 1),
(18, 876812363, 'Marina Lourdes', 'R', 'Limon', 'Primary School Teacher', '1980-02-24', 'marina.limon@westfields.edu.ph', '639178597392', 'Fully Vaccinated', 'limonmarina.jpg', 1),
(19, 877457227, 'Gigi Marie', 'L', 'Romero', 'Primary School Teacher', '1966-06-27', 'gigi.romero@westfields.edu.ph', '639750455760', 'Fully Vaccinated', 'romerogigi.jpg', 1),
(20, 881463643, 'Kimberly', '', 'Marshall', 'Primary School Teacher', '1987-08-15', 'kim.marshall@westfields.edu.ph', '639275904022', 'Fully Vaccinated', 'marshallkimberly.jpg', 1),
(21, 885236043, 'Mark Joseph', '', 'Cortez', 'Primary School Teacher', '1991-09-18', 'joseph.cortez@westfields.edu.ph', '639975103422', 'Fully Vaccinated', 'cortezjoseph.jpg', 1),
(22, 878781019, 'Gregory', 'R', 'Tamba', 'Primary School Teacher', '1987-08-29', 'powerpulses@yahoo.com', '639161866831', 'Fully Vaccinated', 'tambagregory.jpg', 1),
(23, 876277051, 'Manilyn', 'E', 'Macalino', 'Primary School Teacher', '1988-12-31', 'manilyn.macalino@westfields.edu.ph', '639267080277', 'Fully Vaccinated', 'macalinomanilyn.jpg', 1),
(25, 873332811, 'Marites', 'N', 'Ngitngit', 'Primary School Teacher', '1975-12-21', 'marites.ngitngit@westfields.edu.ph', '639269571406', 'Fully Vaccinated', 'ngitngitmarites.jpg', 1),
(26, 875436363, 'Cherish', 'C', 'Esmeria', 'Primary School Teacher', '1998-05-26', 'cherish.esmeria@westfields.edu.ph', '639653016112', 'Fully Vaccinated', 'esmeriacherish.jpg', 1),
(27, 340025319, 'Kristine Ann', '', 'Villanueva', 'Secondary School Teacher', '1996-09-18', 'kristine.villanueva@westfields.edu.ph', '639051384341', 'Fully Vaccinated', 'villanuevakristine.jpg', 1),
(28, 884403771, 'Eva', '', 'Villarin', 'Secondary School Teacher', '1995-06-09', 'eva.villarin@westfields.edu.ph', '639997813618', 'Fully Vaccinated', 'villarineva.jpg', 1),
(29, 887963979, 'Merrylyne', 'P', 'Cruz', 'Secondary School Teacher', '1991-09-26', 'merrylyne.cruz@westfields.edu.ph', '639067191346', 'Fully Vaccinated', 'cruzmerrylyne.jpg', 1),
(30, 880403515, 'Joseph', 'C', 'Dizon', 'Secondary School Teacher', '1997-03-22', 'jdizon0322@gmail.com', '639661817038', 'Fully Vaccinated', 'dizonjoseph.jpg', 1),
(31, 885392715, 'Aerol Christian', 'S', 'Carreon', 'Secondary School Teacher', '1997-04-22', 'aerolchristian042297@gmail.com', '639565301075', 'Fully Vaccinated', 'carreonaerol.jpg', 1),
(32, 888139579, 'Darell', 'C', 'Naguit', 'Secondary School Teacher', '1989-11-28', 'darell.naguit@westfields.edu.ph', '639356659900', 'Fully Vaccinated', 'naguitdarell.jpg', 1),
(33, 878677067, 'Justin Anthony ', 'Cura', 'Macalino', 'Secondary School Teacher', '1981-01-25', 'justin.macalino@westfields.edu.ph', '639279411411', 'Fully Vaccinated', 'macalinojustin.jpg', 1),
(34, 816397109, 'Recy Mae', 'Hipolito', 'Aquino', 'Secondary School Teacher', '1993-11-15', 'recy.aquino@westfields.edu.ph', '639213706926', 'Fully Vaccinated', 'aquinorecy.jpg', 1),
(35, 877775163, 'Jessa Marie', 'T', 'Reyes', 'Secondary School Teacher', '1995-02-19', 'jessa.reyes@westfields.edu.ph', '639057332574', 'Fully Vaccinated', 'reyesjessa.jpg', 1),
(36, 875696987, 'Maria Rowena', 'A', 'Timbreza', 'Secondary School Teacher', '1961-03-06', 'rowena.timbreza@westfields.edu.ph', '639691066215', 'Fully Vaccinated', 'timbrezarowena.jpg', 1),
(37, 878768443, 'Wendy Kate', 'C', 'Mendiola', 'Secondary School Teacher', '1993-10-22', 'wendy.mendiola@westfields.edu.ph', '639072850033', 'Fully Vaccinated', 'mendiolawendy.jpg', 1),
(38, 882856523, 'Nicetas', 'H', 'Lagazon', 'Secondary School Teacher', '1978-04-04', 'lagazonniczon@gmail.com', '639267829914', 'Fully Vaccinated', 'lagazonniczon.jpg', 1),
(39, 341525751, 'Tricia Lorraine', 'C', 'Navarro', 'Secondary School Teacher', '1993-07-14', 'tricia.navarro@westfields.edu.ph', '639178087938', 'Fully Vaccinated', 'navarrotricia.jpg', 1),
(40, 351834599, 'Kylie Jean', 'H', 'Miranda', 'Primary School Teacher', '1990-06-20', 'kylie.miranda@westfields.edu.ph', '639565268822', 'Fully Vaccinated', 'mirandakylie.jpg', 1),
(24, 337012215, 'Marjorie', 'A', 'Pulongbarit', 'Cafeteria Cashier', '1990-10-16', 'cafeteria@westfields.edu.ph', '', 'Fully Vaccinated', 'pulongbaritmarjorie.jpg', 1),
(41, 344793079, 'Patricia Ann', 'A', 'Quinto', 'Grade School', '1989-01-17', 'patricia.quinto@westfields.edu.ph', '639171301784\r\n', 'Fully Vaccinated', 'quintotrish.jpg', 1),
(42, 350191095, 'Kathrine', '', 'Aguilar', 'Teacher', '1980-05-23', 'kathrine.aguilar@westfields.edu.ph', '639263556616', 'Fully Vaccinated', 'aguilarkat.jpg', 1),
(43, 343239655, 'Abegail', 'D', 'Pangilinan', 'Teacher', '1997-12-14', 'abegail.pangilinan@westfields.edu.ph', '639355237884', 'Fully Vaccinated', 'pangilinanabegail.jpg', 1),
(44, 346894839, 'Sandy Adrianne', 'B', 'Roman', 'Teacher', '2000-05-18', 'sandy.roman@westfields.edu.ph', '639289765721', 'Fully Vaccinated', 'romansandy.jpg', 1),
(45, 350332135, 'Hazel', 'M', 'Sangil', 'Teacher', '1998-09-27', 'hazel.sangil@westfields.edu.ph', '639212312954', 'Fully Vaccinated', 'sangilhazel.jpg', 1),
(46, 335584743, 'Karen Joy', '', 'Arrieta', 'Teacher', '1988-03-03', 'karenjoy.arrieta@westfields.edu.ph', '639329801606', 'Fully Vaccinated', 'arrietakarenjoy.jpg', 1),
(47, 341977591, 'Valerie', '', 'Ramirez', 'Primary Teacher', '0000-00-00', 'valerie.ramirez@westfields.edu.ph', '639214402828', 'Fully Vaccinated', 'ramirezvalerie.jpg', 1),
(49, 351728359, 'Karen', 'P', 'Guinto', 'Grade School Teacher', '1985-12-14', 'karen.guinto@westfields.edu.ph', '639218840493', 'Fully Vaccinated', 'guintokaren.jpg', 1),
(50, 340270839, 'Desarie Ann', 'R', 'Mercado', 'Primary School Teacher', '1995-12-07', 'desarie.mercado@westfields.edu.ph', '639683741356', 'Fully Vaccinated', 'mercadojes.jpg', 1),
(51, 335943159, 'Rhoda', 'Rivera', 'Yabut', 'Primary Department Teacher', '1976-01-14', 'rhoda.yabut@westfields.edu.ph', '639190636138', 'Fully Vaccinated', 'yabutrhoda.jpg', 1),
(52, 820907077, 'Querubin', 'F', 'Rangasa', 'Head Chef', '1989-12-27', 'cafeteria@westfields.edu.ph', '639458669933', 'Fully Vaccinated', 'rangasaquerubin.jpg', 1),
(53, 340848103, 'Felipe', 'D', 'Cafe', 'School Guard', '1976-07-10', 'security@westfields.edu.ph', '639054780649', 'Fully Vaccinated', 'cafefelipe.jpg', 1),
(54, 821959749, 'Jessie', 'T', 'Guevarra', 'SSS - Gardener', '1977-12-03', 'sss@westfields.edu.ph', '639285376056', 'Fully Vaccinated', 'guevarrajessie.jpg', 1),
(55, 810368325, 'Rowena', 'H', 'Salonga', 'SSS - Housekeeping', '1969-05-11', 'sss@westfields.edu.ph', '639918030973', 'Fully Vaccinated', 'salongarowena.jpg', 1),
(56, 351120871, 'Reggie', 'M', 'Manumbas', 'Maintenance', '1986-11-07', 'sss@westfields.edu.ph', '639292466308', 'Fully Vaccinated', 'manumbasreggie.jpg', 1),
(57, 338904807, 'Gina', 'L', 'David', 'SSS - Housekeeping', '1967-06-20', 'sss@westfields.edu.ph', '639269584984', 'Fully Vaccinated', 'davidgina.jpg', 1),
(58, 821374773, 'Analyn', 'C', 'Vesoyo', 'SSS - Supervisor Housekeeping', '1974-11-01', 'sss@westfields.edu.ph', '639925202208', 'Fully Vaccinated', 'vesoyoana.jpg', 1),
(59, 811161397, 'Roy', 'N', 'Beltran', 'Shuttle Coordinator', '1970-05-21', 'transport@westfields.edu.ph', '639272412527', 'Fully Vaccinated', 'beltranroy.jpg', 1),
(60, 336336887, 'Adrian', 'V', 'Bernabe', 'High School Teacher', '1998-03-15', 'adrian.bernabe@westfields.edu.ph', '639605620473', 'Fully Vaccinated', 'bernabeadrian.jpg', 1),
(61, 347794663, 'Donn', 'D', 'Garcia', 'Maintenance', '1981-12-29', 'garciadonn9@gmail.com', '639300388592', 'Fully Vaccinated', 'donngarcia.jpg', 1),
(62, 336038903, 'John David', 'Torre', 'Macawile', 'Aircon Maintenance', '1998-11-15', 'cesarjohn03@gmail.com', '09653407694', 'Fully Vaccinated', 'johnmacawile.jpg', 0),
(63, 821070917, 'Agnes', 'D', 'Pangan', 'Teacher Aide', '1966-11-12', 'agnes.dungca@yahoo.com', '639154944190', 'Fully Vaccinated', 'agnesdunga.jpg', 1),
(64, 340342007, 'Mayjolyn', 'C', 'Laxamana', 'Teacher Aide', '0000-00-00', 'mayclxmn@gmail.com', '639564168281', 'Fully Vaccinated', 'mayjolynlaxamana.jpg', 1),
(65, 341593063, 'Eloisa', 'C', 'Junio', 'Housekeeping', '1977-01-13', '', '639753112382', 'Fully Vaccinated', 'eloisajunio.jpg', 1),
(66, 808930357, 'Jaysel', 'Pineda', 'Apelacio', 'Housekeeping', '1989-11-10', '', '', 'Fully Vaccinated', 'jayselapelcaio.jpg', 1),
(67, 348962279, 'Cynthia', 'P', 'Lagman', 'Housekeeping', '1979-08-27', 'cynlagman27@gmail.com', '639973745689', 'Fully Vaccinated', '', 1),
(68, 341866727, 'Leandro', 'P', 'Lagman', 'Housekeeping', '1976-02-10', 'lagmanleandro31@gmail.com', '639617647315', 'Fully Vaccinated', 'leandrolagman.jpg', 1),
(69, 351640807, 'Ruby Joyce', 'A', 'Oligario', 'Cafeteria Supervisor', '1990-02-02', '', '639472385954', 'Fully Vaccinated', 'rubyjoyceoligario.jpg', 1),
(70, 349531623, 'Pamela Marie', 'B', 'Liwanag', 'Assistant Cook', '1998-03-18', 'pamelaliwanag15@gmail.com', '639477916340', 'Fully Vaccinated', 'pamelamarieliwanag.jpg', 1),
(71, 351520743, 'Nilo', 'I', 'Cao', 'Assistant Cook', '1988-01-16', 'nilocao16@yahoo.com', '639155829505', 'Fully Vaccinated', 'nilocao.jpg', 1),
(72, 340325863, 'Harley Joi', 'G', 'Rivera', 'Kitchen Steward', '1992-12-05', 'joijoigascon@gmail.com', '639659565306', 'Fully Vaccinated', 'harleyjoirivera.jpg', 1),
(73, 344296695, 'Regielyn', 'G', 'Pingul', 'Helper Assistant', '1978-09-28', '', '639519668384', 'Fully Vaccinated', 'pingulregielyn.jpg', 1),
(74, 343972599, 'Roberto', 'C', 'Musni', 'Shuttle Driver', '1968-03-28', '', '639208942514', 'Fully Vaccinated', 'musniroberto.jpg', 1),
(75, 350824167, 'Edgar', 'C', 'Mercado', 'Shuttle Driver', '1969-10-29', '', '639169129396', 'Fully Vaccinated', 'mercadoedgar.jpg', 1),
(76, 346959095, 'Evelyn', 'E', 'Yandan', 'Grade School Teacher', '1979-01-25', 'evelyn.yandan@westfields.edu.ph', '639762030898', 'Fully Vaccinated', 'yandanevelyn.jpg', 1),
(77, 348964583, 'Romeo', '', 'Marsaba', 'School Bus Driver', '1971-03-20', '', '639551052001', 'Fully Vaccinated', 'marsabaromeo.jpg', 1),
(78, 809379653, 'Jessica', 'N', 'Garnado', 'Assistant Custodian', '1980-01-09', 'garnadojessica010980@gmail.com', '639161307284', 'Fully Vaccinated', 'garnadojessica.jpg', 1),
(79, 337605863, 'Flaviana Anjerica', 'D', 'Modesto', 'Teacher Aide', '1999-08-01', 'flavimodesto.03@gmail.com', '6369667644716', 'Fully Vaccinated', 'modestoflaviana.jpg', 1),
(80, 342126823, 'Maynard', 'M', 'Gabriel', 'High School Teacher ', '1994-05-17', 'maynard.gabriel@westfields.edu.p', '639352384461', 'Fully Vaccinated', 'gabrielmaynard.jpg', 1),
(81, 341913575, 'Angelica', 'D', 'Caparas', 'Teacher Aide', '1997-01-31', 'rgelcaps@gmail.com', '639972454157', 'Fully Vaccinated', 'caparasangelika.jpg', 1),
(82, 337981927, 'Christian', 'B', 'Manaloto', 'CAIE Teacher', '1975-09-22', 'christian.manaloto@westfields.edu.ph', '639328737890', 'Fully Vaccinated', 'manalotochristian.jpg', 1),
(83, 339665383, 'Chester Bryan', 'D', 'Castro', 'Student Support/House Keeping', '2000-12-10', 'chesterbryan1210@gmail.com', '639615571461', 'Fully Vaccinated', 'castrochester.jpg', 1),
(84, 336370407, 'Nehemiah', '', 'Lagman', 'Grade School Teacher', '1993-12-15', 'Lagmannehemiah@gmail.com', '639361150071', 'Fully Vaccinated', 'lagmannehemiah.jpg', 1),
(85, 351826919, 'Mona Liza', 'V', 'De Leon', 'Grade School Teacher', '1979-08-03', 'nmdeleon837@gmail.com', '639229072521', 'Fully Vaccinated', 'deleonmonaliza.jpg', 1),
(86, 811599365, 'Olivia', 'T', 'Gomez', 'Shadow Teacher', '0000-00-00', 'olivegomez0621@gmail.com', '639771416382', 'Fully Vaccinated', 'gomezolivia.jpg', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

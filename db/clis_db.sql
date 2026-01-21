-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2020 at 07:57 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `lab_package_list_test`
--

CREATE TABLE `lab_package_list_test` (
  `ID` int(11) NOT NULL,
  `Lab_package_test_id` int(11) NOT NULL,
  `Lab_test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_package_list_test`
--

INSERT INTO `lab_package_list_test` (`ID`, `Lab_package_test_id`, `Lab_test_id`) VALUES
(2, 1, 3),
(3, 1, 4),
(4, 1, 5),
(5, 1, 6),
(6, 1, 7),
(7, 1, 8),
(9, 2, 3),
(10, 2, 4),
(11, 2, 5),
(12, 2, 6),
(13, 3, 1),
(14, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `lab_package_test`
--

CREATE TABLE `lab_package_test` (
  `ID` int(11) NOT NULL,
  `Package_name` varchar(255) DEFAULT NULL,
  `Price` double DEFAULT NULL,
  `Available` tinyint(1) NOT NULL DEFAULT 1,
  `Datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_package_test`
--

INSERT INTO `lab_package_test` (`ID`, `Package_name`, `Price`, `Available`, `Datetime_created`) VALUES
(1, 'Anniversary promo', 1185, 1, '2020-04-04 23:30:00'),
(2, 'Something', 200, 1, '2020-04-12 21:58:08'),
(3, '123', 9000, 1, '2020-07-27 23:22:14');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test`
--

CREATE TABLE `lab_test` (
  `ID` int(11) NOT NULL,
  `Abbreviation` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Price` double DEFAULT NULL,
  `Available` int(11) NOT NULL DEFAULT 0,
  `File_name` varchar(255) DEFAULT NULL,
  `Datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_test`
--

INSERT INTO `lab_test` (`ID`, `Abbreviation`, `Description`, `Price`, `Available`, `File_name`, `Datetime_created`) VALUES
(1, 'CBC', 'Complete Blood Count', 80, 1, 'CBC.xlsx', '2020-03-22 10:17:27'),
(3, 'HBsAg', 'Hepatitis B Surface Antigen', 100, 1, 'HBsAg.xlsx', '2020-03-22 10:17:27'),
(4, 'PREGNANCY TEST', 'Pregnancy test', 100, 1, 'PREG_TEST.xlsx', '2020-03-22 10:17:27'),
(5, 'RPR', 'Rapid Plasma Reagin', 230, 1, 'RPR.xlsx', '2020-03-22 10:17:27'),
(6, 'SPUTUM', 'SPUTUM', 100, 1, 'SPUTUM.xlsx', '2020-03-22 10:17:27'),
(7, 'ST', 'ST', 200, 1, 'ST.xlsx', '2020-03-22 10:17:27'),
(8, 'UA', 'Urinalysis', 200, 1, 'UA.xlsx', '2020-03-22 10:17:27'),
(22, 'Sample', 'Sample', 800, 0, 'file_example_XLS_10.xlsx', '2020-07-27 22:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_template`
--

CREATE TABLE `lab_test_template` (
  `ID` int(11) NOT NULL,
  `Lab_transaction_id` int(11) DEFAULT NULL,
  `Lab_test_id` int(11) DEFAULT NULL,
  `Label` varchar(255) DEFAULT NULL,
  `Value` varchar(255) DEFAULT NULL,
  `Coordinate` varchar(225) DEFAULT NULL,
  `Type` text DEFAULT NULL,
  `Datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_test_template`
--

INSERT INTO `lab_test_template` (`ID`, `Lab_transaction_id`, `Lab_test_id`, `Label`, `Value`, `Coordinate`, `Type`, `Datetime_created`) VALUES
(240, 1, 3, 'RESULT', 'Something', 'F,13', NULL, '2020-07-29 00:51:46'),
(241, 1, 3, 'Name', NULL, 'A,20', NULL, '2020-07-29 00:51:46'),
(242, 1, 3, 'Date', NULL, 'G,6', NULL, '2020-07-29 00:51:46'),
(243, 1, 3, 'Age', NULL, 'G,5', NULL, '2020-07-29 00:51:46'),
(244, 1, 3, 'Name', NULL, 'B,5', NULL, '2020-07-29 00:51:46'),
(245, 1, 3, 'Medtech', NULL, 'A,20', NULL, '2020-07-29 00:51:46'),
(246, 2, 4, 'RESULT', 'Positive yeah', 'E,14', NULL, '2020-07-29 00:51:46'),
(247, 2, 4, 'Name', NULL, 'B,5', NULL, '2020-07-29 00:51:46'),
(248, 2, 4, 'Age', NULL, 'G,5', NULL, '2020-07-29 00:51:46'),
(249, 2, 4, 'Date', NULL, 'G,6', NULL, '2020-07-29 00:51:46'),
(250, 2, 4, 'Medtech', NULL, 'A,20', NULL, '2020-07-29 00:51:46'),
(251, 3, 5, 'RESULT', NULL, 'F,13', NULL, '2020-07-29 00:51:46'),
(252, 3, 5, 'Name', NULL, 'B,5', NULL, '2020-07-29 00:51:46'),
(253, 3, 5, 'Date', NULL, 'G,6', NULL, '2020-07-29 00:51:46'),
(254, 3, 5, 'Age', NULL, 'G,5', NULL, '2020-07-29 00:51:46'),
(255, 3, 5, 'Medtech', NULL, 'A,20', NULL, '2020-07-29 00:51:46'),
(256, 3, 5, 'Gender', NULL, 'I,5', NULL, '2020-07-29 00:51:46'),
(257, 4, 6, 'SPECIMEN # 1:', 'Sample3', 'E,13', NULL, '2020-07-29 00:51:46'),
(258, 4, 6, 'SPECIMEN # 2:', 'Sample4', 'E,14', NULL, '2020-07-29 00:51:46'),
(259, 4, 6, 'Name', NULL, 'B,5', NULL, '2020-07-29 00:51:46'),
(260, 4, 6, 'Date', NULL, 'G,6', NULL, '2020-07-29 00:51:46'),
(261, 4, 6, 'Age', NULL, 'G,5', NULL, '2020-07-29 00:51:46'),
(262, 4, 6, 'Medtech', NULL, 'A,20', NULL, '2020-07-29 00:51:46'),
(263, 5, 7, 'COLOR', NULL, 'B,12', NULL, '2020-07-29 00:51:46'),
(264, 5, 7, 'CONSISTENCY', NULL, 'B,13', NULL, '2020-07-29 00:51:46'),
(265, 5, 7, 'HELMINTHS', NULL, 'B,14', NULL, '2020-07-29 00:51:46'),
(266, 5, 7, 'OCCULT BLOOD', NULL, 'B,19', NULL, '2020-07-29 00:51:46'),
(267, 5, 7, 'PUS CELL', NULL, 'B,23', NULL, '2020-07-29 00:51:46'),
(268, 5, 7, 'RBC', NULL, 'B,24', NULL, '2020-07-29 00:51:46'),
(269, 5, 7, 'ASCARIS', NULL, 'E,12', NULL, '2020-07-29 00:51:46'),
(270, 5, 7, 'HOOKWORM', NULL, 'E,13', NULL, '2020-07-29 00:51:46'),
(271, 5, 7, 'TRICHURIS', NULL, 'E,14', NULL, '2020-07-29 00:51:46'),
(272, 5, 7, 'STRONGLYOIDES', NULL, 'E,15', NULL, '2020-07-29 00:51:46'),
(273, 5, 7, 'E.HISTOLYTICA - CYST', NULL, 'E,20', NULL, '2020-07-29 00:51:46'),
(274, 5, 7, 'E.HISTOLYTICA -TROPH', NULL, 'E,21', NULL, '2020-07-29 00:51:46'),
(275, 5, 7, 'E.COLI - CYST', NULL, 'E,23', NULL, '2020-07-29 00:51:46'),
(276, 5, 7, 'E.COLI - TROPH', NULL, 'E,24', NULL, '2020-07-29 00:51:46'),
(277, 5, 7, 'G. LAMBIA', NULL, 'I,12', NULL, '2020-07-29 00:51:46'),
(278, 5, 7, 'T. HONMINIS', NULL, 'I,13', NULL, '2020-07-29 00:51:46'),
(279, 5, 7, 'Name', NULL, 'B,7', NULL, '2020-07-29 00:51:46'),
(280, 5, 7, 'Date', NULL, 'I,5', NULL, '2020-07-29 00:51:46'),
(281, 5, 7, 'Age', NULL, 'G,7', NULL, '2020-07-29 00:51:46'),
(282, 5, 7, 'Gender', NULL, 'I,7', NULL, '2020-07-29 00:51:46'),
(283, 5, 7, 'Medtech', NULL, 'A,27', NULL, '2020-07-29 00:51:46'),
(284, 6, 8, 'COLOR', NULL, 'B,11', NULL, '2020-07-29 00:51:46'),
(285, 6, 8, 'TRANSPARENCY', NULL, 'B,12', NULL, '2020-07-29 00:51:46'),
(286, 6, 8, 'PH', NULL, 'B,13', NULL, '2020-07-29 00:51:46'),
(287, 6, 8, 'SPECIFIC GRAVITY', NULL, 'B,14', NULL, '2020-07-29 00:51:46'),
(288, 6, 8, 'REDUCING SUGAR', NULL, 'B,18', NULL, '2020-07-29 00:51:46'),
(289, 6, 8, 'PROTEIN', NULL, 'B,19', NULL, '2020-07-29 00:51:46'),
(290, 6, 8, 'PUS', NULL, 'E,11', NULL, '2020-07-29 00:51:46'),
(291, 6, 8, 'RBC', NULL, 'E,12', NULL, '2020-07-29 00:51:46'),
(292, 6, 8, 'YEAST', NULL, 'E,13', NULL, '2020-07-29 00:51:46'),
(293, 6, 8, 'SQUAMOUS', NULL, 'E,14', NULL, '2020-07-29 00:51:46'),
(294, 6, 8, 'RENAL', NULL, 'E,15', NULL, '2020-07-29 00:51:46'),
(295, 6, 8, 'BACTERIA', NULL, 'E,16', NULL, '2020-07-29 00:51:46'),
(296, 6, 8, 'HYALINE', NULL, 'E,18', NULL, '2020-07-29 00:51:46'),
(297, 6, 8, 'COURSE GRANULAR', NULL, 'E,19', NULL, '2020-07-29 00:51:46'),
(298, 6, 8, 'FINE GRADULAR', NULL, 'E,20', NULL, '2020-07-29 00:51:46'),
(299, 6, 8, 'PUS', NULL, 'E,21', NULL, '2020-07-29 00:51:46'),
(300, 6, 8, 'RBC', NULL, 'E,22', NULL, '2020-07-29 00:51:46'),
(301, 6, 8, 'WAXY', NULL, 'E,23', NULL, '2020-07-29 00:51:46'),
(302, 6, 8, 'AMORPHOUS URATES', NULL, 'I,11', NULL, '2020-07-29 00:51:46'),
(303, 6, 8, 'AMORPHOUS PO4', NULL, 'I,12', NULL, '2020-07-29 00:51:46'),
(304, 6, 8, 'URIC ACID', NULL, 'I,13', NULL, '2020-07-29 00:51:46'),
(305, 6, 8, 'CALCIUM OXALATE', NULL, 'I,14', NULL, '2020-07-29 00:51:46'),
(306, 6, 8, 'TRIPLE PO4', NULL, 'I,15', NULL, '2020-07-29 00:51:46'),
(307, 6, 8, 'MURUS THREADS', NULL, 'I,18', NULL, '2020-07-29 00:51:46'),
(308, 6, 8, 'Name', NULL, 'B,6', NULL, '2020-07-29 00:51:46'),
(309, 6, 8, 'Date', NULL, 'H,4', NULL, '2020-07-29 00:51:46'),
(310, 6, 8, 'Age', NULL, 'G,6', NULL, '2020-07-29 00:51:46'),
(311, 6, 8, 'Gender', NULL, 'I,6', NULL, '2020-07-29 00:51:46'),
(312, 6, 8, 'Medtech', NULL, 'A,27', NULL, '2020-07-29 00:51:46'),
(313, 1, 3, 'RESULT', 'Something', 'F,13', NULL, '2020-07-29 00:51:59'),
(314, 7, 3, 'RESULT', 'Postive', 'F,13', NULL, '2020-07-29 00:51:59'),
(315, 1, 3, 'Name', NULL, 'A,20', NULL, '2020-07-29 00:51:59'),
(316, 7, 3, 'Name', NULL, 'A,20', NULL, '2020-07-29 00:51:59'),
(317, 1, 3, 'Date', NULL, 'G,6', NULL, '2020-07-29 00:51:59'),
(318, 7, 3, 'Date', NULL, 'G,6', NULL, '2020-07-29 00:51:59'),
(319, 1, 3, 'Age', NULL, 'G,5', NULL, '2020-07-29 00:51:59'),
(320, 7, 3, 'Age', NULL, 'G,5', NULL, '2020-07-29 00:51:59'),
(321, 1, 3, 'Name', NULL, 'B,5', NULL, '2020-07-29 00:51:59'),
(322, 7, 3, 'Name', NULL, 'B,5', NULL, '2020-07-29 00:51:59'),
(323, 1, 3, 'Medtech', NULL, 'A,20', NULL, '2020-07-29 00:51:59'),
(324, 7, 3, 'Medtech', NULL, 'A,20', NULL, '2020-07-29 00:51:59'),
(325, 2, 4, 'RESULT', 'Positive yeah', 'E,14', NULL, '2020-07-29 01:03:21'),
(326, 8, 4, 'RESULT', 'Sample', 'E,14', NULL, '2020-07-29 01:03:21'),
(327, 2, 4, 'Name', NULL, 'B,5', NULL, '2020-07-29 01:03:21'),
(328, 8, 4, 'Name', NULL, 'B,5', NULL, '2020-07-29 01:03:21'),
(329, 2, 4, 'Age', NULL, 'G,5', NULL, '2020-07-29 01:03:21'),
(330, 8, 4, 'Age', NULL, 'G,5', NULL, '2020-07-29 01:03:21'),
(331, 2, 4, 'Date', NULL, 'G,6', NULL, '2020-07-29 01:03:21'),
(332, 8, 4, 'Date', NULL, 'G,6', NULL, '2020-07-29 01:03:21'),
(333, 2, 4, 'Medtech', NULL, 'A,20', NULL, '2020-07-29 01:03:21'),
(334, 8, 4, 'Medtech', NULL, 'A,20', NULL, '2020-07-29 01:03:21'),
(335, 4, 6, 'SPECIMEN # 1:', 'Sample3', 'E,13', NULL, '2020-07-29 01:03:21'),
(336, 9, 6, 'SPECIMEN # 1:', 'Sample2', 'E,13', NULL, '2020-07-29 01:03:21'),
(337, 4, 6, 'SPECIMEN # 2:', 'Sample4', 'E,14', NULL, '2020-07-29 01:03:21'),
(338, 9, 6, 'SPECIMEN # 2:', 'Sample1', 'E,14', NULL, '2020-07-29 01:03:21'),
(339, 4, 6, 'Name', NULL, 'B,5', NULL, '2020-07-29 01:03:21'),
(340, 9, 6, 'Name', NULL, 'B,5', NULL, '2020-07-29 01:03:21'),
(341, 4, 6, 'Date', NULL, 'G,6', NULL, '2020-07-29 01:03:21'),
(342, 9, 6, 'Date', NULL, 'G,6', NULL, '2020-07-29 01:03:21'),
(343, 4, 6, 'Age', NULL, 'G,5', NULL, '2020-07-29 01:03:21'),
(344, 9, 6, 'Age', NULL, 'G,5', NULL, '2020-07-29 01:03:21'),
(345, 4, 6, 'Medtech', NULL, 'A,20', NULL, '2020-07-29 01:03:21'),
(346, 9, 6, 'Medtech', NULL, 'A,20', NULL, '2020-07-29 01:03:21'),
(347, 10, 1, 'HEMOGLOBIN', NULL, 'C,13', NULL, '2020-07-29 01:51:24'),
(348, 10, 1, 'SEGMENTERS', NULL, 'C,18', NULL, '2020-07-29 01:51:24'),
(349, 10, 1, 'STAB', NULL, 'C,19', NULL, '2020-07-29 01:51:24'),
(350, 10, 1, 'EOSINOPHLIS', NULL, 'C,20', NULL, '2020-07-29 01:51:24'),
(351, 10, 1, 'LYMPHOCYTES', NULL, 'C,21', NULL, '2020-07-29 01:51:24'),
(352, 10, 1, 'MONOCYTES', NULL, 'C,22', NULL, '2020-07-29 01:51:24'),
(353, 10, 1, 'BASOPHILS', NULL, 'C,23', NULL, '2020-07-29 01:51:24'),
(354, 10, 1, 'MYELOCYTES', NULL, 'C,24', NULL, '2020-07-29 01:51:24'),
(355, 10, 1, 'JUVENILES', NULL, 'C,25', NULL, '2020-07-29 01:51:24'),
(356, 10, 1, 'WBC', NULL, 'H,11', NULL, '2020-07-29 01:51:24'),
(357, 10, 1, 'RBC', NULL, 'H,12', NULL, '2020-07-29 01:51:24'),
(358, 10, 1, 'PLATELET COUNT', NULL, 'I,20', NULL, '2020-07-29 01:51:24'),
(359, 10, 1, 'ABO TYPE', NULL, 'I,22', NULL, '2020-07-29 01:51:24'),
(360, 10, 1, 'RH TYPE', NULL, 'I,23', NULL, '2020-07-29 01:51:24'),
(361, 10, 1, 'Name', NULL, 'B,5', NULL, '2020-07-29 01:51:24'),
(362, 10, 1, 'Date', NULL, 'F,5', NULL, '2020-07-29 01:51:24'),
(363, 10, 1, 'Age', NULL, 'F,6', NULL, '2020-07-29 01:51:24'),
(364, 10, 1, 'Gender', NULL, 'F,7', NULL, '2020-07-29 01:51:24'),
(365, 10, 1, 'Medtech', NULL, 'A,30', NULL, '2020-07-29 01:51:24'),
(366, 10, 1, 'HEMATOCRIT ', NULL, 'C,11', NULL, '2020-07-29 01:51:24'),
(367, 11, 7, 'COLOR', NULL, 'B,12', NULL, '2020-07-29 01:51:40'),
(368, 11, 7, 'CONSISTENCY', NULL, 'B,13', NULL, '2020-07-29 01:51:40'),
(369, 11, 7, 'HELMINTHS', NULL, 'B,14', NULL, '2020-07-29 01:51:40'),
(370, 11, 7, 'OCCULT BLOOD', NULL, 'B,19', NULL, '2020-07-29 01:51:40'),
(371, 11, 7, 'PUS CELL', NULL, 'B,23', NULL, '2020-07-29 01:51:40'),
(372, 11, 7, 'RBC', NULL, 'B,24', NULL, '2020-07-29 01:51:40'),
(373, 11, 7, 'ASCARIS', NULL, 'E,12', NULL, '2020-07-29 01:51:40'),
(374, 11, 7, 'HOOKWORM', NULL, 'E,13', NULL, '2020-07-29 01:51:40'),
(375, 11, 7, 'TRICHURIS', NULL, 'E,14', NULL, '2020-07-29 01:51:40'),
(376, 11, 7, 'STRONGLYOIDES', NULL, 'E,15', NULL, '2020-07-29 01:51:40'),
(377, 11, 7, 'E.HISTOLYTICA - CYST', NULL, 'E,20', NULL, '2020-07-29 01:51:40'),
(378, 11, 7, 'E.HISTOLYTICA -TROPH', NULL, 'E,21', NULL, '2020-07-29 01:51:40'),
(379, 11, 7, 'E.COLI - CYST', NULL, 'E,23', NULL, '2020-07-29 01:51:40'),
(380, 11, 7, 'E.COLI - TROPH', NULL, 'E,24', NULL, '2020-07-29 01:51:40'),
(381, 11, 7, 'G. LAMBIA', NULL, 'I,12', NULL, '2020-07-29 01:51:40'),
(382, 11, 7, 'T. HONMINIS', NULL, 'I,13', NULL, '2020-07-29 01:51:40'),
(383, 11, 7, 'Name', NULL, 'B,7', NULL, '2020-07-29 01:51:40'),
(384, 11, 7, 'Date', NULL, 'I,5', NULL, '2020-07-29 01:51:40'),
(385, 11, 7, 'Age', NULL, 'G,7', NULL, '2020-07-29 01:51:40'),
(386, 11, 7, 'Gender', NULL, 'I,7', NULL, '2020-07-29 01:51:40'),
(387, 11, 7, 'Medtech', NULL, 'A,27', NULL, '2020-07-29 01:51:40');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_template_config`
--

CREATE TABLE `lab_test_template_config` (
  `ID` int(11) NOT NULL,
  `Lab_test_id` int(11) NOT NULL,
  `Label` varchar(255) DEFAULT NULL,
  `Coordinate` varchar(255) DEFAULT NULL,
  `Show_field` tinyint(1) DEFAULT 1,
  `Type` varchar(225) DEFAULT NULL,
  `Datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_test_template_config`
--

INSERT INTO `lab_test_template_config` (`ID`, `Lab_test_id`, `Label`, `Coordinate`, `Show_field`, `Type`, `Datetime_created`) VALUES
(2, 1, 'HEMOGLOBIN', 'C,13', 1, NULL, '2020-06-23 01:38:21'),
(3, 1, 'SEGMENTERS', 'C,18', 1, NULL, '2020-03-31 22:49:07'),
(4, 1, 'STAB', 'C,19', 1, NULL, '2020-03-31 22:37:17'),
(5, 1, 'EOSINOPHLIS', 'C,20', 1, NULL, '2020-03-31 22:37:31'),
(6, 1, 'LYMPHOCYTES', 'C,21', 0, NULL, '2020-03-31 22:37:47'),
(7, 1, 'MONOCYTES', 'C,22', 0, NULL, '2020-03-31 22:49:08'),
(8, 1, 'BASOPHILS', 'C,23', 0, NULL, '2020-03-31 22:38:28'),
(9, 1, 'MYELOCYTES', 'C,24', 0, NULL, '2020-03-31 22:38:46'),
(10, 1, 'JUVENILES', 'C,25', 0, NULL, '2020-03-31 22:39:09'),
(11, 1, 'WBC', 'H,11', 0, NULL, '2020-03-31 22:39:34'),
(12, 1, 'RBC', 'H,12', 0, NULL, '2020-03-31 22:39:46'),
(13, 1, 'PLATELET COUNT', 'I,20', 0, NULL, '2020-03-31 22:40:13'),
(14, 1, 'ABO TYPE', 'I,22', 0, NULL, '2020-03-31 22:40:37'),
(15, 1, 'RH TYPE', 'I,23', 0, NULL, '2020-03-31 22:41:06'),
(16, 3, 'RESULT', 'F,13', 1, NULL, '2020-06-28 23:26:44'),
(17, 4, 'RESULT', 'E,14', 1, NULL, '2020-04-03 20:09:14'),
(18, 5, 'RESULT', 'F,13', 1, NULL, '2020-04-03 20:15:57'),
(19, 6, 'SPECIMEN # 1:', 'E,13', 1, NULL, '2020-04-03 20:16:50'),
(20, 6, 'SPECIMEN # 2:', 'E,14', 1, NULL, '2020-04-03 20:17:05'),
(21, 7, 'COLOR', 'B,12', 1, NULL, '2020-04-03 20:45:32'),
(22, 7, 'CONSISTENCY', 'B,13', 1, NULL, '2020-04-03 20:46:07'),
(24, 7, 'HELMINTHS', 'B,14', 1, NULL, '2020-04-03 20:47:29'),
(25, 7, 'OCCULT BLOOD', 'B,19', 1, NULL, '2020-04-03 20:48:04'),
(26, 7, 'PUS CELL', 'B,23', 1, NULL, '2020-04-03 20:48:27'),
(27, 7, 'RBC', 'B,24', 1, NULL, '2020-04-03 20:48:37'),
(28, 7, 'ASCARIS', 'E,12', 1, NULL, '2020-04-03 20:49:21'),
(29, 7, 'HOOKWORM', 'E,13', 1, NULL, '2020-04-03 20:49:45'),
(30, 7, 'TRICHURIS', 'E,14', 1, NULL, '2020-04-03 20:50:14'),
(31, 7, 'STRONGLYOIDES', 'E,15', 1, NULL, '2020-04-03 20:50:49'),
(32, 7, 'E.HISTOLYTICA - CYST', 'E,20', 1, NULL, '2020-04-03 20:52:02'),
(33, 7, 'E.HISTOLYTICA -TROPH', 'E,21', 1, NULL, '2020-04-03 20:52:21'),
(34, 7, 'E.COLI - CYST', 'E,23', 1, NULL, '2020-04-03 20:52:41'),
(35, 7, 'E.COLI - TROPH', 'E,24', 1, NULL, '2020-04-03 20:52:54'),
(36, 7, 'G. LAMBIA', 'I,12', 1, NULL, '2020-04-03 20:53:36'),
(37, 7, 'T. HONMINIS', 'I,13', 1, NULL, '2020-04-03 20:54:00'),
(38, 8, 'COLOR', 'B,11', 1, NULL, '2020-04-03 21:10:52'),
(39, 8, 'TRANSPARENCY', 'B,12', 1, NULL, '2020-04-03 21:11:09'),
(40, 8, 'PH', 'B,13', 1, NULL, '2020-04-03 21:11:26'),
(41, 8, 'SPECIFIC GRAVITY', 'B,14', 1, NULL, '2020-04-03 21:11:41'),
(42, 8, 'REDUCING SUGAR', 'B,18', 1, NULL, '2020-04-03 21:11:56'),
(43, 8, 'PROTEIN', 'B,19', 1, NULL, '2020-04-03 21:12:16'),
(44, 8, 'PUS', 'E,11', 1, NULL, '2020-04-03 21:12:31'),
(45, 8, 'RBC', 'E,12', 1, NULL, '2020-04-03 21:18:23'),
(46, 8, 'YEAST', 'E,13', 1, NULL, '2020-04-03 21:18:14'),
(47, 8, 'SQUAMOUS', 'E,14', 1, NULL, '2020-04-03 21:18:05'),
(48, 8, 'RENAL', 'E,15', 1, NULL, '2020-04-03 21:13:55'),
(49, 8, 'BACTERIA', 'E,16', 1, NULL, '2020-04-03 21:17:54'),
(50, 8, 'HYALINE', 'E,18', 1, NULL, '2020-04-03 21:14:59'),
(51, 8, 'COURSE GRANULAR', 'E,19', 1, NULL, '2020-04-03 21:15:23'),
(52, 8, 'FINE GRADULAR', 'E,20', 1, NULL, '2020-04-03 21:15:46'),
(53, 8, 'PUS', 'E,21', 1, NULL, '2020-04-03 21:16:03'),
(54, 8, 'RBC', 'E,22', 1, NULL, '2020-04-03 21:16:13'),
(55, 8, 'WAXY', 'E,23', 1, NULL, '2020-04-03 21:16:24'),
(56, 8, 'AMORPHOUS URATES', 'I,11', 1, NULL, '2020-04-03 21:19:18'),
(57, 8, 'AMORPHOUS PO4', 'I,12', 1, NULL, '2020-04-03 21:19:34'),
(58, 8, 'URIC ACID', 'I,13', 1, NULL, '2020-04-03 21:20:09'),
(59, 8, 'CALCIUM OXALATE', 'I,14', 1, NULL, '2020-04-03 21:20:28'),
(60, 8, 'TRIPLE PO4', 'I,15', 1, NULL, '2020-04-03 21:20:46'),
(61, 8, 'MURUS THREADS', 'I,18', 1, NULL, '2020-04-03 21:21:13'),
(62, 1, 'Name', 'B,5', 0, NULL, '2020-06-23 01:45:17'),
(63, 1, 'Date', 'F,5', 0, NULL, '2020-06-23 01:47:09'),
(64, 1, 'Age', 'F,6', 0, NULL, '2020-06-23 01:48:03'),
(65, 1, 'Gender', 'F,7', 0, NULL, '2020-06-23 01:48:16'),
(66, 1, 'Medtech', 'A,30', 0, NULL, '2020-06-23 01:50:08'),
(67, 1, 'HEMATOCRIT ', 'C,11', 1, NULL, '2020-06-28 20:52:05'),
(68, 3, 'Name', 'A,20', 0, NULL, '2020-06-28 23:29:19'),
(69, 3, 'Date', 'G,6', 0, NULL, '2020-06-28 23:29:49'),
(70, 3, 'Age', 'G,5', 0, NULL, '2020-06-28 23:30:04'),
(71, 3, 'Name', 'B,5', 0, NULL, '2020-06-28 23:30:31'),
(72, 4, 'Name', 'B,5', 0, NULL, '2020-06-29 01:45:45'),
(73, 4, 'Age', 'G,5', 0, NULL, '2020-06-29 01:48:24'),
(74, 4, 'Date', 'G,6', 0, NULL, '2020-06-29 01:46:58'),
(75, 4, 'Medtech', 'A,20', 0, NULL, '2020-06-29 01:47:53'),
(76, 5, 'Name', 'B,5', 0, NULL, '2020-06-29 01:51:41'),
(77, 5, 'Date', 'G,6', 0, NULL, '2020-06-29 01:52:01'),
(78, 5, 'Age', 'G,5', 0, NULL, '2020-06-29 01:53:35'),
(79, 5, 'Medtech', 'A,20', 0, NULL, '2020-06-29 01:54:46'),
(80, 7, 'Name', 'B,7', 0, NULL, '2020-06-29 02:02:51'),
(81, 7, 'Date', 'I,5', 0, NULL, '2020-06-29 02:03:21'),
(82, 7, 'Age', 'G,7', 0, NULL, '2020-06-29 02:04:36'),
(83, 7, 'Gender', 'I,7', 0, NULL, '2020-06-29 02:05:08'),
(84, 7, 'Medtech', 'A,27', 0, NULL, '2020-06-29 02:05:36'),
(85, 8, 'Name', 'B,6', 0, NULL, '2020-06-29 02:11:13'),
(86, 8, 'Date', 'H,4', 0, NULL, '2020-06-29 02:11:30'),
(87, 8, 'Age', 'G,6', 0, NULL, '2020-06-29 02:12:25'),
(88, 8, 'Gender', 'I,6', 0, NULL, '2020-06-29 02:12:42'),
(89, 8, 'Medtech', 'A,27', 0, NULL, '2020-06-29 02:13:15'),
(90, 5, 'Gender', 'I,5', 0, NULL, '2020-06-29 12:00:00'),
(91, 6, 'Name', 'B,5', 0, NULL, '2020-06-29 02:46:07'),
(92, 6, 'Date', 'G,6', 0, NULL, '2020-06-29 02:46:19'),
(93, 6, 'Age', 'G,5', 0, NULL, '2020-06-29 02:47:22'),
(94, 6, 'Medtech', 'A,20', 0, NULL, '2020-06-29 02:47:46'),
(95, 3, 'Medtech', 'A,20', 0, NULL, '2020-06-28 23:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_template_logs`
--

CREATE TABLE `lab_test_template_logs` (
  `ID` int(11) NOT NULL,
  `Lab_transaction_id` int(11) DEFAULT NULL,
  `Lab_test_id` int(11) DEFAULT NULL,
  `Label` varchar(255) DEFAULT NULL,
  `Value` varchar(255) DEFAULT NULL,
  `Coordinate` varchar(225) DEFAULT NULL,
  `Type` text DEFAULT NULL,
  `Datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lab_transaction`
--

CREATE TABLE `lab_transaction` (
  `ID` int(11) NOT NULL,
  `Transaction_number` int(10) UNSIGNED ZEROFILL DEFAULT 0000000001,
  `Mode_of_test_id` int(11) DEFAULT NULL,
  `Lab_package_test_id` int(11) DEFAULT NULL,
  `Lab_test_id` int(11) DEFAULT NULL,
  `Lab_transaction_status_id` int(11) DEFAULT NULL,
  `Patient_id` int(11) DEFAULT NULL,
  `Datetime_request` datetime DEFAULT NULL,
  `Datetime_ongoing` datetime DEFAULT NULL,
  `Datetime_release` datetime DEFAULT NULL,
  `Datetime_pickup` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_transaction`
--

INSERT INTO `lab_transaction` (`ID`, `Transaction_number`, `Mode_of_test_id`, `Lab_package_test_id`, `Lab_test_id`, `Lab_transaction_status_id`, `Patient_id`, `Datetime_request`, `Datetime_ongoing`, `Datetime_release`, `Datetime_pickup`) VALUES
(1, 0000000001, 2, 1, 3, 4, 1, '2020-07-29 00:51:46', '2020-07-29 00:53:19', '2020-07-29 00:53:53', '2020-07-29 00:55:36'),
(2, 0000000001, 2, 1, 4, 3, 1, '2020-07-29 00:51:46', '2020-07-29 01:04:01', '2020-07-29 01:05:09', NULL),
(3, 0000000001, 2, 1, 5, 1, 1, '2020-07-29 00:51:46', NULL, NULL, NULL),
(4, 0000000001, 2, 1, 6, 3, 1, '2020-07-29 00:51:46', '2020-07-29 01:04:07', '2020-07-29 01:04:52', NULL),
(5, 0000000001, 2, 1, 7, 1, 1, '2020-07-29 00:51:46', NULL, NULL, NULL),
(6, 0000000001, 2, 1, 8, 1, 1, '2020-07-29 00:51:46', NULL, NULL, NULL),
(7, 0000000002, 1, NULL, 3, 4, 1, '2020-07-29 00:51:59', '2020-07-29 00:53:25', '2020-07-29 00:53:40', '2020-07-29 00:54:49'),
(8, 0000000003, 1, NULL, 4, 3, 1, '2020-07-29 01:03:21', '2020-07-29 01:03:50', '2020-07-29 01:04:18', NULL),
(9, 0000000003, 1, NULL, 6, 3, 1, '2020-07-29 01:03:21', '2020-07-29 01:03:55', '2020-07-29 01:04:35', NULL),
(10, 0000000004, 1, NULL, 1, 1, 2, '2020-07-29 01:51:24', NULL, NULL, NULL),
(11, 0000000005, 1, NULL, 7, 1, 2, '2020-07-29 01:51:40', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lab_transaction_sent_out`
--

CREATE TABLE `lab_transaction_sent_out` (
  `ID` int(11) NOT NULL,
  `Transaction_number` int(10) UNSIGNED ZEROFILL DEFAULT 0000000001,
  `Lab_test` varchar(225) DEFAULT NULL,
  `Clinic_name` varchar(225) DEFAULT NULL,
  `Clinic_location` varchar(225) DEFAULT NULL,
  `Price` double DEFAULT NULL,
  `Lab_transaction_status_id` int(11) DEFAULT NULL,
  `Patient_id` int(11) DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL,
  `Datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lab_transaction_status`
--

CREATE TABLE `lab_transaction_status` (
  `ID` int(11) NOT NULL,
  `Status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_transaction_status`
--

INSERT INTO `lab_transaction_status` (`ID`, `Status`) VALUES
(1, 'Request'),
(2, 'Ongoing'),
(3, 'Release\r\n'),
(4, 'Pick up\r\n'),
(5, 'Sent out\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `mode_of_test`
--

CREATE TABLE `mode_of_test` (
  `ID` int(11) NOT NULL,
  `Mode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mode_of_test`
--

INSERT INTO `mode_of_test` (`ID`, `Mode`) VALUES
(1, 'Single '),
(2, 'Package');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `ID` int(11) NOT NULL,
  `First_name` varchar(225) DEFAULT NULL,
  `Middle_name` varchar(255) DEFAULT NULL,
  `Last_name` varchar(255) DEFAULT NULL,
  `Date_of_birth` date DEFAULT NULL,
  `Sex` varchar(255) DEFAULT NULL,
  `Phone_number` varchar(255) DEFAULT NULL,
  `Email_address` varchar(255) DEFAULT NULL,
  `Datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`ID`, `First_name`, `Middle_name`, `Last_name`, `Date_of_birth`, `Sex`, `Phone_number`, `Email_address`, `Datetime_created`) VALUES
(1, 'Kevin', ' ', ' ', '1998-04-02', 'Male', '09289342924', 'huelgasjcowork@gmail.com', '2020-03-22 08:37:14'),
(2, 'Bryan', ' ', 'Uguil', '2000-04-02', 'Male', '09238281832', 'sample@gmail.com', '2020-03-22 08:38:15'),
(3, 'Christian ', ' Buenaventura', 'Madregalejo', '1998-04-03', 'Male', '092382818321', 'christianmadregalejo@gmail.com', '2020-03-22 08:39:01'),
(4, 'Joseph ', 'Vallera', 'Hueljas', '1998-04-04', 'Male', '09238281832', 'sample@gmail.com', '2020-03-22 08:39:18'),
(5, 'Shaira', ' ', 'Mallari', '1998-04-05', 'Female', '09238281832', 'sample@gmail.com', '2020-03-22 08:39:32'),
(6, 'Jeffrey', ' ', 'Rizal', '1998-04-28', 'Male', '09289342924', 'sample@gmail.com', '2020-04-28 07:35:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `ID` int(11) NOT NULL,
  `User_position_id` int(11) DEFAULT NULL,
  `First_name` varchar(225) NOT NULL,
  `Middle_name` varchar(225) DEFAULT NULL,
  `Last_name` varchar(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Date_of_birth` date DEFAULT NULL,
  `Sex` varchar(100) DEFAULT NULL,
  `Phone_number` varchar(20) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1,
  `Image_file` text DEFAULT NULL,
  `Datetime_created` datetime DEFAULT NULL,
  `Datetime_deactivated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`ID`, `User_position_id`, `First_name`, `Middle_name`, `Last_name`, `Username`, `Password`, `Date_of_birth`, `Sex`, `Phone_number`, `Active`, `Image_file`, `Datetime_created`, `Datetime_deactivated`) VALUES
(1, 1, ' ', ' ', 'admin', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', '2020-03-29', 'Male', '09289342924', 1, '3.png', '2020-03-29 02:37:48', '2020-04-29 09:12:08'),
(2, 2, 'Hank', 'Lewis', 'Aaron', 'user1', '827ccb0eea8a706c4c34a16891f84e7b', '2020-03-29', 'Male', '09289342924', 1, '2.png', '2020-03-29 15:10:03', '2020-04-29 22:59:02'),
(3, 3, 'Jat', 'Babbitt', 'Abagnale', 'user2', '827ccb0eea8a706c4c34a16891f84e7b', '2020-03-29', 'Female', '09283282382', 1, '1.png', '2020-03-29 15:11:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_position`
--

CREATE TABLE `user_position` (
  `ID` int(11) NOT NULL,
  `Position` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_position`
--

INSERT INTO `user_position` (`ID`, `Position`) VALUES
(1, 'Admin'),
(2, 'Receptionist I'),
(3, 'Medical Technologist			');

-- --------------------------------------------------------

--
-- Table structure for table `user_transaction`
--

CREATE TABLE `user_transaction` (
  `ID` int(11) NOT NULL,
  `Lab_transaction_id` int(11) DEFAULT NULL,
  `Lab_transaction_status_id` int(11) DEFAULT NULL,
  `Patient_id` int(11) DEFAULT NULL,
  `User_account_id` int(11) DEFAULT NULL,
  `Datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_transaction`
--

INSERT INTO `user_transaction` (`ID`, `Lab_transaction_id`, `Lab_transaction_status_id`, `Patient_id`, `User_account_id`, `Datetime_created`) VALUES
(1, 1, 1, 1, 2, '2020-07-29 00:51:46'),
(2, 2, 1, 1, 2, '2020-07-29 00:51:46'),
(3, 3, 1, 1, 2, '2020-07-29 00:51:46'),
(4, 4, 1, 1, 2, '2020-07-29 00:51:47'),
(5, 5, 1, 1, 2, '2020-07-29 00:51:47'),
(6, 6, 1, 1, 2, '2020-07-29 00:51:47'),
(7, 1, 1, 1, 2, '2020-07-29 00:51:59'),
(8, 2, 1, 1, 2, '2020-07-29 00:51:59'),
(9, 3, 1, 1, 2, '2020-07-29 00:51:59'),
(10, 4, 1, 1, 2, '2020-07-29 00:51:59'),
(11, 5, 1, 1, 2, '2020-07-29 00:51:59'),
(12, 6, 1, 1, 2, '2020-07-29 00:51:59'),
(13, 7, 1, 1, 2, '2020-07-29 00:51:59'),
(14, 1, 2, 1, 3, '2020-07-29 00:53:19'),
(15, 7, 2, 1, 3, '2020-07-29 00:53:25'),
(16, 7, 3, 1, 3, '2020-07-29 00:53:40'),
(17, 1, 3, 1, 3, '2020-07-29 00:53:53'),
(18, 7, 4, 1, 3, '2020-07-29 00:54:49'),
(19, 1, 4, 1, 3, '2020-07-29 00:55:37'),
(20, 2, 1, 1, 2, '2020-07-29 01:03:21'),
(21, 3, 1, 1, 2, '2020-07-29 01:03:21'),
(22, 4, 1, 1, 2, '2020-07-29 01:03:21'),
(23, 5, 1, 1, 2, '2020-07-29 01:03:21'),
(24, 6, 1, 1, 2, '2020-07-29 01:03:21'),
(25, 8, 1, 1, 2, '2020-07-29 01:03:21'),
(26, 9, 1, 1, 2, '2020-07-29 01:03:21'),
(27, 8, 2, 1, 3, '2020-07-29 01:03:50'),
(28, 9, 2, 1, 3, '2020-07-29 01:03:55'),
(29, 2, 2, 1, 3, '2020-07-29 01:04:01'),
(30, 4, 2, 1, 3, '2020-07-29 01:04:07'),
(31, 8, 3, 1, 3, '2020-07-29 01:04:18'),
(32, 9, 3, 1, 3, '2020-07-29 01:04:35'),
(33, 4, 3, 1, 3, '2020-07-29 01:04:52'),
(34, 2, 3, 1, 3, '2020-07-29 01:05:09'),
(35, 10, 1, 2, 2, '2020-07-29 01:51:24'),
(36, 10, 1, 2, 2, '2020-07-29 01:51:40'),
(37, 11, 1, 2, 2, '2020-07-29 01:51:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lab_package_list_test`
--
ALTER TABLE `lab_package_list_test`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Lab_test_id` (`Lab_test_id`),
  ADD KEY `Lab_package_test_id` (`Lab_package_test_id`) USING BTREE;

--
-- Indexes for table `lab_package_test`
--
ALTER TABLE `lab_package_test`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `lab_test`
--
ALTER TABLE `lab_test`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `lab_test_template`
--
ALTER TABLE `lab_test_template`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Lab_transaction_id` (`Lab_transaction_id`),
  ADD KEY `Lab_test_id` (`Lab_test_id`);

--
-- Indexes for table `lab_test_template_config`
--
ALTER TABLE `lab_test_template_config`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Lab_test_id` (`Lab_test_id`);

--
-- Indexes for table `lab_test_template_logs`
--
ALTER TABLE `lab_test_template_logs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Lab_transaction_id` (`Lab_transaction_id`),
  ADD KEY `Lab_test_id` (`Lab_test_id`);

--
-- Indexes for table `lab_transaction`
--
ALTER TABLE `lab_transaction`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Mode_of_test_id` (`Mode_of_test_id`),
  ADD KEY `Lab_test_id` (`Lab_test_id`),
  ADD KEY `Lab_transaction_status_id` (`Lab_transaction_status_id`),
  ADD KEY `Patient_id` (`Patient_id`),
  ADD KEY `Lab_package_test_id` (`Lab_package_test_id`);

--
-- Indexes for table `lab_transaction_sent_out`
--
ALTER TABLE `lab_transaction_sent_out`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Lab_transaction_status_id` (`Lab_transaction_status_id`),
  ADD KEY `Patient_id` (`Patient_id`);

--
-- Indexes for table `lab_transaction_status`
--
ALTER TABLE `lab_transaction_status`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mode_of_test`
--
ALTER TABLE `mode_of_test`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`ID`,`First_name`),
  ADD KEY `User_position_id` (`User_position_id`);

--
-- Indexes for table `user_position`
--
ALTER TABLE `user_position`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_transaction`
--
ALTER TABLE `user_transaction`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Lab_transaction_id` (`Lab_transaction_id`),
  ADD KEY `Lab_transaction_status_ida` (`Lab_transaction_status_id`),
  ADD KEY `User_account_id` (`User_account_id`),
  ADD KEY `Patient_id` (`Patient_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lab_package_list_test`
--
ALTER TABLE `lab_package_list_test`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lab_package_test`
--
ALTER TABLE `lab_package_test`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lab_test`
--
ALTER TABLE `lab_test`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `lab_test_template`
--
ALTER TABLE `lab_test_template`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=388;

--
-- AUTO_INCREMENT for table `lab_test_template_config`
--
ALTER TABLE `lab_test_template_config`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `lab_test_template_logs`
--
ALTER TABLE `lab_test_template_logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_transaction`
--
ALTER TABLE `lab_transaction`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lab_transaction_sent_out`
--
ALTER TABLE `lab_transaction_sent_out`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_transaction_status`
--
ALTER TABLE `lab_transaction_status`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mode_of_test`
--
ALTER TABLE `mode_of_test`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_position`
--
ALTER TABLE `user_position`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_transaction`
--
ALTER TABLE `user_transaction`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lab_package_list_test`
--
ALTER TABLE `lab_package_list_test`
  ADD CONSTRAINT `lab_package_list_test_ibfk_1` FOREIGN KEY (`Lab_package_test_id`) REFERENCES `lab_package_test` (`ID`),
  ADD CONSTRAINT `lab_package_list_test_ibfk_2` FOREIGN KEY (`Lab_test_id`) REFERENCES `lab_test` (`ID`);

--
-- Constraints for table `lab_test_template`
--
ALTER TABLE `lab_test_template`
  ADD CONSTRAINT `lab_test_template_ibfk_1` FOREIGN KEY (`Lab_transaction_id`) REFERENCES `lab_transaction` (`ID`),
  ADD CONSTRAINT `lab_test_template_ibfk_2` FOREIGN KEY (`Lab_test_id`) REFERENCES `lab_test` (`ID`);

--
-- Constraints for table `lab_test_template_config`
--
ALTER TABLE `lab_test_template_config`
  ADD CONSTRAINT `lab_test_template_config_ibfk_1` FOREIGN KEY (`Lab_test_id`) REFERENCES `lab_test` (`ID`);

--
-- Constraints for table `lab_transaction`
--
ALTER TABLE `lab_transaction`
  ADD CONSTRAINT `lab_transaction_ibfk_2` FOREIGN KEY (`Lab_test_id`) REFERENCES `lab_test` (`ID`),
  ADD CONSTRAINT `lab_transaction_ibfk_3` FOREIGN KEY (`Lab_transaction_status_id`) REFERENCES `lab_transaction_status` (`ID`),
  ADD CONSTRAINT `lab_transaction_ibfk_4` FOREIGN KEY (`Patient_id`) REFERENCES `patient` (`ID`),
  ADD CONSTRAINT `lab_transaction_ibfk_6` FOREIGN KEY (`Mode_of_test_id`) REFERENCES `mode_of_test` (`ID`),
  ADD CONSTRAINT `lab_transaction_ibfk_7` FOREIGN KEY (`Lab_package_test_id`) REFERENCES `lab_package_test` (`ID`);

--
-- Constraints for table `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `user_account_ibfk_1` FOREIGN KEY (`User_position_id`) REFERENCES `user_position` (`ID`);

--
-- Constraints for table `user_transaction`
--
ALTER TABLE `user_transaction`
  ADD CONSTRAINT `user_transaction_ibfk_1` FOREIGN KEY (`User_account_id`) REFERENCES `user_account` (`ID`),
  ADD CONSTRAINT `user_transaction_ibfk_2` FOREIGN KEY (`Lab_transaction_id`) REFERENCES `lab_transaction` (`ID`),
  ADD CONSTRAINT `user_transaction_ibfk_3` FOREIGN KEY (`Lab_transaction_status_id`) REFERENCES `lab_transaction_status` (`ID`),
  ADD CONSTRAINT `user_transaction_ibfk_4` FOREIGN KEY (`Patient_id`) REFERENCES `patient` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

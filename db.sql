-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 07, 2023 at 11:51 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `osn`
--

-- --------------------------------------------------------

--
-- Table structure for table `Committee`
--

CREATE TABLE `Committee` (
  `ID` int NOT NULL,
  `Competition` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person` int NOT NULL,
  `Role` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Chair` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Competition`
--

CREATE TABLE `Competition` (
  `ID` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Level` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Year` int NOT NULL,
  `Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ShortName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Host` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HostCountryCode` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HostCountryName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `City` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DateBegin` date DEFAULT NULL,
  `DateEnd` date DEFAULT NULL,
  `ScorePr` int DEFAULT NULL,
  `Started` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `Finished` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `DataComplete` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `Note` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Competition`
--

INSERT INTO `Competition` (`ID`, `Level`, `Year`, `Name`, `ShortName`, `Host`, `HostCountryCode`, `HostCountryName`, `City`, `DateBegin`, `DateEnd`, `ScorePr`, `Started`, `Finished`, `DataComplete`, `Note`) VALUES
('APIO2020', 'Regional', 2020, 'Asia-Pacific Informatics Olympiad 2020', 'APIO 2020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y', 'Y', 'Y', NULL),
('APIO2021', 'Regional', 2021, 'Asia-Pacific Informatics Olympiad 2021', 'APIO 2021', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y', 'Y', 'Y', NULL),
('IOI2020', 'International', 2020, 'International Olympiad in Informatics 2020', 'IOI 2020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y', 'Y', 'Y', NULL),
('IOI2021', 'International', 2021, 'International Olympiad in Informatics 2021', 'IOI 2021', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y', 'Y', 'Y', NULL),
('OSN2019', 'National', 2019, 'Olimpiade Sains Nasional 2019 Bidang Informatika', 'OSN 2019', 'SAZ', NULL, NULL, 'Manado', '2019-06-30', '2019-07-06', 0, 'Y', 'Y', 'Y', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Contestant`
--

CREATE TABLE `Contestant` (
  `ID` int NOT NULL,
  `Competition` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person` int NOT NULL,
  `School` int DEFAULT NULL,
  `Province` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Gender` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Grade` int DEFAULT NULL,
  `TeamNo` int NOT NULL DEFAULT '1',
  `Score` decimal(8,2) DEFAULT NULL,
  `Rank` int DEFAULT NULL,
  `Medal` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Contestant`
--

INSERT INTO `Contestant` (`ID`, `Competition`, `Person`, `School`, `Province`, `Gender`, `Grade`, `TeamNo`, `Score`, `Rank`, `Medal`) VALUES
(1160, 'OSN2019', 1001, 27, 'JTZ', NULL, NULL, 1, '563.00', 2, 'G'),
(1279, 'IOI2020', 1001, 27, NULL, NULL, NULL, 1, NULL, 13, 'G'),
(1285, 'APIO2020', 1001, 27, NULL, NULL, NULL, 1, NULL, 43, 'S'),
(1659, 'APIO2021', 1001, 27, NULL, NULL, NULL, 1, NULL, 25, 'S'),
(1663, 'IOI2021', 1001, 27, NULL, NULL, NULL, 1, NULL, 28, 'G');

-- --------------------------------------------------------

--
-- Table structure for table `Person`
--

CREATE TABLE `Person` (
  `ID` int NOT NULL,
  `Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Person`
--

INSERT INTO `Person` (`ID`, `Name`) VALUES
(1001, 'Pikatan Arya Bramajati');

-- --------------------------------------------------------

--
-- Table structure for table `Province`
--

CREATE TABLE `Province` (
  `ID` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Name` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Province`
--

INSERT INTO `Province` (`ID`, `Name`) VALUES
('JTZ', 'Jawa Tengah'),
('SAZ', 'Sulawesi Utara');

-- --------------------------------------------------------

--
-- Table structure for table `School`
--

CREATE TABLE `School` (
  `ID` int NOT NULL,
  `Name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `School`
--

INSERT INTO `School` (`ID`, `Name`) VALUES
(27, 'SMA Semesta BBS Semarang');

-- --------------------------------------------------------

--
-- Table structure for table `Submission`
--

CREATE TABLE `Submission` (
  `ID` int NOT NULL,
  `Contestant` int NOT NULL,
  `Task` int NOT NULL,
  `Score` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Submission`
--

INSERT INTO `Submission` (`ID`, `Contestant`, `Task`, `Score`) VALUES
(4193, 1160, 49, '100.00'),
(4194, 1160, 50, '75.00'),
(4195, 1160, 51, '88.00'),
(4196, 1160, 52, '100.00'),
(4197, 1160, 53, '100.00'),
(4198, 1160, 54, '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `Task`
--

CREATE TABLE `Task` (
  `ID` int NOT NULL,
  `Competition` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DayNo` int NOT NULL,
  `TaskNo` int NOT NULL,
  `Alias` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Name` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `MaxScore` decimal(6,2) DEFAULT NULL,
  `ScorePr` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Task`
--

INSERT INTO `Task` (`ID`, `Competition`, `DayNo`, `TaskNo`, `Alias`, `Name`, `MaxScore`, `ScorePr`) VALUES
(49, 'OSN2019', 1, 1, '1A', 'Mengumpulkan Peserta', '100.00', 0),
(50, 'OSN2019', 1, 2, '1B', 'Pertahanan Manado', '100.00', 0),
(51, 'OSN2019', 1, 3, '1C', 'Rekreasi OSN', '100.00', 0),
(52, 'OSN2019', 2, 4, '2A', 'Tempat Wisata', '100.00', 0),
(53, 'OSN2019', 2, 5, '2B', 'Mencari Emas', '100.00', 0),
(54, 'OSN2019', 2, 6, '2C', 'Penyebaran Hoaks', '100.00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Committee`
--
ALTER TABLE `Committee`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Competition_Person_Role` (`Competition`,`Person`,`Role`) USING BTREE,
  ADD KEY `Person` (`Person`),
  ADD KEY `Competition` (`Competition`) USING BTREE;

--
-- Indexes for table `Competition`
--
ALTER TABLE `Competition`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Level_Year` (`Level`,`Year`),
  ADD KEY `Host` (`Host`);

--
-- Indexes for table `Contestant`
--
ALTER TABLE `Contestant`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Competition_Person` (`Competition`,`Person`),
  ADD KEY `Person` (`Person`),
  ADD KEY `Province` (`Province`) USING BTREE,
  ADD KEY `School` (`School`);

--
-- Indexes for table `Person`
--
ALTER TABLE `Person`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Name` (`Name`);

--
-- Indexes for table `Province`
--
ALTER TABLE `Province`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `School`
--
ALTER TABLE `School`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `Submission`
--
ALTER TABLE `Submission`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Contestant_Task` (`Contestant`,`Task`),
  ADD KEY `Contestant` (`Contestant`),
  ADD KEY `Task` (`Task`);

--
-- Indexes for table `Task`
--
ALTER TABLE `Task`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Competition_DayNo_TaskNo` (`Competition`,`DayNo`,`TaskNo`),
  ADD UNIQUE KEY `Competition_Alias` (`Competition`,`Alias`),
  ADD KEY `Competition` (`Competition`) USING BTREE;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Committee`
--
ALTER TABLE `Committee`
  ADD CONSTRAINT `Committee_ibfk_1` FOREIGN KEY (`Person`) REFERENCES `Person` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Committee_ibfk_2` FOREIGN KEY (`Competition`) REFERENCES `Competition` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Competition`
--
ALTER TABLE `Competition`
  ADD CONSTRAINT `Competition_ibfk_1` FOREIGN KEY (`Host`) REFERENCES `Province` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Contestant`
--
ALTER TABLE `Contestant`
  ADD CONSTRAINT `Contestant_ibfk_1` FOREIGN KEY (`Person`) REFERENCES `Person` (`ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `Contestant_ibfk_2` FOREIGN KEY (`Province`) REFERENCES `Province` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Contestant_ibfk_3` FOREIGN KEY (`Competition`) REFERENCES `Competition` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Contestant_ibfk_4` FOREIGN KEY (`School`) REFERENCES `School` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Submission`
--
ALTER TABLE `Submission`
  ADD CONSTRAINT `Submission_ibfk_1` FOREIGN KEY (`Contestant`) REFERENCES `Contestant` (`ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `Submission_ibfk_2` FOREIGN KEY (`Task`) REFERENCES `Task` (`ID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `Task`
--
ALTER TABLE `Task`
  ADD CONSTRAINT `Task_ibfk_1` FOREIGN KEY (`Competition`) REFERENCES `Competition` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

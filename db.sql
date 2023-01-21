-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2022 at 02:30 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osn`
--

-- --------------------------------------------------------

--
-- Table structure for table `Competition`
--

CREATE TABLE `Competition` (
  `ID` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `Level` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `Year` int NOT NULL,
  `Name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ShortName` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `Host` char(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `HostCountryCode` char(3) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `HostCountryName` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `City` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `DateBegin` date DEFAULT NULL,
  `DateEnd` date DEFAULT NULL,
  `ScorePr` int DEFAULT NULL,
  `Finished` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Y',
  `DataComplete` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `Competition`
--

INSERT INTO `Competition` (`ID`, `Level`, `Year`, `Name`, `ShortName`, `Host`, `City`, `DateBegin`, `DateEnd`, `ScorePr`, `Finished`) VALUES
('APIO2020', 'Regional', 2020, 'Asia-Pacific Informatics Olympiad 2020', 'APIO 2020', NULL, NULL, NULL, NULL, NULL, 'Y'),
('APIO2021', 'Regional', 2021, 'Asia-Pacific Informatics Olympiad 2021', 'APIO 2021', NULL, NULL, NULL, NULL, NULL, 'Y'),
('IOI2020', 'International', 2020, 'International Olympiad in Informatics 2020', 'IOI 2020', NULL, NULL, NULL, NULL, NULL, 'Y'),
('IOI2021', 'International', 2021, 'International Olympiad in Informatics 2021', 'IOI 2021', NULL, NULL, NULL, NULL, NULL, 'Y'),
('OSN2019', 'National', 2019, 'Olimpiade Sains Nasional 2019 Bidang Informatika', 'OSN 2019', 'SAZ', 'Manado', '2019-06-30', '2019-07-06', 0, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `Contestant`
--

CREATE TABLE `Contestant` (
  `ID` int NOT NULL,
  `School` int DEFAULT NULL,
  `Person` int DEFAULT NULL,
  `Province` char(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `TeamNo` int NOT NULL DEFAULT '1',
  `Competition` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `Score` decimal(8,2) DEFAULT NULL,
  `Rank` int DEFAULT NULL,
  `Medal` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `Contestant`
--

INSERT INTO `Contestant` (`ID`, `School`, `Person`, `Province`, `TeamNo`, `Competition`, `Score`, `Rank`, `Medal`) VALUES
(1160, 27, 1001, 'JTZ', 1, 'OSN2019', '563.00', 2, 'G'),
(1279, 27, 1001, NULL, 1, 'IOI2020', NULL, 13, 'G'),
(1285, 27, 1001, NULL, 1, 'APIO2020', NULL, 43, 'S'),
(1659, 27, 1001, NULL, 1, 'APIO2021', NULL, 25, 'S'),
(1663, 27, 1001, NULL, 1, 'IOI2021', NULL, 28, 'G');

-- --------------------------------------------------------

--
-- Table structure for table `Person`
--

CREATE TABLE `Person` (
  `ID` int NOT NULL,
  `Name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
  `ID` char(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Name` varchar(75) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
  `Name` varchar(75) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Alias` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Competition` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `DayNo` int NOT NULL,
  `TaskNo` int NOT NULL,
  `MaxScore` decimal(6,2) DEFAULT NULL,
  `ScorePr` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `Task`
--

INSERT INTO `Task` (`ID`, `Name`, `Alias`, `Competition`, `DayNo`, `TaskNo`, `MaxScore`, `ScorePr`) VALUES
(49, 'Mengumpulkan Peserta', '1A', 'OSN2019', 1, 1, '100.00', 0),
(50, 'Pertahanan Manado', '1B', 'OSN2019', 1, 2, '100.00', 0),
(51, 'Rekreasi OSN', '1C', 'OSN2019', 1, 3, '100.00', 0),
(52, 'Tempat Wisata', '2A', 'OSN2019', 2, 4, '100.00', 0),
(53, 'Mencari Emas', '2B', 'OSN2019', 2, 5, '100.00', 0),
(54, 'Penyebaran Hoaks', '2C', 'OSN2019', 2, 6, '100.00', 0);

--
-- Table structure for table `Committee`
--

CREATE TABLE `Committee` (
  `ID` int NOT NULL,
  `Person` int NOT NULL,
  `Role` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Chair` char(1) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'N',
  `Competition` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


--
-- Indexes for dumped tables
--

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
-- Indexes for table `Committee`
--
ALTER TABLE `Committee`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Competition_Person_Role` (`Competition`,`Person`,`Role`) USING BTREE,
  ADD KEY `Person` (`Person`),
  ADD KEY `Competition` (`Competition`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Contestant`
--
ALTER TABLE `Contestant`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1892;

--
-- AUTO_INCREMENT for table `Person`
--
ALTER TABLE `Person`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1489;

--
-- AUTO_INCREMENT for table `School`
--
ALTER TABLE `School`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=721;

--
-- AUTO_INCREMENT for table `Submission`
--
ALTER TABLE `Submission`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7843;

--
-- AUTO_INCREMENT for table `Task`
--
ALTER TABLE `Task`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `Committee`
--
ALTER TABLE `Committee`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Competition`
--
ALTER TABLE `Competition`
  ADD CONSTRAINT `Olympiad_ibfk_1` FOREIGN KEY (`Host`) REFERENCES `Province` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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

--
-- Constraints for table `Committee`
--
ALTER TABLE `Committee`
  ADD CONSTRAINT `Committee_ibfk_1` FOREIGN KEY (`Person`) REFERENCES `Person` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Committee_ibfk_2` FOREIGN KEY (`Competition`) REFERENCES `Competition` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

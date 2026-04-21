-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2026 at 06:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seniorcaredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `AdminID` int(11) NOT NULL,
  `AdminOscaID` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ResetCode` varchar(6) DEFAULT NULL,
  `CodeExpiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`AdminID`, `AdminOscaID`, `Password`, `ResetCode`, `CodeExpiry`) VALUES
(1, '001', '123', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assistance`
--

CREATE TABLE `assistance` (
  `AssistanceID` int(11) NOT NULL,
  `OscaIDNo` varchar(50) DEFAULT NULL,
  `AssistanceName` varchar(255) DEFAULT NULL,
  `TypeAssistance` text DEFAULT NULL,
  `AssistanceDate` date DEFAULT NULL,
  `AssistanceAttendanceStatus` varchar(50) DEFAULT 'claimed',
  `AssistanceTimeIn` time DEFAULT NULL,
  `AssistanceEventStatus` enum('Active','Stopped') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assistance`
--

INSERT INTO `assistance` (`AssistanceID`, `OscaIDNo`, `AssistanceName`, `TypeAssistance`, `AssistanceDate`, `AssistanceAttendanceStatus`, `AssistanceTimeIn`, `AssistanceEventStatus`) VALUES
(7, NULL, 'dws', 'Food Packs', '2026-04-16', 'claimed', NULL, 'Stopped'),
(8, '055455', 'dws', 'Food Packs', '2026-04-16', 'claimed', '13:38:37', 'Stopped');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `AttendanceID` int(11) NOT NULL,
  `OscaIDNo` varchar(50) DEFAULT NULL,
  `EventID` int(11) DEFAULT NULL,
  `EventAttendanceStatus` enum('present','absent') DEFAULT 'present',
  `attendanceTimeIn` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AttendanceID`, `OscaIDNo`, `EventID`, `EventAttendanceStatus`, `attendanceTimeIn`) VALUES
(2, '055455', 4, 'present', '04:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `EventID` int(11) NOT NULL,
  `EventName` varchar(255) NOT NULL,
  `eventDate` date NOT NULL,
  `EventTime` time NOT NULL,
  `EventStatus` enum('Active','Stopped') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `EventName`, `eventDate`, `EventTime`, `EventStatus`) VALUES
(4, 'sada', '2026-04-18', '10:57:00', 'Stopped'),
(6, 'sd', '2026-04-19', '00:27:00', 'Stopped');

-- --------------------------------------------------------

--
-- Table structure for table `healthrecords`
--

CREATE TABLE `healthrecords` (
  `HealthRecordID` int(11) NOT NULL,
  `OscaIDNo` varchar(50) DEFAULT NULL,
  `HealthName` varchar(255) DEFAULT NULL,
  `HealthDate` date DEFAULT NULL,
  `HealthPurpose` varchar(255) DEFAULT NULL,
  `HealthAttendanceStatus` varchar(50) DEFAULT 'present',
  `HealthTimeIn` time DEFAULT NULL,
  `HealthEventStatus` enum('Active','Stopped') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `healthrecords`
--

INSERT INTO `healthrecords` (`HealthRecordID`, `OscaIDNo`, `HealthName`, `HealthDate`, `HealthPurpose`, `HealthAttendanceStatus`, `HealthTimeIn`, `HealthEventStatus`) VALUES
(1, '055455', 'dad', '2026-04-16', 'Check up', 'present', '08:03:53', 'Stopped'),
(5, NULL, 'sadss', '2026-04-18', 'Check up', 'present', NULL, 'Stopped'),
(6, '055455', 'sadss', '2026-04-18', 'Check up', 'present', '04:56:35', 'Stopped'),
(9, NULL, 'zcsx', '2026-04-19', 'Check up', 'present', NULL, 'Stopped');

-- --------------------------------------------------------

--
-- Table structure for table `pension`
--

CREATE TABLE `pension` (
  `PensionID` int(11) NOT NULL,
  `OscaIDNo` varchar(50) DEFAULT NULL,
  `PensionReason` text DEFAULT NULL,
  `PensionDate` date DEFAULT NULL,
  `PensionCashAmount` decimal(10,2) DEFAULT NULL,
  `ControlNo` varchar(50) DEFAULT NULL,
  `PensionAttendanceStatus` varchar(50) DEFAULT 'claimed',
  `pensionTimeRecieve` time DEFAULT NULL,
  `PensionEventStatus` enum('Active','Stopped') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pension`
--

INSERT INTO `pension` (`PensionID`, `OscaIDNo`, `PensionReason`, `PensionDate`, `PensionCashAmount`, `ControlNo`, `PensionAttendanceStatus`, `pensionTimeRecieve`, `PensionEventStatus`) VALUES
(12, NULL, '2026-04-17', '2026-04-17', 3000.00, NULL, 'claimed', NULL, 'Stopped'),
(13, '055455', '2026-04-17', '2026-04-17', 3000.00, NULL, 'Claimed', '15:25:57', 'Stopped');

-- --------------------------------------------------------

--
-- Table structure for table `seniors`
--

CREATE TABLE `seniors` (
  `OscaIDNo` varchar(50) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `MiddleName` varchar(100) DEFAULT NULL,
  `Sex` enum('Male','Female') NOT NULL,
  `Purok` varchar(50) DEFAULT NULL,
  `Barangay` varchar(100) DEFAULT 'Kalawag 1',
  `Birthday` date NOT NULL,
  `Age` int(3) DEFAULT NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `QRCode` varchar(255) DEFAULT NULL,
  `CitizenStatus` enum('active','inactive') DEFAULT 'active',
  `SignaturePicture` varchar(255) DEFAULT NULL,
  `thumbNailPicture1` varchar(255) DEFAULT NULL,
  `thumbNailPicture2` varchar(255) DEFAULT NULL,
  `thumbNailPicture3` varchar(255) DEFAULT NULL,
  `GenerateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seniors`
--

INSERT INTO `seniors` (`OscaIDNo`, `LastName`, `FirstName`, `MiddleName`, `Sex`, `Purok`, `Barangay`, `Birthday`, `Age`, `Picture`, `QRCode`, `CitizenStatus`, `SignaturePicture`, `thumbNailPicture1`, `thumbNailPicture2`, `thumbNailPicture3`, `GenerateDate`) VALUES
('00123', 'MARCELLA', 'CLEM', 'A', 'Female', 'Zone 6', 'Kalawag 1', '1980-09-18', 45, '00123_profile.jpg', '00123', 'active', '00123_sig.jpg', '00123_thumb1.jpg', '00123_thumb2.jpg', '00123_thumb3.jpg', '2026-04-18 09:46:47'),
('055455', 'Reyes', 'Luz', 'B', 'Female', 'Zone 1', 'Kalawag 1', '1961-01-12', 65, '055455_profile.jpg', '055455', 'active', '055455_sig1.jpg', '055455_thumb1.jpg', '055455_thumb2.jpg', '055455_thumb3.jpg', '2026-04-16 13:36:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `assistance`
--
ALTER TABLE `assistance`
  ADD PRIMARY KEY (`AssistanceID`),
  ADD UNIQUE KEY `unique_assistance_scan` (`OscaIDNo`,`AssistanceDate`,`AssistanceName`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`AttendanceID`),
  ADD UNIQUE KEY `unique_event_scan` (`OscaIDNo`,`EventID`),
  ADD KEY `attendance_ibfk_2` (`EventID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `healthrecords`
--
ALTER TABLE `healthrecords`
  ADD PRIMARY KEY (`HealthRecordID`),
  ADD UNIQUE KEY `unique_health_scan` (`OscaIDNo`,`HealthDate`,`HealthName`);

--
-- Indexes for table `pension`
--
ALTER TABLE `pension`
  ADD PRIMARY KEY (`PensionID`),
  ADD UNIQUE KEY `unique_pension_scan` (`OscaIDNo`,`PensionReason`(100));

--
-- Indexes for table `seniors`
--
ALTER TABLE `seniors`
  ADD PRIMARY KEY (`OscaIDNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assistance`
--
ALTER TABLE `assistance`
  MODIFY `AssistanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `AttendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `healthrecords`
--
ALTER TABLE `healthrecords`
  MODIFY `HealthRecordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pension`
--
ALTER TABLE `pension`
  MODIFY `PensionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assistance`
--
ALTER TABLE `assistance`
  ADD CONSTRAINT `assistance_ibfk_1` FOREIGN KEY (`OscaIDNo`) REFERENCES `seniors` (`OscaIDNo`) ON DELETE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`OscaIDNo`) REFERENCES `seniors` (`OscaIDNo`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`) ON DELETE CASCADE;

--
-- Constraints for table `healthrecords`
--
ALTER TABLE `healthrecords`
  ADD CONSTRAINT `healthrecords_ibfk_1` FOREIGN KEY (`OscaIDNo`) REFERENCES `seniors` (`OscaIDNo`) ON DELETE CASCADE;

--
-- Constraints for table `pension`
--
ALTER TABLE `pension`
  ADD CONSTRAINT `pension_ibfk_1` FOREIGN KEY (`OscaIDNo`) REFERENCES `seniors` (`OscaIDNo`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

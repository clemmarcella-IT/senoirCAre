-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 11:37 AM
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
-- Database: `seniorcare_newdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `AdminID` int(11) NOT NULL,
  `AdminOscaID` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ContactNumber` varchar(50) DEFAULT NULL,
  `ResetCode` varchar(6) DEFAULT NULL,
  `CodeExpiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`AdminID`, `AdminOscaID`, `Password`, `ContactNumber`, `ResetCode`, `CodeExpiry`) VALUES
(1, '001', '$2y$10$OaGp7lBCyxQDmDPXxnT7QeBVLUMdfLvXjdOiZXd4UdaSz3z1L9.ha', '09365250520', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_attendance`
--

CREATE TABLE `event_attendance` (
  `AttendanceID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `OscaIDNo` varchar(50) NOT NULL,
  `TimeIn` time DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Unclaimed',
  `ControlNo` varchar(50) DEFAULT NULL,
  `Reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_attendance`
--

INSERT INTO `event_attendance` (`AttendanceID`, `EventID`, `OscaIDNo`, `TimeIn`, `Status`, `ControlNo`, `Reason`) VALUES
(1, 1, '00123', '08:00:00', 'Claimed', NULL, NULL),
(2, 1, '055455', '08:15:00', 'Claimed', NULL, NULL),
(3, 2, '055455', '10:00:00', 'Claimed', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_master`
--

CREATE TABLE `event_master` (
  `EventID` int(11) NOT NULL,
  `EventName` varchar(255) NOT NULL,
  `EventDate` date NOT NULL,
  `EventTime` time DEFAULT NULL,
  `EventType` enum('Assistance','Health','Pension','Activity') NOT NULL,
  `EventStatus` enum('Active','Stopped') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_master`
--

INSERT INTO `event_master` (`EventID`, `EventName`, `EventDate`, `EventTime`, `EventType`, `EventStatus`) VALUES
(1, 'Relief Goods', '2026-05-03', NULL, 'Assistance', 'Active'),
(2, 'Monthly Pension', '2026-04-22', NULL, 'Pension', 'Stopped'),
(3, 'Health Checkup', '2026-05-03', NULL, 'Health', 'Stopped');

-- --------------------------------------------------------

--
-- Table structure for table `health_details`
--

CREATE TABLE `health_details` (
  `HealthDataID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `HealthPurpose` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_details`
--

INSERT INTO `health_details` (`HealthDataID`, `EventID`, `HealthPurpose`) VALUES
(1, 3, 'Check up');

-- --------------------------------------------------------

--
-- Table structure for table `pension_details`
--

CREATE TABLE `pension_details` (
  `PensionDataID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `CashAmount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pension_details`
--

INSERT INTO `pension_details` (`PensionDataID`, `EventID`, `CashAmount`) VALUES
(1, 2, 12323.00);

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
  `CitizenStatus` enum('active','inactive') DEFAULT 'active',
  `ApprovalStatus` enum('pending','approved','rejected') DEFAULT 'pending',
  `GenerateDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seniors`
--

INSERT INTO `seniors` (`OscaIDNo`, `LastName`, `FirstName`, `MiddleName`, `Sex`, `Purok`, `Barangay`, `Birthday`, `CitizenStatus`, `ApprovalStatus`, `GenerateDate`) VALUES
('00123', 'ARCELLA', 'CLEM', 'A', 'Male', 'Zone 1', 'Kalawag 1', '1960-09-19', 'active', 'approved', '2026-05-03 17:37:00'),
('055455', 'MARCELLA', 'CLEM', 'A', 'Male', 'Zone 2', 'Kalawag 1', '1926-07-21', 'active', 'approved', '2026-05-03 17:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `senior_documents`
--

CREATE TABLE `senior_documents` (
  `DocID` int(11) NOT NULL,
  `OscaIDNo` varchar(50) NOT NULL,
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `SignaturePicture` varchar(255) DEFAULT NULL,
  `ThumbmarkPicture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `senior_documents`
--

INSERT INTO `senior_documents` (`DocID`, `OscaIDNo`, `ProfilePicture`, `SignaturePicture`, `ThumbmarkPicture`) VALUES
(1, '00123', '00123_profile.jpg', '00123_sig.jpg', '00123_thumb1.jpg'),
(2, '055455', '055455_profile.jpg', '055455_sig.jpg', '055455_thumb1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD PRIMARY KEY (`AttendanceID`),
  ADD KEY `fk_attendance_event` (`EventID`),
  ADD KEY `fk_attendance_senior` (`OscaIDNo`);

--
-- Indexes for table `event_master`
--
ALTER TABLE `event_master`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `health_details`
--
ALTER TABLE `health_details`
  ADD PRIMARY KEY (`HealthDataID`),
  ADD UNIQUE KEY `fk_health_event` (`EventID`);

--
-- Indexes for table `pension_details`
--
ALTER TABLE `pension_details`
  ADD PRIMARY KEY (`PensionDataID`),
  ADD UNIQUE KEY `fk_pension_event` (`EventID`);

--
-- Indexes for table `seniors`
--
ALTER TABLE `seniors`
  ADD PRIMARY KEY (`OscaIDNo`);

--
-- Indexes for table `senior_documents`
--
ALTER TABLE `senior_documents`
  ADD PRIMARY KEY (`DocID`),
  ADD UNIQUE KEY `fk_senior_docs` (`OscaIDNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `AttendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_master`
--
ALTER TABLE `event_master`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `health_details`
--
ALTER TABLE `health_details`
  MODIFY `HealthDataID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pension_details`
--
ALTER TABLE `pension_details`
  MODIFY `PensionDataID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `senior_documents`
--
ALTER TABLE `senior_documents`
  MODIFY `DocID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD CONSTRAINT `fk_attendance_event` FOREIGN KEY (`EventID`) REFERENCES `event_master` (`EventID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_attendance_senior` FOREIGN KEY (`OscaIDNo`) REFERENCES `seniors` (`OscaIDNo`) ON DELETE CASCADE;

--
-- Constraints for table `health_details`
--
ALTER TABLE `health_details`
  ADD CONSTRAINT `fk_health_event` FOREIGN KEY (`EventID`) REFERENCES `event_master` (`EventID`) ON DELETE CASCADE;

--
-- Constraints for table `pension_details`
--
ALTER TABLE `pension_details`
  ADD CONSTRAINT `fk_pension_event` FOREIGN KEY (`EventID`) REFERENCES `event_master` (`EventID`) ON DELETE CASCADE;

--
-- Constraints for table `senior_documents`
--
ALTER TABLE `senior_documents`
  ADD CONSTRAINT `fk_senior_docs_fk_seniors` FOREIGN KEY (`OscaIDNo`) REFERENCES `seniors` (`OscaIDNo`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

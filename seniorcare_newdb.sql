-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2026 at 02:47 PM
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
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `ActivityID` int(11) NOT NULL,
  `ActivityName` varchar(255) NOT NULL,
  `ActivityDate` date NOT NULL,
  `ActivityTimeStart` time NOT NULL,
  `ActivityStatus` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`ActivityID`, `ActivityName`, `ActivityDate`, `ActivityTimeStart`, `ActivityStatus`) VALUES
(2, 'sada', '2026-05-09', '17:25:00', 'Stopped'),
(3, 'General Assembly and Health Check', '2026-05-10', '12:11:00', 'Stopped'),
(8, 'sada', '2026-05-20', '20:11:00', 'Stopped'),
(9, 'sada', '2026-05-20', '20:12:00', 'Stopped'),
(10, 'sada', '2026-05-20', '20:43:00', 'Stopped');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `AdminID` int(11) NOT NULL,
  `AdminOscaID` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ContactNumber` varchar(15) DEFAULT NULL,
  `ResetCode` varchar(10) DEFAULT NULL,
  `CodeExpiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`AdminID`, `AdminOscaID`, `Password`, `ContactNumber`, `ResetCode`, `CodeExpiry`) VALUES
(1, '001', '$2y$10$bGXL0ZGmHXeu8p.8cKEvYO0PjlwxE0WjBmELElHgV4xCf9AN2bGCe', '09123456789', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dues_payments`
--

CREATE TABLE `dues_payments` (
  `PaymentID` int(11) NOT NULL,
  `OscaIDNo` varchar(50) NOT NULL,
  `DuesID` int(11) NOT NULL,
  `Amount_Paid` decimal(10,2) NOT NULL,
  `Date_Paid` date NOT NULL,
  `Time_Paid` time DEFAULT NULL,
  `Payment_Status` varchar(20) DEFAULT 'Pending',
  `notification_seen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dues_payments`
--

INSERT INTO `dues_payments` (`PaymentID`, `OscaIDNo`, `DuesID`, `Amount_Paid`, `Date_Paid`, `Time_Paid`, `Payment_Status`, `notification_seen`) VALUES
(7, '055455', 20, 100.00, '2026-05-09', NULL, 'Partial', 1),
(8, '055455', 20, 100.00, '2026-05-09', NULL, 'Paid', 1),
(9, '055455', 21, 50.00, '2026-05-09', NULL, 'Partial', 1),
(10, '055455', 21, 50.00, '2026-05-09', NULL, 'Paid', 1),
(18, '055455', 26, 60.00, '2026-05-20', NULL, 'Partial', 1),
(19, '055455', 26, 40.00, '2026-05-20', NULL, 'Paid', 1);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_dues_master`
--

CREATE TABLE `monthly_dues_master` (
  `DuesID` int(11) NOT NULL,
  `Contribution_Name` varchar(100) NOT NULL,
  `Amount_Required` decimal(10,2) NOT NULL,
  `Due_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monthly_dues_master`
--

INSERT INTO `monthly_dues_master` (`DuesID`, `Contribution_Name`, `Amount_Required`, `Due_Date`) VALUES
(20, 'MonthlyDue_May_2026', 200.00, '2026-05-09'),
(21, 'MonthlyDue_May_2026', 100.00, '2026-05-09'),
(26, 'MonthlyDue_May_2026', 100.00, '2026-05-20');

-- --------------------------------------------------------

--
-- Table structure for table `pension_master`
--

CREATE TABLE `pension_master` (
  `PensionMasterID` int(11) NOT NULL,
  `PayoutDate` date NOT NULL,
  `CashAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pension_master`
--

INSERT INTO `pension_master` (`PensionMasterID`, `PayoutDate`, `CashAmount`) VALUES
(3, '2026-05-09', 4000.00),
(10, '2026-05-20', 1000.00),
(11, '2026-05-20', 1000.00),
(12, '2026-05-20', 2000.00);

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
  `Barangay` varchar(100) DEFAULT NULL,
  `Birthday` date NOT NULL,
  `CitizenStatus` enum('Active','Inactive') DEFAULT 'Active',
  `PensionerStatus` enum('Pensioner','Non-Pensioner') DEFAULT 'Non-Pensioner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seniors`
--

INSERT INTO `seniors` (`OscaIDNo`, `LastName`, `FirstName`, `MiddleName`, `Sex`, `Purok`, `Barangay`, `Birthday`, `CitizenStatus`, `PensionerStatus`) VALUES
('055455', 'DELA CRUZ', 'JUAN', 'M', 'Male', 'Zone 1', 'Kalawag 1', '1955-05-15', 'Active', 'Pensioner'),
('1323434', 'clemenceou', 'mar', 'M', 'Male', 'Zone 3', 'Kalawag 1', '1956-01-05', 'Active', 'Pensioner');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_logs`
--

CREATE TABLE `transaction_logs` (
  `LogID` int(11) NOT NULL,
  `OscaIDNo` varchar(50) NOT NULL,
  `ActivityID` int(11) DEFAULT NULL,
  `PensionMasterID` int(11) DEFAULT NULL,
  `ClaimType` varchar(50) DEFAULT NULL,
  `Amount_Released` decimal(10,2) DEFAULT NULL,
  `DateRecorded` date NOT NULL,
  `TimeRecorded` time NOT NULL,
  `Status` varchar(20) DEFAULT 'Unclaimed',
  `ControlNo` varchar(50) DEFAULT NULL,
  `Reason` text DEFAULT NULL,
  `IsRead` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_logs`
--

INSERT INTO `transaction_logs` (`LogID`, `OscaIDNo`, `ActivityID`, `PensionMasterID`, `ClaimType`, `Amount_Released`, `DateRecorded`, `TimeRecorded`, `Status`, `ControlNo`, `Reason`, `IsRead`) VALUES
(1, '055455', NULL, NULL, 'Pension Claim', 4000.00, '2026-05-09', '09:09:30', 'Claimed', '4565676', '', 1),
(2, '055455', NULL, NULL, 'Benefit Claim', 50.00, '2026-05-09', '10:21:43', 'Claimed', NULL, 'medical', 1),
(3, '055455', NULL, NULL, NULL, NULL, '2026-05-09', '10:22:51', 'Present', NULL, NULL, 1),
(4, '055455', NULL, 3, 'Pension Claim', 4000.00, '2026-05-09', '10:33:31', 'Claimed', '4565676', '', 1),
(6, '055455', 2, NULL, NULL, NULL, '2026-05-09', '11:26:44', 'Present', NULL, NULL, 1),
(8, '055455', NULL, NULL, NULL, NULL, '2026-05-16', '17:48:18', 'Present', NULL, NULL, 1),
(9, '055455', NULL, NULL, 'Pension Claim', 10000.00, '2026-05-20', '06:51:13', 'Claimed', '4565676', '', 1),
(13, '055455', NULL, NULL, 'Pension Claim', 10000.00, '2026-05-20', '06:55:40', 'Claimed', '4565676', '', 1),
(14, '055455', NULL, NULL, NULL, NULL, '2026-05-20', '06:56:16', 'Present', NULL, NULL, 1),
(16, '055455', NULL, NULL, 'Benefit Claim', 100.00, '2026-05-20', '11:03:19', 'Claimed', NULL, 'medical', 1),
(17, '055455', NULL, NULL, 'Pension Claim', 10000.00, '2026-05-20', '11:04:38', 'Claimed', '4565676', '', 1),
(19, '055455', NULL, NULL, NULL, NULL, '2026-05-20', '11:05:18', 'Present', NULL, NULL, 1),
(20, '055455', 8, NULL, NULL, NULL, '2026-05-20', '14:11:22', 'Present', NULL, NULL, 1),
(21, '055455', 9, NULL, NULL, NULL, '2026-05-20', '14:13:00', 'Present', NULL, NULL, 1),
(22, '055455', NULL, 10, 'Pension Claim', 1000.00, '2026-05-20', '14:14:19', 'Claimed', '4565676', '', 1),
(24, '055455', 10, NULL, NULL, NULL, '2026-05-20', '14:43:58', 'Present', NULL, NULL, 1),
(25, '055455', NULL, 12, 'Pension Claim', 2000.00, '2026-05-20', '14:44:42', 'Claimed', '4565676', '', 1),
(26, '1323434', NULL, 12, 'Pension Claim', NULL, '2026-05-20', '14:45:01', 'Unclaimed', '1213', 'death', 0),
(27, '055455', NULL, NULL, 'Benefit Claim', 200.00, '2026-05-20', '14:45:41', 'Claimed', NULL, 'death', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`ActivityID`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `uk_admin_osca` (`AdminOscaID`);

--
-- Indexes for table `dues_payments`
--
ALTER TABLE `dues_payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `fk_dues_senior` (`OscaIDNo`),
  ADD KEY `fk_dues_master` (`DuesID`);

--
-- Indexes for table `monthly_dues_master`
--
ALTER TABLE `monthly_dues_master`
  ADD PRIMARY KEY (`DuesID`);

--
-- Indexes for table `pension_master`
--
ALTER TABLE `pension_master`
  ADD PRIMARY KEY (`PensionMasterID`);

--
-- Indexes for table `seniors`
--
ALTER TABLE `seniors`
  ADD PRIMARY KEY (`OscaIDNo`);

--
-- Indexes for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `fk_trans_senior` (`OscaIDNo`),
  ADD KEY `fk_trans_activity` (`ActivityID`),
  ADD KEY `fk_trans_pension` (`PensionMasterID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `ActivityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dues_payments`
--
ALTER TABLE `dues_payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `monthly_dues_master`
--
ALTER TABLE `monthly_dues_master`
  MODIFY `DuesID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pension_master`
--
ALTER TABLE `pension_master`
  MODIFY `PensionMasterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dues_payments`
--
ALTER TABLE `dues_payments`
  ADD CONSTRAINT `fk_dues_master` FOREIGN KEY (`DuesID`) REFERENCES `monthly_dues_master` (`DuesID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_dues_senior` FOREIGN KEY (`OscaIDNo`) REFERENCES `seniors` (`OscaIDNo`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD CONSTRAINT `fk_trans_activity` FOREIGN KEY (`ActivityID`) REFERENCES `activities` (`ActivityID`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_trans_pension` FOREIGN KEY (`PensionMasterID`) REFERENCES `pension_master` (`PensionMasterID`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_trans_senior` FOREIGN KEY (`OscaIDNo`) REFERENCES `seniors` (`OscaIDNo`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2026 at 11:33 AM
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
-- Table structure for table `dues_payments`
--

CREATE TABLE `dues_payments` (
  `PaymentID` int(11) NOT NULL,
  `OscaIDNo` varchar(50) NOT NULL,
  `DuesID` int(11) NOT NULL,
  `Amount_Paid` decimal(10,2) NOT NULL,
  `Date_Paid` date NOT NULL,
  `Time_Paid` time NOT NULL,
  `Payment_Status` varchar(50) DEFAULT 'Paid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dues_payments`
--

INSERT INTO `dues_payments` (`PaymentID`, `OscaIDNo`, `DuesID`, `Amount_Paid`, `Date_Paid`, `Time_Paid`, `Payment_Status`) VALUES
(1, '00123', 1, 50.00, '2026-01-15', '09:30:00', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `event_master`
--

CREATE TABLE `event_master` (
  `EventID` int(11) NOT NULL,
  `EventName` varchar(255) NOT NULL,
  `EventDate` date NOT NULL,
  `EventTime` time DEFAULT NULL,
  `EventType` enum('Meeting','Pension','Benefit Distribution') NOT NULL,
  `EventStatus` enum('Active','Stopped') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_master`
--

INSERT INTO `event_master` (`EventID`, `EventName`, `EventDate`, `EventTime`, `EventType`, `EventStatus`) VALUES
(1, 'Q1 Monthly Pension', '2026-04-22', NULL, 'Pension', 'Active'),
(2, 'General Assembly', '2026-05-01', NULL, 'Meeting', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `monthly_dues_master`
--

CREATE TABLE `monthly_dues_master` (
  `DuesID` int(11) NOT NULL,
  `Contribution_Name` varchar(255) NOT NULL,
  `Amount_Required` decimal(10,2) NOT NULL,
  `Due_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monthly_dues_master`
--

INSERT INTO `monthly_dues_master` (`DuesID`, `Contribution_Name`, `Amount_Required`, `Due_Date`) VALUES
(1, 'January Damayan Fund', 50.00, '2026-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `pension_details`
--

CREATE TABLE `pension_details` (
  `PensionDataID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `CashAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pension_details`
--

INSERT INTO `pension_details` (`PensionDataID`, `EventID`, `CashAmount`) VALUES
(1, 1, 1500.00);

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
  `CitizenStatus` enum('Active','Inactive') DEFAULT 'Active',
  `PensionerStatus` enum('Yes','No') DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seniors`
--

INSERT INTO `seniors` (`OscaIDNo`, `LastName`, `FirstName`, `MiddleName`, `Sex`, `Purok`, `Barangay`, `Birthday`, `CitizenStatus`, `PensionerStatus`) VALUES
('00123', 'ARCELLA', 'CLEM', 'A', 'Male', 'Zone 1', 'Kalawag 1', '1960-09-19', 'Active', 'Yes'),
('055455', 'MARCELLA', 'CLEM', 'A', 'Male', 'Zone 2', 'Kalawag 1', '1926-07-21', 'Active', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_records`
--

CREATE TABLE `transaction_records` (
  `RecordID` int(11) NOT NULL,
  `OscaIDNo` varchar(50) NOT NULL,
  `EventID` int(11) NOT NULL,
  `Transaction_Type` enum('Attendance','Pension_Claim','Benefit_Claim') NOT NULL,
  `Date_Recorded` date NOT NULL,
  `Time_Recorded` time NOT NULL,
  `ControlNo` varchar(50) DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Claimed',
  `Amount_Used` decimal(10,2) DEFAULT NULL,
  `Reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_records`
--

INSERT INTO `transaction_records` (`RecordID`, `OscaIDNo`, `EventID`, `Transaction_Type`, `Date_Recorded`, `Time_Recorded`, `ControlNo`, `Status`, `Amount_Used`, `Reason`) VALUES
(1, '00123', 1, 'Pension_Claim', '2026-04-22', '08:15:00', 'CN-1001', 'Claimed', NULL, NULL),
(2, '055455', 2, 'Attendance', '2026-05-01', '13:00:00', NULL, 'Present', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `dues_payments`
--
ALTER TABLE `dues_payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `fk_dues_senior` (`OscaIDNo`),
  ADD KEY `fk_dues_master` (`DuesID`);

--
-- Indexes for table `event_master`
--
ALTER TABLE `event_master`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `monthly_dues_master`
--
ALTER TABLE `monthly_dues_master`
  ADD PRIMARY KEY (`DuesID`);

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
-- Indexes for table `transaction_records`
--
ALTER TABLE `transaction_records`
  ADD PRIMARY KEY (`RecordID`),
  ADD KEY `fk_trans_senior` (`OscaIDNo`),
  ADD KEY `fk_trans_event` (`EventID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dues_payments`
--
ALTER TABLE `dues_payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_master`
--
ALTER TABLE `event_master`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `monthly_dues_master`
--
ALTER TABLE `monthly_dues_master`
  MODIFY `DuesID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pension_details`
--
ALTER TABLE `pension_details`
  MODIFY `PensionDataID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction_records`
--
ALTER TABLE `transaction_records`
  MODIFY `RecordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Constraints for table `pension_details`
--
ALTER TABLE `pension_details`
  ADD CONSTRAINT `fk_pension_event` FOREIGN KEY (`EventID`) REFERENCES `event_master` (`EventID`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_records`
--
ALTER TABLE `transaction_records`
  ADD CONSTRAINT `fk_trans_event` FOREIGN KEY (`EventID`) REFERENCES `event_master` (`EventID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_trans_senior` FOREIGN KEY (`OscaIDNo`) REFERENCES `seniors` (`OscaIDNo`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

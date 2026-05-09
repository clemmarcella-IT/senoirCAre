-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2026 at 08:26 AM
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
(1, '001', '$2y$10$OaGp7lBCyxQDmDPXxnT7QeBVLUMdfLvXjdOiZXd4UdaSz3z1L9.ha', '09123456789', NULL, NULL);

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
 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dues_payments`
--

INSERT INTO `dues_payments` (`PaymentID`, `OscaIDNo`, `DuesID`, `Amount_Paid`, `Date_Paid`, `Time_Paid`, `Payment_Status`, `notification_seen`) VALUES
(26, '055455', 15, 400.00, '2026-05-09', NULL, 'Paid', 1),
(27, '055455', 16, 50.00, '2026-05-09', NULL, 'Partial', 1),
(28, '055455', 16, 50.00, '2026-05-09', NULL, 'Paid', 1),
(29, '055455', 17, 50.00, '2026-05-09', NULL, 'Partial', 1),
(30, '055455', 17, 50.00, '2026-05-09', NULL, 'Paid', 1);

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
(15, 'MonthlyDue_May_2026', 400.00, '2026-05-09'),
(16, 'MonthlyDue_May_2026', 100.00, '2026-05-09'),
(17, 'MonthlyDue_May_2026', 100.00, '2026-05-09');

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
(2, '2026-05-09', 4000.00);

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
('055455', 'DELA CRUZ', 'JUAN', 'M', 'Male', 'Zone 1', 'Kalawag 1', '1955-05-15', 'Active', 'Pensioner');

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
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_logs`
--

INSERT INTO `transaction_logs` (`LogID`, `OscaIDNo`, `ActivityID`, `PensionMasterID`, `ClaimType`, `Amount_Released`, `DateRecorded`, `TimeRecorded`, `Status`, `ControlNo`, `Reason`, `IsRead`) VALUES
(17, '055455', NULL, 2, 'Pension Claim', 4000.00, '2026-05-09', '05:42:46', 'Claimed', '4565676', '', 0),
(18, '055455', NULL, NULL, 'Benefit Claim', 50.00, '2026-05-09', '06:00:27', 'Claimed', NULL, 'medical', 1);

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
  MODIFY `ActivityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dues_payments`
--
ALTER TABLE `dues_payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `monthly_dues_master`
--
ALTER TABLE `monthly_dues_master`
  MODIFY `DuesID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pension_master`
--
ALTER TABLE `pension_master`
  MODIFY `PensionMasterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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

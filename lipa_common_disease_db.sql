-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 09:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lipa_common_disease_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `Cont_id` int(11) NOT NULL,
  `Mobile_Nor1` varchar(13) DEFAULT NULL,
  `Mobile_Nor2` varchar(13) DEFAULT NULL,
  `Telephone` varchar(13) DEFAULT NULL,
  `Website` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disease`
--

CREATE TABLE `disease` (
  `Id` int(11) NOT NULL,
  `Name` text DEFAULT NULL,
  `SymptomID` int(11) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Category` varchar(60) DEFAULT NULL,
  `Dated_created` date DEFAULT NULL,
  `Note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `Doctor_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_hospital`
--

CREATE TABLE `doctor_hospital` (
  `Doc_Hospital_ID` int(11) NOT NULL,
  `Doctor_ID` int(11) DEFAULT NULL,
  `Hospital_ID` int(11) DEFAULT NULL,
  `Start_Date` date DEFAULT NULL,
  `Role` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `effect`
--

CREATE TABLE `effect` (
  `Effect_id` int(11) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `Id` int(11) NOT NULL,
  `Hospital_Name` varchar(150) DEFAULT NULL,
  `Address` varchar(150) DEFAULT NULL,
  `Category` int(11) DEFAULT NULL,
  `Department` int(11) DEFAULT NULL,
  `Contact_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specialization`
--

CREATE TABLE `specialization` (
  `Specialization_ID` int(11) NOT NULL,
  `Name` varchar(80) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Disease_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `symptom`
--

CREATE TABLE `symptom` (
  `Symptom_ID` int(11) NOT NULL,
  `Name` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Effect_id` int(11) DEFAULT NULL,
  `Treatment_id` int(11) DEFAULT NULL,
  `Severity` varchar(50) DEFAULT NULL,
  `Note` text DEFAULT NULL,
  `Dated_created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `Treatment_ID` int(11) NOT NULL,
  `Name` text DEFAULT NULL,
  `Effect` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`Cont_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disease`
--
ALTER TABLE `disease`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `SymptomID` (`SymptomID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`Doctor_ID`);

--
-- Indexes for table `doctor_hospital`
--
ALTER TABLE `doctor_hospital`
  ADD PRIMARY KEY (`Doc_Hospital_ID`),
  ADD KEY `Doctor_ID` (`Doctor_ID`),
  ADD KEY `Hospital_ID` (`Hospital_ID`);

--
-- Indexes for table `effect`
--
ALTER TABLE `effect`
  ADD PRIMARY KEY (`Effect_id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Category` (`Category`),
  ADD KEY `Department` (`Department`),
  ADD KEY `Contact_ID` (`Contact_ID`);

--
-- Indexes for table `specialization`
--
ALTER TABLE `specialization`
  ADD PRIMARY KEY (`Specialization_ID`),
  ADD KEY `Disease_ID` (`Disease_ID`);

--
-- Indexes for table `symptom`
--
ALTER TABLE `symptom`
  ADD PRIMARY KEY (`Symptom_ID`),
  ADD KEY `Effect_id` (`Effect_id`),
  ADD KEY `Treatment_id` (`Treatment_id`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`Treatment_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disease`
--
ALTER TABLE `disease`
  ADD CONSTRAINT `disease_ibfk_1` FOREIGN KEY (`SymptomID`) REFERENCES `symptom` (`Symptom_ID`);

--
-- Constraints for table `doctor_hospital`
--
ALTER TABLE `doctor_hospital`
  ADD CONSTRAINT `doctor_hospital_ibfk_1` FOREIGN KEY (`Doctor_ID`) REFERENCES `doctor` (`Doctor_ID`),
  ADD CONSTRAINT `doctor_hospital_ibfk_2` FOREIGN KEY (`Hospital_ID`) REFERENCES `hospital` (`Id`);

--
-- Constraints for table `hospital`
--
ALTER TABLE `hospital`
  ADD CONSTRAINT `hospital_ibfk_1` FOREIGN KEY (`Category`) REFERENCES `category` (`Id`),
  ADD CONSTRAINT `hospital_ibfk_2` FOREIGN KEY (`Department`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `hospital_ibfk_3` FOREIGN KEY (`Contact_ID`) REFERENCES `contact` (`Cont_id`);

--
-- Constraints for table `specialization`
--
ALTER TABLE `specialization`
  ADD CONSTRAINT `specialization_ibfk_1` FOREIGN KEY (`Disease_ID`) REFERENCES `disease` (`Id`);

--
-- Constraints for table `symptom`
--
ALTER TABLE `symptom`
  ADD CONSTRAINT `symptom_ibfk_1` FOREIGN KEY (`Effect_id`) REFERENCES `effect` (`Effect_id`),
  ADD CONSTRAINT `symptom_ibfk_2` FOREIGN KEY (`Treatment_id`) REFERENCES `treatment` (`Treatment_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

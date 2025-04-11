-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 11:25 AM
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
-- Database: `local_disease_registry_lipa_city`
--

-- --------------------------------------------------------

--
-- Table structure for table `affected_group`
--

CREATE TABLE `affected_group` (
  `Group_ID` int(11) NOT NULL,
  `Min_Age` int(11) NOT NULL,
  `Max_Age` int(11) NOT NULL,
  `Gender` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Category_Name` int(11) NOT NULL,
  `Description` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disease`
--

CREATE TABLE `disease` (
  `Disease_ID` int(11) NOT NULL,
  `Disease_Name` varchar(60) NOT NULL,
  `Description` text NOT NULL,
  `Affected_Group_ID` int(11) NOT NULL,
  `Classification` text NOT NULL,
  `Category_ID` int(11) NOT NULL,
  `Date_Modified` int(11) NOT NULL,
  `Note` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diseases_symptom`
--

CREATE TABLE `diseases_symptom` (
  `Diseases_Symptom_ID` int(11) NOT NULL,
  `Disease_ID` int(11) NOT NULL,
  `Symptom_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diseases_treatment`
--

CREATE TABLE `diseases_treatment` (
  `Diseases_Treatment_ID` int(11) NOT NULL,
  `Disease_ID` int(11) NOT NULL,
  `Treatment_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `symptom`
--

CREATE TABLE `symptom` (
  `Symptom_ID` int(11) NOT NULL,
  `Symptom_Name` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Severity` varchar(50) NOT NULL,
  `Note` text NOT NULL,
  `DateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `Treatment_ID` int(11) NOT NULL,
  `Treatment_Name` int(11) NOT NULL,
  `Description` int(11) NOT NULL,
  `Notes` int(11) NOT NULL,
  `Date_Modified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affected_group`
--
ALTER TABLE `affected_group`
  ADD PRIMARY KEY (`Group_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `disease`
--
ALTER TABLE `disease`
  ADD PRIMARY KEY (`Disease_ID`),
  ADD KEY `Affected_Group` (`Affected_Group_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indexes for table `diseases_symptom`
--
ALTER TABLE `diseases_symptom`
  ADD PRIMARY KEY (`Diseases_Symptom_ID`),
  ADD KEY `diseases_symptom_ibfk_1` (`Symptom_ID`),
  ADD KEY `Disease_ID` (`Disease_ID`);

--
-- Indexes for table `diseases_treatment`
--
ALTER TABLE `diseases_treatment`
  ADD PRIMARY KEY (`Diseases_Treatment_ID`),
  ADD KEY `diseases_treatment_ibfk_1` (`Treatment_ID`),
  ADD KEY `Disease_ID` (`Disease_ID`);

--
-- Indexes for table `symptom`
--
ALTER TABLE `symptom`
  ADD PRIMARY KEY (`Symptom_ID`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`Treatment_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affected_group`
--
ALTER TABLE `affected_group`
  MODIFY `Group_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disease`
--
ALTER TABLE `disease`
  MODIFY `Disease_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diseases_symptom`
--
ALTER TABLE `diseases_symptom`
  MODIFY `Diseases_Symptom_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diseases_treatment`
--
ALTER TABLE `diseases_treatment`
  MODIFY `Diseases_Treatment_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `symptom`
--
ALTER TABLE `symptom`
  MODIFY `Symptom_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
  MODIFY `Treatment_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disease`
--
ALTER TABLE `disease`
  ADD CONSTRAINT `disease_ibfk_1` FOREIGN KEY (`Affected_Group_ID`) REFERENCES `affected_group` (`Group_ID`),
  ADD CONSTRAINT `disease_ibfk_2` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`);

--
-- Constraints for table `diseases_symptom`
--
ALTER TABLE `diseases_symptom`
  ADD CONSTRAINT `diseases_symptom_ibfk_1` FOREIGN KEY (`Symptom_ID`) REFERENCES `symptom` (`Symptom_ID`),
  ADD CONSTRAINT `diseases_symptom_ibfk_2` FOREIGN KEY (`Disease_ID`) REFERENCES `disease` (`Disease_ID`);

--
-- Constraints for table `diseases_treatment`
--
ALTER TABLE `diseases_treatment`
  ADD CONSTRAINT `diseases_treatment_ibfk_1` FOREIGN KEY (`Treatment_ID`) REFERENCES `treatment` (`Treatment_ID`),
  ADD CONSTRAINT `diseases_treatment_ibfk_2` FOREIGN KEY (`Disease_ID`) REFERENCES `disease` (`Disease_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

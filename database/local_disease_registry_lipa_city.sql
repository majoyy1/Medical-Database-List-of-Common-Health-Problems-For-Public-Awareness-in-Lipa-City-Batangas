-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2025 at 08:55 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddCategory` (IN `Categ_name` VARCHAR(39), IN `description` TEXT)  DETERMINISTIC SQL SECURITY INVOKER BEGIN
INSERT INTO category(Category_Name, Description) 
VALUES (Categ_name, description);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddDisease` (IN `dName` VARCHAR(60), IN `description` TEXT, IN `classification` VARCHAR(35), IN `categoryID` INT, IN `note` TEXT)  DETERMINISTIC BEGIN
INSERT INTO disease(Disease_Name, Description, Classification, Category_ID, Note) 
VALUES (dName, description, classification, categoryID, note);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteDisease` (IN `ID` INT)  DETERMINISTIC SQL SECURITY INVOKER BEGIN
DELETE FROM disease WHERE disease.Disease_ID = ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListOfDisease` ()  SQL SECURITY INVOKER BEGIN
SELECT d.Disease_ID, d.Disease_Name, d.Description, d.Classification, c.Category_Name from disease as d
Left JOIN category as c 
ON d.Category_ID = c.Category_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ModifyDisease` (IN `DName` VARCHAR(60), IN `descriptionDat` TEXT, IN `class` VARCHAR(40), IN `CId` INT, IN `note` TEXT)   BEGIN
UPDATE disease SET Disease_Name = DName, Description = descriptionDat, Classification = class, Category_ID = CId, Note = note 
WHERE Disease_ID = disease_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowAllData` ()  DETERMINISTIC BEGIN
SELECT * FROM `showalllist`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowListOfCategory` ()  DETERMINISTIC BEGIN
SELECT * FROm category;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ViewDisease` ()   Begin 

SELECT * FROM disease;

End$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `affected_group`
--

CREATE TABLE `affected_group` (
  `Group_ID` int(11) NOT NULL,
  `Disease_ID` int(11) NOT NULL,
  `Min_Age` int(11) NOT NULL,
  `Max_Age` int(11) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Date_Modified` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `affected_group`
--

INSERT INTO `affected_group` (`Group_ID`, `Disease_ID`, `Min_Age`, `Max_Age`, `Gender`, `Date_Modified`) VALUES
(5, 5, 0, 80, 'Both', '2025-03-19'),
(6, 6, 20, 80, 'Both', '2025-03-20'),
(7, 7, 5, 70, 'Both', '2025-03-21'),
(8, 8, 5, 50, 'Both', '2025-03-22'),
(10, 10, 0, 80, 'Both', '2025-03-24');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Category_Name` varchar(40) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_ID`, `Category_Name`, `Description`) VALUES
(1, 'Infectious Diseases', 'Diseases caused by pathogenic microorganisms'),
(2, 'Chronic Diseases', 'Long-lasting conditions with persistent effects'),
(3, 'Vector-Borne Diseases', 'Diseases transmitted by vectors like mosquitoes'),
(4, 'Respiratory Diseases', 'Diseases affecting the lungs and respiratory system'),
(5, 'Waterborne Diseases', 'Diseases spread through contaminated water'),
(6, 'asdasd', 'aaaaaaa'),
(7, 'Cat2', 'is null');

-- --------------------------------------------------------

--
-- Table structure for table `disease`
--

CREATE TABLE `disease` (
  `Disease_ID` int(11) NOT NULL,
  `Disease_Name` varchar(60) NOT NULL,
  `Description` text NOT NULL,
  `Classification` varchar(40) NOT NULL,
  `Category_ID` int(11) DEFAULT NULL,
  `Date_Modified` datetime NOT NULL DEFAULT current_timestamp(),
  `Note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disease`
--

INSERT INTO `disease` (`Disease_ID`, `Disease_Name`, `Description`, `Classification`, `Category_ID`, `Date_Modified`, `Note`) VALUES
(5, 'Influenza', 'Viral infection of the respiratory system', 'Respiratory', 4, '2025-04-12 11:07:29', '2'),
(6, 'Diabetes Mellitus', 'Metabolic disorder of high blood sugar', 'Chronic', 2, '2025-04-12 11:07:29', '3'),
(7, 'Cholera', 'Acute diarrheal illness caused by water contamination', 'Waterborne', 5, '2025-04-12 11:07:29', '1'),
(8, 'Asthma', 'Chronic inflammatory disease of the airways', 'Respiratory', 4, '2025-04-12 11:07:29', '2'),
(10, 'Pneumonia', 'Infection that inflames air sacs in lungs', 'Respiratory', 4, '2025-04-12 11:07:29', '1');

-- --------------------------------------------------------

--
-- Table structure for table `diseases_symptom`
--

CREATE TABLE `diseases_symptom` (
  `Diseases_Symptom_ID` int(11) NOT NULL,
  `Disease_ID` int(11) DEFAULT NULL,
  `Symptom_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diseases_symptom`
--

INSERT INTO `diseases_symptom` (`Diseases_Symptom_ID`, `Disease_ID`, `Symptom_ID`) VALUES
(1, NULL, 1),
(2, NULL, 2),
(3, NULL, 3),
(4, NULL, 4),
(5, NULL, 7),
(6, NULL, 8),
(7, NULL, 1),
(8, NULL, 5),
(9, NULL, 6),
(10, NULL, 1),
(11, NULL, 3),
(12, NULL, 9),
(13, 5, 1),
(14, 5, 2),
(15, 5, 5),
(16, 6, 8),
(17, 6, 9),
(18, 7, 9),
(19, 7, 10),
(20, 8, 5),
(21, 8, 6),
(22, NULL, 1),
(23, NULL, 2),
(24, NULL, 3),
(25, 10, 1),
(26, 10, 5),
(27, 10, 6);

-- --------------------------------------------------------

--
-- Table structure for table `diseases_treatment`
--

CREATE TABLE `diseases_treatment` (
  `Diseases_Treatment_ID` int(11) NOT NULL,
  `Disease_ID` int(11) DEFAULT NULL,
  `Treatment_ID` int(11) DEFAULT NULL,
  `Date_Modified` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diseases_treatment`
--

INSERT INTO `diseases_treatment` (`Diseases_Treatment_ID`, `Disease_ID`, `Treatment_ID`, `Date_Modified`) VALUES
(1, NULL, 1, '2025-04-12'),
(2, NULL, 2, '2025-04-12'),
(3, NULL, 8, '2025-04-12'),
(4, NULL, 4, '2025-04-12'),
(5, NULL, 3, '2025-04-12'),
(6, NULL, 8, '2025-04-12'),
(7, NULL, 3, '2025-04-12'),
(8, NULL, 9, '2025-04-12'),
(9, 5, 1, '2025-04-12'),
(10, 5, 8, '2025-04-12'),
(11, 6, 5, '2025-04-12'),
(12, 7, 2, '2025-04-12'),
(13, 7, 9, '2025-04-12'),
(14, 8, 6, '2025-04-12'),
(15, NULL, 7, '2025-04-12'),
(16, NULL, 8, '2025-04-12'),
(17, 10, 3, '2025-04-12'),
(18, 10, 8, '2025-04-12');

-- --------------------------------------------------------

--
-- Stand-in structure for view `showalllist`
-- (See below for the actual view)
--
CREATE TABLE `showalllist` (
`Disease_ID` int(11)
,`Disease_Name` varchar(60)
,`Description` text
,`Classification` varchar(40)
,`Category_Name` varchar(40)
,`Min_Age` int(11)
,`Max_Age` int(11)
,`Gender` varchar(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `symptom`
--

CREATE TABLE `symptom` (
  `Symptom_ID` int(11) NOT NULL,
  `Symptom_Name` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Severity` varchar(30) NOT NULL,
  `Note` text DEFAULT NULL,
  `DateCreated` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `symptom`
--

INSERT INTO `symptom` (`Symptom_ID`, `Symptom_Name`, `Description`, `Severity`, `Note`, `DateCreated`) VALUES
(1, 'Fever', 'Elevated body temperature', 'Moderate', 'Common in many diseases', '2025-04-12'),
(2, 'Headache', 'Pain in the head or neck region', 'Mild', '', '2025-04-12'),
(3, 'Muscle Pain', 'Aches in muscles throughout the body', 'Mild', '', '2025-04-12'),
(4, 'Rash', 'Skin irritation or eruption', 'Mild', '', '2025-04-12'),
(5, 'Cough', 'Expulsion of air from lungs', 'Moderate', 'Can be dry or productive', '2025-04-12'),
(6, 'Shortness of Breath', 'Difficulty in breathing', 'Severe', 'Requires immediate attention', '2025-04-12'),
(7, 'High Blood Pressure', 'Elevated pressure in arteries', 'Severe', 'Silent killer', '2025-04-12'),
(8, 'Fatigue', 'Extreme tiredness', 'Mild', '', '2025-04-12'),
(9, 'Diarrhea', 'Frequent loose or liquid bowel movements', 'Moderate', 'Can lead to dehydration', '2025-04-12'),
(10, 'Vomiting', 'Forceful expulsion of stomach contents', 'Moderate', '', '2025-04-12');

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `Treatment_ID` int(11) NOT NULL,
  `Treatment_Name` varchar(60) NOT NULL,
  `Description` text NOT NULL,
  `Notes` text DEFAULT NULL,
  `Date_Modified` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`Treatment_ID`, `Treatment_Name`, `Description`, `Notes`, `Date_Modified`) VALUES
(1, 'Paracetamol', 'Medication to reduce fever and pain', NULL, '2025-04-12'),
(2, 'ORS', 'Oral rehydration solution for dehydration', NULL, '2025-04-12'),
(3, 'Antibiotics', 'Medication to treat bacterial infections', NULL, '2025-04-12'),
(4, 'Antihypertensive Drugs', 'Medication to lower blood pressure', NULL, '2025-04-12'),
(5, 'Insulin Therapy', 'Treatment for diabetes management', NULL, '2025-04-12'),
(6, 'Bronchodilators', 'Medication to open airways in asthma', NULL, '2025-04-12'),
(7, 'Antimalarial Drugs', 'Medication to treat malaria', NULL, '2025-04-12'),
(8, 'Bed Rest', 'Physical rest to recover from illness', NULL, '2025-04-12'),
(9, 'IV Fluids', 'Intravenous fluids for severe dehydration', NULL, '2025-04-12'),
(10, 'Vaccination', 'Preventive immunization', NULL, '2025-04-12');

-- --------------------------------------------------------

--
-- Structure for view `showalllist`
--
DROP TABLE IF EXISTS `showalllist`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `showalllist`  AS SELECT `d`.`Disease_ID` AS `Disease_ID`, `d`.`Disease_Name` AS `Disease_Name`, `d`.`Description` AS `Description`, `d`.`Classification` AS `Classification`, `c`.`Category_Name` AS `Category_Name`, `a`.`Min_Age` AS `Min_Age`, `a`.`Max_Age` AS `Max_Age`, `a`.`Gender` AS `Gender` FROM ((`disease` `d` left join `affected_group` `a` on(`d`.`Disease_ID` = `a`.`Disease_ID`)) left join `category` `c` on(`d`.`Category_ID` = `c`.`Category_ID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affected_group`
--
ALTER TABLE `affected_group`
  ADD PRIMARY KEY (`Group_ID`),
  ADD KEY `Disease_ID` (`Disease_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`),
  ADD UNIQUE KEY `index_category` (`Category_Name`);

--
-- Indexes for table `disease`
--
ALTER TABLE `disease`
  ADD PRIMARY KEY (`Disease_ID`),
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
  MODIFY `Group_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `disease`
--
ALTER TABLE `disease`
  MODIFY `Disease_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `diseases_symptom`
--
ALTER TABLE `diseases_symptom`
  MODIFY `Diseases_Symptom_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `diseases_treatment`
--
ALTER TABLE `diseases_treatment`
  MODIFY `Diseases_Treatment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `symptom`
--
ALTER TABLE `symptom`
  MODIFY `Symptom_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
  MODIFY `Treatment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affected_group`
--
ALTER TABLE `affected_group`
  ADD CONSTRAINT `affected_group_ibfk_1` FOREIGN KEY (`Disease_ID`) REFERENCES `disease` (`Disease_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `disease`
--
ALTER TABLE `disease`
  ADD CONSTRAINT `disease_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Constraints for table `diseases_symptom`
--
ALTER TABLE `diseases_symptom`
  ADD CONSTRAINT `diseases_symptom_ibfk_1` FOREIGN KEY (`Disease_ID`) REFERENCES `disease` (`Disease_ID`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `diseases_symptom_ibfk_2` FOREIGN KEY (`Symptom_ID`) REFERENCES `symptom` (`Symptom_ID`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `diseases_treatment`
--
ALTER TABLE `diseases_treatment`
  ADD CONSTRAINT `diseases_treatment_ibfk_1` FOREIGN KEY (`Treatment_ID`) REFERENCES `treatment` (`Treatment_ID`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `diseases_treatment_ibfk_2` FOREIGN KEY (`Disease_ID`) REFERENCES `disease` (`Disease_ID`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 08:11 AM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddDiseaseSymptom` (IN `disId` INT, IN `symid` INT)   INSERT INTO diseases_symptom(Disease_ID, Symptom_ID)
VALUES (disId, symid)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteDisease` (IN `ID` INT)  DETERMINISTIC SQL SECURITY INVOKER BEGIN
DELETE FROM disease WHERE disease.Disease_ID = ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetLastDiseaseID` ()   SELECT * FROM `disease` ORDER by Disease_ID DESC LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListOfDisease` ()  SQL SECURITY INVOKER BEGIN
SELECT d.Disease_ID, d.Disease_Name, d.Description, d.Classification, c.Category_Name from disease as d
Left JOIN category as c 
ON d.Category_ID = c.Category_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ModifyDisease` (IN `ID` INT, IN `DName` VARCHAR(60), IN `descriptionDat` TEXT, IN `class` VARCHAR(40), IN `CId` INT, IN `note` TEXT)   BEGIN
UPDATE disease SET Disease_Name = DName, Description = descriptionDat, Classification = class, Category_ID = CId, Note = note 
WHERE Disease_ID = ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `modifyDiseasebyID` (IN `id` INT, IN `name` VARCHAR(60), IN `des` TEXT, IN `class` VARCHAR(40), IN `catID` INT, IN `note` TEXT)  DETERMINISTIC SQL SECURITY INVOKER UPDATE disease SET Disease_Name = name, Description = des, Classification = class, Category_ID = catID, Note = note WHERE disease.Disease_ID = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchDisByID` (IN `id` INT)  DETERMINISTIC SQL SECURITY INVOKER SELECT * FROM disease WHERE Disease_ID = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchDiseaseByLetter` (IN `searchLetter` VARCHAR(5))   BEGIN
    SELECT Disease_Name, description 
    FROM disease 
    WHERE Disease_Name LIKE CONCAT(searchLetter, '%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchDiseaseByName` (IN `searchLetter` VARCHAR(100))   BEGIN
    SELECT Disease_Name, description 
    FROM disease 
    WHERE Disease_Name LIKE CONCAT('%', searchLetter, '%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowAllData` ()  DETERMINISTIC BEGIN
SELECT * FROM `showalllist`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowAllSymptom` ()   SELECT * FROM `symptom`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowListOfCategory` ()  DETERMINISTIC BEGIN
SELECT * FROm category;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `testMainDbConnection` ()  DETERMINISTIC SELECT Disease_ID from disease LIMIT 1$$

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
(37, 'Dengue Fever', 'Viral disease transmitted by Aedes mosquitoes', 'Vector-Borne', 3, '2025-04-23 20:49:35', '1'),
(38, 'Hypertension', 'High blood pressure condition', 'Chronic', 2, '2025-04-23 20:49:35', '2'),
(40, 'Leptospirosis', 'Bacterial infection spread through contaminated water', 'Waterborne', 5, '2025-04-23 20:49:35', '1'),
(41, 'Influenza', 'Viral infection of the respiratory system', 'Respiratory', 4, '2025-04-23 20:49:35', '2'),
(42, 'Diabetes Mellitus', 'Metabolic disorder of high blood sugar', 'Chronic', 2, '2025-04-23 20:49:35', '3'),
(45, 'Malaria', 'Parasitic disease transmitted by Anopheles mosquitoes', 'Vector-Borne', 3, '2025-04-23 20:49:35', '3'),
(46, 'Pneumonia', 'Infection that inflames air sacs in lungs', 'Respiratory', 4, '2025-04-23 20:49:35', '1'),
(47, 'Diabetes Mellitusasas', 'asasaweqwe21', 'Class', 6, '2025-04-25 15:17:20', 'N/a'),
(50, 'add', 'dada', 'adad', 1, '2025-04-29 16:58:23', ''),
(51, 'add', 'dada', 'adad', 1, '2025-04-29 16:58:45', ''),
(52, 'add', 'dada', 'adad', 1, '2025-04-29 16:59:15', ''),
(53, 'qwerqw', 'fasdfg', 'fgshrh', 1, '2025-04-29 17:30:46', ''),
(54, 'qwerqw', 'fasdfg', 'fgshrh', 1, '2025-04-29 17:31:24', ''),
(55, 'qwerqw', 'fasdfg', 'fgshrh', 1, '2025-04-29 17:32:59', ''),
(56, 'qwerqw', 'fasdfg', 'fgshrh', 1, '2025-04-29 17:34:11', ''),
(57, 'qwerqw', 'fasdfg', 'fgshrh', 1, '2025-04-29 17:34:25', ''),
(58, 'dfsgdfg', 'dfsgsdfg', 'dfsgdfg', 1, '2025-04-29 17:34:35', ''),
(59, 'waerwea', 'awerwe', 'awer', 1, '2025-04-29 17:35:42', ''),
(60, 'sdafasf', 'sadfasdf', 'sdfsdfda', 1, '2025-04-29 17:38:06', ''),
(61, 'sdfdf', 'asfsdf', 'sdfadf', 1, '2025-04-29 17:38:13', ''),
(62, 'asfasf', 'asdfa', 'asdfa', 1, '2025-04-29 17:39:32', ''),
(63, 'asdfasdf', 'asdfsd', 'sadfasd', 1, '2025-04-29 17:39:39', ''),
(64, 'asdfg', 'asdfgjhf', 'sdafghj', 1, '2025-04-29 17:40:36', ''),
(65, 'asdfgfh', 'dsfgh', 'dfsgh', 1, '2025-04-29 17:40:52', ''),
(66, 'asdfgfh', 'dsfgh', 'dfsgh', 1, '2025-04-29 17:41:19', ''),
(67, 'asdfgfh', 'dsfgh', 'dfsgh', 1, '2025-04-29 17:41:21', ''),
(68, 'asdfgfh', 'dsfgh', 'dfsgh', 1, '2025-04-29 17:41:24', ''),
(69, 'asdfgfh', 'dsfgh', 'dfsgh', 1, '2025-04-29 17:41:26', ''),
(70, 'asdfgfh', 'dsfgh', 'dfsgh', 1, '2025-04-29 17:41:29', ''),
(71, 'qwert', '2t', 'adfs', 1, '2025-04-29 17:41:50', ''),
(72, 'asdfgjh', 'asdfg', 'dfgh', 1, '2025-04-29 18:50:01', ''),
(73, 'q4e56tp', '243567890', 'dsfghjk', 1, '2025-04-29 18:52:54', ''),
(74, '1234', '2134', '23456', 1, '2025-04-29 18:53:53', ''),
(75, '323456', 'dfdf', 'asdfasd', 1, '2025-04-29 18:54:48', ''),
(76, 'asdasd', 'asdasd', 'asdasd', 1, '2025-04-29 18:55:11', ''),
(77, 'test1212', 'asdas', 'aaaaaaaa', 1, '2025-04-29 19:58:56', ''),
(78, 'test12345667', 'aaaaaaaaaaa', 'aaaaaaaaaaaaa', 1, '2025-04-29 19:59:58', ''),
(79, 'hahahahhahahh1212121111111111111111111111111111111', '111111111111111', '1111111111111111111', 1, '2025-04-29 20:05:06', ''),
(80, 'test12345667', 'aaaaaaaaaaa', 'aaaaaaaaaaaaa', 1, '2025-04-29 20:06:30', ''),
(81, 'test12345667', 'aaaaaaaaaaa', 'aaaaaaaaaaaaa', 1, '2025-04-29 20:08:25', ''),
(82, 'test12345667', 'aaaaaaaaaaa', 'aaaaaaaaaaaaa', 1, '2025-04-29 20:12:13', ''),
(83, 'test12345667', 'aaaaaaaaaaa', 'aaaaaaaaaaaaa', 1, '2025-04-29 20:16:40', '');

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
(36, 40, 5),
(37, 82, 1),
(38, 82, 2),
(39, 82, 3),
(40, 82, 4),
(41, 82, 5),
(42, 82, 6),
(43, 82, 7),
(44, 82, 8),
(45, 82, 9),
(46, 83, 1),
(47, 83, 2),
(48, 83, 3),
(49, 83, 4),
(50, 83, 5),
(51, 83, 6),
(52, 83, 7),
(53, 83, 8),
(54, 83, 9);

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
(9, NULL, 1, '2025-04-12'),
(10, NULL, 8, '2025-04-12'),
(11, NULL, 5, '2025-04-12'),
(12, NULL, 2, '2025-04-12'),
(13, NULL, 9, '2025-04-12'),
(14, NULL, 6, '2025-04-12'),
(15, NULL, 7, '2025-04-12'),
(16, NULL, 8, '2025-04-12'),
(17, NULL, 3, '2025-04-12'),
(18, NULL, 8, '2025-04-12');

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
  MODIFY `Disease_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `diseases_symptom`
--
ALTER TABLE `diseases_symptom`
  MODIFY `Diseases_Symptom_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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

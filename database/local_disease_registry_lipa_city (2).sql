-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 01:46 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddSymptom` (IN `Name` VARCHAR(50), IN `Description` TEXT, IN `Severity` VARCHAR(30), IN `note` TEXT)   BEGIN
INSERT INTO symptom (Symptom_Name, Description, Severity, Note)
VALUES(Name, Description, Severity, note);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CheckSymptomOfId` (IN `id` INT)   SELECT s.Symptom_Name, s.Symptom_Description, s.Severity, s.Note
from list_disease_symptom as s 
WHERE s.Disease_ID = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteDisease` (IN `ID` INT)  DETERMINISTIC SQL SECURITY INVOKER BEGIN
DELETE FROM disease WHERE disease.Disease_ID = ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetLastDiseaseID` ()   SELECT * FROM `disease` ORDER by Disease_ID DESC LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListOfDisease` ()  SQL SECURITY INVOKER BEGIN
SELECT d.Disease_ID, d.Disease_Name, d.Description, d.Classification, c.Category_Name from disease as d
Left JOIN category as c 
ON d.Category_ID = c.Category_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchDisByID` (IN `id` INT)  DETERMINISTIC SQL SECURITY INVOKER SELECT d.Disease_ID, d.Disease_Name, d.Description, d.Classification, cat.Category_Name as Category, d.Note, d.Date_Modified
FROM disease as d
LEFT JOIN category as cat on cat.Category_ID = d.Category_ID
WHERE d.Disease_ID = id
LIMIT 1$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowAllSymptom` ()   SELECT * FROM `symptom`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowListOfCategory` ()  DETERMINISTIC BEGIN
SELECT * FROm category;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowView_list_disease_symptom` ()   SELECT * FROM list_disease_symptom$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `testMainDbConnection` ()  DETERMINISTIC SELECT Disease_ID from disease LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateDiseaseByID` (IN `id` INT, IN `name` VARCHAR(60), IN `des` TEXT, IN `class` VARCHAR(40), IN `catID` INT, IN `note` TEXT)  DETERMINISTIC SQL SECURITY INVOKER BEGIN
UPDATE disease SET Disease_Name = name, Description = des, Classification = class, Category_ID = catID, Note = note WHERE disease.Disease_ID = id;
END$$

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
(41, 'Influenza', 'Viral infection of the respiratory system', 'Respiratory', 4, '2025-04-23 20:49:35', '2'),
(42, 'Diabetes Mellitus', 'Metabolic disorder of high blood sugar', 'Chronic', 2, '2025-04-23 20:49:35', '3'),
(84, 'Disease Test One', 'Elevated body temperature test123 hahaha', 'Testaaa', 1, '2025-05-03 14:53:24', 'Wala');

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
(36, NULL, 5),
(55, NULL, 2),
(56, NULL, 3),
(57, NULL, 5),
(58, 84, 1),
(59, 84, 2),
(60, 84, 3),
(61, 84, 4),
(62, 84, 5),
(63, 84, 6),
(64, 84, 7),
(65, 84, 8),
(66, 84, 9),
(67, 84, 10),
(68, NULL, 2);

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
-- Stand-in structure for view `list_disease_symptom`
-- (See below for the actual view)
--
CREATE TABLE `list_disease_symptom` (
`Disease_ID` int(11)
,`Disease_Name` varchar(60)
,`Disease_Description` text
,`Classification` varchar(40)
,`Category` varchar(40)
,`Note` text
,`Symptom_Name` varchar(50)
,`Symptom_Description` text
,`Severity` varchar(30)
,`Date_Modified` datetime
);

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
(10, 'Vomiting', 'Forceful expulsion of stomach contents', 'Moderate', '', '2025-04-12'),
(20, 'a', 'a', '0', 'aa', '2025-05-03'),
(21, 'a', 'a', 'a', 'aa', '2025-05-03'),
(22, 'a', 'a', 'a', 'aa', '2025-05-03');

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
-- Structure for view `list_disease_symptom`
--
DROP TABLE IF EXISTS `list_disease_symptom`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `list_disease_symptom`  AS SELECT `d`.`Disease_ID` AS `Disease_ID`, `d`.`Disease_Name` AS `Disease_Name`, `d`.`Description` AS `Disease_Description`, `d`.`Classification` AS `Classification`, `cat`.`Category_Name` AS `Category`, `d`.`Note` AS `Note`, `s`.`Symptom_Name` AS `Symptom_Name`, `s`.`Description` AS `Symptom_Description`, `s`.`Severity` AS `Severity`, `d`.`Date_Modified` AS `Date_Modified` FROM (((`disease` `d` left join `category` `cat` on(`cat`.`Category_ID` = `d`.`Category_ID`)) left join `diseases_symptom` `ds` on(`ds`.`Disease_ID` = `d`.`Disease_ID`)) left join `symptom` `s` on(`s`.`Symptom_ID` = `ds`.`Symptom_ID`)) ;

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
  MODIFY `Disease_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `diseases_symptom`
--
ALTER TABLE `diseases_symptom`
  MODIFY `Diseases_Symptom_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `diseases_treatment`
--
ALTER TABLE `diseases_treatment`
  MODIFY `Diseases_Treatment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `symptom`
--
ALTER TABLE `symptom`
  MODIFY `Symptom_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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

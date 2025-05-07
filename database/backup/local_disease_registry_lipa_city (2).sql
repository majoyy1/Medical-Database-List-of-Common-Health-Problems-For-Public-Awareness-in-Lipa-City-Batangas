-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 05:11 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetPossibleDiseases` (IN `symptom_names` TEXT)   BEGIN
  -- 1) Get all matching diseases
  SELECT DISTINCT
    d.Disease_ID,
    d.Disease_Name,
    d.Description,
    d.Classification,
    d.Category_ID,
    d.Date_Modified,
    d.Note
  FROM disease d
  JOIN diseases_symptom ds ON d.Disease_ID = ds.Disease_ID
  JOIN symptom s           ON ds.Symptom_ID = s.Symptom_ID
  WHERE FIND_IN_SET(s.Symptom_Name, symptom_names) > 0;

  -- 2) Get treatments for those diseases
  SELECT DISTINCT
    t.Treatment_ID,
    t.Treatment_Name,
    t.Description,
    t.Notes,
    t.Date_Modified
  FROM treatment t
  JOIN diseases_treatment dt ON t.Treatment_ID = dt.Treatment_ID
  JOIN diseases_symptom ds   ON ds.Disease_ID = dt.Disease_ID
  JOIN symptom s             ON s.Symptom_ID = ds.Symptom_ID
  WHERE FIND_IN_SET(s.Symptom_Name, symptom_names) > 0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetSymptoms` ()   BEGIN
    SELECT Symptom_Name FROM symptom ORDER BY Symptom_Name ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTreatmentsForDiseases` (IN `disease_ids` TEXT)   BEGIN
    -- Convert the comma-separated string into a list of IDs and fetch treatments
    SET @sql = CONCAT('
        SELECT 
            dt.Disease_ID,
            t.Treatment_Name,
            t.Description 
        FROM diseases_treatment dt
        JOIN treatment t ON dt.Treatment_ID = t.Treatment_ID
        WHERE dt.Disease_ID IN (', disease_ids, ')');

    -- Prepare and execute the dynamic SQL
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

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
(1, 'Respiratory', 'Diseases or symptoms related to the respiratory system, such as the lungs, airways, and breathing mechanisms.'),
(2, 'Metabolic', 'Conditions that affect the body’s metabolism, including blood sugar regulation, energy production, and fat storage.'),
(3, 'Cardiovascular', 'Diseases related to the heart and blood vessels, such as high blood pressure, heart attacks, and stroke.'),
(4, 'Neurological', 'Conditions that affect the brain, spinal cord, and nerves, including diseases like Alzheimer’s, Parkinson’s, and migraines.'),
(5, 'Gastrointestinal', 'Disorders that affect the digestive system, including conditions like ulcers, IBS, and GERD.'),
(6, 'Infectious Diseases', 'Diseases caused by pathogens like bacteria, viruses, fungi, and parasites, such as the flu, tuberculosis, and HIV.'),
(7, 'Musculoskeletal', 'Conditions affecting the muscles, bones, and joints, including arthritis, osteoporosis, and muscle strains.'),
(8, 'Autoimmune', 'Diseases where the immune system attacks the body’s own cells, including rheumatoid arthritis, lupus, and multiple sclerosis.'),
(9, 'Psychiatric', 'Mental health conditions affecting mood, behavior, and cognition, such as depression, anxiety, and schizophrenia.'),
(10, 'Hematologic', 'Diseases related to the blood, including anemia, leukemia, and clotting disorders.'),
(11, 'Allergic', 'Conditions caused by allergic reactions, including asthma, hay fever, and anaphylaxis.'),
(12, 'Endocrine', 'Conditions affecting hormone-producing glands, such as thyroid disorders, diabetes, and adrenal insufficiency.'),
(13, 'Renal', 'Disorders of the kidneys, such as chronic kidney disease, kidney stones, and urinary tract infections.'),
(14, 'Dermatological', 'Conditions that affect the skin, hair, and nails, such as acne, eczema, and psoriasis.'),
(15, 'Oncological', 'Cancer-related conditions, including the various types of cancers affecting different organs in the body.');

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
(1, 'Common Cold', 'A viral infection affecting the upper respiratory tract, causing a runny nose, cough, and sore throat.', '', 1, '2025-05-03 22:54:01', NULL),
(2, 'Pneumonia', 'A lung infection causing inflammation, fever, cough, and difficulty breathing.', '', 1, '2025-05-03 22:54:01', NULL),
(3, 'Type 2 Diabetes', 'A chronic metabolic disorder where the body becomes resistant to insulin, leading to high blood sugar levels.', '', 2, '2025-05-03 22:54:01', NULL),
(4, 'Hypertension', 'High blood pressure, a condition where the force of the blood against the walls of arteries is too high.', '', 3, '2025-05-03 22:54:01', NULL),
(5, 'Heart Attack', 'A condition where blood flow to the heart is blocked, causing damage to the heart muscle.', '', 3, '2025-05-03 22:54:01', NULL),
(6, 'Alzheimer\'s Disease', 'A progressive neurodegenerative disease affecting memory and cognition.', '', 4, '2025-05-03 22:54:01', NULL),
(7, 'Parkinson\'s Disease', 'A neurodegenerative disorder affecting movement, causing tremors and stiffness.', '', 4, '2025-05-03 22:54:01', NULL),
(8, 'Irritable Bowel Syndrome (IBS)', 'A gastrointestinal disorder causing abdominal pain, bloating, and changes in bowel movements.', '', 5, '2025-05-03 22:54:01', NULL),
(9, 'Gastroesophageal Reflux Disease (GERD)', 'A digestive disorder where stomach acid frequently flows back into the esophagus.', '', 5, '2025-05-03 22:54:01', NULL),
(10, 'Tuberculosis', 'A bacterial infection primarily affecting the lungs, causing chronic cough and weight loss.', '', 6, '2025-05-03 22:54:01', NULL),
(11, 'Malaria', 'A parasitic infection transmitted by mosquitoes, causing fever, chills, and flu-like symptoms.', '', 6, '2025-05-03 22:54:01', NULL),
(12, 'Rheumatoid Arthritis', 'An autoimmune disease where the immune system attacks the joints, leading to inflammation and deformity.', '', 8, '2025-05-03 22:54:01', NULL),
(13, 'Multiple Sclerosis', 'An autoimmune disease affecting the central nervous system, leading to muscle weakness and vision problems.', '', 8, '2025-05-03 22:54:01', NULL),
(14, 'Asthma', 'A chronic respiratory condition where the airways become inflamed and narrowed, leading to breathing difficulties.', '', 11, '2025-05-03 22:54:01', NULL),
(15, 'Psoriasis', 'A skin disorder that causes red, flaky patches, often on the elbows, knees, and scalp.', '', 14, '2025-05-03 22:54:01', NULL);

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
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 2, 1),
(6, 2, 2),
(7, 2, 8),
(8, 2, 9),
(9, 3, 7),
(10, 3, 13),
(11, 4, 9),
(12, 4, 7),
(13, 4, 6),
(14, 5, 9),
(15, 5, 8),
(16, 5, 7),
(17, 6, 7),
(18, 6, 6),
(19, 7, 7),
(20, 7, 6),
(21, 7, 14),
(22, 8, 11),
(23, 8, 12),
(24, 8, 13),
(25, 9, 10),
(26, 9, 13),
(27, 10, 1),
(28, 10, 2),
(29, 10, 7),
(30, 11, 1),
(31, 11, 7),
(32, 11, 6),
(33, 12, 14),
(34, 12, 15),
(35, 13, 6),
(36, 13, 14),
(37, 13, 7),
(39, 14, 8),
(40, 14, 1),
(41, 15, 15);

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
(1, NULL, NULL, '2025-04-12'),
(2, NULL, NULL, '2025-04-12'),
(3, NULL, NULL, '2025-04-12'),
(4, NULL, NULL, '2025-04-12'),
(5, NULL, NULL, '2025-04-12'),
(6, NULL, NULL, '2025-04-12'),
(7, NULL, NULL, '2025-04-12'),
(8, NULL, NULL, '2025-04-12'),
(9, NULL, NULL, '2025-04-12'),
(10, NULL, NULL, '2025-04-12'),
(11, NULL, NULL, '2025-04-12'),
(12, NULL, NULL, '2025-04-12'),
(13, NULL, NULL, '2025-04-12'),
(14, NULL, NULL, '2025-04-12'),
(15, NULL, NULL, '2025-04-12'),
(16, NULL, NULL, '2025-04-12'),
(17, NULL, NULL, '2025-04-12'),
(18, NULL, NULL, '2025-04-12'),
(19, 1, 1, '2025-05-03'),
(20, 1, 4, '2025-05-03'),
(21, 1, 14, '2025-05-03'),
(22, 2, 3, '2025-05-03'),
(23, 2, 8, '2025-05-03'),
(24, 2, 5, '2025-05-03'),
(25, 3, 7, '2025-05-03'),
(26, 3, 6, '2025-05-03'),
(27, 4, 2, '2025-05-03'),
(28, 4, 9, '2025-05-03'),
(29, 5, 8, '2025-05-03'),
(30, 5, 10, '2025-05-03'),
(31, 6, 6, '2025-05-03'),
(32, 6, 9, '2025-05-03'),
(33, 7, 6, '2025-05-03'),
(34, 7, 9, '2025-05-03'),
(35, 8, 13, '2025-05-03'),
(36, 8, 4, '2025-05-03'),
(37, 8, 12, '2025-05-03'),
(38, 9, 2, '2025-05-03'),
(39, 9, 6, '2025-05-03'),
(40, 10, 3, '2025-05-03'),
(41, 10, 10, '2025-05-03'),
(42, 11, 13, '2025-05-03'),
(43, 11, 3, '2025-05-03'),
(44, 11, 12, '2025-05-03'),
(45, 12, 9, '2025-05-03'),
(46, 12, 12, '2025-05-03'),
(47, 13, 9, '2025-05-03'),
(48, 13, 6, '2025-05-03'),
(49, 14, 5, '2025-05-03'),
(50, 14, 1, '2025-05-03'),
(51, 15, 15, '2025-05-03');

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
(1, 'Fever', 'An elevation of body temperature above the normal range.', 'Moderate', 'Common in infections.', '2025-01-10'),
(2, 'Cough', 'A sudden, forceful hacking sound to release air and clear irritation in the throat or airway.', 'Mild', 'Can be dry or productive.', '2025-01-11'),
(3, 'Sore Throat', 'Pain or irritation in the throat, often worsened by swallowing.', 'Moderate', 'Often accompanies upper respiratory infections.', '2025-01-12'),
(4, 'Runny Nose', 'Excess drainage, ranging from a clear fluid to thick mucus, from the nasal passages.', 'Mild', 'Also called rhinorrhea.', '2025-01-13'),
(5, 'Muscle Aches', 'Pain or discomfort in the muscles, often diffuse and associated with fatigue.', 'Moderate', 'Common in viral illnesses.', '2025-01-14'),
(6, 'Headache', 'Pain or discomfort in the head or face area.', 'Mild', 'Tension, migraine, or secondary to other conditions.', '2025-01-15'),
(7, 'Fatigue', 'A feeling of tiredness or exhaustion that may not be relieved by rest.', 'Moderate', 'Can be acute or chronic.', '2025-01-16'),
(8, 'Shortness of Breath', 'Difficulty breathing or feeling unable to get enough air.', 'Severe', 'Requires prompt evaluation.', '2025-01-17'),
(9, 'Chest Pain', 'Discomfort or pain in the chest area, which may indicate cardiac or non-cardiac causes.', 'Severe', 'Rule out myocardial infarction.', '2025-01-18'),
(10, 'Nausea', 'A sensation of unease and discomfort in the upper stomach with an involuntary urge to vomit.', 'Mild', 'Often precedes vomiting.', '2025-01-19'),
(11, 'Vomiting', 'The forcible voluntary or involuntary emptying (“throwing up”) of stomach contents through the mouth.', 'Moderate', 'Risk of dehydration.', '2025-01-20'),
(12, 'Diarrhea', 'Loose, watery stools occurring more frequently than usual.', 'Moderate', 'Monitor for fluid loss.', '2025-01-21'),
(13, 'Abdominal Pain', 'Discomfort in the area between the chest and pelvis.', 'Moderate', 'Etiology can be GI, GU, or other.', '2025-01-22'),
(14, 'Joint Pain', 'Discomfort arising from any joint of the body.', 'Mild', 'Arthritis or overuse.', '2025-01-23'),
(15, 'Rash', 'An area of irritated or swollen skin, often itchy or painful.', 'Mild', 'Can be macular, papular, or mixed.', '2025-01-24');

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
(1, 'Paracetamol', 'Used to reduce fever and mild pain', 'Commonly used for fever and mild discomfort', '2025-05-03'),
(2, 'Ibuprofen', 'Nonsteroidal anti-inflammatory drug (NSAID), used for pain relief and to reduce inflammation', 'May cause stomach upset if not taken with food', '2025-05-03'),
(3, 'Antibiotics', 'Used to treat bacterial infections, often prescribed for pneumonia', 'Requires a full course to prevent resistance', '2025-05-03'),
(4, 'Cough Syrup', 'Helps in reducing coughing', 'Can be used for dry or productive coughs', '2025-05-03'),
(5, 'Inhaler', 'Used for asthma and other respiratory conditions to help open airways', 'Essential for managing asthma attacks', '2025-05-03'),
(6, 'Steroids', 'Medications used to reduce inflammation and treat autoimmune conditions', 'Can have side effects with long-term use', '2025-05-03'),
(7, 'Insulin Therapy', 'Used to manage blood sugar levels in patients with Type 2 Diabetes', 'Requires careful monitoring of blood glucose levels', '2025-05-03'),
(8, 'Surgery', 'A medical procedure involving an incision to treat various diseases, such as heart disease', 'Only recommended when other treatments fail', '2025-05-03'),
(9, 'Physical Therapy', 'Treatment to improve movement and manage pain, often used for arthritis', 'Important for rehabilitation and improving mobility', '2025-05-03'),
(10, 'Oxygen Therapy', 'Providing extra oxygen to patients with respiratory diseases', 'Used for diseases like pneumonia, COPD, and asthma', '2025-05-03'),
(11, 'Chemotherapy', 'A type of cancer treatment that uses drugs to destroy cancer cells', 'Often accompanied by side effects like nausea and fatigue', '2025-05-03'),
(12, 'Anti-inflammatory drugs', 'Used to reduce inflammation and manage pain for conditions like arthritis', 'Long-term use may have cardiovascular risks', '2025-05-03'),
(13, 'Hydration Therapy', 'Fluids given to patients who are dehydrated due to illnesses like malaria or severe diarrhea', 'Hydration is critical for recovery from fluid loss', '2025-05-03'),
(14, 'Rest and Fluids', 'Basic treatment for viral infections like the common cold, emphasizing rest and hydration', 'May take several days to recover', '2025-05-03'),
(15, 'Sun Protection', 'Used to treat psoriasis and other skin conditions by preventing skin flare-ups caused by UV exposure', 'Requires regular application of sunscreen', '2025-05-03');

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
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `Diseases_Treatment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `symptom`
--
ALTER TABLE `symptom`
  MODIFY `Symptom_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
  MODIFY `Treatment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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

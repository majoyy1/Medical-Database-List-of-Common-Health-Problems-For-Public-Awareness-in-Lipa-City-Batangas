-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 01:47 PM
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
-- Database: `login_credentials`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddUserAuth` (IN `Uname` VARCHAR(60), IN `hashedPass` VARCHAR(90))  DETERMINISTIC SQL SECURITY INVOKER INSERT INTO user(username, encryption) 
VALUES (Uname, hashedPass)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchByUserName` (IN `uname` VARCHAR(120))   BEGIN
SELECT * from user WHERE username = uname LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowUserAuth` ()   BEGIN
SELECT * FROM user; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `testLoginDbConnection` ()  DETERMINISTIC SELECT user_ID from user LIMIT 1$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(7) NOT NULL,
  `username` varchar(50) NOT NULL,
  `encryption` varchar(120) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `UserRole` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `username`, `encryption`, `DateCreated`, `UserRole`) VALUES
(1000128, 'Admin', 'root', '2025-04-24 18:50:34', 2),
(1000129, 'meow', '$2y$10$SV3UBM.X8qk3CgYFCbHc5eTKHQz56RXWwIjUGwi.lqs.ivyAYD6CS', '2025-04-24 18:50:55', 1),
(1000130, 'admin1', '$2y$10$OhiwItTHoM2wOkXNq/5Aa.dOlU2HfbsD4Lrfv1GVsEd.KI9fVHFAC', '2025-04-24 18:51:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `role_name`) VALUES
(1, 'Guest'),
(2, 'Administrator'),
(3, 'ViewOnly');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `byUname` (`username`) USING BTREE,
  ADD KEY `UserRole` (`UserRole`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000131;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`UserRole`) REFERENCES `user_role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

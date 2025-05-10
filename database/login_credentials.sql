-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 03:58 PM
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
(1000141, 'aaa', '$2y$10$KacMgToMT5ZvlsFH0Wq3aOd3OxcauvP0exuUDuB02codxf0ETRIHy', '2025-05-04 18:19:44', 1),
(1000142, 'admin', '$2y$10$xXf4kEiDdA03wtU6JbzbWOrHDcLTwg9jFcmY3eEYzSTdjCESySF3.', '2025-05-04 18:21:39', 1),
(1000143, 'admin1', '$2y$10$DH2MpUnK5RQUCmTKTEkAtOC0II0UhSaENcqxh6PO2xpYmUFW3nesO', '2025-05-07 15:02:05', 1),
(1000144, '1', '$2y$10$fOODgdzhBVS2tKcC2w8OreVqZ6fxgdKqzPIpuCfGKtQkaBmXsxeRG', '2025-05-10 11:33:20', 1);

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
  MODIFY `user_ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000145;

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

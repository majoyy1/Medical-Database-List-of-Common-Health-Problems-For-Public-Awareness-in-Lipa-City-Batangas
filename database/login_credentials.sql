-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2025 at 03:40 AM
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

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(7) NOT NULL,
  `username` varchar(50) NOT NULL,
  `encryption` varchar(120) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `UserRole` int(5) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `username`, `encryption`, `DateCreated`, `UserRole`) VALUES
(1, '1213', 'arw3423r2434', '0000-00-00 00:00:00', 1),
(1000001, 'john_doe', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', '2023-10-15 09:30:45', 1),
(1000002, 'jane_smith', '$2y$10$Lkjsdflkjsdfkjhsdf.kjhsfdkjhsdfkjhsdfkjhsfdkjhsfdkjhs', '2023-10-16 14:20:10', 2),
(1000003, 'admin_user', '$2y$10$KJHSDFKJHSDfkjsdhfkjsdhfkjshdfkjhsdfkjhsdfkjhsdfkjhsdf', '2023-10-17 08:45:22', 5),
(1000004, 'alice_green', '$2y$10$SDLFJSDLKFJsdflkjsdflkjsdflkjsdflkjsdflkjsdflkjsdflkj', '2023-10-18 11:15:33', 1),
(1000005, 'bob_builder', '$2y$10$DFLKJSDLFKJsdflkjsdflkjsdflkjsdflkjsdflkjsdflkjsdflkj', '2023-10-19 16:40:05', 2),
(1000006, 'emma_watson', '$2y$10$KJSDHFLKSDJfkjshdfkjshdfkjshdfkjshdfkjshdfkjshdfkjshd', '2023-10-20 10:25:18', 1),
(1000007, 'mike_tyson', '$2y$10$LKJSDFLKJSFkjshdfkjshdfkjshdfkjshdfkjshdfkjshdfkjshdf', '2023-10-21 13:50:30', 3),
(1000008, 'sarah_connor', '$2y$10$SDKJFLSKDJFkjshdfkjshdfkjshdfkjshdfkjshdfkjshdfkjshdf', '2023-10-22 17:35:42', 2),
(1000009, 'dave_grohl', '$2y$10$KJSDHFLKSDJfkjshdfkjshdfkjshdfkjshdfkjshdfkjshdfkjshd', '2023-10-23 20:15:55', 1),
(1000010, 'lisa_ray', '$2y$10$LKJSDFLKJSFkjshdfkjshdfkjshdfkjshdfkjshdfkjshdfkjshdf', '2023-10-24 22:45:10', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `byUname` (`username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000011;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

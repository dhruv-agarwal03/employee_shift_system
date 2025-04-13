-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2025 at 07:20 AM
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
-- Database: `employee_shift_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `full_name` varchar(30) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `full_name`, `email`, `mobile`, `city`, `password`, `created_on`) VALUES
(1, 'arun ', 'arun@gmail.com', '78654862452', 'Meerut', 'abc', '2025-04-14 16:45:53'),
(2, 'ajay ', 'ajay@gmail.com', '471025841', 'Meerut', 'abc', '2025-04-14 16:46:29'),
(3, 'admin a', 'admin@gmail.com', '7451', 'Meerut', 'abc', '2025-04-14 17:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `holidayrequest`
--

CREATE TABLE `holidayrequest` (
  `holidayChangeId` int(11) NOT NULL,
  `from_emp` int(11) DEFAULT NULL,
  `to_emp` int(11) DEFAULT NULL,
  `day` int(11) NOT NULL,
  `from_emp_shift` varchar(1) DEFAULT NULL,
  `to_emp_shift` varchar(1) DEFAULT NULL,
  `week_id` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT 'p',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `response_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holidayrequest`
--

INSERT INTO `holidayrequest` (`holidayChangeId`, `from_emp`, `to_emp`, `day`, `from_emp_shift`, `to_emp_shift`, `week_id`, `status`, `create_date`, `response_date`) VALUES
(46, 2, 1, 0, '4', '5', 1, 'A', '2025-04-14 17:22:37', NULL),
(47, 1, 2, 0, '4', '5', 1, 'A', '2025-04-14 17:23:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleId` int(11) NOT NULL,
  `weekID` int(11) DEFAULT NULL,
  `employeeId` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `shift` char(1) DEFAULT NULL,
  `holiday` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleId`, `weekID`, `employeeId`, `day`, `shift`, `holiday`) VALUES
(307, 1, 1, 1, 'A', 0),
(308, 1, 1, 2, 'C', 0),
(309, 1, 1, 3, 'A', 0),
(310, 1, 1, 4, 'C', 0),
(311, 1, 1, 5, 'A', 1),
(312, 1, 1, 6, 'A', 0),
(313, 1, 1, 7, 'A', 0),
(314, 1, 2, 1, 'C', 0),
(315, 1, 2, 2, 'A', 0),
(316, 1, 2, 3, 'C', 0),
(317, 1, 2, 4, 'C', 1),
(318, 1, 2, 5, 'C', 0),
(319, 1, 2, 6, 'C', 0),
(320, 1, 2, 7, 'C', 0),
(321, 1, 3, 1, 'C', 0),
(322, 1, 3, 2, 'C', 0),
(323, 1, 3, 3, 'C', 0),
(324, 1, 3, 4, 'A', 0),
(325, 1, 3, 5, 'C', 1),
(326, 1, 3, 6, 'C', 0),
(327, 1, 3, 7, 'C', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shiftrequest`
--

CREATE TABLE `shiftrequest` (
  `shiftChangeId` int(11) NOT NULL,
  `from_emp` int(11) DEFAULT NULL,
  `to_emp` int(11) DEFAULT NULL,
  `week_id` int(11) DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `shift` char(1) DEFAULT NULL,
  `status` char(1) DEFAULT 'p',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shiftrequest`
--

INSERT INTO `shiftrequest` (`shiftChangeId`, `from_emp`, `to_emp`, `week_id`, `day`, `shift`, `status`, `create_date`) VALUES
(94, 2, 1, 1, 1, 'A', 'A', '2025-04-14 13:16:37'),
(95, 2, 1, 1, 2, 'A', 'A', '2025-04-14 13:55:43'),
(96, 1, 2, 1, 2, 'C', 'A', '2025-04-14 14:01:44'),
(97, 3, 1, 1, 4, 'A', 'A', '2025-04-14 14:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `weeks`
--

CREATE TABLE `weeks` (
  `week_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weeks`
--

INSERT INTO `weeks` (`week_id`, `start_date`, `end_date`) VALUES
(1, '2025-04-13', '2025-04-19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `holidayrequest`
--
ALTER TABLE `holidayrequest`
  ADD PRIMARY KEY (`holidayChangeId`),
  ADD KEY `from_emp` (`from_emp`),
  ADD KEY `to_emp` (`to_emp`),
  ADD KEY `week_id` (`week_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleId`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `shiftrequest`
--
ALTER TABLE `shiftrequest`
  ADD PRIMARY KEY (`shiftChangeId`),
  ADD KEY `from_emp` (`from_emp`),
  ADD KEY `to_emp` (`to_emp`),
  ADD KEY `week_id` (`week_id`);

--
-- Indexes for table `weeks`
--
ALTER TABLE `weeks`
  ADD PRIMARY KEY (`week_id`),
  ADD UNIQUE KEY `start_date` (`start_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `holidayrequest`
--
ALTER TABLE `holidayrequest`
  MODIFY `holidayChangeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- AUTO_INCREMENT for table `shiftrequest`
--
ALTER TABLE `shiftrequest`
  MODIFY `shiftChangeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `weeks`
--
ALTER TABLE `weeks`
  MODIFY `week_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `holidayrequest`
--
ALTER TABLE `holidayrequest`
  ADD CONSTRAINT `holidayrequest_ibfk_1` FOREIGN KEY (`from_emp`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `holidayrequest_ibfk_2` FOREIGN KEY (`to_emp`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `holidayrequest_ibfk_3` FOREIGN KEY (`week_id`) REFERENCES `weeks` (`week_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employees` (`id`);

--
-- Constraints for table `shiftrequest`
--
ALTER TABLE `shiftrequest`
  ADD CONSTRAINT `shiftrequest_ibfk_1` FOREIGN KEY (`from_emp`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `shiftrequest_ibfk_2` FOREIGN KEY (`to_emp`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `shiftrequest_ibfk_3` FOREIGN KEY (`week_id`) REFERENCES `weeks` (`week_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

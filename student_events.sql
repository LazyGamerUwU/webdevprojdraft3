-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 04:00 AM
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
-- Database: `student_events`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `student_number` varchar(20) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `attendance_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `event_id`, `student_number`, `student_name`, `course`, `time_in`, `time_out`, `attendance_date`) VALUES
(6, 6, '202301754', 'Eros Denz Etac', '', '11:30:00', '13:00:00', '2024-11-30 15:04:29'),
(7, 6, '202300727', 'Ethan Wayne Cassion', '', '23:30:00', '00:30:00', '2024-11-30 15:04:54'),
(10, 6, '12345', 'Jake', '', '16:19:00', '15:00:00', '2024-11-30 15:24:06'),
(12, 6, '12345', 'Jake', '', '10:00:00', '11:00:00', '2024-11-30 15:26:03'),
(13, 6, '12345', 'Jake', '', '14:00:00', '13:00:00', '2024-11-30 16:32:44'),
(14, 6, '12345', 'Jake', '', '14:00:00', '15:00:00', '2024-11-30 16:35:49'),
(15, 6, '12345', 'Jake', '', '14:00:00', '00:00:00', '2024-11-30 16:36:01'),
(16, 6, '12345', 'Jake', '', '13:00:00', '14:00:00', '2024-11-30 16:36:56'),
(17, 6, '12345', 'Jake', '', '13:00:00', '14:00:00', '2024-11-30 17:04:02'),
(18, 6, '12345', 'Jake', '', '14:00:00', '13:00:00', '2024-11-30 17:14:17'),
(19, 6, '12345', 'Jake', '', '16:00:00', '17:00:00', '2024-11-30 17:15:51'),
(20, 6, '202300727', 'Cassion, Ethan Wayne Nodado', '', '15:00:00', '16:00:00', '2024-11-30 20:00:01'),
(21, 6, '202302172', 'Seupon, Paul Patigayon', '', '14:00:00', '15:00:00', '2024-11-30 20:09:19'),
(22, 9, '202300727', 'Cassion, Ethan Wayne Nodado', '', '14:00:00', '15:00:00', '2024-11-30 20:15:22'),
(23, 10, '202300727', 'Cassion, Ethan Wayne Nodado', '', '23:00:00', '23:30:00', '2024-12-01 02:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `organizers` varchar(255) DEFAULT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `event_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `organizers`, `starttime`, `endtime`, `venue`, `event_date`) VALUES
(6, 'Event1', 'Lorem Ipsum', 'CCS-CSC', '18:04:00', '19:04:00', 'CCS Building', '2024-11-26'),
(9, 'CCS Loyalty Day', 'Lorem ipsum', 'CSC', '08:00:00', '12:00:00', 'CCS Building', '2024-12-20'),
(10, 'Birthday ni Ethan', 'Waka', 'Ate Cess', '08:00:00', '22:00:00', 'Covered Court', '2025-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_number` varchar(20) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year_level` int(11) NOT NULL,
  `section` text NOT NULL,
  `birthdate` date NOT NULL,
  `sex` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `wmsu_email` varchar(255) NOT NULL,
  `personal_email` varchar(255) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_number`, `last_name`, `first_name`, `middle_name`, `course`, `year_level`, `section`, `birthdate`, `sex`, `address`, `wmsu_email`, `personal_email`, `status`) VALUES
(2, '202301754', 'Etac', 'Eros Denz', 'Labrador', 'Computer Science', 2, 'A', '2005-06-18', 'Male', 'random address', 'a@email.com', 'a@email.com', 'Regular'),
(3, '202300727', 'Cassion', 'Ethan Wayne', 'Nodado', 'Computer Science', 2, 'A', '2005-12-04', 'Male', 'a', 'a@email.com', 'a@email.com', 'Regular'),
(4, '202302172', 'Seupon', 'Paul', 'Patigayon', 'Computer Science', 2, 'A', '2005-04-08', 'Male', 'random address', 'a@email.com', 'a@email.com', 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','officer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$JQq8S0KIrdPAW9SxCK6S7uzYACIVk3fbswfJbeSjYWiQvUO63JXvS', 'admin'),
(2, 'paul', '$2y$10$GyAW7h0f/Vm1Xt0U3Uij9.rG6WjHntNLtHPTUWLY812o2AVBUZsie', 'admin'),
(3, 'officer', '$2y$10$ytI5mdDNBPxNWyS2l9NvbuZyFO7wvzILZYaU4IpTkAoLGM5kexgMa', 'officer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_ibfk_1` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

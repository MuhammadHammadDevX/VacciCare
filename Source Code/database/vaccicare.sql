-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Sep 07, 2026 at 08:44 AM
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
-- Database: `vaccicare`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL,
  `child_id` int(11) UNSIGNED NOT NULL,
  `hospital_id` int(11) UNSIGNED NOT NULL,
  `vaccine_id` int(11) UNSIGNED NOT NULL,
  `vaccinator_id` int(11) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `status` enum('Pending','Confirmed','Completed','Cancelled') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `parent_id`, `child_id`, `hospital_id`, `vaccine_id`, `vaccinator_id`, `booking_date`, `booking_time`, `status`) VALUES
(1, 8, 6, 5, 5, 3, '2026-08-31', '15:00:00', 'Completed'),
(2, 8, 7, 5, 6, 3, '2026-11-23', '14:00:00', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `child_id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL,
  `child_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `contact` varchar(30) DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `vaccination_status` enum('Up to Date','Pending','Partially Vaccinated') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`child_id`, `parent_id`, `child_name`, `date_of_birth`, `gender`, `blood_group`, `contact`, `additional_notes`, `vaccination_status`, `created_at`) VALUES
(6, 8, 'Ahmed', '2023-10-05', 'Male', 'B+', '02876789678', 'None', 'Up to Date', '2026-08-29 15:14:27'),
(7, 8, 'mahnoor', '2019-02-02', 'Female', 'A+', '02876789678', 'None', 'Up to Date', '2026-08-29 15:15:35'),
(8, 8, 'Anaya', '2025-01-27', 'Female', 'A-', '02876789678', 'None', 'Pending', '2026-08-29 15:16:33'),
(9, 8, 'ayan', '2022-10-28', 'Male', 'B+', '02876789678', 'None', 'Pending', '2026-08-30 18:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `hospital_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `hospital_name` varchar(150) NOT NULL,
  `hospital_type` varchar(100) NOT NULL,
  `license_no` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `working_hours` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`hospital_id`, `user_id`, `hospital_name`, `hospital_type`, `license_no`, `email`, `phone`, `city`, `address`, `contact_person`, `working_hours`, `status`, `created_at`, `updated_at`) VALUES
(5, 13, 'Agha Khan Hospital', 'Private', 'RG-10002', 'agha.khan@vaccicare.com', '03001234567', 'Karachi', 'Karachi, Gulshan', 'Dr.Ahsan', '24 Hours', 'Active', '2026-08-29 14:54:34', '2026-08-30 18:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `hospital_users`
--

CREATE TABLE `hospital_users` (
  `id` int(11) NOT NULL,
  `hospital_name` varchar(150) NOT NULL,
  `hospital_type` varchar(50) NOT NULL,
  `registration_number` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'hospital',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_users`
--

INSERT INTO `hospital_users` (`id`, `hospital_name`, `hospital_type`, `registration_number`, `email`, `phone`, `address`, `city`, `province`, `password`, `role`, `created_at`) VALUES
(5, 'Agha Khan Hospital', 'Private', 'RG-10001', 'agha.khan@vaccicare.com', '03001234567', 'Karachi, Gulshan', 'Karachi', 'Sindh', '$2y$10$n3H6.hu.7L8.mNCTNOC.nuRoLeZj4DOPpvhTdYfwH4aDMk7.p2KQm', 'hospital', '2026-08-27 10:14:05');

-- --------------------------------------------------------

--
-- Table structure for table `hospital_vaccines`
--

CREATE TABLE `hospital_vaccines` (
  `id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `vaccine_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `availability` enum('Available','Unavailable') NOT NULL DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_vaccines`
--

INSERT INTO `hospital_vaccines` (`id`, `hospital_id`, `vaccine_name`, `description`, `availability`, `created_at`, `updated_at`) VALUES
(5, 5, 'BCG', 'BCG vaccine', 'Available', '2026-08-29 15:09:20', '2026-08-29 15:09:20'),
(6, 5, 'polio', 'Polio vaccine', 'Available', '2026-08-29 15:09:51', '2026-08-29 15:09:51'),
(7, 5, 'MMR', 'MMR vaccine', 'Available', '2026-08-29 15:10:13', '2026-08-29 15:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) UNSIGNED NOT NULL,
  `recipient_type` enum('admin','hospital','parent','all') NOT NULL DEFAULT 'all',
  `recipient_id` int(11) UNSIGNED DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT 'info',
  `link` varchar(255) DEFAULT '',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `recipient_type`, `recipient_id`, `title`, `message`, `type`, `link`, `is_read`, `created_at`) VALUES
(1, 'admin', 0, 'Welcome to VacciCare Admin Panel', 'Notification system is active. You will receive real-time updates for new bookings, child registrations, and hospital updates.', 'info', 'admin-dashboard.php', 1, '2026-09-06 11:44:11'),
(2, 'admin', 0, 'System Status: All Services Operational', 'Database connectivity and notification dispatcher are functioning normally.', 'success', 'admin-dashboard.php', 1, '2026-09-06 11:44:11'),
(3, 'hospital', 0, 'Welcome to Hospital Portal', 'You will receive notifications here when parents book appointments or update vaccination status.', 'info', 'hospital-appointments.php', 1, '2026-09-06 11:44:11'),
(4, 'parent', 0, 'Welcome to VacciCare Parent Portal', 'Keep track of your children vaccination schedules, bookings, and hospital approvals right here.', 'info', 'vaccination-schedule.php', 0, '2026-09-06 11:44:11');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `parent_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `parent_name` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`parent_id`, `user_id`, `parent_name`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(8, 14, 'faiza', '+923001234567', '', '2026-08-28 17:36:14', '2026-08-28 17:36:14');

-- --------------------------------------------------------

--
-- Table structure for table `parent_requests`
--

CREATE TABLE `parent_requests` (
  `request_id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL,
  `child_id` int(11) UNSIGNED NOT NULL,
  `hospital_id` int(11) UNSIGNED NOT NULL,
  `hospital_vaccine_id` int(11) DEFAULT NULL,
  `request_type` varchar(100) NOT NULL,
  `request_date` date NOT NULL,
  `preferred_time` time DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `reviewed_by` int(11) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent_requests`
--

INSERT INTO `parent_requests` (`request_id`, `parent_id`, `child_id`, `hospital_id`, `hospital_vaccine_id`, `request_type`, `request_date`, `preferred_time`, `message`, `status`, `reviewed_by`, `reviewed_at`) VALUES
(8, 8, 6, 5, 6, 'Vaccination', '2026-08-31', '15:00:00', 'Vaccination appointment for child.', 'Approved', 13, '2026-08-29 15:30:11'),
(9, 8, 7, 5, 7, 'Vaccination', '2026-11-23', '14:00:00', 'None', 'Approved', 13, '2026-08-31 06:52:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','hospital','parent','vaccinator') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(13, 'Muntaha', 'muntaha123@gmail.com', '$2y$10$HsSXqvJCYZoIqMDwx2vyx.jEVwt5LDo7qe3C0/.LXe0uR7k2XA4cK', 'admin', 'active', '2026-08-27 10:31:23', '2026-08-27 10:31:23'),
(14, 'faiza', 'faiza@gmail.com', '$2y$10$czQ7/aebuieAIncX4VMdAem7XvkeAMZBXywirKRbxwnEkQhLqkPR2', 'parent', 'active', '2026-08-28 17:36:14', '2026-08-28 17:36:14'),
(15, 'Hospital Vaccinator', 'vaccinator@vaccicare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC5Z3W5jW5mQ7w3K0m7W', 'vaccinator', 'active', '2026-08-30 08:29:13', '2026-08-30 08:29:13'),
(16, 'Agha Khan Vaccinator', 'vaccinator@agha-khan.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC8V9aV0N5vYvZQv6n6', 'vaccinator', 'active', '2026-08-30 08:51:54', '2026-08-30 08:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `vaccinations`
--

CREATE TABLE `vaccinations` (
  `vaccination_id` int(11) UNSIGNED NOT NULL,
  `child_id` int(11) UNSIGNED NOT NULL,
  `vaccine_id` int(11) UNSIGNED NOT NULL,
  `hospital_id` int(11) UNSIGNED NOT NULL,
  `vaccinator_id` int(11) UNSIGNED NOT NULL,
  `vaccination_date` date NOT NULL,
  `vaccination_time` time NOT NULL,
  `status` enum('Completed','Pending','Cancelled') NOT NULL DEFAULT 'Pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccinations`
--

INSERT INTO `vaccinations` (`vaccination_id`, `child_id`, `vaccine_id`, `hospital_id`, `vaccinator_id`, `vaccination_date`, `vaccination_time`, `status`, `notes`, `created_at`) VALUES
(1, 6, 5, 5, 3, '2026-08-31', '15:00:00', 'Completed', 'vaccinated', '2026-08-30 09:08:29'),
(2, 7, 6, 5, 3, '2026-11-23', '14:00:00', 'Completed', 'None', '2026-08-31 06:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `vaccinators`
--

CREATE TABLE `vaccinators` (
  `vaccinator_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `hospital_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `qualification` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccinators`
--

INSERT INTO `vaccinators` (`vaccinator_id`, `user_id`, `hospital_id`, `name`, `qualification`, `phone`, `status`, `created_at`) VALUES
(3, 15, 5, 'Agha Khan Vaccinator', 'Certified Vaccinator', '03001234567', 'Active', '2026-08-30 08:54:15');

-- --------------------------------------------------------

--
-- Table structure for table `vaccines`
--

CREATE TABLE `vaccines` (
  `vaccine_id` int(11) UNSIGNED NOT NULL,
  `vaccine_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `manufacturer` varchar(150) DEFAULT NULL,
  `recommended_age` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccines`
--

INSERT INTO `vaccines` (`vaccine_id`, `vaccine_name`, `description`, `manufacturer`, `recommended_age`, `created_at`) VALUES
(4, 'BCG', 'BCG vaccine', NULL, NULL, '2026-08-30 07:45:25'),
(5, 'polio', 'Polio vaccine', NULL, NULL, '2026-08-30 07:45:25'),
(6, 'MMR', 'MMR vaccine', NULL, NULL, '2026-08-30 07:45:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `fk_bookings_parent` (`parent_id`),
  ADD KEY `fk_bookings_child` (`child_id`),
  ADD KEY `fk_bookings_hospital` (`hospital_id`),
  ADD KEY `fk_bookings_vaccine` (`vaccine_id`),
  ADD KEY `fk_bookings_vaccinator` (`vaccinator_id`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`child_id`),
  ADD KEY `fk_children_parent` (`parent_id`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`hospital_id`),
  ADD UNIQUE KEY `unique_license_no` (`license_no`),
  ADD KEY `idx_hospitals_user_id` (`user_id`);

--
-- Indexes for table `hospital_users`
--
ALTER TABLE `hospital_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `hospital_vaccines`
--
ALTER TABLE `hospital_vaccines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `idx_recip` (`recipient_type`,`recipient_id`,`is_read`),
  ADD KEY `idx_time` (`created_at`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`parent_id`),
  ADD UNIQUE KEY `unique_parent_user` (`user_id`);

--
-- Indexes for table `parent_requests`
--
ALTER TABLE `parent_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `fk_parent_requests_parent` (`parent_id`),
  ADD KEY `fk_parent_requests_child` (`child_id`),
  ADD KEY `fk_parent_requests_reviewer` (`reviewed_by`),
  ADD KEY `fk_parent_requests_hospital` (`hospital_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `vaccinations`
--
ALTER TABLE `vaccinations`
  ADD PRIMARY KEY (`vaccination_id`),
  ADD KEY `fk_vaccinations_child` (`child_id`),
  ADD KEY `fk_vaccinations_vaccine` (`vaccine_id`),
  ADD KEY `fk_vaccinations_hospital` (`hospital_id`),
  ADD KEY `fk_vaccinations_vaccinator` (`vaccinator_id`);

--
-- Indexes for table `vaccinators`
--
ALTER TABLE `vaccinators`
  ADD PRIMARY KEY (`vaccinator_id`),
  ADD UNIQUE KEY `unique_vaccinator_user` (`user_id`),
  ADD KEY `fk_vaccinators_hospital` (`hospital_id`);

--
-- Indexes for table `vaccines`
--
ALTER TABLE `vaccines`
  ADD PRIMARY KEY (`vaccine_id`),
  ADD UNIQUE KEY `unique_vaccine_name` (`vaccine_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `child_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `hospital_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hospital_users`
--
ALTER TABLE `hospital_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hospital_vaccines`
--
ALTER TABLE `hospital_vaccines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `parent_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `parent_requests`
--
ALTER TABLE `parent_requests`
  MODIFY `request_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vaccinations`
--
ALTER TABLE `vaccinations`
  MODIFY `vaccination_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vaccinators`
--
ALTER TABLE `vaccinators`
  MODIFY `vaccinator_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vaccines`
--
ALTER TABLE `vaccines`
  MODIFY `vaccine_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_bookings_child` FOREIGN KEY (`child_id`) REFERENCES `children` (`child_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bookings_hospital` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bookings_parent` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`parent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bookings_vaccinator` FOREIGN KEY (`vaccinator_id`) REFERENCES `vaccinators` (`vaccinator_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bookings_vaccine` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccines` (`vaccine_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `fk_children_parent` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`parent_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD CONSTRAINT `fk_hospitals_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `fk_parents_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parent_requests`
--
ALTER TABLE `parent_requests`
  ADD CONSTRAINT `fk_parent_requests_child` FOREIGN KEY (`child_id`) REFERENCES `children` (`child_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_parent_requests_hospital` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_parent_requests_parent` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`parent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_parent_requests_reviewer` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `vaccinations`
--
ALTER TABLE `vaccinations`
  ADD CONSTRAINT `fk_vaccinations_child` FOREIGN KEY (`child_id`) REFERENCES `children` (`child_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vaccinations_hospital` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vaccinations_vaccinator` FOREIGN KEY (`vaccinator_id`) REFERENCES `vaccinators` (`vaccinator_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vaccinations_vaccine` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccines` (`vaccine_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vaccinators`
--
ALTER TABLE `vaccinators`
  ADD CONSTRAINT `fk_vaccinators_hospital` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vaccinators_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

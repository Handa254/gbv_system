-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2025 at 03:36 PM
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
-- Database: `gbv_reporting_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `anonymous_reports`
--

CREATE TABLE `anonymous_reports` (
  `report_id` int(11) NOT NULL,
  `incident_type` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `date_of_incident` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `converted_to_case` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `contact_info` varchar(255) DEFAULT NULL,
  `evidence_file` varchar(255) DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `survivor_details` text DEFAULT NULL,
  `perpetrator_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anonymous_reports`
--

INSERT INTO `anonymous_reports` (`report_id`, `incident_type`, `location`, `date_of_incident`, `description`, `converted_to_case`, `created_at`, `contact_info`, `evidence_file`, `submitted_at`, `survivor_details`, `perpetrator_details`) VALUES
(8, 'Physical Abuse', 'Siaya Town', '2025-07-10', 'The survivor has been repeatedly assaulted by her partner at home. On the evening of July 10th, 2025, she was slapped and kicked after a disagreement. She sustained visible bruises on her face and arms. This has been happening frequently, especially when the partner is intoxicated. The survivor fears for her life but is afraid to report because of potential retaliation. This report is being made anonymously to initiate help or intervention.', 1, '2025-07-23 10:20:47', '0100161330', '', '2025-07-23 12:20:47', 'Female, Age 26', 'Male, at 30s');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `case_id` int(11) NOT NULL,
  `incident_type` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `case_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Pending','Ongoing','Resolved') DEFAULT 'Pending',
  `survivor_id` int(11) DEFAULT NULL,
  `perpetrator_id` int(11) DEFAULT NULL,
  `case_type_id` int(11) DEFAULT NULL,
  `reported_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`case_id`, `incident_type`, `location`, `case_date`, `description`, `status`, `survivor_id`, `perpetrator_id`, `case_type_id`, `reported_by`, `created_at`) VALUES
(1, NULL, 'Migori Town', '2025-07-16', 'On July 16, 2025, at around 8:30 PM, my partner returned home drunk and began shouting at me. When I tried to calm him down, he slapped me across the face and threw a glass bottle at me, which cut my arm. My 8-year-old daughter witnessed the incident. This is not the first time he has physically assaulted me. I am scared for my safety and that of my child.', 'Pending', NULL, NULL, 2, 1, '2025-07-22 12:17:29'),
(2, NULL, 'Siaya Town', '2025-07-10', 'The survivor has been repeatedly assaulted by her partner at home. On the evening of July 10th, 2025, she was slapped and kicked after a disagreement. She sustained visible bruises on her face and arms. This has been happening frequently, especially when the partner is intoxicated. The survivor fears for her life but is afraid to report because of potential retaliation. This report is being made anonymously to initiate help or intervention.', 'Pending', NULL, NULL, 2, 1, '2025-07-23 10:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `case_type`
--

CREATE TABLE `case_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_types`
--

CREATE TABLE `case_types` (
  `case_type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_types`
--

INSERT INTO `case_types` (`case_type_id`, `type_name`, `description`) VALUES
(1, 'Sexual Violence', 'Includes rape, sexual assault, and unwanted sexual advances.'),
(2, 'Physical Abuse', 'Includes hitting, slapping, or any form of physical harm.'),
(3, 'Emotional Abuse', 'Verbal abuse, threats, and psychological manipulation.'),
(4, 'Economic Abuse', 'Control over access to financial resources.'),
(5, 'Child Marriage', 'Marriage involving minors below legal age.'),
(6, 'Female Genital Mutilation', 'Cutting or removal of female genitalia.'),
(7, 'Sexual Harassment', 'Unwelcome sexual advances, requests for sexual favors, and other verbal or physical conduct.');

-- --------------------------------------------------------

--
-- Table structure for table `faq_questions`
--

CREATE TABLE `faq_questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq_questions`
--

INSERT INTO `faq_questions` (`id`, `question`, `created_at`) VALUES
(1, 'How can I overcome emotional abuse?', '2025-07-22 11:32:38');

-- --------------------------------------------------------

--
-- Table structure for table `followups`
--

CREATE TABLE `followups` (
  `followup_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `followup_date` date NOT NULL,
  `status_update` text DEFAULT NULL,
  `followup_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending',
  `feedback` varchar(50) DEFAULT 'Pending',
  `next_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `followups`
--

INSERT INTO `followups` (`followup_id`, `case_id`, `followup_date`, `status_update`, `followup_by`, `created_at`, `status`, `feedback`, `next_date`) VALUES
(1, 2, '2025-07-22', NULL, NULL, '2025-07-23 10:22:41', 'Pending Court Action', 'The case has been handled and awaiting Court Actio', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `gbv_events`
--

CREATE TABLE `gbv_events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `event_date` date NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `title`, `type`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(4, 'New Anonymous Report', 'alert', 1, 'A new anonymous report has been submitted. Tracking Code: ANON-000007', 0, '2025-07-22 10:31:48'),
(5, 'New Anonymous Report', 'alert', 1, 'A new anonymous report has been submitted. Tracking Code: ANON-000008', 0, '2025-07-23 13:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `perpetrators`
--

CREATE TABLE `perpetrators` (
  `perpetrator_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `relation_to_survivor` varchar(50) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `relationship_to_survivor` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perpetrators`
--

INSERT INTO `perpetrators` (`perpetrator_id`, `full_name`, `relation_to_survivor`, `phone`, `age`, `gender`, `relationship_to_survivor`, `contact`, `location`, `created_by`, `created_at`) VALUES
(1, 'John Walungo', NULL, NULL, 34, 'Male', 'Husband', NULL, NULL, NULL, '2025-07-22 15:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `report_title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `report_type` enum('anonymous','direct') DEFAULT 'direct'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survivors`
--

CREATE TABLE `survivors` (
  `survivor_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `date_reported` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `survivors`
--

INSERT INTO `survivors` (`survivor_id`, `full_name`, `date_of_birth`, `age`, `gender`, `contact_info`, `contact`, `location`, `date_reported`, `created_by`, `created_at`, `phone_number`, `email`, `address`, `phone`) VALUES
(1, 'Jane Njeri', '1999-05-23', NULL, 'Female', '0100161330', NULL, 'Siaya Town', NULL, NULL, '2025-07-23 13:34:41', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hashed` varchar(255) NOT NULL,
  `role` enum('admin','case_worker','report_viewer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password_hashed`, `role`, `created_at`) VALUES
(1, 'Maurice Handa', 'admin@gbv.com', '$2y$10$bnlYO6s5v895J/ye4rIhWuzOQ0vYIg0SihvmJ2rrD.8hNDJvEnzH.', 'admin', '2025-07-21 12:00:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anonymous_reports`
--
ALTER TABLE `anonymous_reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`case_id`),
  ADD KEY `survivor_id` (`survivor_id`),
  ADD KEY `perpetrator_id` (`perpetrator_id`),
  ADD KEY `case_type_id` (`case_type_id`),
  ADD KEY `reported_by` (`reported_by`);

--
-- Indexes for table `case_type`
--
ALTER TABLE `case_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_types`
--
ALTER TABLE `case_types`
  ADD PRIMARY KEY (`case_type_id`);

--
-- Indexes for table `faq_questions`
--
ALTER TABLE `faq_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followups`
--
ALTER TABLE `followups`
  ADD PRIMARY KEY (`followup_id`),
  ADD KEY `case_id` (`case_id`),
  ADD KEY `followup_by` (`followup_by`);

--
-- Indexes for table `gbv_events`
--
ALTER TABLE `gbv_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `perpetrators`
--
ALTER TABLE `perpetrators`
  ADD PRIMARY KEY (`perpetrator_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `survivors`
--
ALTER TABLE `survivors`
  ADD PRIMARY KEY (`survivor_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anonymous_reports`
--
ALTER TABLE `anonymous_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `case_type`
--
ALTER TABLE `case_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_types`
--
ALTER TABLE `case_types`
  MODIFY `case_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `faq_questions`
--
ALTER TABLE `faq_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `followups`
--
ALTER TABLE `followups`
  MODIFY `followup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gbv_events`
--
ALTER TABLE `gbv_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `perpetrators`
--
ALTER TABLE `perpetrators`
  MODIFY `perpetrator_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survivors`
--
ALTER TABLE `survivors`
  MODIFY `survivor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `cases_ibfk_1` FOREIGN KEY (`survivor_id`) REFERENCES `survivors` (`survivor_id`),
  ADD CONSTRAINT `cases_ibfk_2` FOREIGN KEY (`perpetrator_id`) REFERENCES `perpetrators` (`perpetrator_id`),
  ADD CONSTRAINT `cases_ibfk_3` FOREIGN KEY (`case_type_id`) REFERENCES `case_types` (`case_type_id`),
  ADD CONSTRAINT `cases_ibfk_4` FOREIGN KEY (`reported_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `followups`
--
ALTER TABLE `followups`
  ADD CONSTRAINT `followups_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`),
  ADD CONSTRAINT `followups_ibfk_2` FOREIGN KEY (`followup_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `perpetrators`
--
ALTER TABLE `perpetrators`
  ADD CONSTRAINT `perpetrators_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `survivors`
--
ALTER TABLE `survivors`
  ADD CONSTRAINT `survivors_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

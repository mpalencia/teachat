-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2016 at 09:07 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teachatv3prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `tea_advisory`
--

CREATE TABLE `tea_advisory` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_announcement`
--

CREATE TABLE `tea_announcement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` int(10) UNSIGNED NOT NULL,
  `announce_to` int(11) NOT NULL,
  `announcement` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_appointment`
--

CREATE TABLE `tea_appointment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL,
  `file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appt_date` date NOT NULL,
  `appt_stime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `appt_etime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tea_appointment`
--

INSERT INTO `tea_appointment` (`id`, `teacher_id`, `parent_id`, `file_id`, `appt_date`, `appt_stime`, `appt_etime`, `title`, `description`, `action`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 3, NULL, '2016-05-24', '06:00 PM', '07:15 PM', 'edqeqweqwe', 'qweqweqweqweqwe', NULL, 1, '2016-05-24 02:02:05', '2016-05-24 02:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `tea_audit_trail`
--

CREATE TABLE `tea_audit_trail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `actions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_children`
--

CREATE TABLE `tea_children` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` int(10) UNSIGNED NOT NULL,
  `grade_id` int(10) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `approved` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_curriculum`
--

CREATE TABLE `tea_curriculum` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` int(10) UNSIGNED NOT NULL,
  `grade_id` int(10) UNSIGNED NOT NULL,
  `subject_category_id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_encrypted`
--

CREATE TABLE `tea_encrypted` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_files`
--

CREATE TABLE `tea_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `orig_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_grades`
--

CREATE TABLE `tea_grades` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_history`
--

CREATE TABLE `tea_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `opponent_id` bigint(20) UNSIGNED NOT NULL,
  `duration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_migrations`
--

CREATE TABLE `tea_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tea_migrations`
--

INSERT INTO `tea_migrations` (`migration`, `batch`) VALUES
('2014_10_12_100000_create_password_resets_table', 1),
('2016_05_02_080849_create_tea_state_us_table', 1),
('2016_05_03_102738_create_tea_user_role_table', 1),
('2016_05_03_103229_create_tea_school_table', 1),
('2016_05_04_075904_create_tea_users_table', 1),
('2016_05_04_080042_create_tea_subjects_table', 1),
('2016_05_04_081605_create_tea_teacher_profile_table', 1),
('2016_05_04_082132_create_tea_parent_profile_table', 1),
('2016_05_04_082954_create_tea_advisory_table', 1),
('2016_05_04_090306_create_tea_grades_table', 1),
('2016_05_04_090402_create_tea_children_table', 1),
('2016_05_04_090938_create_tea_students_table', 1),
('2016_05_04_091404_create_tea_schedule_table', 1),
('2016_05_04_091729_create_tea_files_table', 1),
('2016_05_04_092249_create_tea_announcement_table', 1),
('2016_05_04_095453_create_tea_appointment_table', 1),
('2016_05_04_095903_create_tea_audit_trail_table', 1),
('2016_05_04_100343_create_tea_history_table', 1),
('2016_05_04_100710_create_tea_encrypted_table', 1),
('2016_05_05_082734_create_subject_category_table', 1),
('2016_05_12_095522_create_curriculum_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tea_parent_profile`
--

CREATE TABLE `tea_parent_profile` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `contact_cell` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_home` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_work` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_password_resets`
--

CREATE TABLE `tea_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_schedule`
--

CREATE TABLE `tea_schedule` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_user_id` bigint(20) UNSIGNED NOT NULL,
  `from_user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `approve` int(11) NOT NULL,
  `reserve` int(11) NOT NULL,
  `seen` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_school`
--

CREATE TABLE `tea_school` (
  `id` int(10) UNSIGNED NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `school_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `school_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `upload` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tea_school`
--

INSERT INTO `tea_school` (`id`, `state_id`, `school_name`, `school_logo`, `upload`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Ateneo De Manila', 'ateneo.jpg', '0', NULL, NULL, NULL),
(2, 2, 'DLSU Zobel', 'dlsu-zobel.jpg', '0', NULL, NULL, NULL),
(3, 3, 'IS Manila', 'is-manila.jpg', '1', NULL, NULL, NULL),
(4, 4, 'XavierS', 'Avatar-512.png', '1', NULL, NULL, NULL),
(5, 5, 'Admin School', 'Avatar-512.png', '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tea_state_us`
--

CREATE TABLE `tea_state_us` (
  `id` int(10) UNSIGNED NOT NULL,
  `state_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tea_state_us`
--

INSERT INTO `tea_state_us` (`id`, `state_name`, `state_code`, `country`) VALUES
(1, 'Alabama', 'AL', ''),
(2, 'Alaska', 'AK', ''),
(3, 'Arizona', 'AZ', ''),
(4, 'Arkansas', 'AR', ''),
(5, 'California', 'CA', ''),
(6, 'Colorado', 'CO', ''),
(7, 'Connecticut', 'CT', ''),
(8, 'Delaware', 'DE', ''),
(9, 'District of Columbia', 'DC', ''),
(10, 'Florida', 'FL', ''),
(11, 'Georgia', 'GA', ''),
(12, 'Hawaii', 'HI', ''),
(13, 'Idaho', 'ID', ''),
(14, 'Illinois', 'IL', ''),
(15, 'Indiana', 'IN', ''),
(16, 'Iowa', 'IA', ''),
(17, 'Kansas', 'KS', ''),
(18, 'Kentucky', 'KY', ''),
(19, 'Louisiana', 'LA', ''),
(20, 'Maine', 'ME', ''),
(21, 'Maryland', 'MD', ''),
(22, 'Massachusetts', 'MA', ''),
(23, 'Michigan', 'MI', ''),
(24, 'Minnesota', 'MN', ''),
(25, 'Mississippi', 'MS', ''),
(26, 'Missouri', 'MO', ''),
(27, 'Montana', 'MT', ''),
(28, 'Nebraska', 'NE', ''),
(29, 'Nevada', 'NV', ''),
(30, 'New Hampshire', 'NH', ''),
(31, 'New Jersey', 'NJ', ''),
(32, 'New Mexico', 'NM', ''),
(33, 'New York', 'NY', ''),
(34, 'North Carolina', 'NC', ''),
(35, 'North Dakota', 'ND', ''),
(36, 'Ohio', 'OH', ''),
(37, 'Oklahoma', 'OK', ''),
(38, 'Oregon', 'OR', ''),
(39, 'Pennsylvania', 'PA', ''),
(40, 'Rhode Island', 'RI', ''),
(41, 'South Carolina', 'SC', ''),
(42, 'South Dakota', 'SD', ''),
(43, 'Tennessee', 'TN', ''),
(44, 'Texas', 'TX', ''),
(45, 'Utah', 'UT', ''),
(46, 'Vermont', 'VT', ''),
(47, 'Virginia', 'VA', ''),
(48, 'Washington', 'WA', ''),
(49, 'West Virginia', 'WV', ''),
(50, 'Wisconsin', 'WI', ''),
(51, 'Wyoming', 'WY', '');

-- --------------------------------------------------------

--
-- Table structure for table `tea_students`
--

CREATE TABLE `tea_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `child_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `grade_id` int(10) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `section` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_subjects`
--

CREATE TABLE `tea_subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subject_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_subject_category`
--

CREATE TABLE `tea_subject_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_teacher_profile`
--

CREATE TABLE `tea_teacher_profile` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` int(10) UNSIGNED NOT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `experience` text COLLATE utf8_unicode_ci NOT NULL,
  `cv_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tea_users`
--

CREATE TABLE `tea_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `verification_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suspend` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `birthdate` date DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_cell` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_home` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_work` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_one` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_two` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approved` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tea_users`
--

INSERT INTO `tea_users` (`id`, `school_id`, `role_id`, `email`, `password`, `facebook_id`, `first_name`, `middle_name`, `last_name`, `profile_img`, `gender`, `active`, `verification_code`, `status`, `suspend`, `state_id`, `birthdate`, `zip_code`, `city`, `contact_cell`, `contact_home`, `contact_work`, `address_one`, `address_two`, `approved`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'admin@yopmail.com', '$2y$10$uVusMVHgwn.nxab13VDhL.5X6AMV7nCFEvIZSHp1jBFK.I4liR2DG', '', 'Gabriel', NULL, 'Raymundo', 'gab.jpg', 'Male', '1', '', '0', '0', 1, NULL, '3535', 'City 1', '0912412401', NULL, NULL, 'Somewhere down the road', NULL, 1, NULL, NULL, NULL, NULL),
(2, 2, 2, 'teacher@yopmail.com', '$2y$10$YMLnu.0kaBgGvMQWJN4meOT8zNh6RtYxIpwztIAHSHKPDMSY1cpo.', '', 'Kevin', NULL, 'Villanueva', 'kev.jpg', 'Female', '1', '', '0', '0', 2, NULL, '1123', 'City 2', '424242424', NULL, NULL, 'Somewhere up the road', NULL, 1, NULL, NULL, '2016-05-24 01:37:19', NULL),
(3, 2, 3, 'parent@yopmail.com', '$2y$10$L.AcyQrNRXxcocMGEk/9duJxVnfMdb2b4MNeahA0/GvwdkFaYCsYO', '', 'Cris', NULL, 'Toper', 'cris.jpg', 'Male', '1', '', '0', '0', 3, NULL, '1525', 'City 3', '535353321', NULL, NULL, 'Somewhere left the road', NULL, 1, 'YN8kHdvlS4R99lWu1e62dNFkoB4dbTbfTh558UmwUbAuzKQglt2UUFaggBgQ', NULL, '2016-05-23 22:39:11', NULL),
(4, 4, 4, 'superuser@yopmail.com', '$2y$10$LXLaTCPvp/yfGtaiSnvcxuJ/xDFfUecRGSOloMoeYZWKiELK72Gri', '', 'Louie', NULL, 'Boy', 'louie.jpg', 'Female', '1', '', '0', '0', 4, NULL, '5326', 'City 4', '154125125', NULL, NULL, 'Somewhere right the road', NULL, 1, NULL, NULL, NULL, NULL),
(5, 5, 5, 'schooladmin@yopmail.com', '$2y$10$q/O5J03Ebb/qo9eHIIFP4Oag9nq39Bu7SQoQRDYDAmM4BN9Av.JyC', '', 'Christian', NULL, 'Marky', 'louie.jpg', 'Female', '1', '', '0', '0', 4, NULL, '5326', 'City 4', '154125125', NULL, NULL, 'Somewhere right the road', NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tea_user_role`
--

CREATE TABLE `tea_user_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tea_user_role`
--

INSERT INTO `tea_user_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Teacher'),
(3, 'Parent'),
(4, 'Super User'),
(5, 'School Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tea_advisory`
--
ALTER TABLE `tea_advisory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advisory_subject_id_index` (`subject_id`),
  ADD KEY `advisory_teacher_id_index` (`teacher_id`);

--
-- Indexes for table `tea_announcement`
--
ALTER TABLE `tea_announcement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_user_id_index` (`user_id`),
  ADD KEY `announcement_school_id_index` (`school_id`);

--
-- Indexes for table `tea_appointment`
--
ALTER TABLE `tea_appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_teacher_id_index` (`teacher_id`),
  ADD KEY `appointment_parent_id_index` (`parent_id`),
  ADD KEY `appointment_file_id_index` (`file_id`);

--
-- Indexes for table `tea_audit_trail`
--
ALTER TABLE `tea_audit_trail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_trail_user_id_index` (`user_id`);

--
-- Indexes for table `tea_children`
--
ALTER TABLE `tea_children`
  ADD PRIMARY KEY (`id`),
  ADD KEY `children_school_id_index` (`school_id`),
  ADD KEY `children_grade_id_index` (`grade_id`),
  ADD KEY `children_parent_id_index` (`parent_id`),
  ADD KEY `children_state_id_index` (`state_id`);

--
-- Indexes for table `tea_curriculum`
--
ALTER TABLE `tea_curriculum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curriculum_user_id_index` (`user_id`),
  ADD KEY `curriculum_school_id_index` (`school_id`),
  ADD KEY `curriculum_grade_id_index` (`grade_id`),
  ADD KEY `curriculum_subject_category_id_index` (`subject_category_id`);

--
-- Indexes for table `tea_encrypted`
--
ALTER TABLE `tea_encrypted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tea_files`
--
ALTER TABLE `tea_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_teacher_id_index` (`teacher_id`),
  ADD KEY `files_student_id_index` (`student_id`);

--
-- Indexes for table `tea_grades`
--
ALTER TABLE `tea_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_user_id_index` (`user_id`);

--
-- Indexes for table `tea_history`
--
ALTER TABLE `tea_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_user_id_index` (`user_id`),
  ADD KEY `history_opponent_id_index` (`opponent_id`);

--
-- Indexes for table `tea_parent_profile`
--
ALTER TABLE `tea_parent_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_profile_user_id_index` (`user_id`);

--
-- Indexes for table `tea_password_resets`
--
ALTER TABLE `tea_password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `tea_schedule`
--
ALTER TABLE `tea_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_to_user_id_index` (`to_user_id`),
  ADD KEY `schedule_from_user_id_index` (`from_user_id`);

--
-- Indexes for table `tea_school`
--
ALTER TABLE `tea_school`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_state_id_index` (`state_id`);

--
-- Indexes for table `tea_state_us`
--
ALTER TABLE `tea_state_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tea_students`
--
ALTER TABLE `tea_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_child_id_index` (`child_id`),
  ADD KEY `students_parent_id_index` (`parent_id`),
  ADD KEY `students_subject_id_index` (`subject_id`),
  ADD KEY `students_grade_id_index` (`grade_id`),
  ADD KEY `students_teacher_id_index` (`teacher_id`);

--
-- Indexes for table `tea_subjects`
--
ALTER TABLE `tea_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_user_id_index` (`user_id`);

--
-- Indexes for table `tea_subject_category`
--
ALTER TABLE `tea_subject_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_category_user_id_index` (`user_id`);

--
-- Indexes for table `tea_teacher_profile`
--
ALTER TABLE `tea_teacher_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_profile_user_id_index` (`user_id`),
  ADD KEY `teacher_profile_school_id_index` (`school_id`);

--
-- Indexes for table `tea_users`
--
ALTER TABLE `tea_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_school_id_index` (`school_id`),
  ADD KEY `users_role_id_index` (`role_id`),
  ADD KEY `users_state_id_index` (`state_id`);

--
-- Indexes for table `tea_user_role`
--
ALTER TABLE `tea_user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tea_advisory`
--
ALTER TABLE `tea_advisory`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_announcement`
--
ALTER TABLE `tea_announcement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_appointment`
--
ALTER TABLE `tea_appointment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tea_audit_trail`
--
ALTER TABLE `tea_audit_trail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_children`
--
ALTER TABLE `tea_children`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_curriculum`
--
ALTER TABLE `tea_curriculum`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_encrypted`
--
ALTER TABLE `tea_encrypted`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_files`
--
ALTER TABLE `tea_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_grades`
--
ALTER TABLE `tea_grades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_history`
--
ALTER TABLE `tea_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_parent_profile`
--
ALTER TABLE `tea_parent_profile`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_schedule`
--
ALTER TABLE `tea_schedule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_school`
--
ALTER TABLE `tea_school`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tea_state_us`
--
ALTER TABLE `tea_state_us`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `tea_students`
--
ALTER TABLE `tea_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_subjects`
--
ALTER TABLE `tea_subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_subject_category`
--
ALTER TABLE `tea_subject_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_teacher_profile`
--
ALTER TABLE `tea_teacher_profile`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tea_users`
--
ALTER TABLE `tea_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tea_user_role`
--
ALTER TABLE `tea_user_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tea_advisory`
--
ALTER TABLE `tea_advisory`
  ADD CONSTRAINT `advisory_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `tea_subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `advisory_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_announcement`
--
ALTER TABLE `tea_announcement`
  ADD CONSTRAINT `announcement_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `tea_school` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcement_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_appointment`
--
ALTER TABLE `tea_appointment`
  ADD CONSTRAINT `appointment_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `tea_files` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_audit_trail`
--
ALTER TABLE `tea_audit_trail`
  ADD CONSTRAINT `audit_trail_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_children`
--
ALTER TABLE `tea_children`
  ADD CONSTRAINT `children_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `tea_grades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `children_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `children_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `tea_school` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `children_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `tea_state_us` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_curriculum`
--
ALTER TABLE `tea_curriculum`
  ADD CONSTRAINT `curriculum_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `tea_grades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curriculum_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `tea_school` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curriculum_subject_category_id_foreign` FOREIGN KEY (`subject_category_id`) REFERENCES `tea_subject_category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curriculum_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_files`
--
ALTER TABLE `tea_files`
  ADD CONSTRAINT `files_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `tea_students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `files_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_grades`
--
ALTER TABLE `tea_grades`
  ADD CONSTRAINT `grades_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_history`
--
ALTER TABLE `tea_history`
  ADD CONSTRAINT `history_opponent_id_foreign` FOREIGN KEY (`opponent_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_parent_profile`
--
ALTER TABLE `tea_parent_profile`
  ADD CONSTRAINT `parent_profile_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_schedule`
--
ALTER TABLE `tea_schedule`
  ADD CONSTRAINT `schedule_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_school`
--
ALTER TABLE `tea_school`
  ADD CONSTRAINT `school_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `tea_state_us` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_students`
--
ALTER TABLE `tea_students`
  ADD CONSTRAINT `students_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `tea_children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `tea_grades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `tea_subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_subjects`
--
ALTER TABLE `tea_subjects`
  ADD CONSTRAINT `subjects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_subject_category`
--
ALTER TABLE `tea_subject_category`
  ADD CONSTRAINT `subject_category_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_teacher_profile`
--
ALTER TABLE `tea_teacher_profile`
  ADD CONSTRAINT `teacher_profile_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `tea_school` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_profile_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tea_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tea_users`
--
ALTER TABLE `tea_users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `tea_user_role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `tea_school` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `tea_state_us` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

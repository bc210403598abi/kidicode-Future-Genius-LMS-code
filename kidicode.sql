-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2025 at 12:21 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kidicode`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `fkteacherID` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `difficulty` enum('beginner','intermediate','advanced') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_weeks` int(11) NOT NULL,
  `description` text NOT NULL,
  `learning_objectives` text DEFAULT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `intro_video` varchar(255) DEFAULT NULL,
  `materials` text DEFAULT NULL,
  `scorm_enabled` tinyint(1) DEFAULT 0,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `fkteacherID`, `title`, `category`, `difficulty`, `price`, `duration_weeks`, `description`, `learning_objectives`, `thumbnail`, `intro_video`, `materials`, `scorm_enabled`, `status`, `created_at`) VALUES
(1, 6, 'Advanced PHP & MySQL', 'programming', 'intermediate', '80.00', 8, 'Deep dive into PHP backend development with MySQL database integration.', 'Master PHP CRUD,Work with MySQL', '1767423774_download.jpg', '1767423774_download.mp4', '17671197_report_1.pdf,,', 1, 'approved', '2025-12-30 18:35:33');

-- --------------------------------------------------------

--
-- Table structure for table `course_enrollments`
--

CREATE TABLE `course_enrollments` (
  `id` int(11) NOT NULL,
  `fkstudentID` int(11) NOT NULL,
  `fkcourseID` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `progress` decimal(5,2) DEFAULT 0.00,
  `enStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_enrollments`
--

INSERT INTO `course_enrollments` (`id`, `fkstudentID`, `fkcourseID`, `enrolled_at`, `progress`, `enStatus`) VALUES
(3, 5, 1, '2025-12-30 21:33:46', '50.00', 'inactive'),
(4, 5, 1, '2025-12-30 22:56:45', '0.00', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `fkcourseID` int(11) NOT NULL,
  `fkteacherID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `lesson_type` enum('video','reading','quiz','assignment') NOT NULL,
  `description` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `attachments` text DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `lessstatus` enum('draft','published') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `fkcourseID`, `fkteacherID`, `title`, `lesson_type`, `description`, `video`, `content`, `attachments`, `duration_minutes`, `lessstatus`, `created_at`) VALUES
(2, 1, 6, 'NILL', 'reading', 'NILL', '', 'OK', '176714774_ABC.txt', 9, 'published', '2025-12-30 19:59:34');

-- --------------------------------------------------------

--
-- Table structure for table `option_quiz`
--

CREATE TABLE `option_quiz` (
  `id` int(11) NOT NULL,
  `fkquestionID` int(11) NOT NULL,
  `option_answer` varchar(255) NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `option_quiz`
--

INSERT INTO `option_quiz` (`id`, `fkquestionID`, `option_answer`, `is_correct`) VALUES
(1, 1, 'apdate', 0),
(2, 1, 'update', 1),
(3, 1, 'apadate', 0),
(4, 1, 'None', 0),
(5, 2, 'Del', 0),
(6, 2, 'Dell', 0),
(7, 2, 'Delete', 1),
(8, 2, 'None', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('credit_card','paypal','bank_transfer') NOT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `course_id`, `amount`, `payment_method`, `status`, `transaction_id`, `payment_date`) VALUES
(1, 5, 1, '80.00', 'credit_card', 'completed', NULL, '2025-12-31 03:56:45');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `fkcourseID` int(11) NOT NULL,
  `fkteacherID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `time_limit` int(11) DEFAULT NULL,
  `total_points` int(11) DEFAULT NULL,
  `passing_score` int(11) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `fkcourseID`, `fkteacherID`, `title`, `time_limit`, `total_points`, `passing_score`, `instructions`, `created_at`) VALUES
(1, 1, 6, 'Update,Delete', 30, 30, 70, 'PLZ CORRECT', '2025-12-30 21:43:41');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `fkquizID` int(11) NOT NULL,
  `question` text NOT NULL,
  `points` int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `fkquizID`, `question`, `points`) VALUES
(1, 1, 'What is Command of Update?', 15),
(2, 1, 'What is Command of Delete in SQL', 15);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_result`
--

CREATE TABLE `quiz_result` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `total_score` int(11) DEFAULT NULL,
  `status` enum('pass','fail') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_result`
--

INSERT INTO `quiz_result` (`id`, `student_id`, `quiz_id`, `total_score`, `status`, `created_at`) VALUES
(2, 5, 1, 10, 'fail', '2025-12-31 03:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `submit_answer`
--

CREATE TABLE `submit_answer` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submit_answer`
--

INSERT INTO `submit_answer` (`id`, `student_id`, `quiz_id`, `question_id`, `option_id`, `is_correct`, `created_at`) VALUES
(3, 5, 1, 1, 2, 1, '2025-12-31 03:18:19'),
(4, 5, 1, 2, 6, 0, '2025-12-31 03:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('student','instructor','admin','parents') NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `terms_accepted` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive','blocked') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `dob`, `email`, `phone`, `password`, `user_type`, `profile`, `terms_accepted`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2025-12-30', 'admin@gmail.com', '03041659294', 'admin', 'admin', '1767423774_download.jpg', 0, 'active', '2025-12-30 17:23:46', '2025-12-30 17:24:08'),
(5, 'Sudent', '2025-12-30', 'student@gmail.com', '03041659295', 'student', 'student', '1767423774_download.jpg', 0, 'active', '2025-12-30 17:53:59', '2025-12-30 17:56:07'),
(6, 'Teacher', '2025-12-30', 'teacher@gmail.com', '03048987654', 'teacher', 'instructor', '1767423774_download.jpg', 0, 'active', '2025-12-30 17:55:29', '2025-12-30 17:56:14'),
(7, 'Parent', '2025-12-31', 'parent@gmail.com', '03476787654', 'parent', 'parents', '11767423774_download.jpg', 0, 'active', '2025-12-30 23:18:09', '2025-12-30 23:18:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `option_quiz`
--
ALTER TABLE `option_quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submit_answer`
--
ALTER TABLE `submit_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `option_quiz`
--
ALTER TABLE `option_quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz_result`
--
ALTER TABLE `quiz_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `submit_answer`
--
ALTER TABLE `submit_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

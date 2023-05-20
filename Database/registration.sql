-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2023 at 05:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `ID` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ID`, `username`, `fullName`, `phoneNumber`, `emailAddress`, `password`) VALUES
(1, 'bhamza', 'Baqer Hamza', '32321111', 'bhamza@mt.edu', '$2y$10$xkvn5DP47wv568iTqhj6IeQXkn3LN2NctI/3xjklfdBQaGobJR/RW');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `ID` int(11) NOT NULL,
  `courseCode` varchar(20) NOT NULL,
  `courseName` varchar(50) NOT NULL,
  `creditHours` int(11) NOT NULL,
  `preRequisites` varchar(100) DEFAULT NULL,
  `courseDepartment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`ID`, `courseCode`, `courseName`, `creditHours`, `preRequisites`, `courseDepartment`) VALUES
(2, 'ITCS333', 'Internet Software Development', 3, 'ITCS214,ITCS285', 1),
(3, 'ITCS489', 'Software Engineering 2', 3, 'ITCS285', 1),
(6, 'ITCS113', 'Computer Programming 1', 3, NULL, 1),
(7, 'ITCS114', 'Computer Programming 2', 3, 'ITCS113', 1),
(8, 'ITCS214', 'Data Structures', 3, 'ITCS114', 1),
(9, 'ITCS254', 'Discrete Structures 1', 3, 'ITCS113', 1),
(10, 'ITCS255', 'Discrete Structures 2', 3, 'ITCS254', 1),
(11, 'ITCS285', 'Databse Management Systems', 3, 'ITCS214', 1),
(12, 'ITCS316', 'Human-Computer Interaction', 3, 'ITCS214', 1),
(13, 'ITCS347', 'Analysis and Design of Algorithms', 3, 'ITCS214,ITCS255', 1),
(14, 'ITCS321', 'Computer Organization and Assembly Language', 3, 'ITCS114', 1),
(15, 'ITCS389', 'Software Engineering 1', 3, 'ITCS285', 1),
(16, 'ITCS396', 'Professional Issues and Ethics', 3, NULL, 1),
(17, 'ITCS317', 'Formal Languages and Automata', 3, 'ITCS214,ITCS255', 1),
(18, 'ITCS325', 'Operating Systems', 3, 'ITCS214,ITCS321', 1),
(19, 'ITCS440', 'Intelligent Systems ', 3, 'ITCS347', 1),
(20, 'ITCS498', 'Senior Project', 3, 'ITCS396', 1),
(21, 'ITCS411', 'Cryptoigraphy and Computer Security', 3, 'ITCS347', 1),
(22, 'ITCS441', 'Parallel and Distributed Systems', 3, 'ITCS325', 1),
(23, 'ITSE201', 'Introduction to Software Engineering', 3, 'ITCS114', 1),
(24, 'ITSE220', 'Software Requirements Engineering', 3, 'ITSE201', 1),
(25, 'ITCS222', 'Computer Organization', 3, 'ITCS214', 1),
(26, 'ITSE301', 'Software Project Management', 3, 'ITSE201', 1),
(27, 'ITSE302', 'Software Design and Architecture', 3, 'ITSE220', 1),
(28, 'ITSE305', 'Software Engineering Project', 3, 'ITSE301,ITSE302', 1),
(29, 'ITSE403', 'Software Testing and Quality Assurance', 3, 'ITSE305', 1),
(30, 'ITSE498', 'Software Engineering Senior Project', 3, 'ITCS396,ITSE305', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_sections`
--

CREATE TABLE `course_sections` (
  `ID` int(11) NOT NULL,
  `semesterID` int(11) DEFAULT NULL,
  `courseID` int(11) DEFAULT NULL,
  `sectionNumber` int(11) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `days` varchar(5) NOT NULL,
  `room` varchar(10) NOT NULL,
  `availableSeats` int(11) NOT NULL DEFAULT 25,
  `finalDate` date DEFAULT NULL,
  `instructorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_sections`
--

INSERT INTO `course_sections` (`ID`, `semesterID`, `courseID`, `sectionNumber`, `startTime`, `endTime`, `days`, `room`, `availableSeats`, `finalDate`, `instructorID`) VALUES
(8, 1, 2, 1, '08:00:00', '08:50:00', 'UTH', '1046', 25, '2024-01-01', 9),
(9, 1, 2, 2, '08:00:00', '09:15:00', 'MW', '1046', 25, '2024-01-01', 9),
(10, 1, 6, 1, '09:00:00', '09:50:00', 'UTH', '1046', 25, '2023-12-31', 1),
(11, 1, 7, 1, '08:00:00', '08:50:00', 'UTH', '1047', 25, '2023-12-31', 1),
(12, 1, 8, 1, '08:00:00', '09:15:00', 'MW', '2046', 25, '2024-01-03', 12),
(13, 1, 8, 2, '09:30:00', '10:45:00', 'MW', '2047', 25, '2024-01-03', 12),
(14, 1, 23, 1, '12:00:00', '12:50:00', 'UTH', '2049', 25, '2024-01-08', 16),
(15, 1, 11, 1, '12:00:00', '12:50:00', 'UTH', '047', 25, '2024-01-04', 14),
(16, 1, 12, 1, '10:00:00', '10:50:00', 'UTH', '047', 25, '2024-01-05', 12),
(17, 1, 14, 1, '09:00:00', '09:50:00', 'UTH', '049', 25, '2024-01-02', 10),
(18, 9, 6, 1, '09:00:00', '09:50:00', 'UTH', '2047', 25, '2022-05-31', 1),
(19, 8, 7, 1, '09:30:00', '10:45:00', 'MW', '049', 25, '2023-01-02', 16),
(20, 7, 8, 1, '12:00:00', '12:50:00', 'UTH', '1049', 25, '2023-06-02', 15);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `college` varchar(50) NOT NULL,
  `departmentHead` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`ID`, `name`, `college`, `departmentHead`) VALUES
(1, 'Computer Science', 'Information Technology', 1);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `ID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `sectionID` int(11) NOT NULL,
  `grade` varchar(2) DEFAULT NULL,
  `absence` int(11) NOT NULL DEFAULT 0,
  `excusedAbsence` int(11) NOT NULL DEFAULT 0,
  `paid` varchar(10) NOT NULL DEFAULT 'No',
  `courseEvaluation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`ID`, `studentID`, `sectionID`, `grade`, `absence`, `excusedAbsence`, `paid`, `courseEvaluation`) VALUES
(5, 2, 10, NULL, 0, 0, 'No', NULL),
(6, 1, 15, NULL, 0, 0, 'No', NULL),
(7, 1, 16, NULL, 0, 0, 'No', NULL),
(8, 1, 17, NULL, 0, 0, 'No', NULL),
(9, 1, 18, 'A', 3, 1, 'Yes', NULL),
(10, 1, 19, 'A-', 0, 0, 'Yes', 9),
(11, 1, 20, 'A', 6, 5, 'Yes', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `departmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`ID`, `username`, `fullName`, `phoneNumber`, `emailAddress`, `password`, `departmentID`) VALUES
(1, 'tsaleh', 'Dr. Taher Saleh', '34343434', 'tsaleh@mt.edu', '$2y$10$2AQSyYaIOVfkQzJrDcB3iuT8taac/Chrb/b./VzYP7.QK1uqymy3K', 1),
(9, 'aahmed', 'Ali Ahmed', '32321122', 'aahmed@mt.edu', '$2y$10$4u7/4kpwFP09YB8Y35KZSutAIliVWAEgb6GxRsOggEXHM8jES3Gny', 1),
(10, 'mmohammed', 'Mansoor Mohammed', '39991213', 'mmohammed@mt.edu', '$2y$10$..1Pnrk09cKWRRoPzYLH.uCNnHb7vWs6UniHDq8G30w8A6pEMguOq', 1),
(11, 'hhassan', 'Hanan Hassan', '34321111', 'hhassan@mt.edu', '$2y$10$jcAfBF1U7osauCethwWlyeMCrkAmDFveiF6d8KZIN74A0fKF8aXCe', 1),
(12, 'risa', 'Reeman Isa', '31319089', 'risa@mt.edu', '$2y$10$UNuSLCPdpkZ8KTs1xrECX.0N/mz1CYfxTkshsCzxd4v14fYYNBb1S', 1),
(13, 'zzuhair', 'Zainab Zuhair', '36612131', 'zzuhair@mt.edu', '$2y$10$4cYJlk8JkAFfuS9rYd3cmuoXwlsILUn5tGweEQSpblwA5UUBzVHw.', 1),
(14, 'ffallah', 'Fawaz Fallah', '32329089', 'ffallah@mt.edu', '$2y$10$.5kW8W6ti3Kti/QpcxiIaOPIPotspaqQwsJOTNVpFU6.GSc8cGMrO', 1),
(15, 'qamire', 'Qassim Amir', '32111123', 'qamire@mt.edu', '$2y$10$KHmeb54EyM6lSusv.XW.D.k1rtv8P5GCwBc5qxdMsRhgBN3OJOWv.', 1),
(16, 'aabdulla', 'Aysha Abdulla', '36361122', 'aabdulla@mt.edu', '$2y$10$6eGXuTPQR41svIOScENcHOJRojnsUDg.nOl0/BkR/ZrQl1RgyZSj2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `PID` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `year` year(4) NOT NULL,
  `departmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`PID`, `name`, `year`, `departmentID`) VALUES
(1, 'Computer Science', '2022', 1),
(2, 'Software Engineering', '2022', 1);

-- --------------------------------------------------------

--
-- Table structure for table `program_courses`
--

CREATE TABLE `program_courses` (
  `ID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `programID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_courses`
--

INSERT INTO `program_courses` (`ID`, `courseID`, `programID`) VALUES
(1, 6, 1),
(2, 7, 1),
(3, 8, 1),
(4, 9, 1),
(5, 10, 1),
(6, 11, 1),
(7, 12, 1),
(8, 17, 1),
(9, 14, 1),
(10, 18, 1),
(11, 2, 1),
(12, 13, 1),
(13, 15, 1),
(14, 16, 1),
(15, 21, 1),
(16, 19, 1),
(17, 22, 1),
(18, 3, 1),
(19, 20, 1),
(20, 6, 2),
(21, 7, 2),
(22, 8, 2),
(23, 25, 2),
(24, 9, 2),
(25, 10, 2),
(26, 11, 2),
(27, 12, 2),
(28, 18, 2),
(29, 2, 2),
(30, 13, 2),
(31, 16, 2),
(32, 21, 2),
(33, 22, 2),
(34, 23, 2),
(35, 24, 2),
(36, 26, 2),
(37, 27, 2),
(38, 28, 2),
(39, 29, 2),
(40, 30, 2);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `ID` int(11) NOT NULL,
  `year` varchar(4) NOT NULL,
  `number` varchar(1) NOT NULL,
  `beginDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `modifyStart` date DEFAULT NULL,
  `modifyEnd` date DEFAULT NULL,
  `dropEnd` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`ID`, `year`, `number`, `beginDate`, `endDate`, `modifyStart`, `modifyEnd`, `dropEnd`) VALUES
(1, '2023', '1', '2023-09-17', '2024-01-10', '2023-05-23', '2023-08-31', '2023-11-22'),
(7, '2022', '2', '2023-01-25', '2023-06-12', '2023-01-15', '2023-01-30', '2023-03-28'),
(8, '2022', '1', '2022-09-18', '2023-01-06', '2022-09-01', '2022-09-20', '2022-11-28'),
(9, '2021', '2', '2022-01-28', '2022-06-05', '2022-01-05', '2022-01-27', '2022-05-05');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `ID` int(11) NOT NULL,
  `studentID` varchar(10) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `studyProgram` int(11) NOT NULL,
  `enrollmentStatus` varchar(20) NOT NULL,
  `creditsPassed` int(11) NOT NULL,
  `CGPA` decimal(3,2) NOT NULL,
  `GPA` decimal(3,2) NOT NULL,
  `balance` float NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `studentID`, `fullName`, `phoneNumber`, `emailAddress`, `studyProgram`, `enrollmentStatus`, `creditsPassed`, `CGPA`, `GPA`, `balance`, `password`) VALUES
(1, '202010691', 'Jood Yaser', '33336666', '202010691@mt.edu', 1, 'Enrolled', 9, 0.00, 0.00, 0, '$2y$10$S/eq/RGqgn8TvTnB7WVY.eVcqDglyCn2MnA0EGu5lDRjs/k1qk0Ze'),
(2, '202007602', 'Sayed Ahmed Khalaf', '32222223', '202007602@mt.edu', 1, 'Enrolled', 0, 0.00, 0.00, 0, '$2y$10$DFJpUHgcJqV9X0R3RhXfm.hI4UTvTIKhvzgnFumYWLJ5u1dfOHwK2'),
(3, '202002622', 'Ali Majeed', '32321131', '202002622@mt.edu', 2, 'Enrolled', 0, 0.00, 0.00, 0, '$2y$10$6zCfj5VCmiRSfbBmSM/iKOn/yUoUnRd1ZA/LZcO8DOWCKrH8u5jwW'),
(4, '202002920', 'Muneera Jaber', '31311133', '202002920@mt.edu', 2, 'Enrolled', 0, 0.00, 0.00, 0, '$2y$10$JLtpxZaYZ7Q8g0LrZcsWeO0OUUAD22amkSbRMrA56OJcXHkmmf/5K');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CourseDepartment` (`courseDepartment`);

--
-- Indexes for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SectionInstructor` (`instructorID`),
  ADD KEY `CourseID` (`courseID`),
  ADD KEY `SemesterID` (`semesterID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `DepartmentHead` (`departmentHead`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SectionID` (`sectionID`),
  ADD KEY `enrollments_ibfk_1` (`studentID`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `EmailAddress` (`emailAddress`),
  ADD UNIQUE KEY `PhoneNumber` (`phoneNumber`),
  ADD KEY `DepartmentID` (`departmentID`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`PID`),
  ADD UNIQUE KEY `Name` (`name`),
  ADD KEY `Department` (`departmentID`);

--
-- Indexes for table `program_courses`
--
ALTER TABLE `program_courses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `courseID` (`courseID`),
  ADD KEY `programID` (`programID`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `StudentID` (`studentID`),
  ADD UNIQUE KEY `EmailAddress` (`emailAddress`),
  ADD KEY `students_ibfk_1` (`studyProgram`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `course_sections`
--
ALTER TABLE `course_sections`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `program_courses`
--
ALTER TABLE `program_courses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`courseDepartment`) REFERENCES `departments` (`ID`);

--
-- Constraints for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD CONSTRAINT `course_sections_ibfk_3` FOREIGN KEY (`semesterID`) REFERENCES `semester` (`ID`),
  ADD CONSTRAINT `course_sections_ibfk_4` FOREIGN KEY (`courseID`) REFERENCES `courses` (`ID`),
  ADD CONSTRAINT `course_sections_ibfk_5` FOREIGN KEY (`instructorID`) REFERENCES `instructors` (`ID`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`departmentHead`) REFERENCES `instructors` (`ID`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `students` (`ID`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`sectionID`) REFERENCES `course_sections` (`ID`);

--
-- Constraints for table `instructors`
--
ALTER TABLE `instructors`
  ADD CONSTRAINT `instructors_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `departments` (`ID`);

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `departments` (`ID`);

--
-- Constraints for table `program_courses`
--
ALTER TABLE `program_courses`
  ADD CONSTRAINT `program_courses_ibfk_1` FOREIGN KEY (`courseID`) REFERENCES `courses` (`ID`),
  ADD CONSTRAINT `program_courses_ibfk_2` FOREIGN KEY (`programID`) REFERENCES `programs` (`pid`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`studyProgram`) REFERENCES `programs` (`pid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

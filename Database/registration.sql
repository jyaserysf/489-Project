-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2023 at 11:46 PM
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
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `AdminID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`AdminID`, `FullName`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES
(1, 'Fatima Hussain', '39787899', 'fahussain@mt.edu', 'Fa@tii3223'),
(2, 'Baqer Hamza', '32321111', 'bhamza@mt.edu', 'BbaqerB3467'),
(3, 'Younis Ahmed', '66668888', 'yahmed@mt.edu', 'YyYyahmed34');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `CourseID` varchar(20) NOT NULL,
  `CourseName` varchar(50) NOT NULL,
  `CreditHours` int(11) NOT NULL,
  `PreRequisites` varchar(100) DEFAULT NULL,
  `CourseDepartment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CourseID`, `CourseName`, `CreditHours`, `PreRequisites`, `CourseDepartment`) VALUES
('ITCE250', 'Digital Logic', 3, NULL, 4),
('ITCS333', 'Internet Software Development', 3, 'ITCS214,ITCS285', 1),
('ITCS489', 'Software Engineering 2', 3, 'ITCS285', 1),
('MATHS211', 'Linear Algebra', 3, 'MATHS102', 3),
('PHYCS101', 'Introduction To Physics', 4, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `course_sections`
--

CREATE TABLE `course_sections` (
  `SectionID` int(11) NOT NULL,
  `SectionNumber` int(11) NOT NULL,
  `SectionStart` time NOT NULL,
  `SectionEnd` time NOT NULL,
  `SectionDays` varchar(5) NOT NULL,
  `SectionRoom` varchar(10) NOT NULL,
  `FinalDate` date DEFAULT NULL,
  `CourseID` varchar(20) DEFAULT NULL,
  `SemesterID` int(10) DEFAULT NULL,
  `SectionInstructor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_sections`
--

INSERT INTO `course_sections` (`SectionID`, `SectionNumber`, `SectionStart`, `SectionEnd`, `SectionDays`, `SectionRoom`, `FinalDate`, `CourseID`, `SemesterID`, `SectionInstructor`) VALUES
(1, 1, '08:00:00', '08:50:00', 'UTH', 'S40-1086', NULL, 'ITCE250', 2, 4),
(2, 1, '09:30:00', '10:45:00', 'MW', 'S40-049', NULL, 'ITCS333', 2, 5),
(3, 1, '11:00:00', '11:50:00', 'UTH', 'S40-2060', NULL, 'ITCS489', 2, 1),
(4, 2, '13:00:00', '14:15:00', 'MW', 'S40-2049', NULL, 'ITCS489', 2, 1),
(5, 1, '10:00:00', '10:50:00', 'UTH', 'S41-1088', NULL, 'MATHS211', 2, 3),
(6, 2, '08:00:00', '08:50:00', 'UTH', 'S41-1088', NULL, 'MATHS211', 2, 3),
(7, 1, '08:00:00', '09:15:00', 'MW', 'S41-1089', NULL, 'PHYCS101', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `DepartmentID` int(11) NOT NULL,
  `DepartmentName` varchar(50) NOT NULL,
  `DepartmentCollege` varchar(50) NOT NULL,
  `DepartmentHead` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`DepartmentID`, `DepartmentName`, `DepartmentCollege`, `DepartmentHead`) VALUES
(1, 'Computer Science', 'Information Technology', 5),
(2, 'Physics', 'Science', 2),
(3, 'Maths', 'Science', 3),
(4, 'Computer Engineering', 'Information Technology', 4),
(5, 'Information Systems', 'Information Technology', 8),
(6, 'Chemistry', 'Science', 7),
(7, 'Biology', 'Science', 6);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `EnrollmentID` int(11) NOT NULL,
  `Grade` varchar(2) NOT NULL,
  `Absence` int(11) NOT NULL,
  `ExcusedAbsence` int(11) NOT NULL,
  `Paid` tinyint(1) NOT NULL,
  `CourseEvaluation` float NOT NULL,
  `StudentID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `InstructorID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DepartmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`InstructorID`, `FullName`, `PhoneNumber`, `EmailAddress`, `Password`, `DepartmentID`) VALUES
(1, 'Dr. Taher Saleh', '34343434', 'tsaleh@mt.edu', 'Taher@123', 1),
(2, 'Mr. Adnan Ali', '38999920', 'aali@mt.edu', 'Adnan345', 2),
(3, 'Dr. Ali Eid', '66666699', 'aeid@mt.edu', 'Aali@!0', 3),
(4, 'Dr. Salah Mohammed', '32132328', 'smohd@mt.edu', 'Mosalah10', 4),
(5, 'Dr. Abdulla Zuhair', '31567652', 'azuhair@mt.edu', 'Ab00d981', 1),
(6, 'Dr. Abrar Isa', '32455677', 'aisa@mt.edu', 'AsSSWQDSWdwsd45656^%$', 7),
(7, 'Dr.Maryam Ali', '32342222', 'mali@mt.edu', 'SDsdsd12#@1287', 6),
(8, 'Dr. Amine Mohammed', '34564321', 'amohd@mt.edu', 'AShjghvg12456$gh23', 5);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `SemesterID` int(10) NOT NULL,
  `SemesterYear` varchar(4) NOT NULL,
  `SemesterNumber` varchar(1) NOT NULL,
  `SemesterBegin` date DEFAULT NULL,
  `SemesterEnd` date DEFAULT NULL,
  `ModifyStart` date DEFAULT NULL,
  `ModifyEnd` date DEFAULT NULL,
  `DropEnd` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`SemesterID`, `SemesterYear`, `SemesterNumber`, `SemesterBegin`, `SemesterEnd`, `ModifyStart`, `ModifyEnd`, `DropEnd`) VALUES
(1, '2022', '1', NULL, NULL, '2022-09-01', '2022-09-15', '2022-11-15'),
(2, '2022', '2', NULL, NULL, '2023-01-02', '2023-01-16', '2023-04-15'),
(3, '2022', '3', NULL, NULL, '2023-06-15', '2023-06-30', '2023-07-31'),
(6, '2023', '1', '2023-09-17', '2024-01-10', '2023-09-09', '2023-09-20', '2023-11-22');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `StudentID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `StudyProgram` varchar(100) NOT NULL,
  `EnrollmentStatus` varchar(20) NOT NULL,
  `CreditsPassed` int(11) NOT NULL,
  `CGPA` decimal(3,2) NOT NULL,
  `GPA` decimal(3,2) NOT NULL,
  `Balance` float NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`StudentID`, `FullName`, `PhoneNumber`, `EmailAddress`, `StudyProgram`, `EnrollmentStatus`, `CreditsPassed`, `CGPA`, `GPA`, `Balance`, `Password`) VALUES
(20189292, 'Hajar Hasan', '36111166', '20189292@mt.edu', 'BSc. in Biology', 'Suspended', 34, 1.80, 2.89, 0, 'H@123h'),
(202002622, 'Ali Majeed', '32327878', '202002622@mt.edu', 'BSc. in Computer Science', 'Enrolled', 71, 3.80, 3.60, 24, 'Ali321'),
(202002920, 'Muneera Jaber', '66999966', '202002920@mt.edu', 'BSc. in Computer Science', 'Enrolled', 68, 3.77, 3.52, 0, 'Mun33ra'),
(202007602, 'Sayed Ahmed Khalaf', '32222223', '202007602@mt.edu', 'BSc. in Computer Science', 'Enrolled', 86, 3.90, 4.00, 0, 'Ahmed123'),
(202010691, 'Jood Yaser', '33336666', '202010691@mt.edu', 'BSc. in Computer Science', 'Enrolled', 81, 3.88, 4.00, 0, 'Jood819');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `CourseDepartment` (`CourseDepartment`);

--
-- Indexes for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD PRIMARY KEY (`SectionID`),
  ADD KEY `SectionInstructor` (`SectionInstructor`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `SemesterID` (`SemesterID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`DepartmentID`),
  ADD KEY `DepartmentHead` (`DepartmentHead`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`EnrollmentID`),
  ADD KEY `SectionID` (`SectionID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`InstructorID`),
  ADD KEY `DepartmentID` (`DepartmentID`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`SemesterID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`StudentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_sections`
--
ALTER TABLE `course_sections`
  MODIFY `SectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `EnrollmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `InstructorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `SemesterID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`CourseDepartment`) REFERENCES `departments` (`DepartmentID`);

--
-- Constraints for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD CONSTRAINT `course_sections_ibfk_1` FOREIGN KEY (`SectionInstructor`) REFERENCES `instructors` (`InstructorID`),
  ADD CONSTRAINT `course_sections_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`),
  ADD CONSTRAINT `course_sections_ibfk_3` FOREIGN KEY (`SemesterID`) REFERENCES `semester` (`SemesterID`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`DepartmentHead`) REFERENCES `instructors` (`InstructorID`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`SectionID`) REFERENCES `course_sections` (`SectionID`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`StudentID`) REFERENCES `students` (`StudentID`);

--
-- Constraints for table `instructors`
--
ALTER TABLE `instructors`
  ADD CONSTRAINT `instructors_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

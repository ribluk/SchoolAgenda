-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2022 at 02:54 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolagenda`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumn_assignment`
--

CREATE TABLE `alumn_assignment` (
  `alumn` varchar(20) NOT NULL,
  `assignment` int(11) NOT NULL,
  `mark` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `alumn_class`
--

CREATE TABLE `alumn_class` (
  `alumn` varchar(20) NOT NULL,
  `class` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `id` int(11) NOT NULL,
  `teacher` int(11) NOT NULL,
  `subject` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` varchar(4) NOT NULL,
  `classroom` int(11) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `classroom`, `capacity`) VALUES
('1CLS', 1, 10),
('2CLS', 2, 20),
('3CLS', 3, 30);

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `id` int(11) NOT NULL,
  `description` varchar(40) NOT NULL,
  `deadline` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `email`) VALUES
(1, 'teacher1@mail.com'),
(2, 'teacher2@mail.com'),
(3, 'teacher3@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_class`
--

CREATE TABLE `teacher_class` (
  `teacher` int(11) NOT NULL,
  `class` varchar(5) NOT NULL,
  `subject` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher_class`
--

INSERT INTO `teacher_class` (`teacher`, `class`, `subject`) VALUES
(1, '1CLS', 'Algebra'),
(1, '1CLS', 'Math'),
(1, '2CLS', 'Algebra'),
(2, '1CLS', 'English'),
(2, '2CLS', 'English'),
(2, '3CLS', 'English'),
(3, '3CLS', 'Biology'),
(3, '3CLS', 'Chemistry'),
(3, '3CLS', 'Physics');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `topic` varchar(30) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `type` enum('oral','written') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `email` varchar(20) NOT NULL,
  `password` varchar(16) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `address` varchar(30) NOT NULL,
  `dateob` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`, `name`, `surname`, `address`, `dateob`) VALUES
('alumn1@mail.com', 'pass', 'alumn', '1', '1, alumn st.', '2003-11-01'),
('alumn2@mail.com', 'pass', 'alumn', '2', '1, alumn st.', '2003-11-02'),
('alumn3@mail.com', 'pass', 'alumn', '3', '3, alumn st.', '2003-11-03'),
('alumn4@mail.com', 'pass', 'alumn', '4', '4, alumn st.', '2003-11-04'),
('alumn5@mail.com', 'pass', 'alumn', '5', '5, alumn st.', '2003-11-05'),
('teacher1@mail.com', 'pass', 'teacher', '1', '1, teacher st.', '1903-11-01'),
('teacher2@mail.com', 'pass', 'teacher', '2', '2, teacher st.', '1903-11-02'),
('teacher3@mail.com', 'pass', 'teacher', '3', '3, teacher st.', '1903-11-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumn_assignment`
--
ALTER TABLE `alumn_assignment`
  ADD PRIMARY KEY (`alumn`,`assignment`),
  ADD KEY `assignment` (`assignment`);

--
-- Indexes for table `alumn_class`
--
ALTER TABLE `alumn_class`
  ADD PRIMARY KEY (`alumn`,`class`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher` (`teacher`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `teacher_class`
--
ALTER TABLE `teacher_class`
  ADD PRIMARY KEY (`teacher`,`class`,`subject`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumn_assignment`
--
ALTER TABLE `alumn_assignment`
  ADD CONSTRAINT `alumn_assignment_ibfk_1` FOREIGN KEY (`alumn`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `alumn_assignment_ibfk_2` FOREIGN KEY (`assignment`) REFERENCES `assignment` (`id`);

--
-- Constraints for table `alumn_class`
--
ALTER TABLE `alumn_class`
  ADD CONSTRAINT `alumn_class_ibfk_1` FOREIGN KEY (`alumn`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `alumn_class_ibfk_2` FOREIGN KEY (`class`) REFERENCES `class` (`id`);

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`teacher`) REFERENCES `teacher` (`id`);

--
-- Constraints for table `homework`
--
ALTER TABLE `homework`
  ADD CONSTRAINT `homework_ibfk_1` FOREIGN KEY (`id`) REFERENCES `assignment` (`id`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `teacher_class`
--
ALTER TABLE `teacher_class`
  ADD CONSTRAINT `teacher_class_ibfk_1` FOREIGN KEY (`teacher`) REFERENCES `teacher` (`id`),
  ADD CONSTRAINT `teacher_class_ibfk_2` FOREIGN KEY (`class`) REFERENCES `class` (`id`);

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`id`) REFERENCES `assignment` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Database: `kiitquestionbank`
--
CREATE DATABASE IF NOT EXISTS `kiitquestionbank` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `kiitquestionbank`;

-- --------------------------------------------------------
--
-- Drop the Table `school` if exists
--
DROP TABLE IF EXISTS `school`;

--
-- Table structure for table `school`
--
CREATE TABLE `school`
(
  `school_id` INT(4) AUTO_INCREMENT PRIMARY KEY,
  `school_name` varchar(50) NOT NULL,
  `school_desc` varchar(100) DEFAULT NULL,
  `comments` varchar(100) DEFAULT NULL,
  `injected_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Drop the Table `school` if exists
--
DROP TABLE IF EXISTS `user_info`;

--
-- Table structure for table `user_info`
--
CREATE TABLE `user_info`
(
  `user_id` INT(4) AUTO_INCREMENT PRIMARY KEY,
  `school_id` INT(4) NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_admin` bit(1) NOT NULL,
  `injected_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Drop the Table `subject` if exists
--
DROP TABLE IF EXISTS `subject`;

--
-- Table structure for table `subject`
--
CREATE TABLE `subject`
(
  `sub_id` INT(5) AUTO_INCREMENT PRIMARY KEY,
  `sub_code` varchar(20) NOT NULL,
  `sub_name` varchar(50) NOT NULL,
  `sub_desc` varchar(50) NOT NULL,
  `comments` varchar(100) DEFAULT NULL,
  `injected_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Drop the Table `questiontype` if exists
--
DROP TABLE IF EXISTS `questiontype`;

--
-- Table structure for table `questiontype`
--
CREATE TABLE `questiontype`
(
  `qt_id` INT(1) AUTO_INCREMENT PRIMARY KEY,
  `qt_name` varchar(50) NOT NULL,
  `qt_desc` varchar(50) DEFAULT NULL,
  `comments` varchar(50) DEFAULT NULL,
  `injected_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Drop the Table `questiontype` if exists
--
DROP TABLE IF EXISTS `academic_degree`;

--
-- Table structure for table `questiontype`
--
CREATE TABLE `academic_degree`
(
  `ad_id` INT(2) AUTO_INCREMENT PRIMARY KEY,
  `ad_name` varchar(50) NOT NULL,
  `ad_desc` varchar(50) DEFAULT NULL,
  `comments` varchar(50) DEFAULT NULL,
  `injected_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Drop the Table `questiontype` if exists
--
DROP TABLE IF EXISTS `questionbank`;

--
-- Table structure for table `questionbank`
--
CREATE TABLE `questionbank`
(
  `q_id` INT(5) AUTO_INCREMENT PRIMARY KEY,
  `school_id` INT(4) DEFAULT NULL,
  `intermediate_year` enum('1st','2nd','3rd','4th','5th','6th') NOT NULL,
  `sub_id` INT(5) DEFAULT NULL,
  `ad_id` INT(2) DEFAULT NULL,
  `question_desc` varchar(50) DEFAULT NULL,
  `question_file` MEDIUMBLOB DEFAULT NULL,
  `answer_desc` varchar(50) DEFAULT NULL,
  `answer_file` MEDIUMBLOB DEFAULT NULL,
  `qt_id` int(1) DEFAULT NULL,
  `q_year` int(4) DEFAULT NULL,
  `user_name` varchar(50) NOT NULL,
  `injected_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Drop the Table `questiontype` if exists
--
DROP VIEW IF EXISTS `questionbank_v`;

--
-- Structure of `questionbank_v` view
--
CREATE OR REPLACE VIEW `questionbank_v` AS SELECT
  questionbank.q_id AS `QUESTION_ID`,
  questionbank.school_id AS `SCHOOL_ID`,
  school.school_name AS `SCHOOL_NAME`,
  school.school_desc AS `SCHOOL_DESC`,
  questionbank.intermediate_year AS `INTERMEDIATE_YEAR`,
  questionbank.sub_id AS `SUBJECT_ID`,
  subject.sub_code AS `SUBJECT_CODE`,
  subject.sub_name AS `SUBJECT_NAME`,
  subject.sub_desc AS `SUBJECT_DESC`,
  questionbank.ad_id AS `ACADEMIC_ID`,
  academic_degree.ad_name AS `ACADEMIC_NAME`,
  academic_degree.ad_desc AS `ACADEMIC_DESC`,
  questionbank.question_desc AS `QUESTION_DESC`,
  questionbank.question_file AS `QUESTION_FILE`,
  questionbank.answer_desc AS `ANSWER_DESC`,
  questionbank.answer_file AS `ANSWER_FILE`,
  questionbank.qt_id AS `QUESTION_TYPE_ID`,
  questiontype.qt_name AS `QUESTION_TYPE_NAME`,
  questiontype.qt_desc AS `QUESTION_TYPE_DESC`,
  questionbank.q_year AS `QUESTION_YEAR`,
  questionbank.user_name AS `USER_NAME` FROM questionbank INNER JOIN school ON questionbank.school_id = school.school_id
										INNER JOIN subject ON questionbank.sub_id = subject.sub_id
										INNER JOIN questiontype ON questionbank.qt_id = questiontype.qt_id
										INNER JOIN academic_degree ON questionbank.ad_id = academic_degree.ad_id;

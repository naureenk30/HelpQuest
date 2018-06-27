--
-- Database: `kiitquestionbank`
--
USE `kiitquestionbank`;

TRUNCATE TABLE `school`;
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Computer Application", "School of Computer Application", "School of Computer Application");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Civil", "School of Civil Engineering", "School of Civil Engineering");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Computer", "School of Computer Engineering", "School of Computer Engineering");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Electrical", "School of Electrical Engineering", "School of Electrical Engineering");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Electronics", "School of Electronics Engineering", "School of Electronics Engineering");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Mechanical", "School of Mechanical Engineering", "School of Mechanical Engineering");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Humanities and Social Sciences", "School of Humanities and Social Sciences", "School of Humanities and Social Sciences");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Applied Sciences", "School of Applied Sciences", "School of Applied Sciences");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Management", "School of Management", "School of Management");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Biotechnology", "School of Biotechnology", "School of Biotechnology");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Rural Management", "School of Rural Management", "School of Rural Management");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Law", "School of Law", "School of Law");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Fashion Technology", "School of Fashion Technology", "School of Fashion Technology");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Film and Media Sciences", "School of Film and Media Sciences", "School of Film and Media Sciences");
INSERT INTO `school`(school_name, school_desc, comments) VALUES("Medicine", "School of Medicine", "School of Medicine");

TRUNCATE TABLE `user_info`;
INSERT INTO user_info(name, password, is_admin) VALUES('ca@kiit.ac.in', MD5('ca@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('civil@kiit.ac.in', MD5('civil@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('computer@kiit.ac.in', MD5('computer@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('electrical@kiit.ac.in', MD5('electrical@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('electronics@kiit.ac.in', MD5('electronics@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('mechanical@kiit.ac.in', MD5('mechanical@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('hasc@kiit.ac.in', MD5('hasc@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('as@kiit.ac.in', MD5('as@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('management@kiit.ac.in', MD5('management@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('biotechnology@kiit.ac.in', MD5('biotechnology@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('rm@kiit.ac.in', MD5('rm@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('law@kiit.ac.in', MD5('law@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('ft@kiit.ac.in', MD5('ft@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('fams@kiit.ac.in', MD5('fams@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('mediciene@kiit.ac.in', MD5('mediciene@kiit.ac.in'), 0);
INSERT INTO user_info(name, password, is_admin) VALUES('admin@kiit.ac.in', MD5('admin@kiit.ac.in'), 1);

TRUNCATE TABLE `questiontype`;
INSERT INTO questiontype(qt_name, qt_desc, comments) VALUES('Mid-Sem', 'Mid Semester', 'Mid Semester');
INSERT INTO questiontype(qt_name, qt_desc, comments) VALUES('End-Sem', 'End Semester', 'End Semester');
INSERT INTO questiontype(qt_name, qt_desc, comments) VALUES('Supplementary', 'Supplementary', 'Supplementary');
INSERT INTO questiontype(qt_name, qt_desc, comments) VALUES('Repeat-Mid-Sem', 'Repeat Mid Semester', 'Repeat Mid Semester');
INSERT INTO questiontype(qt_name, qt_desc, comments) VALUES('Practice', 'Practice Questions', 'Practice Questions');

TRUNCATE TABLE `academic_degree`;
INSERT INTO academic_degree(ad_name, ad_desc, comments) VALUES('B.Tech', 'Bachelor of Technology', '4 years');
INSERT INTO academic_degree(ad_name, ad_desc, comments) VALUES('M.Tech', 'Master of Technology', '2 years');
INSERT INTO academic_degree(ad_name, ad_desc, comments) VALUES('Ph.D', 'Doctor of Philosophy', 'Minimum 3 years');
INSERT INTO academic_degree(ad_name, ad_desc, comments) VALUES('B.Tech & M.Tech', 'Dual Degree (B.Tech & M.Tech)', '5 years');
INSERT INTO academic_degree(ad_name, ad_desc, comments) VALUES('B.Tech & MBA', 'Dual Degree (B.Tech & MBA)', '6 years');

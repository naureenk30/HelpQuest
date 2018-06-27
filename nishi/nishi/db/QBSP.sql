--
-- Database: `kiitquestionbank`
--
USE `kiitquestionbank`;

--
-- Drop the FUNCTION `AUTHENTICATE` if exists
--
DROP FUNCTION IF EXISTS `AUTHENTICATE`;

--
-- FUNCTION to authenticate the user
--
CREATE FUNCTION AUTHENTICATE (uname varchar(50), upassword varchar(50)) RETURNS INT 
BEGIN
  RETURN (SELECT COUNT(*) FROM user_info WHERE name = uname AND password = MD5(upassword));
END

--
-- Drop the FUNCTION `AUTHENTICATE` if exists
--
DROP FUNCTION IF EXISTS `ISADMIN`;

--
-- FUNCTION to check whether the user is an admin or standard user
--
CREATE FUNCTION ISADMIN(uname varchar(50)) RETURNS INT
DETERMINISTIC 
BEGIN
   DECLARE checkAdmin bit(1);
   SELECT `is_admin` INTO checkAdmin FROM user_info WHERE name = uname;
   RETURN checkAdmin;
END
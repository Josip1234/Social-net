-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2026 at 03:39 PM
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
-- Database: `socialnet`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `autoInsertIntoProfileDet` (IN `userId` INT UNSIGNED, IN `acTypeId` INT UNSIGNED, IN `registrationDate` DATETIME, IN `accountStatus` VARCHAR(50))   begin
-- validate if status is one of the three in enum of account status table
if accountStatus = 'Active' || accountStatus = 'Banned' || accountStatus = 'Inactive' then
insert into profiledetails(userId,acTypeId,registrationDate,accountStatus)
values (userId,acTypeId,registrationDate, accountStatus);
else
SIGNAL sqlstate '45000'
set message_text = 'Account status is invalid. Please, choose one of the values: Active, Banned or Inactive.';
end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Create_user_Or_grant_roles` (IN `userName` VARCHAR(255))   BEGIN
    declare recordNumber int;
    declare userName2 varchar(255);
	SELECT count(*) INTO recordNumber FROM databaseuser d WHERE d.userName=userName;
    if recordNumber = 0 then
    select concat('User does not exist') as Poruka;
    else 
       SELECT d.userName INTO userName2 FROM databaseuser d WHERE d.userName=userName;
       if userName2='social_admin' then
           CREATE USER IF NOT EXISTS 'social_admin'@'localhost' IDENTIFIED BY 'rootadmin123';
           GRANT ALL PRIVILEGES ON socialnet.* TO 'social_admin'@'localhost' with grant option;
           FLUSH PRIVILEGES;
       elseif userName2='regular' then
        CREATE USER IF NOT EXISTS 'regular'@'localhost' IDENTIFIED BY 'reg';
           GRANT select,insert,update,delete ON socialnet.* TO 'regular'@'localhost';
           FLUSH PRIVILEGES;
       end if;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUsersIntoDbLoggerIfNotExists` (IN `id` INT(10) UNSIGNED)   BEGIN
   -- variable to store current user
   -- declare currentUser varchar(255);
    -- need user id first
  -- declare id int(10) unsigned;insertUserIntoDatabaseLogger
   -- get current user
   -- select substring_index(current_user(),'@',1) INTO currentUser;
   -- get uder id from current user
   -- select userId into id from databaseuser where userName=userName;
   -- if userid is not null insert into db logger current user id
   if id is not null && user()='social_admin@localhost' then
      insert into database_logger(userId) value (id);
       call saveLog('insert','dbus');
	else 
    SIGNAL sqlstate '45000' 
     set message_text='User is not admin.Operation not allowed.';
   end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUsersIntoLoggers` (IN `tableNameForInsert` VARCHAR(50), IN `userNum` INT(10) UNSIGNED)   BEGIN
declare userCount int(10) unsigned;
-- to insert users with id into database logger first we need to check if user already exists
select count(userId) into userCount from database_logger where userId=userNum;
if tableNameForInsert='database_logger' then
if userCount=0 then
insert into database_logger(userId) value (userId);
else 
SIGNAL sqlstate '45000'
set message_text='User already exists in database logger. Insert operation will be aborted.';
end if;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `limitUseOfCudOperations` (IN `operation` VARCHAR(10))   BEGIN
declare typeOfUser varchar(30);
declare dbLoggerid int(10) unsigned;
    declare id int(10) unsigned;
select act.acTypeName into typeOfUser from accountType act  inner join databaseuser du on act.acTypeId=du.acTypeId where 
du.userName=substring_index(user(),'@',1);
select userId into id from databaseuser where userName=substring_index(user(),'@',1);
SELECT dbLogId into dbLoggerid from database_logger WHERE userId=id;
if operation = 'insert' && typeOfUser='Regular' then
-- select concat('Regular user can only read data from this table.') as Poruka;
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Regular user can only read data from this table.',substring_index(user(),'@',1),now());
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
elseif operation = 'update' && typeOfUser='Regular' then
-- select concat('Regular user can only read data from this table.') as Poruka;
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Regular user can only read data from this table.',substring_index(user(),'@',1),now());
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
elseif operation = 'delete' && typeOfUser='Regular' then
-- select concat('Regular user can only read data from this table.') as Poruka;
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Regular user can only read data from this table.',substring_index(user(),'@',1),now());
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `saveLog` (IN `operation` VARCHAR(10), IN `tableName` VARCHAR(50))   BEGIN
   -- variable to store current user
     declare currentUser varchar(255);
    -- need user id first
    declare id int(10) unsigned;
    declare dbLoggerid int(10) unsigned;
    declare userType varchar(30);
   -- get current user
   select userName into currentUser from databaseuser where userName=substring_index(user(),'@',1);
   -- get uder id from current user
   select userId into id from databaseuser where userName=currentUser;
-- now we need to select logger id
SELECT dbLogId into dbLoggerid from database_logger WHERE userId=id;
select act.acTypeName into userType from accountType act  inner join databaseuser du on act.acTypeId=du.acTypeId where 
du.userName=substring_index(user(),'@',1);
if operation = 'insert' && tableName = 'state' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Logged in user has added new state',currentUser,now());
elseif operation = 'update' && tableName = 'state' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Logged in user has updated state',currentUser,now());
elseif operation = 'delete' && tableName = 'state' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Logged in user has deleted a state',currentUser,now());
elseif operation = 'insert' && tableName = 'city' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Logged in user has added new city.',currentUser,now());
elseif operation = 'update' && tableName = 'city' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Logged in user has updated a city',currentUser,now());
elseif operation = 'delete' && tableName = 'city' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Logged in user has deleted a city',currentUser,now());
elseif operation = 'insert' && tableName = 'adr' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Logged in user has added new address.',currentUser,now());
elseif operation = 'update' && tableName = 'adr' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Logged in user updated an adress.',currentUser,now());
elseif operation = 'delete' && tableName = 'adr' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Logged in user deleted an address',currentUser,now());
elseif operation = 'insert' && tableName = 'pd' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Added new profile detail.',currentUser,now());
elseif operation = 'update' && tableName = 'pd' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Updated profile detail.',currentUser,now());
elseif operation = 'delete' && tableName = 'pd' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Deleted profile detail.',currentUser,now());
elseif operation = 'insert' && tableName = 'at' && userType ='Admin' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New account type has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'at' && userType = 'Admin' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Account type has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'at' && userType = 'Admin' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Deleted account type.',currentUser,now());
elseif operation = 'insert' && tableName = 'dbus' && userType ='Admin' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New database user has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'dbus' && userType = 'Admin' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Database user has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'dbus' && userType = 'Admin' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Deleted database user.',currentUser,now());

elseif operation = 'insert' && tableName = 'cmt' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New comment has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'cmt' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Comment has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'cmt' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Comment has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'img' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New image has been uploaded.',currentUser,now());
elseif operation = 'update' && tableName = 'img' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Image has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'img' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Image has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'imgal' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New image has been added to gallery.',currentUser,now());
elseif operation = 'update' && tableName = 'imgal' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Gallery has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'imgal' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Image gallery has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'imgdet' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New image detail has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'imgdet' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Image detail has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'imgdet' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Image detail has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'imgtyp' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New image type has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'imgtyp' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Image type has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'imgtyp' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Image type has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'iig' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New image has been added to the gallery.',currentUser,now());
elseif operation = 'update' && tableName = 'iig' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Image has been replace in gallery.',currentUser,now());
elseif operation = 'delete' && tableName = 'iig' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Image has been removed from the gallery.',currentUser,now());

elseif operation = 'insert' && tableName = 'pcs' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New comment has been connected with profile comment subtopic table.',currentUser,now());
elseif operation = 'update' && tableName = 'pcs' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Comment has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'pcs' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Comment has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'dblog' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New user has been added to database logger.',currentUser,now());
elseif operation = 'update' && tableName = 'dblog' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'User has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'dblog' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'User has been deleted.',currentUser,now());
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `saveLog2` (IN `operation` VARCHAR(10), IN `tableName` VARCHAR(50))   BEGIN
   -- variable to store current user
     declare currentUser varchar(255);
    -- need user id first
    declare id int(10) unsigned;
    declare dbLoggerid int(10) unsigned;
    declare userType varchar(30);
   -- get current user
   select userName into currentUser from databaseuser where userName=substring_index(user(),'@',1);
   -- get uder id from current user
   select userId into id from databaseuser where userName=currentUser;
-- now we need to select logger id
SELECT dbLogId into dbLoggerid from database_logger WHERE userId=id;
select act.acTypeName into userType from accountType act  inner join databaseuser du on act.acTypeId=du.acTypeId where 
du.userName=substring_index(user(),'@',1);
if operation = 'insert' && tableName = 'pl' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New user has been added to profile logger.',currentUser,now());
elseif operation = 'update' && tableName = 'pl' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'User has been updated from profile logger',currentUser,now());
elseif operation = 'delete' && tableName = 'pl' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'User has been deleted from profile logger.',currentUser,now());
elseif operation = 'insert' && tableName = 'st' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New subtopic has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'st' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Subtopic has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'st' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Subtopic has been deleted.',currentUser,now());
elseif operation = 'insert' && tableName = 'top' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New topic has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'top' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Topic has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'top' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Topic has been deleted.',currentUser,now());
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `saveProfileLog` (IN `operation` VARCHAR(10), IN `tableName` VARCHAR(50), IN `userName2` VARCHAR(255), IN `oldUserName` VARCHAR(255))   BEGIN
   -- variable to store current user
     declare currentUser varchar(255);
    -- need user id first
    declare id int(10) unsigned;
    declare dbLoggerid int(10) unsigned;
   -- get current user
   select userName into currentUser from databaseuser where userName=substring_index(user(),'@',1);
   -- get uder id from current user
   select userId into id from databaseuser where userName=currentUser;
-- now we need to select logger id
SELECT dbLogId into dbLoggerid from database_logger WHERE userId=id;
if operation = 'insert' && tableName = 'profile' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,concat('New user ',userName2,' has been added'),currentUser,now());
elseif operation = 'update' && tableName = 'profile' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,concat('Username ',oldUserName,' has been updated. New value ',userName2),currentUser,now());
elseif operation = 'delete' && tableName = 'profile' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,concat('User ',userName2,' has been deleted'),currentUser,now());
end if;
END$$

CREATE DEFINER=`social_admin`@`localhost` PROCEDURE `update_profile_address` (IN `addressId` INT)   BEGIN
declare uIdWhereNull int;
declare adIdWhereNull int;
-- id where to insert
select p.userId into uIdWhereNull from profile p where p.addressId is NULL;
-- confirm if address is nukk
select p.addressId into adIdWhereNull from profile p where p.addressId is NULL;
if adIdWhereNull is NULL then
update profile set profile.addressId=addressId where profile.userId=uIdWhereNull;
end if;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounttype`
--

CREATE TABLE `accounttype` (
  `acTypeId` int(10) UNSIGNED NOT NULL,
  `acTypeName` varchar(30) NOT NULL,
  `listOfPrivileges` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounttype`
--

INSERT INTO `accounttype` (`acTypeId`, `acTypeName`, `listOfPrivileges`) VALUES
(1, 'Admin', 'ALL PRIVILEGES'),
(2, 'Regular', 'Create,insert,delete,select');

--
-- Triggers `accounttype`
--
DELIMITER $$
CREATE TRIGGER `deleteTypeLog` AFTER DELETE ON `accounttype` FOR EACH ROW begin 
if user()='regular' then
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
else
call saveLog('delete','at');
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertTypeLog` AFTER INSERT ON `accounttype` FOR EACH ROW begin 
if user()='regular' then
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
else
call saveLog('insert','at');
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `limitAccountTypeTableBeforeDelete` BEFORE DELETE ON `accounttype` FOR EACH ROW begin 
if user()='regular' then
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
else
call limitUseOfCudOperations('delete');
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `limitAccountTypeTableBeforeInsert` BEFORE INSERT ON `accounttype` FOR EACH ROW begin 
if user()='regular' then
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
else
call limitUseOfCudOperations('insert');
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `limitAccountTypeTableBeforeUpdate` BEFORE UPDATE ON `accounttype` FOR EACH ROW begin 
if user()='regular' then
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
else
call limitUseOfCudOperations('update');
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateTypeLog` AFTER UPDATE ON `accounttype` FOR EACH ROW begin 
if user()='regular' then
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
else
call saveLog('update','at');
end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `addressId` int(10) UNSIGNED NOT NULL,
  `street` varchar(255) NOT NULL,
  `postNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`addressId`, `street`, `postNumber`) VALUES
(1, 'Ivana Zeline 53', '10000'),
(2, '123 Malino Street', '20162'),
(3, 'Sveti Rok 81', '34000'),
(4, 'Jankomirska 25', '12365000'),
(5, 'Matije Gupca 6', '34000'),
(6, 'Ivana Zeline 53', '20162'),
(7, 'Maksimirska 25', '10000'),
(8, '123 Malino Street', '12365000'),
(9, 'Sveti rok 81', '34000'),
(10, 'Jankomirska 25', '1');

--
-- Triggers `address`
--
DELIMITER $$
CREATE TRIGGER `deleteAdrIntoDatabaseLogger` AFTER DELETE ON `address` FOR EACH ROW begin 
call saveLog('delete','adr');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertAdrIntoDatabaseLogger` AFTER INSERT ON `address` FOR EACH ROW begin 
call saveLog('insert','adr');
-- auto update address in profile table after address has been inserted into address table
call update_profile_address(new.addressId);
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateAdrIntoDatabaseLogger` AFTER UPDATE ON `address` FOR EACH ROW begin 
call saveLog('update','adr');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `postNumber` varchar(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `stateId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`postNumber`, `name`, `stateId`) VALUES
('01001', 'Kyiv', 8),
('1', 'Mexico City', 5),
('10000', 'Zagreb', 1),
('10101', 'Jastrebarsko', 1),
('10450', 'Jastrebarsko', 1),
('12365000', 'Marseille', 3),
('20001', 'Washington, D.C', 4),
('20162', 'Milano', 2),
('3', 'afafwaf', 1),
('31309', 'Kneževi Vinogradi', 1),
('32000', 'Firenza', 2),
('34000', 'Požega', 1),
('34310', 'Pleternica', 1),
('34311', 'Kuzmica', 1),
('34550', 'Pakrac', 1),
('35000', 'Slavonski Brod', 1),
('4', 'Navodno', 1),
('44100', 'Guadalajara', 5),
('44213', 'Kratečko', 1),
('44330', 'Novska', 1),
('455', 'bfdgsdg', 1),
('47240', 'Slunj', 1),
('52434', 'Boljun', 1),
('70123', 'Paris', 3),
('71000', 'Sarajevo', 12),
('789996', 'gsgsgsf', 1),
('80100', 'Poreč', 1);

--
-- Triggers `city`
--
DELIMITER $$
CREATE TRIGGER `UserLogAfterDeleteOnCity` AFTER DELETE ON `city` FOR EACH ROW begin 
call saveLog('delete','city');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UserLogAfterInsertOnCity` AFTER INSERT ON `city` FOR EACH ROW begin 
call saveLog('insert','city');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UserLogAfterUpdateOnCity` AFTER UPDATE ON `city` FOR EACH ROW begin 
call saveLog('update','city');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentId` int(10) UNSIGNED NOT NULL,
  `commentContent` text NOT NULL,
  `markOfOffensiveness` enum('Offensive','Not offensive') DEFAULT NULL,
  `comDateUpdated` datetime NOT NULL,
  `comDateAdded` datetime NOT NULL,
  `commentLike` int(10) UNSIGNED NOT NULL,
  `commentDislike` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `comments`
--
DELIMITER $$
CREATE TRIGGER `CommentLogAfterDelete` AFTER DELETE ON `comments` FOR EACH ROW begin 
call saveLog('delete','cmt');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `CommentLogAfterInsert` AFTER INSERT ON `comments` FOR EACH ROW begin 
call saveLog('insert','cmt');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `CommentLogAfterUpdate` AFTER UPDATE ON `comments` FOR EACH ROW begin 
call saveLog('update','cmt');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `databaseuser`
--

CREATE TABLE `databaseuser` (
  `userId` int(10) UNSIGNED NOT NULL,
  `userName` varchar(255) NOT NULL,
  `acTypeId` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `databaseuser`
--

INSERT INTO `databaseuser` (`userId`, `userName`, `acTypeId`) VALUES
(1, 'social_admin', 1),
(2, 'regular', 2);

--
-- Triggers `databaseuser`
--
DELIMITER $$
CREATE TRIGGER `dbuserDeleteLog` AFTER DELETE ON `databaseuser` FOR EACH ROW begin 
if user()='regular' then
SIGNAL sqlstate '45000' 
set message_text='User is not admin.Operation not allowed.';
	else
call saveLog('delete','dbus');
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `dbuserInsertLog` BEFORE INSERT ON `databaseuser` FOR EACH ROW begin 
if user()='regular' then
SIGNAL sqlstate '45000' 
set message_text='User is not admin.Operation not allowed.';
	else
call saveLog('insert','dbus');
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `dbuserUpdateLog` AFTER UPDATE ON `databaseuser` FOR EACH ROW begin 
if user()='regular' then
SIGNAL sqlstate '45000' 
set message_text='User is not admin.Operation not allowed.';
	else
call saveLog('update','dbus');
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertUserIntoDatabaseLogger` AFTER INSERT ON `databaseuser` FOR EACH ROW begin 
if user()='regular' then
SIGNAL sqlstate '45000' 
set message_text='User is not admin.Operation not allowed.';
	else
call insertUsersIntoDbLoggerIfNotExists(new.userId);
end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `database_logger`
--

CREATE TABLE `database_logger` (
  `dbLogId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `database_logger`
--

INSERT INTO `database_logger` (`dbLogId`, `userId`) VALUES
(1, 1),
(2, 2);

--
-- Triggers `database_logger`
--
DELIMITER $$
CREATE TRIGGER `databaseLogAfterDelete` AFTER DELETE ON `database_logger` FOR EACH ROW begin 
call saveLog('delete','dblog');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `databaseLogAfterInsert` AFTER INSERT ON `database_logger` FOR EACH ROW begin 
call saveLog('insert','dblog');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `databaseLogAfterUpdate` AFTER UPDATE ON `database_logger` FOR EACH ROW begin 
call saveLog('update','dblog');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `imageId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `imageName` varchar(50) NOT NULL,
  `url` text NOT NULL,
  `profileMarkImage` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`imageId`, `userId`, `imageName`, `url`, `profileMarkImage`) VALUES
(1, 2, 'slikica.net', 'social_net/2/slika.png', ''),
(2, 2, 'image_69df9378c2f84.jpeg', 'C:\\xampp\\htdocs\\Social-net\\Web_application\\app\\Helpers../../../public/assets/images/2/image_69df9378c2f84.jpeg', ''),
(3, 2, 'image_69df950f4ed11.jpeg', 'C:\\xampp\\htdocs\\Social-net\\Web_application\\app\\Helpers../../../public/assets/images/2/image_69df950f4ed11.jpeg', ''),
(4, 2, 'image_69df9758a6850.jpeg', 'C:\\xampp\\htdocs\\Social-net\\Web_application\\app\\Helpers../../../public/assets/images/2/image_69df9758a6850.jpeg', ''),
(5, 2, 'image_69df979edfecf.jpeg', 'C:\\xampp\\htdocs\\Social-net\\Web_application\\app\\Helpers../../../public/assets/images/2/image_69df979edfecf.jpeg', ''),
(6, 2, 'image_69e38dd64da8c.webp', 'C:\\xampp\\htdocs\\Social-net\\Web_application\\app\\Helpers../../../public/assets/images/2/image_69e38dd64da8c.webp', ''),
(7, 2, 'image_69e38f6f32948.jpg', 'C:\\xampp\\htdocs\\Social-net\\Web_application\\app\\Helpers../../../public/assets/images/2/image_69e38f6f32948.jpg', ''),
(8, 2, 'image_69e3922d3316b.webp', 'C:\\xampp\\htdocs\\Social-net\\Web_application\\app\\Helpers../../../public/assets/images/2/image_69e3922d3316b.webp', ''),
(9, 2, 'image_69e39497bb7b1.webp', 'wp14494675.webp', ''),
(10, 2, 'image_69e39df3f1be0.jpg', 'wp12965257-asus-vivobook-15-wallpapers.jpg', ''),
(12, 20, 'some', 'some', ''),
(13, 20, 'image_69f1c34501b98.jpg', 'index3.jpg', 'p'),
(14, 2, 'image_69f35a1c888df.webp', 'd00791ae-ubuntu_cli_cheat_sheet_2025.webp', 'p'),
(15, 23, 'slika.jpg', 'slika.jpg', 'p'),
(17, 24, 'image_6a0c53a9b13bf.jpg', 'index7.jpg', 'p'),
(18, 25, 'image_6a0dcc576208a.jpg', 'chuckolino.jpg', 'p'),
(20, 28, 'image_6a0ebcc0c56ea.jpg', 'index6.jpg', 'p'),
(21, 30, 'image_6a2c7ff6dcc4c.jpg', 'index34.jpg', 'p');

--
-- Triggers `image`
--
DELIMITER $$
CREATE TRIGGER `ImageLogAfterDelete` AFTER DELETE ON `image` FOR EACH ROW begin 
call saveLog('delete','img');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ImageLogAfterInsert` AFTER INSERT ON `image` FOR EACH ROW begin 
call saveLog('insert','img');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ImageLogAfterUpdate` AFTER UPDATE ON `image` FOR EACH ROW begin 
call saveLog('update','img');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `imagedetails`
--

CREATE TABLE `imagedetails` (
  `iDetailsId` int(10) UNSIGNED NOT NULL,
  `typeId` int(10) UNSIGNED NOT NULL,
  `imageSize` varchar(15) NOT NULL,
  `imageDateAdded` datetime NOT NULL,
  `imageDateUpdated` datetime NOT NULL,
  `imageId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `imagedetails`
--
DELIMITER $$
CREATE TRIGGER `ImageDetailsLogAfterDelete` AFTER DELETE ON `imagedetails` FOR EACH ROW begin 
call saveLog('delete','imgdet');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ImageDetailsLogAfterInsert` AFTER INSERT ON `imagedetails` FOR EACH ROW begin 
call saveLog('insert','imgdet');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ImageDetailsLogAfterUpdate` AFTER UPDATE ON `imagedetails` FOR EACH ROW begin 
call saveLog('update','imgdet');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `imagetype`
--

CREATE TABLE `imagetype` (
  `typeId` int(10) UNSIGNED NOT NULL,
  `iTypeName` enum('.jpg','.jpeg','.png','.gif','.webp','.svg') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `imagetype`
--
DELIMITER $$
CREATE TRIGGER `limitUserOfDeletingDataToImageType` BEFORE DELETE ON `imagetype` FOR EACH ROW begin 
call limitUseOfCudOperations('delete');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `limitUserOfInsertingDataToImageType` BEFORE INSERT ON `imagetype` FOR EACH ROW begin 
call limitUseOfCudOperations('insert');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `limitUserOfUpdatingDataToImageType` BEFORE UPDATE ON `imagetype` FOR EACH ROW begin 
call limitUseOfCudOperations('update');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logImageTypeAfterDelete` AFTER DELETE ON `imagetype` FOR EACH ROW begin 
call saveLog('delete','imgtyp');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logImageTypeAfterInsert` AFTER INSERT ON `imagetype` FOR EACH ROW begin 
call saveLog('insert','imgtyp');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logImageTypeAfterUpdate` AFTER UPDATE ON `imagetype` FOR EACH ROW begin 
call saveLog('update','imgtyp');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `image_gallery`
--

CREATE TABLE `image_gallery` (
  `galleryId` int(10) UNSIGNED NOT NULL,
  `galleryName` varchar(50) NOT NULL,
  `galleryDateAdded` datetime NOT NULL,
  `galleryDateUpdated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `image_gallery`
--
DELIMITER $$
CREATE TRIGGER `ImageGalleryLogAfterDelete` AFTER DELETE ON `image_gallery` FOR EACH ROW begin 
call saveLog('delete','imgal');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ImageGalleryLogAfterInsert` AFTER INSERT ON `image_gallery` FOR EACH ROW begin 
call saveLog('insert','imgal');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ImageGalleryLogAfterUpdate` AFTER UPDATE ON `image_gallery` FOR EACH ROW begin 
call saveLog('update','imgal');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `img_img_gal`
--

CREATE TABLE `img_img_gal` (
  `uniqueId` int(10) UNSIGNED NOT NULL,
  `imageId` int(10) UNSIGNED NOT NULL,
  `galleryId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `img_img_gal`
--
DELIMITER $$
CREATE TRIGGER `imageInGalleryLogAfterDelete` AFTER DELETE ON `img_img_gal` FOR EACH ROW begin 
call saveLog('delete','iig');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `imageInGalleryLogAfterInsert` AFTER INSERT ON `img_img_gal` FOR EACH ROW begin 
call saveLog('insert','iig');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `imageInGalleryLogAfterUpdate` AFTER UPDATE ON `img_img_gal` FOR EACH ROW begin 
call saveLog('update','iig');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `logger_content`
--

CREATE TABLE `logger_content` (
  `idLogCon` int(10) UNSIGNED NOT NULL,
  `dbLogId` int(10) UNSIGNED NOT NULL,
  `loggerDescription` text NOT NULL,
  `userAdded` varchar(255) NOT NULL,
  `userUpdated` varchar(255) DEFAULT NULL,
  `userDeleted` varchar(255) DEFAULT NULL,
  `dateDeleted` datetime DEFAULT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `dateAdded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logger_content`
--

INSERT INTO `logger_content` (`idLogCon`, `dbLogId`, `loggerDescription`, `userAdded`, `userUpdated`, `userDeleted`, `dateDeleted`, `dateUpdated`, `dateAdded`) VALUES
(1, 1, 'New user has been added to database logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:49:42'),
(2, 1, 'New user has been added to database logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:49:42'),
(3, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(4, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(5, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(6, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(7, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(8, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(9, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(10, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(11, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(12, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(13, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(14, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(15, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(16, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(17, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(18, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(19, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(20, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(21, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(22, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(23, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(24, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(25, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(26, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(27, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(28, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(29, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(30, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(31, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(32, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(33, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(34, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(35, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(36, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(37, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(38, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(39, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(40, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(41, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(42, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(43, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(44, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(45, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(46, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(47, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(48, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(49, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(50, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(51, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(52, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(53, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(54, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(55, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(56, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:28'),
(57, 1, 'New user Starting Admin has been added', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:52'),
(58, 1, 'Added new profile detail.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-24 13:52:52'),
(59, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-02-24 13:52:52', '0000-00-00 00:00:00'),
(60, 1, 'User Starting Admin has been deleted', '', NULL, 'social_admin', '2026-02-28 13:44:22', NULL, '0000-00-00 00:00:00'),
(61, 1, 'New user Starting Admin has been added', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 13:46:21'),
(62, 1, 'Added new profile detail.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 13:46:21'),
(63, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-02-28 13:55:18', '0000-00-00 00:00:00'),
(64, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 14:20:29'),
(65, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-02-28 14:20:29', '0000-00-00 00:00:00'),
(66, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 14:33:57'),
(67, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-02-28 14:33:57', '0000-00-00 00:00:00'),
(68, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 14:43:17'),
(69, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-02-28 14:43:17', '0000-00-00 00:00:00'),
(70, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 14:45:49'),
(71, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-02-28 14:45:49', '0000-00-00 00:00:00'),
(72, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 14:47:42'),
(73, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-02-28 14:47:42', '0000-00-00 00:00:00'),
(74, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 14:48:03'),
(75, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-02-28 14:48:03', '0000-00-00 00:00:00'),
(76, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 14:51:24'),
(77, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-02-28 14:51:24', '0000-00-00 00:00:00'),
(78, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 14:56:10'),
(79, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-02-28 14:56:10', '0000-00-00 00:00:00'),
(80, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 14:56:38'),
(81, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-02-28 14:56:38', '0000-00-00 00:00:00'),
(82, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-02-28 14:58:01'),
(83, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-02-28 14:58:01', '0000-00-00 00:00:00'),
(84, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-03-02 10:12:26'),
(85, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-03-02 10:12:26', '0000-00-00 00:00:00'),
(86, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-03-02 10:25:40'),
(87, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-03-02 10:25:40', '0000-00-00 00:00:00'),
(88, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-03-03 18:59:43'),
(89, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-03-03 18:59:43', '0000-00-00 00:00:00'),
(90, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-03-03 19:28:33'),
(91, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-03-03 19:28:33', '0000-00-00 00:00:00'),
(92, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-03-03 19:37:56'),
(93, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-03-03 19:37:56', '0000-00-00 00:00:00'),
(94, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-03-05 14:17:09'),
(95, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-03-05 14:17:09', '0000-00-00 00:00:00'),
(96, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-03-05 14:17:39'),
(97, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-03-05 14:17:39', '0000-00-00 00:00:00'),
(98, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-03-07 16:38:31'),
(99, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-03-07 16:38:31', '0000-00-00 00:00:00'),
(100, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-03-07 16:39:53'),
(101, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-03-07 16:39:53', '0000-00-00 00:00:00'),
(102, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-03-09 10:18:07'),
(103, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-03-09 10:18:07', '0000-00-00 00:00:00'),
(104, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-03-09 10:23:26'),
(105, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-03-09 10:23:26', '0000-00-00 00:00:00'),
(106, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-03-09 10:24:03'),
(107, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-03-09 10:24:03', '0000-00-00 00:00:00'),
(108, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-03-09 10:24:07'),
(109, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-03-09 10:24:07', '0000-00-00 00:00:00'),
(110, 2, 'New user Mark Mark has been added', 'regular', NULL, NULL, NULL, NULL, '2026-03-20 11:09:23'),
(111, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-03-20 11:09:23'),
(112, 2, 'New user Mark Testerović has been added', 'regular', NULL, NULL, NULL, NULL, '2026-03-20 14:56:19'),
(113, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-03-20 14:56:19'),
(114, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-04 14:51:55'),
(115, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-04 14:51:55', '0000-00-00 00:00:00'),
(116, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-04 14:52:30'),
(117, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-04 14:52:30', '0000-00-00 00:00:00'),
(118, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-04 15:18:48'),
(119, 1, 'Logged in user has added new address.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-04 15:25:35'),
(120, 1, 'Username Starting Admin has been updated. New value Starting Admin', '', 'social_admin', NULL, NULL, '2026-04-04 15:25:51', '0000-00-00 00:00:00'),
(121, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-06 15:35:28'),
(122, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-06 15:35:28', '0000-00-00 00:00:00'),
(123, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-06 16:50:17'),
(124, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-06 16:50:17', '0000-00-00 00:00:00'),
(125, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-09 13:26:59'),
(126, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-09 13:26:59', '0000-00-00 00:00:00'),
(127, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-09 13:48:36'),
(128, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-09 13:48:36', '0000-00-00 00:00:00'),
(129, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-09 18:05:47'),
(130, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-09 18:05:47', '0000-00-00 00:00:00'),
(131, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-10 10:38:44'),
(132, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-10 10:38:44', '0000-00-00 00:00:00'),
(133, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-10 11:03:52'),
(134, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-10 11:03:52', '0000-00-00 00:00:00'),
(135, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-10 15:09:56'),
(136, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-10 15:09:56', '0000-00-00 00:00:00'),
(137, 1, 'Username Starting Admin has been updated. New value Glavni Admin', '', 'social_admin', NULL, NULL, '2026-04-10 15:58:55', '0000-00-00 00:00:00'),
(138, 1, 'Username Glavni Admin has been updated. New value Glavni Admin', '', 'social_admin', NULL, NULL, '2026-04-10 15:59:24', '0000-00-00 00:00:00'),
(139, 1, 'Username Glavni Admin has been updated. New value Glavni Admin', '', 'social_admin', NULL, NULL, '2026-04-10 16:06:15', '0000-00-00 00:00:00'),
(140, 1, 'Username Glavni Admin has been updated. New value Glavni Novi Admin', '', 'social_admin', NULL, NULL, '2026-04-10 16:07:58', '0000-00-00 00:00:00'),
(141, 1, 'Username Glavni Novi Admin has been updated. New value Glavni Novi Admin', '', 'social_admin', NULL, NULL, '2026-04-10 16:08:49', '0000-00-00 00:00:00'),
(142, 1, 'Username Glavni Novi Admin has been updated. New value Glavni Novi Admin', '', 'social_admin', NULL, NULL, '2026-04-10 16:09:13', '0000-00-00 00:00:00'),
(143, 1, 'Username Glavni Novi Admin has been updated. New value Joso Mafiozo jobo Admin', '', 'social_admin', NULL, NULL, '2026-04-10 16:12:29', '0000-00-00 00:00:00'),
(144, 1, 'Username Joso Mafiozo jobo Admin has been updated. New value Joso Mafiozo jobo Admin', '', 'social_admin', NULL, NULL, '2026-04-10 16:12:40', '0000-00-00 00:00:00'),
(145, 1, 'Username Joso Mafiozo jobo Admin has been updated. New value Jobo Admin', '', 'social_admin', NULL, NULL, '2026-04-10 16:14:03', '0000-00-00 00:00:00'),
(146, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-10 16:15:22'),
(147, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-10 16:15:22', '0000-00-00 00:00:00'),
(148, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 14:34:55'),
(149, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 14:34:55', '0000-00-00 00:00:00'),
(150, 1, 'Username Jobo Admin has been updated. New value  Admin', '', 'social_admin', NULL, NULL, '2026-04-11 14:50:43', '0000-00-00 00:00:00'),
(151, 1, 'Username  Admin has been updated. New value Josip Admin', '', 'social_admin', NULL, NULL, '2026-04-11 14:50:59', '0000-00-00 00:00:00'),
(152, 1, 'Username Josip Admin has been updated. New value Josip Admin', '', 'social_admin', NULL, NULL, '2026-04-11 15:05:41', '0000-00-00 00:00:00'),
(153, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-11 15:09:55'),
(154, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-11 15:09:55', '0000-00-00 00:00:00'),
(155, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 17:47:47'),
(156, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 17:47:47', '0000-00-00 00:00:00'),
(157, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-11 19:05:06'),
(158, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-11 19:05:06', '0000-00-00 00:00:00'),
(159, 2, 'New user Novi  Korisnik has been added', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:05:47'),
(160, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:05:47'),
(161, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:06:12'),
(162, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:06:12', '0000-00-00 00:00:00'),
(163, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:06:22'),
(164, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:06:22', '0000-00-00 00:00:00'),
(165, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:07:02'),
(166, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:07:02', '0000-00-00 00:00:00'),
(167, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:07:20'),
(168, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:07:20', '0000-00-00 00:00:00'),
(169, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:07:34'),
(170, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:07:34', '0000-00-00 00:00:00'),
(171, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:07:48'),
(172, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:07:48', '0000-00-00 00:00:00'),
(173, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-11 19:08:36'),
(174, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-11 19:08:36', '0000-00-00 00:00:00'),
(175, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:08:44'),
(176, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:08:44', '0000-00-00 00:00:00'),
(177, 2, 'New user Novi Korisnik has been added', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:09:35'),
(178, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:09:35'),
(179, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:09:55'),
(180, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:09:55', '0000-00-00 00:00:00'),
(181, 2, 'New user Test test has been added', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:16:47'),
(182, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:16:47'),
(183, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:17:05'),
(184, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:17:05', '0000-00-00 00:00:00'),
(185, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:23:09'),
(186, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:23:09', '0000-00-00 00:00:00'),
(187, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-11 19:23:12'),
(188, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-11 19:23:12', '0000-00-00 00:00:00'),
(189, 2, 'New user Tester Testerović has been added', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:23:35'),
(190, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:23:35'),
(191, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:23:52'),
(192, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:23:52', '0000-00-00 00:00:00'),
(193, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:25:49'),
(194, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:25:49', '0000-00-00 00:00:00'),
(195, 2, 'New user Matko Matkić has been added', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:36:44'),
(196, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:36:44'),
(197, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:36:48'),
(198, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:36:48', '0000-00-00 00:00:00'),
(199, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-11 19:37:24'),
(200, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-11 19:37:24', '0000-00-00 00:00:00'),
(201, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-12 11:28:42'),
(202, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-12 11:28:42', '0000-00-00 00:00:00'),
(203, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-12 11:51:51'),
(204, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-12 11:51:51', '0000-00-00 00:00:00'),
(205, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-13 13:16:54'),
(206, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-13 13:16:54', '0000-00-00 00:00:00'),
(207, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-13 13:42:26', '0000-00-00 00:00:00'),
(208, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-13 13:47:53', '0000-00-00 00:00:00'),
(209, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-13 13:58:08'),
(210, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-13 13:58:08', '0000-00-00 00:00:00'),
(211, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-14 18:04:03'),
(212, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-14 18:04:03', '0000-00-00 00:00:00'),
(213, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-14 18:36:00'),
(214, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-14 18:36:00', '0000-00-00 00:00:00'),
(215, 1, 'New user Maja Majić has been added', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-14 18:39:51'),
(216, 1, 'Added new profile detail.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-14 18:39:51'),
(217, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-15 14:22:43'),
(218, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-15 14:22:43', '0000-00-00 00:00:00'),
(219, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-15 14:52:01'),
(220, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-15 14:52:01', '0000-00-00 00:00:00'),
(221, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-15 14:54:30'),
(222, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-15 14:54:30', '0000-00-00 00:00:00'),
(223, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-15 15:32:40'),
(224, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-15 15:32:40', '0000-00-00 00:00:00'),
(225, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-15 15:32:40', '0000-00-00 00:00:00'),
(226, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-15 15:39:27'),
(227, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-15 15:39:27', '0000-00-00 00:00:00'),
(228, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-15 15:39:27', '0000-00-00 00:00:00'),
(229, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-15 15:49:12'),
(230, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-15 15:49:12', '0000-00-00 00:00:00'),
(231, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-15 15:49:12', '0000-00-00 00:00:00'),
(232, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-15 15:49:12', '0000-00-00 00:00:00'),
(233, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-15 15:50:22'),
(234, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-15 15:50:22', '0000-00-00 00:00:00'),
(235, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-15 15:50:22', '0000-00-00 00:00:00'),
(236, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-15 15:50:22', '0000-00-00 00:00:00'),
(237, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-18 15:45:38'),
(238, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-18 15:45:38', '0000-00-00 00:00:00'),
(239, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-18 15:57:42'),
(240, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 15:57:42', '0000-00-00 00:00:00'),
(241, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 15:57:42', '0000-00-00 00:00:00'),
(242, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 15:57:42', '0000-00-00 00:00:00'),
(243, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-18 16:04:31'),
(244, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:04:31', '0000-00-00 00:00:00'),
(245, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:04:31', '0000-00-00 00:00:00'),
(246, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:04:31', '0000-00-00 00:00:00'),
(247, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-18 16:16:13'),
(248, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:16:13', '0000-00-00 00:00:00'),
(249, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:16:13', '0000-00-00 00:00:00'),
(250, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:16:13', '0000-00-00 00:00:00'),
(251, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-18 16:26:31'),
(252, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:26:31', '0000-00-00 00:00:00'),
(253, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:26:31', '0000-00-00 00:00:00'),
(254, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:26:31', '0000-00-00 00:00:00'),
(255, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:26:53', '0000-00-00 00:00:00'),
(256, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:26:53', '0000-00-00 00:00:00'),
(257, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:31:17', '0000-00-00 00:00:00'),
(258, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:31:17', '0000-00-00 00:00:00'),
(259, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:33:53', '0000-00-00 00:00:00'),
(260, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:33:53', '0000-00-00 00:00:00'),
(261, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:34:19', '0000-00-00 00:00:00'),
(262, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 16:34:19', '0000-00-00 00:00:00'),
(263, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-18 17:06:27'),
(264, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 17:06:28', '0000-00-00 00:00:00'),
(265, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 17:06:28', '0000-00-00 00:00:00'),
(266, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-18 17:06:28', '0000-00-00 00:00:00'),
(267, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-18 17:12:45'),
(268, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-18 17:12:45', '0000-00-00 00:00:00'),
(269, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-19 10:28:41'),
(270, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-19 10:28:41', '0000-00-00 00:00:00'),
(271, 1, 'Username Josip Admin has been updated. New value Josip Admin', '', 'social_admin', NULL, NULL, '2026-04-19 11:17:17', '0000-00-00 00:00:00'),
(272, 1, 'Username Josip Admin has been updated. New value Josip Admin', '', 'social_admin', NULL, NULL, '2026-04-19 11:21:11', '0000-00-00 00:00:00'),
(273, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-20 16:39:11'),
(274, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-20 16:39:11', '0000-00-00 00:00:00'),
(275, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-20 17:39:26'),
(276, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-20 17:39:26', '0000-00-00 00:00:00'),
(277, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:05:44'),
(278, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:05:44', '0000-00-00 00:00:00'),
(279, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-29 09:06:45'),
(280, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-29 09:06:45', '0000-00-00 00:00:00'),
(281, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:07:01'),
(282, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:07:01', '0000-00-00 00:00:00'),
(283, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:07:22'),
(284, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:07:22', '0000-00-00 00:00:00'),
(285, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-29 09:16:55'),
(286, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:28:18'),
(287, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:28:18', '0000-00-00 00:00:00'),
(288, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:28:41'),
(289, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:28:41', '0000-00-00 00:00:00'),
(290, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:29:33'),
(291, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:29:33', '0000-00-00 00:00:00'),
(292, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:29:45'),
(293, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:29:45', '0000-00-00 00:00:00'),
(294, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-29 09:30:09', '0000-00-00 00:00:00'),
(295, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:30:32'),
(296, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:30:32', '0000-00-00 00:00:00'),
(297, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:30:47'),
(298, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:30:47', '0000-00-00 00:00:00'),
(299, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-29 09:32:02'),
(300, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-29 09:32:02', '0000-00-00 00:00:00'),
(301, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:32:19'),
(302, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:32:19', '0000-00-00 00:00:00'),
(303, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:32:23'),
(304, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:32:23', '0000-00-00 00:00:00'),
(305, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:33:51'),
(306, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:33:51', '0000-00-00 00:00:00'),
(307, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:34:00'),
(308, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:34:00', '0000-00-00 00:00:00'),
(309, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:37:13'),
(310, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:37:13', '0000-00-00 00:00:00'),
(311, 1, 'Database user has been updated.', '', 'social_admin', NULL, NULL, '2026-04-29 09:53:47', '0000-00-00 00:00:00'),
(312, 1, 'Database user has been updated.', '', 'social_admin', NULL, NULL, '2026-04-29 09:53:47', '0000-00-00 00:00:00'),
(313, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:54:06'),
(314, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:54:06', '0000-00-00 00:00:00'),
(315, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:54:24'),
(316, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:54:24', '0000-00-00 00:00:00'),
(317, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-29 09:55:15'),
(318, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-29 09:55:15', '0000-00-00 00:00:00'),
(319, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:55:26'),
(320, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:55:26', '0000-00-00 00:00:00'),
(321, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 09:55:39'),
(322, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 09:55:39', '0000-00-00 00:00:00'),
(323, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:05:43'),
(324, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 10:05:43', '0000-00-00 00:00:00'),
(325, 1, 'User Mark Mark has been deleted', '', NULL, 'social_admin', '2026-04-29 10:06:04', NULL, '0000-00-00 00:00:00'),
(326, 1, 'User Mark Testerović has been deleted', '', NULL, 'social_admin', '2026-04-29 10:06:04', NULL, '0000-00-00 00:00:00'),
(327, 1, 'User Novi  Korisnik has been deleted', '', NULL, 'social_admin', '2026-04-29 10:06:04', NULL, '0000-00-00 00:00:00'),
(328, 1, 'User Novi Korisnik has been deleted', '', NULL, 'social_admin', '2026-04-29 10:06:04', NULL, '0000-00-00 00:00:00'),
(329, 1, 'User Test test has been deleted', '', NULL, 'social_admin', '2026-04-29 10:06:04', NULL, '0000-00-00 00:00:00'),
(330, 1, 'User Tester Testerović has been deleted', '', NULL, 'social_admin', '2026-04-29 10:06:04', NULL, '0000-00-00 00:00:00'),
(331, 1, 'User Matko Matkić has been deleted', '', NULL, 'social_admin', '2026-04-29 10:06:04', NULL, '0000-00-00 00:00:00'),
(332, 1, 'User Maja Majić has been deleted', '', NULL, 'social_admin', '2026-04-29 10:06:04', NULL, '0000-00-00 00:00:00'),
(333, 2, 'New user Novi Korisnik has been added', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:07:08'),
(334, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:07:08'),
(335, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:07:12'),
(336, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 10:07:12', '0000-00-00 00:00:00'),
(337, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:11:21'),
(338, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 10:11:21', '0000-00-00 00:00:00'),
(339, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:11:31'),
(340, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 10:11:31', '0000-00-00 00:00:00'),
(341, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-29 10:12:03'),
(342, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-29 10:12:03', '0000-00-00 00:00:00'),
(343, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:12:21'),
(344, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 10:12:21', '0000-00-00 00:00:00'),
(345, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:16:54'),
(346, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 10:16:54', '0000-00-00 00:00:00'),
(347, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:17:14'),
(348, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 10:17:14', '0000-00-00 00:00:00'),
(349, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-29 10:17:26'),
(350, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-29 10:17:26', '0000-00-00 00:00:00'),
(351, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:18:28'),
(352, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 10:18:28', '0000-00-00 00:00:00'),
(353, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-29 10:21:05'),
(354, 1, 'Username Novi Korisnik has been updated. New value Novi Korisnik', '', 'social_admin', NULL, NULL, '2026-04-29 10:22:06', '0000-00-00 00:00:00'),
(355, 2, 'New image has been uploaded.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:37:25'),
(356, 2, 'Image has been updated.', '', 'regular', NULL, NULL, '2026-04-29 10:37:25', '0000-00-00 00:00:00'),
(357, 2, 'Image has been updated.', '', 'regular', NULL, NULL, '2026-04-29 10:37:25', '0000-00-00 00:00:00'),
(358, 2, 'Image has been updated.', '', 'regular', NULL, NULL, '2026-04-29 10:37:25', '0000-00-00 00:00:00'),
(359, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:37:31'),
(360, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 10:37:31', '0000-00-00 00:00:00'),
(361, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-29 10:37:41'),
(362, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-29 10:37:41', '0000-00-00 00:00:00'),
(363, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-29 10:37:48'),
(364, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-29 10:37:48', '0000-00-00 00:00:00'),
(365, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-30 15:00:12'),
(366, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-30 15:00:12', '0000-00-00 00:00:00'),
(367, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-30 15:04:58'),
(368, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-30 15:04:58', '0000-00-00 00:00:00'),
(369, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-30 15:05:03'),
(370, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-30 15:05:03', '0000-00-00 00:00:00'),
(371, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-30 15:05:18'),
(372, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-30 15:05:18', '0000-00-00 00:00:00'),
(373, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-30 15:05:30'),
(374, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-30 15:05:30', '0000-00-00 00:00:00'),
(375, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-30 15:25:26'),
(376, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-30 15:25:26', '0000-00-00 00:00:00'),
(377, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-30 15:25:42'),
(378, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-30 15:25:42', '0000-00-00 00:00:00'),
(379, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-30 15:27:32'),
(380, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-30 15:27:32', '0000-00-00 00:00:00'),
(381, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-04-30 15:28:08'),
(382, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-04-30 15:28:08', '0000-00-00 00:00:00'),
(383, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-30 15:33:16'),
(384, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-30 15:33:16', '0000-00-00 00:00:00'),
(385, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-30 15:33:16', '0000-00-00 00:00:00'),
(386, 1, 'Image has been updated.', '', 'social_admin', NULL, NULL, '2026-04-30 15:33:16', '0000-00-00 00:00:00'),
(387, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-04-30 15:34:19'),
(388, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-04-30 15:34:19', '0000-00-00 00:00:00'),
(389, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-03 16:02:53'),
(390, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-03 16:02:53', '0000-00-00 00:00:00'),
(391, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-03 16:28:05'),
(392, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-03 16:28:05', '0000-00-00 00:00:00'),
(393, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-04 13:07:08'),
(394, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-04 13:07:08', '0000-00-00 00:00:00'),
(395, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-04 14:18:42'),
(396, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-04 14:18:42', '0000-00-00 00:00:00'),
(397, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-04 14:19:00'),
(398, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-04 14:19:00', '0000-00-00 00:00:00'),
(399, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-04 14:55:11'),
(400, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-04 14:55:11', '0000-00-00 00:00:00'),
(401, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-05 13:37:27'),
(402, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-05 13:37:27', '0000-00-00 00:00:00'),
(403, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-05 13:40:49'),
(404, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-05 13:40:49', '0000-00-00 00:00:00'),
(405, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-05 13:41:06'),
(406, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-05 13:41:06', '0000-00-00 00:00:00'),
(407, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-05 13:42:55'),
(408, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-05 13:42:55', '0000-00-00 00:00:00'),
(409, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-05 14:38:34'),
(410, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-05 14:38:54'),
(411, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-05 14:38:54', '0000-00-00 00:00:00'),
(412, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-05 14:39:13'),
(413, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-05 14:39:13', '0000-00-00 00:00:00'),
(414, 2, 'Logged in user has added new state', 'regular', NULL, NULL, NULL, NULL, '2026-05-05 14:39:41'),
(415, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-05 14:40:22'),
(416, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-05 14:40:22', '0000-00-00 00:00:00'),
(417, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-07 13:06:04'),
(418, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-07 13:06:04', '0000-00-00 00:00:00'),
(419, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-07 14:45:29'),
(420, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-07 14:47:29'),
(421, 1, 'Logged in user has deleted a city', '', NULL, 'social_admin', '2026-05-07 14:50:57', NULL, '0000-00-00 00:00:00'),
(422, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-07 14:51:03');
INSERT INTO `logger_content` (`idLogCon`, `dbLogId`, `loggerDescription`, `userAdded`, `userUpdated`, `userDeleted`, `dateDeleted`, `dateUpdated`, `dateAdded`) VALUES
(423, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-07 14:51:03', '0000-00-00 00:00:00'),
(424, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-08 13:01:30'),
(425, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-08 13:01:30', '0000-00-00 00:00:00'),
(426, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-08 13:01:56'),
(427, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-08 13:07:43'),
(428, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-08 13:09:27'),
(429, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-08 13:13:03'),
(430, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-08 13:15:06'),
(431, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-08 13:15:06', '0000-00-00 00:00:00'),
(432, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-11 16:04:40'),
(433, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-11 16:04:40', '0000-00-00 00:00:00'),
(434, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:13:03'),
(435, 1, 'Logged in user has deleted a state', '', NULL, 'social_admin', '2026-05-11 16:13:20', NULL, '0000-00-00 00:00:00'),
(436, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:13:28'),
(437, 1, 'Logged in user has deleted a state', '', NULL, 'social_admin', '2026-05-11 16:13:44', NULL, '0000-00-00 00:00:00'),
(438, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:16:19'),
(439, 1, 'Logged in user has deleted a state', '', NULL, 'social_admin', '2026-05-11 16:16:28', NULL, '0000-00-00 00:00:00'),
(440, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:16:42'),
(441, 1, 'Logged in user has deleted a city', '', NULL, 'social_admin', '2026-05-11 16:16:57', NULL, '0000-00-00 00:00:00'),
(442, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:18:55'),
(443, 1, 'Logged in user has deleted a state', '', NULL, 'social_admin', '2026-05-11 16:19:12', NULL, '0000-00-00 00:00:00'),
(444, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:28:51'),
(445, 1, 'Logged in user has deleted a city', '', NULL, 'social_admin', '2026-05-11 16:29:09', NULL, '0000-00-00 00:00:00'),
(446, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:36:05'),
(447, 1, 'Logged in user has deleted a city', '', NULL, 'social_admin', '2026-05-11 16:36:15', NULL, '0000-00-00 00:00:00'),
(448, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:39:03'),
(449, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:39:05'),
(450, 1, 'Logged in user has deleted a state', '', NULL, 'social_admin', '2026-05-11 16:39:19', NULL, '0000-00-00 00:00:00'),
(451, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:39:33'),
(452, 1, 'Logged in user has deleted a state', '', NULL, 'social_admin', '2026-05-11 16:39:55', NULL, '0000-00-00 00:00:00'),
(453, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:42:09'),
(454, 1, 'Logged in user has deleted a state', '', NULL, 'social_admin', '2026-05-11 16:42:29', NULL, '0000-00-00 00:00:00'),
(455, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:42:38'),
(456, 1, 'Logged in user has deleted a state', '', NULL, 'social_admin', '2026-05-11 16:42:51', NULL, '0000-00-00 00:00:00'),
(457, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 16:45:59'),
(458, 1, 'Logged in user has deleted a state', '', NULL, 'social_admin', '2026-05-11 16:46:22', NULL, '0000-00-00 00:00:00'),
(459, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 17:02:43'),
(460, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 17:31:43'),
(461, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 17:45:30'),
(462, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 17:46:06'),
(463, 1, 'Logged in user has deleted a state', '', NULL, 'social_admin', '2026-05-11 17:46:49', NULL, '0000-00-00 00:00:00'),
(464, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 17:46:54'),
(465, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 17:47:20'),
(466, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 17:48:32'),
(467, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 17:48:35'),
(468, 1, 'Logged in user has added new state', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 17:50:05'),
(469, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-11 17:50:35'),
(470, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-11 17:50:35', '0000-00-00 00:00:00'),
(471, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-12 20:10:03'),
(472, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-12 20:10:03', '0000-00-00 00:00:00'),
(473, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-12 20:10:20'),
(474, 1, 'Logged in user has deleted a city', '', NULL, 'social_admin', '2026-05-12 20:14:21', NULL, '0000-00-00 00:00:00'),
(475, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-12 20:14:30'),
(476, 1, 'Logged in user has deleted a city', '', NULL, 'social_admin', '2026-05-12 20:14:45', NULL, '0000-00-00 00:00:00'),
(477, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-12 21:30:07'),
(478, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-12 21:30:21'),
(479, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-12 21:30:32'),
(480, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-12 21:30:52'),
(481, 1, 'Logged in user has deleted a city', '', NULL, 'social_admin', '2026-05-12 21:41:17', NULL, '0000-00-00 00:00:00'),
(482, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-12 21:42:37'),
(483, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-12 21:44:05'),
(484, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-14 08:42:07'),
(485, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-14 08:42:07', '0000-00-00 00:00:00'),
(486, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-14 09:46:32'),
(487, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-14 09:49:20'),
(488, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-14 09:52:59'),
(489, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-14 09:53:41'),
(490, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-14 09:54:46'),
(491, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-14 09:54:46', '0000-00-00 00:00:00'),
(492, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 09:22:28'),
(493, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 09:22:28', '0000-00-00 00:00:00'),
(494, 1, 'Logged in user has added new city.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 09:23:27'),
(495, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 10:26:53'),
(496, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 10:26:53', '0000-00-00 00:00:00'),
(497, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 10:48:58'),
(498, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 10:48:58', '0000-00-00 00:00:00'),
(499, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 10:49:14'),
(500, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 10:49:14', '0000-00-00 00:00:00'),
(501, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 10:49:44'),
(502, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 10:49:44', '0000-00-00 00:00:00'),
(503, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 10:49:55'),
(504, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 10:49:55', '0000-00-00 00:00:00'),
(505, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 10:51:11'),
(506, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 10:51:11', '0000-00-00 00:00:00'),
(507, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 10:51:41'),
(508, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 10:51:41', '0000-00-00 00:00:00'),
(509, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 10:57:05'),
(510, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 10:57:05', '0000-00-00 00:00:00'),
(511, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 10:57:21'),
(512, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 10:57:21', '0000-00-00 00:00:00'),
(513, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 11:05:48'),
(514, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 11:05:48', '0000-00-00 00:00:00'),
(515, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 11:05:58'),
(516, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 11:05:58', '0000-00-00 00:00:00'),
(517, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 11:08:12'),
(518, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 11:08:12', '0000-00-00 00:00:00'),
(519, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 11:08:21'),
(520, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 11:08:21', '0000-00-00 00:00:00'),
(521, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 11:15:00'),
(522, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 11:15:00', '0000-00-00 00:00:00'),
(523, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 11:15:07'),
(524, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 11:15:07', '0000-00-00 00:00:00'),
(525, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 11:34:03'),
(526, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 11:34:03', '0000-00-00 00:00:00'),
(527, 2, 'New user Novi Korisnik has been added', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 11:37:44'),
(528, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 11:37:44'),
(529, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 11:37:48'),
(530, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 11:37:48', '0000-00-00 00:00:00'),
(531, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 11:39:34'),
(532, 1, 'Username Novi Korisnik has been updated. New value Novi Korisnik', '', 'social_admin', NULL, NULL, '2026-05-15 12:06:41', '0000-00-00 00:00:00'),
(533, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 12:19:15'),
(534, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 12:19:15', '0000-00-00 00:00:00'),
(535, 2, 'New user Mark Mark has been added', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 12:19:32'),
(536, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 12:19:32'),
(537, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 12:19:36'),
(538, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 12:19:36', '0000-00-00 00:00:00'),
(539, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 12:48:22'),
(540, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 12:48:22', '0000-00-00 00:00:00'),
(541, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 12:51:22'),
(542, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 12:51:22', '0000-00-00 00:00:00'),
(543, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 12:52:38'),
(544, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 12:52:38', '0000-00-00 00:00:00'),
(545, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:01:44'),
(546, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:01:44', '0000-00-00 00:00:00'),
(547, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:10:15'),
(548, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:10:15', '0000-00-00 00:00:00'),
(549, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:10:22'),
(550, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:10:22', '0000-00-00 00:00:00'),
(551, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 13:11:22'),
(552, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 13:11:22', '0000-00-00 00:00:00'),
(553, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:11:34'),
(554, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:11:34', '0000-00-00 00:00:00'),
(555, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:24:37'),
(556, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:24:37', '0000-00-00 00:00:00'),
(557, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:28:10'),
(558, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:28:10', '0000-00-00 00:00:00'),
(559, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 13:32:43'),
(560, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 13:32:43', '0000-00-00 00:00:00'),
(561, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:32:51'),
(562, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:32:51', '0000-00-00 00:00:00'),
(563, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 13:33:16'),
(564, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 13:33:16', '0000-00-00 00:00:00'),
(565, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:33:30'),
(566, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:33:30', '0000-00-00 00:00:00'),
(567, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:49:08'),
(568, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:49:08', '0000-00-00 00:00:00'),
(569, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:49:24'),
(570, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:49:24', '0000-00-00 00:00:00'),
(571, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:49:33'),
(572, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:49:33', '0000-00-00 00:00:00'),
(573, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 13:52:50'),
(574, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 13:52:50', '0000-00-00 00:00:00'),
(575, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:53:03'),
(576, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:53:03', '0000-00-00 00:00:00'),
(577, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 13:54:57'),
(578, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 13:54:57', '0000-00-00 00:00:00'),
(579, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:55:12'),
(580, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:55:12', '0000-00-00 00:00:00'),
(581, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:57:42'),
(582, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:57:42', '0000-00-00 00:00:00'),
(583, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:57:49'),
(584, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:57:49', '0000-00-00 00:00:00'),
(585, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 13:57:59'),
(586, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 13:57:59', '0000-00-00 00:00:00'),
(587, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 14:03:19'),
(588, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 14:03:19', '0000-00-00 00:00:00'),
(589, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:03:31'),
(590, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:03:31', '0000-00-00 00:00:00'),
(591, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:04:29'),
(592, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:04:29', '0000-00-00 00:00:00'),
(593, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:04:42'),
(594, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:04:42', '0000-00-00 00:00:00'),
(595, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 14:08:54'),
(596, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 14:08:54', '0000-00-00 00:00:00'),
(597, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:09:07'),
(598, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:09:07', '0000-00-00 00:00:00'),
(599, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:12:58'),
(600, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:12:58', '0000-00-00 00:00:00'),
(601, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:13:15'),
(602, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:13:15', '0000-00-00 00:00:00'),
(603, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:13:23'),
(604, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:13:23', '0000-00-00 00:00:00'),
(605, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 14:13:29'),
(606, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 14:13:29', '0000-00-00 00:00:00'),
(607, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:13:48'),
(608, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:13:48', '0000-00-00 00:00:00'),
(609, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:16:28'),
(610, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:16:28', '0000-00-00 00:00:00'),
(611, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:16:40'),
(612, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:16:40', '0000-00-00 00:00:00'),
(613, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:16:55'),
(614, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:16:55', '0000-00-00 00:00:00'),
(615, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-15 14:17:03'),
(616, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-15 14:17:03', '0000-00-00 00:00:00'),
(617, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:17:16'),
(618, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:17:16', '0000-00-00 00:00:00'),
(619, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-15 14:18:42'),
(620, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-15 14:18:42', '0000-00-00 00:00:00'),
(621, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-17 11:02:55'),
(622, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-17 11:02:55', '0000-00-00 00:00:00'),
(623, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-17 11:20:18'),
(624, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-17 11:20:18', '0000-00-00 00:00:00'),
(625, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-17 11:20:33'),
(626, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-17 11:20:33', '0000-00-00 00:00:00'),
(627, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-17 11:24:43'),
(628, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-17 11:24:43', '0000-00-00 00:00:00'),
(629, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-17 11:25:02'),
(630, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-17 11:25:02', '0000-00-00 00:00:00'),
(631, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-17 11:32:19'),
(632, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-17 11:32:19', '0000-00-00 00:00:00'),
(633, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-17 11:32:30'),
(634, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-17 11:32:30', '0000-00-00 00:00:00'),
(635, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-17 11:32:38'),
(636, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-17 11:32:38', '0000-00-00 00:00:00'),
(637, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-17 11:32:56'),
(638, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-17 11:32:56', '0000-00-00 00:00:00'),
(639, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-19 13:45:48'),
(640, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-19 13:45:48', '0000-00-00 00:00:00'),
(641, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-19 13:46:31'),
(642, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-19 13:46:31', '0000-00-00 00:00:00'),
(643, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-19 13:47:13'),
(644, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-19 13:47:13', '0000-00-00 00:00:00'),
(645, 2, 'New image has been uploaded.', 'regular', NULL, NULL, NULL, NULL, '2026-05-19 14:12:25'),
(646, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-19 14:17:19'),
(647, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-19 14:17:19', '0000-00-00 00:00:00'),
(648, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-19 14:17:30'),
(649, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-19 14:17:30', '0000-00-00 00:00:00'),
(650, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-19 14:18:30'),
(651, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-19 14:18:30', '0000-00-00 00:00:00'),
(652, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-19 14:18:46'),
(653, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-19 14:18:46', '0000-00-00 00:00:00'),
(654, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-19 14:21:05'),
(655, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-19 14:21:05', '0000-00-00 00:00:00'),
(656, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 14:45:09'),
(657, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 14:45:09', '0000-00-00 00:00:00'),
(658, 2, 'Logged in user has added new state', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 14:59:54'),
(659, 2, 'Logged in user has added new state', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 15:00:19'),
(660, 2, 'Logged in user has added new state', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 15:04:33'),
(661, 2, 'Logged in user has added new state', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 15:05:03'),
(662, 2, 'Logged in user has added new state', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 15:06:43'),
(663, 2, 'Logged in user has added new state', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 15:07:49'),
(664, 2, 'Logged in user has added new address.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 15:45:03'),
(665, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 15:45:54'),
(666, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 15:45:54', '0000-00-00 00:00:00'),
(667, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 15:46:10'),
(668, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 15:46:10', '0000-00-00 00:00:00'),
(669, 1, 'Username Mark Mark has been updated. New value Mark Mark', '', 'social_admin', NULL, NULL, '2026-05-20 16:13:25', '0000-00-00 00:00:00'),
(670, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:30:34'),
(671, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 16:30:34', '0000-00-00 00:00:00'),
(672, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:30:52'),
(673, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 16:30:52', '0000-00-00 00:00:00'),
(674, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:31:00'),
(675, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 16:31:00', '0000-00-00 00:00:00'),
(676, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-20 16:31:09'),
(677, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-20 16:31:09', '0000-00-00 00:00:00'),
(678, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:31:19'),
(679, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 16:31:19', '0000-00-00 00:00:00'),
(680, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:40:57'),
(681, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 16:40:57', '0000-00-00 00:00:00'),
(682, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:41:03'),
(683, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 16:41:03', '0000-00-00 00:00:00'),
(684, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:41:11'),
(685, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 16:41:11', '0000-00-00 00:00:00'),
(686, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:47:36'),
(687, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 16:47:36', '0000-00-00 00:00:00'),
(688, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:58:07'),
(689, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 16:58:07', '0000-00-00 00:00:00'),
(690, 2, 'New user Josip Bošnjak has been added', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:59:21'),
(691, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:59:21'),
(692, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:59:25'),
(693, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 16:59:25', '0000-00-00 00:00:00'),
(694, 2, 'New image has been uploaded.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:59:35'),
(695, 2, 'Logged in user has added new address.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 16:59:46'),
(696, 1, 'Username Josip Bošnjak has been updated. New value Josip Bošnjak', '', 'social_admin', NULL, NULL, '2026-05-20 17:00:16', '0000-00-00 00:00:00'),
(697, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-20 17:00:22'),
(698, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-20 17:00:22', '0000-00-00 00:00:00'),
(699, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 08:59:42'),
(700, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-21 08:59:42', '0000-00-00 00:00:00'),
(701, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-21 09:05:08'),
(702, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-21 09:05:08', '0000-00-00 00:00:00'),
(703, 2, 'New user Donald Trumop has been added', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 09:05:41'),
(704, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 09:05:41'),
(705, 1, 'Username Josip Admin has been updated. New value Josip Admin', '', 'social_admin', NULL, NULL, '2026-05-21 09:07:43', '0000-00-00 00:00:00'),
(706, 1, 'Username Novi Korisnik has been updated. New value Novi Korisnik', '', 'social_admin', NULL, NULL, '2026-05-21 09:07:43', '0000-00-00 00:00:00'),
(707, 1, 'Username Novi Korisnik has been updated. New value Novi Korisnik', '', 'social_admin', NULL, NULL, '2026-05-21 09:07:43', '0000-00-00 00:00:00'),
(708, 1, 'Username Mark Mark has been updated. New value Mark Mark', '', 'social_admin', NULL, NULL, '2026-05-21 09:07:43', '0000-00-00 00:00:00'),
(709, 1, 'Username Josip Bošnjak has been updated. New value Josip Bošnjak', '', 'social_admin', NULL, NULL, '2026-05-21 09:07:43', '0000-00-00 00:00:00'),
(710, 1, 'Username Donald Trumop has been updated. New value Donald Trumop', '', 'social_admin', NULL, NULL, '2026-05-21 09:07:43', '0000-00-00 00:00:00'),
(711, 1, 'Username Donald Trumop has been updated. New value Donald Trumop', '', 'social_admin', NULL, NULL, '2026-05-21 09:11:30', '0000-00-00 00:00:00'),
(712, 2, 'New user Nu Nu has been added', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 09:24:22'),
(713, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 09:24:22'),
(714, 1, 'Username Nu Nu has been updated. New value Nu Nu', '', 'social_admin', NULL, NULL, '2026-05-21 09:41:46', '0000-00-00 00:00:00'),
(715, 2, 'New user Melania Bitch has been added', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 09:46:25'),
(716, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 09:46:25'),
(717, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 09:47:24'),
(718, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-21 09:47:24', '0000-00-00 00:00:00'),
(719, 2, 'Logged in user has added new address.', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 09:47:39'),
(720, 2, 'Username Melania Bitch has been updated. New value Melania Bitch', '', 'regular', NULL, NULL, '2026-05-21 09:47:39', '0000-00-00 00:00:00'),
(721, 1, 'New image has been uploaded.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-21 09:48:44'),
(722, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 09:48:53'),
(723, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-21 09:48:53', '0000-00-00 00:00:00'),
(724, 1, 'Image has been deleted.', '', NULL, 'social_admin', '2026-05-21 09:49:17', NULL, '0000-00-00 00:00:00'),
(725, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 09:49:34'),
(726, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-21 09:49:34', '0000-00-00 00:00:00'),
(727, 2, 'New image has been uploaded.', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 10:05:20'),
(728, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-21 10:06:50'),
(729, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-21 10:06:50', '0000-00-00 00:00:00'),
(730, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-22 09:24:52'),
(731, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-22 09:24:52', '0000-00-00 00:00:00'),
(732, 1, 'Logged in user has added new address.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-22 13:26:50'),
(733, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-22 13:51:34'),
(734, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-22 13:51:34', '0000-00-00 00:00:00'),
(735, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-24 18:39:36'),
(736, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-24 18:39:36', '0000-00-00 00:00:00'),
(737, 1, 'Logged in user has added new address.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-24 18:43:13'),
(738, 1, 'Logged in user has added new address.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-24 18:58:08'),
(739, 1, 'Username Josip Admin has been updated. New value Josip Admin', '', 'social_admin', NULL, NULL, '2026-05-24 19:17:17', '0000-00-00 00:00:00'),
(740, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-24 19:17:52'),
(741, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-24 19:17:52', '0000-00-00 00:00:00'),
(742, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-24 19:17:57'),
(743, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-24 19:17:57', '0000-00-00 00:00:00'),
(744, 2, 'Logged in user has added new address.', 'regular', NULL, NULL, NULL, NULL, '2026-05-24 19:18:22'),
(745, 2, 'Username Novi Korisnik has been updated. New value Novi Korisnik', '', 'regular', NULL, NULL, '2026-05-24 19:18:33', '0000-00-00 00:00:00'),
(746, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-24 19:18:41'),
(747, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-24 19:18:41', '0000-00-00 00:00:00'),
(748, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-25 13:42:58'),
(749, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-25 13:42:58', '0000-00-00 00:00:00'),
(750, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-25 14:17:15'),
(751, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-25 14:17:15', '0000-00-00 00:00:00'),
(752, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-25 14:17:30'),
(753, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-25 14:17:30', '0000-00-00 00:00:00'),
(754, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-25 14:17:35'),
(755, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-25 14:17:35', '0000-00-00 00:00:00'),
(756, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-25 14:17:43'),
(757, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-25 14:17:43', '0000-00-00 00:00:00'),
(758, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-25 14:47:32'),
(759, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-25 14:47:32', '0000-00-00 00:00:00'),
(760, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-26 12:24:35'),
(761, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-26 12:24:35', '0000-00-00 00:00:00'),
(762, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-26 16:13:06'),
(763, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-26 16:13:06', '0000-00-00 00:00:00'),
(764, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-28 13:07:42'),
(765, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-28 13:07:42', '0000-00-00 00:00:00'),
(766, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-28 13:45:32'),
(767, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-28 13:45:32', '0000-00-00 00:00:00'),
(768, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-05-31 10:09:16'),
(769, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-05-31 10:09:16', '0000-00-00 00:00:00'),
(770, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-05-31 11:21:55'),
(771, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-05-31 11:21:55', '0000-00-00 00:00:00'),
(772, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-03 14:14:50'),
(773, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-03 14:14:50', '0000-00-00 00:00:00'),
(774, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-03 14:34:54'),
(775, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-03 14:34:54', '0000-00-00 00:00:00'),
(776, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-04 10:05:56'),
(777, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-04 10:05:56', '0000-00-00 00:00:00'),
(778, 1, 'Username Josip Admin has been updated. New value Josip Admin', '', 'social_admin', NULL, NULL, '2026-06-04 12:09:06', '0000-00-00 00:00:00'),
(779, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-04 12:19:46'),
(780, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-04 12:19:46', '0000-00-00 00:00:00'),
(781, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-04 12:19:56'),
(782, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-04 12:19:56', '0000-00-00 00:00:00'),
(783, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-04 12:20:32'),
(784, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-04 12:20:32', '0000-00-00 00:00:00'),
(785, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-04 12:20:52'),
(786, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-04 12:20:52', '0000-00-00 00:00:00'),
(787, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-04 12:49:07'),
(788, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-04 12:49:07', '0000-00-00 00:00:00'),
(789, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-09 08:49:28'),
(790, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-09 08:49:28', '0000-00-00 00:00:00'),
(791, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-09 08:51:57'),
(792, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-09 08:51:57', '0000-00-00 00:00:00'),
(793, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-09 08:52:09'),
(794, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-09 08:52:09', '0000-00-00 00:00:00'),
(795, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-09 08:52:55'),
(796, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-09 08:52:55', '0000-00-00 00:00:00'),
(797, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-09 08:53:07'),
(798, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-09 08:53:07', '0000-00-00 00:00:00'),
(799, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-09 08:56:13'),
(800, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-09 08:56:13', '0000-00-00 00:00:00'),
(801, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-09 08:56:21'),
(802, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-09 08:56:21', '0000-00-00 00:00:00'),
(803, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-09 11:11:42'),
(804, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-09 11:11:42', '0000-00-00 00:00:00'),
(805, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-10 12:59:20'),
(806, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-10 12:59:20', '0000-00-00 00:00:00'),
(807, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-10 13:29:23'),
(808, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-10 13:29:23', '0000-00-00 00:00:00'),
(809, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-10 13:29:48'),
(810, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-10 13:29:48', '0000-00-00 00:00:00'),
(811, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-10 13:30:01'),
(812, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-10 13:30:01', '0000-00-00 00:00:00'),
(813, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-10 14:12:48'),
(814, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-10 14:12:48', '0000-00-00 00:00:00'),
(815, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-12 21:15:32'),
(816, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-12 21:15:32', '0000-00-00 00:00:00'),
(817, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-12 23:28:45'),
(818, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-12 23:28:45', '0000-00-00 00:00:00'),
(819, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-12 23:43:23'),
(820, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-12 23:43:23', '0000-00-00 00:00:00'),
(821, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-12 23:43:30'),
(822, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-12 23:43:30', '0000-00-00 00:00:00'),
(823, 2, 'New user Tester Testerović has been added', 'regular', NULL, NULL, NULL, NULL, '2026-06-12 23:53:42'),
(824, 2, 'Added new profile detail.', 'regular', NULL, NULL, NULL, NULL, '2026-06-12 23:53:42'),
(825, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-12 23:53:46'),
(826, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-12 23:53:46', '0000-00-00 00:00:00'),
(827, 2, 'New image has been uploaded.', 'regular', NULL, NULL, NULL, NULL, '2026-06-12 23:53:58'),
(828, 2, 'Logged in user has added new address.', 'regular', NULL, NULL, NULL, NULL, '2026-06-12 23:54:13'),
(829, 2, 'Username Tester Testerović has been updated. New value Tester Testerović', '', 'regular', NULL, NULL, '2026-06-12 23:54:13', '0000-00-00 00:00:00'),
(830, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-12 23:54:21'),
(831, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-12 23:54:21', '0000-00-00 00:00:00'),
(832, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-14 14:03:42'),
(833, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-14 14:03:42', '0000-00-00 00:00:00'),
(834, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-14 14:40:14'),
(835, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-14 14:40:14', '0000-00-00 00:00:00'),
(836, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-17 17:12:00'),
(837, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-17 17:12:00', '0000-00-00 00:00:00'),
(838, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-17 19:03:46'),
(839, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-17 19:03:46', '0000-00-00 00:00:00'),
(840, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-19 12:43:44');
INSERT INTO `logger_content` (`idLogCon`, `dbLogId`, `loggerDescription`, `userAdded`, `userUpdated`, `userDeleted`, `dateDeleted`, `dateUpdated`, `dateAdded`) VALUES
(841, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-19 12:43:44', '0000-00-00 00:00:00'),
(842, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-19 13:28:29'),
(843, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-19 13:28:29', '0000-00-00 00:00:00'),
(844, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-21 14:27:18'),
(845, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-21 14:27:18', '0000-00-00 00:00:00'),
(846, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-21 14:27:52'),
(847, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-21 14:27:52', '0000-00-00 00:00:00'),
(848, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-23 22:12:45'),
(849, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-23 22:12:45', '0000-00-00 00:00:00'),
(850, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-24 00:25:13'),
(851, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-24 00:25:13', '0000-00-00 00:00:00'),
(852, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-24 00:25:26'),
(853, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-24 00:25:26', '0000-00-00 00:00:00'),
(854, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-24 00:51:59'),
(855, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-24 00:51:59', '0000-00-00 00:00:00'),
(856, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-24 00:52:11'),
(857, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-24 00:52:11', '0000-00-00 00:00:00'),
(858, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-24 00:57:31'),
(859, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-24 00:57:31', '0000-00-00 00:00:00'),
(860, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-06-30 13:02:22'),
(861, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-06-30 13:02:22', '0000-00-00 00:00:00'),
(862, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-06-30 13:56:47'),
(863, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-06-30 13:56:47', '0000-00-00 00:00:00'),
(864, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-07-04 13:33:29'),
(865, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-07-04 13:33:29', '0000-00-00 00:00:00'),
(866, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-07-04 13:57:42'),
(867, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-07-04 13:57:42', '0000-00-00 00:00:00'),
(868, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-07-09 11:42:29'),
(869, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-07-09 11:42:29', '0000-00-00 00:00:00'),
(870, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-07-09 12:22:38'),
(871, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-07-09 12:22:38', '0000-00-00 00:00:00'),
(872, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-07-09 12:24:42'),
(873, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-07-09 12:24:42', '0000-00-00 00:00:00'),
(874, 1, 'Logged in user has added new address.', 'social_admin', NULL, NULL, NULL, NULL, '2026-07-09 12:25:42'),
(875, 1, 'Username Josip Admin has been updated. New value Josip Admin', '', 'social_admin', NULL, NULL, '2026-07-09 12:25:58', '0000-00-00 00:00:00'),
(876, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-07-09 12:30:02'),
(877, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-07-09 12:30:02', '0000-00-00 00:00:00'),
(878, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-07-11 13:37:31'),
(879, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-07-11 13:37:31', '0000-00-00 00:00:00'),
(880, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-07-11 15:05:36'),
(881, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-07-11 15:05:36', '0000-00-00 00:00:00'),
(882, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-07-11 15:05:46'),
(883, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-07-11 15:05:46', '0000-00-00 00:00:00'),
(884, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-07-11 15:05:56'),
(885, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-07-11 15:05:56', '0000-00-00 00:00:00'),
(886, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-07-11 15:06:39'),
(887, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-07-11 15:06:39', '0000-00-00 00:00:00'),
(888, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-07-19 08:52:18'),
(889, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-07-19 08:52:18', '0000-00-00 00:00:00'),
(890, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-07-19 09:46:34'),
(891, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-07-19 09:46:34', '0000-00-00 00:00:00'),
(892, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-07-20 16:37:58'),
(893, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-07-20 16:37:58', '0000-00-00 00:00:00'),
(894, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 17:07:15', '0000-00-00 00:00:00'),
(895, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 17:13:06', '0000-00-00 00:00:00'),
(896, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 17:17:47', '0000-00-00 00:00:00'),
(897, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 17:46:25', '0000-00-00 00:00:00'),
(898, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 17:50:34', '0000-00-00 00:00:00'),
(899, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 17:55:33', '0000-00-00 00:00:00'),
(900, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 18:04:57', '0000-00-00 00:00:00'),
(901, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 18:07:30', '0000-00-00 00:00:00'),
(902, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 18:14:35', '0000-00-00 00:00:00'),
(903, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 18:14:44', '0000-00-00 00:00:00'),
(904, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-20 18:14:56', '0000-00-00 00:00:00'),
(905, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-07-20 18:14:59'),
(906, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-07-20 18:14:59', '0000-00-00 00:00:00'),
(907, 2, 'New user has been added to profile logger.', 'regular', NULL, NULL, NULL, NULL, '2026-07-24 15:06:37'),
(908, 2, 'User has been updated from profile logger', '', 'regular', NULL, NULL, '2026-07-24 15:06:37', '0000-00-00 00:00:00'),
(909, 1, 'Updated profile detail.', '', 'social_admin', NULL, NULL, '2026-07-24 15:07:03', '0000-00-00 00:00:00'),
(910, 1, 'New user has been added to profile logger.', 'social_admin', NULL, NULL, NULL, NULL, '2026-07-24 15:39:02'),
(911, 1, 'User has been updated from profile logger', '', 'social_admin', NULL, NULL, '2026-07-24 15:39:02', '0000-00-00 00:00:00');

--
-- Triggers `logger_content`
--
DELIMITER $$
CREATE TRIGGER `logContentBeforeUpdate` BEFORE UPDATE ON `logger_content` FOR EACH ROW begin 
SIGNAL sqlstate '45000' 
set message_text='Update operation for update log content in logger content table is not allowed.';
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `procomsub`
--

CREATE TABLE `procomsub` (
  `proComSub` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `commentId` int(10) UNSIGNED NOT NULL,
  `subTopicsId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `procomsub`
--
DELIMITER $$
CREATE TRIGGER `proComSubLogAfterDelete` AFTER DELETE ON `procomsub` FOR EACH ROW begin 
call saveLog('delete','pcs');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `proComSubLogAfterInsert` AFTER INSERT ON `procomsub` FOR EACH ROW begin 
call saveLog('insert','pcs');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `proComSubLogAfterUpdate` AFTER UPDATE ON `procomsub` FOR EACH ROW begin 
call saveLog('update','pcs');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `userId` int(10) UNSIGNED NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sex` char(1) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `addressId` int(10) UNSIGNED DEFAULT NULL,
  `hashPassword` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`userId`, `firstName`, `lastName`, `email`, `sex`, `dateOfBirth`, `addressId`, `hashPassword`) VALUES
(2, 'Josip', 'Admin', 'mainadmin@main.com', 'm', '1992-11-05', 10, '$2y$10$aY5UXzxviIvBa1YPuRMFP.0oqtLlltqQmjOUlTgkROrg1kFEFP.Su'),
(20, 'Novi', 'Korisnik', 'nkor@mail.com', 'm', '1995-04-29', 8, '$2y$10$KeOibLKzqmZUnW7xPlr0Ous8VPddR6sr2ul7/4J3Yalb/CeakDamC'),
(23, 'Novi', 'Korisnik', 'nkor2@mail.com', 'm', '2000-05-15', 3, '$2y$10$foU/fg4jrxbnSeoN26u56OF.iHDA9q/eAqA/PrCOkJgh4nrohKndC'),
(24, 'Mark', 'Mark', 'mmark@mail.com', 'm', '1985-12-15', 3, '$2y$10$6HIFawsC9yxzuL2WbWnZj.HFsAv1v1x0CJVWU/OA75sBolqZW6rfO'),
(25, 'Josip', 'Bošnjak', 'Josip@mail.com', 'm', '1995-05-20', 3, '$2y$10$3DOpV6Mj703VGwaophdxM.mJE2XEo5/Y4OCDtuuwy74is3sA.XnL6'),
(26, 'Donald', 'Trumop', 'asshole@nazi.com', 'm', '1966-05-21', 1, '$2y$10$SiQhoiuyhlICztEAPR7leeNqC3GYJQDC9DMa4EQonUlmwWDGFDfdy'),
(27, 'Nu', 'Nu', 'nu@nu.nu', 'f', '1985-05-21', 3, '$2y$10$9zG2e3kjrRSZFhYBUegDauwgNznH.MaB0.wCeRBTlgb5bGev6d.3W'),
(28, 'Melania', 'Bitch', 'mbitch@bitch.com', 'f', '1965-05-21', 4, '$2y$10$NBDCZfj9.pf1s4295hu6we67IggG6pT5pg.SJ/m3gOclSSA91EW3y'),
(30, 'Tester', 'Testerović', 'tester@mail.com', 'm', '1988-02-12', 9, '$2y$10$Zc02L05ksBvFwRrJzY.FNuPindE9WbNIZXivN1b.uco/43c2L3ojO');

--
-- Triggers `profile`
--
DELIMITER $$
CREATE TRIGGER `userDeleteProfileLog` AFTER DELETE ON `profile` FOR EACH ROW begin 
call saveProfileLog('delete','profile',concat(old.firstName,' ',old.lastName),null);
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `userProfileLog` AFTER INSERT ON `profile` FOR EACH ROW begin 
declare accTypeId int unsigned;
select acTypeId into accTypeId from accounttype where acTypeName='Regular';
if accTypeId is not null then
call saveProfileLog('insert','profile',concat(new.firstName,' ',new.lastName),null);
call autoInsertIntoProfileDet(new.userId,accTypeId, now(), 'Active');
else 
SIGNAL sqlstate '45000'
set message_text = 'There are no account type under this name. Please check data in the table account type.';
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `userUpdateProfileLog` AFTER UPDATE ON `profile` FOR EACH ROW begin 
call saveProfileLog('update','profile',concat(new.firstName,' ',new.lastName),concat(old.firstName,' ',old.lastName));
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `profiledetails`
--

CREATE TABLE `profiledetails` (
  `proDetId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `acTypeId` int(10) UNSIGNED DEFAULT NULL,
  `registrationDate` datetime NOT NULL,
  `pdUpdateDate` datetime DEFAULT NULL,
  `accountStatus` enum('Active','Banned','Inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiledetails`
--

INSERT INTO `profiledetails` (`proDetId`, `userId`, `acTypeId`, `registrationDate`, `pdUpdateDate`, `accountStatus`) VALUES
(2, 2, 1, '2026-02-28 13:46:21', '2026-02-28 13:55:18', 'Active'),
(11, 20, 1, '2026-04-29 10:07:08', '2026-07-24 15:07:03', 'Active'),
(12, 23, 2, '2026-05-15 11:37:44', '2026-07-20 18:14:56', 'Banned'),
(13, 24, 2, '2026-05-15 12:19:32', NULL, 'Active'),
(14, 25, 2, '2026-05-20 16:59:21', '2026-07-20 17:46:25', 'Inactive'),
(15, 26, 2, '2026-05-21 09:05:41', '2026-07-20 18:14:35', 'Banned'),
(16, 27, 2, '2026-05-21 09:24:22', '2026-07-20 18:14:44', 'Banned'),
(17, 28, 1, '2026-05-21 09:46:25', '2026-07-20 17:13:06', 'Inactive'),
(18, 30, 1, '2026-06-12 23:53:42', '2026-07-20 17:07:15', 'Banned');

--
-- Triggers `profiledetails`
--
DELIMITER $$
CREATE TRIGGER `addedProfileDetailsLog` AFTER INSERT ON `profiledetails` FOR EACH ROW begin 
call saveLog('insert','pd');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deletedProfileDetailsLog` AFTER DELETE ON `profiledetails` FOR EACH ROW begin 
call saveLog('delete','pd');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updatedProfileDetailsLog` AFTER UPDATE ON `profiledetails` FOR EACH ROW begin 
call saveLog('update','pd');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_logger`
--

CREATE TABLE `profile_logger` (
  `plId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `additionDate` datetime NOT NULL,
  `updateDate` datetime DEFAULT NULL,
  `deleteDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profile_logger`
--

INSERT INTO `profile_logger` (`plId`, `userId`, `message`, `additionDate`, `updateDate`, `deleteDate`) VALUES
(1, 2, 'User with email mainadmin@main.com has been logged in', '2026-02-28 14:20:29', NULL, NULL),
(2, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-02-28 14:33:57', NULL, NULL),
(3, 2, 'User with email mainadmin@main.com has been logged in', '2026-02-28 14:43:17', NULL, NULL),
(4, 2, 'User with email mainadmin@main.com has been logged in', '2026-02-28 14:45:49', NULL, NULL),
(5, 2, 'User with email mainadmin@main.com has been logged in', '2026-02-28 14:47:42', NULL, NULL),
(6, 2, 'User with email mainadmin@main.com has been logged in', '2026-02-28 14:48:03', NULL, NULL),
(7, 2, 'User with email mainadmin@main.com has been logged in', '2026-02-28 14:51:24', NULL, NULL),
(8, 2, 'User with email mainadmin@main.com has been logged in', '2026-02-28 14:56:10', NULL, NULL),
(9, 2, 'User with email mainadmin@main.com has been logged in', '2026-02-28 14:56:38', NULL, NULL),
(10, 2, 'User with email mainadmin@main.com has been logged in', '2026-02-28 14:58:01', NULL, NULL),
(11, 2, 'User with email mainadmin@main.com has been logged in', '2026-03-02 10:12:26', NULL, NULL),
(12, 2, 'User with email mainadmin@main.com has been logged in', '2026-03-02 10:25:40', NULL, NULL),
(13, 2, 'User with email mainadmin@main.com has been logged in', '2026-03-03 18:59:43', '2026-03-03 19:20:44', NULL),
(14, 2, 'User with email mainadmin@main.com has been logged in', '2026-03-03 19:28:33', '2026-03-03 19:28:37', NULL),
(15, 2, 'User with email mainadmin@main.com has been logged in', '2026-03-03 19:37:56', '2026-03-03 19:38:00', NULL),
(16, 2, 'User with email mainadmin@main.com has been logged in', '2026-03-05 14:17:09', '2026-03-05 14:17:39', NULL),
(17, 2, 'User with email mainadmin@main.com has been logged out.', '2026-03-05 14:17:39', NULL, NULL),
(18, 2, 'User with email mainadmin@main.com has been logged in', '2026-03-07 16:38:31', '2026-03-07 16:39:53', NULL),
(19, 2, 'User with email mainadmin@main.com has been logged out.', '2026-03-07 16:39:53', NULL, NULL),
(20, 2, 'User with email mainadmin@main.com has been logged in', '2026-03-09 10:18:07', '2026-03-09 10:23:26', NULL),
(21, 2, 'User with email mainadmin@main.com has been logged out.', '2026-03-09 10:23:26', NULL, NULL),
(22, 2, 'User with email mainadmin@main.com has been logged in', '2026-03-09 10:24:03', '2026-03-09 10:24:07', NULL),
(23, 2, 'User with email mainadmin@main.com has been logged out.', '2026-03-09 10:24:07', NULL, NULL),
(24, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-04-04 14:51:55', NULL, NULL),
(25, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-04 14:52:30', NULL, NULL),
(26, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-06 15:35:28', '2026-04-06 16:50:17', NULL),
(27, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-06 16:50:17', NULL, NULL),
(28, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-09 13:26:59', '2026-04-09 13:48:36', NULL),
(29, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-09 13:48:36', NULL, NULL),
(30, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-09 18:05:47', NULL, NULL),
(31, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-10 10:38:44', '2026-04-10 11:03:52', NULL),
(32, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-10 11:03:52', NULL, NULL),
(33, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-10 15:09:56', '2026-04-10 16:15:22', NULL),
(34, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-10 16:15:22', NULL, NULL),
(35, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-11 14:34:55', '2026-04-11 15:09:55', NULL),
(36, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-11 15:09:55', NULL, NULL),
(37, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-11 17:47:47', '2026-04-11 19:05:06', NULL),
(38, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-11 19:05:06', NULL, NULL),
(42, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-04-11 19:07:20', NULL, NULL),
(43, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-04-11 19:07:34', NULL, NULL),
(44, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-11 19:07:48', '2026-04-11 19:08:36', NULL),
(45, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-11 19:08:36', NULL, NULL),
(49, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-11 19:23:09', '2026-04-11 19:23:12', NULL),
(50, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-11 19:23:12', NULL, NULL),
(55, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-12 11:28:42', '2026-04-12 11:51:51', NULL),
(56, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-12 11:51:51', NULL, NULL),
(57, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-13 13:16:54', '2026-04-13 13:58:08', NULL),
(58, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-13 13:58:08', NULL, NULL),
(59, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-14 18:04:03', '2026-04-14 18:36:00', NULL),
(60, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-14 18:36:00', NULL, NULL),
(61, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-15 14:22:43', '2026-04-15 14:52:01', NULL),
(62, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-15 14:52:01', NULL, NULL),
(63, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-15 14:54:30', NULL, NULL),
(64, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-18 15:45:38', '2026-04-18 17:12:44', NULL),
(65, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-18 17:12:45', NULL, NULL),
(66, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-19 10:28:41', NULL, NULL),
(67, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-20 16:39:11', '2026-04-20 17:39:26', NULL),
(68, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-20 17:39:26', NULL, NULL),
(69, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-29 09:05:44', '2026-04-29 09:06:45', NULL),
(70, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-29 09:06:45', NULL, NULL),
(78, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-29 09:30:47', '2026-04-29 09:32:01', NULL),
(79, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-29 09:32:02', NULL, NULL),
(86, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-29 09:54:24', '2026-04-29 09:55:15', NULL),
(87, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-29 09:55:15', NULL, NULL),
(91, 20, 'User with email nkor@mail.com has been logged in', '2026-04-29 10:07:12', '2026-04-29 10:11:21', NULL),
(92, 20, 'User with email nkor@mail.com has been logged out.', '2026-04-29 10:11:21', NULL, NULL),
(93, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-29 10:11:31', '2026-04-29 10:12:03', NULL),
(94, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-29 10:12:03', NULL, NULL),
(95, 20, 'User with email nkor@mail.com has been logged in', '2026-04-29 10:12:21', '2026-04-29 10:16:54', NULL),
(96, 20, 'User with email nkor@mail.com has been logged out.', '2026-04-29 10:16:54', NULL, NULL),
(97, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-29 10:17:14', '2026-04-29 10:17:26', NULL),
(98, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-29 10:17:26', NULL, NULL),
(99, 20, 'User with email nkor@mail.com has been logged in', '2026-04-29 10:18:28', '2026-04-29 10:37:31', NULL),
(100, 20, 'User with email nkor@mail.com has been logged out.', '2026-04-29 10:37:31', NULL, NULL),
(101, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-29 10:37:41', '2026-04-29 10:37:48', NULL),
(102, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-29 10:37:48', NULL, NULL),
(103, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-30 15:00:12', '2026-04-30 15:04:58', NULL),
(104, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-30 15:04:58', NULL, NULL),
(105, 20, 'User with email nkor@mail.com has been logged in', '2026-04-30 15:05:03', '2026-04-30 15:05:18', NULL),
(106, 20, 'User with email nkor@mail.com has been logged out.', '2026-04-30 15:05:18', NULL, NULL),
(107, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-30 15:05:30', '2026-04-30 15:25:26', NULL),
(108, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-30 15:25:26', NULL, NULL),
(109, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-30 15:25:42', '2026-04-30 15:27:32', NULL),
(110, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-30 15:27:32', NULL, NULL),
(111, 2, 'User with email mainadmin@main.com has been logged in', '2026-04-30 15:28:08', '2026-04-30 15:34:19', NULL),
(112, 2, 'User with email mainadmin@main.com has been logged out.', '2026-04-30 15:34:19', NULL, NULL),
(113, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-03 16:02:53', '2026-05-03 16:28:05', NULL),
(114, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-03 16:28:05', NULL, NULL),
(115, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-04 13:07:08', '2026-05-04 14:18:42', NULL),
(116, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-04 14:18:42', NULL, NULL),
(117, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-04 14:19:00', '2026-05-04 14:55:11', NULL),
(118, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-04 14:55:11', NULL, NULL),
(119, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-05 13:37:27', '2026-05-05 13:40:49', NULL),
(120, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-05 13:40:49', NULL, NULL),
(121, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-05 13:41:06', NULL, NULL),
(122, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-05 13:42:55', '2026-05-05 14:38:54', NULL),
(123, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-05 14:38:54', NULL, NULL),
(124, 20, 'User with email nkor@mail.com has been logged in', '2026-05-05 14:39:13', '2026-05-05 14:40:22', NULL),
(125, 20, 'User with email nkor@mail.com has been logged out.', '2026-05-05 14:40:22', NULL, NULL),
(126, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-07 13:06:04', '2026-05-07 14:51:03', NULL),
(127, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-07 14:51:03', NULL, NULL),
(128, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-08 13:01:30', '2026-05-08 13:15:06', NULL),
(129, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-08 13:15:06', NULL, NULL),
(130, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-11 16:04:40', '2026-05-11 17:50:35', NULL),
(131, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-11 17:50:35', NULL, NULL),
(132, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-12 20:10:03', NULL, NULL),
(133, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-14 08:42:07', '2026-05-14 09:54:46', NULL),
(134, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-14 09:54:46', NULL, NULL),
(135, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 09:22:28', NULL, NULL),
(136, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 10:26:53', '2026-05-15 10:48:58', NULL),
(137, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 10:48:58', NULL, NULL),
(138, 20, 'User with email nkor@mail.com has been logged in', '2026-05-15 10:49:14', '2026-05-15 10:49:44', NULL),
(139, 20, 'User with email nkor@mail.com has been logged out.', '2026-05-15 10:49:44', NULL, NULL),
(140, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 10:49:55', '2026-05-15 10:51:11', NULL),
(141, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 10:51:11', NULL, NULL),
(142, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 10:51:41', '2026-05-15 10:57:05', NULL),
(143, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 10:57:05', NULL, NULL),
(144, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 10:57:21', '2026-05-15 11:05:48', NULL),
(145, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 11:05:48', NULL, NULL),
(146, 20, 'User with email nkor@mail.com has been logged in', '2026-05-15 11:05:58', '2026-05-15 11:08:12', NULL),
(147, 20, 'User with email nkor@mail.com has been logged out.', '2026-05-15 11:08:12', NULL, NULL),
(148, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 11:08:21', '2026-05-15 11:15:00', NULL),
(149, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 11:15:00', NULL, NULL),
(150, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 11:15:07', '2026-05-15 11:34:03', NULL),
(151, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 11:34:03', NULL, NULL),
(152, 23, 'User with email nkor2@mail.com has been logged in', '2026-05-15 11:37:48', '2026-05-15 12:19:15', NULL),
(153, 23, 'User with email nkor2@mail.com has been logged out.', '2026-05-15 12:19:15', NULL, NULL),
(154, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 12:19:36', '2026-05-15 12:48:22', NULL),
(155, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-15 12:48:22', NULL, NULL),
(156, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 12:51:22', NULL, NULL),
(157, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 12:52:38', NULL, NULL),
(158, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 13:01:44', '2026-05-15 13:10:15', NULL),
(159, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-15 13:10:15', NULL, NULL),
(160, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 13:10:22', '2026-05-15 13:11:22', NULL),
(161, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 13:11:22', NULL, NULL),
(162, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 13:11:34', '2026-05-15 13:24:37', NULL),
(163, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-15 13:24:37', NULL, NULL),
(164, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 13:28:10', '2026-05-15 13:32:43', NULL),
(165, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 13:32:43', NULL, NULL),
(166, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 13:32:51', '2026-05-15 13:33:16', NULL),
(167, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 13:33:16', NULL, NULL),
(168, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 13:33:30', '2026-05-15 13:49:08', NULL),
(169, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-15 13:49:08', NULL, NULL),
(170, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-05-15 13:49:24', NULL, NULL),
(171, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 13:49:33', '2026-05-15 13:52:50', NULL),
(172, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 13:52:50', NULL, NULL),
(173, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 13:53:03', '2026-05-15 13:54:57', NULL),
(174, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 13:54:57', NULL, NULL),
(175, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 13:55:12', '2026-05-15 13:57:42', NULL),
(176, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-15 13:57:42', NULL, NULL),
(177, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-05-15 13:57:49', NULL, NULL),
(178, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 13:57:59', '2026-05-15 14:03:19', NULL),
(179, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 14:03:19', NULL, NULL),
(180, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 14:03:31', '2026-05-15 14:04:29', NULL),
(181, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-15 14:04:29', NULL, NULL),
(182, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 14:04:42', '2026-05-15 14:08:54', NULL),
(183, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 14:08:54', NULL, NULL),
(184, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 14:09:07', '2026-05-15 14:12:58', NULL),
(185, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-15 14:12:58', NULL, NULL),
(186, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-05-15 14:13:15', NULL, NULL),
(187, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 14:13:23', '2026-05-15 14:13:29', NULL),
(188, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 14:13:29', NULL, NULL),
(189, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 14:13:48', '2026-05-15 14:16:28', NULL),
(190, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-15 14:16:28', NULL, NULL),
(191, 24, 'Unsuccessfull login by mmark@mail.com', '2026-05-15 14:16:40', NULL, NULL),
(192, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-15 14:16:55', '2026-05-15 14:17:03', NULL),
(193, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-15 14:17:03', NULL, NULL),
(194, 24, 'User with email mmark@mail.com has been logged in', '2026-05-15 14:17:16', '2026-05-15 14:18:42', NULL),
(195, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-15 14:18:42', NULL, NULL),
(196, 24, 'User with email mmark@mail.com has been logged in', '2026-05-17 11:02:55', '2026-05-17 11:20:18', NULL),
(197, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-17 11:20:18', NULL, NULL),
(198, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-17 11:20:33', '2026-05-17 11:24:43', NULL),
(199, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-17 11:24:43', NULL, NULL),
(200, 24, 'User with email mmark@mail.com has been logged in', '2026-05-17 11:25:02', '2026-05-17 11:32:19', NULL),
(201, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-17 11:32:19', NULL, NULL),
(202, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-05-17 11:32:30', NULL, NULL),
(203, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-17 11:32:38', '2026-05-17 11:32:56', NULL),
(204, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-17 11:32:56', NULL, NULL),
(205, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-19 13:45:48', '2026-05-19 13:46:31', NULL),
(206, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-19 13:46:31', NULL, NULL),
(207, 24, 'User with email mmark@mail.com has been logged in', '2026-05-19 13:47:13', '2026-05-19 14:17:19', NULL),
(208, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-19 14:17:19', NULL, NULL),
(209, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-19 14:17:30', '2026-05-19 14:18:30', NULL),
(210, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-19 14:18:30', NULL, NULL),
(211, 24, 'User with email mmark@mail.com has been logged in', '2026-05-19 14:18:46', '2026-05-19 14:21:05', NULL),
(212, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-19 14:21:05', NULL, NULL),
(213, 24, 'User with email mmark@mail.com has been logged in', '2026-05-20 14:45:09', '2026-05-20 15:45:54', NULL),
(214, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-20 15:45:54', NULL, NULL),
(215, 24, 'User with email mmark@mail.com has been logged in', '2026-05-20 15:46:10', '2026-05-20 16:30:34', NULL),
(216, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-20 16:30:34', NULL, NULL),
(217, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-05-20 16:30:52', NULL, NULL),
(218, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-20 16:31:00', '2026-05-20 16:31:09', NULL),
(219, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-20 16:31:09', NULL, NULL),
(220, 24, 'User with email mmark@mail.com has been logged in', '2026-05-20 16:31:19', '2026-05-20 16:40:57', NULL),
(221, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-20 16:40:57', NULL, NULL),
(222, 23, 'User with email nkor2@mail.com has been logged in', '2026-05-20 16:41:03', '2026-05-20 16:41:11', NULL),
(223, 23, 'User with email nkor2@mail.com has been logged out.', '2026-05-20 16:41:11', NULL, NULL),
(224, 24, 'User with email mmark@mail.com has been logged in', '2026-05-20 16:47:36', '2026-05-20 16:58:07', NULL),
(225, 24, 'User with email mmark@mail.com has been logged out.', '2026-05-20 16:58:07', NULL, NULL),
(226, 25, 'User with email Josip@mail.com has been logged in', '2026-05-20 16:59:25', '2026-05-20 17:00:22', NULL),
(227, 25, 'User with email Josip@mail.com has been logged out.', '2026-05-20 17:00:22', NULL, NULL),
(228, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-21 08:59:42', '2026-05-21 09:05:08', NULL),
(229, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-21 09:05:08', NULL, NULL),
(230, 28, 'User with email mbitch@bitch.com has been logged in', '2026-05-21 09:47:24', '2026-05-21 09:48:53', NULL),
(231, 28, 'User with email mbitch@bitch.com has been logged out.', '2026-05-21 09:48:53', NULL, NULL),
(232, 28, 'User with email mbitch@bitch.com has been logged in', '2026-05-21 09:49:34', '2026-05-21 10:06:50', NULL),
(233, 28, 'User with email mbitch@bitch.com has been logged out.', '2026-05-21 10:06:50', NULL, NULL),
(234, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-22 09:24:52', '2026-05-22 13:51:34', NULL),
(235, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-22 13:51:34', NULL, NULL),
(236, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-24 18:39:36', '2026-05-24 19:17:52', NULL),
(237, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-24 19:17:52', NULL, NULL),
(238, 20, 'User with email nkor@mail.com has been logged in', '2026-05-24 19:17:57', '2026-05-24 19:18:41', NULL),
(239, 20, 'User with email nkor@mail.com has been logged out.', '2026-05-24 19:18:41', NULL, NULL),
(240, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-25 13:42:58', '2026-05-25 14:17:15', NULL),
(241, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-25 14:17:15', NULL, NULL),
(242, 27, 'User with email nu@nu.nu has been logged in', '2026-05-25 14:17:30', '2026-05-25 14:17:35', NULL),
(243, 27, 'User with email nu@nu.nu has been logged out.', '2026-05-25 14:17:35', NULL, NULL),
(244, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-25 14:17:43', '2026-05-25 14:47:32', NULL),
(245, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-25 14:47:32', NULL, NULL),
(246, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-26 12:24:35', '2026-05-26 16:13:06', NULL),
(247, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-26 16:13:06', NULL, NULL),
(248, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-28 13:07:42', '2026-05-28 13:45:32', NULL),
(249, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-28 13:45:32', NULL, NULL),
(250, 2, 'User with email mainadmin@main.com has been logged in', '2026-05-31 10:09:16', '2026-05-31 11:21:55', NULL),
(251, 2, 'User with email mainadmin@main.com has been logged out.', '2026-05-31 11:21:55', NULL, NULL),
(252, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-03 14:14:50', '2026-06-03 14:34:54', NULL),
(253, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-03 14:34:54', NULL, NULL),
(254, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-04 10:05:56', '2026-06-04 12:19:46', NULL),
(255, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-04 12:19:46', NULL, NULL),
(256, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-04 12:19:56', '2026-06-04 12:20:32', NULL),
(257, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-04 12:20:32', NULL, NULL),
(258, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-04 12:20:52', '2026-06-04 12:49:07', NULL),
(259, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-04 12:49:07', NULL, NULL),
(260, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-09 08:49:28', '2026-06-09 08:51:57', NULL),
(261, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-09 08:51:57', NULL, NULL),
(262, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-09 08:52:09', '2026-06-09 08:52:55', NULL),
(263, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-09 08:52:55', NULL, NULL),
(264, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-09 08:53:07', '2026-06-09 08:56:13', NULL),
(265, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-09 08:56:13', NULL, NULL),
(266, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-09 08:56:21', '2026-06-09 11:11:42', NULL),
(267, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-09 11:11:42', NULL, NULL),
(268, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-10 12:59:20', '2026-06-10 13:29:23', NULL),
(269, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-10 13:29:23', NULL, NULL),
(270, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-06-10 13:29:48', NULL, NULL),
(271, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-10 13:30:01', '2026-06-10 14:12:48', NULL),
(272, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-10 14:12:48', NULL, NULL),
(273, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-12 21:15:32', NULL, NULL),
(274, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-12 23:28:45', '2026-06-12 23:43:23', NULL),
(275, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-12 23:43:23', NULL, NULL),
(276, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-12 23:43:30', NULL, NULL),
(277, 30, 'User with email tester@mail.com has been logged in', '2026-06-12 23:53:46', '2026-06-12 23:54:21', NULL),
(278, 30, 'User with email tester@mail.com has been logged out.', '2026-06-12 23:54:21', NULL, NULL),
(279, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-14 14:03:42', '2026-06-14 14:40:14', NULL),
(280, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-14 14:40:14', NULL, NULL),
(281, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-17 17:12:00', '2026-06-17 19:03:46', NULL),
(282, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-17 19:03:46', NULL, NULL),
(283, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-19 12:43:44', '2026-06-19 13:28:29', NULL),
(284, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-19 13:28:29', NULL, NULL),
(285, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-21 14:27:18', '2026-06-21 14:27:52', NULL),
(286, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-21 14:27:52', NULL, NULL),
(287, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-23 22:12:45', '2026-06-24 00:25:13', NULL),
(288, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-24 00:25:13', NULL, NULL),
(289, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-24 00:25:26', '2026-06-24 00:51:59', NULL),
(290, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-24 00:51:59', NULL, NULL),
(291, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-24 00:52:11', '2026-06-24 00:57:31', NULL),
(292, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-24 00:57:31', NULL, NULL),
(293, 2, 'User with email mainadmin@main.com has been logged in', '2026-06-30 13:02:22', '2026-06-30 13:56:47', NULL),
(294, 2, 'User with email mainadmin@main.com has been logged out.', '2026-06-30 13:56:47', NULL, NULL),
(295, 2, 'User with email mainadmin@main.com has been logged in', '2026-07-04 13:33:29', '2026-07-04 13:57:42', NULL),
(296, 2, 'User with email mainadmin@main.com has been logged out.', '2026-07-04 13:57:42', NULL, NULL),
(297, 2, 'User with email mainadmin@main.com has been logged in', '2026-07-09 11:42:29', '2026-07-09 12:22:38', NULL),
(298, 2, 'User with email mainadmin@main.com has been logged out.', '2026-07-09 12:22:38', NULL, NULL),
(299, 2, 'User with email mainadmin@main.com has been logged in', '2026-07-09 12:24:42', '2026-07-09 12:30:02', NULL),
(300, 2, 'User with email mainadmin@main.com has been logged out.', '2026-07-09 12:30:02', NULL, NULL),
(301, 2, 'User with email mainadmin@main.com has been logged in', '2026-07-11 13:37:31', '2026-07-11 15:05:36', NULL),
(302, 2, 'User with email mainadmin@main.com has been logged out.', '2026-07-11 15:05:36', NULL, NULL),
(303, 2, 'Unsuccessfull login by mainadmin@main.com', '2026-07-11 15:05:46', NULL, NULL),
(304, 2, 'User with email mainadmin@main.com has been logged in', '2026-07-11 15:05:56', '2026-07-11 15:06:39', NULL),
(305, 2, 'User with email mainadmin@main.com has been logged out.', '2026-07-11 15:06:39', NULL, NULL),
(306, 2, 'User with email mainadmin@main.com has been logged in', '2026-07-19 08:52:18', '2026-07-19 09:46:34', NULL),
(307, 2, 'User with email mainadmin@main.com has been logged out.', '2026-07-19 09:46:34', NULL, NULL),
(308, 2, 'User with email mainadmin@main.com has been logged in', '2026-07-20 16:37:58', '2026-07-20 18:14:59', NULL),
(309, 2, 'User with email mainadmin@main.com has been logged out.', '2026-07-20 18:14:59', NULL, NULL),
(310, 2, 'User with email mainadmin@main.com has been logged in', '2026-07-24 15:06:37', '2026-07-24 15:39:02', NULL),
(311, 2, 'User with email mainadmin@main.com has been logged out.', '2026-07-24 15:39:02', NULL, NULL);

--
-- Triggers `profile_logger`
--
DELIMITER $$
CREATE TRIGGER `logContentAfterDelete` AFTER DELETE ON `profile_logger` FOR EACH ROW begin 
call saveLog2('delete','pl');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logContentAfterUpdate` AFTER INSERT ON `profile_logger` FOR EACH ROW begin 
call saveLog2('update','pl');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logContentAfterinsert` AFTER INSERT ON `profile_logger` FOR EACH ROW begin 
call saveLog2('insert','pl');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `stateId` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`stateId`, `name`) VALUES
(58, '12'),
(67, '123'),
(73, '123478'),
(64, '2456'),
(59, '345'),
(65, '788844'),
(39, 'Afghanistan'),
(32, 'Algeria'),
(37, 'Angola'),
(26, 'Argentina'),
(17, 'Australia'),
(38, 'Austria'),
(68, 'Bahamas'),
(16, 'Bangladesh'),
(30, 'Barbados'),
(12, 'Bosnia and Herzegovina'),
(7, 'Brazil'),
(36, 'Chile'),
(14, 'China'),
(29, 'Colombia'),
(1, 'Croatia'),
(19, 'Denmark'),
(57, 'dhethrsh'),
(3, 'France'),
(22, 'Germany'),
(13, 'Hungary'),
(2, 'Italy'),
(44, 'Jamaica'),
(42, 'Kenya'),
(43, 'Lebanon'),
(63, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sit amet porta urna. Sed varius,'),
(62, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the '),
(31, 'Marocco'),
(5, 'Mexico'),
(50, 'Milano'),
(70, 'Milano1456'),
(11, 'Montenegro'),
(41, 'Namibia'),
(71, 'neka nova država'),
(72, 'new'),
(18, 'New Zeland'),
(40, 'Nigeria'),
(35, 'North Korea'),
(25, 'Portugal'),
(27, 'Russia'),
(9, 'Saudi Arabia'),
(10, 'Serbia'),
(33, 'South Africa'),
(34, 'South Korea'),
(23, 'Spain'),
(15, 'Taiwan'),
(24, 'Thailand'),
(8, 'Ukraine'),
(20, 'United Kingdom'),
(6, 'Uruguay'),
(4, 'USA'),
(28, 'Venezuela'),
(69, 'Virgin Island'),
(21, 'Wales');

--
-- Triggers `state`
--
DELIMITER $$
CREATE TRIGGER `UserLogAfterDeleteOnState` AFTER DELETE ON `state` FOR EACH ROW begin 
call saveLog('delete','state');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UserLogAfterInsertOnState` AFTER INSERT ON `state` FOR EACH ROW begin 
call saveLog('insert','state');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UserLogAfterUpdateOnState` AFTER UPDATE ON `state` FOR EACH ROW begin 
call saveLog('update','state');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `subtopics`
--

CREATE TABLE `subtopics` (
  `subTopicsId` int(10) UNSIGNED NOT NULL,
  `topicId` int(10) UNSIGNED NOT NULL,
  `subTopicContent` text NOT NULL,
  `subTopicDateAdded` datetime NOT NULL,
  `subTopicDateUpdated` datetime NOT NULL,
  `subtopicLike` int(10) UNSIGNED NOT NULL,
  `subtopicDislike` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `subtopics`
--
DELIMITER $$
CREATE TRIGGER `logContentAfterDeleteSt` AFTER DELETE ON `subtopics` FOR EACH ROW begin 
call saveLog2('delete','st');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logContentAfterInsertSt` AFTER INSERT ON `subtopics` FOR EACH ROW begin 
call saveLog2('insert','st');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logContentAfterUpdateSt` AFTER UPDATE ON `subtopics` FOR EACH ROW begin 
call saveLog2('update','st');
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topicId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `topicContent` text NOT NULL,
  `topicDateAdded` datetime NOT NULL,
  `topicLike` int(10) UNSIGNED NOT NULL,
  `topicDislike` int(10) UNSIGNED NOT NULL,
  `topicDateUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `topics`
--
DELIMITER $$
CREATE TRIGGER `logContentAfterDeleteTop` AFTER DELETE ON `topics` FOR EACH ROW begin 
call saveLog2('delete','top');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logContentAfterInsertTop` AFTER INSERT ON `topics` FOR EACH ROW begin 
call saveLog2('insert','top');
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logContentAfterUpdateTop` AFTER UPDATE ON `topics` FOR EACH ROW begin 
call saveLog2('update','top');
end
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounttype`
--
ALTER TABLE `accounttype`
  ADD PRIMARY KEY (`acTypeId`),
  ADD UNIQUE KEY `acTypeName` (`acTypeName`),
  ADD UNIQUE KEY `listOfPrivileges` (`listOfPrivileges`) USING HASH;

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`addressId`),
  ADD KEY `postNumber_fk` (`postNumber`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`postNumber`),
  ADD KEY `stateId_fk` (`stateId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentId`);

--
-- Indexes for table `databaseuser`
--
ALTER TABLE `databaseuser`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userName` (`userName`),
  ADD KEY `accountType_fk` (`acTypeId`);

--
-- Indexes for table `database_logger`
--
ALTER TABLE `database_logger`
  ADD PRIMARY KEY (`dbLogId`),
  ADD KEY `user_id_fk` (`userId`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`imageId`),
  ADD UNIQUE KEY `url` (`url`) USING HASH,
  ADD KEY `userid_imgid_fk` (`userId`);

--
-- Indexes for table `imagedetails`
--
ALTER TABLE `imagedetails`
  ADD PRIMARY KEY (`iDetailsId`),
  ADD KEY `typeId_fk` (`typeId`),
  ADD KEY `imageId_fk` (`imageId`);

--
-- Indexes for table `imagetype`
--
ALTER TABLE `imagetype`
  ADD PRIMARY KEY (`typeId`),
  ADD UNIQUE KEY `iTypeName` (`iTypeName`);

--
-- Indexes for table `image_gallery`
--
ALTER TABLE `image_gallery`
  ADD PRIMARY KEY (`galleryId`),
  ADD UNIQUE KEY `galleryName` (`galleryName`);

--
-- Indexes for table `img_img_gal`
--
ALTER TABLE `img_img_gal`
  ADD PRIMARY KEY (`uniqueId`),
  ADD KEY `imageIdiig_fk` (`imageId`),
  ADD KEY `galleryId_fk` (`galleryId`);

--
-- Indexes for table `logger_content`
--
ALTER TABLE `logger_content`
  ADD PRIMARY KEY (`idLogCon`),
  ADD KEY `dbLogId_fk` (`dbLogId`);

--
-- Indexes for table `procomsub`
--
ALTER TABLE `procomsub`
  ADD PRIMARY KEY (`proComSub`),
  ADD KEY `userIdPcs_fk` (`userId`),
  ADD KEY `commentId_fk` (`commentId`),
  ADD KEY `subtopicsid_pcs_fk` (`subTopicsId`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `addressId_fk` (`addressId`);

--
-- Indexes for table `profiledetails`
--
ALTER TABLE `profiledetails`
  ADD PRIMARY KEY (`proDetId`),
  ADD KEY `userIdac_fk` (`userId`),
  ADD KEY `acTypeId_fk` (`acTypeId`);

--
-- Indexes for table `profile_logger`
--
ALTER TABLE `profile_logger`
  ADD PRIMARY KEY (`plId`),
  ADD KEY `userIdpl_fk` (`userId`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`stateId`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `subtopics`
--
ALTER TABLE `subtopics`
  ADD PRIMARY KEY (`subTopicsId`),
  ADD UNIQUE KEY `subTopicContent` (`subTopicContent`) USING HASH,
  ADD KEY `topicId_fk` (`topicId`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topicId`),
  ADD UNIQUE KEY `topicContent` (`topicContent`) USING HASH,
  ADD KEY `user_id_topics_fk` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounttype`
--
ALTER TABLE `accounttype`
  MODIFY `acTypeId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `addressId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `databaseuser`
--
ALTER TABLE `databaseuser`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `database_logger`
--
ALTER TABLE `database_logger`
  MODIFY `dbLogId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `imageId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `imagedetails`
--
ALTER TABLE `imagedetails`
  MODIFY `iDetailsId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imagetype`
--
ALTER TABLE `imagetype`
  MODIFY `typeId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_gallery`
--
ALTER TABLE `image_gallery`
  MODIFY `galleryId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `img_img_gal`
--
ALTER TABLE `img_img_gal`
  MODIFY `uniqueId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logger_content`
--
ALTER TABLE `logger_content`
  MODIFY `idLogCon` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=912;

--
-- AUTO_INCREMENT for table `procomsub`
--
ALTER TABLE `procomsub`
  MODIFY `proComSub` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `profiledetails`
--
ALTER TABLE `profiledetails`
  MODIFY `proDetId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `profile_logger`
--
ALTER TABLE `profile_logger`
  MODIFY `plId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `stateId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `subtopics`
--
ALTER TABLE `subtopics`
  MODIFY `subTopicsId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topicId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `postNumber_fk` FOREIGN KEY (`postNumber`) REFERENCES `city` (`postNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `stateId_fk` FOREIGN KEY (`stateId`) REFERENCES `state` (`stateId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `databaseuser`
--
ALTER TABLE `databaseuser`
  ADD CONSTRAINT `accountType_fk` FOREIGN KEY (`acTypeId`) REFERENCES `accounttype` (`acTypeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `database_logger`
--
ALTER TABLE `database_logger`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`userId`) REFERENCES `databaseuser` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `userid_imgid_fk` FOREIGN KEY (`userId`) REFERENCES `profile` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `imagedetails`
--
ALTER TABLE `imagedetails`
  ADD CONSTRAINT `imageId_fk` FOREIGN KEY (`imageId`) REFERENCES `image` (`imageId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `typeId_fk` FOREIGN KEY (`typeId`) REFERENCES `imagetype` (`typeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `img_img_gal`
--
ALTER TABLE `img_img_gal`
  ADD CONSTRAINT `galleryId_fk` FOREIGN KEY (`galleryId`) REFERENCES `image_gallery` (`galleryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `imageIdiig_fk` FOREIGN KEY (`imageId`) REFERENCES `image` (`imageId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logger_content`
--
ALTER TABLE `logger_content`
  ADD CONSTRAINT `dbLogId_fk` FOREIGN KEY (`dbLogId`) REFERENCES `database_logger` (`dbLogId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `procomsub`
--
ALTER TABLE `procomsub`
  ADD CONSTRAINT `commentId_fk` FOREIGN KEY (`commentId`) REFERENCES `comments` (`commentId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subtopicsid_pcs_fk` FOREIGN KEY (`subTopicsId`) REFERENCES `subtopics` (`subTopicsId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userIdPcs_fk` FOREIGN KEY (`userId`) REFERENCES `profile` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `addressId_fk` FOREIGN KEY (`addressId`) REFERENCES `address` (`addressId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profiledetails`
--
ALTER TABLE `profiledetails`
  ADD CONSTRAINT `acTypeId_fk` FOREIGN KEY (`acTypeId`) REFERENCES `accounttype` (`acTypeId`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `userIdac_fk` FOREIGN KEY (`userId`) REFERENCES `profile` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile_logger`
--
ALTER TABLE `profile_logger`
  ADD CONSTRAINT `userIdpl_fk` FOREIGN KEY (`userId`) REFERENCES `profile` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subtopics`
--
ALTER TABLE `subtopics`
  ADD CONSTRAINT `topicId_fk` FOREIGN KEY (`topicId`) REFERENCES `topics` (`topicId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `user_id_topics_fk` FOREIGN KEY (`userId`) REFERENCES `profile` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

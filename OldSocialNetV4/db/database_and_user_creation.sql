create database if not exists scn3 char set utf8mb4 collate utf8mb4_general_ci;
create user if not exists 'adminscn'@'localhost' identified by 'admin';
grant all privileges on scn3.* to 'adminscn'@'localhost';
create user if not exists 'userscn'@'localhost' identified by 'user';
grant select,update,delete,insert on scn3.* to 'userscn'@'localhost';
use scn3; 
CREATE TABLE IF NOT EXISTS `profile` (
  `imageId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `imageType` varchar(25) NOT NULL,
  `imageData` longblob NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_of_addition` datetime NOT NULL,
  PRIMARY KEY (`imageId`),
  KEY `email` (`email`)
) 
DELIMITER $$
CREATE TRIGGER `profile_OnInsert` BEFORE INSERT ON `profile` FOR EACH ROW SET NEW.`date_of_addition` = IFNULL(NEW.`date_of_addition`, NOW())
$$
DELIMITER ;

CREATE TABLE IF NOT EXISTS `registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50)  NOT NULL,
  `lname` varchar(50) NOT NULL,
  `sex` varchar(1)  NOT NULL,
  `dateofbirth` date NOT NULL,
  `cityofbirth` varchar(50) NOT NULL,
  `countryofbirth` varchar(50)  NOT NULL,
  `pass` varchar(50)  NOT NULL,
  `profilepicture` longblob NOT NULL,
  `email` varchar(255)  DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);
ALTER TABLE `profile`
  ADD CONSTRAINT `email_index` FOREIGN KEY (`email`) REFERENCES `registration` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
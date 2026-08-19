create database if not exists scn4 char set utf8mb4 collate utf8mb4_general_ci;
create user if not exists 'adminscn'@'localhost' identified by 'admin';
grant all privileges on scn4.* to 'adminscn'@'localhost';
create user if not exists 'userscn'@'localhost' identified by 'user';
grant select,update,delete,insert on scn4.* to 'userscn'@'localhost';
use scn4; 
CREATE TABLE `kvaliteta` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50)  NOT NULL,
  `lastname` varchar(100)  NOT NULL,
  `suggestion` varchar(255)  NOT NULL
);
INSERT INTO `kvaliteta` (`id`, `firstname`, `lastname`, `suggestion`) VALUES
(1, '', '', ''),
(2, 'Josip', 'Bošnjak', 'Treba napraviti bla bla pa onda bla bla bla i tek onda bla bla bla.'),
(3, 'Josip', 'Bošnjak', 'Blabla bi trebalo promijeniti staviti blablabla.'),
(4, 'Josip', 'Bošnjak', 'Blabla bi trebalo promijeniti staviti blablabla.');
ALTER TABLE `kvaliteta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `firstname` (`firstname`),
  ADD KEY `lastname` (`lastname`),
  ADD KEY `suggestion` (`suggestion`);
  ALTER TABLE `kvaliteta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;
alter table kvaliteta modify column firstname varchar(60) not null;
alter table kvaliteta modify column lastname varchar(60) not null;

INSERT INTO `kvaliteta` (`id`, `firstname`, `lastname`, `suggestion`) VALUES
(6, 'Josip', 'Bošnjak', 'Blabla bi trebalo promijeniti staviti blablabla.'),
(7, 'Mario', 'Mandžukić', 'Treba mi napadačka vrba.'),
(8, 'Ivan', 'Perišić', 'Imam coronu. Ne mogu igrati.'),
(9, 'Josip', 'Bošnjak', 'Napravljen unos feedbacka za stranicu. Popraviti bug koji dodaje prazno mjesto u tablicu. Napraviti neki captcha za odgodu novog unosa.'),
(10, 'Josip', 'Bošnjak', 'Sada treba napraviti registracijsku formu. Treba napraviti i stranicu koja omogućuje adminu da  uređuje feedbackove. Feedbackove može vidjeti samo admin.');

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50)  NOT NULL,
  `sex` varchar(1)  NOT NULL,
  `dateofbirth` date NOT NULL,
  `cityofbirth` varchar(50)  NOT NULL,
  `countryofbirth` varchar(50) NOT NULL,
  `pass` varchar(50)  NOT NULL,
  `profilepicture` longblob DEFAULT NULL
);
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fname` (`fname`),
  ADD KEY `lname` (`lname`);
  
  ALTER TABLE `kvaliteta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10; 
  
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

CREATE TABLE `obavljeno` (
  `id` int(11) NOT NULL,
  `obavljeno` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL
);
INSERT INTO `obavljeno` (`id`, `obavljeno`, `user_id`) VALUES
(1, 1, 4),
(3, 1, 4),
(5, 1, 4);

CREATE TABLE `profilna` (
  `imageId` tinyint(4) NOT NULL,
  `imageType` varchar(25) NOT NULL,
  `imageData` longblob NOT NULL
);
alter table registration add column `email` varchar(255)  NOT NULL;
INSERT INTO `registration` ( `fname`, `lname`, `sex`, `dateofbirth`, `cityofbirth`, `countryofbirth`, `pass`, `email`) VALUES
( 'hrgiho', 'hgoirhgo', 'm', '0005-02-05', 'grgrg', 'rggere', 'gfeeg', 'jbosnjak34@gmail.com'),
( 'Josip', 'Bošnjak', 'm', '1992-11-05', 'VVinterthur', 'Švicarska', '4854848484fege', 'jbosnjak3@gmail.com'),
( 'Marko', 'Marković', 'm', '1988-07-08', 'Požega', 'Hrvatska', 'volimhrvatsku', 'mmarkovic@gmail.com');
INSERT INTO `registration` ( `fname`, `lname`, `sex`, `dateofbirth`, `cityofbirth`, `countryofbirth`, `pass`, `email`) VALUES
( 'Marek', 'Hamšik', 'm', '1988-12-15', 'Zilina', 'Slovakia', '4545fee', 'mhamsik@gmail.com'),
( 'Mason', 'Mount', 'm', '1995-01-15', 'London', 'England', '154116916re', 'mmount@gmail.com');

CREATE TABLE `uloge` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `uloga` enum('Administrator','Korisnik','Banovani korisnik') NOT NULL
);

--
-- Indexes for table `obavljeno`
--
ALTER TABLE `obavljeno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `profilna`
--
ALTER TABLE `profilna`
  ADD PRIMARY KEY (`imageId`);
  
alter table registration ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `uloge`
--
ALTER TABLE `uloge`
  ADD PRIMARY KEY (`id`);
  
  ALTER TABLE `obavljeno`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `registration` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

alter table uloge drop column user_id;
alter table uloge add column email varchar(255) not null;
alter table uloge add constraint email_fk foreign key (email) references registration (email) on delete cascade on update cascade;

INSERT INTO `uloge` (`id`, `email`, `uloga`) VALUES
(1, 'jbosnjak34@gmail.com', 'Administrator');

INSERT INTO `kvaliteta` VALUES(12, '', '', '');
INSERT INTO `kvaliteta` VALUES(13, 'Josip', 'Bošnjak', 'Treba napraviti bla bla pa onda bla bla bla i tek onda bla bla bla.');
INSERT INTO `kvaliteta` VALUES(14, 'Josip', 'Bošnjak', 'Blabla bi trebalo promijeniti staviti blablabla.');
INSERT INTO `kvaliteta` VALUES(15, 'Josip', 'Bošnjak', 'Blabla bi trebalo promijeniti staviti blablabla.');
INSERT INTO `kvaliteta` VALUES(16, 'Mario', 'Mandžukić', 'Treba mi napadačka vrba.');
INSERT INTO `kvaliteta` VALUES(17, 'Ivan', 'Perišić', 'Imam coronu. Ne mogu igrati.');
INSERT INTO `kvaliteta` VALUES(18, 'Josip', 'Bošnjak', 'Napravljen unos feedbacka za stranicu. Popraviti bug koji dodaje prazno mjesto u tablicu. Napraviti neki captcha za odgodu novog unosa.');
INSERT INTO `kvaliteta` VALUES(19, 'Josip', 'Bošnjak', 'Sada treba napraviti registracijsku formu. Treba napraviti i stranicu koja omogućuje adminu da  uređuje feedbackove. Feedbackove može vidjeti samo admin.');
alter table profilna add column email varchar(255) not null;
alter table profilna add constraint emailp_fk foreign key (email) references registration(email) on delete cascade on update cascade;
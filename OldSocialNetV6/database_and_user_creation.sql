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
create database if not exists scn8 char set utf8mb4 collate utf8mb4_general_ci;
create user if not exists 'adminscn'@'localhost' identified by 'admin';
grant all privileges on scn8.* to 'adminscn'@'localhost';
create user if not exists 'userscn'@'localhost' identified by 'user';
grant select,update,delete,insert on scn4.* to 'userscn'@'localhost';
use scn8; 
create table qaqc(
id int primary key auto_increment,
fname varchar(50) not null,
lname varchar(100) not null,
suggestions text not null)



INSERT INTO `qaqc` (`fname`, `lname`, `suggestions`) VALUES
( 'Josip', 'Bošnjak', 'Errors needs to be deal it.'),
( 'Josip', 'Bošnjak', 'There is multiple insertion on submit. Needs to deal with it.'),
( 'Josip', 'Bošnjak', 'There is multiple insertion on submit. Needs to deal with it.'),
('Josip', 'Bošnjak', 'On refresh, same value has been inserted. Need to fix that.'),
( 'Josip', 'Bošnjak', 'test'),
( 'Josip', 'Bošnjak', 'Take me to the first page please.');

CREATE TABLE `registration` (
  `id` int primary key auto_increment,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `dateofbirth` date NOT NULL,
  `cityofbirth` varchar(50) NOT NULL,
  `countryofbirth` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `profilepicture` varchar(255) NOT NULL
) ;

CREATE TABLE `kvaliteta` (
  `id` int primary key auto_increment not null,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `suggestion` varchar(255) NOT NULL
);

INSERT INTO `kvaliteta` ( `firstname`, `lastname`, `suggestion`) VALUES
( '', '', ''),
('Josip', 'Bošnjak', 'Bok. Moje ime je Josip. Ovo je moj prvi upis u bazu podataka. Trebalo bi poboljšati dizajn stranice i trebalo bi se poboljšati da ne piše na stranici undefined variables. To piše jer su varijable trebale biti deklarirane na početku. Lijep pozdrav.'),
( 'Ivan', 'Ivić', 'Veličina polja za feedback mi se ne sviđa. Trebalo bi to promijeniti.'),
( 'Ryno', 'gt4', 'Hello i do not understand lot of this stuff on this website. Can you add some translation on english please? I would appreciate it.'),
( 'Josip', 'Bošnjak', 'Napravljen unos feedbacka za stranicu. Popraviti bug koji dodaje prazno mjesto u tablicu. Napraviti neki captcha za odgodu novog unosa.'),
( 'Josip', 'Bošnjak', 'Sada treba napraviti registracijsku formu. Treba napraviti i stranicu koja omogućuje adminu da  uređuje feedbackove. Feedbackove može vidjeti samo admin.');


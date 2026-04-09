create database if not exists scn char set utf8mb4 collate utf8mb4_general_ci;
create user if not exists 'adminscn'@'localhost' identified by 'admin';
grant all privileges on scn.* to 'adminscn'@'localhost';
create user if not exists 'userscn'@'localhost' identified by 'user';
grant select,update,delete,insert on scn.* to 'userscn'@'localhost';
use scn; 
create table kvaliteta(
id int primary key auto_increment, 
fname varchar(50),
lname varchar(50),
suggestions text);
select * from kvaliteta;
alter table kvaliteta change column fname firstname varchar(50);
alter table kvaliteta change column lname lastname varchar(50);
alter table kvaliteta change column suggestions suggestion text;
create table registration (
id int primary key auto_increment,
fname varchar(50) not null,
lname varchar(50) not null,
sex char(1) not null,
dateOfBirth date not null,
cityOfBirth varchar(50) not null,
countryOfBirth varchar(50) not null,
pass varchar(50) not null,
profilepicture longblob not null);
alter table kvaliteta modify column firstname varchar(50) not null;
alter table kvaliteta modify column lastname varchar(50) not null;
alter table kvaliteta modify column suggestion text not null;
create table obavljeno(
id int primary key auto_increment,
obavljeno tinyint(1) not null);
select * from registration;
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
alter table registration add column email varchar(50) unique;
alter table registration drop column email;
alter table registration add column email varchar(50) unique not null;
alter table registration modify column profilepicture longblob null;
alter table registration drop column profilepicture;
create table profilna(
id int auto_increment primary key,
imageId tinyint(4) not null,
imageType varchar(25) not null,
imageData longblob not null);
alter table profilna modify column imageId tinyint(4) not null unique;
use test;
alter table profilna add column email varchar(50);
alter table profilna add constraint email_fk foreign key (email) references registration(email);
create table uloge(
id int primary key auto_increment,
user_id int not null,
uloga enum('Administrator','Korisnik','Banovani korisnik'),
constraint user_id_fk foreign key (user_id) references registration(id) on delete cascade on update cascade);
drop table uloge;

alter table profilna add constraint email_fk foreign key (email) references registration(email) on delete cascade on update cascade;
alter table profilna drop column imageId;
alter table profilna add column imageId varchar(50) not null unique;
select * from registration;
alter table registration modify column pass varchar(255) not null;
select r.id,r.email,u.id,u.uloga from registration r left join uloge u on r.id=u.user_id;
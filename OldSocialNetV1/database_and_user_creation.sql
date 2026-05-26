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
alter table obavljeno add column kvaliteta_id int;
alter table kvaliteta drop column kvaliteta_id;
alter table obavljeno drop constraint fk_kvaliteta_id;
alter table obavljeno add constraint fk_kvaliteta_id foreign key (kvaliteta_id) references kvaliteta(id) on update cascade on delete cascade;
select r.fname,r.lname,r.sex,r.dateOfBirth,r.cityOfBirth,r.countryOfBirth, r.email, pr.imageId,pr.imageType,pr.imageData from registration r inner join profilna pr on r.email=pr.email where pr.email='jbosnjak@mail.com';
select max(id)+1 as id from registration;
create table imagehistory(
id int auto_increment primary key,
useremail varchar(50) null,
imageId varchar(50),
imageType varchar(25),
imageData longblob,
constraint im_reg_email_fk foreign key (useremail) references registration(email) on delete cascade on update cascade);
alter table profilna modify column email varchar(50) unique;
alter table profilna modify column email varchar(50) not null unique;
create table teme(
id int primary key auto_increment,
email varchar(50) not null,
broj_teme varchar(255) unique,
naziv_teme varchar(255) unique,
constraint temail_fk foreign key (email) references registration(email) on delete cascade on update cascade);
create table komentari(
id int primary key auto_increment,
broj_teme varchar(255) not null,
datum_i_vrijeme_komentara datetime,
komentar varchar(255),
constraint broj_teme_fk foreign key (broj_teme) references teme(broj_teme) on delete cascade on update cascade); 
alter table obavljeno add column auditor_email varchar(50) not null;
alter table obavljeno add constraint aud_em_fk foreign key (auditor_email) references registration(email) on delete cascade on update cascade;
alter table komentari add column email varchar(50) not null;
alter table komentari add constraint email_kom_fk foreign key (email) references registration(email) on delete cascade on update cascade;

create table galerija(
id int primary key auto_increment,
email varchar(50) not null,
date_of_upload date not null,
type_of_gallery varchar(100) not null,
imageType varchar(25),
imageData longblob,
constraint korisnik_fk foreign key (email) references registration (email) on update cascade on delete cascade);

create database SocialNet character set utf8mb4 collate utf8mb4_unicode_ci;
use socialnet;
create table state (stateId int unsigned auto_increment primary key, name varchar(100) not null,unique(name));
create table city (
postNumber varchar(20) primary key, 
name varchar(150) not null,
stateId int unsigned not null, 
constraint stateId_fk foreign key (stateId) references state (stateId) on delete cascade on update cascade);
create table address (
addressId int unsigned primary key not null auto_increment,
street varchar(255) not null,
postNumber varchar(20) not null,
constraint postNumber_fk foreign key (postNumber) references city (postNumber) on delete cascade on update cascade);
create table profile(
userId int unsigned primary key not null auto_increment,
firstName varchar(50) not null,
lastName varchar(50) not null,
email varchar(50) not null,
sex char(1) not null,
dateOfBirth date not null,
addressId int unsigned null,
hashPassword text not null,
unique(email),
constraint addressId_fk foreign key (addressId) references address (addressId) on delete cascade on update cascade);
create table accounttype(
acTypeId int unsigned auto_increment primary key not null,
acTypeName varchar(30) not null,
listOfPrivileges text not null,
unique(acTypeName),
unique(listOfPrivileges));


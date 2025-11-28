create database SocialNet character set utf8mb4 collate utf8mb4_unicode_ci;
use socialnet;
create table state (stateId int unsigned auto_increment primary key, name varchar(100) not null,unique(name));
create table city (
postNumber varchar(20) primary key, 
name varchar(150) not null,
stateId int unsigned not null, 
constraint stateId_fk foreign key (stateId) references state (stateId) on delete cascade on update cascade);
create table address (
addressId int unsigned primary key not null,
street varchar(255) not null,
stateId int unsigned not null,
postNumber varchar(20) not null,
constraint postNumber_fk foreign key (postNumber) references city (postNumber) on delete cascade on update cascade);

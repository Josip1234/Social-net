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
create table profiledetails(
proDetId int unsigned primary key auto_increment not null,
userId int unsigned not null,
acTypeId int unsigned null,
registrationDate datetime not null,
pdUpdateDate datetime not null,
accountStatus enum('Active','Banned','Inactive'),
constraint userIdac_fk foreign key (userId) references profile (userId) on update cascade on delete cascade,
constraint acTypeId_fk foreign key (acTypeId) references accounttype (acTypeId) on delete SET NULL on update cascade); 
-- if profile is updated or deleted, update or delete also profile details
-- if type is deleted, set null, if it is updated update also here 
create table imageType(
typeId int unsigned primary key auto_increment not null,
iTypeName enum('.jpg','.jpeg','.png','.gif','.webp','.svg'),
unique(iTypeName));
create table imagedetails(
iDetailsId int unsigned primary key auto_increment not null,
typeId int unsigned not null,
imageSize varchar(15) not null,
imageDateAdded datetime not null,
imageDateUpdated datetime not null,
-- unique(typeId),
constraint typeId_fk foreign key(typeId) references imagetype (typeId) on update cascade on delete cascade);
create table image(
imageId int primary key auto_increment not null,
userId int unsigned not null,
imageName varchar(50) not null,
url text not null,
iDetailsId int unsigned not null,
unique(url),
constraint userid_imgid_fk foreign key (userId) references profile(userId) on update cascade on delete cascade,
constraint iDetailsId_fk foreign key (iDetailsId) references imagedetails (iDetailsId) on update cascade on delete cascade);



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
-- one image can have one multiple details

create table image(
imageId int unsigned primary key auto_increment not null,
userId int unsigned not null,
imageName varchar(50) not null,
url text not null,
unique(url),
constraint userid_imgid_fk foreign key (userId) references profile(userId) on update cascade on delete cascade);

-- need to update this
create table imagedetails(
iDetailsId int unsigned primary key auto_increment not null,
typeId int unsigned not null,
imageSize varchar(15) not null,
imageDateAdded datetime not null,
imageDateUpdated datetime not null,
imageId int unsigned not null,
-- unique(typeId),
constraint typeId_fk foreign key(typeId) references imagetype (typeId) on update cascade on delete cascade,
constraint imageId_fk foreign key(imageId) references image (imageId) on update cascade on delete cascade);

create table databaseUser(
userId int unsigned primary key not null auto_increment,
userName varchar(255) not null,
unique(username));

-- need to update database user table
-- need account type table to pull account type for database users
-- we will fetch acocunt type id and we will use that id 
-- to fetch type of user to validate operations with triggers 
-- and stored procedure to limit regular user cannot change 
-- anything in account type table unless he have admin rights
alter table databaseUser add column acTypeId int(10) unsigned after userName;
alter table databaseUser add constraint accountType_fk foreign key(acTypeId) references accountType(acTypeId) on update cascade on delete cascade;

create table database_logger(
dbLogId int unsigned primary key auto_increment not null,
userId int unsigned not null,
constraint user_id_fk foreign key(userId) references databaseUser(userId) on update cascade on delete cascade);

create table logger_content(
idLogCon int unsigned primary key auto_increment not null,
dbLogId int unsigned not null,
loggerDescription text not null,
userAdded varchar(255) not null,
userUpdated varchar(255) null,
userDeleted varchar(255) null,
dateDeleted datetime null,
dateUpdated datetime null,
dateAdded datetime not null,
constraint dbLogId_fk foreign key(dbLogId) references database_logger(dbLogId) on update cascade on delete cascade);

create table topics(
topicId int unsigned primary key auto_increment,
userId int unsigned not null,
topicContent text not null,
topicDateAdded datetime not null,
topicLike integer unsigned not null,
topicDislike integer unsigned not null,
topicDateUpdated datetime not null,
unique(topicContent),
constraint user_id_topics_fk foreign key(userId) references profile(userId) on update cascade on delete cascade);

create table subtopics(
subTopicsId int unsigned not null primary key auto_increment,
topicId int unsigned not null,
subTopicContent text not null,
subTopicDateAdded datetime not null,
subTopicDateUpdated datetime not null,
subtopicLike integer unsigned not null,
subtopicDislike integer unsigned not null,
unique(subTopicContent),
constraint topicId_fk foreign key (topicId) references topics(topicId) on update cascade on delete cascade);

create table comments(
commentId int unsigned not null primary key auto_increment,
commentContent text not null,
markOfOffensiveness enum('Offensive','Not offensive'),
comDateUpdated datetime not null,
comDateAdded datetime not null,
commentLike integer unsigned not null,
commentDislike integer unsigned not null);

create table procomsub(
proComSub int unsigned not null primary key auto_increment,
userId int unsigned not null,
commentId int unsigned not null,
subTopicsId int unsigned not null,
constraint userIdPcs_fk foreign key (userId) references profile(userId) on update cascade on delete cascade,
constraint commentId_fk foreign key(commentId) references comments(commentId) on update cascade on delete cascade,
constraint subtopicsid_pcs_fk foreign key (subTopicsId) references subtopics(subTopicsId) on update cascade on delete cascade);

-- there is no need for image and comment subcomment logger we already have that in image details and comments
create table profile_logger(
plId int unsigned not null primary key auto_increment,
userId int unsigned not null,
message text not null,
additionDate datetime not null,
updateDate datetime null,
deleteDate datetime null,
constraint userIdpl_fk foreign key (userId) references profile(userId) on update cascade on delete cascade);

create table image_gallery(
galleryId int unsigned not null primary key auto_increment,
galleryName varchar(50) not null,
galleryDateAdded datetime not null,
galleryDateUpdated datetime null,
unique(galleryName));

create table img_img_gal(
uniqueId int unsigned not null primary key auto_increment,
imageId int unsigned not null,
galleryId int unsigned not null,
constraint imageIdiig_fk foreign key (imageId) references image(imageId) on update cascade on delete cascade,
constraint galleryId_fk foreign key (galleryId) references image_gallery(galleryId) on update cascade on delete cascade);


-- states will be chosen from select choice 
-- real data for countries
INSERT INTO state(name) values ('Croatia'),('Italy'),('France'),('USA'),('Mexico'),('Uruguay'),('Brazil'),('Ukraine'),('Saudi Arabia');
INSERT INTO state(name) values ('Serbia'),('Montenegro'),('Bosnia and Herzegovina'),('Hungary'),('China'),('Taiwan'),('Bangladesh');
INSERT INTO state(name) values ('Australia'),('New Zeland'),('Denmark'),('United Kingdom'),('Wales'),('Germany'),('Spain');
INSERT INTO state(name) values ('Thailand'),('Portugal'),('Argentina'),('Russia'),('Venezuela'),('Colombia'),('Barbados');
INSERT INTO state(name) values ('Marocco'),('Algeria'),('South Africa'),('South Korea'),('North Korea'),('Chile');
INSERT INTO state(name) values ('Angola'),('Austria'),('Afghanistan'),('Nigeria'),('Namibia'),('Kenya');
INSERT INTO state(name) VALUES ('Qatar');
INSERT INTO state(name) VALUES ('Kosovo');
INSERT INTO state(name) VALUES ('Bosnia & Herzegovina');
INSERT INTO state(name) VALUES ('Cnd');
INSERT INTO state(name) VALUES ('Canada');
UPDATE state set name='Can' where name = 'Canada';
UPDATE state set name='Canada' where name = 'Can';
DELETE FROM state where name='North Korea';
DELETE FROM state where name='Canada';
-- cities will be inserted by text fields
insert into city values ('34000','Požega','10'),('10000','Zagreb','10'),('35000','Slavonski Brod',10);
insert into city values ('10450','Jastrebarsko','1'),('44330','Novska','1'),('47240','Slunj',1);
insert into city values ('34310','Pleternica','1'),('34311','Kuzmica','1'),('52434','Boljun',1);
insert into city values ('44213','Kratečko','1'),('34550','Pakrac','1'),('31309','Kneževi Vinogradi',1);
update city set name='Zagereb', postNumber='10001', stateId='2' WHERE postNumber='34000';
delete from city where postNumber='10001';

-- addresses will be inserted with text fields
insert into address (street,postNumber) values ('Izmišljena ulica 53','34000'),('Izmišljena ulica 25','34000'),('Izmišljena uliva 55','34000');
insert into address (street,postNumber) values ('Izmišljena ulica 54','10000'),('Izmišljena ulica 25','10450'),('Izmišljena uliva 55','44213');
update address set postNumber='34310' where postNumber='10000';
delete from address where postNumber='34310';

-- test data for profile
insert into profile (firstName,lastName,email,sex,dateOfBirth,addressId,hashPassword) VALUES ('Josip','Bošnjak','jbosnjak@mail.com','m','1992-11-05',1,sha1('pass1234'));

-- test data for profile details
insert into profiledetails (userId,acTypeId,registrationDate,pdUpdateDate,accountStatus) values (1,3,now(),date_add(current_date(), interval 1 day),'Inactive');

-- real data for accounttype
-- this one is for main admin
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('All privileges','GRANT ALL PRIVILEGES'); 
-- every other user
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('Insert and update','insert,update');
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('Read','select');
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('Read and delete','select,delete');
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('CRUD','select,insert,update,delete');
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('Update,delete','update,delete');
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('DEL','delete'),('INS','insert'),('UPD','update');
-- real data for image types
insert into imagetype (iTypeName) values ('.jpg'),('.jpeg'),('.png'),('.gif'),('.webp'),('.svg');
-- insert some data into image details
insert into imagedetails(typeId,imageSize,imageDateAdded,imageDateUpdated,imageId) values (1,'16 kb',now(),now(),1);
-- insert data to image table
insert into image(userId,imageName,url) VALUES (1,'Nova slika','www.localhost/image/image2.jpg');

insert into databaseuser(userName) VALUES ('social_admin');
insert into databaseuser(userName) VALUES ('regular');
SELECT count(*) FROM databaseuser d WHERE d.userName='social_admin';
-- we have made a triger and stored procedure to auto insert into database logger new user 
-- however this user needs to insert manually.
insert into database_logger(userId) value (2);
-- some test data for user profile
-- password is jobo
-- hash bycript password is generated online by https://bcrypt.online/
insert into profile(firstName,lastName,email,sex,dateOfBirth,addressId,hashPassword) values 
('Josip','Bošnjak','jbosnjak@mail.com','m','1992-11-05',11,'$2y$10$Yu5uppfKPS/VHf0WkcSA5uKjmsw1jMFgmANzNh5iIZoYryLtd6DhG');
update profile set firstName='Josipa', sex='f' where email='jbosnjak@mail.com';
delete from profile where email='jbosnjak@mail.com';
-- dml test data for profile details
insert into profiledetails (userId,acTypeId,registrationDate,pdUpdateDate,accountStatus) values
(6,1,now(),now(),'Inactive');
update profiledetails set accountStatus='Banned' where proDetId=2;
delete from profiledetails where proDetId=2;
-- dml test data for account type
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('social_admin','ALL PRIVILEGES'); 
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('Admin','ALL PRIVILEGES'); 
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('Regular','Create,insert,delete,select'); 
update accounttype set acTypeName='Regulars' where acTypeId=13;
delete from accounttype where acTypeId=13;
-- dml test for database user
insert into databaseuser(userName) values ('regular');
insert into databaseuser(userName) values ('social_admin');
insert into databaseuser(userName) values ('socialadmin12345');
update databaseuser set acTypeId='1' where userName='social_admin';
update databaseuser set acTypeId='2' where userName='regular';
delete from databaseuser where userName='social_admin';
-- dml test data for comments
insert into comments(commentContent,markOfOffensiveness,comDateAdded,commentLike,commentDislike) values ('Testni komentar','Not offensive',now(),0,0);
update comments set commentlike='1' where commentId=1;
delete from comments where commentId=1;
-- dml test data for image table
insert into image(userId,imageName,url) values (2,'slikica.jpg','www.google.com/slikica.jpg');
update image set imageName='new image' where imageId='1';
delete from image where imageId='1';
-- dml test data for image gallery
insert into image_gallery(galleryName,galleryDateAdded) VALUES ('new gal',now());
update image_gallery set galleryDateUpdated=now() where galleryId=1;
delete from image_gallery where galleryId=1;
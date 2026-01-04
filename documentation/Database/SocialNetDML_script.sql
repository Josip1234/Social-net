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
INSERT INTO state(name) VALUES ('Canada');
UPDATE state set name='Can' where name = 'Canada';
UPDATE state set name='Canada' where name = 'Can';

-- cities will be inserted by text fields
insert into city values ('34000','Požega','1'),('10000','Zagreb','1'),('35000','Slavonski Brod',1);
insert into city values ('10450','Jastrebarsko','1'),('44330','Novska','1'),('47240','Slunj',1);
insert into city values ('34310','Pleternica','1'),('34311','Kuzmica','1'),('52434','Boljun',1);
insert into city values ('44213','Kratečko','1'),('34550','Pakrac','1'),('31309','Kneževi Vinogradi',1);

-- addresses will be inserted with text fields
insert into address (street,postNumber) values ('Izmišljena ulica 53','34000'),('Izmišljena ulica 25','34000'),('Izmišljena uliva 55','34000');
insert into address (street,postNumber) values ('Izmišljena ulica 54','10000'),('Izmišljena ulica 25','10450'),('Izmišljena uliva 55','44213');

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
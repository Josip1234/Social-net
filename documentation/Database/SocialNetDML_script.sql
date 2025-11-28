-- states will be chosen from select choice 
INSERT INTO state(name) values ('Croatia'),('Italy'),('France'),('USA'),('Mexico'),('Uruguay'),('Brazil'),('Ukraine'),('Saudi Arabia');
INSERT INTO state(name) values ('Serbia'),('Montenegro'),('Bosnia and Herzegovina'),('Hungary'),('China'),('Taiwan'),('Bangladesh');
INSERT INTO state(name) values ('Australia'),('New Zeland'),('Denmark'),('United Kingdom'),('Wales'),('Germany'),('Spain');
INSERT INTO state(name) values ('Thailand'),('Portugal'),('Argentina'),('Russia'),('Venezuela'),('Colombia'),('Barbados');
INSERT INTO state(name) values ('Marocco'),('Algeria'),('South Africa'),('South Korea'),('North Korea'),('Chile');

-- cities will be inserted by text fields
insert into city values ('34000','Požega','1'),('10000','Zagreb','1'),('35000','Slavonski Brod',1);
insert into city values ('10450','Jastrebarsko','1'),('44330','Novska','1'),('47240','Slunj',1);
insert into city values ('34310','Pleternica','1'),('34311','Kuzmica','1'),('52434','Boljun',1);
insert into city values ('44213','Kratečko','1'),('34550','Pakrac','1'),('31309','Kneževi Vinogradi',1);

-- addresses will be inserted with text fields
insert into address (street,postNumber) values ('Izmišljena ulica 53','34000'),('Izmišljena ulica 25','34000'),('Izmišljena uliva 55','34000');
insert into address (street,postNumber) values ('Izmišljena ulica 54','10000'),('Izmišljena ulica 25','10450'),('Izmišljena uliva 55','44213');
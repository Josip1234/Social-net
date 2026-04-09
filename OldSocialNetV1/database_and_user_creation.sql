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
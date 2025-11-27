create database SocialNet character set utf8mb4 collate utf8mb4_unicode_ci;
use socialnet;
create table state (stateId int auto_increment primary key, name varchar(100) not null,unique(name));
select * from profile;
select * from profiledetails;
insert into profile(firstName,lastName,email,sex,dateOfBirth,hashPassword) 
values ('Starting','Admin','mainadmin@main.com','m','1991-01-01',sha1('mainadmin'));
update profiledetails set acTypeId=1, pdUpdateDate=now() where proDetId=1;
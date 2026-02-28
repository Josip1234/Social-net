select * from profile;
select * from profiledetails;
insert into profile(firstName,lastName,email,sex,dateOfBirth,hashPassword) 
values ('Starting','Admin','mainadmin@main.com','m','1991-01-01','$2y$10$aY5UXzxviIvBa1YPuRMFP.0oqtLlltqQmjOUlTgkROrg1kFEFP.Su');
-- mainadmin password mainadmin
update profiledetails set acTypeId=1, pdUpdateDate=now() where proDetId=2;
delete  from profile where userId=1;
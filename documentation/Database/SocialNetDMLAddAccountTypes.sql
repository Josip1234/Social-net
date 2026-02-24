insert into accounttype (acTypeName,listOfPrivileges) VALUES ('Admin','ALL PRIVILEGES'); 
insert into accounttype (acTypeName,listOfPrivileges) VALUES ('Regular','Create,insert,delete,select'); 
select * from accounttype;
select * from databaseuser;
update databaseuser set acTypeId=1 where userId=2;
update databaseuser set acTypeId=2 where userId=3;
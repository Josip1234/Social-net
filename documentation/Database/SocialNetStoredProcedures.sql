use socialnet;
-- this procedure will grant user privileges only if they exists in databaseuser table 
-- also it will grant roles depending on user name
-- if another user will be added, then this proceure also needs to be modified 
-- for if else check.
-- just in case for admin we will add posibility to create new users
-- regular user can only make crud operations
DELIMITER $$
create procedure Create_user_Or_grant_roles(in userName varchar(255))
BEGIN
    declare recordNumber int;
    declare userName2 varchar(255);
	SELECT count(*) INTO recordNumber FROM databaseuser d WHERE d.userName=userName;
    if recordNumber = 0 then
    select concat('User does not exist') as Poruka;
    else 
       SELECT d.userName INTO userName2 FROM databaseuser d WHERE d.userName=userName;
       if userName2='social_admin' then
           CREATE USER IF NOT EXISTS 'social_admin'@'localhost' IDENTIFIED BY 'rootadmin123';
           GRANT ALL PRIVILEGES ON socialnet.* TO 'social_admin'@'localhost' with grant option;
           FLUSH PRIVILEGES;
       elseif userName2='regular' then
        CREATE USER IF NOT EXISTS 'regular'@'localhost' IDENTIFIED BY 'reg';
           GRANT select,insert,update,delete ON socialnet.* TO 'regular'@'localhost';
           FLUSH PRIVILEGES;
       end if;
    end if;
END $$
DELIMITER ;
-- procerdure for saving log from user
DELIMITER $$
create procedure saveLog(in operation varchar(10), in tableName varchar(50))
BEGIN
   -- variable to store current user
     declare currentUser varchar(255);
    -- need user id first
    declare id int(10) unsigned;
    declare dbLoggerid int(10) unsigned;
    declare userType varchar(30);
   -- get current user
   select userName into currentUser from databaseuser where userName=substring_index(user(),'@',1);
   -- get uder id from current user
   select userId into id from databaseuser where userName=currentUser;
-- now we need to select logger id
SELECT dbLogId into dbLoggerid from database_logger WHERE userId=id;
select act.acTypeName into userType from accountType act  inner join databaseuser du on act.acTypeId=du.acTypeId where 
du.userName=substring_index(user(),'@',1);
if operation = 'insert' && tableName = 'state' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Logged in user has added new state',currentUser,now());
elseif operation = 'update' && tableName = 'state' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Logged in user has updated state',currentUser,now());
elseif operation = 'delete' && tableName = 'state' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Logged in user has deleted a state',currentUser,now());
elseif operation = 'insert' && tableName = 'city' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Logged in user has added new city.',currentUser,now());
elseif operation = 'update' && tableName = 'city' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Logged in user has updated a city',currentUser,now());
elseif operation = 'delete' && tableName = 'city' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Logged in user has deleted a city',currentUser,now());
elseif operation = 'insert' && tableName = 'adr' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Logged in user has added new address.',currentUser,now());
elseif operation = 'update' && tableName = 'adr' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Logged in user updated an adress.',currentUser,now());
elseif operation = 'delete' && tableName = 'adr' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Logged in user deleted an address',currentUser,now());
elseif operation = 'insert' && tableName = 'pd' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Added new profile detail.',currentUser,now());
elseif operation = 'update' && tableName = 'pd' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Updated profile detail.',currentUser,now());
elseif operation = 'delete' && tableName = 'pd' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Deleted profile detail.',currentUser,now());
elseif operation = 'insert' && tableName = 'at' && userType ='Admin' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New account type has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'at' && userType = 'Admin' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Account type has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'at' && userType = 'Admin' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Deleted account type.',currentUser,now());
end if;
END $$
DELIMITER ;

-- procedure for profile only modification of save log to database only to reference profile name as argument

DELIMITER $$
create procedure saveProfileLog(in operation varchar(10), in tableName varchar(50), in userName2 varchar(255), in oldUserName varchar(255))
BEGIN
   -- variable to store current user
     declare currentUser varchar(255);
    -- need user id first
    declare id int(10) unsigned;
    declare dbLoggerid int(10) unsigned;
   -- get current user
   select userName into currentUser from databaseuser where userName=substring_index(user(),'@',1);
   -- get uder id from current user
   select userId into id from databaseuser where userName=currentUser;
-- now we need to select logger id
SELECT dbLogId into dbLoggerid from database_logger WHERE userId=id;
if operation = 'insert' && tableName = 'profile' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,concat('New user ',userName2,' has been added'),currentUser,now());
elseif operation = 'update' && tableName = 'profile' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,concat('Username ',oldUserName,' has been updated. New value ',userName2),currentUser,now());
elseif operation = 'delete' && tableName = 'profile' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,concat('User ',userName2,' has been deleted'),currentUser,now());
end if;
END $$
DELIMITER ;


-- procedure will insert users into database logger if they do not exists
DELIMITER $$
create procedure insertUsersIntoDbLoggerIfNotExists(in userName varchar(255))
BEGIN
   -- variable to store current user
   -- declare currentUser varchar(255);
    -- need user id first
   declare id int(10) unsigned;
   -- get current user
   -- select substring_index(current_user(),'@',1) INTO currentUser;
   -- get uder id from current user
   select userId into id from databaseuser where userName=userName;
   -- if userid is not null insert into db logger current user id
   if id is not null then
      insert into database_logger(userId) value (id);
   end if;
END $$
DELIMITER ;
-- for each user logged in intop database need to insert id from that user to database logger 
call insertUsersIntoDbLoggerIfNotExists();
call saveStateLog('delete');


-- procerdure for limit use of table account type if user is not admin
-- cud operations will be limited for admin user only
-- regular user will only read information from this table
-- since we did not declare limitation with dml we will use 
-- stored procedure to limit what regular user can do and what he cannot do
-- also we will put into database logger message if regular user tries to
-- use insert update and delete 
DELIMITER $$
create procedure limitUseOfCudOperationsOnAccountTypeTable(in operation varchar(10))
BEGIN
declare typeOfUser varchar(30);
declare dbLoggerid int(10) unsigned;
    declare id int(10) unsigned;
select act.acTypeName into typeOfUser from accountType act  inner join databaseuser du on act.acTypeId=du.acTypeId where 
du.userName=substring_index(user(),'@',1);
select userId into id from databaseuser where userName=substring_index(user(),'@',1);
SELECT dbLogId into dbLoggerid from database_logger WHERE userId=id;
if operation = 'insert' && typeOfUser='Regular' && user()='regular' then
-- select concat('Regular user can only read data from this table.') as Poruka;
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Regular user can only read data from this table.',substring_index(user(),'@',1),now());
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
elseif operation = 'update' && typeOfUser='Regular' then
-- select concat('Regular user can only read data from this table.') as Poruka;
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Regular user can only read data from this table.',substring_index(user(),'@',1),now());
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
elseif operation = 'delete' && typeOfUser='Regular' then
-- select concat('Regular user can only read data from this table.') as Poruka;
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Regular user can only read data from this table.',substring_index(user(),'@',1),now());
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
end if;
END $$
DELIMITER ;





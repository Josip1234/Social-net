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
-- procedure has reached his own limit use savelog2 for futher log stuff
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
elseif operation = 'insert' && tableName = 'dbus' && userType ='Admin' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New database user has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'dbus' && userType = 'Admin' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Database user has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'dbus' && userType = 'Admin' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Deleted database user.',currentUser,now());

elseif operation = 'insert' && tableName = 'cmt' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New comment has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'cmt' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Comment has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'cmt' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Comment has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'img' then 
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New image has been uploaded.',currentUser,now());
elseif operation = 'update' && tableName = 'img' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Image has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'img' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Image has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'imgal' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New image has been added to gallery.',currentUser,now());
elseif operation = 'update' && tableName = 'imgal' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Gallery has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'imgal' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Image gallery has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'imgdet' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New image detail has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'imgdet' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Image detail has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'imgdet' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Image detail has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'imgtyp' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New image type has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'imgtyp' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Image type has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'imgtyp' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Image type has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'iig' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New image has been added to the gallery.',currentUser,now());
elseif operation = 'update' && tableName = 'iig' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Image has been replace in gallery.',currentUser,now());
elseif operation = 'delete' && tableName = 'iig' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Image has been removed from the gallery.',currentUser,now());

elseif operation = 'insert' && tableName = 'pcs' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New comment has been connected with profile comment subtopic table.',currentUser,now());
elseif operation = 'update' && tableName = 'pcs' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Comment has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'pcs' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Comment has been deleted.',currentUser,now());

elseif operation = 'insert' && tableName = 'dblog' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New user has been added to database logger.',currentUser,now());
elseif operation = 'update' && tableName = 'dblog' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'User has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'dblog' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'User has been deleted.',currentUser,now());
end if;
END $$
DELIMITER ;


DELIMITER $$
create procedure saveLog2(in operation varchar(10), in tableName varchar(50))
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
if operation = 'insert' && tableName = 'pl' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New user has been added to profile logger.',currentUser,now());
elseif operation = 'update' && tableName = 'pl' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'User has been updated from profile logger',currentUser,now());
elseif operation = 'delete' && tableName = 'pl' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'User has been deleted from profile logger.',currentUser,now());
elseif operation = 'insert' && tableName = 'st' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'New subtopic has been added.',currentUser,now());
elseif operation = 'update' && tableName = 'st' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Subtopic has been updated.',currentUser,now());
elseif operation = 'delete' && tableName = 'st' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Subtopic has been deleted.',currentUser,now());
end if;
END $$;
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
-- only work for admins need to modify this
-- will make new procedure see procedure insertUsersIntoLoggers
DELIMITER $$
create procedure insertUsersIntoDbLoggerIfNotExists(in id int(10) unsigned)
BEGIN
   -- variable to store current user
   -- declare currentUser varchar(255);
    -- need user id first
  -- declare id int(10) unsigned;insertUserIntoDatabaseLogger
   -- get current user
   -- select substring_index(current_user(),'@',1) INTO currentUser;
   -- get uder id from current user
   -- select userId into id from databaseuser where userName=userName;
   -- if userid is not null insert into db logger current user id
   if id is not null && user()='social_admin@localhost' then
      insert into database_logger(userId) value (id);
       call saveLog('insert','dbus');
	else 
    SIGNAL sqlstate '45000' 
     set message_text='User is not admin.Operation not allowed.';
   end if;
END $$
DELIMITER ;
-- for each user logged in intop database need to insert id from that user to database logger 
-- call insertUsersIntoDbLoggerIfNotExists();
-- call saveStateLog('delete');


-- procerdure for limit use of table if user is not admin
-- cud operations will be limited for admin user only
-- regular user will only read information from this table
-- since we did not declare limitation with dml we will use 
-- stored procedure to limit what regular user can do and what he cannot do
-- also we will put into database logger message if regular user tries to
-- use insert update and delete 
DELIMITER $$
create procedure limitUseOfCudOperations(in operation varchar(10))
BEGIN
declare typeOfUser varchar(30);
declare dbLoggerid int(10) unsigned;
    declare id int(10) unsigned;
select act.acTypeName into typeOfUser from accountType act  inner join databaseuser du on act.acTypeId=du.acTypeId where 
du.userName=substring_index(user(),'@',1);
select userId into id from databaseuser where userName=substring_index(user(),'@',1);
SELECT dbLogId into dbLoggerid from database_logger WHERE userId=id;
if operation = 'insert' && typeOfUser='Regular' then
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


-- procedure will insert users for databaseuser and register profile user into 
-- database logger and profile logger which depends of input parameters
-- function for inserting into database for user is functional this is not needed
-- however we will leave it here in case we need universal function 
DELIMITER $$
create procedure insertUsersIntoLoggers(in tableNameForInsert varchar(50), in userNum int(10) unsigned)
BEGIN
declare userCount int(10) unsigned;
-- to insert users with id into database logger first we need to check if user already exists
select count(userId) into userCount from database_logger where userId=userNum;
if tableNameForInsert='database_logger' then
if userCount=0 then
insert into database_logger(userId) value (userId);
else 
SIGNAL sqlstate '45000'
set message_text='User already exists in database logger. Insert operation will be aborted.';
end if;
end if;
END $$
DELIMITER ;
call insertUsersIntoLoggers('database_logger',11);






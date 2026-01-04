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
create procedure saveStateLog(in operation varchar(10))
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
if operation = 'insert' then
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Logged in user has added new state',currentUser,now());
elseif operation = 'update' then
INSERT INTO logger_content(dbLogId,loggerDescription,userUpdated,dateUpdated) VALUES (dbLoggerid,'Logged in user has updated state',currentUser,now());
elseif operation = 'delete' then
INSERT INTO logger_content(dbLogId,loggerDescription,userDeleted,dateDeleted) VALUES (dbLoggerid,'Logged in user has deleted a state',currentUser,now());
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


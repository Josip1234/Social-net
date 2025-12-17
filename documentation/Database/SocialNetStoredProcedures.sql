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



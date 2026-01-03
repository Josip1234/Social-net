-- za logiranje korisnika baze podataka u tablici state
DELIMITER $$
create trigger UserLogAfterInsertOnState after insert on state
for each row 
begin 
-- this user id will be saved to database logger
declare userId int(10);
-- current user which is logged in as database user
declare currentUser varchar(255);
-- declare id from logger
declare dbLoggerid int(10);
-- get current user strip localhost as search value 
select substring_index(current_user(),'@',1) INTO currentUser;  
-- search user in table database user return userId
select userId into userId from databaseuser where userName=currentUser;
-- insert found user id in database logger
  INSERT INTO database_logger (userId) VALUES (userId);
-- now we need to select logger id
SELECT dbLogId into dbLoggerid from database_logger WHERE userId=userId;
INSERT INTO logger_content(dbLogId,loggerDescription,userAdded,dateAdded) VALUES (dbLoggerid,'Logged in user has added new state',current_user(),now());
end $$
DELIMITER ;

drop trigger UserLogAfterInsertOnState;

-- insert into log values (concat('Kreiran novi korisnik: ',NEW.username),now(),current_user());
-- select substring_index(current_user(),'@',1) as kor_ime;
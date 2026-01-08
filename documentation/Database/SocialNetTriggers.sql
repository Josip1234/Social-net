-- za logiranje korisnika baze podataka u tablici state
DELIMITER $$
create trigger UserLogAfterInsertOnState after insert on state
for each row 
begin 
call saveLog('insert','state');
end $$
DELIMITER ;

DELIMITER $$
create trigger UserLogAfterUpdateOnState after update on state
for each row 
begin 
call saveLog('update','state');
end $$
DELIMITER ;

DELIMITER $$
create trigger UserLogAfterDeleteOnState after delete on state
for each row 
begin 
call saveLog('delete','state');
end $$
DELIMITER ;

-- triggers for logging city tables
DELIMITER $$
create trigger UserLogAfterInsertOnCity after insert on city
for each row 
begin 
call saveLog('insert','city');
end $$
DELIMITER ;

DELIMITER $$
create trigger UserLogAfterUpdateOnCity after update on city
for each row 
begin 
call saveLog('update','city');
end $$
DELIMITER ;

DELIMITER $$
create trigger UserLogAfterDeleteOnCity after delete on city
for each row 
begin 
call saveLog('delete','city');
end $$
DELIMITER ;


DELIMITER $$
create trigger insertUserIntoDatabaseLogger after insert on databaseuser
for each row 
begin 
call insertUsersIntoDbLoggerIfNotExists(new.userName);
end $$
DELIMITER ;

-- triggers for table address
DELIMITER $$
create trigger insertAdrIntoDatabaseLogger after insert on address
for each row 
begin 
call saveLog('insert','adr');
end $$
DELIMITER ;

DELIMITER $$
create trigger updateAdrIntoDatabaseLogger after update on address
for each row 
begin 
call saveLog('update','adr');
end $$
DELIMITER ;

DELIMITER $$
create trigger deleteAdrIntoDatabaseLogger after delete on address
for each row 
begin 
call saveLog('delete','adr');
end $$
DELIMITER ;

-- triggers for log user profile
DELIMITER $$
create trigger userProfileLog after insert on profile
for each row 
begin 
call saveProfileLog('insert','profile',concat(new.firstName,' ',new.lastName),null);
end $$
DELIMITER ;

DELIMITER $$
create trigger userUpdateProfileLog after update on profile
for each row 
begin 
call saveProfileLog('update','profile',concat(new.firstName,' ',new.lastName),concat(old.firstName,' ',old.lastName));
end $$
DELIMITER ;

DELIMITER $$
create trigger userDeleteProfileLog after delete on profile
for each row 
begin 
call saveProfileLog('delete','profile',concat(old.firstName,' ',old.lastName),null);
end $$
DELIMITER ;

drop trigger UserLogAfterInsertOnState;
drop trigger UserLogAfterDeleteOnState;
drop trigger UserLogAfterUpdateOnState;
drop trigger UserLogAfterInsertOnCity;
drop trigger UserLogAfterDeleteOnCity;
drop trigger UserLogAfterUpdateOnCity;
drop trigger updateAdrIntoDatabaseLogger;
drop trigger userUpdateProfileLog;
drop trigger userDeleteProfileLog;
drop trigger userProfileLog;


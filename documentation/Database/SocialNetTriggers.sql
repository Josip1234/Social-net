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

drop trigger UserLogAfterInsertOnState;
drop trigger UserLogAfterDeleteOnState;
drop trigger UserLogAfterUpdateOnState;
drop trigger UserLogAfterInsertOnCity;
drop trigger UserLogAfterDeleteOnCity;
drop trigger UserLogAfterUpdateOnCity;



-- za logiranje korisnika baze podataka u tablici state
DELIMITER $$
create trigger UserLogAfterInsertOnState after insert on state
for each row 
begin 
call saveStateLog('insert');
end $$
DELIMITER ;

DELIMITER $$
create trigger UserLogAfterUpdateOnState after update on state
for each row 
begin 
call saveStateLog('update');
end $$
DELIMITER ;

DELIMITER $$
create trigger UserLogAfterDeleteOnState after delete on state
for each row 
begin 
call saveStateLog('delete');
end $$
DELIMITER ;

drop trigger UserLogAfterInsertOnState;


-- za logiranje korisnika baze podataka u tablici state
DELIMITER $$
create trigger UserLogAfterInsertOnState after insert on state
for each row 
begin 
call saveStateLog();
end $$
DELIMITER ;

drop trigger UserLogAfterInsertOnState;

-- insert into log values (concat('Kreiran novi korisnik: ',NEW.username),now(),current_user());
-- select substring_index(current_user(),'@',1) as kor_ime;
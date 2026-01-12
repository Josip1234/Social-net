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
if user()='regular' then
SIGNAL sqlstate '45000' 
set message_text='User is not admin.Operation not allowed.';
	else
call insertUsersIntoDbLoggerIfNotExists(new.userId);
end if;
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

-- triggers for profile details table
DELIMITER $$
create trigger addedProfileDetailsLog after insert on profiledetails
for each row 
begin 
call saveLog('insert','pd');
end $$
DELIMITER ;

DELIMITER $$
create trigger updatedProfileDetailsLog after update on profiledetails
for each row 
begin 
call saveLog('update','pd');
end $$
DELIMITER ;

DELIMITER $$
create trigger deletedProfileDetailsLog after delete on profiledetails
for each row 
begin 
call saveLog('delete','pd');
end $$
DELIMITER ;

-- triggers for limiting use of account type table will be triggered before insert, update and delete
DELIMITER $$
create trigger limitAccountTypeTableBeforeInsert before insert on accounttype
for each row 
begin 
call limitUseOfCudOperationsOnAccountTypeTable('insert');
end $$
DELIMITER ;

DELIMITER $$
create trigger limitAccountTypeTableBeforeUpdate before update on accounttype
for each row 
begin 
call limitUseOfCudOperationsOnAccountTypeTable('update');
end $$
DELIMITER ;

DELIMITER $$
create trigger limitAccountTypeTableBeforeDelete before delete on accounttype
for each row 
begin 
call limitUseOfCudOperationsOnAccountTypeTable('delete');
end $$
DELIMITER ;
-- triggers for logging account type table
DELIMITER $$
create trigger insertTypeLog after insert on accounttype
for each row 
begin 
if user()='regular' then
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
else
call saveLog('insert','at');
end if;
end $$
DELIMITER ;

DELIMITER $$
create trigger updateTypeLog after update on accounttype
for each row 
begin 
if user()='regular' then
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
else
call saveLog('update','at');
end if;
end $$
DELIMITER ;

DELIMITER $$
create trigger deleteTypeLog after delete on accounttype
for each row 
begin 
if user()='regular' then
SIGNAL sqlstate '45000'
set message_text='User is not admin. Operation not allowed.';
else
call saveLog('delete','at');
end if;
end $$
DELIMITER ;

-- trigger for databaseusers logging
DELIMITER $$
create trigger dbuserInsertLog before insert on databaseuser
for each row 
begin 
if user()='regular' then
SIGNAL sqlstate '45000' 
set message_text='User is not admin.Operation not allowed.';
	else
call saveLog('insert','dbus');
end if;
end $$
DELIMITER ;

DELIMITER $$
create trigger dbuserUpdateLog after update on databaseuser
for each row 
begin 
if user()='regular' then
SIGNAL sqlstate '45000' 
set message_text='User is not admin.Operation not allowed.';
	else
call saveLog('update','dbus');
end if;
end $$
DELIMITER ;

DELIMITER $$
create trigger dbuserDeleteLog after delete on databaseuser
for each row 
begin 
if user()='regular' then
SIGNAL sqlstate '45000' 
set message_text='User is not admin.Operation not allowed.';
	else
call saveLog('delete','dbus');
end if;
end $$
DELIMITER ;
-- triggers for comments
DELIMITER $$
create trigger CommentLogAfterInsert after insert on comments
for each row 
begin 
call saveLog('insert','cmt');
end $$
DELIMITER ;

DELIMITER $$
create trigger CommentLogAfterUpdate after update on comments
for each row 
begin 
call saveLog('update','cmt');
end $$
DELIMITER ;

DELIMITER $$
create trigger CommentLogAfterDelete after delete on comments
for each row 
begin 
call saveLog('delete','cmt');
end $$
DELIMITER ;

-- triggers for table images
DELIMITER $$
create trigger ImageLogAfterInsert after insert on image
for each row 
begin 
call saveLog('insert','img');
end $$
DELIMITER ;

DELIMITER $$
create trigger ImageLogAfterUpdate after update on image
for each row 
begin 
call saveLog('update','img');
end $$
DELIMITER ;

DELIMITER $$
create trigger ImageLogAfterDelete after delete on image
for each row 
begin 
call saveLog('delete','img');
end $$
DELIMITER ;
-- triggers for image gallery
DELIMITER $$
create trigger ImageGalleryLogAfterInsert after insert on image_gallery
for each row 
begin 
call saveLog('insert','imgal');
end $$
DELIMITER ;

DELIMITER $$
create trigger ImageGalleryLogAfterUpdate after update on image_gallery
for each row 
begin 
call saveLog('update','imgal');
end $$
DELIMITER ;

DELIMITER $$
create trigger ImageGalleryLogAfterDelete after delete on image_gallery
for each row 
begin 
call saveLog('delete','imgal');
end $$
DELIMITER ;
-- triggers for image details
DELIMITER $$
create trigger ImageDetailsLogAfterInsert after insert on imagedetails
for each row 
begin 
call saveLog('insert','imgdet');
end $$
DELIMITER ;

DELIMITER $$
create trigger ImageDetailsLogAfterUpdate after update on imagedetails
for each row 
begin 
call saveLog('update','imgdet');
end $$
DELIMITER ;

DELIMITER $$
create trigger ImageDetailsLogAfterDelete after delete on imagedetails
for each row 
begin 
call saveLog('delete','imgdet');
end $$
DELIMITER ;

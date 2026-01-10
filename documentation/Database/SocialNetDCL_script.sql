-- here will be called procedure for grant roles for our database
call Create_user_Or_grant_roles('regular');
call Create_user_Or_grant_roles('social_admin');
call Create_user_Or_grant_roles('Regular'); -- message for user does not exists works
call Create_user_Or_grant_roles('Social_admin');
-- we need to revoke grants for regular user until find a solution to
-- forbid regular user to do anythign to account type table
-- only admin can do update create delete on account type
show grants for 'social_admin'@'localhost';
revoke INSERT,UPDATE,DELETE on socialnet.accounttype from 'regular'@'localhost';
GRANT ALL PRIVILEGES ON socialnet.* TO 'social_admin'@'localhost' with grant option;
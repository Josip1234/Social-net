-- here will be called procedure for grant roles for our database
call Create_user_Or_grant_roles('regular');
call Create_user_Or_grant_roles('social_admin');
call Create_user_Or_grant_roles('Regular'); -- message for user does not exists works
call Create_user_Or_grant_roles('Social_admin');
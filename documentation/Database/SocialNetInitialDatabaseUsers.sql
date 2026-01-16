 CREATE USER IF NOT EXISTS 'social_admin'@'localhost' IDENTIFIED BY 'rootadmin123';
           GRANT ALL PRIVILEGES ON socialnet.* TO 'social_admin'@'localhost' with grant option;
           FLUSH PRIVILEGES;

    CREATE USER IF NOT EXISTS 'regular'@'localhost' IDENTIFIED BY 'reg';
           GRANT select,insert,update,delete ON socialnet.* TO 'regular'@'localhost';
           FLUSH PRIVILEGES;

-- root admin with all privileges on socialnet database: username: 'social_admin'@'localhost' privileges: all 
-- (must be in database, need a procedure and/or trigger to validate admin user)
-- password for admin: rootadmin123
/*
regular user for CRUD operations on socialnet database: 'regular'@'localhost' pass reg
(also for the connection as regular user)
*/
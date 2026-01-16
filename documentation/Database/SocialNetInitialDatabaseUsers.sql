# Privileges for `regular`@`localhost`

GRANT USAGE ON *.* TO `regular`@`localhost` IDENTIFIED BY PASSWORD '*873276E5E5ED7750E7F74DCD72D93803DF4861A6';

GRANT SELECT, INSERT, UPDATE, DELETE ON `socialnet`.* TO `regular`@`localhost`;


# Privileges for `social_admin`@`localhost`

GRANT USAGE ON *.* TO `social_admin`@`localhost` IDENTIFIED BY PASSWORD '*059EF22F6B87A074483D1994D4C02BECB736EA99';

GRANT ALL PRIVILEGES ON `socialnet`.* TO `social_admin`@`localhost` WITH GRANT OPTION;

-- root admin with all privileges on socialnet database: username: 'social_admin'@'localhost' privileges: all 
-- (must be in database, need a procedure and/or trigger to validate admin user)
-- password for admin: rootadmin123
/*
regular user for CRUD operations on socialnet database: 'regular'@'localhost' pass reg
(also for the connection as regular user)
*/
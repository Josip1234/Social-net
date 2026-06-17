<?php
namespace App\Models;

use Core\Database;

class DatabaseLogger{
    /*
    select lc.idLogCon,lc.loggerDescription,lc.userAdded,lc.userUpdated,lc.userDeleted,lc.dateDeleted,lc.dateUpdated,lc.dateAdded,at.acTypeName from logger_content lc inner join database_logger dl on lc.dbLogId=dl.dbLogId
inner join databaseuser du on dl.userId=du.userId inner join accounttype at on du.acTypeId=at.acTypeId;
    */
//function to select logger content to logger content table into our view
    public static function selectLoggerContent(): array
    {   
        $db = Database::getInstance();
        $sql = "select lc.idLogCon,lc.loggerDescription,lc.userAdded,lc.userUpdated,lc.userDeleted,lc.dateDeleted,lc.dateUpdated,lc.dateAdded,at.acTypeName from logger_content lc inner join database_logger dl on lc.dbLogId=dl.dbLogId
inner join databaseuser du on dl.userId=du.userId inner join accounttype at on du.acTypeId=at.acTypeId order by lc.idLogCon asc";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }







}
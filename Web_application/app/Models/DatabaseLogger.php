<?php

namespace App\Models;

use Core\Database;

class DatabaseLogger
{
    /*
    select lc.idLogCon,lc.loggerDescription,lc.userAdded,lc.userUpdated,lc.userDeleted,lc.dateDeleted,lc.dateUpdated,lc.dateAdded,at.acTypeName from logger_content lc inner join database_logger dl on lc.dbLogId=dl.dbLogId
inner join databaseuser du on dl.userId=du.userId inner join accounttype at on du.acTypeId=at.acTypeId;
    */
    //function to select logger content to logger content table into our view
    public static function selectLoggerContent(int $limit, int $page): array
    {
        $off = ($page-1)*$limit;
        $db = Database::getInstance();
        $sql = "select lc.idLogCon,lc.loggerDescription,lc.userAdded,lc.userUpdated,lc.userDeleted,lc.dateDeleted,lc.dateUpdated,lc.dateAdded,at.acTypeName from logger_content lc inner join database_logger dl on lc.dbLogId=dl.dbLogId
inner join databaseuser du on dl.userId=du.userId inner join accounttype at on du.acTypeId=at.acTypeId order by lc.idLogCon asc LIMIT :lim OFFSET :off";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':lim'=>$limit,
            ':off'=>$off,
        ]);
        return $stmt->fetchAll();
    }


    //function to count total row for database logger
    //query for total row: select count(lc.idLogCon) as total from logger_content lc;
    public static function countRowsForDatabaseLogger():int{
        $db=Database::getInstance();
        $sql="select count(lc.idLogCon) as total from logger_content lc";
        $stmt=$db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

            //function to check how much rows we have in our data for database log with searched value
    public static function countRowsForDatabaseLoggerSearch(string $searchedValue): int
    {
          $pattern = '%' . $searchedValue . '%';
        $db = Database::getInstance();
        $sql = "select count(lc.idLogCon) as total from logger_content lc inner join database_logger dl on lc.dbLogId=dl.dbLogId
inner join databaseuser du on dl.userId=du.userId inner join accounttype at on du.acTypeId=at.acTypeId
where at.acTypeName like :pattern";
        $stmt = $db->prepare($sql);
        $stmt->execute([":pattern"=>$pattern]);
        return $stmt->fetchColumn();
    }

//function to select logger content to logger content table into our view
    public static function selectLoggerContentSearch(string $account_type, int $limit, int $page): array
    {   
       
        $off = ($page - 1) * $limit;
        $db = Database::getInstance();
        $pattern = '%' . $account_type . '%';
        $sql = "select lc.idLogCon,lc.loggerDescription,lc.userAdded,lc.userUpdated,lc.userDeleted,lc.dateDeleted,lc.dateUpdated,lc.dateAdded,at.acTypeName from logger_content lc inner join database_logger dl on lc.dbLogId=dl.dbLogId
inner join databaseuser du on dl.userId=du.userId inner join accounttype at on du.acTypeId=at.acTypeId where at.acTypeName like :pattern order by lc.idLogCon asc LIMIT :lim OFFSET :off;
";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':pattern' => $pattern,
            ':lim' => $limit,
            ':off' => $off
        ]);
   
        return $stmt->fetchAll();
    }


}

<?php

namespace App\Models;

use Core\Database;
use Carbon\Carbon;

class ProfileLogger
{
    //this function will insert data when user has logged in
    public static function log(int $userId, string $message)
    {
        $db = Database::getInstance();
        $sql = "INSERT INTO profile_logger (userId, message, additionDate) VALUES (:userId,:message,:additionDate)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':userId' => $userId,
            ':message' => $message,
            ':additionDate' => Carbon::now()
        ]);
    }
    //function for selecting last inserted id for profile logger
    public static function getLastIdFromProfileLogger(int $userId): int
    {
        $db = Database::getInstance();
        $sql = "SELECT max(pl.plId) FROM profile_logger pl where pl.userId=:userId";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':userId' => $userId
        ]);
        return $stmt->fetchColumn();
    }
    //function for update profile logger to log user logout
    public static function updateProfileLogger(int $profileLoggerId): bool
    {
        $db = Database::getInstance();
        $sql = "UPDATE profile_logger set updateDate=:updateDate where plId=:profileLoggerId";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':updateDate' => \Carbon\Carbon::now(),
            ':profileLoggerId' => $profileLoggerId,
        ]);
    }

    //function to get profile data log without pagination 
    public static function getProfileLogWithoutPagination(): array
    {
        $db = Database::getInstance();
        $sql = "SELECT pf.plId as id,concat(p.firstName,' ',p.lastName) as username,pf.message,
pf.additionDate,pf.updateDate,p.dateOfBirth, at.acTypeName, round(datediff(now(),p.dateOfBirth)/(SELECT DAYOFYEAR(
LAST_DAY(DATE_ADD(NOW(), INTERVAL 12-MONTH(NOW()) MONTH)))),0) as Age 
FROM profile_logger pf join profile p on pf.userId=p.userId
join profiledetails pd on p.userId=pd.userId join accounttype at on pd.acTypeId=at.acTypeId order by id";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    //function to get profile data log with pagination 
    public static function getProfileLogWithPagination(int $limit, int $page): array
    {
        //225 records three missing 228 should be at current rate
        $off = ($page - 1) * $limit;
        $db = Database::getInstance();
        $sql = "SELECT pf.plId as id,concat(p.firstName,' ',p.lastName) as username,pf.message,
pf.additionDate,pf.updateDate,p.dateOfBirth, at.acTypeName, round(datediff(now(),p.dateOfBirth)/(SELECT DAYOFYEAR(
LAST_DAY(DATE_ADD(NOW(), INTERVAL 12-MONTH(NOW()) MONTH)))),0) as Age 
FROM profile_logger pf join profile p on pf.userId=p.userId
join profiledetails pd on p.userId=pd.userId join accounttype at on pd.acTypeId=at.acTypeId order by id
LIMIT :lim OFFSET :off";
        $stmt = $db->prepare($sql);

        $stmt->execute([
            ':lim' => $limit,
            ':off' => $off,
        ]);

        return $stmt->fetchAll();
    }
    //function to check how much rows we have in our data for profile log
    public static function countRowsForProfileLog(): int
    {
        $db = Database::getInstance();
        $sql = "SELECT count(*) as total
FROM profile_logger pf join profile p on pf.userId=p.userId
join profiledetails pd on p.userId=pd.userId join accounttype at on pd.acTypeId=at.acTypeId";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //function for searching values without pagination (profile log search need to rename this function)
    public static function searchByUsernameWithoutPagination(string $username): array
    {
        $db = Database::getInstance();
        $pattern = '%' . $username . '%';
        $sql = "SELECT pf.plId as id,concat(p.firstName,' ',p.lastName) as username,pf.message,
pf.additionDate,pf.updateDate,p.dateOfBirth, at.acTypeName, round(datediff(now(),p.dateOfBirth)/(SELECT DAYOFYEAR(
LAST_DAY(DATE_ADD(NOW(), INTERVAL 12-MONTH(NOW()) MONTH)))),0) as Age 
FROM profile_logger pf join profile p on pf.userId=p.userId
join profiledetails pd on p.userId=pd.userId join accounttype at on pd.acTypeId=at.acTypeId 
having username like :pattern order by id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ":pattern" => $pattern
        ]);
        return $stmt->fetchAll();
    }

    //function for searching values with pagination (profile log search need to rename this function)
    public static function searchByUsernameWithPagination(string $username, int $limit, int $page): array
    {   
       
        $off = ($page - 1) * $limit;
        $db = Database::getInstance();
        $pattern = '%' . $username . '%';
        $sql = "SELECT pf.plId as id,concat(p.firstName,' ',p.lastName) as username,pf.message,
pf.additionDate,pf.updateDate,p.dateOfBirth, at.acTypeName, round(datediff(now(),p.dateOfBirth)/(SELECT DAYOFYEAR(
LAST_DAY(DATE_ADD(NOW(), INTERVAL 12-MONTH(NOW()) MONTH)))),0) as Age 
FROM profile_logger pf join profile p on pf.userId=p.userId
join profiledetails pd on p.userId=pd.userId join accounttype at on pd.acTypeId=at.acTypeId 
having username like :pattern order by id LIMIT :lim OFFSET :off";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':pattern' => $pattern,
            ':lim' => $limit,
            ':off' => $off
        ]);
        return $stmt->fetchAll();
    }


        //function to check how much rows we have in our data for profile log with searched value
    public static function countRowsForProfileLogSearch(string $searchedValue): int
    {
          $pattern = '%' . $searchedValue . '%';
        $db = Database::getInstance();
        $sql = "SELECT count(pl.plId) from profile_logger pl join profile p on pl.userId=p.userId
where concat(p.firstName,' ',p.lastName) like :pattern";
        $stmt = $db->prepare($sql);
        $stmt->execute([":pattern"=>$pattern]);
        return $stmt->fetchColumn();
    }

  


}

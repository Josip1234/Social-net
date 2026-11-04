<?php
namespace App\Models;

use Core\Database;

class Topic{
       //function for inserting new topic
    public static function insertTopic(array $data){
            
             $db = Database::getInstance();
        $sql = "INSERT INTO topics(userId,topicContent,topicDateAdded,topicLike,topicDislike,topicDateUpdated)
values (:userId,:topicContent,:topicDateAdded,:topicLike,:topicDislike,:topicDateUpdated)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':userId'=>$_SESSION['user']['id'],
            ':topicContent'=>$data["topicContent"],
            ':topicDateAdded'=>date("Y-m-d H:i:s",strtotime($data["topicDateAdded"])),
            ':topicLike'=>$data["topicLike"],
            ':topicDislike'=>$data["topicDislike"],
            ':topicDateUpdated'=>date("Y-m-d H:i:s",strtotime($data["topicDateUpdated"]))
        ]);
    }
}
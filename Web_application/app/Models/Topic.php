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
    //function for printing topics from database
    public static function printTopics():array{
        $db=Database::getInstance();
        $topics=array();
        $sql="SELECT concat(p.firstName,' ',p.lastName) as user, tp.topicId as topicNumber,tp.topicContent as topicName, tp.topicDateAdded as dateAdded, tp.topicLike as likeNumbers,tp.topicDislike as dislikeNumbers,tp.topicDateUpdated as dateUpdated FROM topics tp inner join profile p on tp.userId=p.userId"; 
        $stmt=$db->prepare($sql);
        $topics=$db->query($sql)->fetchAll();
        return $topics;
    }
}
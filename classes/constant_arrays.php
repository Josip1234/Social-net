<?php
class Cnst_array
{
    private $main;
    private $profile;
    private $privacy;
    private $forum;
    private $photos;

    public function __construct($main,  $profile,  $privacy,  $forum,  $photos)
    {
        $this->main = array("Profile","Privacy, feedbacks","Forums, chats","Photos","Homepage");
        $this->profile = array("Registration","Profile of user","Delete profile","Add profile picture","Update profile picture","Login","Logout");
        $this->privacy = array("Terms of privacy","Add feedback");
        $this->forum = array("Forum");
        $this->photos = array("Print profile history images","Photo gallery","Add to gallery");
    }
    public function getMain()
    {
        return $this->main;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function getPrivacy()
    {
        return $this->privacy;
    }

    public function getForum()
    {
        return $this->forum;
    }

    public function getPhotos()
    {
        return $this->photos;
    }
}

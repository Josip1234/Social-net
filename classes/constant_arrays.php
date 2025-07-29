<?php
class Cnst_array
{
    private $main;
    private $profile;
    private $privacy;
    private $forum;
    private $photos;
    private $php_scripts;

    public function __construct()
    {
        $this->main = array("Profile","Privacy, feedbacks","Forums, chats","Photos","Homepage");
        $this->profile = array("Registration","Profile of user","Delete profile","Add profile picture","Update profile picture","Login","Logout");
        $this->privacy = array("Terms of privacy","Add feedback");
        $this->forum = array("Forum");
        $this->photos = array("Print profile history images","Photo gallery","Add to gallery");
        $this->php_scripts=array("registration.php","profile.php","delete_profile.php","profile_picture.php","update_profile_picture.php","login.php","logout.php","privacy.php","feedback.php","forum.php","index.php","print_profile_history.php","gallery.php","add_to_gallery.php");
    }
public function getMain() {return $this->main;}

	public function getProfile() {return $this->profile;}

	public function getPrivacy() {return $this->privacy;}

	public function getForum() {return $this->forum;}

	public function getPhotos() {return $this->photos;}

	public function getPhpScripts() {return $this->php_scripts;}

	
}

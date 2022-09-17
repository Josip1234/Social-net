<?php 
class User{

public $first_name;
public $last_name;
public $email;
public $sex;
public $profile;
private $date_of_birth;
private $address;
private $password; //napravljena forma za login feb 7 2017

public function __construct($first_name,$last_name,$email,$sex,$profile,$date_of_birth,$address,$password)
{
    $this->first_name = $first_name;
    $this->last_name = $last_name;
    $this->email = $email;
    $this->sex = $sex;
    $this->profile = $profile;
    $this->date_of_birth = $date_of_birth;
    $this->address = $address;
    $this->password = $password;
}

public function __destruct()
{
    $this->first_name = "";
    $this->last_name = "";
    $this->email = "";
    $this->sex = "";
    $this->profile = "";
    $this->date_of_birth = "";
    $this->address = "";
    $this->password = "";
}





/**
 * Get the value of first_name
 */ 
public function getFirst_name()
{
return $this->first_name;
}

/**
 * Set the value of first_name
 *
 * @return  self
 */ 
public function setFirst_name($first_name)
{
$this->first_name = $first_name;

return $this;
}

/**
 * Get the value of last_name
 */ 
public function getLast_name()
{
return $this->last_name;
}

/**
 * Set the value of last_name
 *
 * @return  self
 */ 
public function setLast_name($last_name)
{
$this->last_name = $last_name;

return $this;
}

/**
 * Get the value of email
 */ 
public function getEmail()
{
return $this->email;
}

/**
 * Set the value of email
 *
 * @return  self
 */ 
public function setEmail($email)
{
$this->email = $email;

return $this;
}

/**
 * Get the value of sex
 */ 
public function getSex()
{
return $this->sex;
}

/**
 * Set the value of sex
 *
 * @return  self
 */ 
public function setSex($sex)
{
$this->sex = $sex;

return $this;
}

/**
 * Get the value of profile
 */ 
public function getProfile()
{
return $this->profile;
}

/**
 * Set the value of profile
 *
 * @return  self
 */ 
public function setProfile($profile)
{
$this->profile = $profile;

return $this;
}

/**
 * Get the value of date_of_birth
 */ 
public function getDate_of_birth()
{
return $this->date_of_birth;
}

/**
 * Set the value of date_of_birth
 *
 * @return  self
 */ 
public function setDate_of_birth($date_of_birth)
{
$this->date_of_birth = $date_of_birth;

return $this;
}

/**
 * Get the value of address
 */ 
public function getAddress()
{
return $this->address;
}

/**
 * Set the value of address
 *
 * @return  self
 */ 
public function setAddress($address)
{
$this->address = $address;

return $this;
}

/**
 * Get the value of password
 */ 
public function getPassword()
{
return $this->password;
}

/**
 * Set the value of password
 *
 * @return  self
 */ 
public function setPassword($password)
{
$this->password = $password;

return $this;
}
}


?>
<?php 
$host="localhost";
$user="root";
$pass="";
$db="social_network";

$dbc=mysqli_connect($host,$user,$pass,$db);
mysqli_set_charset($dbc,'utf8_croatian_ci');

if(!$dbc){
    die('I cannot connect to database. There is no existing database, or there is a problem with database connection');
};

?>
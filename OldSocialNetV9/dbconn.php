<?php 
$host="localhost";
$user="adminscn";
$pass="admin";
$db="scn8";

$dbc=mysqli_connect($host,$user,$pass,$db);
//mysqli_set_charset($dbc,'utf8_croatian_ci');
ini_set('display_errors',0);

if(!$dbc){
    die('I cannot connect to database. There is no existing database, or there is a problem with database connection');
};
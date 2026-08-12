<?php

$host="localhost";
$user="adminscn";
$pass="admin";
$db="scn4";

$dbc= mysqli_connect($host,$user,$pass,$db);

mysqli_set_charset($dbc,'utf8');
ini_set('display_errors',0);
if(!$dbc){
    die("I cant connect or no internet connection.");
};

?>
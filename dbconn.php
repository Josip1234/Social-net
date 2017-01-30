<?php
$host="localhost";
$user="root";
$pass="";
$db="scn";

$dbc=mysqli_connect($host,$user,$pass,$db);

mysqli_set_charset($dbc,'utf8_croatian_ci');

if(!$dbc){
	die("I cant connect or no internet connection");
};

?>
<?php
$host='localhost';
$user='adminscn';
$pass='admin';
$db='scn';


try {
    $dbc=mysqli_connect($host,$user,$pass,$db);
    mysqli_set_charset($dbc,"utf8mb4");
    ini_set('display_errors',0);
} catch (mysqli_sql_exception $ex) {
    echo $ex->getMessage();
    echo "<br>";
    echo $ex->getLine();
    die('I cannot connect to the database or there is no internet connection.');
}
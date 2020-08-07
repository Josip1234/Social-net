<?php

function checkIfUserExistsInDatabase($username,$pass){
$query="SELECT id FROM registration WHERE email='$username' AND pass='$pass'";
$q=mysqli_query($dbc,$query);
if($res=mysqli_fetch_array($q)){
	if($res==$username && $res==$pass){
	$_SESSION['username']=$username;
	$_SESSION['pass']=$pass;
	$_SESSION['loggedin']=1;
	session_start();
	}
}else{
	session_destroy();
	$SESSION['loggedin']=0;
	die('you dont exist in database. register please.');

}
function add_session($username){
	
}
}
?>
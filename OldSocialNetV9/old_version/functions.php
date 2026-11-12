<?php
function provjeri_prethodnog($fname,$lname,$suggestions){
    include("dbconn.php");
	$sql1="SELECT suggestion FROM kvaliteta WHERE id = id-1";
	mysqli_query($dbc,$sql1);
	if($suggestions==$sql1){
		$sql2="DELETE * FROM kvaliteta WHERE id=id";
		mysqli_query($dbc,$sql2);
		return 1;
	};
}

?>
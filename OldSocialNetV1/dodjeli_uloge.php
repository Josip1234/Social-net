<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>

<div class="con">
<nav>

<?php include "navigacija.php"; ?>

</nav>
</div>
<div class="pravila">
<section>
<?php
include "functions.php";
$sql="select r.id,r.email,u.id as rid,u.uloga from registration r left join uloge u on r.id=u.user_id;";
$q=mysqli_query($dbc,$sql);
echo "<table border='1'><thead><tr><th>User id</th>
	<th>User email</th>
	<th>Role id</th>
    <th>Role name</th>
	</tr></thead><tbody>";
while($row=mysqli_fetch_array($q)){
	
	echo"<tr>";
	echo"<td>{$row['id']}</td>";
	echo "<td>{$row['email']}</td>";
	echo "<td>{$row['rid']}</td>";
    echo "<td>{$row['uloga']}</td>";
	echo "</tr>";
};
echo "</tbody></table>";

?>
</section>
</div>

<div id="dodjela_uloga">
	<section>
<h2>Set the role for one user:</h2>
<form action="dodjeli_uloge.php" method="post">
<label>Email of the user which you want so set his role:</label><input type="email" autocomplete="off" name="email">
<select name="selektiraj">
<option value="Administrator">Administrator</option>
<option value="Korisnik">Korisnik</option>
<option value="Banovani korisnik">Banovani korisnik</option>
</select>
<input type="submit" value="Set_role"/>
</form>
</section>
<?php 
if($_SERVER["REQUEST_METHOD"]==="POST"){
		$email=$_POST["email"];
		$userId="SELECT r.id FROM registration r where email='$email'";
		$query=mysqli_query($dbc,$userId);
		$result=mysqli_fetch_assoc($query);
		$uId=$result["id"];
		$selektiraj=$_POST["selektiraj"];
		//check if there is a user with already assigned user role if there is update his role 
		//else insert new role
		$query="SELECT count(u.user_id) as UserRoleNum from uloge u where user_id='$uId'";
		$stmt=mysqli_query($dbc,$query);
		$res=mysqli_fetch_assoc($stmt);
		if($res["UserRoleNum"]>0){
			$sql="UPDATE uloge set uloga='$selektiraj' where user_id='$uId'";
			$stmt=mysqli_query($dbc,$sql);
			if($stmt){
				echo "Successfully updated user role.";
			}
		}else{
			$sql="INSERT INTO uloge (user_id,uloga) VALUES ('$uId','$selektiraj')";
			$stmt=mysqli_query($dbc,$sql);
			if($stmt){
				echo "Successfully added new user role.";
			}
		}

}


mysqli_close($dbc); 

?>
</div>

</body>
</html>
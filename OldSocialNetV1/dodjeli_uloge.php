
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Socialnet</title>
<?php include "functions.php"; echo cssIncludes(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php  echo jsIncludes(); ?>
</head>

<?php  echo printBodyOnMouseOverAndOnLoad(); ?>

<div class="con">
<nav>

<?php require_once "navigacija.php";
require_once "dbconn.php"; 
loggedUsersOnly();
?>

</nav>
</div>
<?php 
echo dropdownMenu();
echo printCalendar();
echo printPictures();
echo printVideos();
echo printCurrencyRate();

?>
<div class="pravila">
<section>
<?php

$sql="select r.id,r.email,u.id as rid,u.uloga from registration r left join uloge u on r.id=u.user_id;";
$q=mysqli_query($dbc,$sql);
echo "<table border='1'><thead><tr><th>ID</th>
	<th>User email</th>
    <th>Role name</th>
	</tr></thead><tbody>";
while($row=mysqli_fetch_array($q)){
	
	echo"<tr>";
	echo"<td>{$row['id']}</td>";
	echo "<td>{$row['email']}</td>";
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
	<label for="email">Select user email:</label>
	<select name="email" id="email">
		<option value="-">Select email</option>
		<?php 
		$sql="SELECT r.email from registration r";
		$res=mysqli_query($dbc,$sql);
		while($r=mysqli_fetch_array($res)):
		?>
		<option value="<?= $r["email"]; ?>"><?= $r["email"]; ?></option>
		<?php endwhile; ?>
	</select>

<select name="selektiraj">
<option value="-">Select new user role</option>
<option value="Administrator">Administrator</option>
<option value="Korisnik">Korisnik</option>
<option value="Banovani korisnik">Banovani korisnik</option>
</select>
<input type="submit" value="Set_role"/>
</form>
</section>
<?php 
if($_SERVER["REQUEST_METHOD"]==="POST"){
	$msg="Successfully updated user role.";
	$errMsg="Invalid values";
	    if($_POST["email"]==='-' || $_POST["selektiraj"]==='-'){
			echo $errMsg;
		}else{
		$email=mysqli_real_escape_string($dbc,trim(strip_tags($_POST["email"])));
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
				header('Location: dodjeli_uloge.php?msg='.$msg);
			}
		}else{
			$sql="INSERT INTO uloge (user_id,uloga) VALUES ('$uId','$selektiraj')";
			$stmt=mysqli_query($dbc,$sql);
			if($stmt){
				$msg="Successfully added new user role.";
				header('Location: dodjeli_uloge.php?msg='.$msg);
			}
		}
		}
		
}


mysqli_close($dbc); 

?>
</div>
<?php 
echo printFooter();
?>
</body>
</html>
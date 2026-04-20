<?php include "functions.php";  ?>
  <a href="feedback.php" target="_self">Feedbacks</a>
  <a href="registration.php" target="_self">Registration</a>
  <a href="login.php" target="_self">Login</a>
<a href="index.php" target="_self">Homepage</a>
<a href="logout.php" target="_self">Logout</a>
<?php 
if(isset($_SESSION["id"])){
    $array=returnAdminNavigationUrls($_SESSION["id"]);
foreach ($array as $value) {
     echo $value;
}
}


?>

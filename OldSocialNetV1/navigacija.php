<?php include "functions.php";  ?>
  <a href="feedback.php" target="_self">Feedbacks</a>

<a href="index.php" target="_self">Homepage</a>

<?php 
if(isset($_SESSION["id"])){
    $array=returnUrls($_SESSION["id"]);
    
foreach ($array as $value) {
     echo $value;
}
}else{
   echo '  <a href="registration.php" target="_self">Registration</a>
  <a href="login.php" target="_self">Login</a>';
}


?>

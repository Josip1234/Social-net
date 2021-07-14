<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}else{
	$_SESSION['login']=time();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css" type="text/css" media="all">
</head>
<body>
    <div class="con">
    <nav>
    <a href="index.html" target="_blank">Back to main page</a>
    <a href="privacy.php" target="_blank">Term of privacy</a>
    <a href="trenutnifeedback.php" target="_blank">Feedbacks-only for admins</a>
    <a href="profile.php" target="_blank">Profile of user</a>
    <a href="logout.php" target="_blank">Logout</a>
    </nav>
    </div>
    <div class="pravila">
        <section>
        <h2>
        Feedbackovi
        </h2>
        <table>
        <?php
          include('dbconn.php');
          $query="SELECT * FROM kvaliteta";
          $q=mysqli_query($dbc,$query);
          while($row=mysqli_fetch_array($q)){
              echo "<tr>";
              echo "<td>".$row['id']."&ensp;".$row['firstname']."&ensp;".$row['lastname']."&ensp;".$row['suggestion']."<br> <form action='test.php' method='post'> Obavljeno?<input type='checkbox' name='formWheelchair' value='Yes'><input type='submit' name='formSubmit' value='Posalji'></form></td>";
              
              echo"</tr>";
          }
         
          mysqli_close($dbc);
          ?>
         
        </table>
        </section>
    </div>
</body>
</html>
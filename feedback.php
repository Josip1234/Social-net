<!DOCTYPE html>
<html lang="en">
<head>
<?php 
include("dbconn.php");
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css" media="all" type="text/css">
</head>
<body>
    <div class="con">
<nav>
    <a href="#" target="_self">Registration</a>
    <a href="#" target="_self">Login</a>
    <a href="profile.php" target="_self">Profile of user</a>
    <a href="logout.php" target="_self">Logout</a>
    <a href="dodjeli_uloge.php">Set user roles</a>
</nav>
    </div>
    <div class="pravila">
<section>
    <h2>Your feedback</h2>
    <form action="feedback.php" method="post">
        <label for="fname">Your first name:</label><br>
        <input type="text" name="fname" id="fname" required autocomplete="off"><br>
        <label for="lname">Your last name:</label><br>
        <input type="text" name="lname" id="lname" required autocomplete="off"><br>
        <label for="suggestions">Suggestions of improvement</label><br>
        <textarea name="suggestions" id="suggestions" cols="30" rows="10" required></textarea> <br>
        <input type="submit" value="Send suggestion">
    </form>
    <?php 
       $fname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['fname'])));
       if($fname!=''){
        $lname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['lname'])));
        if($lname!=''){
            $suggestions=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['suggestions'])));
            if($suggestions!=''){
                  
       $query="INSERT INTO kvaliteta(firstname,lastname,suggestion) VALUES ('".$fname."','".$lname."','".$suggestions."')";
       mysqli_query($dbc,$query);
       mysqli_close($dbc);
       include("functions.php");
       if($query){
           //die("Thanks for adding some suggestions");
           header('Location:index.html');
       }else{
           die("Can't add empty informations");
           
       }
            }
        }
       }
       
       

    ?>
</section>
    </div>
</body>
</html>
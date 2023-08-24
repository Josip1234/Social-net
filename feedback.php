
<?php 
$fname="";
$lname="";
$suggestion="";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css">
</head>
<body>

    <div class="con">
        <nav>
            <ul>
                <li><a href="#" target="_blank" rel="noopener noreferrer">Registration</a></li>
                <li><a href="#" target="_blank" rel="noopener noreferrer">Login</a></li>
            </ul>
        </nav>

        <div class="rules">
<section>
    <h2>Your feedback here:</h2>
    <form action="feedback.php" method="post">
<label>Your first name:</label> <br>
<input type="text" name="fname"> <br>
<label>Your last name</label> <br>
<input type="text" name="lname"> <br>
<label>Suggestions of improvement</label> <br>
<textarea name="suggestion" id="suggestion" cols="30" rows="10"></textarea>
<input type="submit" value="Send suggestion">
    </form>
    <?php 

include("dbconn.php");
$fname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['fname'])));
$lname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['lname'])));
$suggestion=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['suggestion'])));
$query="INSERT INTO qaqc(fname,lname,suggestions) VALUES ('$fname','$lname','$suggestion')";
mysqli_query($dbc,$query);
mysqli_close($dbc);
$fname="";
$lname="";
$suggestion="";
?>
</section>
        </div>
    </div>
</body>
</html>
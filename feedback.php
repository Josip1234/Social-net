
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
<input type="text" name="fname" required autocomplete="off"> <br>
<label>Your last name</label> <br>
<input type="text" name="lname" required autocomplete="off"> <br>
<label>Suggestions of improvement</label> <br>
<textarea name="suggestion" id="suggestion" cols="30" rows="10" required></textarea>
<input type="submit" value="Send suggestion">
    </form>
    <?php 

include("dbconn.php");
include("php_scripts/php_functions/functions.php");

$validation_passes=false;
$fnamePass=false;
$lnamePass=false;
$suggestionPassed=false;

$fname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['fname'])));
$lname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['lname'])));
$suggestion=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['suggestion'])));


//check for each field if there is value if there is no value validation is not passed all three fields are required.
if($fname==''){
    $fnamePass=false;
}else{
    $fnamePass==true;
}

if($lname==''){
    $lnamePass=false;
}else{
    $lnamePass=true;
}


if($suggestion==''){
    $suggestionPassed=false;
}else{
    $suggestionPassed=true;
}

//only if all three conditions are true validation will be true
if($fnamePass==1){
        if($lnamePass==1){
            if($suggestionPassed==1){
                $validation_passes==true;
            }else{
                $validation_passes==false;
            }
        }else{
            $validation_passes==false;
        }
}else{
    $validation_passes==false;
}
//then insert data into database
if($validation_passes==true){
    //we need another query here. To check for duplicates. We need unique key for suggestions to prevent duplicate suggestions. 
    //also we need to return to user error suggestion already exists.
    $query="INSERT INTO qaqc(fname,lname,suggestions) VALUES ('$fname','$lname','$suggestion')";
    mysqli_query($dbc,$query);
    mysqli_close($dbc);
    $fname="";
$lname="";
$suggestion="";
 
}else{
    die("Information has not be inserted into our database.");
    $fname="";
    $lname="";
    $suggestion="";
}

?>
</section>
        </div>
    </div>
</body>
</html>
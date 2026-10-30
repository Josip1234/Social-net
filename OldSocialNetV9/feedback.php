
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
if($fname==""){
    $fnamePass=false;
    $validation_passes=false;
    
}else{
    $fnamePass==true;
    $validation_passes=true;

}
$validation_passes=false;

if($lname==""){
    $lnamePass=false;
    $validation_passes=false;
}else{
    $lnamePass=true;
    $validation_passes=true;
  
}
$validation_passes=false;
if($suggestion==""){
    $suggestionPassed=false;
    $validation_passes=false;
}else{
    $suggestionPassed=true;
    $validation_passes=true;
}

//works everything until here


//then insert data into database
if($validation_passes==true){
    //we need another query here. To check for duplicates. We need unique key for suggestions to prevent duplicate suggestions. 
    //also we need to return to user error suggestion already exists.
    //echo($fname);
    $query="INSERT INTO `qaqc` (`fname`, `lname`, `suggestions`) VALUES ( '".$fname."', '".$lname."', '".$suggestion."')";
    mysqli_query($dbc,$query);
    mysqli_close($dbc);
    if($query){
        header('Location:index.php');
        $fname="";
        $lname="";
        $suggestion="";
    }else{
        die("Information has not been added. There is a problem with connection.");
        $fname="";
        $lname="";
        $suggestion="";
    }

 
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
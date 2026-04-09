<?php
include "functions.php";

?>
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
<h2>Your feedback</h2>
<form action="<?=  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
<label>Your first name:</label><br/>
<input type="text" name="fname" required autocomplete="off"/><br/>
<label>Your last name:</label><br/>
<input type="text" name="lname" required autocomplete="off"/><br/>
<label>Suggestions of improvment:</label><br/>
<textarea name="suggestions" required></textarea>
<br/>
<input type="submit" value="Send suggestion"/>
</form>

<?php
if($_SERVER["REQUEST_METHOD"]==="POST"){
$msg="Cannot add empty information";
$smsg="Thanks for adding some suggestions!";
$fname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['fname'])));
if($fname!=''){
    $lname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['lname'])));
    if($lname!=''){
        $suggestions=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['suggestions'])));
        if($suggestions!=''){
                $query="INSERT INTO kvaliteta (firstname,lastname,suggestion) VALUES ('$fname','$lname','$suggestions')";
                mysqli_query($dbc,$query);
                mysqli_close($dbc);
                if($query){
                    header('Location:index.php?msg='.$smsg);
                }else{
                    echo "Error! Information not inserted.";
                }
        }else{
            echo $msg;
        }
    }else{
        echo $msg;
    }
}else{
    echo $msg;
}




}
?>


</section>
</div>



</body>
</html>
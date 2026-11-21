<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css" type="text/css" media="all">
</head>
<body>
    <div class="pravila">
    <?php
    include("dbconn.php");
if(isset($_POST['obavljeno']) && $_POST['obavljeno'] == 'Yes'){
    //echo "Dopušten je pristup.";
    $obavljeno=1;
    $user_id=1;
    $sql="INSERT INTO obavljeno (obavljeno,user_id) VALUES ($obavljeno,$user_id)";
    mysqli_query($dbc,$sql);
    echo "Table updated successfully.";
    mysqli_close($dbc);
}else{
    //echo "Nije dopušten pristup.";
    echo "Table update was not successfull";
    mysqli_close($dbc);
}
    ?>
    </div>

</body>
</html>
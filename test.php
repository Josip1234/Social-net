<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css" type="text/css" media="all">
</head>
<body>
    <?php 
    include("dbconn.php");
if(isset($_POST['formWheelchair']) && ($_POST['formWheelchair'] == 'Yes')){
    //echo "Need wheelchair access";
    $obavljeno=1;
    $user_id=4;
    $sql="INSERT INTO obavljeno(obavljeno,user_id) VALUES ($obavljeno,$user_id)";
    mysqli_query($dbc,$sql);
    echo "successfully updated table";
    mysqli_close($dbc);
}else{
    echo "Do not need Wheelchair access.";
}

    ?>
</body>
</html>
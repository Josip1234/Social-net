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
            <a href="#" target="_blank" >Registration</a>
            <a href="#" target="_blank" >Login</a>
        </nav>
    </div>
    <div class="pravila">
        <section>
            <h2>
                Update your profile picture here
            </h2>
            <?php 

if(count($_FILES)>0){
    if(is_uploaded_file($_FILES['userImage']['tmp_name'])){
        include("dbconn.php");
        $imgData=addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
        $imageProperties= getimagesize($_FILES['userImage']['tmp_name']);
        $sql="INSERT INTO profilna(imageType,imageData) VALUES ('{$imageProperties['mime']}','{$imgData}')";
        mysqli_query($dbc, $sql);
        mysqli_close($dbc);
        if($sql){
            header('Location:index.html');
        }
    }
}
            ?>
            <form name="frmImage" enctype="multipart/form-data" action="profilna.php" method="post" class="frmImageUpload">
           <label>
               Upload image file:
           </label><br>
           <input type="file" name="userImage" class="inputFile"> 
           <input type="submit" value="Submit" class="btnSubmit">
        </form>
        </section>
    </div>
</body>
</html>
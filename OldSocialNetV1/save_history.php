

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
<script src="socialnet.js"></script>
<script src="calendar.js"></script>
</head>

<?php include "functions.php"; echo printBodyOnMouseOver(); ?>
    <div class="con">
        <nav>
          <?php include "navigacija.php"; ?>

        </nav>

    </div>
    <?php echo printCalendar(); ?>
    <div class="pravila">
       
        <?php

if(isset($_SESSION["imageType"]) && isset($_SESSION["imageData"]) && isset($_SESSION["imageId"])){
       $uploadedFile=$_SESSION["file"];
       //$_FILES['userImage2']['tmp_name']
      //print_r(addslashes(file_get_contents($uploadedFile);
      //var_dump(addslashes(file_get_contents($uploadedFile[$_FILES['userImage2']['tmp_name']])));
   
	$imageType=$_SESSION["imageType"];
	$imageData=$_SESSION["imageData"];
    
    $username=$_SESSION["username"];

   
   


}else{
    unsetImageSessions();
	header("Location: updateprofilne.php");
}


?>
        <?php
echo '<img src="data:'.$imageType.';base64,'.base64_encode( $imageData ).'"/> ';
?>
          <?php 
          if($_SERVER["REQUEST_METHOD"]==="POST"){

            if(isset($_SESSION["odgovor"]) && isset($_GET["save"])){
                if($_GET["save"]==="save"){
                     $imageId=$_SESSION["imageId"];
                       $imgData=$_SESSION["file"]["imgData"];
	                    $imageProperties=$_SESSION["file"]["imgProp"];



                         unset($_SESSION["file"]["imgData"]);
                        unset($_SESSION["file"]["imgProp"]);
                    
                   // $ima =addslashes(file_get_contents($_FILES[$imageData][$imageType]));
                   // $imag = getimageSize($_FILES[$imageData][$imageType]);
                    //$imageD=base64_encode($imageData);
                    //$imagP=$imageType; 
                    //{$imageProperties['mime']}', '{$imgData}'
                    $sql="INSERT INTO imagehistory(useremail,imageId,imageType,imageData) VALUES ('$username','$imageId','{$imageProperties['mime']}', '{$imgData}')";
                    mysqli_query($dbc,$sql);
                    mysqli_close($dbc);



                    unset($_SESSION["odgovor"]);
                    unsetImageSessions();
                    
                  
                }
                
            }

            if(isset($_POST["odgovor"])){
               $odgovor=$_POST["odgovor"]; 
            }else{
                $odgovor="";
            }
            
            if($odgovor==="yes" || isset($_SESSION["odgovor"])){
                	$_SESSION["odgovor"]=$odgovor;

            }
          }
          
          
          ?>
<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])."?save=save" ?>" method="post">
    <input type="submit" value="Insert into history"/>
  </form>
 
    </div>
    <?php 
echo printFooter();
?>
</body>
</html>
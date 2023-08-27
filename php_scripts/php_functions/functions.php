<?php 

   function check_previous($fname,$lname,$suggestion){
    include("../../dbconn.php");
    $sql1="SELECT suggestions FROM qaqc WHERE id=id-1";
    mysqli_query($dbc,$sql1);
    if($suggestion==$sql1){
        $sql2="DELETE * FROM qaqc WHERE id=id";
        mysqli_query($dbc,$sql2);
        return 1;
    }else{
        return 0;
    }
   }

?>
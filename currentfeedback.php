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
            <a href="#" target="_blank" rel="noopener noreferrer">Registratiom</a>
            <a href="#" target="_blank" rel="noopener noreferrer">Login</a>
        </nav>
        <div class="rules">
<section>
    <h2>Feedbacks</h2>
    <table>
        <?php 
           include("dbconn.php");
           $query="SELECT fname,lname,suggestions FROM qaqc";
           $q=mysqli_query($dbc,$query);
           while($row=mysqli_fetch_array($q)){
            echo "<tr>";
            echo "<td>".$row['fname']." ".$row['lname']." ".$row['suggestions']."</td>";
            echo "</tr>";
           }
           mysqli_close($dbc);
        ?>
    </table>
</section>
        </div>

    </div>
</body>
</html>
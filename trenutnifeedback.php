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
    <a href="#" target="_blank">Registration</a>
    <a href="#" target="_blank">Login</a>
    </nav>
    </div>
    <div class="pravila">
        <section>
        <h2>
        Feedbackovi
        </h2>
        <table>
        <?php
          include('dbconn.php');
          $query="SELECT firstname,lastname,suggestion FROM kvaliteta";
          $q=mysqli_query($dbc,$query);
          while($row=mysqli_fetch_array($q)){
              echo "<tr>";
              echo "<td>".$row['firstname']."&ensp;".$row['lastname']."&ensp;".$row['suggestion']."</td>";
              echo"</tr>";
          }
          mysqli_close($dbc);
          ?>
        </table>
        </section>
    </div>
</body>
</html>
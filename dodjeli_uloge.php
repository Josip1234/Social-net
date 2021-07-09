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
    <a href="registration.php" target="_blank">Registration</a>
    <a href="login.php" target="_blank">Login</a>
</nav>        
    </div>
<div class="pravila">
<section>
              <?php 
                include("dbconn.php");
                $sql="SELECT id, fname, lname, sex, dateofbirth, cityofbirth, countryofbirth, pass, email FROM registration";
                $result=mysqli_query($dbc,$sql);
                while($res=mysqli_fetch_array($result)){
                    echo $res['id']."<br>";
                    echo $res['fname']."<br>";
                    echo $res['lname']."<br>";
                    echo $res['sex']."<br>";
                    echo $res['dateofbirth']."<br>";
                    echo $res['cityofbirth']."<br>";
                    echo $res['countryofbirth']."<br>";
                    echo $res['pass']."<br>";
                    echo $res['email']."<br><br>";
                    mysqli_close($dbc);

                }
              ?>
</section>
</div>
    <div id="dodjela_uloga">
    <section>
        <h2>Dodjeli ulogu:</h2>
        <form action="dodjeli_uloge.php" method="post">
        <label>Email korisnika za kojeg želiš dodjeliti ulogu:</label>
        <input type="email" name="email" autocomplete="off">
        <select name="selektiraj">
           <option value="Administrator">Administrator</option>
           <option value="Korisnik">Korisnik</option>
           <option value="Banovani korisnik">Banovani korisnik</option>            
        </select>
        <input type="submit" value="Set_role">
        </form>
    </section> 
    </div>
</body>
</html>
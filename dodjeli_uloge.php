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
                $sql="SELECT `registration`.`id`, `registration`.`email`, `uloge`.`id`, `uloge`.`user_id`, `uloge`.`uloga`
                FROM `registration`
                LEFT JOIN `uloge` ON `registration`.`id` = `uloge`.`user_id`";
              ?>
          </section>
    </div>
</body>
</html>
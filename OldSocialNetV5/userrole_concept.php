<?php 
$username="jbosnjak3@gmail.com";
$default_role="User";
$roles=array("Administrator","Anonymous");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User roles</title>
</head>
<body>
    <section>
          <p>Default username under the name: <?php echo $username ?> is <?php echo $default_role ?>
          Other available user roles are: <?php 
              echo $roles[0]." and ".$roles[1].".";
          
          ?> User could have multiple userroles if administrator permits it.</p>

<form action="userrole_concept.php" method="post">
<label for="select_user">Select username:</label>
<select name="username" id="username">
<option value="jbosnjak3@gmail.com">jbosnjak3@gmail.com</option>
<option value="mmarkovic@gmail.com">mmarkovic@gmail.com</option>
<option value="mmagda@gmail.com">mmagda@gmail.com</option>
</select>
<br>
<label for="role">Choose user role:</label><br>
<input type="checkbox" name="default_role"  value="'<?php echo $default_role  ?>'">
<label for="default_role"><?php echo $default_role  ?></label>
<input type="checkbox" name="default_role"  value="'<?php echo $roles[0]  ?>'">
<label for="default_role"><?php echo $roles[0]  ?></label>
<input type="checkbox" name="default_role"  value="'<?php echo $roles[1]  ?>'">
<label for="default_role"><?php echo $roles[1]  ?></label>
<br>
<input type="submit" value="Change default user role">
</form>
    </section>
</body>
</html>
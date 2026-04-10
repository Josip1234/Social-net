<main>
        <div class="form-box">
   
  
        <h2>User registration</h2>
        <form method="post" action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=users/edit');?>">
                   

         

            <?php if(isset($_POST)): ?>
            <label for="fname">First name:</label>
            <input type="text" name="firstName" id="fname" value="<?= isset($_POST["lname"])?$_POST["lname"]:$profil["firstName"] ?>">
                
            <label for="lname">Last name:</label>
            <input type="text" name="lastName" id="lname" value="<?= isset($_POST["lname"])?$_POST["lname"]:$profil["lastName"]; ?>">
            
            <label for="email">Email address:</label>
            <input type="email" name="email" id="email" value="<?= isset($_POST["email"])?$_POST["email"]:$profil["email"]; ?>">
            
            <label for="sex1">Sex:</label>
            <span class="radio">
    
            <input type="radio" name="sex" id="sex1" value="m" <?php if(isset($_POST["sex"])&& $_POST["sex"]==="m") echo "checked"; else if($profil['sex']==='m') echo "checked"; ?>>Male
            <input type="radio" name="sex" id="sex2" value="f" <?php if(isset($_POST["sex"]) && $_POST["sex"]==="f") echo "checked"; else if($profil['sex']==='f') echo "checked"; ?>>Female
     
            <label for="dbirth">Date of birth</label>
            <input type="date" name="dateOfBirth" id="dbirth" value="<?= isset($_POST["dbirth"])?$_POST["dbirth"]:$profil["dateOfBirth"]; ?>" max="999-12-31">
      
            <input type="hidden" name="userId" value="<?= $profil['userId']; ?>">
            <input type="submit" value="Update profile">
            <button type="reset">Reset entry</button>
            <?php endif; ?>
        </form>
      
    </div>
</main>
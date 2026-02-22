<main>

    <div class="form-box">
        <?php if(isset($max) && ($max===1)): ?>
          <form action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=setAdmin');?>" method="post">
            <label for="userId">Current user id:</label>
            <input type="number" name="userId" id="userId" value="<?= $max; ?>" readonly>
            <label for="regDate">Current registration date:</label>
            <input type="date" name="regDate" id="regDate" value="<?= $regDate; ?>" readonly>
            <label for="accTypeId">Promjena uloge korisnika</label>
            <select name="accTypeId" id="accTypeId">
                <option value="">Select user option</option>
                <?php    
                  
                    foreach ($types as $type):
                      ?>
                      
                     <option value="<?=$type["acTypeId"]; ?>"
                     <?= $userType===$type["acTypeId"]?:"selected"; ?>> <?= $type["acTypeName"]; ?></option>
                   
                      
                
                
                <?php endforeach; ?>
            </select>
            <button type="submit">Promijeni ulogu korisnika</button>
          </form>
          <?php else: ?>
        <h2>User registration</h2>
        <form method="post" action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=register');?>">
            <?php if(isset($_POST)): ?>
            <label for="fname">First name:</label>
            <input type="text" name="fname" id="fname" value="<?= $_POST["fname"]; ?>">
            <?php if(isset($errors["fn"])): ?>
            <span class="error"> <?= $errors["fn"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["fnn"])): ?>
            <span class="error"> <?=  $errors["fnn"]; ?></span>
            <?php endif; ?>
            <label for="lname">Last name:</label>
            <input type="text" name="lname" id="lname" value="<?= $_POST["lname"] ?>">
            
               <?php if(isset($errors["ln"])): ?>
            <span class="error"> <?= $errors["ln"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["lnn"])): ?>
            <span class="error"> <?=  $errors["lnn"]; ?></span>
            <?php endif; ?>




            <label for="email">Email address:</label>
            <input type="email" name="email" id="email" value="<?= $_POST["email"] ?>">
            
                 <?php if(isset($errors["em"])): ?>
            <span class="error"> <?= $errors["em"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["ism"])): ?>
            <span class="error"> <?=  $errors["ism"]; ?></span>
            <?php endif; ?>






            <label for="sex1">Sex:</label>
            <span class="radio">
              
            <input type="radio" name="sex" id="sex1" value="m" <?php if($_POST["sex"]==="m") echo "checked"; ?>>Male
            <input type="radio" name="sex" id="sex2" value="f" <?php if($_POST["sex"]==="f") echo "checked"; ?>>Female
            
                      <?php if(isset($errors["sx"])): ?>
            <span class="error"> <?= $errors["sx"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["sxv"])): ?>
            <span class="error"> <?=  $errors["sxv"]; ?></span>
            <?php endif; ?>



            </span>
     
            <label for="dbirth">Date of birth</label>
            <input type="date" name="dbirth" id="dbirth" value="<?= $_POST["dbirth"]; ?>" max="999-12-31">
                      <?php if(isset($errors["db"])): ?>
            <span class="error"> <?= $errors["db"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["dtb"])): ?>
            <span class="error"> <?=  $errors["dtb"]; ?></span>
            <?php endif; ?>
            
                <?php if(isset( $errors["yva"])): ?>
            <span class="error"> <?=  $errors["yva"]; ?></span>
            <?php endif; ?>

              <?php if(isset( $errors["yvc"])): ?>
            <span class="error"> <?=  $errors["yvc"]; ?></span>
            <?php endif; ?>
          
        
             <p id="pi"> <b>Input address?</b></p>
            <input type="checkbox" id="ia" onclick="showForm()">
          
       
            <div class="disabled" id="form">
                <label for="city">Insert city</label>
                <input type="text" name="city" id="city">
                 <span class="error">Errors for city</span>
                <label for="state">Add new state</label>
                <input type="text" name="state" id="state">
                 <span class="error">Errors for state</span>
                <label for="address">Add new address</label>
                <input type="text" name="address" id="address">
                 <span class="error">Errors for address</span>
            </div>
            <label for="hp">Input password</label>
            <input type="password" name="hp" id="hp">
                       <?php if(isset($errors["ps"])): ?>
            <span class="error"> <?= $errors["ps"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["pl"])): ?>
            <span class="error"> <?=  $errors["pl"]; ?></span>
            <?php endif; ?>

            <input type="hidden" name="registrationDate" value="<?= \Carbon\Carbon::now()->format("Y-m-d H:m:s"); ?>">
            <span id="hidden" class="disabled"></span>
            <input type="hidden" name="regValidation" value="validate">
            <input type="submit" value="Register">
            <button type="reset">Reset entry</button>
            <?php endif; ?>
        </form>
        <?php endif; ?>
    </div>
</main>
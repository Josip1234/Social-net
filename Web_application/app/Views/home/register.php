<main>
    <div class="form-box">
        <h2>User registration</h2>
        <form method="post" action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=register');?>">
            <label for="fname">First name:</label>
            <input type="text" name="fname" id="fname">
            <?php if(isset($errors["fn"])): ?>
            <span class="error"> <?= $errors["fn"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["fnn"])): ?>
            <span class="error"> <?=  $errors["fnn"]; ?></span>
            <?php endif; ?>
            <label for="lname">Last name:</label>
            <input type="text" name="lname" id="lname">
            
               <?php if(isset($errors["ln"])): ?>
            <span class="error"> <?= $errors["ln"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["lnn"])): ?>
            <span class="error"> <?=  $errors["lnn"]; ?></span>
            <?php endif; ?>




            <label for="email">Email address:</label>
            <input type="email" name="email" id="email">
            
                 <?php if(isset($errors["em"])): ?>
            <span class="error"> <?= $errors["em"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["ism"])): ?>
            <span class="error"> <?=  $errors["ism"]; ?></span>
            <?php endif; ?>






            <label for="sex1">Sex:</label>
            <span class="radio">
            <input type="radio" name="sex" id="sex1" value="m" >Male
            <input type="radio" name="sex" id="sex2" value="f">Female
            
                      <?php if(isset($errors["sx"])): ?>
            <span class="error"> <?= $errors["sx"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["sxv"])): ?>
            <span class="error"> <?=  $errors["sxv"]; ?></span>
            <?php endif; ?>



            </span>
     
            <label for="dbirth">Date of birth</label>
            <input type="date" name="dbirth" id="dbirth">
                      <?php if(isset($errors["db"])): ?>
            <span class="error"> <?= $errors["db"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["dtb"])): ?>
            <span class="error"> <?=  $errors["dtb"]; ?></span>
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
            <input type="hp" name="hp" id="hp">
                       <?php if(isset($errors["ps"])): ?>
            <span class="error"> <?= $errors["ps"]; ?></span>
            <?php endif; ?>
              <?php if(isset( $errors["pl"])): ?>
            <span class="error"> <?=  $errors["pl"]; ?></span>
            <?php endif; ?>

            <input type="hidden" name="registrationDate" value="<?= \Carbon\Carbon::now()->format("Y-m-d"); ?>">
            <span id="hidden" class="disabled"></span>
            <input type="hidden" name="regValidation" value="validate">
            <input type="submit" value="Register">
        </form>
    </div>
</main>
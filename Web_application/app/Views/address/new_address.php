<main>
     <div class="form-box">
          <a href="?page=address/new_state" class='updateInformations' target="_blank">Insert new state</a>
        <a href="?page=city" class='updateInformations' target="_blank">Insert new city</a>
  
        <form method="post" action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=storeAddress');?>" >
            <label for="state">Select your state:</label>
            <select name="state" id="state" onchange="showSelected()">
                <option value="-">--Select state--</option>
                <?php 
                foreach ($states as $state): 
                $selected=($state["stateId"]==$address["stateId"])?'selected':"";
                ?>
                <option value="<?= $state["stateId"]; ?>"
                
                <?= $selected; ?>><?= $state["name"]; ?></option>
                <?php endforeach; 
  
                ?>
            </select>
              
            <label for="city">Select your city:</label>
            <select name="city" id="city" >
                <option value="-">--Select city--</option>
                <?php 
                if(isset($_COOKIE["selected"])):
                   
                foreach ($cities as $city):
                    $selectedC=($city["postNumber"]===$address["postNumber"])?'selected':"";
                    echo $selectedC;
                ?>
                <option value="<?= $city["postNumber"]; ?>" <?= $selectedC; ?> ><?= $city["name"]; ?></option>
                <?php 
                
                endforeach;
           
                endif;
                ?>
            </select>
              <?php if(isset($errors["empty"])): ?>
                        <span class="error"> <?= $errors["empty"]; ?></span>
                      <?php endif; ?>
            
                          <?php if(isset($errors["num"])): ?>
                        <span class="error"> <?= $errors["num"]; ?></span>
                      <?php endif; ?>

            <label for="address">Insert address:</label>
            <input type="text" name="address" id="address" value="<?= (!empty($address))?$address["street"]:""; ?>">

             <?php if(isset($errors["len"])): ?>
                        <span class="error"> <?= $errors["len"]; ?></span>
                      <?php endif; ?>

            <button type="submit">Save</button>
            <button type="reset">Reset entry</button>
        </form>
      
      </div>
</main>
<main>
      <div class="form-box">
          <a href="?page=address/new_state" class='updateInformations'>Insert new state</a>
        <a href="?page=city" class='updateInformations'>Insert new city</a>
        <a href="?page=address/insert" class='updateInformations'>Insert new address</a>
       
           <?php if(isset($_GET["select"])):?>
             <form action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=address/update&selected=1');?>" method="post">
                       <label for="state">Select or change state:</label>
            <select name="state" id="state">
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
            <button type="submit">Select state</button>
             <button type="reset">Reset entry</button>
             </form>
            <?php endif; ?>
           
             <?php if(isset($_GET["selected"])):?>
                 
             <form action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=address/update&city=1');?>" method="post">
             
             
                <label for="city">Select or change selection city:</label>
            <select name="city" id="city" >
                <option value="-">--Select city--</option>
                <?php 
              
                   
                foreach ($cities as $city):
                    $selectedC=($city["postNumber"]===$address["postNumber"])?'selected':"";
                    echo $selectedC;
                ?>
                <option value="<?= $city["postNumber"]; ?>" <?= $selectedC; ?> ><?= $city["name"]; ?></option>
                <?php 
                
                endforeach;
           
              
                ?>
            </select>
                
                 <button type="submit">Select city</button>
             <button type="reset">Reset entry</button>


                                 </form>
             <?php endif; ?>

        
              <?php if(isset($_GET["city"])):?>
                    <form action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=address/update&add=1');?>" method="post">
                                                <label for="address">Select current address:</label>
            <select name="address" id="address" >
              
                <?php 
              
                   
                foreach ($add as $ad):
                          $selectedAd=($ad["addressId"]===$address["addressId"])?'selected':"";
                          $id=$ad["addressId"]; 
                          $val=$ad["street"];
                          
                ?>
                     <option value="<?= $id ?>" <?= $selectedAd ?>><?= $val ?></option>
                <?php 
                
                endforeach;
           
              
                ?>
            </select>
                    <button type="submit">Update profile address</button>
             <button type="reset">Reset entry</button>
                    </form>
             <?php endif;?>
      
      </div>
</main>
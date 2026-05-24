<main>
      <div class="form-box">
          <a href="?page=address/new_state" class='updateInformations' target="_blank">Insert new state</a>
        <a href="?page=city" class='updateInformations' target="_blank">Insert new city</a>
        <a href="?page=address/insert" class='updateInformations' target="_blank">Insert new address</a>

          <?php if(isset($_SESSION['msg'])): ?>
     <div class="message">
          <p class="success"><?= $_SESSION['msg']; ?></p>
     </div>
     <?php endif; unset($_SESSION['msg']);?>
       
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
                                                <label for="address">Change current address:</label>
            <select name="address_id" id="address_id" >
              
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
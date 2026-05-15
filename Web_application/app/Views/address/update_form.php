<main>
      <div class="form-box">
          <a href="?page=address/new_state" class='updateInformations'>Insert new state</a>
        <a href="?page=city" class='updateInformations'>Insert new city</a>
  
        <form action="" method="post">
            <label for="state">Select or change selection of state:</label>
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
            <label for="city">Select or change selection city:</label>
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
            <label for="address">Insert or update new address:</label>
            <input type="text" name="address" id="address" value="<?= (!empty($address))?$address["street"]:""; ?>">
            <button type="submit">Save</button>
            <button type="reset">Reset entry</button>
        </form>
      
      </div>
</main>
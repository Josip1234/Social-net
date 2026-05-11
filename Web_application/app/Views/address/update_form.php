<main>
      <div class="form-box">
          <a href="?page=address/new_state" class='updateInformations'>Insert new state</a>
        <a href="?page=city" class='updateInformations'>Insert new city</a>
        
        <form action="" method="post">
            <label for="state">Select state:</label>
            <select name="state" id="state" onchange="showSelected()">
                <option value="-">--Select state--</option>
                <?php 
                foreach ($states as $state):
                ?>
                <option value="<?= $state["stateId"]; ?>"><?= $state["name"]; ?></option>
                <?php endforeach; 
  
                ?>
            </select>
            <label for="city">Select city:</label>
            <select name="city" id="city">
                <option value="-">--Select city--</option>
                <?php 
                if(isset($_COOKIE["selected"])):
                   
                foreach ($cities as $city):
                ?>
                <option value="<?= $city["postNumber"]; ?>"><?= $city["name"]; ?></option>
                <?php 
                
                endforeach;
           
                endif;
                ?>
            </select>
            <label for="address">Insert new address:</label>
            <input type="text" name="address" id="address">
            <button type="submit">Save</button>
            <button type="reset">Reset entry</button>
        </form>
      
      </div>
</main>
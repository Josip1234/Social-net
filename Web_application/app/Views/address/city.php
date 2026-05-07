<main>
   
    <div class="form-box">
            <?php if(isset($_SESSION['msg'])): ?>
     <div class="message">
          <p class="success"><?= $_SESSION['msg']; ?></p>
     </div>
     <?php endif; unset($_SESSION['msg']);?>
         <?php if(isset($_POST["addCity"]) && ($_POST["addCity"]==1)): ?>
              <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Post Number</th>
                        <th>City name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index=0;foreach($cities as $city): $index++;?> 
                        <tr>
                            <td><?= $index; ?></td>
                            <td><?= $city['postNumber']; ?></td>
                            <td><?= $city['name']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
              </table>
         <?php endif; ?>
         <form method="post" action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=city');?>" >
             <?php if(!isset($_POST["addCity"]) || ($_POST["addCity"]!=1)): ?>
             <select name="state" id="state">
        <option value="-">--Select state--</option>
    <?php 
    foreach ($states as $state):
    ?>
   
        <option value="<?= $state["stateId"] ?>"><?= $state["name"] ?></option>
  
    <?php endforeach; ?>
      </select>
            <input type="hidden" name="addCity" value="1">
              <?php endif;  ?>
               <?php if(isset($_POST["addCity"]) && ($_POST["addCity"]==1)): ?>
                  <label for="postNumber">Insert new postNumber</label>
                  <input type="number" name="postNumber" id="postNumber" min='1'>
                  <label for="name">Insert new city name</label>
                  <input type="text" name="name" id="name">
                      <input type="hidden" name="dbCity" value="1">
                      <input type="hidden" name="stateId" value="<?= $stateId; ?>">
                    <?php endif;  ?>
            <button type="submit">Save</button>
            <button type="reset">Reset entry</button>
          
      </form>
             
    </div>

</main>
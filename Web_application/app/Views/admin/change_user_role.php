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
             <?php endif; ?>
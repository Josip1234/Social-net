<main>
    <div id="container">
        <div class="form-box">
  
             <h2>User account status change</h2>
        <form method="post" action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=admin/update_account_status');?>">
            <label for="userId">User id</label>
            <input type="text" class="readonly" name="userId" id="userId" value="<?= (isset($_GET["id"]) && is_numeric($_GET["id"]) && ($_GET["id"]!=0) && ($_GET["id"]>0))?$_GET["id"]:header("Location: index.php?page=admin/user_management"); ?>" readonly>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="readonly" value="<?= $username; ?>" readonly> 
            <label for="accountStatus">Select new account status</label>
            <select name="accountStatus" id="accountStatus">
                <option value="Active" <?php if($acStatus=="Active") echo "selected"; ?>>Active</option>
                <option value="Banned" <?php if($acStatus=="Banned") echo "selected"; ?>>Banned</option>
                <option value="Inactive" <?php if($acStatus=="Inactive") echo "selected"; ?>>Inactive</option>
            </select>
            <label for="accountType">Account types:</label>
            <select name="accountType" id="accountType">
                <?php
                $selected="selected"; 
                foreach ($acTypes as $value):
                 
                ?>
                <option value="<?= $value['acTypeId'] ?>"
                <?php    if($value['acTypeId']==$acTypeId) echo $selected; ?>
                ><?= $value['acTypeName'] ?></option>
                <?php endforeach; ?>
            </select>
                  <input type="submit" value="Update">
            <button type="reset">Reset entry</button>
        </form>
        </div>
    </div>
</main>
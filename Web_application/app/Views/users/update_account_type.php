<main>
    <div class="form-box">
        <h2>Update account type</h2>
        
        <form action="" method="post">
            <label for="acTypeId">Choose new type of user account:</label>
            <select name="acTypeId" id="acTypeId">
                <?php foreach ($account_type as $at):?>
                <option value="<?= $at["acTypeId"]; ?>"
                <?php if($role===$at["acTypeId"]) echo 'selected'; ?>
                ><?= $at["acTypeName"]; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="proDetId" value="<?= $id; ?>">
              <input type="submit" value="Update">
            <button type="reset">Reset entry</button>
        </form>
    </div>
</main>
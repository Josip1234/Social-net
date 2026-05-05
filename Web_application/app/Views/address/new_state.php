<main>
      <div class="form-box">  
      <?php if(isset($_SESSION['msg'])): ?>
     <div class="message">
          <p class="success"><?= $_SESSION['msg']; ?></p>
     </div>
     <?php endif; unset($_SESSION['msg']);?>
            <form method="post" action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=insertNewState');?>" >
                <label for="name">Insert new state</label>
                <input type="text" name="name" id="name" value="<?= isset($_POST["name"])?$_POST["name"]:"" ?>">
                 <?php if(isset($errors["max"])): ?>
            <span class="error"> <?= $errors["max"]; ?></span>
            <?php endif; ?>
                <?php if(isset($errors["min"])): ?>
            <span class="error"> <?= $errors["min"]; ?></span>
            <?php endif; ?>
                <?php if(isset($errors["exists"])): ?>
            <span class="error"> <?= $errors["exists"]; ?></span>
            <?php endif; ?>
                 <?php if(isset($errors["empty"])): ?>
            <span class="error"> <?= $errors["empty"]; ?></span>
            <?php endif; ?>
            <input type="submit" value="Insert new state">
            <button type="reset">Reset entry</button>
            </form>
      </div>
</main>
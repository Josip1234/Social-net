<main>
    <div id="container">
           <div class="form-box">  
 
            <form method="post" action="<?=  htmlspecialchars($_SERVER["PHP_SELF"].'?page=topic/insertNewTopic');?>" >
                <label for="name">Insert new topic</label>
             <input type="text" name="topicContent" id="topicContent" value="<?= isset($_POST["topicContent"])?$_POST["topicContent"]:"" ?>">
                 <?php if(isset($errors["topicContent"])): ?>
            <span class="error"> <?= $errors["topicContent"]; ?></span>  

          
            <?php endif; ?>

                     <?php if(isset( $errors["numeric"])): ?>
            <span class="error"> <?= $errors["numeric"]; ?></span> 
            <?php endif; ?>

             <?php if(isset( $errors["charNumbers"])): ?>
            <span class="error"> <?= $errors["charNumbers"]; ?></span> 
            <?php endif; ?>

             <label for="topicDateAdded">Current date and time of topic addition</label>
            <input type="datetime" name="topicDateAdded" id="topicDateAdded" value="<?php echo date("d.m.Y H:i:s") ?>"  readonly>
            
            <label for="topicLike">Default topic likes:</label>
             <input type="number" name="topicLike" id="topicLike" value="0" readonly>

                 
            <label for="topicLike">Default topic dislikes:</label>
             <input type="number" name="topicDislike" id="topicDislike" value="0" readonly>
 

            <label for="topicDateUpdated">Date of topic update</label>
            <input type="datetime" name="topicDateUpdated" id="topicDateUpdated" value="<?php echo date("d.m.Y H:i:s") ?>"  readonly>
            

            <input type="submit" value="Insert new topic">
            <button type="reset">Reset entry</button>
            </form>
      </div>
    </div>
</main>
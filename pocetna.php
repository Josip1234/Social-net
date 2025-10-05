<?php  include "zaglavlje.php"; ?>
    <div id="sadrzaj">
            <?php include "navigacija.php"; ?>
             <?php 
              (isset($_GET["akcija"]))?(($_GET["akcija"]==="prijava")?ispisiFormuZaPrijavu():""):"";
             
             
             ?>
    </div>
<?php include "podnozje.php"; ?>
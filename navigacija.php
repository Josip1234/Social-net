<?php if(!isset($_SESSION["user"])): ?>
<?= "<div id='navigacija' class='neprijavljen'>
    <ul>
        
        <li><a href='?akcija=prijava'>Prijava</a></li>
        <li><a href='?akcija=registracija'>Registracija</a></li>
    </ul>
</div>";
?>
<?php endif;?>
<?php if(isset($_SESSION["user"])): ?>
<?= "<div id='navigacija' class='prijavljen'>
    <ul>
        <li><a href='?akcija=odjava'>Odjava</a></li>
    </ul>
</div>";
?>
<?php endif;?>
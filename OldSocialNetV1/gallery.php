<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Social net old first version</title>
<?php include "functions.php"; echo cssIncludes(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php  echo jsIncludes(); ?>
</head>

<?php  echo printBodyOnMouseOverAndOnLoadForGallery() ?>
    <div class="con">
        <nav>
          <?php include "navigacija.php"; ?>
        </nav>

    </div>
    <?php
    echo dropdownMenu();
    echo printCalendar();
echo printPictures();
echo printVideos();
echo printCurrencyRate();
?>
    <div class="pravila">

    <section><h2>Picture Gallery</h2>
<div id="slika">

	
</div>

</section>

    </div>
    <?php 
echo printFooter();
echo printGalleryNav();
?>
</body>
</html>
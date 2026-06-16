<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Social net old first version</title>
<?php include "functions.php"; loggedUsersOnly(); echo cssIncludes(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php  echo jsIncludes(); ?>
</head>

<?php  echo printBodyOnMouseOverAndOnLoad(); ?>
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
      <section>
<h2>Ovdje počinje forum</h2>
<div id="tema">
    <?php  include("ispis_tema.php") ?>
	<h2>Ovdje idu teme</h2>
</div>
<div id="podtema">
<h2>Forum</h2>
<div id="profil">
    <h3>Lijevo treba biti slika profila i ime</h3>
	<div id="odgovori">
		<h4>Desno treba biti odgovor</h4>
	</div>
</div>
</div>
</section>

    </div>
    <?php 
echo printFooter();
?>
</body>
</html>
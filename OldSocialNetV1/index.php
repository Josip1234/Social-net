<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Social net old first version</title>
<link rel="stylesheet" href="css/stil.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="socialnet.js"></script>
<script src="calendar.js"></script>
</head>

<?php include "functions.php"; echo printBodyOnMouseOver(); ?>
    <div class="con">
        <nav>
          <?php include "navigacija.php"; ?>
        </nav>

    </div>
    <?php echo printCalendar(); ?>
    <div class="pravila">
        <section>
            <h2>Privacy rules</h2>
            <p>Your data will be protected. Any unauthorised use of your data from our employees will be prosecuted by the law of our country. Do not use passwords if you are already use in your other emails, or site logins. Always use password not less than 8 bites and use at least 1 number and 1 small and 1 big letter. To accept our rules of privacy, visit <a id="privatnost" href="privacy.php" target="_blank">privacy </a> and check if you are agree. Other information will be here also.</p>
        </section>

    </div>
    <?php 
echo printFooter();
?>
</body>
</html>
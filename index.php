<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css">
</head>-->
<?php 
include("classes/header_html.php");
//ispiši konstante iz header_html skripte koja sadrži header i title klasu
echo Header::START_HTML;
echo Header::HTML_LANG;
echo Header::OPEN_HEADER;
echo Header::META_CHARSET;
echo Header::VIEWPORT;
//stvori novi naslov 
$title=new Title("Socialnet");
//ispiši naslov
$title->printTitle();
echo Header::MAIN_CSS;
echo Header::CLOSE_HEADER;
?>
<body>
    <div class="con">
        <nav>
            <ul>
                <li><a href="#" target="_blank" rel="noopener noreferrer">Registration</a></li>
                <li><a href="#" target="_blank" rel="noopener noreferrer">Login</a></li>
            </ul>
        </nav>

        <div class="rules">
            <section>
                <h2>Privacy rules</h2>
                <p>
                    We guarantee the protection of your data. If there is any violation of data integrity or if your data is stolen, we are responsible for it if it happens on the server. If the user is at fault, we disclaim responsibility and shift the responsibility to the user. For more detailed information, visit this link:
                    <a id="privacy" href="privacy.php" target="_blank" rel="noopener noreferrer">Privacy</a>
                </p>
            </section>

        </div>

    </div>

</body>
</html>
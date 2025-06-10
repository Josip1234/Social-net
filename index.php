<?php 
include("classes/header_html.php");
include("classes/body_html.php");
include("classes/headings.php");
include("classes/paragraph.php");
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
echo Body::OPEN_BODY;
echo Body::OPEN_CONTAINER;
echo Body::OPEN_NAV;
echo Body::OPEN_UL;
echo Body::OPEN_LI;
echo Body::REGISTRATION_URL;
echo Body::CLOSE_LI;
echo Body::OPEN_LI;
echo Body::LOGIN_URL;
echo Body::CLOSE_LI;
echo Body::CLOSE_UL;
echo Body::CLOSE_NAV;
echo Body::OPEN_RULES_DIV;
echo Body::OPEN_SECTION;
$heading=new Heading("Privacy rules");
echo $heading->print_h2();
$par=new Paragraph('We guarantee the protection of your data. If there is any violation of data integrity or if your data is stolen, we are responsible for it if it happens on the server. If the user is at fault, we disclaim responsibility and shift the responsibility to the user. For more detailed information, visit this link: <a id="privacy" href="privacy.php" target="_self" rel="noopener noreferrer">Privacy</a>');
echo $par->print_paragraphs_values();
echo Body::CLOSE_SECTION;
echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;
echo Body::CLOSE_BODY;
echo Body::CLOSE_HTML_DOCUMENT;
?>
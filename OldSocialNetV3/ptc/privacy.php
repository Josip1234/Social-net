<?php

namespace Privacy;

require_once "../classes/Nav.php";
require_once "../classes/Header.php";
require_once "../classes/Lists.php";
require_once "../classes/Division.php";
require_once "../classes/Body.php";
require_once "../classes/Footer.php";
require_once "../classes/Links.php";
require_once "../classes/Section.php";
require_once "../classes/Headings.php";
require_once "../classes/Paragraph.php";

use Classes\Division;
use Classes\Footer;
use Classes\Header;
use Classes\Headings;
use Classes\Lists;
use Classes\Links;
use Classes\Nav;
use Classes\Section;
use Classes\Paragraph;

$header = new Header("hr", "", "Socialnet", basename(__DIR__ . "/" . __FILE__, ".php"), []);
$footer = new Footer();
$divClasses = array();
$listItems = array();
$urlItems = array("Registration", "Login", "Homepage");
$urlScripts = array("registration.php", "login.php", "../index.php");
$urls = new Links($urlScripts, $urlItems, "__blank");
$urls = $urls->returnUrls();

foreach ($urls as $val) {

    $listItems[] = $val;
}

$divClasses[] = "con";

$division = new Division($divClasses);
$rules = new Division(["rules"]);

$lists = new Lists($listItems);

$scripts = "../js/social.js,../style/style.css";
$setScripts = false;
$setScripts = $header->setIncludeScripts($scripts);

$nav = new Nav($lists->createUnorderedList());

$additionalDivs = array();
$additionalDivs[] = $rules;

$sections = array();
$heading1 = new Headings("Privacy rules");
$first_h2 = $heading1->returnHeading(2);

$heading2 = new Headings("Basic rules of use this site");
$second_h2 = $heading2->returnHeading(2);


$paragraph = new Paragraph("Your data will be protected. 
       Any unauthorised use of your 
       data from our employees will 
       be prosecuted by the country 
       law . Do not use 
       passwords if you are 
       already use in your other
        emails, or site logins. 
        Always use password not 
        less than 8 bites 
        and use at least 1 number 
        and 1 small and 1 big letter.");

$p = $paragraph->returnParagraph();
$sections[] = $first_h2 . $p;

$orderedListItems = array();
$orderedListItems[] = "When you are register and login into the site,
     you are agreeing to give us your sensitive data like 
     username, email, password.";

$orderedListItems[] = "We are not responsible if you give some other person your password, 
    and if that results that that person is misusing our site ,
     you will still be banned for our site, 
     your serial will be blacklisted and you wont be able to register again.";

$orderedListItems[] = "Serial presents email. 
    If you make new registration from new device or email, 
    and you still misusing our site, you will be prosecuted by law.";

$orderedList = new Lists($orderedListItems);

$sections[] = $second_h2 . $orderedList->createOrderedList();

if ($setScripts == 1) {
    $header->generateHtmlHeader();
    $footer->closeBodyAndHtml($division, $lists, $nav, $additionalDivs, $sections);
}

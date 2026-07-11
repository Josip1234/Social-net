<?php
namespace Index;
require_once "classes/Header.php";
require_once "classes/Lists.php";
require_once "classes/Division.php";
require_once "classes/Body.php";
require_once "classes/Footer.php";
require_once "classes/Links.php";

use Classes\Division;
use Classes\Footer;
use Classes\Header;
use Classes\Lists;
use Classes\Links;


$header = new Header("hr","","Socialnet",basename(__DIR__."/".__FILE__,".php"),[]);
$footer=new Footer();
$divClasses=array();
$listItems=array();
$urlItems=array("#","#");
$urlScripts=array("Registration","Login");
$urls=new Links($urlItems,$urlScripts,"__blank");
$urls=$urls->returnUrls();

foreach ($urls as $val) {
    
    $listItems[]=$val;
}

$divClasses[]="con";

$division=new Division($divClasses);
$lists=new Lists("UNORDERED LIST",$listItems);

$scripts="js/social.js,style/style.css";
$setScripts=false;
$setScripts=$header->setIncludeScripts($scripts);

if($setScripts==1){
    $header->generateHtmlHeader(); 
    $footer->closeBodyAndHtml($division,$lists);
}



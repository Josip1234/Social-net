<?php
namespace Index;
require_once "classes/Header.php";

use Classes\Header;

$header = new Header("hr","","Socialnet",basename(__DIR__."/".__FILE__,".php"),[]);


$scripts="js/social.js,style/style.css";
$setScripts=false;
$setScripts=$header->setIncludeScripts($scripts);

if($setScripts==1){
    $header->generateHtmlHeader(); 
}



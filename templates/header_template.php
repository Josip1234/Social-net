<?php 
function create_header_template($url){  
  include("classes/url_constants.php");
  if($url==Url_constant::INDEX){
include("classes/header_html.php");
include("classes/body_html.php");
include("classes/headings.php");
include("classes/paragraph.php");
include("classes/css_js_includes.php");
include("classes/dbconn.php");
include("classes/files_and_directories.php");
include("classes/scan_data.php");
include("classes/random_js_structure.php");
include("navigation_template.php");

  }else if($url==Url_constant::VALUTA){
    include("classes/header_html.php");
include("classes/css_js_includes.php");
include("classes/body_html.php");
include("classes/headings.php");
include("templates/table_template.php");
include("templates/forms_templates.php");
include("classes/paragraph.php");

  }
echo Header::START_HTML;
echo Header::HTML_LANG;
echo Header::OPEN_HEADER;
echo Header::META_CHARSET;
echo Header::VIEWPORT;
if($url==Url_constant::INDEX){
//stvori novi naslov 
$title=new Title("Socialnet");
//ispiši naslov
$title->printTitle();
//echo Header::MAIN_CSS;
echo Styles::CUSTOM_COLOR_AND_BORDERS_CSS;
echo Styles::CUSTOM_MARGIN_PADDING_CSS;
echo Styles::CALENDAR_JS;
echo Styles::GALERIJA_JS;
echo Styles::MAIN_CSS;
echo Styles::DATE_JS;
echo Styles::BOOTSTRAP_BUNDLE;
echo Styles::BOOTSTRAP_CSS;
echo Styles::BOOTSTRAP_MIN_JS;
echo Styles::BOOTSTRAP_POPPER;
echo Header::CLOSE_HEADER;
}else if($url==Url_constant::VALUTA){
  $title=new Title("Valute");
$title->printTitle();
echo Styles::CURRENCY_JS;
echo Styles::CURRENCY_CSS;
echo Header::CLOSE_HEADER;
}







}

?>
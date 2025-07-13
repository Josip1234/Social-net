<?php 
include("classes/header_html.php");
include("classes/body_html.php");
include("classes/headings.php");
include("classes/paragraph.php");
include("classes/css_js_includes.php");
include("classes/dbconn.php");
include("classes/files_and_directories.php");
include("classes/scan_data.php");
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
//echo Header::MAIN_CSS;
echo Styles::BOOTSTRAP_BUNDLE;
echo Styles::BOOTSTRAP_CSS;
echo Styles::BOOTSTRAP_MIN_JS;
echo Styles::BOOTSTRAP_POPPER;
echo Styles::CUSTOM_COLOR_AND_BORDERS_CSS;
echo Styles::CUSTOM_MARGIN_PADDING_CSS;
echo Styles::CALENDAR_JS;
echo Styles::CURRENCY_JS;
echo Styles::GALERIJA_JS;
echo Styles::MAIN_CSS;
echo Styles::DATE_JS;
echo Header::CLOSE_HEADER;
echo Body::OPEN_BODY_ONLOAD_CALENDAR_AND_RANDOM_PICTURES;
echo Body::OPEN_CONTAINER;
echo Body::OPEN_BOOTSTRAP_DIV_ROW_CUSTOMISED;
echo Body::OPEN_BOOTSTRAP_DIV_COLUMN_CUSTOM_MARGIN;
echo Body::OPEN_NAV_CUSTOMISED;
echo Body::OPEN_HORIZONTAL_UL;
echo Body::OPEN_LIST_GROUP_ITEM;
echo Body::REGISTRATION_URL;
echo Body::CLOSE_LI;
echo Body::OPEN_LIST_GROUP_ITEM;
echo Body::LOGIN_URL;
echo Body::CLOSE_LI;
echo Body::CLOSE_UL;
echo Body::CLOSE_NAV;
echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;
echo Body::OPEN_BOOTSTRAP_DIV_ROW;
echo Body::OPEN_BOOTSTRAP_DIV_COLUMN;
echo Body::OPEN_DIV_CALENDAR;
//need some heading here
$heading=new Heading("");
echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;
echo Body::OPEN_BOOTSTRAP_DIV_COLUMN;
echo Body::OPEN_RULES_DIV;
echo Body::OPEN_SECTION;
$heading->setH2("Privacy rules");
$heading->print_h2();
$par=new Paragraph('We guarantee the protection of your data. If there is any violation of data integrity or if your data is stolen, we are responsible for it if it happens on the server. If the user is at fault, we disclaim responsibility and shift the responsibility to the user. For more detailed information, visit this link: <a id="privacy" href="privacy.php" target="_self" rel="noopener noreferrer">Privacy</a>');
echo $par->print_paragraphs_values();
echo Body::CLOSE_SECTION;
echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;
echo Body::OPEN_BOOTSTRAP_DIV_ROW;
echo Body::OPEN_BOOTSTRAP_DIV_COLUMN;
echo Body::OPEN_SECTION_CLASS_RANDSLIKE;
$heading=new Heading("Random slike");
$heading->print_h2();
echo Paragraph::P_WITH_ID_S;
echo Paragraph::CLOSE_P;
echo Body::CLOSE_SECTION;
echo Body::CLOSE_DIV;
echo Body::OPEN_BOOTSTRAP_DIV_COLUMN;

//--------------------------------------------------------------------------------------------------------------------//
//connect to databse
$database_connection=new DatabaseConnection("localhost","root","","scn","utf8");
$database_connection->connectToDatabase();
$result=array();
$heading=new Heading("Neki drugi sadržaj");
echo $heading->print_h2();
//scan files
//need an array of data what to print from database
$data_to_print=array();
$data_to_print[]="relativni_put";
$result=$database_connection->print_all_data_from_database("file_directory_for_scan",$data_to_print);

$files_in_directories="";
//loop trough array of directories
foreach ($result as $value) {
    $files=new File_Directory($value);
    //add scanned files to array of results
    $files_in_directories.=$files->scan_files_in_directory();
}
//we got returning string we need to separate it by ,
//we will use explode
$fil_dir_array=array();
//this is the list of url-s from scanned directories from database
$fil_dir_array=explode(",",$files_in_directories);

//insert values for scanned urls into database
$scanned_data=new Scanned_data("");
$scanned_data->insert_scanned_data_into_database($database_connection,$fil_dir_array);


$database_connection->close_database();
//--------------------------------------------------------------------------------------------------------------------//

echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;
echo Body::CLOSE_BODY;
echo Body::CLOSE_HTML_DOCUMENT;
?>
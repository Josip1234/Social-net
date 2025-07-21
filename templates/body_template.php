<?php 

function create_body_template($url){
    
//----------------------------------------------------------
    if($url==Url_constant::INDEX){
        echo Body::OPEN_BODY_ONLOAD_CALENDAR_AND_RANDOM_PICTURES_AND_DATE;
echo Body::OPEN_CONTAINER;
create_navigation_template(Url_constant::INDEX);

echo Body::CLOSE_DIV;
echo Body::OPEN_BOOTSTRAP_DIV_ROW;
echo Body::OPEN_BOOTSTRAP_DIV_COLUMN;
echo Body::OPEN_DIV_CALENDAR;
echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;
       echo Body::OPEN_BOOTSTRAP_DIV_COLUMN;
echo Body::OPEN_RULES_DIV;
echo Body::OPEN_SECTION;
//need some heading here
$heading=new Heading("");
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
//------------------------------------------------------------
if($url==Url_constant::INDEX){
    //ispiši konstante iz header_html skripte koja sadrži header i title klasu
echo Body::OPEN_BOOTSTRAP_DIV_COLUMN;
//--------------------------------------------------------------------------------------------------------------------//
//connect to databse
$database_connection=new DatabaseConnection("localhost","root","","scn","utf8");
$database_connection->connectToDatabase();
$result=array();
$heading=new Heading("Slike");
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
//filer empty values
$fil_dir_array = array_filter($fil_dir_array);
//insert values for scanned urls into database
$scanned_data=new Scanned_data("");
$images=array();
$scanned_data->insert_scanned_data_into_database($database_connection,$fil_dir_array);
$images=$scanned_data->return_list_of_images_from_database($database_connection);
//convert list of image array to real images
$image = new Image("","","","img__size");
$new_images=array();
$new_images=$image->convert_urls_to_images($images);

$random_js=new Randomjs($new_images);
$random_js->save_images_to_random_js(Image::ROOT_URL,"js_scripts/random.js");
//--------------------------------------------------------------------------------------------------------------------//
echo Body::OPEN_BOOTSTRAP_DIV_ROW;
//we assume all of id does not have break 
//we need to add a fix if there is some id break 
//to generate another number
$rec_num=array();
$rec_num[]=$database_connection->get_num_of_records_from_table(Scanned_data::TABLE_NAME);
$image_array=array();
$image_array=$image->get_nth_number_of_random_images_from_database(3,$database_connection,$rec_num);
//print filtered array
foreach ($image_array as $value) {
    echo Body::OPEN_BOOTSTRAP_DIV_COLUMN;
    echo $value;
    echo Body::CLOSE_DIV;
}
echo Body::CLOSE_DIV;
$scanned_data->maintainDatabase($database_connection);
$database_connection->close_database();
}
//--------------------------------------------------------------------------------------------------------------------//
echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;

echo Body::OPEN_BOOTSTRAP_DIV_ROW;
echo Body::OPEN_BOOTSTRAP_DIV_COLUMN;
echo Body::OPEN_SECTION_WITH_ID_VALUT;
$heading->setH2("Currencies");
$heading->print_h2();
echo Body::IFRAME_WITH_VALUTA_DOCUMENT;
echo Body::CLOSE_SECTION;
echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;
echo Body::CLOSE_DIV;

echo Body::OPEN_FOOTER;
echo Paragraph::P_WITH_ID_DATUM;
echo Paragraph::CLOSE_P;
echo Body::CLOSE_FOOTER;
echo Body::CLOSE_BODY;
echo Body::CLOSE_HTML_DOCUMENT;
    }else if($url==Url_constant::VALUTA){
        echo Body::OPEN_BODY;
echo Body::OPEN_CONTAINER_WITH_ID_CN;
$heading=new Heading("Credit bank");
$heading->print_h2();
echo Body::OPEN_SECTION_WITH_ID_LISTE;
$heading->setH2("Odaberi vrijednost:");
$heading->print_h2();
$th_data=array("Valuta","Kupovni","Srednji","Prodajni");
$td_data=array("CHF","5.642","5.861","6.061","EUR","7.156","7.258","7.356","USD","4.326","4.586","4.698");
$table=new Table("table table-striped",$th_data,$td_data,3);
$table->print_table();
echo Body::CLOSE_SECTION;
echo Body::OPEN_DIV_WITH_ID_INPUT;
echo Form::OPEN_SELECT_WITH_ONCHANGE_EVENT;
echo Form::OPEN_EMPTY_OPTION_WITH_ID;
$new_id_value=new Form("","Select","");
echo $new_id_value->getOptionValue();
echo Form::CLOSE_OPTION;
$currencies=array("CHF","EUR","USD");
$form=new Form("","",$currencies);
$form->print_option_values_only_with_id_s();
echo FORM::CLOSE_SELECT;
echo Paragraph::P_WITH_ID_TXT;
echo Paragraph::CLOSE_P;
    }
}

?>
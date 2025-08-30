<?php 

 function create_navigation_template($url){
    echo Body::OPEN_BOOTSTRAP_DIV_ROW_CUSTOMISED;
echo Body::OPEN_BOOTSTRAP_DIV_COLUMN_CUSTOM_MARGIN;
echo Body::OPEN_NAV_CUSTOMISED;
echo Body::OPEN_HORIZONTAL_UL;
echo Body::OPEN_LI_CLASS_RED;
echo Body::REGISTRATION_URL;
echo Body::CLOSE_LI;
echo Body::OPEN_LI_CLASS_RED;
echo Body::LOGIN_URL;
echo Body::CLOSE_LI;
echo Body::CLOSE_UL;
echo Body::CLOSE_NAV;
echo Body::CLOSE_DIV;
 }

 function create_navigation_template_from_database($url,$dbconn,$table_name,$what_data_to_print){
    //need data from database first
    $navigation_items=array();
    $navigation_items=$dbconn->print_all_data_from_database($table_name,$what_data_to_print);
           echo "<div class='row red border border-0 rounded-pill'><div class='col nmarginnav'>
        <nav class='red border border-0 rounded-pill p-2'>
        <ul class='list-group list-group-horizontal'>";
    foreach ($navigation_items as $value) {
        if($value!="BUTTON" && $value!=null){
            echo  "<li class='red'><a href='#' target='_self' rel='noopener noreferrer' class='text-decoration-none text-white'>".$value."</a></li>";
        }   
     }
    echo "</ul></nav></div></div>";

 }


?>
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


?>